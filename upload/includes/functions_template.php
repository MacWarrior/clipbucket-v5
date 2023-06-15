<?php
function redirect_to($url){
    echo '<script type="text/javascript">
		window.location = "'.$url.'"
		</script>';
    exit("Javascript is turned off, <a href='$url'>click here to go to requested page</a>");
}

//Test function to return template file
function Fetch($name,$inside=FALSE)
{
    global $cbtpl;
    if($inside){
        $file = $cbtpl->fetch($name);
    } else {
        $file = $cbtpl->fetch(LAYOUT.DIRECTORY_SEPARATOR.$name);
    }

    return $file;
}

//Simple Template Displaying Function
function Template($template,$layout=true){
    global $admin_area,$cbtpl;
    if($layout) {
        $cbtpl->display(LAYOUT.DIRECTORY_SEPARATOR.$template);
    } else {
        $cbtpl->display($template);
    }

    if($template == 'footer.html' && $admin_area !=TRUE){
        $cbtpl->display(BASEDIR.'/includes/templatelib/'.$template);
    }
    if($template == 'header.html'){
        $cbtpl->display(BASEDIR.'/includes/templatelib/'.$template);
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
    return json_encode(['msg'=>$msg, 'template'=>$template]);
}

function Assign($name,$value)
{
    global $cbtpl;
    $cbtpl->assign($name,$value);
}

/**
 * Return Head menu of CLipBucket front-end
 *
 * @param array $params
 * @return array
 */
function cb_menu($params=NULL){ global $Cbucket; return $Cbucket->cbMenu($params); }

/**
 * Function used to call display
 */
function display_it()
{
    try {
        global $ClipBucket,$__devmsgs,$breadcrumb;
        if (is_array($__devmsgs)) {
            assign('thebase', BASEDIR);
            assign('__devmsgs',$__devmsgs);
        }
        $new_list = array();
        foreach($ClipBucket->template_files as $file) {
            if(file_exists(LAYOUT.DIRECTORY_SEPARATOR.$file['file']) || is_array($file)) {
                if($ClipBucket->show_page || !$file['follow_show_page']) {
                    if(!is_array($file)){
                        $new_list[] = $file;
                    } else {
                        if(isset($file['folder']) && file_exists($file['folder'].DIRECTORY_SEPARATOR.$file['file'])){
                            $new_list[] = $file['folder'].DIRECTORY_SEPARATOR.$file['file'];
                        } else {
                            $new_list[] = $file['file'];
                        }
                    }
                }
            }
        }

        assign('template_files',$new_list);
        assign('breadcrumb', $breadcrumb);

        Template('body.html');

        footer();
    }
    catch(SmartyException $e) {
        show_cb_error($e);
    }
}

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
function display_language_edit()
{
    $detail = Language::getInstance()->getLangById($_POST['language_id']);
    assign('lang_details', $detail);
    echo templateWithMsgJson('blocks/language_edit.html');
}