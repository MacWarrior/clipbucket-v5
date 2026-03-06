# Use a stable Debian image as base
FROM debian:stable-slim

# Build arguments for customization
ARG LITE=false
ARG PHP_VERSION=8.4
ARG INSTALL_PHPMYADMIN=false
ARG INSTALL_XDEBUG=false
ARG INSTALL_REDIS=false
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

# Install PHP pear (required for pecl)
RUN apt-get update && apt-get install -y --no-install-recommends     php-pear     && rm -rf /var/lib/apt/lists/*

# Install PHP and extensions (one by one for debugging)
RUN apt-get update

# Install PHP-FPM
RUN apt-get install -y --no-install-recommends php${PHP_VERSION}-fpm ||     (echo "ERROR: Failed to install php${PHP_VERSION}-fpm" && exit 1)

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

# Clean apt cache after all PHP installs
RUN rm -rf /var/lib/apt/lists/*

# Install MariaDB only if not in lite mode
RUN if [ "$LITE" = "false" ]; then         apt-get update &&         apt-get install -y --no-install-recommends mariadb-server &&         rm -rf /var/lib/apt/lists/*;     fi

# Install Redis server if requested
RUN if [ "$INSTALL_REDIS" = "true" ]; then         apt-get update &&         apt-get install -y --no-install-recommends redis-server &&         rm -rf /var/lib/apt/lists/* &&         sed -i 's/^bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf &&         sed -i 's/^# maxmemory/maxmemory 256mb/' /etc/redis/redis.conf &&         sed -i 's/^# maxmemory-policy/maxmemory-policy allkeys-lru/' /etc/redis/redis.conf;     fi

# Install PHP Xdebug if requested
RUN if [ "$INSTALL_XDEBUG" = "true" ]; then         apt-get update &&         apt-get install -y --no-install-recommends php${PHP_VERSION}-xdebug ||         (pecl install xdebug &&         echo "zend_extension=xdebug.so" > /etc/php/${PHP_VERSION}/mods-available/xdebug.ini) &&         echo "xdebug.mode=debug,coverage" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         echo "xdebug.start_with_request=yes" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         echo "xdebug.client_host=host.docker.internal" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         echo "xdebug.client_port=9003" >> /etc/php/${PHP_VERSION}/mods-available/xdebug.ini &&         phpenmod xdebug &&         rm -rf /var/lib/apt/lists/*;     fi

# Install XHProf (always installed for profiling)
RUN apt-get update &&     (apt-get install -y --no-install-recommends php${PHP_VERSION}-xhprof ||     pecl install xhprof) &&     echo "extension=xhprof.so" > /etc/php/${PHP_VERSION}/mods-available/xhprof.ini &&     phpenmod xhprof &&     rm -rf /var/lib/apt/lists/*

# Install phpMyAdmin via git clone if requested
RUN if [ "$INSTALL_PHPMYADMIN" = "true" ]; then         mkdir -p /usr/share/phpmyadmin &&         cd /usr/share/phpmyadmin &&         git clone --depth 1 --branch STABLE https://github.com/phpmyadmin/phpmyadmin.git . &&         mkdir -p /var/lib/phpmyadmin/tmp &&         chmod 777 /var/lib/phpmyadmin/tmp &&         apt-get update &&         apt-get install -y --no-install-recommends php${PHP_VERSION}-bcmath php${PHP_VERSION}-opcache &&         echo "<?php \\$cfg['blowfish_secret'] = '$(openssl rand -base64 32)'; \\$cfg['TempDir'] = '/var/lib/phpmyadmin/tmp'; \\$cfg['Servers'][1]['auth_type'] = 'cookie'; \\$cfg['Servers'][1]['host'] = 'localhost'; \\$cfg['Servers'][1]['compress'] = false; \\$cfg['Servers'][1]['AllowNoPassword'] = false;" > /usr/share/phpmyadmin/config.inc.php &&         rm -rf /var/lib/apt/lists/*;     fi

# PHP configuration
RUN sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/${PHP_VERSION}/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/cli/php.ini

# Change the nginx and php-fpm user
RUN sed -i 's/^user www-data;/user containeruser;/g' /etc/nginx/nginx.conf &&     sed -i "s/^user = www-data\$/user = containeruser/" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf &&     sed -i "s/^group = www-data\$/group = containeruser/" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf

# Configure Nginx
RUN rm -f /etc/nginx/sites-enabled/default &&     echo 'server {         listen 80;         server_name DOMAIN_NAME_PLACEHOLDER;         root /srv/http/clipbucket/upload;         index index.php;         client_max_body_size 2M;         proxy_connect_timeout 7200s;         proxy_send_timeout 7200s;         proxy_read_timeout 7200s;         fastcgi_send_timeout 7200s;         fastcgi_read_timeout 7200s;         fastcgi_buffers 16 32k;         fastcgi_buffer_size 64k;         fastcgi_busy_buffers_size 64k;         proxy_buffer_size 128k;         proxy_buffers 4 256k;         proxy_busy_buffers_size 256k;         location ~* \.(php|phtml)$ {             fastcgi_pass unix:/run/php/phpPHP_VERSION_PLACEHOLDER-fpm.sock;             fastcgi_index index.php;             fastcgi_split_path_info ^(.+\.(php|phtml))(.*)$;             include fastcgi_params;             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;         }         error_page 404 /404;         error_page 403 /403;         location ~* ^(.*/)?403$ {             try_files $uri $1403.php;         }         location ~* ^(.*/)?404$ {             try_files $uri $1404.php;         }         # Forbidden access         location ~ ^(.*/)?\.(git|github|idea|gitignore|htaccess) {             return 302 $1403;         }         location ~* ^(.*/)?(includes|changelog)/ {             return 302 $1403;         }         location ~* ^(.*/)?files/temp/ {             return 302 $1403;         }         # Direct acces to files         location ~* ^(.*/)?files/ {             try_files $uri $uri/ =404;         }         location ~* \.(css|js|jpe?g|png|gif|webp|svg|ico|woff2?|ttf|eot|otf|mp4|m3u8|ts|srt|webm|ogg|mp3)(\?[0-9]+)?$ {             access_log off;             log_not_found off;             expires max;             try_files $uri =404;         }         # External use         location ~* ^(.*/)?sitemap\.xml$ {             rewrite ^(.*/)?sitemap\.xml$ $1sitemap.php last;         }         location ~* ^(.*/)?rss(/([a-zA-Z0-9][^/]*))?$ {             rewrite ^(.*/)?rss/?$ $1rss.php?$query_string last;             rewrite ^(.*/)?rss/([a-zA-Z0-9][^/]*)$ $1rss.php?mode=$2&$query_string last;         }         # Collections         location ~* ^(.*/)?collections(/(.*))?$ {             rewrite ^(.*/)?collections/(.*)/(.*)/(.*)/(.*) $1collections.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;             rewrite ^(.*/)?collections/(.*)/(.*)/(.*) $1collections.php?sort=$2&time=$3&page=$4&$query_string last;             rewrite ^(.*/)?collections/([0-9]+) $1collections.php?page=$2&$query_string last;             rewrite ^(.*/)?collections/?$ $1collections.php?$query_string last;         }         location ~* ^(.*/)?collection(/(.*))?$ {             rewrite ^(.*/)?collection/(.*)/(.*)/(.*) $1view_collection.php?cid=$2&type=$3&page=$4&$query_string last;         }         # Videos         location ~* ^(.*/)?videos(/(.*))?$ {             rewrite ^(.*/)?videos/(.*)/(.*)/(.*)/(.*) $1videos.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;             rewrite ^(.*/)?videos/(.*)/(.*)/(.*) $1videos.php?sort=$2&time=$3&page=$4&$query_string last;             rewrite ^(.*/)?videos/([0-9]+) $1videos.php?page=$2&$query_string last;             rewrite ^(.*/)?videos/?$ $1videos.php?$query_string last;         }         location ~* ^(.*/)?videos_public(/(.*))?$ {             rewrite ^(.*/)?videos_public/(.*)/(.*)/(.*)/(.*) $1videos_public.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;             rewrite ^(.*/)?videos_public/(.*)/(.*)/(.*) $1videos_public.php?sort=$2&time=$3&page=$4&$query_string last;             rewrite ^(.*/)?videos_public/([0-9]+) $1videos_public.php?page=$2&$query_string last;             rewrite ^(.*/)?videos_public/?$ $1videos_public.php?$query_string last;         }         location ~* ^(.*/)?video(/(.*))?$ {             rewrite ^(.*/)?video/(.*)/(.*) $1watch_video.php?v=$2&$query_string last;             rewrite ^(.*/)?video/([0-9]+)_(.*) $1watch_video.php?v=$2&$query_string last;         }         location ~* ^(.*/)?video_public(/(.*))?$ {             rewrite ^(.*/)?video_public/(.*)/(.*) $1watch_video_public.php?v=$2&$query_string last;             rewrite ^(.*/)?video_public/([0-9]+)_(.*) $1watch_video_public.php?v=$2&$query_string last;         }         location ~* ^(/.*/)?(.+)_v([0-9]+)$ {             rewrite ^(.*/)?(.*)_v([0-9]+) $1watch_video.php?v=$3&$query_string last;         }         # Photos         location ~* ^(.*/)?item(/(.*))?$ {             rewrite ^(.*/)?item/(.*)/(.*)/(.*)/(.*) $1view_item.php?item=$4&type=$2&collection=$3&$query_string last;         }         location ~* ^(.*/)?photos(/(.*))?$ {             rewrite ^(.*/)?photos/(.*)/(.*)/(.*)/(.*) $1photos.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;             rewrite ^(.*/)?photos/(.*)/(.*)/(.*) $1photos.php?sort=$2&time=$3&page=$4&$query_string last;             rewrite ^(.*/)?photos/([0-9]+) $1photos.php?page=$2&$query_string last;             rewrite ^(.*/)?photos/?$ $1photos.php?$query_string last;         }         # Channels         location ~* ^(.*/)?channels(/(.*))?$ {             rewrite ^(.*/)?channels/(.*)/(.*)/(.*)/(.*) $1channels.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;             rewrite ^(.*/)?channels/(.*)/(.*)/(.*) $1channels.php?sort=$2&time=$3&page=$4&$query_string last;             rewrite ^(.*/)?channels/([0-9]+) $1channels.php?page=$2&$query_string last;             rewrite ^(.*/)?channels/?$ $1channels.php?$query_string last;         }         location ~* ^(.*/)?user/(.*)$ {             rewrite ^(.*/)?user/(.*) $1view_channel.php?user=$2&$query_string last;         }         # Uploads         location ~* ^(.*/)?photo_upload(/(.*))?$ {             rewrite ^(.*/)?photo_upload/(.*)$ $1photo_upload.php?collection=$2&$query_string last;             rewrite ^(.*/)?photo_upload/?$ $1photo_upload.php?$query_string last;         }         location ~* ^(.*/)?upload/?$ {             rewrite ^(.*/)?upload/?$ $1upload.php?$query_string last;         }         # Account         location ~* ^(.*/)?my_account$ {             rewrite ^(.*/)?my_account$ $1myaccount.php?$query_string last;         }         location ~* ^(.*/)?signup/?$ {             rewrite ^(.*/)?signup/?$ $1signup.php?$query_string last;         }         location ~* ^(.*/)?signin/?$ {             rewrite ^(.*/)?signin/?$ $1signup.php?mode=login&$query_string last;         }         # Custom pages         location ~* ^(.*/)?page/([0-9]+)/(.*)$ {             rewrite ^(.*/)?page/([0-9]+)/(.*) $1view_page.php?pid=$2&$query_string last;         }     }' > /etc/nginx/sites-available/clipbucket &&     ln -s /etc/nginx/sites-available/clipbucket /etc/nginx/sites-enabled/

# Configure phpMyAdmin for Nginx if installed
RUN if [ "$INSTALL_PHPMYADMIN" = "true" ]; then         echo 'server {         listen 8080;         server_name PHPMYADMIN_DOMAIN_PLACEHOLDER;         root /usr/share/phpmyadmin;         index index.php;         location ~* \.(php|phtml)$ {             fastcgi_pass unix:/run/php/phpPHP_VERSION_PLACEHOLDER-fpm.sock;             fastcgi_index index.php;             include fastcgi_params;             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;         }         location / {             try_files $uri $uri/ /index.php;         }     }' >> /etc/nginx/sites-available/phpmyadmin &&         sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/phpmyadmin &&         ln -sf /etc/nginx/sites-available/phpmyadmin /etc/nginx/sites-enabled/;     fi

# Activate ClipBucket site
RUN ln -sf /etc/nginx/sites-available/clipbucket /etc/nginx/sites-enabled/     && sed -i "s/DOMAIN_NAME_PLACEHOLDER/${DOMAIN_NAME}/g" /etc/nginx/sites-available/clipbucket     && sed -i "s/phpPHP_VERSION_PLACEHOLDER-fpm/php${PHP_VERSION}-fpm/g" /etc/nginx/sites-available/clipbucket     && sed -i "s/PHPMYADMIN_DOMAIN_PLACEHOLDER/${PHPMYADMIN_DOMAIN}/g" /etc/nginx/sites-available/phpmyadmin

# Add entrypoint script for database and sources initialization
COPY docker/entrypoint.sh /usr/local/bin/
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create volumes (only in full mode, not in lite mode)
VOLUME ["/srv/http/clipbucket", "label=clipbucket_sources"]

# Listening ports (8080 for phpMyAdmin if installed)
EXPOSE 80

# Start command
ENTRYPOINT ["entrypoint.sh"]
