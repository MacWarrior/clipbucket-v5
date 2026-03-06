#!/bin/bash
set -e

# Définir la version PHP par défaut si non spécifiée
PHP_VERSION="${PHP_VERSION:-8.4}"

echo "========================================="
echo "ClipBucket v5 Docker Container"
echo "PHP Version: ${PHP_VERSION}"
echo "========================================="

if [ "${UID}" = "0" ]; then
    USER_NAME=root
else
    USER_NAME=containeruser

    if ! getent group ${GID} > /dev/null; then
      groupadd -g ${GID} ${USER_NAME}
    fi

    if ! getent passwd ${UID} > /dev/null; then
      useradd -m -u ${UID} -g ${GID} ${USER_NAME}
    fi
fi

# Adapter les permissions pour le nouvel user
mkdir -p /srv/http/clipbucket /var/lib/nginx && chown -R ${USER_NAME}:${USER_NAME} /srv/http/clipbucket /run/php

if [ "$LITE" != "true" ]; then
    mkdir -p /var/lib/mysql /run/mysqld &&     chown -R ${USER_NAME}:${USER_NAME} /var/lib/mysql /run/mysqld /usr/lib/mysql
fi

# Configurer phpMyAdmin si installé
if [ "${INSTALL_PHPMYADMIN}" = "true" ] && [ -d "/usr/share/phpmyadmin" ]; then
    echo "phpMyAdmin is enabled on port 8080"
    # Adapter les permissions
    chown -R ${USER_NAME}:${USER_NAME} /var/lib/phpmyadmin /usr/share/phpmyadmin
fi

# Fonction pour terminer correctement les processus enfants
terminate_processes() {
    echo "Terminating processes..."
    kill -TERM "$php_pid" "$nginx_pid" 2>/dev/null || true
    if [ "$LITE" != "true" ]; then
        kill -TERM "$mariadb_pid" 2>/dev/null || true
        wait "$mariadb_pid" 2>/dev/null || true
    fi
    if [ "${INSTALL_REDIS}" = "true" ]; then
        kill -TERM "$redis_pid" 2>/dev/null || true
        wait "$redis_pid" 2>/dev/null || true
    fi
    wait "$php_pid" "$nginx_pid" 2>/dev/null || true
    echo "All processes terminated."
    exit 1
}

# Capturer les signaux pour arrêter proprement les processus
trap terminate_processes SIGTERM SIGINT

# Démarrer Redis si installé et demandé
if [ "${INSTALL_REDIS}" = "true" ]; then
    echo "Starting Redis Server..."
    redis-server /etc/redis/redis.conf --daemonize no &
    redis_pid=$!

    # Attendre que Redis soit disponible
    timeout=100
    elapsed=0
    while [ $elapsed -lt $timeout ]; do
        if redis-cli ping > /dev/null 2>&1; then
            echo "Redis Server is ready!"
            break
        fi
        sleep 0.1
        elapsed=$((elapsed + 1))
    done

    if [ $elapsed -ge $timeout ]; then
        echo "Warning: Redis Server did not start in time"
    fi
fi

# Mode lite : sans MariaDB
if [ "$LITE" != "true" ]; then
    # Vérifier si mysql a déjà été installé
    if [ ! -d "/var/lib/mysql/mysql" ]; then
        echo "Installing MariaDB..."
        mariadb-install-db --user=${USER_NAME} --basedir=/usr --datadir=/var/lib/mysql || true
    else
        echo "MariaDB already installed."
    fi

    # Démarrer MariaDB
    echo "Starting MariaDB..."
    mariadbd --user=${USER_NAME} --datadir=/var/lib/mysql &
    mariadb_pid=$!

    # Initialiser le compteur de temps d'attente
    timeout=200
    elapsed=0

    # Attendre que le fichier de socket MariaDB soit créé, avec une limite de 20 secondes
    while [ ! -e /var/run/mysqld/mysqld.sock ] && [ $elapsed -lt $timeout ]; do
      sleep 0.1
      elapsed=$((elapsed + 1))
    done

    # Si le fichier de socket n'a pas été trouvé après 20 secondes, échouer
    if [ ! -e /var/run/mysqld/mysqld.sock ]; then
      echo "Error: MariaDB socket file not created after 20 seconds."
      exit 1
    fi

    # Vérifier si la base de données existe
    if [ ! -d "/var/lib/mysql/clipbucket" ]; then
        echo "Init database..."
        mysql -uroot -e "CREATE DATABASE IF NOT EXISTS clipbucket;"
        mysql -uroot -e "CREATE USER IF NOT EXISTS 'clipbucket'@'localhost' IDENTIFIED BY '${MYSQL_PASSWORD}';"
        mysql -uroot -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost';"
        mysql -uroot -e "FLUSH PRIVILEGES;"
    else
        echo "Database already exists. No init required."
    fi
else
    echo "Lite mode: MariaDB is disabled"
fi

# Démarrer PHP-FPM
echo "Starting PHP-FPM ${PHP_VERSION}..."
php-fpm${PHP_VERSION} -F --fpm-config /etc/php/${PHP_VERSION}/fpm/php-fpm.conf --nodaemonize &
php_pid=$!

# Initialiser le compteur de temps d'attente
timeout=200
elapsed=0

# Attendre que le fichier de socket soit créé, avec une limite de 20 secondes
while [ ! -e /run/php/php${PHP_VERSION}-fpm.sock ] && [ $elapsed -lt $timeout ]; do
  sleep 0.1
  elapsed=$((elapsed + 1))
done

# Si le fichier de socket n'a pas été trouvé après 20 secondes, échouer
if [ ! -e /run/php/php${PHP_VERSION}-fpm.sock ]; then
  echo "Error: PHP-FPM socket file not created after 20 seconds."
  exit 1
fi

# Changer le propriétaire du fichier de socket une fois qu'il est disponible
chown ${USER_NAME}:${USER_NAME} /run/php/php${PHP_VERSION}-fpm.sock

# Vérifier si les sources existent
if [ ! "$(ls -A /srv/http/clipbucket)" ]; then
    echo "Init sources..."
    mkdir -p /srv/http/clipbucket
    git clone https://github.com/MacWarrior/clipbucket-v5.git /srv/http/clipbucket
    git config --global core.fileMode false
    git config --global --add safe.directory /srv/http/clipbucket
    chown -R ${USER_NAME}:${USER_NAME} /srv/http/clipbucket
    chmod 755 -R /srv/http/clipbucket
else
    echo "Sources already exist. No init required."
fi

# Démarrer Nginx en mode foreground
echo "Starting Nginx..."
nginx -g "daemon off;" &
nginx_pid=$!

# Surveiller les processus et détecter les arrêts
echo "========================================="
echo "All services started successfully!"
echo "========================================="
if [ "${INSTALL_PHPMYADMIN}" = "true" ]; then
    echo "phpMyAdmin available at: http://localhost:8080"
fi
if [ "${INSTALL_REDIS}" = "true" ]; then
    echo "Redis Server running on port 6379"
fi

while true; do
    if [ "$LITE" != "true" ]; then
        if ! kill -0 "$mariadb_pid" 2>/dev/null; then
            echo "MariaDB process has exited. Exiting script..."
            terminate_processes
        fi
    fi

    if ! kill -0 "$php_pid" 2>/dev/null; then
        echo "PHP-FPM process has exited. Exiting script..."
        terminate_processes
    fi

    if ! kill -0 "$nginx_pid" 2>/dev/null; then
        echo "Nginx process has exited. Exiting script..."
        terminate_processes
    fi

    if [ "${INSTALL_REDIS}" = "true" ]; then
        if ! kill -0 "$redis_pid" 2>/dev/null; then
            echo "Redis Server process has exited. Exiting script..."
            terminate_processes
        fi
    fi

    sleep 2
done
