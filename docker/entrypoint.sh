#!/bin/bash
set -e

# Vérifier si le groupe existe déjà, sinon le créer
if ! getent group ${GID} > /dev/null; then
  groupadd -g ${GID} containergroup
fi

# Vérifier si l'utilisateur existe déjà, sinon le créer
if ! getent passwd ${UID} > /dev/null; then
  useradd -m -u ${UID} -g ${GID} containeruser

  # adapter les permission pour le nouvel user
  mkdir -p /var/lib/mysql /srv/http/clipbucket /run/mysqld /var/lib/nginx && \
  chown -R containeruser:containergroup /var/lib/mysql /srv/http/clipbucket /run/mysqld /usr/lib/mysql
fi

# Fonction pour terminer correctement les processus enfants
terminate_processes() {
    echo "Terminating processes..."
    kill -TERM "$mariadb_pid" "$php_pid" "$nginx_pid" 2>/dev/null
    wait "$mariadb_pid" "$php_pid" "$nginx_pid"
    echo "All processes terminated."
    exit 1
}

# Capturer les signaux pour arrêter proprement les processus
trap terminate_processes SIGTERM SIGINT

# Vérifier si mysql a deja était installé
if [ ! -d "/var/lib/mysql/clipbucket" ]; then
    echo "install mariadb ..."
    mariadb-install-db --user=containeruser --basedir=/usr --datadir=/var/lib/mysql || true
else
    echo "mariadb already installed."
fi

# Démarrer MariaDB
echo "Starting MariaDB..."
mariadbd --user=containeruser --datadir=/var/lib/mysql &
mariadb_pid=$!

sleep 5

# Vérifier si la base de données existe
if [ ! -d "/var/lib/mysql/clipbucket" ]; then
    echo "Init database..."
    mysql -uroot -e "CREATE DATABASE clipbucket;"
    mysql -uroot -e "CREATE USER 'clipbucket'@'localhost' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';"
    mysql -uroot -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost';"
    mysql -uroot -e "FLUSH PRIVILEGES;"
else
    echo "Database already exists. No init required."
fi

# Démarrer PHP-FPM
echo "Starting PHP-FPM..."
php-fpm8.2 -F --fpm-config /etc/php/8.2/fpm/php-fpm.conf --nodaemonize &
php_pid=$!

# Vérifier si les sources existent
if [ ! "$(ls -A /srv/http/clipbucket)" ]; then
    echo "Init sources..."
    mkdir -p /srv/http/clipbucket && \
    git clone https://github.com/MacWarrior/clipbucket-v5.git /srv/http/clipbucket && \
    git config --global core.fileMode false && \
    git config --global --add safe.directory /srv/http/clipbucket && \
    chown www-data: -R /srv/http/clipbucket && \
    chmod 755 -R /srv/http/clipbucket
else
    echo "Sources already exist. No init required."
fi

# Démarrer Nginx en mode foreground
echo "Starting Nginx..."
nginx -g "daemon off;" &
nginx_pid=$!

# Surveiller les processus et détecter les arrêts
while true; do
    if ! kill -0 "$mariadb_pid" 2>/dev/null; then
        echo "MariaDB process has exited. Exiting script..."
        terminate_processes
    fi

    if ! kill -0 "$php_pid" 2>/dev/null; then
        echo "PHP-FPM process has exited. Exiting script..."
        terminate_processes
    fi

    if ! kill -0 "$nginx_pid" 2>/dev/null; then
        echo "Nginx process has exited. Exiting script..."
        terminate_processes
    fi

    sleep 2
done
