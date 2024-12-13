#!/bin/bash
set -e

# Démarrer MariaDB en arrière-plan
service mariadb start

# Vérifier si la base de données existe
if [ ! -d "/var/lib/mysql/clipbucket" ]; then
    echo "Initialisation de la base de données..."
    mysql -uroot -e "CREATE DATABASE clipbucket;"
    mysql -uroot -e "CREATE USER 'clipbucket'@'localhost' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';"
    mysql -uroot -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost';"
    mysql -uroot -e "FLUSH PRIVILEGES;"
else
    echo "La base de données existe déjà. Aucune initialisation requise."
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
    echo "Initialisation des sources..."
    mkdir -p ${INSTALL_PATH} && \
    git clone https://github.com/MacWarrior/clipbucket-v5.git ${INSTALL_PATH} && \
    git config --global core.fileMode false && \
    git config --global --add safe.directory ${INSTALL_PATH} && \
    chown www-data: -R ${INSTALL_PATH} && \
    chmod 755 -R ${INSTALL_PATH}
else
    echo "Les sources existe déjà. Aucune initialisation requise."
fi

# Démarrer Nginx en mode foreground
exec "$@"

