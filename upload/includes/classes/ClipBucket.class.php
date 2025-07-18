<?php
class ClipBucket
{
    private static self $instance;
    public static function getInstance(): self
    {
        if( empty(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public $custom_video_file_funcs;

    var $JSArray = [];
    var $AdminJSArray = [];
    var $CSSArray = [];
    var $AdminCSSArray = [];
    var $actionList = [];
    var $anchorList = [];
    var $ids = []; //IDS WILL BE USED FOR JS FUNCTIONS
    var $AdminMenu = [];
    var $configs = [];
    var $header_files = []; // these files will be included in <head> tag
    var $admin_header_files = []; // these files will be included in <head> tag
    var $anchor_function_list = [];
    var $show_page = true;
    var $upload_opt_list = []; //this will have array of upload opts like upload file, emebed or remote upload
    var $temp_exts = []; //Temp extensions
    var $actions_play_video = [];
    var $template_files = [];
    var $links = [];
    var $captchas = [];
    var $clipbucket_footer = [];
    var $clipbucket_functions = [];
    var $head_menu = [];
    var $foot_menu = [];
    var $template = '';
    var $cbinfo = [];
    var $search_types = [];

    /**
     * All Functions that are called
     * before after converting a video
     * are saved in these arrays
     */
    var $after_convert_functions = [];

    /**
     * This array contains
     * all functions that are called
     * when we call video to play on watch_video page
     */
    var $watch_video_functions = [];

    /**
     * Email Function list
     */
    var $email_functions = [];

    /**
     * This array contains
     * all functions that are called
     * on CBvideo::remove_files
     */
    var $on_delete_video = [];

    //This array contains the public pages name for private access to website 
    var $public_pages = ["signup", "view_page"];

    /**
     * @throws Exception
     */
    function __construct()
    {
        //Assign Configs
        $this->configs = $this->get_configs();

        //This is used to create Admin Menu
        //Updating Upload Options		
        $this->temp_exts = ['ahz', 'jhz', 'abc', 'xyz', 'cb2', 'tmp', 'olo', 'oar', 'ozz'];
        $this->template = $this->configs['template_dir'];

        if (!defined("IS_CAPTCHA_LOADING")) {
            $_SESSION['total_captchas_loaded'] = 0;
        }

        $this->clean_requests();

        if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
            $_GET['page'] = 1;
        }

        $filepath_custom_css = DirPath::get('files') . 'custom.css';
        if( file_exists($filepath_custom_css) ){
            $this->addCSS(['custom.css' => 'custom']);
        }
    }

    /**
     * @throws Exception
     */
    function addJS($files): void
    {
        $this->addFile($this->JSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAdminJS($files): void
    {
        $this->addFile($this->AdminJSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAllJS($files): void
    {
        $this->addFile($this->JSArray, $files);
        $this->addFile($this->AdminJSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addCSS($files): void
    {
        $this->addFile($this->CSSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAdminCSS($files): void
    {
        $this->addFile($this->AdminCSSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAllCSS($files): void
    {
        $this->addFile($this->CSSArray, $files);
        $this->addFile($this->AdminCSSArray, $files);
    }

    /**
     * @throws Exception
     */
    private function addFile(&$array_var, $files): void
    {
        $cache_key = $this->getCacheKey();
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if (!isset($array_var[$key])) {
                    $array_var[$key . '?v=' . $cache_key] = $file;
                }
            }
        } else {
            if (!isset($array_var[$files])) {
                $array_var[$files . '?v=' . $cache_key] = 'global';
            }
        }
    }

    public function getCacheKey()
    {
        if(System::isInDev()){
            $cache_key = time();
        } else {
            $cache_key = str_replace('.', '', Update::getInstance()->getCurrentCoreVersion()) . Update::getInstance()->getCurrentCoreRevision();
        }
        return $cache_key;
    }

    /**
     * Function add_header()
     * this will be used to add new files in header array
     * this is basically for plugins
     *
     * @param $file
     * @param string $place
     */
    function add_header($file, $place = 'global'): void
    {
        if (!is_array($place)) {
            $place = [$place];
        }
        $this->header_files[$file] = $place;
    }

    /**
     * Function add_admin_header()
     * this will be used to add new files in header array
     * this is basically for plugins
     *
     * @param $file
     * @param string $place
     */
    function add_admin_header($file, $place = 'global'): void
    {
        if (!is_array($place)) {
            $place = [$place];
        }
        $this->admin_header_files[$file] = $place;
    }

    /**
     * Function used to get list of function of any type
     *
     * @param : type (category,title,date etc)
     *
     * @return mixed
     */
    function getFunctionList($type)
    {
        return $this->actionList[$type];
    }

    /**
     * Function used to get anchors that are registered in plugins
     *
     * @param $place
     *
     * @return bool|mixed
     */
    function get_anchor_codes($place)
    {
        //Getting list of codes available for $place
        if (isset($this->anchorList[$place])) {
            return $this->anchorList[$place];
        }
        return false;
    }

    /**
     * Function used to get function of anchors that are registered in plugins
     *
     * @param $place
     *
     * @return bool|mixed
     */
    function get_anchor_function_list($place)
    {
        //Getting list of functions
        $place = $this->anchor_function_list[$place];
        $all = $this->anchor_function_list['*'];

        $funcs = array_merge($place ?? [], $all ?? []);
        return !empty($funcs) ? $funcs : false;
    }

    function addMenuAdmin($menu_params, $order = null): void
    {
        $menu_already_exists = false;

        if (is_null($order)) {
            if( empty(self::getInstance()->AdminMenu) ){
                $order = 1;
            } else {
                $order = max(array_keys(self::getInstance()->AdminMenu)) + 1;
            }
        } else {
            if (array_key_exists($order, self::getInstance()->AdminMenu)) {
                do {
                    $order++;
                } while (array_key_exists($order, self::getInstance()->AdminMenu));
            }
        }

        foreach (self::getInstance()->AdminMenu as &$menu) {
            if ($menu['title'] == $menu_params['title']) {
                foreach ($menu_params['sub'] as $subMenu) {
                    $submenu_already_exists = false;

                    foreach ($menu['sub'] as $tmp_submenu) {
                        if ($tmp_submenu['title'] == $subMenu['title'] && $tmp_submenu['url'] == $subMenu['url']) {
                            $submenu_already_exists = true;
                            break;
                        }
                    }

                    if (!$submenu_already_exists) {
                        $menu['sub'][] = $subMenu;
                    }
                }
                $menu_already_exists = true;
            }
        }
        if (!$menu_already_exists) {
            self::getInstance()->AdminMenu[$order] = $menu_params;
        }
        ksort(self::getInstance()->AdminMenu);
    }

    /**
     * @throws Exception
     */
    function initAdminMenu(): void
    {
        $menu_dashboard = [
            'title'   => 'Dashboard'
            , 'class' => 'glyphicon glyphicon-dashboard'
            , 'url'   => DirPath::getUrl('admin_area') . 'index.php'
        ];
        $this->addMenuAdmin($menu_dashboard, 1);

        $menu_configuration = [
            'title'   => lang('configurations')
            , 'class' => 'icon- fa fa-cog'
            , 'sub'   => []
        ];
        $menu_configuration['sub'][] = [
            'title' => lang('basic_settings')
            , 'url' => DirPath::getUrl('admin_area') . 'setting_basic.php'
        ];
        $menu_configuration['sub'][] = [
            'title' => lang('advanced_settings')
            , 'url' => DirPath::getUrl('admin_area') . 'setting_advanced.php'
        ];

        $menu_configuration['sub'][] = [
            'title' => lang('template_editor')
            , 'url' => DirPath::getUrl('admin_area') . 'template_editor.php'
        ];

        $menu_configuration['sub'][] = [
            'title' => lang('manage_x', strtolower(lang('pages')))
            , 'url' => DirPath::getUrl('admin_area') . 'manage_pages.php'
        ];

        $menu_configuration['sub'][] = [
            'title' => lang('languages_settings')
            , 'url' => DirPath::getUrl('admin_area') . 'language_settings.php'
        ];

        $menu_configuration['sub'][] = [
            'title' => lang('watermark_settings')
            , 'url' => DirPath::getUrl('admin_area') . 'photo_settings.php?mode=watermark_settings'
        ];

        $menu_configuration['sub'][] = [
            'title' => lang('manage_social_networks_links')
            , 'url' => DirPath::getUrl('admin_area') . 'manage_social_networks.php'
        ];

        if (User::getInstance()->hasPermission('allow_manage_user_level') || userquery::getInstance()->level == 1) {
            $menu_configuration['sub'][] = [
                'title' =>  lang('manage_x',strtolower(lang('user_levels')))
                , 'url' => DirPath::getUrl('admin_area') . 'user_levels.php'
            ];
        }

        global $cbplugin;
        $plugins_available = count($cbplugin->getNewPlugins());
        $plugins_installed = count($cbplugin->getInstalledPlugins());
        $plugins_count = $plugins_available + $plugins_installed;
        if (User::getInstance()->hasPermission('plugins_moderation') && ($plugins_count >= 1 || System::isInDev())) {
            $menu_configuration['sub'][] = [
                'title' => lang('manage_x', strtolower(lang('plugins'))),
                'url'   => DirPath::getUrl('admin_area') . 'plugin_manager.php'
            ];
        }

        if (User::getInstance()->hasPermission('manage_template_access')) {
            global $cbtpl, $cbplayer;
            if (count($cbtpl->get_templates()) > 1 || System::isInDev()) {
                $menu_configuration['sub'][] = [
                    'title' => lang('manage_x', strtolower(lang('templates'))),
                    'url'   => DirPath::getUrl('admin_area') . 'templates.php'
                ];
            }

            if( count($cbplayer->getPlayers()) > 1 || System::isInDev() ){
                $menu_configuration['sub'][] = [
                    'title' => lang('manage_x', strtolower(lang('players')))
                    , 'url' => DirPath::getUrl('admin_area') . 'manage_players.php'
                ];
            }
        }
        if( config('disable_email') != 'yes'  && User::getInstance()->hasPermission('email_template_management') ){
            $menu_configuration['sub'][] = [
                'title' =>  lang('email_template_management')
                , 'url' => DirPath::getUrl('admin_area') . 'email_template_management.php'
            ];
        }

        $this->addMenuAdmin($menu_configuration, 2);

        if (NEED_UPDATE) {
            return;
        }
        if (User::getInstance()->hasPermission('admin_access')) {
            $menu_general = [
                'title'   => lang('general')
                , 'class' => 'glyphicon glyphicon-stats'
                , 'sub'   => []
            ];

            if (config('enable_comments_video') == 'yes' || config('enable_comments_photo') == 'yes' || config('enable_comments_channel') == 'yes' || config('enable_comments_collection') == 'yes') {
                $menu_general['sub'][] = [
                    'title' => lang('manage_x', strtolower(lang('comments')))
                    , 'url' => DirPath::getUrl('admin_area') . 'comments.php'
                ];
            }

            $menu_general['sub'][] = [
                'title' => lang('manage_x', strtolower(lang('tags')))
                , 'url' => DirPath::getUrl('admin_area') . 'manage_tags.php'
            ];

            if (
                (config('videosSection')=='yes' && User::getInstance()->hasPermission('video_moderation'))
                || (config('photosSection')=='yes' && User::getInstance()->hasPermission('photos_moderation'))
                || (config('collectionsSection')=='yes' && User::getInstance()->hasPermission('collection_moderation'))
                || (config('channelsSection')=='yes' && User::getInstance()->hasPermission('member_moderation'))
            ) {
                $menu_general['sub'][] = [
                    'title' => lang('notifications')
                    , 'url' => DirPath::getUrl('admin_area') . 'notifications.php'
                ];
            }

            $this->addMenuAdmin($menu_general, 10);
        }

        if (User::getInstance()->hasPermission('member_moderation')) {
            $menu_users = [
                'title'   => lang('users')
                , 'class' => 'glyphicon glyphicon-user'
                , 'sub'   => [
                    [
                        'title' => lang('manage_x', strtolower(lang('users')))
                        , 'url' => DirPath::getUrl('admin_area') . 'members.php'
                    ]
                    , [
                        'title' => 'Inactive Only'
                        , 'url' => DirPath::getUrl('admin_area') . 'members.php?search=yes&status=ToActivate'
                    ]
                    , [
                        'title' => 'Active Only'
                        , 'url' => DirPath::getUrl('admin_area') . 'members.php?search=yes&status=Ok'
                    ]
                    , [
                        'title' => lang('user_flagged')
                        , 'url' => DirPath::getUrl('admin_area') . 'flagged_item.php?type=user'
                    ]
                ]
            ];

            if( config('enable_user_category') == 'yes' ){
                $menu_users['sub'][] = [
                    'title' => lang('manage_x', strtolower(lang('categories')))
                    , 'url' => DirPath::getUrl('admin_area') . 'category.php?type=user'
                ];
            }

            $this->addMenuAdmin($menu_users, 20);
        }

        if (User::getInstance()->hasPermission('ad_manager_access') && config('enable_advertisement') == 'yes' ) {
            $menu_ad = [
                'title'   => 'Advertisement'
                , 'class' => 'glyphicon glyphicon-bullhorn'
                , 'sub'   => [
                    [
                        'title' => 'Manage Advertisments'
                        , 'url' => DirPath::getUrl('admin_area') . 'ads_manager.php'
                    ]
                    , [
                        'title' => 'Manage Placements'
                        , 'url' => DirPath::getUrl('admin_area') . 'ads_add_placements.php'
                    ]
                ]
            ];

            $this->addMenuAdmin($menu_ad, 30);
        }

        if (User::getInstance()->hasPermission('tool_box')) {
            $menu_tool = [
                'title'   => lang('tool_box')
                , 'class' => 'glyphicon glyphicon-wrench'
                , 'sub'   => [
                    [
                        'title' => 'View online users'
                        , 'url' => DirPath::getUrl('admin_area') . 'online_users.php'
                    ]
                    , [
                        'title' => 'Action Logs'
                        , 'url' => DirPath::getUrl('admin_area') . 'action_logs.php?type=login'
                    ]
                    , [
                        'title' => 'Conversion Queue Manager'
                        , 'url' => DirPath::getUrl('admin_area') . 'cb_conversion_queue.php'
                    ]
                    , [
                        'title' => 'ReIndexer'
                        , 'url' => DirPath::getUrl('admin_area') . 'reindex_cb.php'
                    ]
                    , [
                        'title' => lang('admin_tool')
                        , 'url' => DirPath::getUrl('admin_area') . 'admin_tool.php'
                    ]
                    , [
                        'title' => lang('system_info')
                        , 'url' => DirPath::getUrl('admin_area') . 'system_info.php'
                    ]
                    , [
                        'title' => lang('changelog')
                        , 'url' => DirPath::getUrl('admin_area') . 'changelog.php'
                    ]
                ]
            ];

            if (config('disable_email') == 'no') {
                $menu_tool['sub'][] = [
                    'title' => 'Mass Email'
                    , 'url' => DirPath::getUrl('admin_area') . 'mass_email.php'
                ];
            }


            if (User::getInstance()->hasPermission('advanced_settings')) {
                $menu_tool['sub'][] = [
                    'title' => 'Maintenance'
                    , 'url' => DirPath::getUrl('admin_area') . 'maintenance.php'
                ];
            }

            $menu_tool['sub'][] = [
                'title' => 'Reports &amp; Stats'
                , 'url' => DirPath::getUrl('admin_area') . 'reports.php'
            ];

            $this->addMenuAdmin($menu_tool, 60);
        }
    }

    /**
     * Function used to assign ClipBucket configurations
     * @throws Exception
     */
    function get_configs(): array
    {
        return myquery::getInstance()->Get_Website_Details();
    }

    /**
     * Function used to get list of countries
     *
     * @param string $type
     *
     * @return array
     * @throws Exception
     */
    function get_countries($type = 'iso2'): array
    {
        $results = Clipbucket_db::getInstance()->select(tbl('countries'), '*');
        $carray = [];
        switch ($type) {
            case 'iso2':
                foreach ($results as $result) {
                    $carray[$result['iso2']] = $result['name_en'];
                }
                break;
            case 'iso3':
                foreach ($results as $result) {
                    $carray[$result['iso3']] = $result['name_en'];
                }
                break;
            case 'id':
            default:
                foreach ($results as $result) {
                    $carray[$result['country_id']] = $result['name_en'];
                }
                break;
        }

        return $carray;
    }

    /**
     * Function used to set show_page = false or true
     *
     * @param bool $val
     */
    function show_page($val = true): void
    {
        $this->show_page = $val;
    }

    /**
     * Function used to set template (Frontend)
     *
     * @return bool|mixed|string
     * @throws Exception
     */
    function set_the_template()
    {
        if( is_dir(DirPath::get('styles') . $this->template) ){
            $template = $this->template;
        } else {
            // Fallback to default template
            $template = 'cb_28';
        }
        require_once DirPath::get('styles') . $template . DIRECTORY_SEPARATOR . 'header.php';

        if (!is_dir(DirPath::get('styles') . $template) || !$template) {
            $template = CBTemplate::getInstance()->get_any_template();
        }

        if( isset($_GET['set_template']) && User::getInstance()->hasAdminAccess() ){
            myquery::getInstance()->set_template($template);
        }

        //$this->smarty_version
        $template_details = CBTemplate::getInstance()->get_template_details($template);
        CBTemplate::getInstance()->smarty_version = $template_details['smarty_version'];

        return $this->template = $template;
    }
    function get_extensions($type = 'video'): string
    {
        switch ($type) {
            default:
            case 'video':
                $exts = config('allowed_video_types');
                break;
            case 'photo':
                $exts = config('allowed_photo_types');
                break;
        }

        return preg_replace('/ /', '', strtolower($exts));
    }

    /**
     * Function used to load head menu
     *
     * @return array|void
     * @throws Exception
     */
    function head_menu()
    {
        $this->head_menu[] = ['name' => lang('menu_home'), 'icon' => '<i class="fa fa-home"></i>', 'link' => DirPath::getUrl('root'), 'this' => 'home', 'section' => 'home', 'extra_attr' => ''];

        if( config('videosSection') == 'yes' ){
            $this->head_menu[] = ['name' => lang('videos'), 'icon' => '<i class="fa fa-video-camera"></i>', 'link' => cblink(['name' => 'videos']), 'this' => 'videos', 'section' => 'home', 'permission'=>'view_videos'];
            if (config('enable_public_video_page') == 'yes' && User::getInstance()->hasPermission('allow_public_video_page')) {
                $this->head_menu[] = ['name' => lang('public_videos'), 'icon' => '<i class="fa fa-video-camera"></i>', 'link' => cblink(['name' => 'videos_public']), 'this' => 'videos_public', 'section' => 'videos_public', 'permission'=>'allow_public_video_page'];
            }
        }
        if( config('photosSection') == 'yes' ) {
            $this->head_menu[] = ['name' => lang('photos'), 'icon' => '<i class="fa fa-camera"></i>', 'link' => cblink(['name' => 'photos']), 'this' => 'photos', 'permission'=>'view_photos'];
        }
        if( config('channelsSection') == 'yes' ) {
            $this->head_menu[] = ['name' => lang('channels'), 'icon' => '<i class="fa fa-desktop"></i>', 'link' => cblink(['name' => 'channels']), 'this' => 'channels', 'section' => 'channels', 'permission'=>'view_channels'];
        }
        if( config('collectionsSection') == 'yes' && (config('videosSection') == 'yes' || config('photosSection') == 'yes') ) {
            $this->head_menu[] = ['name' => lang('collections'), 'icon' => '<i class="fa fa-bars"></i>', 'link' => cblink(['name' => 'collections']), 'this' => 'collections', 'section' => 'collections', 'permission'=>'view_collections'];
        }

        return $this->head_menu;
    }

    /**
     * @throws Exception
     */
    function cbMenu()
    {
        $this->head_menu();

        $params = [];
        $params['class'] = '';

        $headMenu = $this->head_menu;

        $custom = (isset($this->custom_menu)) ? $this->custom_menu : false;
        if (is_array($custom)) {
            $headMenu = array_merge($headMenu, $custom);
        }

        /* Excluding tabs from menu */
        if (isset($params['exclude'])) {
            if (is_array($params['exclude'])) {
                $exclude = $params['exclude'];
            } else {
                $exclude = explode(',', $params['exclude']);
            }

            foreach ($headMenu as $key => $hm) {
                foreach ($exclude as $ex) {
                    $ex = trim($ex);
                    if (strtolower(trim($hm['name'])) == strtolower($ex)) {
                        unset($headMenu[$key]);
                    }
                }
            }
        }

        $main_menu = [];
        foreach ($headMenu as $menu) {
            $selected = current_page(['page' => $menu['this']]);
            if ($selected) {
                $menu['active'] = true;
            }

            $main_menu[] = $menu;
        }
        if (!isset($params['echo'])) {
            return $main_menu;
        }
        $output = '';
        foreach ($main_menu as $menu) {
            $selected = getArrayValue($menu, 'active');
            $output .= '<li ';
            $output .= "id = 'cb" . $menu['name'] . "Tab'";

            $output .= " class = '";
            if ($params['class']) {
                $output .= $params['class'];
            }
            if ($selected) {
                $output .= ' selected';
            }
            $output .= "'";

            if (isset($params['extra_params'])) {
                $output .= ($params['extra_params']);
            }
            $output .= '>';
            $output .= "<a href='" . $menu['link'] . "'>";
            $output .= $menu['name'] . "</a>";
            $output .= '</li>';
        }

        echo $output;
        return true;
    }

    /**
     * Function used to load head menu
     *
     * @param null $params
     *
     * @return array|void
     * @throws Exception
     */
    function foot_menu($params = null)
    {
        $pages = cbpage::getInstance()->get_pages(['active' => 'yes', 'display_only' => 'yes', 'order' => 'page_order ASC']);

        if ($pages) {
            foreach ($pages as $p) {
                $this->foot_menu[] = ['name' => display_clean(lang('page_name_' . $p['page_name'])), 'link' => cbpage::getInstance()->page_link($p), 'this' => 'home'];
            }
        }

        if ($params['assign']) {
            assign($params['assign'], $this->foot_menu);
        } else {
            return $this->foot_menu;
        }
    }

    /**
     * Function used to clean requests
     */
    function clean_requests(): void
    {
        $posts = $_POST;
        $gets = $_GET;
        $request = $_REQUEST;

        //Cleaning post..
        if (is_array($posts) && count($posts) > 0) {
            $clean_posts = [];
            foreach ($posts as $key => $post) {
                if (!is_array($post)) {
                    $clean_posts[$key] = preg_replace(['/\|no_mc\|/', '/\|f\|/'], '', $post);
                } else {
                    $clean_posts[$key] = $post;
                }
            }
            $_POST = $clean_posts;
        }

        //Cleaning get..
        if (is_array($gets) && count($gets) > 0) {
            $clean_gets = [];
            foreach ($gets as $key => $get) {
                if (!is_array($get)) {
                    $clean_gets[$key] = preg_replace(['/\|no_mc\|/', '/\|f\|/'], '', $get);
                } else {
                    $clean_gets[$key] = $get;
                }
            }
            $_GET = $clean_gets;
        }

        //Cleaning request..
        if (is_array($request) && count($request) > 0) {
            $clean_request = [];
            foreach ($request as $key => $request) {
                if (!is_array($request)) {
                    $clean_request[$key] = preg_replace(['/\|no_mc\|/', '/\|f\|/'], '', $request);
                } else {
                    $clean_request[$key] = $request;
                }
            }
            $_REQUEST = $clean_request;
        }
    }

    function getMaxUploadSize($suffix = ''): string
    {
        $list_upload_limits = [];

        $post_max_size = ini_get('post_max_size');
        $list_upload_limits[] = (float)$post_max_size * pow(1024, stripos('KMGT', strtoupper(substr($post_max_size, -1)))) / 1024;

        $upload_max_filesize = ini_get('upload_max_filesize');
        $list_upload_limits[] = (float)$upload_max_filesize * pow(1024, stripos('KMGT', strtoupper(substr($upload_max_filesize, -1)))) / 1024;

        if( config('enable_chunk_upload') == 'yes' ){
            $list_upload_limits[] = (float)config('chunk_upload_size');
        }

        if( Network::is_cloudflare() ){
            $list_upload_limits[] = (float)config('cloudflare_upload_limit');
        }

        return (min($list_upload_limits)-0.01).$suffix;
    }

}
