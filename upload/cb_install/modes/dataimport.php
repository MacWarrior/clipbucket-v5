<div class="nav_des clearfix">
    <div class="cb_container">
		<h4 style="color:#fff;">Creating Database Tables and Importing data</h4>
		<p style="color:#fff; font-size:13px;"></p>
	</div>
</div>

<div id="sub_container">
	<div id="resultsDiv" style="margin-top:20px;">
		<img src="images/loading.gif" alt="loading" id="loading" />
		<span id="current">Creating database structure...</span>
	</div>

	<form name="installation" method="post" id="installation">
		<input type="hidden" name="dbhost" value="<?php echo @$_POST['dbhost']; ?>"/>
		<input type="hidden" name="dbpass" value="<?php echo @$_POST['dbpass']; ?>"/>
		<input type="hidden" name="dbname" value="<?php echo @$_POST['dbname']; ?>"/>
		<input type="hidden" name="dbuser" value="<?php echo @$_POST['dbuser']; ?>"/>
		<input type="hidden" name="dbprefix" value="<?php echo $_POST['dbprefix']; ?>"/>

		<input type="hidden" name="mode" value="adminsettings"/>
	</form>
</div>

<script>
	$(document).ready()
	{
		dodatabase('structure');
	}
</script>
