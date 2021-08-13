#!/bin/bash
# Clipbucket install on Debian 9.0 - 9.4
## THIS SCRIPT MUST BE LAUNCHED AS ROOT

echo ""
echo -ne "Updating Debian system..."
apt-get update > /dev/null
apt-get dist-upgrade -f > /dev/null
echo -ne " OK"

echo ""
echo -ne "Installing requiered elements..."
apt-get install php7.0-fpm nginx-full mariadb-server git php-curl ffmpeg php7.0-mysqli php7.0-xml php7.0-mbstring php7.0-gd sendmail mediainfo --yes > /dev/null 2>&1
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 50M/g" /etc/php/7.0/fpm/php.ini
sed -i "s/post_max_size = 8M/post_max_size = 50M/g" /etc/php/7.0/fpm/php.ini
sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/7.0/fpm/php.ini
service php7.0-fpm restart
echo -ne " OK"

echo ""
echo -ne "Installing Clipbucket sources..."
mkdir -p /home/http/clipbucket/ && cd "$_"
git clone https://github.com/MacWarrior/clipbucket-v5.git ./ > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Updating sources access permissions..."
chown www-data: -R ../clipbucket/
chmod 755 -R ./upload/cache ./upload/files ./upload/images ./upload/includes/langs
chmod 755 ./upload/includes
echo -ne " OK"

echo ""
echo -ne "Generating DB access..."
mysql -uroot -e "CREATE DATABASE clipbucket;"
DB_PASS=$(date +%s | sha256sum | base64 | head -c 16)
mysql -uroot -e "CREATE USER 'clipbucket'@'localhost' IDENTIFIED BY '$DB_PASS';"
mysql -uroot -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost' IDENTIFIED BY '$DB_PASS';"
mysql -uroot -e "FLUSH PRIVILEGES;"
echo -ne " OK"
echo ""
echo "- Database address : localhost"
echo "- Database name : clipbucket"
echo "- Database user : clipbucket"
echo "- Database password : ${DB_PASS}"

echo ""
echo -ne "Configuring Nginx Vhost..."
rm -f /etc/nginx/sites-enabled/default
cat << 'EOF' > /etc/nginx/sites-available/001-clipbucket
server {
    listen 80;
    server_name clipbucket.local;

    root /home/http/clipbucket/upload/;
    index index.php;

    client_max_body_size 50M;

    # set expiration of assets to MAX for caching
    location ~* \.(ico|css|js)(\?[0-9]+)?$ {
        expires max;
        log_not_found off;
    }

    location ~* \.php$ {
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location / {
        if ($query_string ~ "mosConfig_[a-zA-Z_]{1,21}(=|\%3D)"){
            rewrite ^/([^.]*)/?$ /index.php last;
        }
        rewrite ^/(.*)_v([0-9]+) /watch_video.php?v=$2&$query_string last;
    rewrite ^/([a-zA-Z0-9-]+)/?$ /view_channel.php?uid=$1&seo_diret=yes last;
    }

    location /includes/ {
        return 302 /404;
    }

    location /changelog/ {
        return 302 /404;
    }

    location /video/ {
        rewrite ^/video/(.*)/(.*) /watch_video.php?v=$1&$query_string last;
        rewrite ^/video/([0-9]+)_(.*) /watch_video.php?v=$1&$query_string last;
    }

    location /videos/ {
        rewrite ^/videos/(.*)/(.*)/(.*)/(.*)/(.*) /videos.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last;
        rewrite ^/videos/([0-9]+) /videos.php?page=$1 last;
        rewrite ^/videos/?$ /videos.php?$query_string last;
    }

    location /channels/ {
        rewrite ^/channels/(.*)/(.*)/(.*)/(.*)/(.*) /channels.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last;
        rewrite ^/channels/([0-9]+) /channels.php?page=$1 last;
        rewrite ^/channels/?$ /channels.php last;
    }

    location /members/ {
        rewrite ^/members/?$ /channels.php last;
    }

    location /users/ {
        rewrite ^/users/?$ /channels.php last;
    }

    location /user/ {
        rewrite ^/user/(.*) /view_channel.php?user=$1 last;
    }

    location /channel/ {
        rewrite ^/channel/(.*) /view_channel.php?user=$1 last;
    }

    location /my_account {
        rewrite ^/my_account /myaccount.php last;
    }

    location /page/ {
        rewrite ^/page/([0-9]+)/(.*) /view_page.php?pid=$1 last;
    }

    location /search/ {
        rewrite ^/search/result/?$ /search_result.php last;
    }

    location /upload {
        rewrite ^/upload/?$ /upload.php last;
    }

    location /contact/ {
        rewrite ^/contact/?$ /contact.php last;
    }

    location /categories/ {
        rewrite ^/categories/?$ /categories.php last;
    }

    location /collections/ {
        rewrite ^/collections/(.*)/(.*)/(.*)/(.*)/(.*) /collections.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last;
        rewrite ^/collections/([0-9]+) /collections.php?page=$1 last;
        rewrite ^/collections/?$ /collections.php last;
    }

    location /photos/ {
        rewrite ^/photos/(.*)/(.*)/(.*)/(.*)/(.*) /photos.php?cat=$1&sort=$3&time=$4&page=$5&seo_cat_name=$2 last;
        rewrite ^/photos/([0-9]+) /photos.php?page=$1 last;
        rewrite ^/photos/?$ /photos.php last;
    }

    location /collection/ {
        rewrite ^/collection/(.*)/(.*)/(.*) /view_collection.php?cid=$1&type=$2&page=$3 last;
    }

    location /item/ {
        rewrite ^/item/(.*)/(.*)/(.*)/(.*) /view_item.php?item=$3&type=$1&collection=$2 last;
    }

    location /photo_upload {
        rewrite ^/photo_upload/(.*) /photo_upload.php?collection=$1 last;
        rewrite ^/photo_upload/?$ /photo_upload.php last;
    }

    location = /sitemap.xml {
        rewrite ^(.*)$ /sitemap.php last;
    }

    location /signup {
        rewrite ^/signup/?$ /signup.php last;
    }

    location /rss/ {
        rewrite ^/rss/([a-zA-Z0-9].+)$ /rss.php?mode=$1&$query_string last;
    }

    location /list/ {
        rewrite ^/list/([0-9]+)/(.*)?$ /view_playlist.php?list_id=$1 last;
    }

    location ~ /rss$ {
        try_files $uri /rss.php;
    }
}
EOF

ln -s /etc/nginx/sites-available/001-clipbucket /etc/nginx/sites-enabled/

# Restarting Apache service
systemctl restart nginx > /dev/null

echo -ne " OK"
echo ""
echo "- Website URL : http://clipbucket.local"

echo ""
echo "Clipbucket installation completed"
echo ""
