# Clipbucket install on Debian 9.1

# Let's get all up to date
apt-get update
apt-get dist-upgrade -f

# Install all necessary
apt-get install php7.0 apache2 mariadb-server git php-curl php-imagick ffmpeg gpac ruby php7.0-mysqli php7.0-xml sendmail --yes
gem install flvtool2

# Creating directory et get sources
mkdir -p /home/http/clipbucket/ && cd "$_"
git clone https://github.com/MacWarrior/clipbucket.git ./

# Configuring Apache
cat << 'EOF' > /etc/apache2/sites-available/001-clipbucket.conf
<VirtualHost *:80>
        ServerName clipbucket.local
        DocumentRoot /home/http/clipbucket/upload/

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

ln -s /etc/apache2/sites-available/001-clipbucket.conf /etc/apache2/sites-enabled/001-clipbucket.conf

cat << 'EOF' >> /etc/apache2/apache2.conf

<Directory /home/http/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
EOF

# Restarting Apache service
service apache2 restart

# And it's done !
