#!/bin/bash
# ClipbucketV5 install on Cent OS 7.8
# PHP : 7.4.X
# MySQL : 8.0.X
# FFMPEG : 3.4
## THIS SCRIPT MUST BE LAUNCHED AS ROOT

echo ""
echo -ne "Updating Cent OS system..."
yum update -y -q
echo -ne " OK"

echo ""
echo -ne "Installing requiered elements..."
yum install yum-utils -y > /dev/null

yum -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm > /dev/null 2>&1
yum -y install https://rpms.remirepo.net/enterprise/remi-release-7.rpm > /dev/null 2>&1
yum-config-manager --enable remi-php74 > /dev/null

yum localinstall --nogpgcheck -y https://download1.rpmfusion.org/free/el/rpmfusion-free-release-7.noarch.rpm > /dev/null 2>&1

rpm -Uvh https://repo.mysql.com/mysql80-community-release-el7-3.noarch.rpm > /dev/null 2>&1
sed -i 's/enabled=1/enabled=0/' /etc/yum.repos.d/mysql-community.repo

yum --enablerepo=mysql80-community install -y -q mysql-community-server > /dev/null 2>&1

yum install -y -q php php-mysqlnd php-curl php-xml php-mbstring php-pear php-devel php-gd httpd git gcc ImageMagick ImageMagick-devel mediainfo sendmail ffmpeg ffmpeg-devel > /dev/null 2>&1

systemctl enable httpd mysqld > /dev/null 2>&1
systemctl start httpd mysqld
echo -ne " OK"

echo ""
echo "Updating Mysql ROOT password..."
MYSQL_ROOT_PASS=$(grep "A temporary password" /var/log/mysqld.log | awk -F "localhost: " '{print $NF}')
MYSQL_ROOT_PASS_NEW="$(date +%s | sha256sum | base64 | head -c 16)zQ9è/"
mysql -uroot -p${MYSQL_ROOT_PASS} --connect-expired-password -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '${MYSQL_ROOT_PASS_NEW}';" > /dev/null 2>&1
echo -ne " OK"
echo ""
echo "New Mysql ROOT Password : ${MYSQL_ROOT_PASS_NEW}"

echo ""
echo -ne "Installing ClipbucketV5 sources..."
mkdir -p /srv/http/clipbucket/ && cd "$_"
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
mysql -uroot -p${MYSQL_ROOT_PASS_NEW} -e "CREATE DATABASE clipbucket;" > /dev/null 2>&1
DB_PASS="$(date +%s | sha256sum | base64 | head -c 16)lO7à,"
mysql -uroot -p${MYSQL_ROOT_PASS_NEW} -e "CREATE USER 'clipbucket'@'localhost' IDENTIFIED BY '${DB_PASS}';" > /dev/null 2>&1
mysql -uroot -p${MYSQL_ROOT_PASS_NEW} -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost';" > /dev/null 2>&1
mysql -uroot -p${MYSQL_ROOT_PASS_NEW} -e "FLUSH PRIVILEGES;" > /dev/null 2>&1
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
        DocumentRoot /srv/http/clipbucket/upload/

        ErrorLog /var/log/httpd/error_log
        CustomLog /var/log/httpd/access_log combined
</VirtualHost>
EOF

cat << 'EOF' >> /etc/httpd/conf/httpd.conf

NameVirtualHost *:80
<Directory /srv/http/>
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
