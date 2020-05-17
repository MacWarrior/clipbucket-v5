#!/bin/bash
# Clipbucket install on Cent OS 7
## THIS SCRIPT MUST BE LAUNCHED AS ROOT

echo ""
echo -ne "Updating Cent OS system..."
yum update -y -q
echo -ne " OK"

echo ""
echo -ne "Installing requiered elements..."
rpm --quiet --import http://li.nux.ro/download/nux/RPM-GPG-KEY-nux.ro https://archive.fedoraproject.org/pub/epel/RPM-GPG-KEY-EPEL-7Server https://rpms.remirepo.net/RPM-GPG-KEY-remi
yum install -y -q yum-utils epel-release http://li.nux.ro/download/nux/dextop/el7/x86_64/nux-dextop-release-0-5.el7.nux.noarch.rpm

yum-config-manager --enable remi-php70 > /dev/null

yum install -y -q php php-mysqlnd php-curl php-xml php-mbstring php-pear php-devel httpd git mariadb-server mariadb gcc ImageMagick ImageMagick-devel gpac mediainfo sendmail ffmpeg ffmpeg-devel lshw > /dev/null 2>&1
# http://mir01.syntis.net/epel/7/x86_64/repodata/3e3bf72827ce3cbe2381f1cac087f6ff23b8bb8c2bdab06598f18057209e423e-updateinfo.xml.bz2: [Errno 14] HTTP Error 404 - Not Found
# I don't know how to fix this for now, but it works anyway :)

systemctl enable httpd mariadb > /dev/null 2>&1
systemctl start httpd mariadb
echo -ne " OK"

echo ""
echo -ne "Installing Clipbucket sources..."
mkdir -p /home/http/clipbucket/ && cd "$_"
git clone https://github.com/MacWarrior/clipbucket-5.0.git ./ > /dev/null 2>&1
echo -ne " OK"

echo ""
echo -ne "Updating sources access permissions..."
chown apache: -R ../clipbucket/
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
echo "Clipbucket installation completed"
echo ""

# You may have to manually specify a not-default audio codec for video conversion : libfaac
