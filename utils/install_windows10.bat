@echo off
cls

net session >nul 2>&1
if %errorLevel% NEQ 0 (
    echo ClipBucketV5 easy installation script must be run as Administrator
    echo.
    pause
    exit /b
)

echo.
echo   ____ _ _       ____             _        _ __     ______
echo  / ___^| (_)_ __ ^| __ ) _   _  ___^| ^| _____^| ^|\ \   / / ___^|
echo ^| ^|   ^| ^| ^| '_ \^|  _ \^| ^| ^| ^|/ __^| ^|/ / _ \ __\ \ / /^|___ \\
echo ^| ^|___^| ^| ^| ^|_) ^| ^|_) ^| ^|_^| ^| (__^|   ^<  __/ ^|_ \ V /  ___) ^|
echo  \____^|_^|_^| .__/^|____/ \__,_^|\___^|_^|\_\___^|\__^| \_/  ^|____/
echo           ^|_^|  Installation script for Windows 10 + Nginx
echo.
echo Disclaimer : This easy installation script is only
echo              made to configure local / dev environments.
echo              Use it with caution.

echo.
SET "CB_DIR=C:\ClipBucketV5"
echo ClipBucketV5 will be installed in %CB_DIR% with all it's components
pause

echo |set /p=Creating root directory...
::md %CB_DIR%
echo OK

echo.
echo |set /p=Creating GIT directory...
SET "GIT_DIR=%CB_DIR%\git"
::md %GIT_DIR%
echo OK

echo |set /p=Downloading GIT 2.43.0 install...
SET "GIT_URL=https://github.com/git-for-windows/git/releases/download/v2.43.0.windows.1/PortableGit-2.43.0-64-bit.7z.exe"
SET "GIT_EXE_FILENAME=install_git.exe"
SET "GIT_EXE=%GIT_DIR%\%GIT_EXE_FILENAME%"
::Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%GIT_URL%','%GIT_EXE%')"
echo OK

echo |set /p=Installing GIT...
::start %GIT_EXE% -o"%GIT_DIR%" -y
:CheckGitProcess
::timeout /t 2 /nobreak > NUL
::FOR /F %%x IN ('tasklist /NH /FI "IMAGENAME eq %GIT_EXE_FILENAME%"') DO IF %%x == %GIT_EXE_FILENAME% goto CheckGitProcess
echo OK

echo |set /p=Deleting GIT install file...
::del %GIT_EXE%
echo OK

echo.
echo |set /p=Creating MariaDB directory...
SET "MARIADB_DIR=%CB_DIR%\mariadb"
::md %MARIADB_DIR%
echo OK

echo |set /p=Downloading MariaDB 11.2.2 install...
SET "MARIADB_URL=https://mirrors.ircam.fr/pub/mariadb/mariadb-11.2.2/winx64-packages/mariadb-11.2.2-winx64.zip"
SET "MARIADB_ZIP_FILENAME=mariadb-11.2.2.zip"
SET "MARIADB_ZIP=%MARIADB_DIR%\%MARIADB_ZIP_FILENAME%"
::Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%MARIADB_URL%','%MARIADB_ZIP%')"
echo OK

echo |set /p=Extracting MariaDB...
::Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%MARIADB_ZIP%' '%MARIADB_DIR%'"
::Powershell.exe -command "Move-Item %MARIADB_DIR%\mariadb-*\* %MARIADB_DIR%"
::Powershell.exe -command "Remove-Item %MARIADB_DIR%\mariadb-*"
echo OK

echo.
echo |set /p=Creating Nginx directory...
SET "NGINX_DIR=%CB_DIR%\nginx"
::md %NGINX_DIR%
echo OK

echo |set /p=Downloading Nginx 1.25.3 install...
SET "NGINX_URL=https://nginx.org/download/nginx-1.25.3.zip"
SET "NGINX_ZIP_FILENAME=nginx-1.25.3.zip"
SET "NGINX_ZIP=%NGINX_DIR%\%NGINX_ZIP_FILENAME%"
::Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%NGINX_URL%','%NGINX_ZIP%')"
echo OK

echo |set /p=Extracting Nginx...
::Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%NGINX_ZIP%' '%NGINX_DIR%'"
::Powershell.exe -command "Move-Item %NGINX_DIR%\nginx-*\* %NGINX_DIR%"
::Powershell.exe -command "Remove-Item %NGINX_DIR%\nginx-*"
echo OK

echo.
echo |set /p=Creating PHP directory...
SET "PHP_DIR=%CB_DIR%\php"
::md %PHP_DIR%
echo OK

echo |set /p=Downloading PHP 8.3.1 install...
SET "PHP_URL=https://windows.php.net/downloads/releases/php-8.3.1-Win32-vs16-x64.zip"
SET "PHP_ZIP_FILENAME=php-8.3.1.zip"
SET "PHP_ZIP=%PHP_DIR%\%PHP_ZIP_FILENAME%"
:: We're faking Edge useragent to prevent PHP website to block download
::Powershell.exe -command "$cli = New-Object System.Net.WebClient; $cli.Headers['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.2210.91'; $cli.DownloadFile('%PHP_URL%', '%PHP_ZIP%')"
echo OK

echo |set /p=Extracting PHP...
::Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%PHP_ZIP%' '%PHP_DIR%'"
::Powershell.exe -command "Move-Item %PHP_DIR%\php-*\* %PHP_DIR%"
::Powershell.exe -command "Remove-Item %PHP_DIR%\php-*"
echo OK

echo.
echo |set /p=Creating FFMpeg directory...
SET "FFMPEG_DIR=%CB_DIR%\ffmpeg"
::md %FFMPEG_DIR%
echo OK

echo |set /p=Downloading FFMpeg 6.1.1 install...
SET "FFMPEG_URL=https://github.com/GyanD/codexffmpeg/releases/download/6.1.1/ffmpeg-6.1.1-full_build.zip"
SET "FFMPEG_ZIP_FILENAME=ffmpeg-6.1.1.zip"
SET "FFMPEG_ZIP=%FFMPEG_DIR%\%FFMPEG_ZIP_FILENAME%"
::Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%FFMPEG_URL%','%FFMPEG_ZIP%')"
echo OK

echo |set /p=Extracting FFMpeg...
::Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%FFMPEG_ZIP%' '%FFMPEG_DIR%'"
::Powershell.exe -command "Move-Item %FFMPEG_DIR%\ffmpeg-*\* %FFMPEG_DIR%"
::Powershell.exe -command "Remove-Item %FFMPEG_DIR%\ffmpeg-*"
echo OK

echo.
echo |set /p=Creating MediaInfo directory...
SET "MEDIAINFO_DIR=%CB_DIR%\mediainfo"
::md %MEDIAINFO_DIR%
echo OK

echo |set /p=Downloading MediaInfo 23.11.1 install...
SET "MEDIAINFO_URL=https://mediaarea.net/download/binary/mediainfo/23.11.1/MediaInfo_CLI_23.11.1_Windows_x64.zip"
SET "MEDIAINFO_ZIP_FILENAME=mediainfo-23.11.1.zip"
SET "MEDIAINFO_ZIP=%MEDIAINFO_DIR%\%MEDIAINFO_ZIP_FILENAME%"
::Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%MEDIAINFO_URL%','%MEDIAINFO_ZIP%')"
echo OK

echo |set /p=Extracting MediaInfo...
::Powershell.exe -command "$ProgressPreference = 'SilentlyContinue'; Expand-Archive -Force '%MEDIAINFO_ZIP%' '%MEDIAINFO_DIR%'"
::Powershell.exe -command "Move-Item %MEDIAINFO_DIR%\mediainfo-*\* %MEDIAINFO_DIR%"
::Powershell.exe -command "Remove-Item %MEDIAINFO_DIR%\mediainfo-*"
echo OK

echo.
echo |set /p=Creating Web root directory...
SET "WEB_DIR=%CB_DIR%\www"
::md %WEB_DIR%
echo OK

echo |set /p=Downloading ClipBucketV5 install...
SET "CLIPBUCKETV5_URL=https://github.com/MacWarrior/clipbucket-v5.git"
SET "MEDIAINFO_ZIP_FILENAME=mediainfo-23.11.1.zip"
SET "MEDIAINFO_ZIP=%MEDIAINFO_DIR%\%MEDIAINFO_ZIP_FILENAME%"
::Powershell.exe -command "(New-Object System.Net.WebClient).DownloadFile('%MEDIAINFO_URL%','%MEDIAINFO_ZIP%')"
::start %GIT_DIR%\bin\git.exe -clone %CLIPBUCKETV5_URL% -q
echo OK

:: TODO
:: - Configuring PHP extensions & settings
:: - Configuring Nginx & Vhost
:: - Configuring Windows Hosts