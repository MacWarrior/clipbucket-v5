#!/bin/bash
set -e

# Démarrer MariaDB en arrière-plan
service mariadb start

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

# Démarrer les autres services
service php8.2-fpm start

# Vérifier si les sources existe
if [ ! "$(ls -A /srv/http/clipbucket)" ]; then
    echo "Init sources..."
    mkdir -p /srv/http/clipbucket && \
    git clone https://github.com/MacWarrior/clipbucket-v5.git /srv/http/clipbucket && \
    git config --global core.fileMode false && \
    git config --global --add safe.directory /srv/http/clipbucket && \
    chown www-data: -R /srv/http/clipbucket && \
    chmod 755 -R /srv/http/clipbucket
else
    echo "Sources already exists. No init required."
fi

# Démarrer Nginx en mode foreground
exec "$@"
