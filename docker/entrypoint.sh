#!/bin/bash
set -e

# Définir les variables avec des valeurs par défaut si elles ne sont pas définies
PHP_VERSION=${PHP_VERSION:-8.2}
INSTALL_PATH=${INSTALL_PATH:-/srv/http/clipbucket}

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
if command -v php${PHP_VERSION}-fpm; then
    service php${PHP_VERSION}-fpm start
else
    echo "Error: PHP-FPM version ${PHP_VERSION} not installed."
    exit 1
fi

# Vérifier si les sources existe
if [ ! "$(ls -A ${INSTALL_PATH})" ]; then
    echo "Init sources..."
    mkdir -p ${INSTALL_PATH} && \
    git clone https://github.com/MacWarrior/clipbucket-v5.git ${INSTALL_PATH} && \
    git config --global core.fileMode false && \
    git config --global --add safe.directory ${INSTALL_PATH} && \
    chown www-data: -R ${INSTALL_PATH} && \
    chmod 755 -R ${INSTALL_PATH}
else
    echo "Sources already exists. No init required."
fi

# Démarrer Nginx en mode foreground
exec "$@"

