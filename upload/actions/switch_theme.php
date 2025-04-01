<?php
define('THIS_PAGE', 'switch_theme');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';


$theme = '';
$url = '';
if (isset($_POST['theme']) && ($_POST['theme'] == 'light' || $_POST['theme'] == 'dark')) {
    $min_suffixe = in_dev() ? '' : '.min';
    User::getInstance()->setActiveTheme($_POST['theme']);
    $theme = $_POST['theme'];
    $url = 'themes/'.$theme. $min_suffixe . '.css?v=' . ClipBucket::getInstance()->getCacheKey();
}
echo json_encode(['theme' => $theme, 'url'=>$url]);
