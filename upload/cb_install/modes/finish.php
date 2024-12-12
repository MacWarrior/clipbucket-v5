<?php
global $myquery;
$pass = pass_code(post('password'), 1);

Clipbucket_db::getInstance()->update(
    tbl('users'),
    ['username', 'password', 'email', 'doj', 'num_visits', 'ip', 'signup_ip'],
    [post('username'), $pass, post('email'), now(), 1, Network::get_remote_ip(), Network::get_remote_ip()]
    , 'userid=1'
);

if (in_dev()) {
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
userquery::getInstance()->login_user(post('username'), post('password'));
if (file_exists(DirPath::get('temp') . 'install.me') && !file_exists(DirPath::get('temp') . 'install.me.not')) {
    unlink(DirPath::get('temp') . 'install.me');
}
?>

<div class="nav_des">
    <h4 style="color:#fff;">ClipBucketV5 - v<?php echo VERSION; ?> <?php echo lang('successful_install'); ?></h4>
</div>

<div id="sub_container">
    <div style="margin-top:40px;text-align:center;">
        <?php
        button_danger(lang('continue_admin_area'), ' onclick="window.location=\'/admin_area\'" ');
        button(lang('continue_to') . ' ' . display_clean(config('site_title')), ' onclick="window.location=\'/\'" ');
        ?>
    </div>
</div>