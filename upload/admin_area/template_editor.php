<?php
define('THIS_PAGE', 'template_editor');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->perm_check('manage_template_access', true);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('template_editor'), 'url' => DirPath::getUrl('admin_area') . 'template_editor.php'];

/**
 * Getting List Of Templates
 */
$templates = $cbtpl->get_templates();

#Checking if user has selected template for editing, if not, make SELECTED template for editing
$sel_dir = $_GET['dir'];
if (!$sel_dir || !$cbtpl->is_template($sel_dir)) {
    $sel_dir = TEMPLATE;
}

//Checking if still there is no template, display error
if (!$cbtpl->is_template($sel_dir)) {
    e('No Template Found');
} else {
    assign('sel_dir', $sel_dir);
    //Getting list template layout files , i.e HTML files
    $files = $cbtpl->get_template_files($sel_dir);
    assign('tpl_files', $files);
    //Getting list of css files
    $css_files = $cbtpl->get_template_files($sel_dir, 'theme');
    assign('css_files', $css_files);

    //Reading File
    if (isset($_GET['file']) && isset($_GET['folder'])) {
        $file = DirPath::get('styles') . TEMPLATE . DIRECTORY_SEPARATOR . $_GET['folder'] . DIRECTORY_SEPARATOR . $_GET['file'];

        if (file_exists($file)) {
            if (isset($_POST['update_file'])) {
                if (is_writable($file)) {
                    //echo $file;
                    $data = $_POST['thecontent'];
                    $open_file = fopen($file, 'w');
                    fwrite($open_file, stripslashes($data));
                    e('File has been updated', 'm');
                } else {
                    e('Unable to write file');
                }
            }

            $content = htmlentities(file_get_contents($file));
            assign('content', $content);

            if (!is_writable($file)) {
                assign('writeable', 'no');
            } else {
                assign('writeable', 'yes');
            }
        }
    }
}

//Getting And Listing Files
if (!file_exists(DirPath::get('styles') . @$_GET['temp']) || @$_GET['temp'] == '') {
    $dir = SITETEMPLATEDIR . '/layout/';
    $cur_dir = TEMPLATE;
} else {
    $dir = DirPath::get('styles') . $_GET['temp'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR;
    $cur_dir = $_GET['temp'];
}
if (!($dp = opendir($dir))) {
    die("Cannot open $dir.");
}
while ($file = readdir($dp)) {
    $ext = getExt($file);
    if ($ext == 'html' || $ext == 'HTML') {
        $files[] = $file;
    }
}
closedir($dp);
sort($files);
Assign('files', $files);

//Writing File
if (isset($_POST['save'])) {
    $file = $dir . $_POST['file'];
    $data = stripslashes($_POST['data']);
    $open_file = fopen($file, "w");
    fwrite($open_file, $data);
    $msg = $_POST['file'] . " Has Been Saved And Updated";
}

//Getting Data from File
if (isset($_POST['file'])) {
    $file = $dir . $_POST['file'];
    $_file = $_POST['file'];
} else {
    $file = $dir . $files[0];
    $_file = $files[0];
}
$open_file = fopen($file, "r");
$data = htmlentities(file_get_contents($file));

template_files('template_editor.html');
display_it();
