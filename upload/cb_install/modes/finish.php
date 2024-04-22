<?php
global $myquery;
$title = mysql_clean(post('title'));
$slogan = mysql_clean(post('slogan'));
$baseurl = mysql_clean(post('baseurl'));

//First update website settings
$myquery->Set_Website_Details('site_title', $title);
$myquery->Set_Website_Details('site_slogan', $slogan);
$myquery->Set_Website_Details('baseurl', $baseurl);

if (file_exists(DirPath::get('temp') . 'install.me') && !file_exists(DirPath::get('temp') . 'install.me.not')) {
    unlink(DirPath::get('temp') . 'install.me');
}
?>

<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">ClipBucketV5 - v<?php echo VERSION; ?> <?php echo lang('successful_install'); ?></h4>
    </div>
</div>

<div id="sub_container">
    <div style="margin-top:40px;text-align:center;">
        <?php
        button_danger(lang('continue_admin_area'), ' onclick="window.location=\'/admin_area\'" ');
        button(lang('continue_to') . ' ' . display_clean(config('site_title')), ' onclick="window.location=\'/\'" ');
        ?>
    </div>
</div>