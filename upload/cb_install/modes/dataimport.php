<div class="nav_des clearfix">
    <div class="cb_container">
		<h4 style="color:#fff;">Creating Database Tables and Importing data</h4>
		<p style="color:#fff; font-size:13px;"></p>
	</div>
</div>

<div id="sub_container">
	<div id="resultsDiv" style="margin-top:20px;">
		<img src="images/loading.gif" alt="loading" id="loading" />
	<?php if(!$upgrade){ ?>
		<span id="current">Creating database structure...</span>
	<?php } else { ?>
		<span id="current">Upgrading clipbucket...</span>
	<?php } ?>
	</div>

	<form name="installation" method="post" id="installation">
		<input type="hidden" name="dbhost" value="<?php echo @$_POST['dbhost']; ?>"/>
		<input type="hidden" name="dbpass" value="<?php echo @$_POST['dbpass']; ?>"/>
		<input type="hidden" name="dbname" value="<?php echo @$_POST['dbname']; ?>"/>
		<input type="hidden" name="dbuser" value="<?php echo @$_POST['dbuser']; ?>"/>
		<input type="hidden" name="dbprefix" value="<?php echo $_POST['dbprefix']; ?>"/>

	<?php if($upgrade){ ?>
		<input type="hidden" name="mode" value="finish_upgrade"/>
	<?php } else { ?>
		<input type="hidden" name="mode" value="adminsettings"/>
	<?php } ?>
	</form>
</div>

<script>
	$(document).ready()
	{
	<?php if($upgrade){ ?>
		dodatabase('upgrade');
	<?php } else { ?>
		dodatabase('structure');
	<?php } ?>
	}
</script>
