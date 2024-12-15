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
        location / { \
            if ($query_string ~ "mosConfig_[a-zA-Z_]{1,21}(=|\%3D)"){ \
                rewrite ^/([^.]*)/?$ /index.php last; \
            } \
            rewrite ^/(.*)_v([0-9]+) /watch_video.php?v=$2&$query_string last; \
            rewrite ^/([a-zA-Z0-9-]+)/?$ /view_channel.php?uid=$1&seo_diret=yes last; \
        } \
        error_page 404 /404; \
        error_page 403 /403; \
        location /403 { \
            try_files $uri /403.php; \
        } \
        location /404 { \
            try_files $uri /404.php; \
        } \
        location /includes/ { \
            return 302 /404; \
        } \
        location /changelog/ { \
            return 302 /404; \
        } \
        location /video/ { \
            rewrite ^/video/(.*)/(.*) /watch_video.php?v=$1&$query_string last; \
            rewrite ^/video/([0-9]+)_(.*) /watch_video.php?v=$1&$query_string last; \
        } \
        location /videos/ { \
            rewrite ^/videos/(.*)/(.*)/(.*)/(.*)/(.*) /videos.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last; \
            rewrite ^/videos/([0-9]+) /videos.php?page=$1 last; \
            rewrite ^/videos/?$ /videos.php?$query_string last; \
        } \
        location /channels/ { \
            rewrite ^/channels/(.*)/(.*)/(.*)/(.*)/(.*) /channels.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last; \
            rewrite ^/channels/([0-9]+) /channels.php?page=$1 last; \
            rewrite ^/channels/?$ /channels.php last; \
        } \
        location /members/ { \
            rewrite ^/members/?$ /channels.php last; \
        } \
        location /users/ { \
            rewrite ^/users/?$ /channels.php last; \
        } \
        location /user/ { \
            rewrite ^/user/(.*) /view_channel.php?user=$1 last; \
        } \
        location /channel/ { \
            rewrite ^/channel/(.*) /view_channel.php?user=$1 last; \
        } \
        location /my_account { \
            rewrite ^/my_account /myaccount.php last; \
        } \
        location /page/ { \
            rewrite ^/page/([0-9]+)/(.*) /view_page.php?pid=$1 last; \
        } \
        location /search/ { \
            rewrite ^/search/result/?$ /search_result.php last; \
        } \
        location /upload { \
            rewrite ^/upload/?$ /upload.php last; \
        } \
        location /contact/ { \
            rewrite ^/contact/?$ /contact.php last; \
        } \
        location /categories/ { \
            rewrite ^/categories/?$ /categories.php last; \
        } \
        location /collections/ { \
            rewrite ^/collections/(.*)/(.*)/(.*)/(.*)/(.*) /collections.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last; \
            rewrite ^/collections/([0-9]+) /collections.php?page=$1 last; \
            rewrite ^/collections/?$ /collections.php last; \
        } \
        location /photos/ { \
            rewrite ^/photos/(.*)/(.*)/(.*)/(.*)/(.*) /photos.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last; \
            rewrite ^/photos/([0-9]+) /photos.php?page=$1 last; \
            rewrite ^/photos/?$ /photos.php last; \
        } \
        location /collection/ { \
            rewrite ^/collection/(.*)/(.*)/(.*) /view_collection.php?cid=$1&type=$2&page=$3 last; \
        } \
        location /item/ { \
            rewrite ^/item/(.*)/(.*)/(.*)/(.*) /view_item.php?item=$3&type=$1&collection=$2 last; \
        } \
        location /photo_upload { \
            rewrite ^/photo_upload/(.*) /photo_upload.php?collection=$1 last; \
            rewrite ^/photo_upload/?$ /photo_upload.php last; \
        } \
        location = /sitemap.xml { \
            rewrite ^(.*)$ /sitemap.php last; \
        } \
        location /signup { \
            rewrite ^/signup/?$ /signup.php last; \
        } \
        location /rss/ { \
            rewrite ^/rss/([a-zA-Z0-9].+)$ /rss.php?mode=$1&$query_string last; \
        } \
        location /list/ { \
            rewrite ^/list/([0-9]+)/(.*)?$ /view_playlist.php?list_id=$1 last; \
        } \
        location ~ /rss$ { \
            try_files $uri /rss.php; \
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
