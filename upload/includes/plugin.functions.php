<?php
/**
 * FUNCTION USED TO REGISTER ACTIONS THAT ARE TO APPLIED
 * ON COMMENTS , TITLE, DESCRIPTIONS etc
 *
 * @param      $name
 * @param null $type
 *
 * @deprecated : Since v2.7
 */
function register_action($name, $type = null): void
{
    if (is_array($name)) {
        foreach ($name as $key => $naam) {
            if (is_array($naam)) {
                foreach ($naam as $name) {
                    ClipBucket::getInstance()->actionList[$name][] = $key;
                }
            } else {
                ClipBucket::getInstance()->actionList[$naam][] = $key;
            }
        }
    } else {
        if ($type != null) {
            ClipBucket::getInstance()->actionList[$type][] = $name;
        }
    }
}

/**
 * FUNCTION USED TO CREATE ANCHOR PLACEMENT
 * these are the placement where we can add plugin's or widget's code,
 * e.g if we want to display a new WYSIWYG box before comment text area
 * we will create anchor before text area as {ANCHOR place='before_compose_box'}
 * code will be written in plugin file and its place will point 'before_compose_box'
 * then our function will get all the code for this placement and will display it
 * @param : array(Ad Code, LIMIT);
 */
function ANCHOR($params): void
{
    if( empty($params['place']) ){
        return;
    }

    //Getting List of codes to display at this anchor
    $codes = ClipBucket::getInstance()->get_anchor_codes($params['place']);
    if (!empty($codes)) {
        if (is_array($codes)) {
            foreach ($codes as $code) {
                echo $code;
            }
        } else {
            echo $codes;
        }
    }

    //Getting list of function that will be performed while calling achor
    $funcs = ClipBucket::getInstance()->get_anchor_function_list($params['place']);
    global $current_anchor;
    $current_anchor = $params['place'];

    if (!empty($funcs)) {
        foreach ($funcs as $func) {
            if (is_array($func)) {
                $class = $func['class'];
                $method = $func['method'];
                if (method_exists($class, $method)) {
                    if (isset($params['data'])) {
                        $class::$method($params['data']);
                    } else {
                        $class::$method();
                    }
                }
            } else {
                if (function_exists($func)) {
                    if (isset($params['data'])) {
                        $func($params['data']);
                    } else {
                        $func();
                    }
                }
            }
        }
    }
}

/**
 * FUNCTION USED TO REGISTER ANCHORS
 *
 * @param      $name
 * @param null $type
 */
function register_anchor($name, $type = null): void
{
    if (is_array($name)) {
        foreach ($name as $key => $naam) {
            if (is_array($naam)) {
                foreach ($naam as $name) {
                    ClipBucket::getInstance()->anchorList[$name][] = $key;
                }
            } else {
                ClipBucket::getInstance()->anchorList[$naam][] = $key;
            }
        }
    } else {
        if ($type != null) {
            ClipBucket::getInstance()->anchorList[$type][] = $name;
        }
    }
}


/**
 * FUNCTION USED TO REGISTER FUNCTION
 * If you want to perform some function on
 * some place, you can simple register function that will be execute where anchor points are
 * placed
 *
 * @param      $method
 * @param null $type
 * @param null $class
 * @return bool
 */
function register_anchor_function($method, $type, $class = null): bool
{
    if( empty($type) ){
        if( in_dev() ){
            error_log('register_anchor_function '.$method.' must have a type specified');
        }
        return false;
    }

    if (empty($class)) {
        if( empty(ClipBucket::getInstance()->anchor_function_list[$type]) || !in_array($method, ClipBucket::getInstance()->anchor_function_list[$type]) ){
            ClipBucket::getInstance()->anchor_function_list[$type][] = $method;
        }
    } else {
        $entry = ['class' => $class, 'method' => $method];

        if (empty(ClipBucket::getInstance()->anchor_function_list[$type]) || !in_array($entry, ClipBucket::getInstance()->anchor_function_list[$type], true)) {
            ClipBucket::getInstance()->anchor_function_list[$type][] = $entry;
        }
    }
    return true;
}

/**
 * Function used to add items in admin menu
 * This function will insert new item in admin menu
 * under given header, if the header is not available
 * it will create one, ( Header means titles ie 'Plugins' 'Videos' etc)
 *
 * @param STRING $header - Could be Plugin , Videos, Users , please check
 * @param        $name
 * @param        $link
 * @param bool $plug_folder
 * @param bool $is_player_file
 */
function add_admin_menu($header, $name, $link, $plug_folder = false, $is_player_file = false): void
{
    if (NEED_UPDATE) {
        return;
    }

    if ($plug_folder) {
        $link = 'plugin.php?folder=' . $plug_folder . '&file=' . $link;
    }
    if ($is_player_file) {
        $link .= '&player=true';
    }

    $menu_plugin = [
        'title'   => $header
        , 'class' => ''
        , 'sub'   => [
            [
                'title' => $name
                , 'url' => $link
            ]
        ]
    ];

    ClipBucket::getInstance()->addMenuAdmin($menu_plugin);
}

/**
 * Function used to add custom upload fields
 * In this you will provide an array that has a complete
 * details of the field such as 'name',validate_func etc
 *
 * @param $array
 */
function register_custom_upload_field($array): void
{
    $name = key($array);
    if (is_array($array) && !empty($array[$name]['name'])) {
        foreach ($array as $key => $arr) {
            Upload::getInstance()->custom_upload_fields[$key] = $arr;
        }
    }
}

/**
 * Function used to add custom form fields
 * In this you will provide an array that has a complete
 * details of the field such as 'name',validate_func etc
 *
 * @param      $array
 * @param bool $isGroup
 */
function register_custom_form_field($array, bool $isGroup = false): void
{
    $name = key($array);

    if (!$isGroup) {
        if (is_array($array) && !empty($array[$name]['name'])) {
            foreach ($array as $key => $arr) {
                Upload::getInstance()->custom_form_fields[$key] = $arr;
            }
        }
    } else {
        if (is_array($array) && !empty($array['group_name'])) {
            Upload::getInstance()->custom_form_fields_groups[] = $array;
        }
    }
}

/**
 * Function used to add custom signup form fields
 * In this you will provide an array that has a complete
 * details of the field such as 'name',validate_func etc
 *
 * @param $array
 * @throws Exception
 */
function register_signup_field($array): void
{
    $name = key($array);
    if (is_array($array) && !empty($array[$name]['name'])) {
        foreach ($array as $key => $arr) {
            userquery::getInstance()->custom_signup_fields[$key] = $arr;
        }
    }
}

/**
 * Function used to add custom profile fields fields
 * In this you will provide an array that has a complete
 * details of the field such as 'name',validate_func etc
 *
 * @param      $array
 * @param bool $isGroup
 * @throws Exception
 */
function register_custom_profile_field($array, bool $isGroup = false): void
{
    $name = key($array);

    if (!$isGroup) {
        if (is_array($array) && !empty($array[$name]['name'])) {
            foreach ($array as $key => $arr) {
                userquery::getInstance()->custom_profile_fields[$key] = $arr;
            }
        }
    } else {
        if (is_array($array) && !empty($array['group_name'])) {
            userquery::getInstance()->custom_profile_fields_groups[] = $array;
        }
    }
}

/**
 * Function used to add actions that will be performed
 * when video is uploaded
 * @param string $func Function name
 */
function register_after_video_upload_action(string $func): void
{
    Upload::getInstance()->actions_after_video_upload[] = $func;
}

/**
 * Function used to add actions that will be performed
 * when video is going to play, it will check which player to use
 * what type to use and what to do
 * @param string $method Function name
 */
function register_actions_play_video(string $method, string $class = null): bool
{
    if (empty($method)) {
        return false;
    }

    if (empty($class)) {
        ClipBucket::getInstance()->actions_play_video[] = $method;
    } else {
        ClipBucket::getInstance()->actions_play_video[] = [
            'class'    => $class
            , 'method' => $method
        ];
    }
    return true;
}

function register_collection_delete_functions($func): void
{
    Collections::getInstance()->collection_delete_functions[] = $func;
}

/**
 * function use to register function that will be
 * called while deleting a video
 *
 * @param string $func
 */
function register_action_remove_video(string $func): void
{
    //Editing this thing without special consideration can trun whole CB into "WTF"
    CBvideo::getInstance()->video_delete_functions[] = $func;
}

/**
 * Function used to register function , that will be called when deleting video files
 *
 * @param string $func
 */
function register_action_remove_video_files(string $func): void
{
    ClipBucket::getInstance()->on_delete_video[] = $func;
}

/**
 * Function used to display comment rating
 *
 * @param $input
 *
 * @return string
 */
function comment_rating($input): string
{
    if ($input < 0) {
        return '<font color="#ed0000">' . $input . '</font>';
    }
    if ($input > 0) {
        return '<font color="#006600">+' . $input . '</font>';
    }
    return $input;
}

/**
 * Function use to register security captchas for clipbucket
 *
 * @param      $func
 * @param      $ver_func
 * @param bool $show_field
 */
function register_cb_captcha($func, $ver_func, bool $show_field = true): void
{
    ClipBucket::getInstance()->captchas[] = ['load_function' => $func, 'validate_function' => $ver_func, 'show_field' => $show_field];
}

/**
 * FUnction used to register ClipBucket php functions
 *
 * @param      $func_name
 * @param      $place
 * @param null $params
 */
function cb_register_function($func_name, $place, $params = null): void
{
    if (function_exists($func_name)) {
        ClipBucket::getInstance()->clipbucket_functions[$place][] = ['func' => $func_name, 'params' => $params];
    }
}

/**
 * function used to check weather specific place has function or not
 *
 * @param $place
 *
 * @return bool | array | void
 */
function cb_get_functions($place)
{
    if (isset(ClipBucket::getInstance()->clipbucket_functions[$place])) {
        if (count(ClipBucket::getInstance()->clipbucket_functions[$place]) > 0) {
            return ClipBucket::getInstance()->clipbucket_functions[$place];
        }
        return false;
    }
}

/**
 * Function used to call cb_functions
 * Why I am re-writting this. Because we need some
 * extra parameters in some places to make these
 * functions work correctly. Like while displaying
 * categories we need to pass all paramerters that
 * user has passed in cbCategories function
 *
 * @param      $place
 * @param null $extra
 */
function cb_call_functions($place, $extra = null): void
{
    $funcs = cb_get_functions($place);
    if (is_array($funcs)) {
        foreach ($funcs as $func) {
            $fname = $func['func'];
            $fparams = $func['params'];
            if (function_exists($fname)) {
                if ($fparams) { // checking if we have user defined params{
                    if (is_array($fparams)) { // Checking if params are array
                        if ($extra && is_array($extra)) { // Checking if we have some extra params
                            $fparams = array_merge($fparams, $extra); // If yes, then merge all params
                        }
                    } elseif ($extra) {
                        $fparams = $extra; // It is not array, so assign $extra to $fparams.
                    }
                    if (!empty($fparams)) {
                        $fname($fparams);
                    } else {
                        $fname();
                    }
                } else {
                    if ($extra != null) {
                        $fname($extra);
                    } else {
                        $fname();
                    }
                }
            }
        }
    }
}

/**
 * Register Embed Function
 *
 * @param string $name
 */
function register_embed_function(string $name): void
{
    CBvideo::getInstance()->embed_func_list [] = $name;
}

/**
 * function used to get remote url function
 */
function get_remote_url_function(): string
{
    $funcs = cb_get_functions('remote_url_function');

    if ($funcs) {
        foreach ($funcs as $func) {
            $val = $func['func']();
            if ($val) {
                return $val;
            }
        }
    }
    return 'check_remote_url()';
}
