<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Prechecking</h4>
        <p style="color:#fff; font-size:13px;">ClipbucketV5 requires following modules in order to work properly, we are performing some initial search to find modules.
    </div>
</div>

<div id="sub_container">
    <table class="grey-text">
        <tbody>
            <tr>
                <th style="min-width: 80px;">PHP Web</th>
                <td></td>
                <td><?php echo msg_arr(check_module('php_web')); ?></td>
            </tr>
            <tr>
                <td rowspan="5"></td>
                <th style="min-width: 95px;">GD</th>
                <td><?php echo msg_arr(check_extension('gd', 'web')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">MBstring</th>
                <td><?php echo msg_arr(check_extension('mbstring', 'web')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">MySQLi</th>
                <td><?php echo msg_arr(check_extension('mysqli', 'web')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">XML</th>
                <td><?php echo msg_arr(check_extension('xml', 'web')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">cURL</th>
                <td><?php echo msg_arr(check_extension('curl', 'web')); ?></td>
            </tr>
        <tbody>
            <tr>
                <th style="min-width: 80px;">PHP CLI</th>
                <td></td>
                <td><?php echo msg_arr(check_module('php_cli')); ?></td>
            </tr>
            <tr>
                <td rowspan="5"></td>
                <th style="min-width: 95px;">GD</th>
                <td><?php echo msg_arr(check_extension('gd', 'cli')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">MBstring</th>
                <td><?php echo msg_arr(check_extension('mbstring', 'cli')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">MySQLi</th>
                <td><?php echo msg_arr(check_extension('mysqli', 'cli')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">XML</th>
                <td><?php echo msg_arr(check_extension('xml', 'cli')); ?></td>
            </tr>
            <tr>
                <th style="min-width: 95px;">cURL</th>
                <td><?php echo msg_arr(check_extension('curl', 'cli')); ?></td>
            </tr>
        </tbody>
        <tbody>
        <tr>
            <th style="min-width: 80px;">FFMPEG</th>
            <td></td>
            <td><?php echo msg_arr(check_module('ffmpeg')); ?></td>
        </tr>
        <tr>
            <th style="min-width: 80px;">FFPROBE</th>
            <td></td>
            <td><?php echo msg_arr(check_module('ffprobe')); ?></td>
        </tr>
        <tr>
            <th style="min-width: 80px;">Media Info</th>
            <td></td>
            <td><?php echo msg_arr(check_module('media_info')); ?></td>
        </tr>
        </tbody>
    </table>

    <form method="post" id="installation">
        <input type="hidden" name="mode" value="permission"/>
        <div style="padding:10px 0;text-align:right;">
            <?php button('Continue To Next Step', ' onclick="$(\'#installation\').submit()" '); ?>
        </div>
    </form>
</div>
