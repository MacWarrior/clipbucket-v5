# Utiliser une image Debian stable comme base
FROM debian:stable-slim

# Variables d'environnement pour le runtime
ENV DOMAIN_NAME=clipbucket.local
ENV MYSQL_PASSWORD=clipbucket_password

# Ajouter un utilisateur avec un UID/GID dynamique
ENV UID=1000
ENV GID=1000

# Version de PHP fixée
RUN apt-get update && \
    apt-get dist-upgrade -y && \
    apt-get install -y \
        nginx-full \
        mariadb-server \
        php8.2-fpm \
        php8.2-curl \
        php8.2-mysqli \
        php8.2-xml \
        php8.2-mbstring \
        php8.2-gd \
        git \
        ffmpeg \
        sendmail \
        mediainfo && \
    apt-get clean

# Configuration PHP
RUN sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/8.2/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/8.2/fpm/php.ini
RUN sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/8.2/cli/php.ini

# change l'utilisateur de nginx et php-fpm
RUN sed -i 's/^user www-data;/user containeruser;/g' /etc/nginx/nginx.conf ;\
    sed -i 's/^user = www-data$/user = containeruser/' /etc/php/8.2/fpm/pool.d/www.conf ;\
    sed -i 's/^group = www-data$/group = containeruser/' /etc/php/8.2/fpm/pool.d/www.conf

# Configure Nginx
RUN rm -f /etc/nginx/sites-enabled/default && \
    echo 'server { \
        listen 80; \
        server_name DOMAIN_NAME_PLACEHOLDER; \
        root /srv/http/clipbucket/upload; \
        index index.php; \
        client_max_body_size 2M; \
        proxy_connect_timeout 7200s; \
        proxy_send_timeout 7200s; \
        proxy_read_timeout 7200s; \
        fastcgi_send_timeout 7200s; \
        fastcgi_read_timeout 7200s; \
        fastcgi_buffers 16 32k; \
        fastcgi_buffer_size 64k; \
        fastcgi_busy_buffers_size 64k; \
        proxy_buffer_size 128k; \
        proxy_buffers 4 256k; \
        proxy_busy_buffers_size 256k; \
        # set expiration of assets to MAX for caching \
        location ~* \.(ico|css|js)(\?[0-9]+)?$ { \
            expires max; \
            log_not_found off; \
        } \
        location ~* \.php$ { \
            fastcgi_pass unix:/run/php/php8.2-fpm.sock; \
            fastcgi_index index.php; \
            fastcgi_split_path_info ^(.+\.php)(.*)$; \
            include fastcgi_params; \
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        } \
        # set expiration of assets to MAX for caching \
        location ~* \.(ico|css|js)(\?[0-9]+)?$ { \
            expires max; \
            log_not_found off; \
        } \
        error_page 404 /404; \
        error_page 403 /403; \
        location ~* ^(.*/)?403$ { \
            try_files $uri $1/403.php; \
        } \
        location ~* ^(.*/)?404$ { \
            try_files $uri $1/404.php; \
        } \
        # Forbidden access \
        location ~ ^(.*/)?.(git|github|idea|gitignore|htaccess) { \
            return 302 $1403; \
        } \
        location ~* ^(.*/)?(includes|changelog)/ { \
            return 302 $1403; \
        } \
        # Direct acces to files \
        location ~* ^(.*/)?files/ { \
            try_files $uri $uri/ =404; \
        } \
        # External use \
        location ~* ^(.*/)?sitemap.xml$ { \
            rewrite ^(.*/)?sitemap.xml$ $1sitemap.php last; \
            break; \
        } \
        location ~* ^(.*/)?rss(/([a-zA-Z0-9][^/]*))?$ { \
            rewrite ^(.*/)?rss/?$ $1rss.php?$query_string last; \
            rewrite ^(.*/)?rss/([a-zA-Z0-9][^/]*)$ $1rss.php?mode=$2&$query_string last; \
            break; \
        } \
        # Collections \
        location ~* ^(.*/)?collections(/(.*))?$ { \
            rewrite ^(.*/)?collections/(.*)/(.*)/(.*)/(.*) $1collections.php?cat=$1&sort=$2&time=$3&page=$4&$query_string last; \
            rewrite ^(.*/)?collections/(.*)/(.*)/(.*) $1collections.php?sort=$1&time=$2&page=$3&$query_string last; \
            rewrite ^(.*/)?collections/([0-9]+) $1collections.php?page=$2&$query_string last; \
            rewrite ^(.*/)?collections/?$ $1collections.php last; \
            break; \
        } \
        location ~* ^(.*/)?collection(/(.*))?$ { \
            rewrite ^(.*/)?collection/(.*)/(.*)/(.*) $1view_collection.php?cid=$2&type=$3&page=$4&$query_string last; \
            break; \
        } \
        # Videos \
        location ~* ^(.*/)?videos(/(.*))?$ { \
            rewrite ^(.*/)?videos/(.*)/(.*)/(.*)/(.*) $1videos.php?cat=$1&sort=$2&time=$3&page=$4&$query_string last; \
            rewrite ^(.*/)?videos/(.*)/(.*)/(.*) $1videos.php?sort=$1&time=$2&page=$3&$query_string last; \
            rewrite ^(.*/)?videos/([0-9]+) $1videos.php?page=$2&$query_string last; \
            rewrite ^(.*/)?videos/?$ $1videos.php?$query_string last; \
            break; \
        } \
        location ~* ^(.*/)?video(/(.*))?$ { \
            rewrite ^(.*/)?video/(.*)/(.*) $1watch_video.php?v=$2&$query_string last; \
            rewrite ^(.*/)?video/([0-9]+)_(.*) $1watch_video.php?v=$2&$query_string last; \
            break; \
        } \
        location ~* ^(/.*/)?(.+)_v([0-9]+)$ { \
            rewrite ^(.*/)?(.*)_v([0-9]+) $1watch_video.php?v=$3&$query_string last; \
            break; \
        } \
        # Photos \
        location ~* ^(.*/)?item(/(.*))?$ { \
            rewrite ^(.*/)?item/(.*)/(.*)/(.*)/(.*) $1view_item.php?item=$4&type=$2&collection=$3&$query_string last; \
            break; \
        } \
        location ~* ^(.*/)?photos(/(.*))?$ { \
            rewrite ^(.*/)?photos/(.*)/(.*)/(.*)/(.*) $1photos.php?cat=$1&sort=$2&time=$3&page=$4&$query_string last; \
            rewrite ^(.*/)?photos/(.*)/(.*)/(.*) $1photos.php?sort=$1&time=$2&page=$3&$query_string last; \
            rewrite ^(.*/)?photos/([0-9]+) $1photos.php?page=$2&$query_string last; \
            rewrite ^(.*/)?photos/?$ $1photos.php?$query_string last; \
            break; \
        } \
        # Channels \
        location ~* ^(.*/)?channels(/(.*))?$ { \
            rewrite ^(.*/)?channels/(.*)/(.*)/(.*)/(.*) $1channels.php?cat=$1&sort=$2&time=$3&page=$4&$query_string last; \
            rewrite ^(.*/)?channels/(.*)/(.*)/(.*) $1channels.php?sort=$1&time=$2&page=$3&$query_string last; \
            rewrite ^(.*/)?channels/([0-9]+) $1channels.php?page=$2&$query_string last; \
            rewrite ^(.*/)?channels/?$ $1channels.php?$query_string last; \
            break; \
        } \
        location ~* ^(.*/)?user/(.*)$ { \
            rewrite ^(.*/)?user/(.*) $1view_channel.php?user=$2&$query_string last; \
            break; \
        } \
        # Uploads \
        location ~* ^(.*/)?photo_upload(/(.*))?$ { \
            rewrite ^(.*/)?photo_upload/(.*)$ $1photo_upload.php?collection=$2&$query_string last; \
            rewrite ^(.*/)?photo_upload/?$ $1photo_upload.php?$query_string last; \
            break; \
        } \
        location ~* ^(.*/)?upload/?$ { \
            rewrite ^(.*/)?upload/?$ $1upload.php?$query_string last; \
            break; \
        } \
        # Account \
        location ~* ^(.*/)?my_account$ { \
            rewrite ^(.*/)?my_account$ $1myaccount.php?$query_string last; \
            break; \
        } \
        location ~* ^(.*/)?signup/?$ { \
            rewrite ^(.*/)?signup/?$ $1signup.php?$query_string last; \
            break; \
        } \
        location ~* ^(.*/)?signin/?$ { \
            rewrite ^(.*/)?signin/?$ $1signup.php?mode=login&$query_string last; \
            break; \
        } \
        # Custom pages \
        location ~* ^(.*/)?page/([0-9]+)/(.*)$ { \
            rewrite ^(.*/)?page/([0-9]+)/(.*) $1view_page.php?pid=$2&$query_string last; \
            break; \
        } \
    }' > /etc/nginx/sites-available/clipbucket && \
    ln -s /etc/nginx/sites-available/clipbucket /etc/nginx/sites-enabled/

RUN sed -i "s/DOMAIN_NAME_PLACEHOLDER/${DOMAIN_NAME}/g" /etc/nginx/sites-available/clipbucket

# Ajouter un script d'entrée pour init bdd et sources si necessaire
COPY docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Créer les volumes pour la bdd et les sources
VOLUME ["/var/lib/mysql", "label=clipbucket_database"]
VOLUME ["/srv/http/clipbucket", "label=clipbucket_sources"]

# Port d'écoute
EXPOSE 80

# Commande de démarrage
ENTRYPOINT ["entrypoint.sh"]
