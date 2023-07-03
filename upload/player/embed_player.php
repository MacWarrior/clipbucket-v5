<?php
define('THIS_PAGE', 'watch_video');
global $cbvid;
include("../includes/config.inc.php");

$vkey = $_GET['vid'];
//getting video details by key
$vdetails = $cbvid->get_video($vkey);
increment_views_new($vkey, 'video');
$width = @$_GET['width'];
$height = @$_GET['height'];
$autoplay = @$_GET['autoplay'];

if (!$width) {
    $width = '320';
}

if (!$height) {
    $height = '240';
}

if (!$autoplay) {
    $autoplay = 'no';
}

if (!$vdetails) {
    exit(json_encode(["err" => "no video details found"]));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $vdetails['title']; ?></title>
    <script type="text/javascript" src="/styles/cb_28/theme/js/jquery-3.6.4.min.js"></script>
    <?php
    Template(STYLES_DIR . '/global/head.html', false);
    ?>
</head>

<body style="margin:0;padding:0;">
<?php
flashPlayer(['vdetails' => $vdetails, 'width' => $width, 'height' => $height, 'autoplay' => $autoplay]);
?>
</body>
</html>
