@echo off
cls

:: TODO
:: - Hide git install progress bar if possible

net session >nul 2>&1
if %errorLevel% NEQ 0 (
    echo ClipBucketV5 easy installation script must be run as Administrator
    echo.
    pause
    exit /b
)

reg Query "HKLM\Hardware\Description\System\CentralProcessor\0" | find /i "x86" > NUL && set OS=32BIT || set OS=64BIT
if %OS%==32BIT (
   echo ClipBucketV5 easy installation script can only be used on 64bit operating system
   echo.
   pause
   exit /b
)

echo.
echo   ____ _ _       ____             _        _ __     ______
echo  / ___^| (_)_ __ ^| __ ) _   _  ___^| ^| _____^| ^|\ \   / / ___^|
echo ^| ^|   ^| ^| ^| '_ \^|  _ \^| ^| ^| ^|/ __^| ^|/ / _ \ __\ \ / /^|___ \
echo ^| ^|___^| ^| ^| ^|_) ^| ^|_) ^| ^|_^| ^| (__^|   ^<  __/ ^|_ \ V /  ___) ^|
echo  \____^|_^|_^| .__/^|____/ \__,_^|\___^|_^|\_\___^|\__^| \_/  ^|____/
echo           ^|_^| Installation script for Windows 10/11 + Nginx
echo.
echo Disclaimer : This easy installation script is only
echo              made to configure local / dev environments.
echo              Use it with caution.

echo.
SET "CB_DIR=C:\ClipBucketV5"
echo ClipBucketV5 will be installed in %CB_DIR% with all it's components
pause

SET "LOCAL_DOMAIN="
echo.
echo Which domain name do you want to use ? [clipbucket.local]
SET /p LOCAL_DOMAIN=
if "%LOCAL_DOMAIN%"=="" (
    SET "LOCAL_DOMAIN=clipbucket.local"
)

SET "EDIT_HOSTS="
echo.
echo Should installation script add entry in Windows hosts ? (Y/N) [Y]
SET /p EDIT_HOSTS=
if "%EDIT_HOSTS%"=="" (
    SET "EDIT_HOSTS=Y"
)

SET "WINDOWS_HOSTS=C:\Windows\System32\drivers\etc\hosts"
if "%EDIT_HOSTS%"=="Y" (
    echo. >> %WINDOWS_HOSTS%
    echo 127.0.0.1	%LOCAL_DOMAIN% >> %WINDOWS_HOSTS%
)

:install_root
echo.
echo |set /p=Creating root directory...
md %CB_DIR%
echo OK

:install_git
echo.
echo |set /p=Creating GIT directory...
SET "GIT_DIR=%CB_DIR%\git"
md %GIT_DIR%
echo OK
SET "GIT_VERSION=2.45.2"
echo |set /p=Downloading GIT %GIT_VERSION%...
SET "GIT_URL=https://github.com/git-for-windows/git/releases/download/v%GIT_VERSION%.windows.1/PortableGit-%GIT_VERSION%-64-bit.7z.exe"
SET "GIT_EXE_FILENAME=install_git.exe"
SET "GIT_EXE=%GIT_DIR%\%GIT_EXE_FILENAME%"
Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%GIT_URL%','%GIT_EXE%')"
echo OK
echo |set /p=Installing GIT...
start %GIT_EXE% -o"%GIT_DIR%" -y
:CheckGitProcess
timeout /t 2 /nobreak > NUL
FOR /F %%x IN ('tasklist /NH /FI "IMAGENAME eq %GIT_EXE_FILENAME%"') DO IF %%x == %GIT_EXE_FILENAME% goto CheckGitProcess
echo OK
echo |set /p=Deleting GIT file...
del %GIT_EXE%
echo OK

:install_mariadb
echo.
echo |set /p=Creating MariaDB directory...
SET "MARIADB_DIR=%CB_DIR%\mariadb"
md %MARIADB_DIR%
echo OK
SET "MARIADB_VERSION=11.6.0"
echo |set /p=Downloading MariaDB %MARIADB_VERSION%...
SET "MARIADB_URL=https://mirrors.ircam.fr/pub/mariadb/mariadb-%MARIADB_VERSION%/winx64-packages/mariadb-%MARIADB_VERSION%-winx64.zip"
SET "MARIADB_ZIP_FILENAME=mariadb-%MARIADB_VERSION%.zip"
SET "MARIADB_ZIP=%MARIADB_DIR%\%MARIADB_ZIP_FILENAME%"
Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%MARIADB_URL%','%MARIADB_ZIP%')"
echo OK
echo |set /p=Extracting MariaDB...
Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%MARIADB_ZIP%' '%MARIADB_DIR%'"
Powershell.exe -command "Move-Item %MARIADB_DIR%\mariadb-*\* %MARIADB_DIR%"
Powershell.exe -command "Remove-Item %MARIADB_DIR%\mariadb-*"
echo OK

:install_nginx
echo.
echo |set /p=Creating Nginx directory...
SET "NGINX_DIR=%CB_DIR%\nginx"
md %NGINX_DIR%
echo OK
SET "NGINX_VERSION=1.27.0"
echo |set /p=Downloading Nginx %NGINX_VERSION%...
SET "NGINX_URL=https://nginx.org/download/nginx-%NGINX_VERSION%.zip"
SET "NGINX_ZIP_FILENAME=nginx-%NGINX_VERSION%.zip"
SET "NGINX_ZIP=%NGINX_DIR%\%NGINX_ZIP_FILENAME%"
Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%NGINX_URL%','%NGINX_ZIP%')"
echo OK
echo |set /p=Extracting Nginx...
Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%NGINX_ZIP%' '%NGINX_DIR%'"
Powershell.exe -command "Move-Item %NGINX_DIR%\nginx-%NGINX_VERSION%*\* %NGINX_DIR%"
Powershell.exe -command "Remove-Item %NGINX_DIR%\nginx-%NGINX_VERSION%*"
echo OK

:install_php
echo.
echo |set /p=Creating PHP directory...
SET "PHP_DIR=%CB_DIR%\php"
md %PHP_DIR%
echo OK
SET "PHP_VERSION=8.3.12"
echo /!\ We're using PHP because PHP-FPM doesn't support Windows
echo |set /p=Downloading PHP %PHP_VERSION%...
SET "PHP_URL=https://windows.php.net/downloads/releases/php-%PHP_VERSION%-Win32-vs16-x64.zip"
SET "PHP_ZIP_FILENAME=php-%PHP_VERSION%.zip"
SET "PHP_ZIP=%PHP_DIR%\%PHP_ZIP_FILENAME%"
:: We're faking Edge useragent to prevent PHP website to block download
Powershell.exe -command "$cli = New-Object System.Net.WebClient; $cli.Headers['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.2210.91'; $cli.DownloadFile('%PHP_URL%', '%PHP_ZIP%')"
echo OK
echo |set /p=Extracting PHP...
Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%PHP_ZIP%' '%PHP_DIR%'"
Powershell.exe -command "Move-Item %PHP_DIR%\php-%PHP_VERSION%*\* %PHP_DIR%"
Powershell.exe -command "Remove-Item %PHP_DIR%\php-%PHP_VERSION%*"
echo OK

:install_ffmpeg
echo.
echo |set /p=Creating FFMpeg directory...
SET "FFMPEG_DIR=%CB_DIR%\ffmpeg"
md %FFMPEG_DIR%
echo OK
SET "FFMPEG_VERSION=7.0.2"
echo |set /p=Downloading FFMpeg %FFMPEG_VERSION%...
SET "FFMPEG_URL=https://github.com/GyanD/codexffmpeg/releases/download/%FFMPEG_VERSION%/ffmpeg-%FFMPEG_VERSION%-full_build.zip"
SET "FFMPEG_ZIP_FILENAME=ffmpeg-%FFMPEG_VERSION%.zip"
SET "FFMPEG_ZIP=%FFMPEG_DIR%\%FFMPEG_ZIP_FILENAME%"
Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%FFMPEG_URL%','%FFMPEG_ZIP%')"
echo OK
echo |set /p=Extracting FFMpeg...
Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%FFMPEG_ZIP%' '%FFMPEG_DIR%'"
Powershell.exe -command "Move-Item %FFMPEG_DIR%\ffmpeg-%FFMPEG_VERSION%*\* %FFMPEG_DIR%"
Powershell.exe -command "Remove-Item %FFMPEG_DIR%\ffmpeg-%FFMPEG_VERSION%*"
echo OK

:install_mediainfo
echo.
echo |set /p=Creating MediaInfo directory...
SET "MEDIAINFO_DIR=%CB_DIR%\mediainfo"
md %MEDIAINFO_DIR%
echo OK
SET "MEDIAINFO_VERSION=24.06"
echo |set /p=Downloading MediaInfo %MEDIAINFO_VERSION%...
SET "MEDIAINFO_URL=https://mediaarea.net/download/binary/mediainfo/%MEDIAINFO_VERSION%/MediaInfo_CLI_%MEDIAINFO_VERSION%_Windows_x64.zip"
SET "MEDIAINFO_ZIP_FILENAME=mediainfo-%MEDIAINFO_VERSION%.zip"
SET "MEDIAINFO_ZIP=%MEDIAINFO_DIR%\%MEDIAINFO_ZIP_FILENAME%"
Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%MEDIAINFO_URL%','%MEDIAINFO_ZIP%')"
echo OK
echo |set /p=Extracting MediaInfo...
Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%MEDIAINFO_ZIP%' '%MEDIAINFO_DIR%'"
Powershell.exe -command "Move-Item %MEDIAINFO_DIR%\mediainfo-*\* %MEDIAINFO_DIR%"
Powershell.exe -command "Remove-Item %MEDIAINFO_DIR%\mediainfo-*"
echo OK

:config_web
echo.
echo |set /p=Creating Web root directory...
SET "WEB_DIR=%CB_DIR%\www"
md %WEB_DIR%
echo OK

:install_clipbucket
echo.
echo |set /p=Downloading ClipBucketV5...
SET "CLIPBUCKETV5_URL=https://github.com/MacWarrior/clipbucket-v5.git"
start %GIT_DIR%\bin\git.exe clone %CLIPBUCKETV5_URL% %WEB_DIR% -q
echo OK

:config_mariadb
SET "MARIADB_DIR=%CB_DIR%\mariadb"

echo.
echo |set /p=Configuring MariaDB...
%MARIADB_DIR%\bin\mariadb-install-db.exe > NULL 2>&1
SET "MARIADB_SERVER_EXE=%MARIADB_DIR%\bin\mariadbd.exe"
start /wait %MARIADB_SERVER_EXE% --initialize-insecure > NULL 2>&1

start %MARIADB_SERVER_EXE% --console
timeout 10 > NUL

SET "MYSQL_BIN=%MARIADB_DIR%\bin\mysql.exe"
SET "DB_PASS=%RANDOM%-%RANDOM%-%RANDOM%"
%MYSQL_BIN% -u root -e "CREATE DATABASE clipbucket;"
%MYSQL_BIN% -u root -e "CREATE USER 'clipbucket'@'localhost' IDENTIFIED BY '%DB_PASS%';"
%MYSQL_BIN% -u root -e "GRANT ALL PRIVILEGES ON clipbucket.* TO 'clipbucket'@'localhost' IDENTIFIED BY '%DB_PASS%';"
%MYSQL_BIN% -u root -e "FLUSH PRIVILEGES;"

taskkill /IM mariadbd.exe > NULL
echo OK

:config_php
echo.
echo |set /p=Configuring PHP...
ren %PHP_DIR%\php.ini-development php.ini

set "PHP_INI_FILEPATH=%PHP_DIR%\php.ini"

set "SEARCH=;extension=curl"
set "REPLACEMENT=extension=curl"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=;extension=gd"
set "REPLACEMENT=extension=gd"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=;extension=mbstring"
set "REPLACEMENT=extension=mbstring"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=;extension=mysqli"
set "REPLACEMENT=extension=mysqli"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=;extension=openssl"
set "REPLACEMENT=extension=openssl"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=;extension=fileinfo"
set "REPLACEMENT=extension=fileinfo"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=;extension_dir = \"./\""
set "REPLACEMENT=extension_dir = \"%PHP_DIR%\ext\""
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

set "SEARCH=max_execution_time = 30"
set "REPLACEMENT=max_execution_time = 7200"
Powershell.exe -command "(Get-Content %PHP_INI_FILEPATH%) -replace '%SEARCH%', '%REPLACEMENT%' | Out-File -encoding UTF8 %PHP_INI_FILEPATH%"

echo OK

:config_nginx
echo.
echo |set /p=Configuring Nginx...
SET "NGINX_CONF=%NGINX_DIR%\conf\nginx.conf"

echo daemon off;> %NGINX_CONF%
echo worker_processes  1;>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo events {>> %NGINX_CONF%
echo     worker_connections  1024;>> %NGINX_CONF%
echo }>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo http {>> %NGINX_CONF%
echo     include       mime.types;>> %NGINX_CONF%
echo     default_type  application/octet-stream;>> %NGINX_CONF%
echo     sendfile        on;>> %NGINX_CONF%
echo     gzip  on;>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 	server {>> %NGINX_CONF%
echo 		listen 80;>> %NGINX_CONF%
echo 		server_name %LOCAL_DOMAIN%;>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		root "c:\\ClipBucketV5\\www\\upload\\";>> %NGINX_CONF%
echo 		index index.php;>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		client_max_body_size 2M;>> %NGINX_CONF%
echo 		fastcgi_send_timeout 7200s;>> %NGINX_CONF%
echo 		fastcgi_read_timeout 7200s;>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		# set expiration of assets to MAX for caching>> %NGINX_CONF%
echo 		location ~* \.(ico^|css^|js)(\?[0-9]+)?$ {>> %NGINX_CONF%
echo 			expires max;>> %NGINX_CONF%
echo 			log_not_found off;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location ~* \.php$ {>> %NGINX_CONF%
echo 			fastcgi_pass 127.0.0.1:9000;>> %NGINX_CONF%
echo 			fastcgi_index index.php;>> %NGINX_CONF%
echo 			fastcgi_split_path_info (.+\.php)(.*)$;>> %NGINX_CONF%
echo 			fastcgi_param SCRIPT_FILENAME $request_filename;>> %NGINX_CONF%
echo 			include fastcgi_params;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location / {>> %NGINX_CONF%
echo 			rewrite /(.*)_v([0-9]+) /watch_video.php?v=$2^&$query_string last;>> %NGINX_CONF%
echo 			rewrite /([a-zA-Z0-9-]+)/?$ /view_channel.php?uid=$1^&seo_diret=yes last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		error_page 404 /404;>> %NGINX_CONF%
echo 		error_page 403 /403;>> %NGINX_CONF%
echo 		location /403 {>> %NGINX_CONF%
echo 			try_files $uri /403.php;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo 		location /404 {>> %NGINX_CONF%
echo 			try_files $uri /404.php;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /includes/ {>> %NGINX_CONF%
echo 			return 302 /404;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /changelog/ {>> %NGINX_CONF%
echo 			return 302 /404;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /video/ {>> %NGINX_CONF%
echo 			rewrite ^^/video/(.*)/(.*) /watch_video.php?v=$1^&$query_string last;>> %NGINX_CONF%
echo 			rewrite ^^/video/([0-9]+)_(.*) /watch_video.php?v=$1^&$query_string last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /videos/ {>> %NGINX_CONF%
echo 			rewrite ^^/videos/(.*)/(.*)/(.*)/(.*)/(.*) /videos.php?cat=$1^&sort=$3^&time=$4^&page=$5^&seo_cat_name=$2 last;>> %NGINX_CONF%
echo 			rewrite ^^/videos/([0-9]+) /videos.php?page=$1 last;>> %NGINX_CONF%
echo 			rewrite ^^/videos/?$ /videos.php?$query_string last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /channels/ {>> %NGINX_CONF%
echo 			rewrite ^^/channels/(.*)/(.*)/(.*)/(.*)/(.*) /channels.php?cat=$1^&sort=$3^&time=$4^&page=$5^&seo_cat_name=$2 last;>> %NGINX_CONF%
echo 			rewrite ^^/channels/([0-9]+) /channels.php?page=$1 last;>> %NGINX_CONF%
echo 			rewrite ^^/channels/?$ /channels.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /members/ {>> %NGINX_CONF%
echo 			rewrite ^^/members/?$ /channels.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /users/ {>> %NGINX_CONF%
echo 			rewrite ^^/users/?$ /channels.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /user/ {>> %NGINX_CONF%
echo 			rewrite ^^/user/(.*) /view_channel.php?user=$1 last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /channel/ {>> %NGINX_CONF%
echo 			rewrite ^^/channel/(.*) /view_channel.php?user=$1 last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /my_account {>> %NGINX_CONF%
echo 			rewrite ^^/my_account /myaccount.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /page/ {>> %NGINX_CONF%
echo 			rewrite ^^/page/([0-9]+)/(.*) /view_page.php?pid=$1 last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /search/ {>> %NGINX_CONF%
echo 			rewrite ^^/search/result/?$ /search_result.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /upload {>> %NGINX_CONF%
echo 			rewrite ^^/upload/?$ /upload.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /contact/ {>> %NGINX_CONF%
echo 			rewrite ^^/contact/?$ /contact.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /categories/ {>> %NGINX_CONF%
echo 			rewrite ^^/categories/?$ /categories.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /collections/ {>> %NGINX_CONF%
echo 			rewrite ^^/collections/(.*)/(.*)/(.*)/(.*)/(.*) /collections.php?cat=$1^&sort=$3^&time=$4^&page=$5^&seo_cat_name=$2 last;>> %NGINX_CONF%
echo 			rewrite ^^/collections/([0-9]+) /collections.php?page=$1 last;>> %NGINX_CONF%
echo 			rewrite ^^/collections/?$ /collections.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /photos/ {>> %NGINX_CONF%
echo 			rewrite ^^/photos/(.*)/(.*)/(.*)/(.*)/(.*) /photos.php?cat=$1^&sort=$3^&time=$4^&page=$5^&seo_cat_name=$2 last;>> %NGINX_CONF%
echo 			rewrite ^^/photos/([0-9]+) /photos.php?page=$1 last;>> %NGINX_CONF%
echo 			rewrite ^^/photos/?$ /photos.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /collection/ {>> %NGINX_CONF%
echo 			rewrite ^^/collection/(.*)/(.*)/(.*) /view_collection.php?cid=$1^&type=$2^&page=$3 last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /item/ {>> %NGINX_CONF%
echo 			rewrite ^^/item/(.*)/(.*)/(.*)/(.*) /view_item.php?item=$3^&type=$1^&collection=$2 last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /photo_upload {>> %NGINX_CONF%
echo 			rewrite ^^/photo_upload/(.*) /photo_upload.php?collection=$1 last;>> %NGINX_CONF%
echo 			rewrite ^^/photo_upload/?$ /photo_upload.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location = /sitemap.xml {>> %NGINX_CONF%
echo 			rewrite ^^(.*)$ /sitemap.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /signup {>> %NGINX_CONF%
echo 			rewrite ^^/signup/?$ /signup.php last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /rss/ {>> %NGINX_CONF%
echo 			rewrite ^^/rss/([a-zA-Z0-9].+)$ /rss.php?mode=$1^&$query_string last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location /list/ {>> %NGINX_CONF%
echo 			rewrite ^^/list/([0-9]+)/(.*)?$ /view_playlist.php?list_id=$1 last;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo. >> %NGINX_CONF%
echo 		location ~ /rss$ {>> %NGINX_CONF%
echo 			try_files $uri /rss.php;>> %NGINX_CONF%
echo 		}>> %NGINX_CONF%
echo 	}>> %NGINX_CONF%
echo }>> %NGINX_CONF%

echo OK

:setup_script
echo.
echo Configuring server start script...
SET "START_SCRIPT=%CB_DIR%\start.bat"

echo start %PHP_DIR%\php-cgi.exe -b 127.0.0.1:9000 -c %PHP_DIR%\php.ini >> %START_SCRIPT%
echo start cmd.exe /k "cd %NGINX_DIR% & %NGINX_DIR%\nginx.exe" >> %START_SCRIPT%
echo start %MARIADB_SERVER_EXE% --console >> %START_SCRIPT%

:end
echo.
echo You can now start server by launching %CB_DIR%\start.bat
echo.

echo - Database address : localhost
echo - Database name : clipbucket
echo - Database user : clipbucket
echo - Database port : 3306
echo - Database password : %DB_PASS%
echo - Install directory : %CB_DIR%
echo - Website URL : http://%LOCAL_DOMAIN%
echo.
pause
