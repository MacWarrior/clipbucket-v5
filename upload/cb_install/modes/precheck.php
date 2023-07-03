<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Prechecking</h4>
        <p style="color:#fff; font-size:13px;">Clipbucket requires following modules in order to work properly, we are performing some initial search to find modules.
    </div>
</div>

<div id="sub_container">
    <dl>
        <dt class="grey-text">PHP</dt>
        <?php $php_ver = check_module('php'); ?>
        <dd><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($php_ver); ?></span></dd>

        <dt class="grey-text">FFMPEG</dt>
        <?php $ffmpeg_ver = check_module('ffmpeg'); ?>
        <dd style="background-color:#fff;"><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($ffmpeg_ver); ?></span></dd>

        <dt class="grey-text">FFPROBE</dt>
        <?php $ffprobe_ver = check_module('ffprobe'); ?>
        <dd><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($ffprobe_ver); ?></span></dd>

        <dt class="grey-text">cURL</dt>
        <?php $curlver = check_module('curl'); ?>
        <dd><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($curlver); ?></span></dd>

        <dt class="grey-text">Media Info</dt>
        <?php $media_info = check_module('media_info'); ?>
        <dd style="background-color:#fff;"><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($media_info); ?></span></dd>
    </dl>

    <form method="post" id="installation">
        <input type="hidden" name="mode" value="permission"/>
        <div style="padding:10px 0;text-align:right;">
            <?php button('Continue To Next Step', ' onclick="$(\'#installation\').submit()" '); ?>
        </div>
    </form>
</div>
