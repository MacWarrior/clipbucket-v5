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
function register_action($name, $type = null)
{
    global $Cbucket;
    if (is_array($name)) {
        foreach ($name as $key => $naam) {
            if (is_array($naam)) {
                foreach ($naam as $name) {
                    $Cbucket->actionList[$name][] = $key;
                }
            } else {
                $Cbucket->actionList[$naam][] = $key;
            }
        }
    } else {
        if ($type != null) {
            $Cbucket->actionList[$type][] = $name;
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
function ANCHOR($params)
{
    if( empty($params['place']) ){
        return;
    }

    global $Cbucket;
    //Getting List of codes to display at this anchor
    $codes = $Cbucket->get_anchor_codes($params['place']);
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
    $funcs = $Cbucket->get_anchor_function_list($params['place']);
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
 * before_comments etc.. see complete list on http://docs.clip-bucket.com
 *
 * @param      $name
 * @param null $type
 */
function register_anchor($name, $type = null)
{
    global $Cbucket;
    if (is_array($name)) {
        foreach ($name as $key => $naam) {
            if (is_array($naam)) {
                foreach ($naam as $name) {
                    $Cbucket->anchorList[$name][] = $key;
                }
            } else {
                $Cbucket->anchorList[$naam][] = $key;
            }
        }
    } else {
        if ($type != null) {
            $Cbucket->anchorList[$type][] = $name;
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
    global $Cbucket;

    if( empty($type) ){
        if( in_dev() ){
            error_log('register_anchor_function '.$method.' must have a type specified');
        }
        return false;
    }

    if (empty($class)) {
        $Cbucket->anchor_function_list[$type][] = $method;
    } else {
        $Cbucket->anchor_function_list[$type][] = [
            'class'    => $class
            , 'method' => $method
        ];
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
 * http://docs.clip-bucket.com. for reference
 * @param        $name
 * @param        $link
 * @param bool $plug_folder
 * @param bool $is_player_file
 */
function add_admin_menu($header, $name, $link, $plug_folder = false, $is_player_file = false)
{
    if (NEED_UPDATE) {
        return;
    }

    global $Cbucket;

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
 * please check docs.clip-bucket.com for "how to add custom upload field"
 *
 * @param $array
 */
function register_custom_upload_field($array)
{
    global $Upload;
    $name = key($array);
    if (is_array($array) && !empty($array[$name]['name'])) {
        foreach ($array as $key => $arr) {
            $Upload->custom_upload_fields[$key] = $arr;
        }
    }
}

/**
 * Function used to add custom form fields
 * In this you will provide an array that has a complete
 * details of the field such as 'name',validate_func etc
 * please check docs.clip-bucket.com for "how to add custom form field"
 *
 * @param      $array
 * @param bool $isGroup
 */
function register_custom_form_field($array, $isGroup = false)
{
    global $Upload;
    $name = key($array);

    if (!$isGroup) {
        if (is_array($array) && !empty($array[$name]['name'])) {
            foreach ($array as $key => $arr) {
                $Upload->custom_form_fields[$key] = $arr;
            }
        }
    } else {
        if (is_array($array) && !empty($array['group_name'])) {
            $Upload->custom_form_fields_groups[] = $array;
        }
    }
}

/**
 * Function used to add custom signup form fields
 * In this you will provide an array that has a complete
 * details of the field such as 'name',validate_func etc
 * please check docs.clip-bucket.com for "how to add custom signup field"
 *
 * @param $array
 */
function register_signup_field($array)
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
 * please check docs.clip-bucket.com for "how to add custom form field"
 *
 * @param      $array
 * @param bool $isGroup
 */
function register_custom_profile_field($array, $isGroup = false)
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
 * @param string Function name
 */
function register_after_video_upload_action($func)
{
    global $Upload;
    $Upload->actions_after_video_upload[] = $func;
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

    global $Cbucket;
    if (empty($class)) {
        $Cbucket->actions_play_video[] = $method;
    } else {
        $Cbucket->actions_play_video[] = [
            'class'    => $class
            , 'method' => $method
        ];
    }
    return true;
}

function register_collection_delete_functions($func)
{
    global $cbcollection;
    $cbcollection->collection_delete_functions[] = $func;
}

/**
 * function use to register function that will be
 * called while deleting a video
 *
 * @param string $func
 */
function register_action_remove_video($func)
{
    global $cbvid;
    //Editing this thing without special consideration can trun whole CB into "WTF"
    $cbvid->video_delete_functions[] = $func;
}

/**
 * Function used to register function , that will be called when deleting video files
 *
 * @param string $func
 */
function register_action_remove_video_files($func)
{
    global $Cbucket;
    $Cbucket->on_delete_video[] = $func;
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
function register_cb_captcha($func, $ver_func, $show_field = true)
{
    global $Cbucket;
    $Cbucket->captchas[] = ['load_function' => $func, 'validate_function' => $ver_func, 'show_field' => $show_field];
}

/**
 * FUnction used to register ClipBucket php functions
 *
 * @param      $func_name
 * @param      $place
 * @param null $params
 */
function cb_register_function($func_name, $place, $params = null)
{
    global $Cbucket;

    if (function_exists($func_name)) {
        $Cbucket->clipbucket_functions[$place][] = ['func' => $func_name, 'params' => $params];
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
    global $Cbucket;
    if (isset($Cbucket->clipbucket_functions[$place])) {
        if (count($Cbucket->clipbucket_functions[$place]) > 0) {
            return $Cbucket->clipbucket_functions[$place];
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
function cb_call_functions($place, $extra = null)
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
 * @param $name
 */
function register_embed_function($name)
{
    global $cbvid;
    $cbvid->embed_func_list [] = $name;
}

/**
 * function used to get remote url function
 */
function get_remote_url_function()
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

