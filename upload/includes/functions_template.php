<?php
function redirect_to($url)
{
    $header = './';
    //if not complete URL
    if (!preg_match('/https?:\/\//',$url )) {
        //make sure we don't have .// in URL
        $url= preg_replace('/\/\//', '/', $header.$url);
    }
    header('Location: ' . $url);
    die();
}

//Test function to return template file
function Fetch($name, $inside = false)
{
    global $cbtpl;
    if ($inside) {
        $file = $cbtpl->fetch($name);
    } else {
        $file = $cbtpl->fetch(LAYOUT . DIRECTORY_SEPARATOR . $name);
    }

    return $file;
}

//Simple Template Displaying Function
function Template($template, $layout = true)
{
    global $cbtpl;
    if ($layout) {
        $cbtpl->display(LAYOUT . DIRECTORY_SEPARATOR . $template);
    } else {
        $cbtpl->display($template);
    }
}

/**
 * return JSON string containing msg template and $template
 * use this for AJAX call to print result template and msg generated with e()
 * @param $template
 * @return string|false
 */
function templateWithMsgJson($template)
{
    ob_start();
    Template('msg.html');
    $msg = ob_get_contents();
    ob_clean();
    Template($template);
    $template = ob_get_clean();
    return json_encode(['msg' => $msg, 'template' => $template]);
}

function getTemplateMsg()
{
    ob_start();
    Template('msg.html');
    return ob_get_clean();
}

function Assign($name, $value)
{
    global $cbtpl;
    $cbtpl->assign($name, $value);
}

/**
 * Return Head menu of CLipBucket front-end
 *
 * @param array $params
 * @return array
 * @throws Exception
 */
function cb_menu($params = null)
{
    global $Cbucket;
    return $Cbucket->cbMenu($params);
}

/**
 * Function used to call display
 */
function display_it()
{
    try {
        global $__devmsgs, $breadcrumb;
        if( in_dev() ) {
            assign('thebase', DirPath::get('root'));
            assign('__devmsgs', $__devmsgs);
        }

        $new_list = [];
        foreach (ClipBucket::getInstance()->template_files as $file) {
            if (ClipBucket::getInstance()->show_page || !$file['follow_show_page']) {
                if( isset($file['folder']) ){
                    $filepath = $file['folder'].DIRECTORY_SEPARATOR.$file['file'];
                } else {
                    $filepath = LAYOUT.DIRECTORY_SEPARATOR.$file['file'];
                }

                if( file_exists($filepath) ){
                    $new_list[] = $filepath;
                }
            }
        }

        assign('template_files', $new_list);
        assign('breadcrumb', $breadcrumb);

        Template('body.html');

        footer();
    } catch (SmartyException $e) {
        show_cb_error($e);
    }
}

/**
 * @throws Exception
 */
function display_restorable_language_list()
{
    $restorable_langs = get_restorable_languages();
    //Get List Of Languages
    assign('restore_lang_options', $restorable_langs);
    echo templateWithMsgJson('blocks/restorable_language_list.html');
}

/**
 * @throws Exception
 */
function display_language_list()
{
    $ll = Language::getInstance()->get_langs(false, true);
    foreach ($ll as &$language) {
        $language['pourcentage_traduction'] = $language['nb_trads'] * 100 / $language['nb_codes'];
    }
    //Get List Of Languages
    assign('language_list', $ll);
    echo templateWithMsgJson('blocks/language_list.html');
}

/**
 * @throws Exception
 */
function display_language_edit()
{
    $detail = Language::getInstance()->getLangById($_POST['language_id']);
    assign('lang_details', $detail);
    echo templateWithMsgJson('blocks/language_edit.html');
}

/**
 * @throws Exception
 */
function display_thumb_list($data)
{
    assign('data', $data);
    assign('vidthumbs', get_thumb($data,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($data,TRUE,'168x105','custom'));
    echo templateWithMsgJson('blocks/thumb_list.html');
}

function display_resolution_list($data)
{
    assign('resolution_list', $data);
    echo templateWithMsgJson('blocks/resolution_list.html');
}

function display_subtitle_list($data)
{
    assign('subtitle_list', $data);
    echo templateWithMsgJson('blocks/subtitle_list.html');
}

//todO séparer en 2 fonctions
/**
 * @throws Exception
 */
function return_thumb_mini_list($data)
{
    assign('data', $data);
    assign('vidthumbs', get_thumb($data,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($data,TRUE,'168x105','custom'));

    return (templateWithMsgJson('blocks/thumb_mini_list.html'));
}
