<?php
const THIS_PAGE = 'admin_launch_update';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$core_tool = new AdminTool();

$error_init = [];
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
    $error_init['core'] = $core_tool->initByCode('update_core');
    $error_init['db'] = AdminTool::getInstance()->initByCode('update_database_version');
} else {
    $error_init['core'] = $core_tool->initById(11);
    $error_init['db'] = AdminTool::getInstance()->initById(5);
}

if (($error_init['core'] === false && $_POST['type'] == 'core') || $error_init['db'] === false) {
    echo json_encode([
        'success'   => false
        ,
        'error_msg' => System::isInDev() ? 'Failed to find tools for update' : lang('technical_error')
    ]);
    die();
}

sendClientResponseAndContinue(function () {
    ob_start();
    Update::getInstance()->displayGlobalSQLUpdateAlert($_POST['type']);
    echo json_encode([
        'success' => true,
        'html'=>ob_get_clean()
    ]);
});


if (file_exists(DirPath::get('temp') . 'update_core_tmp.php')) {
    unlink(DirPath::get('temp') . 'update_core_tmp.php');
}
$tmp_file = fopen(DirPath::get('temp') . 'update_core_tmp.php', 'w');
$data = /** @lang PHP */
    '<?php
             if (php_sapi_name() != \'cli\') {
                die;
            }
            const THIS_PAGE = \'update_core_tmp\';
            include_once dirname(__FILE__, 3) .DIRECTORY_SEPARATOR . \'includes\'.DIRECTORY_SEPARATOR . \'admin_config.php\';
            $type = \'' . $_POST['type'] . '\';
            $core_tool = AdminTool::getUpdateCoreTool();
            if (empty($core_tool)) {
                echo  \'false\';
                die;
            }
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo(\'5.5.0\', \'367\')) {
                AdminTool::getInstance()->initByCode(\'update_database_version\');
            } else {
                AdminTool::getInstance()->initById(5);
            }
            if (empty(AdminTool::getInstance())) {
                echo  \'false\';
                die;
            }
            if ($type == \'core\' && $core_tool->isAlreadyLaunch() === false) {
                $core_tool->setToolInProgress();
                $core_tool->launch();
            }
            Update::getInstance()->flush();
            
            if (($type == \'core\' || $type == \'db\') && AdminTool::getInstance()->isAlreadyLaunch() === false) {
                AdminTool::getInstance()->setToolInProgress();
                AdminTool::getInstance()->launch();
            }
            ?>
    ';
fwrite($tmp_file, $data);
fclose($tmp_file);
chdir(DirPath::get('root'));
$cmd = System::get_binaries('php') . ' -q ' . DirPath::get('temp') . 'update_core_tmp.php';
if (stristr(PHP_OS, 'WIN')) {
    $complement = '';
} elseif (stristr(PHP_OS, 'darwin')) {
    $complement = ' </dev/null >/dev/null &';
} else { // for ubuntu or linux
    $complement = ' > /dev/null &';
}

$cmd .= $complement;
shell_exec($cmd);
die;
