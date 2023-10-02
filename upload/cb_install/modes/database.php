<div class="clearfix"></div>

<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Database Settings</h4>
        <p style="color:#fff; font-size:13px;">
            To setup ClipBucketV5, we need some information on the database. You will need to know the following items before proceeding.<br/>
            In all likelihood, these items were supplied to you by your Web Host. If you do not have this information, then you will need to contact them before you can continue.<br/>
            If you&rsquo;re all ready&hellip;Below you should enter your database connection details
        </p>
    </div>
</div>

<div id="sub_container">
    <div class="errorDiv" id="dbresult" style="display:none;"></div>
    <div class="db_fields" style="background-image:url(images/db_img.png);background-repeat:no-repeat;background-position:right;">
        <form method="post" id="installation">
            <div class="field">
                <label class="grey-text" for="host">Host</label>
                <input name="dbhost" type="text" id="host" class="form-control" value="localhost">
                <p class="grey-text font-size" style="margin-top:0;">
                    You should be able to get this info from your web host
                </p>
            </div>

            <div class="field">
                <label class="grey-text" for="dbname">Database Name</label>
                <input type="text" name="dbname" id="dbname" value="" class="form-control">
                <p class="grey-text font-size" style="margin-top:0;">
                    The name of the database you want to run ClipbucketV5 in
                </p>
            </div>

            <div class="field">
                <label class="grey-text" for="dbuser">Database User</label>
                <input type="text" name="dbuser" id="dbuser" value="" class="form-control">
                <p class="grey-text font-size" style="margin-top:0;">
                    Your MYSQL username
                </p>
            </div>

            <div class="field">
                <label class="grey-text" for="dbpass">Database Password</label>
                <input type="text" name="dbpass" id="dbpass" value="" class="form-control">
                <p class="grey-text font-size" style="margin-top:0;">
                    Your MYSQL password
                </p>
            </div>

            <div class="field">
                <label class="grey-text" for="dbprefix">Database Prefix</label>
                <input type="text" name="dbprefix" id="dbprefix" value="cb_" class="form-control">
                <p class="grey-text font-size" style="margin-top:0;">
                    If you want to run multiple Clipbucket installations in a single database,<br/>
                    change this
                </p>
            </div>

            <input type="hidden" name="mode" value="dataimport"/>
        </form>
        <div style="padding:10px 0;"><?php button('Check Connection', ' onclick="dbconnect()" '); ?> <span id="loading"></span></div>
    </div>
</div>