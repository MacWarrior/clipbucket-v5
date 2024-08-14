<?php
/*
    Plugin Name: Social Networks
    Description: Display links to your social networks in footer
    Author: MacWarrior
    Website: https://github.com/MacWarrior/clipbucket-v5/
    Version: 1.0.0
    ClipBucket Version: 5.5.1
*/

class cb_social_networks
{
    private static $plugin;
    public $template_dir = '';
    public $asset_dir = '';
    public $pages_url = '';
    public static $table_name = 'plugin_' . self::class;
    public static $lang_prefix = 'plugin_' . self::class . '_';

    /**
     * @throws Exception
     */
    function __construct(){
        $this->template_dir = DirPath::get('plugins') . self::class . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;
        $this->asset_dir = self::class . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $this->pages_url = DirPath::getUrl('plugins') . self::class . '/pages/';
        if (has_access('admin_access', true)) {
            $this->addAdminMenu();
        }
        $this->register_anchor_function();
        $this->add_css();
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
    private function addAdminMenu(){
        add_admin_menu('Plugin Manager', lang($this::$lang_prefix.'menu'), $this->pages_url.'social_networks.php');
    }

    private function register_anchor_function(){
        // TODO : REPLACE ANCHORS
        //register_anchor_function('displayAllVertical', 'global', self::class);
        register_anchor_function('displayAll', 'before_footer_elements', self::class);
    }

    /**
     * @throws Exception
     */
    private function add_css(){
        $min_suffixe = in_dev() ? '' : '.min';
        ClipBucket::getInstance()->addCSS([
            self::class.'/assets/css/social_networks' . $min_suffixe . '.css' => 'plugin'
        ]);
    }

    /**
     * @throws Exception
     */
    public static function getAll()
    {
        return Clipbucket_db::getInstance()->select(tbl(self::$table_name), '*', "id != 0")[0];
    }

    /**
     * @throws Exception
     */
    public static function displayAll(bool $vertical = false)
    {
        $links = self::getAll();
        if ($vertical) {
            $class = "class='vertical-social'";
        } else {
            $class = '';
        }

        echo "<ul id='social_networks_links' $class>";
        foreach ($links as $name => $daLink) {
            if (empty($daLink)) {
                continue;
            }
            echo "<li><a href=" . $daLink . "><i class='fa fa-" . $name . "'></i> " . ucfirst($name) . "</a></li>";
        }
        echo "</ul>";
    }

    /**
     * @throws Exception
     */
    public static function displayAllVertical()
    {
        self::displayAll(true);
    }
}

new cb_social_networks();
