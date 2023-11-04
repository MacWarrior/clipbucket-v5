#!/bin/bash
# ClipbucketV5 install on Cent OS 7.8
# PHP : 7.3.X
# MariaDB : 10.3
# FFMPEG : 3.4
## THIS SCRIPT MUST BE LAUNCHED AS ROOT

echo ""
echo -ne "Updating Cent OS system..."
yum update -y -q
echo -ne " OK"

echo ""
echo -ne "Installing requiered elements..."
yum install -y -q yum-utils epel-release http://rpms.remirepo.net/enterprise/remi-release-7.rpm
yum localinstall --nogpgcheck -y https://download1.rpmfusion.org/free/el/rpmfusion-free-release-7.noarch.rpm > /dev/null

cat > /etc/yum.repos.d/mariadb.10.3.repo << EOF
[mariadb]
name = MariaDB
baseurl = http://yum.mariadb.org/10.3/centos7-amd64
gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB
gpgcheck=1
EOF
yum update -y -q > /dev/null 2>&1

yum-config-manager --disable remi-php54 > /dev/null
yum-config-manager --enable remi-php73 > /dev/null

yum install -y -q php php-mysqlnd php-curl php-gd php-xml php-mbstring php-pear php-devel httpd git mariadb-server mariadb gcc ImageMagick ImageMagick-devel mediainfo sendmail ffmpeg ffmpeg-devel > /dev/null 2>&1

systemctl enable httpd mariadb > /dev/null 2>&1
systemctl start httpd mariadb
echo -ne " OK"

echo ""
echo -ne "Installing ClipbucketV5 sources..."
mkdir -p /home/http/clipbucket/ && cd "$_"
git clone https://github.com/MacWarrior/clipbucket-v5.git ./ > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Updating sources access permissions..."
chown apache: -R ../clipbucket/
chmod 755 -R ./upload/cache ./upload/files ./upload/images
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
echo -ne "Configuring Apache access..."
mv /etc/httpd/conf.d/welcome.conf /etc/httpd/conf.d/welcome.conf.bak
cat << 'EOF' > /etc/httpd/conf.d/001-clipbucket.conf
<VirtualHost *:80>
        ServerName clipbucket.local
        DocumentRoot /home/http/clipbucket/upload/

        ErrorLog /var/log/httpd/error_log
        CustomLog /var/log/httpd/access_log combined
</VirtualHost>
EOF

cat << 'EOF' >> /etc/httpd/conf/httpd.conf

NameVirtualHost *:80
<Directory /home/http/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
EOF

setenforce 0

firewall-cmd --permanent --add-port=80/tcp > /dev/null
firewall-cmd --reload > /dev/null

systemctl restart httpd > /dev/null

echo -ne " OK"
echo ""
echo "- Website URL : http://clipbucket.local"

echo ""
echo "ClipbucketV5 installation completed"
echo ""

# You may have to manually specify a not-default audio codec for video conversion : libfaac
