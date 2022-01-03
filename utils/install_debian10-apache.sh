#!/bin/bash
# Clipbucket install on Debian 10.0
## THIS SCRIPT MUST BE LAUNCHED AS ROOT

echo ""
echo -ne "Updating Debian system..."
apt update > /dev/null 2>&1
apt dist-upgrade -f > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Installing requiered elements..."
apt install php7.3 apache2 mariadb-server git php-curl ffmpeg php7.3-mysql php7.3-xml php7.3-mbstring php7.3-gd sendmail mediainfo --yes > /dev/null 2>&1
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 100M/g" /etc/php/7.3/apache2/php.ini
sed -i "s/post_max_size = 8M/post_max_size = 100M/g" /etc/php/7.3/apache2/php.ini
sed -i "s/max_execution_time = 30/max_execution_time = 7200/g" /etc/php/7.3/apache2/php.ini
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
echo -ne "Configuring Apache Vhost..."
a2enmod rewrite
cat << 'EOF' > /etc/apache2/sites-available/001-clipbucket.conf
<VirtualHost *:80>
    ServerName clipbucket.local
    DocumentRoot /home/http/clipbucket/upload/

    <Directory /home/http/clipbucket/upload/>
        Options Indexes FollowSymLinks
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

a2ensite 001-clipbucket > /dev/null

cat << 'EOF' >> /etc/apache2/apache2.conf

<Directory /home/http/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
EOF

# Restarting Apache service
systemctl restart apache2 > /dev/null

echo -ne " OK"
echo ""
echo "- Website URL : http://clipbucket.local"

echo ""
echo "Clipbucket installation completed"
echo ""
