<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;"><?php echo lang('website_configuration'); ?></h4>
        <p style="color:#fff; font-size:13px;">
            <?php echo lang('website_configuration_info'); ?>
        </p>
    </div>
</div>

<div id="sub_container">
    <div class="site_fields">
        <form name="installation" method="post" id="installation" style="background-image:url(images/site_setting.png);background-repeat:no-repeat;background-position:right;">
            <br/>
            <div class="field">
                <label for="base_url"><?php echo lang('website_base_url'); ?></label>
                <input name="base_url" type="text" id="base_url" class="form-control" value="<?php echo Network::get_server_url(); ?>">
                <p class="grey-text font-size" style="margin-top:0;">
                    <?php echo lang('website_base_url_hint'); ?>
                </p>
            </div>
            <div class="field">
                <label for="title"><?php echo lang('website_title'); ?></label>
                <input name="title" type="text" id="title" class="form-control" value="ClipBucketV5 - v<?php echo Update::getInstance()->getCurrentCoreVersion(); ?>">
                <p class="grey-text font-size" style="margin-top:0;">
                    <?php echo lang('website_title_hint'); ?>
                </p>
            </div>

            <div class="field">
                <label for="slogan"> <?php echo lang('website_slogan'); ?></label>
                <input name="slogan" type="text" id="slogan" class="form-control" value="A way to broadcast yourself">
                <p class="grey-text font-size" style="margin-top:0;">
                    <?php echo lang('website_slogan_hint'); ?>
                </p>
            </div>

            <div class="field">
                <label  for="email"><?php echo lang('default_language'); ?></label>
                <select name="language" id="language" class="form-control">
                    <?php foreach (Language::getInstance()->get_langs() as $lang) {
                        echo '<option value="'.$lang['language_id'].'">'.$lang['language_name'].'</option>';
                    } ?>
                </select>
            </div>
            <?php $arr = [];
            $arr_cli=[];
            $current_datetime_cli = System::get_php_cli_config('CurrentDatetime');
            if (!System::isDateTimeSynchro($arr) || !System::isDateTimeSynchro($arr,$current_datetime_cli)) {
                $query = /** @lang MySQL */'SELECT timezones.timezone FROM '.cb_sql_table('timezones').' ORDER BY timezones.timezone';
                $rs = Clipbucket_db::getInstance()->_select($query);
                $allTimezone = array_column($rs, 'timezone');?>
                <div class="field">
                    <label  for="timezone"><?php echo lang('option_timezone'); ?></label>
                    <select class="form-control check_timezone has-error" name="timezone" id="timezone" style="display:inline-block;">
                        <option value=""></option>
                        <?php foreach ($allTimezone as $timezone) { ?>
                            <option value="<?php echo $timezone; ?>">
                                <?php echo $timezone; ?>
                            </option>
                      <?php  } ?>
                    </select>
                    <div class="spinner-content" id="spinner-content" style="display: none;">
                        <p class="fa-spinner fa fa-spin animate-spin"></p>
                    </div>
                </div>
            <?php } ?>
            <br/>
            <input type="hidden" name="mode" value="adminsettings"/>
            <button class="btn btn-primary" onclick="$('#installation').submit()"><?php echo lang('save_continue'); ?></button>
        </form>
    </div>
</div>
