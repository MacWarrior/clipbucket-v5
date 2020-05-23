<?php
$db->update(tbl("config"),array("value"),array(now())," name='date_updated' ");

if(file_exists(FILES_DIR.'/temp/install.me')){
	unlink(FILES_DIR.'/temp/install.me');
}
?>

<div class="nav_des clearfix">
    <div class="cb_container">
		<h4 style="color:#fff">Your Clipbucket has been successfully upgraded to <?php echo VERSION; ?></h4>
		<p style="color:#fff; font-size:13px;">You have succesfully upgraded clipbucket, you may be insterested in following plugins to <strong>enhance your website</strong></p>
	</div>
</div>

<div id="sub_container">
	<div class="errorDiv">
		<span style="color:#A32727;">Please delete cb_install directory</span>
	</div>

	<div style="margin-top:40px;text-align:center;">
        <?php
        button_danger("Continue to Admin Area",' onclick="window.location=\'/admin_area\'" ');
        button("Continue to ".display_clean(config('site_title')),' onclick="window.location=\'/\'" ');
        ?>
	</div>
</div>

