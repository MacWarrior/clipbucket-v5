<?php
/*
    Plugin Name: CB - Global announcement
    Description: This will let you post a global announcement on your website
    Author: Arslan Hassan & MacWarrior
    Version: 2.0.6
    Website: https://github.com/MacWarrior/clipbucket-v5/
    ClipBucket Version: 5.5.2
*/

class cb_global_announcement
{
    private static self $plugin;
    public string $template_dir = '';
    public string $pages_url = '';
    public static string $table_name = 'plugin_' . self::class;
    public static string $lang_prefix = 'plugin_' . self::class . '_';

    /**
     * @throws Exception
     */
    function __construct(){
        $this->template_dir = DirPath::get('plugins') . self::class . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;
        $this->pages_url = DirPath::getUrl('plugins') . self::class . '/pages/';
        if (User::getInstance()->hasAdminAccess()) {
            $this->addAdminMenu();
        }
        $this->register_anchor_function();
    }

    public static function getInstance(): self
    {
        if( empty(self::$plugin) ){
            self::$plugin = new self();
        }
        return self::$plugin;
    }

    /**
     * @throws Exception
     */
    private function addAdminMenu(): void
    {
        add_admin_menu(lang('configurations'), lang($this::$lang_prefix.'menu'), $this->pages_url.'edit_announcement.php');
    }

    private function register_anchor_function(): void
    {
        register_anchor_function('get_global_announcement', 'global', self::class);
    }

    /**
     * @throws Exception
     */
    public static function get_global_announcement($display = true)
    {
        $results = Clipbucket_db::getInstance()->select(tbl(self::$table_name), '*');
        $announce = $results[0]['announcement'];

        if( !$display ){
            return $announce ?? '';
        }

        if( !empty($announce) ){
            echo '<div class="alert alert-info margin-bottom-10 ">' . $announce . '</div>';
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public static function update_announcement($text): void
    {
        $textCheck = str_replace(['<p>', '</p>', '<br>'], '', $text);
        if (strlen($textCheck) < 1) {
            $text = '';
        }
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl(self::$table_name) . ' SET announcement=\'' . mysql_clean($text) . '\'');
    }

}

new cb_global_announcement();
