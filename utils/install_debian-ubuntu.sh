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
echo "          |_|            Installation script for"
echo "                    Debian 10-12 & Ubuntu 22.04-24.10"
echo ""
echo "Disclaimer : This easy installation script is only"
echo "             made to configure local / dev environments."
echo "             Use it with caution, on a clean OS."

echo ""
echo -ne "Updating system..."
apt update > /dev/null 2>&1
apt dist-upgrade -y > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Installing required software for setup..."
apt install lsb-release --yes > /dev/null 2>&1
echo -ne " OK"

OS_NAME=$(lsb_release -d | awk -F"\t" '{print $2}')
case ${OS_NAME} in

    "Debian GNU/Linux 10 (buster)")
        OS="DEBIAN10"
        ;;
    "Debian GNU/Linux 11 (bullseye)")
        OS="DEBIAN11"
        ;;
    "Debian GNU/Linux 12 (bookworm)")
        OS="DEBIAN12"
        ;;

    "Ubuntu 22.04.3 LTS"|"Ubuntu 22.04.2 LTS"|"Ubuntu 22.04.1 LTS"|"Ubuntu 22.04 LTS"|"Ubuntu 22.04")
        OS="UBUNTU2204"
        ;;
    "Ubuntu 23.04")
        OS="UBUNTU2304"
        ;;
    "Ubuntu 23.10")
        OS="UBUNTU2310"
        ;;
    "Ubuntu 24.04.1 LTS"|"Ubuntu 24.04 LTS"|"Ubuntu 24.04")
        OS="UBUNTU2404"
        ;;
    "Ubuntu 24.10")
        OS="UBUNTU2410"
        ;;
    *)
        echo ""
        echo ""
        echo "Installation script haven't been able to determine your operating system."
        echo "Please select one : "
        echo " - Debian 10"
        echo " - Debian 11"
        echo " - Debian 12"
        echo " - Ubuntu 22.04"
        echo " - Ubuntu 23.04"
        echo " - Ubuntu 23.10"
        echo " - Ubuntu 24.04"
        echo " - Ubuntu 24.10"
        read -p "Which operating system do you use ? " READ_OS
        case ${READ_OS} in
            "Debian 10"|"debian 10")
                OS="DEBIAN10"
                ;;
            "Debian 11"|"debian 11")
                OS="DEBIAN11"
                ;;
            "Debian"|"debian"|"Debian 12"|"debian 12")
                OS="DEBIAN12"
                ;;
            "Ubuntu 22.04"|"ubuntu 22.04")
                OS="UBUNTU2204"
                ;;
            "Ubuntu 23.04"|"ubuntu 23.04")
                OS="UBUNTU2204"
                ;;
            "Ubuntu 23.10"|"ubuntu 23.10")
                OS="UBUNTU2310"
                ;;
            "Ubuntu 24.04"|"ubuntu 24.04")
                OS="UBUNTU2404"
                ;;
            "Ubuntu"|"ubuntu"|"Ubuntu 24.10"|"ubuntu 24.10")
                OS="UBUNTU2410"
                ;;
            *)
                echo "Unknown system, please select Debian or Ubuntu"
                exit
                ;;
        esac
        ;;
esac

echo ""
echo ""
echo "HTTP servers availables : "
echo " - Nginx [Default]"
echo " - Apache"
read -p "Which HTTP server do you want to use ? [Nginx] " READ_HTTP_SERVER
case ${READ_HTTP_SERVER} in
    "Apache")
        HTTP_SERVER="APACHE"
        echo ""
        echo -ne "Installing Apache..."
        apt install apache2 --yes > /dev/null 2>&1
        ;;
    *)
        HTTP_SERVER="NGINX"
        echo ""
        echo -ne "Installing Nginx..."
        apt install nginx-full --yes > /dev/null 2>&1
        ;;
esac
echo -ne " OK"

case ${OS} in
    "DEBIAN10")
        echo ""
        echo ""
        echo "PHP versions availables : "
        echo " - 8.0 [Default]"
        echo " - 8.1"
        echo " - 8.2"
        echo " - 8.3"
        echo " - 8.4"
        read -p "Which PHP version do you want to use ? [8.0] " READ_PHP_VERSION
        case ${READ_PHP_VERSION} in
            "8.0"|"8.1"|"8.2"|"8.3"|"8.4"|*)
                echo ""
                echo -ne "Configuring PHP ${READ_PHP_VERSION} repo..."
                apt install apt-transport-https ca-certificates curl wget gnupg2 --yes > /dev/null 2>&1
                wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg > /dev/null 2>&1
                echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
                apt update > /dev/null 2>&1
                echo -ne " OK"
                PHP_VERSION=${READ_PHP_VERSION}
                ;;
        esac
        ;;

    "DEBIAN11")
        echo ""
        echo ""
        echo "PHP versions availables : "
        echo " - 8.0 [Default]"
        echo " - 8.1"
        echo " - 8.2"
        echo " - 8.3"
        echo " - 8.4"
        read -p "Which PHP version do you want to use ? [8.0] " READ_PHP_VERSION
        case ${READ_PHP_VERSION} in
            "8.0"|"8.1"|"8.2"|"8.3"|"8.4"|*)
                echo ""
                echo -ne "Configuring PHP ${READ_PHP_VERSION} repo..."
                apt install apt-transport-https ca-certificates curl wget gnupg2 --yes > /dev/null 2>&1
                wget -qO- https://packages.sury.org/php/apt.gpg | gpg --dearmor > /etc/apt/trusted.gpg.d/sury-php-x.x.gpg
                echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
                apt update > /dev/null 2>&1
                echo -ne " OK"
                PHP_VERSION=${READ_PHP_VERSION}
                ;;
        esac
        ;;

    "DEBIAN12")
        echo ""
        echo ""
        echo "PHP versions availables : "
        echo " - 8.2 [Default]"
        echo " - 8.3"
        echo " - 8.4"
        read -p "Which PHP version do you want to use ? [8.2] " READ_PHP_VERSION
        case ${READ_PHP_VERSION} in
            "8.3"|"8.4")
                echo ""
                echo -ne "Configuring PHP ${READ_PHP_VERSION} repo..."
                apt install apt-transport-https ca-certificates curl wget gnupg2 --yes > /dev/null 2>&1
                wget -qO- https://packages.sury.org/php/apt.gpg | gpg --dearmor > /etc/apt/trusted.gpg.d/sury-php-x.x.gpg
                echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
                apt update > /dev/null 2>&1
                echo -ne " OK"
                PHP_VERSION=${READ_PHP_VERSION}
                ;;
            "8.2"|*)
                PHP_VERSION="8.2"
                ;;
        esac
        ;;

    "UBUNTU2304"|"UBUNTU2204")
        PHP_VERSION="8.1"
        ;;
    "UBUNTU2310")
        PHP_VERSION="8.2"
        ;;
    "UBUNTU2404"|"UBUNTU2410")
        PHP_VERSION="8.3"
        ;;
esac

echo ""
echo -ne "Installing requiered elements..."
apt install php${PHP_VERSION}-fpm mariadb-server git php${PHP_VERSION}-curl ffmpeg php${PHP_VERSION}-mysqli php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring php${PHP_VERSION}-gd sendmail mediainfo --yes > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Updating PHP ${PHP_VERSION} configs..."
sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i "s/;ffi.enable=preload/ffi.enable=true/g" /etc/php/${PHP_VERSION}/cli/php.ini

systemctl restart php${PHP_VERSION}-fpm
echo -ne " OK"

echo ""
echo -ne "Installing ClipbucketV5 sources..."
SERVER_ROOT="/srv/http/"
INSTALL_PATH="${SERVER_ROOT}clipbucket/"
mkdir -p ${INSTALL_PATH}
git clone https://github.com/MacWarrior/clipbucket-v5.git ${INSTALL_PATH} > /dev/null 2>&1
git config --global core.fileMode false
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
case ${HTTP_SERVER} in
    "NGINX")
        echo -ne "Configuring Nginx Vhost..."
        VHOST_PATH="/etc/nginx/sites-available/001-clipbucket"
        rm -f /etc/nginx/sites-enabled/default
        cat << 'EOF' > ${VHOST_PATH}
server {
    listen 80;
    server_name DOMAINNAME;

    root INSTALLPATH;
    index index.php;

    client_max_body_size 2M;

    proxy_connect_timeout 7200s;
    proxy_send_timeout 7200s;
    proxy_read_timeout 7200s;
    fastcgi_send_timeout 7200s;
    fastcgi_read_timeout 7200s;

    fastcgi_buffers 16 32k;
    fastcgi_buffer_size 64k;
    fastcgi_busy_buffers_size 64k;
    proxy_buffer_size 128k;
    proxy_buffers 4 256k;
    proxy_busy_buffers_size 256k;

    location ~* \.php$ {
        fastcgi_pass unix:/var/run/php/phpPHPVERSION-fpm.sock;
        fastcgi_index index.php;
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    error_page 404 /404;
    error_page 403 /403;
    location ~* ^(.*/)?403$ {
        try_files $uri $1403.php;
    }
    location ~* ^(.*/)?404$ {
        try_files $uri $1404.php;
    }

    # Forbidden access
    location ~ ^(.*/)?.(git|github|idea|gitignore|htaccess) {
        return 302 $1403;
    }
    location ~* ^(.*/)?(includes|changelog)/ {
        return 302 $1403;
    }
    location ~* ^(.*/)?files/temp/ {
        return 302 $1403;
    }

    # Direct acces to files
    location ~* ^(.*/)?files/ {
        try_files $uri $uri/ =404;
    }
    location ~* \.(css|js|jpe?g|png|gif|webp|svg|ico|woff2?|ttf|eot|otf|mp4|m3u8|ts|srt|webm|ogg|mp3)(\?[0-9]+)?$ {
        access_log off;
        log_not_found off;
        expires max;
        try_files $uri =404;
    }

    # External use
    location ~* ^(.*/)?sitemap.xml$ {
        rewrite ^(.*/)?sitemap.xml$ $1sitemap.php last;
    }
    location ~* ^(.*/)?rss(/([a-zA-Z0-9][^/]*))?$ {
        rewrite ^(.*/)?rss/?$ $1rss.php?$query_string last;
        rewrite ^(.*/)?rss/([a-zA-Z0-9][^/]*)$ $1rss.php?mode=$2&$query_string last;
    }

    # Collections
    location ~* ^(.*/)?collections(/(.*))?$ {
        rewrite ^(.*/)?collections/(.*)/(.*)/(.*)/(.*) $1collections.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;
        rewrite ^(.*/)?collections/(.*)/(.*)/(.*) $1collections.php?sort=$2&time=$3&page=$4&$query_string last;
        rewrite ^(.*/)?collections/([0-9]+) $1collections.php?page=$2&$query_string last;
        rewrite ^(.*/)?collections/?$ $1collections.php?$query_string last;
    }
    location ~* ^(.*/)?collection(/(.*))?$ {
        rewrite ^(.*/)?collection/(.*)/(.*)/(.*) $1view_collection.php?cid=$2&type=$3&page=$4&$query_string last;
    }

    # Videos
    location ~* ^(.*/)?videos(/(.*))?$ {
        rewrite ^(.*/)?videos/(.*)/(.*)/(.*)/(.*) $1videos.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;
        rewrite ^(.*/)?videos/(.*)/(.*)/(.*) $1videos.php?sort=$2&time=$3&page=$4&$query_string last;
        rewrite ^(.*/)?videos/([0-9]+) $1videos.php?page=$2&$query_string last;
        rewrite ^(.*/)?videos/?$ $1videos.php?$query_string last;
    }
    location ~* ^(.*/)?videos_public(/(.*))?$ {
        rewrite ^(.*/)?videos_public/(.*)/(.*)/(.*)/(.*) $1videos_public.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;
        rewrite ^(.*/)?videos_public/(.*)/(.*)/(.*) $1videos_public.php?sort=$2&time=$3&page=$4&$query_string last;
        rewrite ^(.*/)?videos_public/([0-9]+) $1videos_public.php?page=$2&$query_string last;
        rewrite ^(.*/)?videos_public/?$ $1videos_public.php?$query_string last;
    }
    location ~* ^(.*/)?video(/(.*))?$ {
        rewrite ^(.*/)?video/(.*)/(.*) $1watch_video.php?v=$2&$query_string last;
        rewrite ^(.*/)?video/([0-9]+)_(.*) $1watch_video.php?v=$2&$query_string last;
    }
    location ~* ^(.*/)?video_public(/(.*))?$ {
        rewrite ^(.*/)?video_public/(.*)/(.*) $1watch_video_public.php?v=$2&$query_string last;
        rewrite ^(.*/)?video_public/([0-9]+)_(.*) $1watch_video_public.php?v=$2&$query_string last;
    }
    location ~* ^(/.*/)?(.+)_v([0-9]+)$ {
        rewrite ^(.*/)?(.*)_v([0-9]+) $1watch_video.php?v=$3&$query_string last;
    }

    # Photos
    location ~* ^(.*/)?item(/(.*))?$ {
        rewrite ^(.*/)?item/(.*)/(.*)/(.*)/(.*) $1view_item.php?item=$4&type=$2&collection=$3&$query_string last;
    }
    location ~* ^(.*/)?photos(/(.*))?$ {
        rewrite ^(.*/)?photos/(.*)/(.*)/(.*)/(.*) $1photos.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;
        rewrite ^(.*/)?photos/(.*)/(.*)/(.*) $1photos.php?sort=$2&time=$3&page=$4&$query_string last;
        rewrite ^(.*/)?photos/([0-9]+) $1photos.php?page=$2&$query_string last;
        rewrite ^(.*/)?photos/?$ $1photos.php?$query_string last;
    }

    # Channels
    location ~* ^(.*/)?channels(/(.*))?$ {
        rewrite ^(.*/)?channels/(.*)/(.*)/(.*)/(.*) $1channels.php?cat=$2&sort=$3&time=$4&page=$5&$query_string last;
        rewrite ^(.*/)?channels/(.*)/(.*)/(.*) $1channels.php?sort=$2&time=$3&page=$4&$query_string last;
        rewrite ^(.*/)?channels/([0-9]+) $1channels.php?page=$2&$query_string last;
        rewrite ^(.*/)?channels/?$ $1channels.php?$query_string last;
    }
    location ~* ^(.*/)?user/(.*)$ {
        rewrite ^(.*/)?user/(.*) $1view_channel.php?user=$2&$query_string last;
    }

    # Uploads
    location ~* ^(.*/)?photo_upload(/(.*))?$ {
        rewrite ^(.*/)?photo_upload/(.*)$ $1photo_upload.php?collection=$2&$query_string last;
        rewrite ^(.*/)?photo_upload/?$ $1photo_upload.php?$query_string last;
    }
    location ~* ^(.*/)?upload/?$ {
        rewrite ^(.*/)?upload/?$ $1upload.php?$query_string last;
    }

    # Account
    location ~* ^(.*/)?my_account$ {
        rewrite ^(.*/)?my_account$ $1myaccount.php?$query_string last;
    }
    location ~* ^(.*/)?signup/?$ {
        rewrite ^(.*/)?signup/?$ $1signup.php?$query_string last;
    }
    location ~* ^(.*/)?signin/?$ {
        rewrite ^(.*/)?signin/?$ $1signup.php?mode=login&$query_string last;
    }

    # Custom pages
    location ~* ^(.*/)?page/([0-9]+)/(.*)$ {
        rewrite ^(.*/)?page/([0-9]+)/(.*) $1view_page.php?pid=$2&$query_string last;
    }
}
EOF

        ln -s ${VHOST_PATH} /etc/nginx/sites-enabled/
        ;;

    "APACHE")
        echo -ne "Configuring Apache Vhost..."
        VHOST_PATH="/etc/apache2/sites-available/001-clipbucket.conf"
        a2enconf php${PHP_VERSION}-fpm 2>&1 > /dev/null
        a2enmod rewrite proxy_fcgi 2>&1 > /dev/null
        cat << 'EOF' > ${VHOST_PATH}
<VirtualHost *:80>
    ServerName DOMAINNAME
    DocumentRoot INSTALLPATH

    <Directory INSTALLPATH>
        Options Indexes FollowSymLinks
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    <FilesMatch .php$>
        SetHandler "proxy:unix:/run/php/phpPHPVERSION-fpm.sock|fcgi://localhost"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

        a2ensite 001-clipbucket > /dev/null

        cat << 'EOF' >> /etc/apache2/apache2.conf

<Directory SERVERROOT>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
EOF
        sed -i "s/SERVERROOT/${SERVER_ROOT//\//\\/}/g" /etc/apache2/apache2.conf
        ;;
esac

sed -i "s/DOMAINNAME/${DOMAIN_NAME}/g" ${VHOST_PATH}
sed -i "s/PHPVERSION/${PHP_VERSION}/g" ${VHOST_PATH}
sed -i "s/INSTALLPATH/${INSTALL_PATH//\//\\/}upload/g" ${VHOST_PATH}

case ${HTTP_SERVER} in
    "NGINX")
      systemctl restart nginx > /dev/null
      ;;
    "APACHE")
      systemctl restart apache2 > /dev/null
      ;;
esac
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
