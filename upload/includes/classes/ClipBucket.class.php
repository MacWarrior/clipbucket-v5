<?php
class ClipBucket
{
    var $JSArray = [];
    var $AdminJSArray = [];
    var $CSSArray = [];
    var $AdminCSSArray = [];
    var $moduleList = [];
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

    public static function getInstance(){
        global $Cbucket;
        return $Cbucket;
    }

    /**
     * @throws Exception
     */
    function __construct()
    {
        global $pages;
        //Assign Configs
        $this->configs = $this->get_configs();
        //Get Current Page and Redirects it to without www.
        $pages->redirectOrig();

        //This is used to create Admin Menu
        //Updating Upload Options		
        $this->temp_exts = ['ahz', 'jhz', 'abc', 'xyz', 'cb2', 'tmp', 'olo', 'oar', 'ozz'];
        $this->template = $this->configs['template_dir'];

        if (!defined("IS_CAPTCHA_LOADING")) {
            $_SESSION['total_captchas_loaded'] = 0;
        }

        $this->clean_requests();

        $sort_array = sorting_links();

        if (!isset($_GET['sort']) || !isset($sort_array[$_GET['sort']])) {
            $_GET['sort'] = 'most_recent';
        }

        $time_array = time_links();

        if (!isset($_GET['time']) || !isset($time_array[$_GET['time']])) {
            $_GET['time'] = 'all_time';
        }

        if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
            $_GET['page'] = 1;
        }
    }

    /**
     * @throws Exception
     */
    function addJS($files)
    {
        $this->addFile($this->JSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAdminJS($files)
    {
        $this->addFile($this->AdminJSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAllJS($files)
    {
        $this->addFile($this->JSArray, $files);
        $this->addFile($this->AdminJSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addCSS($files)
    {
        $this->addFile($this->CSSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAdminCSS($files)
    {
        $this->addFile($this->AdminCSSArray, $files);
    }

    /**
     * @throws Exception
     */
    function addAllCSS($files)
    {
        $this->addFile($this->CSSArray, $files);
        $this->addFile($this->AdminCSSArray, $files);
    }

    /**
     * @throws Exception
     */
    private function addFile(&$array_var, $files)
    {
        if(in_dev()){
            $cache_key = time();
        } else {
            $cache_key = str_replace('.', '', Update::getInstance()->getCurrentCoreVersion()) . Update::getInstance()->getCurrentCoreRevision();
        }

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

    /**
     * Function add_header()
     * this will be used to add new files in header array
     * this is basically for plugins
     *
     * @param $file
     * @param string $place
     */
    function add_header($file, $place = 'global')
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
    function add_admin_header($file, $place = 'global')
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

    function addMenuAdmin($menu_params, $order = null)
    {
        global $Cbucket;
        $menu_already_exists = false;

        if (is_null($order)) {
            if( empty($Cbucket->AdminMenu) ){
                $order = 1;
            } else {
                $order = max(array_keys($Cbucket->AdminMenu)) + 1;
            }
        } else {
            if (array_key_exists($order, $Cbucket->AdminMenu)) {
                do {
                    $order++;
                } while (array_key_exists($order, $Cbucket->AdminMenu));
            }
        }

        foreach ($Cbucket->AdminMenu as &$menu) {
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
            $Cbucket->AdminMenu[$order] = $menu_params;
        }
        ksort($Cbucket->AdminMenu);
    }

    /**
     * @throws Exception
     */
    function initAdminMenu()
    {
        global $userquery;
        $per = $userquery->get_user_level(user_id());

        $menu_dashboard = [
            'title'   => 'Dashboard'
            , 'class' => 'icon-dashboard'
            , 'url'   => DirPath::getUrl('admin_area') . 'index.php'
        ];
        $this->addMenuAdmin($menu_dashboard, 1);

        if (NEED_UPDATE) {
            return;
        }
        if ($per['web_config_access'] == 'yes') {
            $menu_general = [
                'title'   => lang('general')
                , 'class' => 'glyphicon glyphicon-stats'
                , 'sub'   => [
                    [
                        'title' => 'Reports &amp; Stats'
                        , 'url' => DirPath::getUrl('admin_area') . 'reports.php'
                    ]
                    , [
                        'title' => 'Website Configurations'
                        , 'url' => DirPath::getUrl('admin_area') . 'main.php'
                    ]
                    , [
                        'title' => 'Email Templates'
                        , 'url' => DirPath::getUrl('admin_area') . 'email_settings.php'
                    ]
                    , [
                        'title' => 'Language Settings'
                        , 'url' => DirPath::getUrl('admin_area') . 'language_settings.php'
                    ]
                    , [
                        'title' => 'Manage Pages'
                        , 'url' => DirPath::getUrl('admin_area') . 'manage_pages.php'
                    ]
                    , [
                        'title' => 'Manage Comments'
                        , 'url' => DirPath::getUrl('admin_area') . 'comments.php'
                    ]
                    , [
                        'title' => 'Update Logos'
                        , 'url' => DirPath::getUrl('admin_area') . 'upload_logo.php'
                    ]
                    , [
                        'title' => lang('manage_tags')
                        , 'url' => DirPath::getUrl('admin_area') . 'manage_tags.php'
                    ]
                ]
            ];

            $this->addMenuAdmin($menu_general, 10);
        }

        if ($per['member_moderation'] == 'yes') {
            $menu_users = [
                'title'   => lang('users')
                , 'class' => 'glyphicon glyphicon-user'
                , 'sub'   => [
                    [
                        'title' => lang('grp_manage_members_title')
                        , 'url' => DirPath::getUrl('admin_area') . 'members.php'
                    ]
                    , [
                        'title' => 'Add Member'
                        , 'url' => DirPath::getUrl('admin_area') . 'add_member.php'
                    ]
                    , [
                        'title' => lang('manage_categories')
                        , 'url' => DirPath::getUrl('admin_area') . 'user_category.php'
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
                        'title' => 'Reported Users'
                        , 'url' => DirPath::getUrl('admin_area') . 'flagged_users.php'
                    ]
                ]
            ];

            if (config('disable_email') == 'no') {
                $menu_users['sub'][] = [
                    'title' => 'Mass Email'
                    , 'url' => DirPath::getUrl('admin_area') . 'mass_email.php'
                ];
            }

            if ($per['allow_manage_user_level'] == 'yes' || $userquery->level == 1) {
                $menu_users['sub'][] = [
                    'title' => 'User Levels'
                    , 'url' => DirPath::getUrl('admin_area') . 'user_levels.php'
                ];
            }

            $this->addMenuAdmin($menu_users, 20);
        }

        if ($per['ad_manager_access'] == 'yes' && config('enable_advertisement') == 'yes' ) {
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

        if ($per['manage_template_access'] == 'yes') {
            $sub = [];
            global $cbtpl, $cbplayer;
            if( count($cbtpl->get_templates()) > 1 || in_dev() ){
                $sub[] = [
                    'title' => 'Templates Manager'
                    , 'url' => DirPath::getUrl('admin_area') . 'templates.php'
                ];
            }
            $sub[] = [
                'title' => 'Templates Editor'
                , 'url' => DirPath::getUrl('admin_area') . 'template_editor.php'
            ];


            if( count($cbplayer->getPlayers()) > 1 || in_dev() ){
                $sub[] = [
                    'title' => 'Players Manager'
                    , 'url' => DirPath::getUrl('admin_area') . 'manage_players.php'
                ];
            }
            $sub[] = [
                'title' => lang('player_settings')
                , 'url' => DirPath::getUrl('admin_area') . 'manage_players.php?mode=show_settings'
            ];


            $menu_template = [
                'title'   => 'Templates And Players'
                , 'class' => 'glyphicon glyphicon-play-circle'
                , 'sub'   => $sub
            ];

            $this->addMenuAdmin($menu_template, 40);
        }

        global $cbplugin;
        $plugins_available = count($cbplugin->getNewPlugins());
        $plugins_installed = count($cbplugin->getInstalledPlugins());
        $plugins_count = $plugins_available + $plugins_installed;
        if ($per['plugins_moderation'] == 'yes' && ($plugins_count >= 1 || in_dev())) {
            $menu_plugin = [
                'title'   => 'Plugin Manager'
                , 'class' => 'glyphicon glyphicon-tasks'
                , 'sub'   => [
                    [
                        'title' => 'Plugin Manager'
                        , 'url' => DirPath::getUrl('admin_area') . 'plugin_manager.php'
                    ]
                ]
            ];

            $this->addMenuAdmin($menu_plugin, 50);
        }

        if ($per['tool_box'] == 'yes') {
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
                        'title' => lang('email_tester')
                        , 'url' => DirPath::getUrl('admin_area') . 'email_tester.php'
                    ]
                ]
            ];


            if ($per['web_config_access'] == 'yes') {
                $menu_tool['sub'][] = [
                    'title' => 'Maintenance'
                    , 'url' => DirPath::getUrl('admin_area') . 'maintenance.php'
                ];
            }

            $this->addMenuAdmin($menu_tool, 60);
        }
    }

    /**
     * Function used to assign ClipBucket configurations
     * @throws Exception
     */
    function get_configs()
    {
        global $myquery;
        return $myquery->Get_Website_Details();
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
        global $db;
        $results = $db->select(tbl('countries'), '*');
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
    function show_page($val = true)
    {
        $this->show_page = $val;
    }

    /**
     * Function used to set template (Frontend)
     *
     * @param bool $ctemplate
     *
     * @return bool|mixed|string
     * @throws Exception
     */
    function set_the_template($ctemplate = false)
    {
        global $cbtpl, $myquery;
        if ($ctemplate) {
            $_GET['template'] = $ctemplate;
        }
        $template = $this->template;

        require_once DirPath::get('styles') . $this->template . DIRECTORY_SEPARATOR . 'header.php';
        if (isset($_SESSION['the_template']) && $cbtpl->is_template($_SESSION['the_template'])) {
            $template = $_SESSION['the_template'];
        }

        if (isset($_GET['template'])) { //@todo : add permission
            if (is_dir(DirPath::get('styles') . $_GET['template']) && $_GET['template']) {
                $template = $_GET['template'];
            }
        }
        if (isset($_GET['set_the_template']) && $cbtpl->is_template($_GET['set_the_template'])) {
            $template = $_SESSION['the_template'] = $_GET['set_the_template'];
        }

        if (!is_dir(DirPath::get('styles') . $template) || !$template) {
            $template = $cbtpl->get_any_template();
        }

        if (!is_dir(DirPath::get('styles') . $template) || !$template) {
            exit("Unable to find any template, please goto <a href='http://clip-bucket.com/no-template-found'><strong>ClipBucket Support!</strong></a>");
        }

        if (isset($_GET['set_template'])) {
            $myquery->set_template($template);
        }

        //$this->smarty_version
        $template_details = $cbtpl->get_template_details($template);
        $cbtpl->smarty_version = $template_details['smarty_version'];

        define('SMARTY_VERSION', $cbtpl->smarty_version);

        return $this->template = $template;
    }

    /**
     * Function used to list available extension for clipbucket
     */
    function list_extensions()
    {
        $exts = $this->configs['allowed_video_types'];
        $exts = preg_replace('/ /', '', $exts);
        $exts = explode(',', $exts);
        $new_form = '';
        foreach ($exts as $ext) {
            if (!empty($new_form)) {
                $new_form .= ';';
            }
            $new_form .= "*.$ext";
        }

        return $new_form;
    }

    function get_extensions($type = 'video'): string
    {
        switch ($type) {
            default:
            case 'video':
                $exts = $this->configs['allowed_video_types'];
                break;
            case 'photo':
                $exts = $this->configs['allowed_photo_types'];
                break;
        }

        $exts = preg_replace('/ /', '', strtolower($exts));
        $exts = explode(',', $exts);
        $new_form = '';
        foreach ($exts as $ext) {
            $new_form .= "$ext,";
        }

        return $new_form;
    }

    /**
     * Function used to load head menu
     *
     * @param null $params
     *
     * @return array|void
     * @throws Exception
     */
    function head_menu($params = null)
    {
        $this->head_menu[] = ['name' => lang('menu_home'), 'icon' => '<i class="fa fa-home"></i>', 'link' => BASEURL, 'this' => 'home', 'section' => 'home', 'extra_attr' => ''];
        $this->head_menu[] = ['name' => lang('videos'), 'icon' => '<i class="fa fa-video-camera"></i>', 'link' => cblink(['name' => 'videos']), 'this' => 'videos', 'section' => 'home'];
        $this->head_menu[] = ['name' => lang('photos'), 'icon' => '<i class="fa fa-camera"></i>', 'link' => cblink(['name' => 'photos']), 'this' => 'photos'];
        $this->head_menu[] = ['name' => lang('channels'), 'icon' => '<i class="fa fa-desktop"></i>', 'link' => cblink(['name' => 'channels']), 'this' => 'channels', 'section' => 'channels'];
        $this->head_menu[] = ['name' => lang('collections'), 'icon' => '<i class="fa fa-bars"></i>', 'link' => cblink(['name' => 'collections']), 'this' => 'collections', 'section' => 'collections'];

        /* Calling custom functions for headMenu. This can be used to add new tabs */
        if ($params['assign']) {
            assign($params['assign'], $this->head_menu);
        } else {
            return $this->head_menu;
        }
    }

    /**
     * @throws Exception
     */
    function cbMenu($params = null)
    {
        $this->head_menu($params);

        if (!$params['class']) {
            $params['class'] = '';
        }

        if (!isset($params['getSubTab'])) {
            $params['getSubTab'] = '';
        }

        if (!isset($params['parentTab'])) {
            $params['parentTab'] = '';
        }

        if (!isset($params['selectedTab'])) {
            $params['selectedTab'] = '';
        }

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
            if (isSectionEnabled($menu['this'])) {
                $selected = current_page(['page' => $menu['this']]);
                if ($selected) {
                    $menu['active'] = true;
                }

                $main_menu[] = $menu;
            }
        }

        $output = "";
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

        if (isset($params['echo'])) {
            echo $output;
        } else {
            return $main_menu;
        }
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
        global $cbpage;

        $pages = $cbpage->get_pages(['active' => 'yes', 'display_only' => 'yes', 'order' => 'page_order ASC']);

        if ($pages) {
            foreach ($pages as $p) {
                $this->foot_menu[] = ['name' => lang($p['page_name']), 'link' => $cbpage->page_link($p), 'this' => 'home'];
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
    function clean_requests()
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

}
