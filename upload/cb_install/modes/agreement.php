<div class="nav_des clearfix">
    <div class="cb_container" style="color:#fff;">
        Welcome to ClipBucket <?php echo VERSION; ?> Installer, this will let you install clipbucket with few clicks.
        Please contact us on <a href="https://github.com/MacWarrior/clipbucket-v5" target="_blank" style="color:#fff;text-decoration:underline;">GitHub</a> if necessary.
        <br/><br/>
        <i>
            Clipbucket is an open-source software under <a href="http://opensource.org/licenses/AAL" target="_blank" style="color:#fff;text-decoration:underline;">Attribution assurance license</a>. Its not scary, it just states that those
            who did all the tough job should get credit for their work in form of their brand name in the footer, you can edit, sell, use this script but you must keep author's and product name on your website until and
            unless you purchase our branding removal license.
        </i>
        <br/><br/>
        Because Clipbucket original is dead since 2018 <i>(officially since 2022)</i>, branding removal license can't be bought anymore.<br/><i class="small">(It would be a shame if branding was integraded in translations system)</i>
        <br/><br/>
        This version of Clipbucket and futher updates are supported by <a href="https://github.com/MacWarrior/clipbucket-v5" target="_blank" style="color:#fff;text-decoration:underline;">Clipbucket V5</a> team and <a href='https://clipbucket.oxygenz.fr' target='_blank'  style="color:#fff;text-decoration:underline;">Oxygenz</a>.
    </div>
</div>

<div id="sub_container">
    <h4 class="grey-text">License</h4>
    <div class="cb-instal-licenc-holder">
        <div class="cb-instal-licenc-sec">
            <?php echo get_cbla(); ?>
        </div>
    </div>

    <form method="post" id="installation">
        <input type="hidden" name="mode" value="precheck"/>
        <div style="padding:10px 0;text-align:right;"><?php button('Ok, I Agree, Now let me Continue!', ' onclick="$(\'#installation\').submit()" '); ?></div>
    </form>
</div>
