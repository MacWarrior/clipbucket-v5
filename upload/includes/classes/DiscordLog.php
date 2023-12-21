<?php

class DiscordLog extends \OxygenzSAS\Discord\Discord
{
    private static $discordLog;

    const FILE_NAME = TEMP_DIR . DIRECTORY_SEPARATOR . 'discord.webhook';
    const FILE_NAME_DISABLED =  TEMP_DIR . DIRECTORY_SEPARATOR . 'discord.webhook_disabled';

    const APP_NAME = 'ClipBucket';

    /**
     * @return DiscordLog|null
     */
    public static function getInstance()
    {
        if( empty(self::$discordLog) ){
            if (!file_exists(self::FILE_NAME)) {
                return null;
            }
            $url = file_get_contents(self::FILE_NAME);
            if (empty($url)) {
                return null;
            }
            self::$discordLog = new self($url, self::APP_NAME);
        }
        return self::$discordLog;
    }

    /**
     * @param $var mixed the var to dump
     * @return bool
     */
    public static function sendDump($var): bool
    {
        $obj = self::getInstance();
        if (empty($obj)) {
            return false;
        }
        if (is_string($var) ) {
            $obj->debug($var);
        } else {
            $obj->debug('', [$var]);
        }
        return true;
    }

    public static function enable($url)
    {
        if (is_writable(BASEDIR . '/includes')) {
            if (file_exists(self::FILE_NAME_DISABLED)) {
                rename(self::FILE_NAME_DISABLED, self::FILE_NAME);
            }
            file_put_contents(self::FILE_NAME, $url);
        } else {
            e('"includes" directory is not writeable');
        }
    }

    public static function disable()
    {
        if (file_exists(self::FILE_NAME)) {
            rename(self::FILE_NAME, self::FILE_NAME_DISABLED);
        } else {
            e('"includes" directory is not writeable');
        }
    }

    public static function isEnabled(): bool
    {
        if (!file_exists(self::FILE_NAME)) {
            return false;
        }
        $url = file_get_contents(self::FILE_NAME);
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        return true;
    }

    public static function getCurrentUrl(): string
    {
        if (file_exists(self::FILE_NAME)) {
            return $url = file_get_contents(self::FILE_NAME);
        }
        if (file_exists(self::FILE_NAME_DISABLED)) {
            return $url = file_get_contents(self::FILE_NAME_DISABLED);
        }
        return '';
    }
}
