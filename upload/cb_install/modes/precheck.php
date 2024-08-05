<div class="nav_des clearfix">
    <div class="cb_container">
        <h4 style="color:#fff;">Prechecking</h4>
        <p style="color:#fff; font-size:13px;">ClipbucketV5 requires following modules in order to work properly, we are performing some initial search to find modules.
    </div>
</div>

<?php
$required_php = get_required_php();
$required_php_extensions = System::get_php_extensions_list();
$required_php_fonctions = get_php_functions();
$required_softwares = get_required_softwares();
$skippable_option = get_skippable_options();
?>

<div id="sub_container" class="grey-text">
    <form method="post" id="installation">
        <dl>
<?php
    $everything_good = true;
    $line = 0;
    foreach($required_php as $php => $php_name) {
        $line++;

        echo '<dt' . ($line %2 == 0 ? ' class=\'white\'' : '') . '>' . $php_name . '</dt>';
        echo '<dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . msg_arr(System::get_software_version($php, true, $_POST[$php . '_filepath'] ?? null)) . '</span></dd>';
        if( !System::get_software_version($php, false, $_POST[$php . '_filepath'] ?? null) || !empty($_POST[$php . '_filepath']) ) {
            $input_test_class = 'refresh';
            if( !System::get_software_version($php, false, $_POST[$php . '_filepath'] ?? null) ) {
                $everything_good = false;
                if( !empty($_POST[$php . '_filepath']) ){
                    $input_test_class = 'remove';
                }
            }
            if( System::get_software_version($php, false, $_POST[$php . '_filepath'] ?? null) && !empty($_POST[$php . '_filepath']) ) {
                $input_test_class = 'ok';
            }

            if( $php == 'php_cli' ){
                echo '
            <dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '>
                <div style="padding-left: 80px;">
                    <div style="display:inline-block;vertical-align:middle;width:175px;">
                        <label class="nowrap" for="' . $php . '_filepath" title="' . $php_name . ' filepath">' . $php_name . ' filepath :</label>
                    </div>
                    <div style="display:inline-block;max-width:30%;vertical-align:middle;">
                        <div class="input-group">
                            <input class="form-control" name="' . $php . '_filepath" id="' . $php . '_filepath" value="' . ($_POST[$php . '_filepath'] ?? '') . '"/>
                            <span class="input-group-addon glyphicon glyphicon-' . $input_test_class . '" id="' . $php . '_filepath_test" title="Check ' . $php_name . ' filepath" style="top:0;"></span>
                        </div>
                    </div>
                </div>
            </dd>';
            }
        }

        $php_extensions = System::get_php_extensions($php, $_POST[$php . '_filepath'] ?? null);
        foreach($required_php_extensions as $key => $extension) {
            if( !System::get_software_version($php, false, $_POST[$php . '_filepath'] ?? null) ){
                break;
            }
            $line++;

            if( empty($php_extensions[$key]) ) {
                $everything_good = false;
                $msg = ['err' => $extension['display'] . ' extension is not enabled'];
            } else {
                $msg = ['msg' => $extension['display'] . ' extension '. $php_extensions[$key]];
            }

            echo '<dt' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . $extension['display'] . '</dt>';
            echo '<dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . msg_arr($msg) . '</span></dd>';
        }

        foreach($required_php_fonctions as $func => $func_name) {
            if( !System::get_software_version($php, false, $_POST[$php . '_filepath'] ?? null) ){
                break;
            }
            $line++;
            echo '<dt' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . $func_name . '</dt>';
            echo '<dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . msg_arr(System::check_php_function($func, ($php == 'php_web' ? 'web' : 'cli'), true, $_POST[$php . '_filepath'] ?? null)) . '</span></dd>';
            if( !System::check_php_function($func, ($php == 'php_web' ? 'web' : 'cli'), false, $_POST[$php . '_filepath'] ?? null) ){
                $everything_good = false;
            }
        }

        if( $php == 'php_web' ){
            if( System::can_sse() ){
                $msg = ['msg' => 'fastcgi_finish_request function available'];
            } else {
                $msg = ['war' => 'fastcgi_finish_request function unavailable'];
            }
            echo '<dt' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>fastcgi_finish_request()</dt>';
            echo '<dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . msg_arr($msg) . '</span></dd>';
        }
    }

    foreach($required_softwares as $soft => $soft_name) {
        $line++;

        $post = $_POST[$soft . '_filepath'] ?? null;
        $filepath_disabled = '';
        if( !empty($skippable_option[$soft]) && !empty($_POST['skip_' . $soft]) ){
            $msg = ['msg' => $soft_name . ' is not required'];
            $filepath_disabled = ' disabled';
            $post = null;
        } else {
            $msg = System::get_software_version($soft, true, $post);
        }

        echo '<dt' . ($line %2 == 0 ? ' class=\'white\'' : '') . '>' . $soft_name . '</dt>';
        echo '<dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '><span>' . msg_arr($msg) . '</span></dd>';

        if( !System::get_software_version($soft, false, $post) || !empty($post) ) {
            $input_test_class = 'refresh';
            if( !System::get_software_version($soft, false, $post) && !empty($post) ) {
                $input_test_class = 'remove';
            }
            if( System::get_software_version($soft, false, $post) && !empty($post) ) {
                $input_test_class = 'ok';
            }

            echo '
            <dd' . ($line %2 == 0 ? ' class=\'white\'' : '') . '>
                <div style="padding-left: 80px;">
                    <div style="display:inline-block;vertical-align:middle;width:175px;">
                        <label class="nowrap" for="' . $soft . '_filepath" title="' . $soft_name . ' filepath">' . $soft_name . ' filepath :</label>
                    </div>
                    <div style="display:inline-block;max-width:30%;vertical-align:middle;">
                        <div class="input-group">
                            <input class="form-control" name="' . $soft . '_filepath" id="' . $soft . '_filepath" value="' . ($post ?? '') . '"' . $filepath_disabled . '/>
                            <span class="input-group-addon glyphicon glyphicon-' . $input_test_class . $filepath_disabled . '" id="' . $soft . '_filepath_test" title="Check ' . $soft_name . ' filepath" style="top:0;"></span>
                        </div>
                    </div>';
            if( !empty($skippable_option[$soft]) ) {
                $checked = !empty($_POST['skip_' . $soft]) ? 'checked' : '';
                echo '<br/><input type=\'checkbox\' name=\'skip_' . $soft . '\' id = \'skip_' . $soft . '\' ' . $checked . '/>
                    <label for=\'skip_' . $soft . '\'>' . $skippable_option[$soft] . '</label>
                ';
                if( !System::get_software_version($soft, false, $post) && empty($_POST['skip_' . $soft]) ){
                    $everything_good = false;
                }
            } else if( !System::get_software_version($soft, false, $post) ){
                $everything_good = false;
            }
            echo '</div>						
            </dd>';
        }
    }
?>

        </dl>

        <input type="hidden" name="mode" value="permission" id="mode"/>
        <div style="text-align:right;">
            <?php
                button_green('Recheck', 'onclick="$(\'#mode\').val(\'precheck\'); $(\'#installation\').submit();" ');
                $params_button_valid = '';
                if( !$everything_good ){
                    $params_button_valid = 'disabled=\'disabled\'';
                    echo '<span title="Please fix your configuration to continue">';
                    button('Continue to next step', $params_button_valid);
                    echo '</span>';
                } else {
                    $params_button_valid = 'onclick="$(\'#installation\').submit()"';
                    button('Continue to next step', $params_button_valid);
                }
            ?>
        </div>
    </form>
</div>
