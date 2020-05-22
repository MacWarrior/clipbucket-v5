
</div>

<div class="nav_des clearfix">
    <div class="cb_container">
	<h4 style="color:#fff;">Admin Settings</h4>
	<p style="color:#fff; font-size:13px;">
		All major steps are done, now enter username and password for your admin,
		by default its username : <strong>admin</strong> | pass : <strong>admin</strong><br/>
		we now update installation details and insert language phrases.
	</p>
	<p>
<?php

$baseurl = dirname(GetServerURL());
if(substr($baseurl,strlen($baseurl)-1,1)=='/'){
	$baseurl = substr($baseurl,0,strlen($baseurl)-1);
}

$db->update(tbl("config"),array("value"),array($baseurl)," name='baseurl'");
$db->update(tbl("config"),array("value"),array(BASEDIR)," name='basedir'");

echo '<span class="glyphicon glyphicon-ok" style="color:#fff"></span><span style="color:#fff"> Installation details have been updated</span>';

$lang_obj->updateFromPack('en');

echo '<br><span class="glyphicon glyphicon-ok" style="color:#fff"></span><span style="color:#fff"> Language phrases have been imported</span>';
?>
		</p>
	</div>
</div>
<div id="sub_container">
	<form name="installation" method="post" id="installation" style="background-image:url(<?php echo installer_path(); ?>images/user_thumb.png);background-repeat:no-repeat;background-position:right;">
		<div class="field">
			<label class="grey-text" for="username">Admin username</label>
			<input name="username" type="text" id="username" class="form-control" value="admin">
			<p class="grey-text font-size" style="margin-top:0;">
				Username can have only alphanumeric characters, Underscores
			</p>
		</div>
		<br/>
		<div class="field">
			<label class="grey-text" for="password">Admin Password</label>
			<input name="password" type="password" id="password" class="form-control" value="admin">
			<a href="javascript:void(0);" onclick="newpassword();" >Generate</a> | <strong>Current</strong> : <span id="genPass" style="color:#09c;"><strong>admin</strong></span>
		</div>
		<br/>
		<div class="field">
			<label class="grey-text" for="email">Admin Email</label>
			<input name="email" type="text" id="email" class="form-control" value="admin@thiswebsite.com">
			<p class="grey-text font-size" style="margin-top:0;">
				Double check your email address before continuing
			</p>
		</div>

		<input type="hidden" name="mode" value="sitesettings" /><br>
		<?php button('Save and Continue',' onclick="$(\'#installation\').submit()" '); ?>
	</form>
</div>