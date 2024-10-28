<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Update</h4>
        <p style="color:#fff; font-size:13px;">Check if your ClipbucketV5 version is up to date.
    </div>
</div>

<?php

/**
 * Copy of function from includes/functions.php without config()
 * Cannot be declared in both functions_install and functions because some step have them both
 * @TODO find a better way to get git version
 * @param string $format
 * @param string $timeout
 * @return resource
 */
function get_proxy_settings(string $format = '', string $timeout = '')
{
    switch ($format) {
        default:
        case 'file_get_contents':
            $context = null;
            if( !empty($timeout)) {
                $context['http']['timeout'] = (int)$timeout;
            }

            return stream_context_create($context);
    }
}
$isGitInstalled = Update::getInstance()->isGitInstalled();
$isGitManaged = Update::getInstance()->isManagedWithGit();
$isCoreUpToDate = Update::getInstance()->isCoreUpToDate();
?>
<div id="sub_container" class="grey-text">
    <div class="errorDiv" style="display:none;"></div>
    <div id="resultDiv" style="display:none;"></div>
    <dl>
        <dt>
            Client Git
        </dt>
        <dd>
        <span>
            <span class="msg <?php echo $isGitInstalled ? 'ok' : 'alert_cross'; ?>"></span>
        </span>
        </dd>
        <dt class="white">
            Git Check
        </dt>
        <dd class="white">
        <span>
            <span class="msg <?php echo $isGitManaged ? 'ok' : 'alert_cross'; ?>"></span>
        </span>
        </dd>
        <dt>
            Up to date
        </dt>
        <dd>
        <span>
            <?php
                if ($isCoreUpToDate) {
                    echo '<span class="msg ok"></span>';
                } else {
                    echo 'A new version is available ! Click here to update <button class="btn btn-success udpdate_core" >Update</button>';
                    echo Update::getInstance()->getChangelogHTML(Update::getInstance()->getChangeLogDiffCurrent());
                }
            ?>
        </span>
        </dd>
    </dl>
</div>
<div id="sub_container" class="grey-text">
    <form method="post" id="installation">

        <input type="hidden" name="mode" value="permission" id="mode"/>
        <div style="text-align:right;">
            <?php button('Continue to next step', 'onclick="$(\'#installation\').submit()"'); ?>
        </div>
    </form>
</div>
