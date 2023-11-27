<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Prechecking</h4>
        <p style="color:#fff; font-size:13px;">ClipbucketV5 requires following modules in order to work properly, we are performing some initial search to find modules.
    </div>
</div>

<div id="sub_container" class="grey-text">
    <dl>
        <dt>PHP Web</dt>
        <dd><span><?php echo msg_arr(check_module('php_web')); ?></span></dd>
        <dt class="white"><span>GD</dt>
        <dd class="white"><span><?php echo msg_arr(check_extension('gd', 'web')); ?></span></dd>
        <dt><span>MBstring</dt>
        <dd><span><?php echo msg_arr(check_extension('mbstring', 'web')); ?></span></dd>
        <dt class="white"><span>MySQLi</dt>
        <dd class="white"><span><?php echo msg_arr(check_extension('mysqli', 'web')); ?></span></dd>
        <dt><span>XML</dt>
        <dd><span><?php echo msg_arr(check_extension('xml', 'web')); ?></span></dd>
        <dt class="white"><span>cURL</dt>
        <dd class="white"><span><?php echo msg_arr(check_extension('curl', 'web')); ?></span></dd>

        <dt>PHP CLI</dt>
        <dd><span><?php echo msg_arr(check_module('php_cli')); ?></span></dd>
        <dt class="white"><span>GD</dt>
        <dd class="white"><span><?php echo msg_arr(check_extension('gd', 'cli')); ?></span></dd>
        <dt><span>MBstring</dt>
        <dd><span><?php echo msg_arr(check_extension('mbstring', 'cli')); ?></span></dd>
        <dt class="white"><span>MySQLi</dt>
        <dd class="white"><span><?php echo msg_arr(check_extension('mysqli', 'cli')); ?></span></dd>
        <dt><span>XML</dt>
        <dd><span><?php echo msg_arr(check_extension('xml', 'cli')); ?></span></dd>
        <dt class="white"><span>cURL</dt>
        <dd class="white"><span><?php echo msg_arr(check_extension('curl', 'cli')); ?></span></dd>

        <dt>FFMPEG</dt>
        <dd><span><?php echo msg_arr(check_module('ffmpeg')); ?></span></dd>

        <dt class="white">FFPROBE</dt>
        <dd class="white"><span><?php echo msg_arr(check_module('ffprobe')); ?></span></dd>

        <dt>Media Info</dt>
        <dd><span><?php echo msg_arr(check_module('media_info')); ?></span></dd>
    </dl>

    <form method="post" id="installation">
        <input type="hidden" name="mode" value="permission"/>
        <div style="padding:10px 0;text-align:right;">
            <?php button('Continue To Next Step', ' onclick="$(\'#installation\').submit()" '); ?>
        </div>
    </form>
</div>
