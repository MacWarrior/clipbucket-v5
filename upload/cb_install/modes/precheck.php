<?php
$php_ver = check_module('php');
?>

</div>

<div class="nav_des clearfix">
    <div class="cb_container">
    <h4 style="color:#fff;">Prechecking</h4>
    <p style="color:#fff; font-size:13px;">Clipbucket requires following modules in order to work properly, we are performing some initial search to find modules.
<a href="http://docs.clip-bucket.com/clipbucket-docs/clipbucket-installation#requirments" style="color:#fff;text-decoration:underline;">Click here</a> for why we need these modules
<p></p>

</div><!--cb_container-->
</div><!--nav_des-->

  <div class="cb_container">
    <div style="margin-top: 18px;margin-left: 135px;" >
      <script src="//www.googletagservices.com/tag/js/gpt.js">
        googletag.pubads().definePassback('/152929750/cb_installer_horizontal_banner', [[728, 90], [970, 90]]).display();
      </script>
    </div>
  </div>

<div id="sub_container" >
<dl>
	<dt class="grey-text">PHP</dt>
	<?php $php_ver = check_module('php');  ?>
	<dd><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($php_ver); ?></span></dd>

	<dt class="grey-text">FFMPEG</dt>
	<?php $ffmpeg_ver = check_module('ffmpeg'); ?>
	<dd style="background-color:#fff;"><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($ffmpeg_ver); ?></span></dd>

	<dt class="grey-text">FFPROBE</dt>
	<?php $ffprobe_ver = check_module('ffprobe'); ?>
	<dd style="background-color:#fff;"><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($ffprobe_ver); ?></span></dd>

	<dt class="grey-text">MP4Box</dt>
	<?php $mp4boxver = check_module('mp4box'); ?>
	<dd style="background-color:#fff;"><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($mp4boxver); ?></span></dd>

	<dt class="grey-text">cURL</dt>
	<?php $curlver = check_module('curl'); ?>
	<dd><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($curlver); ?></span></dd>

	<dt class="grey-text">Media Info</dt>
	<?php $media_info = check_module('media_info'); ?>
	<dd  style="background-color:#fff;"><span style="margin-left:60px;" class="grey-text"><?php echo msg_arr($media_info); ?></span></dd>
</dl>

<form name="installation" method="post" id="installation">
    <input type="hidden" name="mode" value="permission" />
    <div style="padding:10px 0;" align="right"><?php button('Continue To Next Step',' onclick="$(\'#installation\').submit()" '); ?></div>
</form>
