<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Creating Database Tables and Importing data</h4>
        <p style="color:#fff; font-size:13px;"></p>
    </div>
</div>

<div id="sub_container">
    <div class="errorDiv" style="display:none;"></div>
    <div id="dbresult" style="display:none;"></div>
    <div id="resultsDiv" style="margin-top:20px;">
        <img src="./images/loading.gif" alt="loading" id="loading"/>
        <span id="current"><?php echo !empty($_POST['reset_db']) ? 'Dropping previous tables & datas...':'Creating database structure...'; ?></span>
    </div>

    <form method="post" id="installation">
        <input type="hidden" name="dbhost" value="<?php echo $_POST['dbhost']; ?>"/>
        <input type="hidden" name="dbpass" value="<?php echo $_POST['dbpass']; ?>"/>
        <input type="hidden" name="dbname" value="<?php echo $_POST['dbname']; ?>"/>
        <input type="hidden" name="dbuser" value="<?php echo $_POST['dbuser']; ?>"/>
        <input type="hidden" name="dbport" value="<?php echo $_POST['dbport']; ?>"/>
        <input type="hidden" name="dbprefix" value="<?php echo $_POST['dbprefix']; ?>"/>
        <input type="hidden" name="reset_db" id="reset_db" value="<?php echo $_POST['reset_db'] ?? ''; ?>"/>

        <?php show_hidden_inputs(); ?>

        <input type="hidden" name="mode" value="sitesettings"/>
    </form>
</div>

<script>
    $(document).ready()
    {
        var reset_db = $('#reset_db').val();
        dodatabase(reset_db== '1' ? 'reset_db' : 'structure');
    }
</script>
