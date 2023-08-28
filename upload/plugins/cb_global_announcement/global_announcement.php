<?php
/*
    Plugin Name: CB - Global announcement
    Description: This will let you post a global announcement on your website
    Author: Arslan Hassan & MacWarrior
    Version: 2.0.2
    Website: https://github.com/MacWarrior/clipbucket-v5/
    ClipBucket Version: 5.5.0
*/

class cb_global_announcement
{
    public static $template_dir = PLUG_DIR.DIRECTORY_SEPARATOR.self::class.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR;
    public static $table_name = 'plugin_'.self::class;
    public static $pages_url = PLUG_URL.'/'.self::class.'/pages/';
    public static $lang_prefix = 'plugin_'.self::class.'_';

    /**
     * @throws Exception
     */
    function __construct(){
        if (has_access('admin_access', true)) {
            $this->addAdminMenu();
        }
        $this->register_anchor_function();
    }

    /**
     * @throws Exception
     */
    private function addAdminMenu(){
        add_admin_menu('Plugin Manager', lang($this::$lang_prefix.'menu'), self::$pages_url.'edit_announcement.php');
    }

    private function register_anchor_function(){
        register_anchor_function('get_global_announcement', 'global', self::class);
    }

    /**
     * @throws Exception
     */
    public static function get_global_announcement($display = true)
    {
        global $db;
        $results = $db->select(tbl(self::$table_name), '*');
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
    public static function update_announcement($text)
    {
        global $db;
        $textCheck = str_replace(['<p>', '</p>', '<br>'], '', $text);
        if (strlen($textCheck) < 1) {
            $text = '';
        }
        $db->execute('UPDATE ' . tbl(self::$table_name) . ' SET announcement=\'' . mysql_clean($text) . '\'');
    }

}

new cb_global_announcement();
