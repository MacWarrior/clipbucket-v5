<?php
global $myquery;
$title = mysql_clean(post('title'));
$slogan = mysql_clean(post('slogan'));
$baseurl = mysql_clean(post('baseurl'));

//First update website settings
$myquery->Set_Website_Details('site_title', $title);
$myquery->Set_Website_Details('site_slogan', $slogan);
$myquery->Set_Website_Details('baseurl', $baseurl);

if (file_exists(FILES_DIR . '/temp/install.me')) {
    unlink(FILES_DIR . '/temp/install.me');
}
?>

<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">ClipBucket <?php echo VERSION; ?> has been installed successfully !</h4>
    </div>
</div>

<div id="sub_container">
    <div style="margin-top:40px;text-align:center;">
        <?php
        button_danger('Continue to Admin Area', ' onclick="window.location=\'/admin_area\'" ');
        button('Continue to ' . display_clean(config('site_title')), ' onclick="window.location=\'/\'" ');
        ?>
    </div>
</div>