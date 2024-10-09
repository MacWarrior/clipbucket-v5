<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Checking File & Directories Permissions</h4>
        <p style="color:#fff; font-size:13px;">ClipBucketV5 need some files and folders permissions in order to store files properly, please make sure all files given below are chmod properly.<br/>
            <em>CHMOD : the chmod command (abbreviated from <strong>ch</strong>ange <strong>mod</strong>e) is a shell command and C language function in Unix and Unix-like environments.</em></p>
    </div>
</div>

<div id="sub_container">
    <dl>
        <?php
        $permissions = System::getPermissions();
        foreach ($permissions as $permission) {
            ?>
            <dt style="width:300px;" class="grey-text"><?php echo $permission['path']; ?></dt>
            <dd class="grey-text"><?php echo msg_arr($permission); ?></dd>
        <?php } ?>
    </dl>

    <form method="post" id="installation">
        <div style="padding:10px 0;text-align:right;">
            <?php
            button_green('Recheck', ' onclick="$(\'#mode\').val(\'permission\'); $(\'#installation\').submit()" ');
            button('Continue To Next Step', ' onclick="$(\'#installation\').submit()" ');
            ?>
        </div>

        <?php show_hidden_inputs(); ?>

        <input type="hidden" name="mode" value="database" id="mode"/>
    </form>
</div>
