# Use a stable Debian image as base
FROM debian:stable-slim

# Build arguments for customization
ARG LITE=false
ARG PHP_VERSION=8.4
ARG INSTALL_PHPMYADMIN=false
ARG INSTALL_XDEBUG=false
ARG INSTALL_REDIS=false
ARG INSTALL_PROFILING=false
ARG DOMAIN_NAME=clipbucket.local
ARG PHPMYADMIN_DOMAIN=phpmyadmin.local

# Environment variables for runtime
ENV DOMAIN_NAME=${DOMAIN_NAME}
ENV PHPMYADMIN_DOMAIN=${PHPMYADMIN_DOMAIN}
ENV MYSQL_PASSWORD=clipbucket_password
ENV LITE=${LITE}
ENV PHP_VERSION=${PHP_VERSION}

# Add a user with a dynamic UID/GID
ENV UID=1000
ENV GID=1000

# Install base dependencies and add PHP repository
RUN apt-get update && apt-get install -y --no-install-recommends     ca-certificates     curl     gnupg2     lsb-release     && rm -rf /var/lib/apt/lists/*

# Add Ondrej Sury PHP repository for all PHP versions (8.1-8.5)
# This external repo is required because Debian stable only provides one PHP version
RUN mkdir -p /etc/apt/keyrings \
    && curl -sSL https://packages.sury.org/php/apt.gpg -o /etc/apt/keyrings/sury-php.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/sury-php.gpg] https://packages.sury.org/php $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update

# Debug: Show repository configuration
RUN echo "=== Repository Configuration ===" && cat /etc/apt/sources.list.d/php.list \
    && echo "=== Debian Version ===" && lsb_release -sc

# Validate PHP version (8.1 to 8.5)
RUN case "${PHP_VERSION}" in     8.1|8.2|8.3|8.4|8.5) echo "PHP version ${PHP_VERSION} is valid" ;;     *) echo "Error: PHP_VERSION must be between 8.1 and 8.5 (inclusive)"; exit 1 ;; esac

# Update package list after adding PHP repository
RUN apt-get update

# Install nginx and base tools
RUN apt-get install -y --no-install-recommends     nginx-full     git     ffmpeg     sendmail     mediainfo     curl     wget     unzip     && rm -rf /var/lib/apt/lists/*

# Install PHP pear (required for pecl) only if needed
RUN if [ "$INSTALL_XDEBUG" = "true" ] || [ "$INSTALL_PROFILING" = "true" ]; then         apt-get update && apt-get install -y --no-install-recommends         php-pear         && rm -rf /var/lib/apt/lists/*;     fi

# Install PHP and extensions (one by one for debugging)
RUN apt-get update

# Install PHP-FPM and PHP-CLI (same version)
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-fpm ||     (echo "ERROR: Failed to install php${PHP_VERSION}-fpm" && exit 1)

# Install PHP-CLI (same version as FPM)
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-cli ||     (echo "ERROR: Failed to install php${PHP_VERSION}-cli" && exit 1)

# Configure update-alternatives to use the correct PHP version
RUN update-alternatives --set php /usr/bin/php${PHP_VERSION} 2>/dev/null ||     update-alternatives --install /usr/bin/php php /usr/bin/php${PHP_VERSION} 100

# Install PHP-Dev
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-dev ||     (echo "ERROR: Failed to install php${PHP_VERSION}-dev" && exit 1)

# Install PHP-Curl
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-curl ||     (echo "ERROR: Failed to install php${PHP_VERSION}-curl" && exit 1)

# Install PHP-MySQLi
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-mysqli ||     (echo "ERROR: Failed to install php${PHP_VERSION}-mysqli" && exit 1)

# Install PHP-XML
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-xml ||     (echo "ERROR: Failed to install php${PHP_VERSION}-xml" && exit 1)

# Install PHP-MBString
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-mbstring ||     (echo "ERROR: Failed to install php${PHP_VERSION}-mbstring" && exit 1)

# Install PHP-GD
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-gd ||     (echo "ERROR: Failed to install php${PHP_VERSION}-gd" && exit 1)

# Install PHP-Zip
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-zip ||     (echo "ERROR: Failed to install php${PHP_VERSION}-zip" && exit 1)

# Install common PHP extensions
# Note: json and openssl are built into PHP 8.0+
# Note: pcntl may not be available for PHP 8.5 yet
RUN apt-get install -y --no-install-recommends     php${PHP_VERSION}-intl     php${PHP_VERSION}-fileinfo     php${PHP_VERSION}-tokenizer     php${PHP_VERSION}-ctype     php${PHP_VERSION}-iconv     php${PHP_VERSION}-simplexml     php${PHP_VERSION}-dom     php${PHP_VERSION}-sockets     php${PHP_VERSION}-posix     php${PHP_VERSION}-ffi ||     (echo "WARNING: Some PHP extensions could not be installed" && exit 0)

# Clean apt cache after all PHP installs
RUN rm -rf /var/lib/apt/lists/*

# Install MariaDB only if not in lite mode
RUN if [ "$LITE" = "false" ]; then         apt-get update &&         apt-get install -y --no-install-recommends mariadb-server &&         rm -rf /var/lib/apt/lists/*;     fi

# Install Redis server if requested
RUN if [ "$INSTALL_REDIS" = "true" ]; then         apt-get update &&         apt-get install -y --no-install-recommends redis-server &&         rm -rf /var/lib/apt/lists/* &&         sed -i 's/^bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf &&         sed -i 's/^# maxmemory/maxmemory 256mb/' /etc/redis/redis.conf &&         sed -i 's/^# maxmemory-policy/maxmemory-policy allkeys-lru/' /etc/redis/redis.conf;     fi

# Install PHP Xdebug if requested
RUN if [ "$INSTALL_XDEBUG" = "true" ]; then         apt-get update &&         apt-get install -y --no-install-recommends php${PHP_VERSION}-xdebug ||         (pecl install xdebug &&         echo "zend_extension=xdebug.so" > /etc/php/${PHP_VERSION}/mods-available/xdebug.ini) &&         echo "xdebug.mode=debug,coverage" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         echo "xdebug.start_with_request=yes" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         echo "xdebug.client_host=host.docker.internal" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         echo "xdebug.client_port=9003" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         phpenmod xdebug &&         rm -rf /var/lib/apt/lists/*;     fi

# Install XHProf only if profiling is requested
RUN if [ "$INSTALL_PROFILING" = "true" ]; then         apt-get update &&         (apt-get install -y --no-install-recommends php${PHP_VERSION}-xhprof ||         pecl install xhprof) &&         echo "extension=xhprof.so" > /etc/php/${PHP_VERSION}/mods-available/xhprof.ini &&         phpenmod xhprof &&         rm -rf /var/lib/apt/lists/*;     fi

# Install phpMyAdmin via git clone if requested
RUN if [ "$INSTALL_PHPMYADMIN" = "true" ]; then         mkdir -p /usr/share/phpmyadmin &&         cd /usr/share/phpmyadmin &&         git clone --depth 1 --branch STABLE https://github.com/phpmyadmin/phpmyadmin.git . &&         mkdir -p /var/lib/phpmyadmin/tmp &&         chmod 777 /var/lib/phpmyadmin/tmp &&         apt-get update &&         (apt-get install -y --no-install-recommends php${PHP_VERSION}-bcmath php${PHP_VERSION}-opcache ||          apt-get install -y --no-install-recommends php-bcmath php-opcache ||          echo "Warning: Could not install bcmath/opcache packages") &&         echo "<?php \\$cfg['blowfish_secret'] = '$(openssl rand -base64 32)'; \\$cfg['TempDir'] = '/var/lib/phpmyadmin/tmp'; \\$cfg['Servers'][1]['auth_type'] = 'cookie'; \\$cfg['Servers'][1]['host'] = 'localhost'; \\$cfg['Servers'][1]['compress'] = false; \\$cfg['Servers'][1]['AllowNoPassword'] = false;" > /usr/share/phpmyadmin/config.inc.php &&         rm -rf /var/lib/apt/lists/*;     fi

# PHP configuration
RUN sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/${PHP_VERSION}/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/cli/php.ini

# Change the nginx and php-fpm user
RUN sed -i 's/^user www-data;/user containeruser;/g' /etc/nginx/nginx.conf &&     sed -i "s/^user = www-data\$/user = containeruser/" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf &&     sed -i "s/^group = www-data\$/group = containeruser/" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf


# Copy nginx configuration
COPY docker/nginx-clipbucket.conf /etc/nginx/sites-available/clipbucket
RUN rm -f /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/clipbucket /etc/nginx/sites-enabled/

# Replace placeholders in nginx config
RUN sed -i "s/DOMAIN_NAME_PLACEHOLDER/${DOMAIN_NAME}/g" /etc/nginx/sites-available/clipbucket && \
    sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/clipbucket

# Configure phpMyAdmin for Nginx if installed
RUN if [ "$INSTALL_PHPMYADMIN" = "true" ]; then \
        echo 'server { \
        listen 8080; \
        server_name PHPMYADMIN_DOMAIN_PLACEHOLDER; \
        root /usr/share/phpmyadmin; \
        index index.php; \
        location ~* \\.php$ { \
            fastcgi_pass unix:/run/php/phpPHP_VERSION_PLACEHOLDER-fpm.sock; \
            fastcgi_index index.php; \
            include fastcgi_params; \
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        } \
        location / { \
            try_files $uri $uri/ /index.php; \
        } \
    }' >> /etc/nginx/sites-available/phpmyadmin && \
        sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/phpmyadmin && \
        ln -sf /etc/nginx/sites-available/phpmyadmin /etc/nginx/sites-enabled/; \
    fi

# Configure phpMyAdmin domain if installed
RUN if [ -f /etc/nginx/sites-available/phpmyadmin ]; then \
        sed -i "s/PHPMYADMIN_DOMAIN_PLACEHOLDER/${PHPMYADMIN_DOMAIN}/g" /etc/nginx/sites-available/phpmyadmin; \
    fi

# Add entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && \
    chmod +x /usr/local/bin/entrypoint.sh

# Create volumes
VOLUME ["/srv/http/clipbucket", "label=clipbucket_sources"]

# Expose port
EXPOSE 80

# Start command
ENTRYPOINT ["entrypoint.sh"]
