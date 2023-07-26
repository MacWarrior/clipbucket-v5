<?php

$baseurl = dirname(GetServerURL());
if (substr($baseurl, strlen($baseurl) - 1, 1) == '/') {
    $baseurl = substr($baseurl, 0, strlen($baseurl) - 1);
}

$db->update(tbl('config'), ['value'], [$baseurl], " name='baseurl'");
$db->update(tbl('config'), ['value'], [BASEDIR], " name='basedir'");
?>

<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Admin Settings</h4>
        <p style="color:#fff;font-size:13px;">
            All major steps are done, now enter username and password for your admin,
            by default its username : <strong>admin</strong> | pass : <strong>admin</strong>
        </p>
    </div>
</div>

<div id="sub_container">
    <form method="post" id="installation" style="background-image:url(images/user_thumb.png);background-repeat:no-repeat;background-position:right;">
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
            <a href="javascript:void(0);" onclick="newpassword();">Generate</a> | <strong>Current</strong> : <span id="genPass" style="color:#09c;"><strong>admin</strong></span>
        </div>
        <br/>
        <div class="field">
            <label class="grey-text" for="email">Admin Email</label>
            <input name="email" type="text" id="email" class="form-control" value="admin@thiswebsite.com">
            <p class="grey-text font-size" style="margin-top:0;">
                Double check your email address before continuing
            </p>
        </div>

        <input type="hidden" name="mode" value="sitesettings"/>
        <?php button('Save and Continue', ' onclick="$(\'#installation\').submit()" '); ?>
    </form>
</div>