# Use a stable Debian image as base
FROM debian:stable-slim

# Build arguments for customization
ARG INSTALL_MARIADB=false
ARG PHP_VERSION=8.5
ARG INSTALL_PHPMYADMIN=false
ARG INSTALL_XDEBUG=false
ARG INSTALL_REDIS=false
ARG INSTALL_PROFILING=false
ARG DOMAIN_NAME=clipbucket.local
ARG PHPMYADMIN_DOMAIN=phpmyadmin.local
ARG PROFILING_DOMAIN=profiling.local

# Environment variables for runtime
ENV DOMAIN_NAME=${DOMAIN_NAME}
ENV PHPMYADMIN_DOMAIN=${PHPMYADMIN_DOMAIN}
ENV MYSQL_PASSWORD=clipbucket_password
ENV INSTALL_MARIADB=${INSTALL_MARIADB}
ENV PHP_VERSION=${PHP_VERSION}
ENV INSTALL_PHPMYADMIN=${INSTALL_PHPMYADMIN}
ENV INSTALL_XDEBUG=${INSTALL_XDEBUG}
ENV INSTALL_REDIS=${INSTALL_REDIS}
ENV INSTALL_PROFILING=${INSTALL_PROFILING}
ENV PROFILING_DOMAIN=${PROFILING_DOMAIN}

# Add a user with a dynamic UID/GID
ENV UID=1000
ENV GID=1000

# Install base dependencies and add PHP repository
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates  curl  gnupg2  lsb-release  nginx-full git \
    ffmpeg  sendmail mediainfo curl wget unzip  

# Add Ondrej Sury PHP repository for all PHP versions 
# This external repo is required because Debian stable only provides one PHP version
RUN mkdir -p /etc/apt/keyrings \
    && curl -sSL https://packages.sury.org/php/apt.gpg -o /etc/apt/keyrings/sury-php.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/sury-php.gpg] https://packages.sury.org/php $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-dev \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-mysqli \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-fileinfo \
        php${PHP_VERSION}-tokenizer \
        php${PHP_VERSION}-ctype \
        php${PHP_VERSION}-iconv \
        php${PHP_VERSION}-simplexml \
        php${PHP_VERSION}-dom \
        php${PHP_VERSION}-sockets \
        php${PHP_VERSION}-posix \
        php${PHP_VERSION}-ffi

# Configure update-alternatives to use the correct PHP version
RUN update-alternatives --set php /usr/bin/php${PHP_VERSION} 2>/dev/null || update-alternatives --install /usr/bin/php php /usr/bin/php${PHP_VERSION} 100

# Install PHP pear (required for pecl) only if needed
RUN if [ "${INSTALL_XDEBUG}" = "true" ] || [ "${INSTALL_PROFILING}" = "true" ]; then \
        apt-get install -y --no-install-recommends php-pear; \
    fi

# Install MariaDB only if not in INSTALL_MARIADB mode
RUN if [ "${INSTALL_MARIADB}" = "true" ]; then \
        apt-get install -y --no-install-recommends mariadb-server ; \
    fi

# Install Redis server if requested
RUN if [ "${INSTALL_REDIS}" = "true" ]; then \
        apt-get install -y --no-install-recommends redis-server ; \
        sed -i 's/^bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf \
        && echo 'maxmemory 256mb' >> /etc/redis/redis.conf \
        && echo 'maxmemory-policy allkeys-lru' >> /etc/redis/redis.conf;\
    fi

# Install PHP Xdebug if requested
RUN if [ "${INSTALL_XDEBUG}" = "true" ]; then \
        apt-get install -y --no-install-recommends php${PHP_VERSION}-xdebug || (pecl install xdebug && echo "zend_extension=xdebug.so" > /etc/php/${PHP_VERSION}/mods-available/xdebug.ini) \
        && echo "xdebug.mode=debug,coverage" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini \
        && echo "xdebug.start_with_request=yes" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini \
        && echo "xdebug.client_host=host.docker.internal" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini \
        && echo "xdebug.client_port=9003" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini && phpenmod xdebug ;\
    fi

# Install XHProf and XHGUI only if profiling is requested
RUN if [ "${INSTALL_PROFILING}" = "true" ]; then \
        (apt-get install -y --no-install-recommends php${PHP_VERSION}-xhprof || pecl install xhprof) \
        && echo "extension=xhprof.so" > /etc/php/${PHP_VERSION}/mods-available/xhprof.ini \
        && phpenmod xhprof && phpenmod pdo_mysql  ;\
    fi

# Copy XHGUI configuration file
COPY docker/xhgui-config.php /tmp/xhgui-config.php

# Install XHGUI if profiling is requested
RUN if [ "${INSTALL_PROFILING}" = "true" ]; then \
        apt-get install -y --no-install-recommends composer \
        && mkdir -p /usr/share/xhgui /var/lib/xhgui \
        && git clone --depth 1 https://github.com/perftools/xhgui.git /usr/share/xhgui \
        && chmod 777 /var/lib/xhgui && mkdir -p /usr/share/xhgui/cache \
        && chmod 777 /usr/share/xhgui/cache && cd /usr/share/xhgui \
        && (composer install --no-dev --optimize-autoloader 2>&1 || echo "Composer install completed with warnings") \
        && mkdir -p config \
        && cp /tmp/xhgui-config.php /usr/share/xhgui/config/config.php ;\
    fi

# PHP configuration
RUN sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/${PHP_VERSION}/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/cli/php.ini

# Change the nginx and php-fpm user
RUN sed -i 's/^user www-data;/user containeruser;/g' /etc/nginx/nginx.conf \
    && sed -i "s/^user = www-data\$/user = containeruser/" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && sed -i "s/^group = www-data\$/group = containeruser/" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf

# Copy nginx configuration
COPY docker/nginx-clipbucket.conf /etc/nginx/sites-available/clipbucket
RUN rm -f /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/clipbucket /etc/nginx/sites-enabled/

# Replace placeholders in nginx config
RUN sed -i "s/DOMAIN_NAME_PLACEHOLDER/${DOMAIN_NAME}/g" /etc/nginx/sites-available/clipbucket && \
    sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/clipbucket

# Copy nginx config for phpMyAdmin
COPY docker/nginx-phpmyadmin.conf /tmp/nginx-phpmyadmin.conf
RUN if [ "${INSTALL_PHPMYADMIN}" = "true" ]; then \
        mkdir -p /etc/nginx/sites-available /etc/nginx/sites-enabled && \
        cp /tmp/nginx-phpmyadmin.conf /etc/nginx/sites-available/phpmyadmin && \
        sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/phpmyadmin && \
        ln -sf /etc/nginx/sites-available/phpmyadmin /etc/nginx/sites-enabled/; \
    fi

# Configure phpMyAdmin domain if installed
RUN if [ -f /etc/nginx/sites-available/phpmyadmin ]; then \
        sed -i "s/PHPMYADMIN_DOMAIN_PLACEHOLDER/${PHPMYADMIN_DOMAIN}/g" /etc/nginx/sites-available/phpmyadmin; \
    fi

# Copy nginx config for XHGUI
COPY docker/nginx-xhgui.conf /tmp/nginx-xhgui.conf
RUN if [ "${INSTALL_PROFILING}" = "true" ]; then \
        mkdir -p /etc/nginx/sites-available /etc/nginx/sites-enabled && \
        cp /tmp/nginx-xhgui.conf /etc/nginx/sites-available/xhgui && \
        sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/xhgui && \
        ln -sf /etc/nginx/sites-available/xhgui /etc/nginx/sites-enabled/; \
    fi

# Configure XHGUI domain if installed
RUN if [ -f /etc/nginx/sites-available/xhgui ]; then \
        sed -i "s/PROFILING_DOMAIN_PLACEHOLDER/${PROFILING_DOMAIN}/g" /etc/nginx/sites-available/xhgui; \
    fi

# Install phpMyAdmin via git clone with yarn build for assets
RUN if [ "${INSTALL_PHPMYADMIN}" = "true" ]; then \
        echo "---- Installing phpMyAdmin from official release ----" && \
        echo "---- Creating directories ----" && \
        mkdir -p /usr/share/phpmyadmin /var/lib/phpmyadmin/tmp && \
        echo "---- Downloading latest phpMyAdmin ----" && \
        curl -fsSL https://files.phpmyadmin.net/phpMyAdmin/latest/phpMyAdmin-latest-all-languages.tar.gz -o /tmp/phpmyadmin.tar.gz && \
        echo "---- Extracting phpMyAdmin ----" && \
        tar xzf /tmp/phpmyadmin.tar.gz --strip-components=1 -C /usr/share/phpmyadmin && \
        echo "---- Setting permissions ----" && \
        chmod 777 /var/lib/phpmyadmin/tmp && \
        echo "---- Creating phpMyAdmin config ----" && \
        echo "<?php \$cfg['blowfish_secret'] = '$(openssl rand -base64 32)'; \$cfg['TempDir'] = '/var/lib/phpmyadmin/tmp'; \$cfg['Servers'][1]['auth_type'] = 'cookie'; \$cfg['Servers'][1]['host'] = 'localhost'; \$cfg['Servers'][1]['compress'] = false; \$cfg['Servers'][1]['AllowNoPassword'] = false;" > /usr/share/phpmyadmin/config.inc.php && \
        echo "---- Cleaning temporary files ----" && \
        rm -f /tmp/phpmyadmin.tar.gz && \
        echo "---- phpMyAdmin installation completed ----"; \
    fi

# Clean apt cache apt
RUN rm -rf /var/lib/apt/lists/*

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