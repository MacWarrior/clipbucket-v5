#!/bin/bash

if [[ $EUID -ne 0 ]]; then
    echo "ClipBucketV5 easy installation script must be run as root"
    exit
fi

clear
echo ""
echo "  ____ _ _       ____             _        _ __     ______"
echo " / ___| (_)_ __ | __ ) _   _  ___| | _____| |\ \   / / ___|"
echo "| |   | | | '_ \|  _ \| | | |/ __| |/ / _ \ __\ \ / /|___ \\"
echo "| |___| | | |_) | |_) | |_| | (__|   <  __/ |_ \ V /  ___) |"
echo " \____|_|_| .__/|____/ \__,_|\___|_|\_\___|\__| \_/  |____/"
echo "          |_|  Installation script for Debian 12 + Nginx"
echo ""
echo "Disclaimer : This easy installation script is only"
echo "             made to configure local / dev environments."
echo "             Use it with caution."
echo ""

echo ""
echo -ne "Updating Debian system..."
apt update > /dev/null 2>&1
apt dist-upgrade -y > /dev/null 2>&1
echo -ne " OK"

echo ""
echo ""
echo "PHP versions availables : "
echo " - 8.2 [Default]"
echo " - 8.3"
read -p "Which PHP version do you want to use ? [8.2] " READ_PHP_VERSION
case ${READ_PHP_VERSION} in
    "8.3")
        echo ""
        echo -ne "Configuring PHP 8.3 repo..."
        apt install apt-transport-https lsb-release ca-certificates curl wget gnupg2 --yes > /dev/null 2>&1
        wget -qO- https://packages.sury.org/php/apt.gpg | gpg --dearmor > /etc/apt/trusted.gpg.d/sury-php-x.x.gpg
        echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
        apt update > /dev/null 2>&1
        echo -ne " OK"
        PHP_VERSION="8.3"
        ;;
    *)
        PHP_VERSION="8.2"
        ;;
esac

echo ""
echo -ne "Installing requiered elements..."
apt install php${PHP_VERSION}-fpm nginx-full mariadb-server git php${PHP_VERSION}-curl ffmpeg php${PHP_VERSION}-mysqli php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring php${PHP_VERSION}-gd sendmail mediainfo --yes > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Updating PHP ${PHP_VERSION} configs..."
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 100M/g" /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i "s/post_max_size = 8M/post_max_size = 100M/g" /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/${PHP_VERSION}/fpm/php.ini

sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 100M/g" /etc/php/${PHP_VERSION}/cli/php.ini
sed -i "s/post_max_size = 8M/post_max_size = 100M/g" /etc/php/${PHP_VERSION}/cli/php.ini
systemctl restart php${PHP_VERSION}-fpm
echo -ne " OK"

echo ""
echo -ne "Installing ClipbucketV5 sources..."
INSTALL_PATH="/srv/http/clipbucket/"
mkdir -p ${INSTALL_PATH}
git clone https://github.com/MacWarrior/clipbucket-v5.git ${INSTALL_PATH} > /dev/null 2>&1
git config --global --add safe.directory ${INSTALL_PATH}
echo -ne " OK"

echo ""
echo -ne "Updating sources access permissions..."
chown www-data: -R ${INSTALL_PATH}
chmod 755 -R ${INSTALL_PATH}
echo -ne " OK"

echo ""
read -p "Which domain name do you want to use ? [clipbucket.local] " READ_DOMAIN
case ${READ_DOMAIN} in
    "")
        DOMAIN_NAME="clipbucket.local"
        ;;
    *)
        DOMAIN_NAME=${READ_DOMAIN}
        ;;
esac

echo ""
echo -ne "Configuring Nginx Vhost..."
rm -f /etc/nginx/sites-enabled/default
cat << 'EOF' > /etc/nginx/sites-available/001-clipbucket
server {
    listen 80;
    server_name DOMAINNAME;

    root INSTALLPATH;
    index index.php;

    client_max_body_size 100M;

    # set expiration of assets to MAX for caching
    location ~* \.(ico|css|js)(\?[0-9]+)?$ {
        expires max;
        log_not_found off;
    }

    location ~* \.php$ {
        fastcgi_pass unix:/var/run/php/phpPHPVERSION-fpm.sock;
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

    error_page 404 /404;
    error_page 403 /403;
    location /403 {
        try_files $uri /403.php;
    }
    location /404 {
        try_files $uri /404.php;
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

sed -i "s/DOMAINNAME/${DOMAIN_NAME}/g" /etc/nginx/sites-available/001-clipbucket
sed -i "s/PHPVERSION/${PHP_VERSION}/g" /etc/nginx/sites-available/001-clipbucket
sed -i "s/INSTALLPATH/${INSTALL_PATH//\//\\/}upload/g" /etc/nginx/sites-available/001-clipbucket
ln -s /etc/nginx/sites-available/001-clipbucket /etc/nginx/sites-enabled/
systemctl restart nginx > /dev/null
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
echo "- Install directory : ${INSTALL_PATH}"
echo "- Website URL : http://${DOMAIN_NAME}"
echo ""
echo "ClipBucketV5 installation completed - Welcome onboard !"
echo ""
