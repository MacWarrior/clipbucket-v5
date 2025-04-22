<div class="nav_des clearfix">
    <div class="cb_container" style="color:#fff;">
        Welcome to ClipBucketV5 - v<?php echo Update::getInstance()->getCurrentCoreVersion(); ?> Installer, this will let you install ClipBucketV5 with few clicks.
        Please contact us on <a href="https://github.com/MacWarrior/clipbucket-v5" target="_blank" style="color:#fff;text-decoration:underline;">GitHub</a> if necessary.
        <br/><br/>
        This version of ClipbucketV5 and futher updates are supported by <a href="https://github.com/MacWarrior/clipbucket-v5" target="_blank" style="color:#fff;text-decoration:underline;">Clipbucket V5</a> team and <a href='https://clipbucket.oxygenz.fr' target='_blank' style="color:#fff;text-decoration:underline;">Oxygenz</a>.
    </div>
</div>

<div id="sub_container">
    <h4 class="grey-text">Clipbucket is an opensource software under <a href="https://opensource.org/license/attribution-php" target="_blank" class="grey-text" style="text-decoration:underline;">Attribution assurance license</a>.</h4>
    <div class="small" style="margin-bottom:5px;">
        Because Clipbucket original is abandoned since 2018 <a href="https://github.com/arslancb/clipbucket" target="_blank" style="text-decoration:none; color:#333;"><i>(officially since 2022)</i></a>, branding removal license can't be bought anymore.<br/>
    </div>
    <div class="cb-instal-licenc-holder">
        <div class="cb-instal-licenc-sec">
            <?php echo System::get_license('LICENSE'); ?>
        </div>
    </div>

    <?php if( !Network::check_forbidden_directory(false) ){ ?>
    <br/>
    <div class="alert alert-danger alert-dismissable container" style="width:100%;">
        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        <ul class="list-unstyled">
            <li>
                <?php Network::check_forbidden_directory(); ?>
            </li>
        </ul>
    </div>
    <?php } ?>

    <form method="post" id="installation">
        <input type="hidden" name="mode" value="precheck"/>
        <div style="padding:10px 0;text-align:right;"><?php button('Ok, I Agree, Now let me Continue !', Network::check_forbidden_directory(false) ? ' onclick="$(\'#installation\').submit()" ' : ' disabled'); ?></div>
    </form>
</div>
