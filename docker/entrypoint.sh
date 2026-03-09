#!/bin/bash
set -e

# Set default PHP version if not specified
PHP_VERSION="${PHP_VERSION:-8.5}"

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

# Adjust permissions for the new user
mkdir -p /srv/http/clipbucket /var/lib/nginx && chown -R ${USER_NAME}:${USER_NAME} /srv/http/clipbucket /run/php

if [ "$INSTALL_MARIADB" != "true" ]; then
    mkdir -p /var/lib/mysql /run/mysqld &&     chown -R ${USER_NAME}:${USER_NAME} /var/lib/mysql /run/mysqld /usr/lib/mysql
fi

# Configure phpMyAdmin if installed
if [ "${INSTALL_PHPMYADMIN}" = "true" ] && [ -d "/usr/share/phpmyadmin" ]; then
    echo "phpMyAdmin is enabled on port 8080"
    # Adjust permissions
    chown -R ${USER_NAME}:${USER_NAME} /var/lib/phpmyadmin /usr/share/phpmyadmin
fi

# Function to properly terminate child processes
terminate_processes() {
    echo "Terminating processes..."
    kill -TERM "$php_pid" "$nginx_pid" 2>/dev/null || true
    if [ "$INSTALL_MARIADB" = "true" ]; then
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

# Capture signals to properly stop processes
trap terminate_processes SIGTERM SIGINT

# Start Redis if installed and requested
if [ "${INSTALL_REDIS}" = "true" ]; then
    echo "Starting Redis Server..."
    redis-server /etc/redis/redis.conf --daemonize no &
    redis_pid=$!

    # Wait for Redis to be available
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

# Mode without MariaDB
if [ "$INSTALL_MARIADB" = "true" ]; then
    # Check if mysql has already been installed
    if [ ! -d "/var/lib/mysql/mysql" ]; then
        echo "Installing MariaDB..."
        mariadb-install-db --user=${USER_NAME} --basedir=/usr --datadir=/var/lib/mysql || true
    else
        echo "MariaDB already installed."
    fi

    # Start MariaDB
    echo "Starting MariaDB..."
    mariadbd --user=${USER_NAME} --datadir=/var/lib/mysql &
    mariadb_pid=$!

    # Initialize timeout counter
    timeout=200
    elapsed=0

    # Wait for MariaDB socket file to be created, with a 20 second limit
    while [ ! -e /var/run/mysqld/mysqld.sock ] && [ $elapsed -lt $timeout ]; do
      sleep 0.1
      elapsed=$((elapsed + 1))
    done

    # If socket file was not found after 20 seconds, fail
    if [ ! -e /var/run/mysqld/mysqld.sock ]; then
      echo "Error: MariaDB socket file not created after 20 seconds."
      exit 1
    fi

    # Check if database exists
    if [ ! -d "/var/lib/mysql/clipbucket" ]; then
        echo "Init database..."
        mysql -uroot -e "CREATE DATABASE IF NOT EXISTS clipbucket;"
        mysql -uroot -e "CREATE USER IF NOT EXISTS 'clipbucket'@'localhost' IDENTIFIED BY '${MYSQL_PASSWORD}';"
        mysql -uroot -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost';"
        mysql -uroot -e "FLUSH PRIVILEGES;"
    else
        echo "Database already exists. No init required."
    fi

    # Create XHGUI database and user if profiling is enabled
    if [ "${INSTALL_PROFILING}" = "true" ]; then
        echo "Creating XHGUI database and user..."
        mysql -uroot -e "CREATE DATABASE IF NOT EXISTS xhgui;"
        mysql -uroot -e "CREATE USER IF NOT EXISTS 'xhgui'@'localhost' IDENTIFIED BY 'xhgui';"
        mysql -uroot -e "GRANT ALL PRIVILEGES ON xhgui.* TO 'xhgui'@'localhost';"
        mysql -uroot -e "FLUSH PRIVILEGES;"
        echo "XHGUI database created successfully."
    fi
else
    echo "MariaDB is disabled"
fi

# Start PHP-FPM
echo "Starting PHP-FPM ${PHP_VERSION}..."
php-fpm${PHP_VERSION} -F --fpm-config /etc/php/${PHP_VERSION}/fpm/php-fpm.conf --nodaemonize &
php_pid=$!

# Initialize timeout counter
timeout=200
elapsed=0

# Wait for socket file to be created, with a 20 second limit
while [ ! -e /run/php/php${PHP_VERSION}-fpm.sock ] && [ $elapsed -lt $timeout ]; do
  sleep 0.1
  elapsed=$((elapsed + 1))
done

# If socket file was not found after 20 seconds, fail
if [ ! -e /run/php/php${PHP_VERSION}-fpm.sock ]; then
  echo "Error: PHP-FPM socket file not created after 20 seconds."
  exit 1
fi

# Change socket file owner once available
chown ${USER_NAME}:${USER_NAME} /run/php/php${PHP_VERSION}-fpm.sock

# Check if sources exist
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

# Start Nginx in foreground mode
echo "Starting Nginx..."
nginx -g "daemon off;" &
nginx_pid=$!

# Monitor processes and detect shutdowns
echo "========================================="
echo "All services started successfully!"
echo "========================================="
if [ "${INSTALL_PHPMYADMIN}" = "true" ]; then
    echo "phpMyAdmin available at: http://${PHPMYADMIN_DOMAIN}:8080"
fi
if [ "${INSTALL_REDIS}" = "true" ]; then
    echo "Redis Server running on port 6379"
fi

while true; do
    if [ "$INSTALL_MARIADB" = "true" ]; then
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
