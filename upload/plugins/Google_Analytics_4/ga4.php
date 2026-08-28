<?php
/*
    Plugin Name: Google Analytics 4
    Description: Adds Google Analytics 4 and HTML5/Video.js video engagement tracking to ClipBucket V5.
    Author: ZakHao
    Website: https://www.loonervideo.com/
    Version: 1.1.2
    ClipBucket Version: 5.5.3
*/

class ga4
{
    private static self $plugin;
    public string $template_dir = '';
    public static string $table_name = 'plugin_' . self::class;

    public function __construct()
    {
        $this->template_dir = DirPath::get('plugins') . basename(__DIR__) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;

        if (User::getInstance()->hasAdminAccess()) {
            $this->addAdminMenu();
        }

        $config = self::getConfig();
        assign('ga4_measurement_id', htmlspecialchars($config['measurement_id'] ?? '', ENT_QUOTES, 'UTF-8'));
        assign('ga4_enabled', $config['enabled'] ?? 'no');
        add_header($this->template_dir . 'ga4_header.html');
    }

    public static function getInstance(): self
    {
        if (empty(self::$plugin)) {
            self::$plugin = new self();
        }
        return self::$plugin;
    }

    private function addAdminMenu(): void
    {
        add_admin_menu(
            lang('configurations'),
            'Google Analytics 4',
            DirPath::getUrl('plugins') . basename(__DIR__) . '/admin/ga4_config.php'
        );
    }

    public static function getConfig(): array
    {
        $results = Clipbucket_db::getInstance()->select(tbl(self::$table_name), '*');
        return $results[0] ?? ['enabled' => 'no', 'measurement_id' => ''];
    }

    public static function updateConfig($enabled, $measurement_id): void
    {
        $enabled = $enabled === 'yes' ? 'yes' : 'no';
        $measurement_id = trim((string)$measurement_id);

        if ($enabled === 'yes' && !preg_match('/^G-[A-Z0-9]+$/i', $measurement_id)) {
            throw new Exception('Please enter a valid GA4 Measurement ID, for example G-XXXXXXXXXX.');
        }

        $sql = 'UPDATE ' . tbl(self::$table_name)
            . " SET enabled='" . mysql_clean($enabled) . "', measurement_id='" . mysql_clean($measurement_id) . "'";
        Clipbucket_db::getInstance()->execute($sql);
    }
}

ga4::getInstance();
