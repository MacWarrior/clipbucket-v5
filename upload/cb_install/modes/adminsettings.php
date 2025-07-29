<?php
Migration::updateConfig('base_url', post('base_url'));
Migration::updateConfig('site_title', post('title'));
Migration::updateConfig('site_slogan', post('slogan'));
Migration::updateConfig('timezone', post('timezone'));
Migration::updateConfig('nginx_vhost_version', Update::getInstance()->getCurrentCoreVersion());
Migration::updateConfig('nginx_vhost_revision', Update::getInstance()->getCurrentCoreRevision());
Migration::updateConfig('enable_anonymous_stats', post('anonymous_stats') ? 'yes' : 'no' );
?>

<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;"><?php echo lang('admin_account'); ?></h4>
        <p style="color:#fff;font-size:13px;">
            <?php echo lang('admin_install_info'); ?>
        </p>
    </div>
</div>

<div id="sub_container">
    <form method="post" id="installation" style="background-image:url(./images/user_thumb.png);background-repeat:no-repeat;background-position:right;">
        <div class="field">
            <label class="grey-text" for="username"><?php echo lang('admin_username'); ?></label>
            <input name="username" type="text" id="username" class="form-control" value="admin">
            <p class="grey-text font-size" style="margin-top:0;">
                <?php echo lang('admin_username'); ?>
            </p>
        </div>
        <br/>
        <div class="field">
            <label class="grey-text" for="password"><?php echo lang('admin_password'); ?></label>
            <input name="password" type="password" id="password" class="form-control" value="admin">
            <a href="javascript:void(0);" onclick="newpassword();"><?php echo lang('generate'); ?></a> | <strong><?php echo lang('current'); ?></strong> : <span id="genPass" style="color:#09c;"><strong>admin</strong></span>
        </div>
        <br/>
        <div class="field">
            <label class="grey-text" for="email"><?php echo lang('admin_email'); ?></label>
            <input name="email" type="text" id="email" class="form-control" value="admin@<?php echo $_SERVER['HTTP_HOST']; ?>">
            <p class="grey-text font-size" style="margin-top:0;">
                <?php echo lang('hint_admin_email'); ?>
            </p>
        </div>
        <br/>

        <input type="hidden" name="mode" value="finish"/>
        <?php button(lang('save_continue'), ' onclick="$(\'#installation\').submit()" '); ?>
    </form>
</div>