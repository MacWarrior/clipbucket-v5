<?php
//Lets just save admin settings so we can move forward
$pass = pass_code(post('password'), 1);

Clipbucket_db::getInstance()->update(
    tbl('users'),
    ['username', 'password', 'email', 'doj', 'num_visits', 'ip', 'signup_ip'],
    [post('username'), $pass, post('email'), now(), 1, Network::get_remote_ip(), Network::get_remote_ip()]
    , 'userid=1'
);

require_once dirname(__DIR__ ). DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
if (file_exists(DirPath::get('temp') . 'development.dev')) {
    require_once DirPath::get('vendor') . 'autoload.php';
    require_once DirPath::get('classes') . 'DiscordLog.php';
    require_once DirPath::get('classes') . 'update.class.php';
    require_once DirPath::get('includes') . 'clipbucket.php';
    require_once DirPath::get('classes') . 'system.class.php';

    //clean lock
    if (conv_lock_exists()) {
        for ($i = 0; $i < config('max_conversion'); $i++) {
            if (file_exists(DirPath::get('temp') . 'conv_lock' . $i . '.loc')) {
                unlink(DirPath::get('temp') . 'conv_lock' . $i . '.loc');
            }
        }
    }
    //launch tool clean
    $tool = AdminTool::getToolByCode('clean_orphan_files');
    if (!empty($tool)) {
        AdminTool::launchCli($tool['id_tool']);
    }
}

//Login user
userquery::getInstance()->login_user(post('username'), post('password'))
?>

<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;"><?php echo lang('website_configuration'); ?></h4>
        <p style="color:#fff; font-size:13px;">
            <?php echo lang('website_configuration_info'); ?>
        </p>
    </div>
</div>

<div id="sub_container">
    <div class="site_fields">
        <form name="installation" method="post" id="installation" style="background-image:url(images/site_setting.png);background-repeat:no-repeat;background-position:right;">
            <br/>
            <div class="field">
                <label for="title"><?php echo lang('website_title'); ?></label>
                <input name="title" type="text" id="title" class="form-control" value="ClipBucketV5 - v<?php echo VERSION . ' ' . STATE; ?>">
                <p class="grey-text font-size" style="margin-top:0;">
                    <?php echo lang('website_title_hint'); ?>
                </p>
            </div>

            <div class="field">
                <label for="slogan"> <?php echo lang('website_slogan'); ?></label>
                <input name="slogan" type="text" id="slogan" class="form-control" value="A way to broadcast yourself">
                <p class="grey-text font-size" style="margin-top:0;">
                    <?php echo lang('website_slogan_hint'); ?>
                </p>
            </div>

            <div class="field">
                <label for="baseurl"><?php echo lang('website_url'); ?></label>
                <input name="baseurl" type="text" id="baseurl" class="form-control" value="<?php echo BASEURL; ?>">
                <p class="grey-text font-size" style="margin-top:0;">
                    <?php echo lang('website_url_hint'); ?>
                </p>
            </div>

            <br/>
            <input type="hidden" name="mode" value="finish"/>
            <?php button(lang('save_continue'), ' onclick="$(\'#installation\').submit()" '); ?>
        </form>
    </div>
</div>
