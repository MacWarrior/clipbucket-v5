<?php

class DiscordLog extends \OxygenzSAS\Discord\Discord
{
    private static $discordLog;
    private $app_name = '';
    private $filepath = '';
    private $filepath_disabled = '';

    public function __construct()
    {
        $site_title = '';
        if( function_exists('config') ){
            $site_title = config('site_title');
        }
        if( empty($site_title) ){
            $site_title = $_SERVER['HTTP_HOST'];
        }
        $this->app_name = $site_title;
        $this->filepath = DirPath::get('temp') . 'discord.webhook';
        $this->filepath_disabled = $this->filepath . '_disabled';

        if (!file_exists($this->filepath)) {
            return null;
        }
        $url = file_get_contents($this->filepath);
        if (empty($url)) {
            return null;
        }

        self::$discordLog = parent::__construct($url, $this->app_name);
        return self::$discordLog;
    }

    /**
     * @return DiscordLog|null
     */
    public static function getInstance()
    {
        if( empty(self::$discordLog) ){
            self::$discordLog = new self();
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

    public function enable($url)
    {
        if (is_writable(DirPath::get('temp'))) {
            if (file_exists($this->filepath_disabled)) {
                rename($this->filepath_disabled, $this->filepath);
            }
            file_put_contents($this->filepath, $url);
        } else {
            e('"temp" directory is not writeable');
        }
    }

    public function disable()
    {
        if (file_exists(DirPath::get('temp'))) {
            rename($this->filepath, $this->filepath_disabled);
        } else {
            e('"temp" directory is not writeable');
        }
    }

    public function isEnabled(): bool
    {
        if (!file_exists($this->filepath)) {
            return false;
        }
        $url = file_get_contents($this->filepath);
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        return true;
    }

    public function getCurrentUrl(): string
    {
        if (file_exists($this->filepath)) {
            return file_get_contents($this->filepath);
        }
        if (file_exists($this->filepath_disabled)) {
            return file_get_contents($this->filepath_disabled);
        }
        return '';
    }
}
