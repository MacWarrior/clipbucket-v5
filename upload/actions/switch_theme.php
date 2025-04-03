<?php
define('THIS_PAGE', 'switch_theme');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$theme = '';
$url = '';
if( isset($_POST['theme']) && in_array($_POST['theme'],['light','dark','auto']) ){
    $min_suffixe = in_dev() ? '' : '.min';

    if( in_array($_POST['theme'], ['light','dark']) ){
        $theme = $_POST['theme'];
    } else if( in_array($_POST['os'], ['light','dark']) ){
        $theme = $_POST['os'];
    } else {
        $theme = config('default_theme');
    }
    $url = DirPath::getUrl('theme_css') . 'themes/'.$theme. $min_suffixe . '.css?v=' . ClipBucket::getInstance()->getCacheKey();

    User::getInstance()->setActiveTheme($_POST['theme']);
}
echo json_encode([
    'theme' => $theme,
    'url'=>$url
]);
