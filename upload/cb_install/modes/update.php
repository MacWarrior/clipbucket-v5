<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Update</h4>
        <p style="color:#fff; font-size:13px;">Your ClipBucketV5 installation seems outdated, please update for the best experience !
    </div>
</div>

<?php


?>
<div id="sub_container" class="grey-text"">
<div style="text-align: center;">
    <div class="errorDiv" style="display:none;"></div>
    <div id="resultDiv" class="alert alert-success" style="display:none; "></div>
</div>
    <dl style="margin-top: 10px;">
        <dd>
            <?php

                echo '<div id="update_button"><span>A new version is available ! Click here to update <button class="btn btn-success update_core " style="min-width: 6em;">
                        <div class="text">Update</div>
                        <div class="spinner-content" id="spinner-content" style="display: none;">
                            <p class="fa-spinner fa fa-spin animate-spin"></p>
                        </div>
                        </button></span><br></div>';
                $diff_log = Update::getInstance()->getChangeLogDiffCurrent();?>
                <div id="changelog">
                    <?php if ($diff_log) {
                        echo Update::getInstance()->getChangelogHTML($diff_log);
                    } else {
                        echo '<span>The new revision has the same changelog</span>';
                    } ?>
                </div>
        </dd>
    </dl>
</div>
<div id="sub_container" class="grey-text">
    <form method="post" id="installation">
        <input type="hidden" name="mode" value="permission" id="mode"/>
        <div style="text-align:right;">
            <button id="submit_update" class="btn-success btn" style="min-width: 10em;">
                <div class="text">Continue to next step</div>
                <div class="spinner-content" id="spinner-content" style="display: none;">
                    <p class="fa-spinner fa fa-spin animate-spin"></p>
                </div></button>
        </div>
    </form>
</div>
<script>
    var need_update = <?php echo $need_update ?: 0;?>;
</script>
