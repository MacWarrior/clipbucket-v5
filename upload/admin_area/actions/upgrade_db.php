<?php
const THIS_PAGE = 'upgrade_db';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$need_to_create_version_table = true;
errorhandler::getInstance()->flush_error();
$error = false;
$array_42 = ['4.2-RC1-free', '4.2-RC1-premium'];
if (php_sapi_name() == 'cli') {
    $update = Update::getInstance();

    try {
        $version_db = $update->getDBVersion();
        $version = $version_db['version'];
        $revision = $version_db['revision'];

        if ($version == '-1' || $revision == '-1') {
            if (empty($argv[1]) && empty($argv[2])) {
                $version = readline('Version : ');
                $revision = readline('Revision : ');
            } elseif (empty($argv[1]) || empty($argv[2])) {
                echo 'Version or revision is missing. Please retry ex: php ./actions/upgrade_db.php vers=5.3.0 rev=1' . PHP_EOL;
                die;
            } else {
                parse_str($argv[1], $arg_version);
                parse_str($argv[2], $arg_revision);
                if (empty($arg_version['vers']) || empty($arg_revision['rev'])) {
                    echo 'Version or revision is missing. Please retry ex: php ./actions/upgrade_db.php vers=5.3.0 rev=1' . PHP_EOL;
                    die;
                }
                $revision = (int)$arg_revision['rev'];
                $version = $arg_version['vers'];
            }
            $version_list = $update->getUpdateVersions();
            if (!array_key_exists($version, $version_list)) {
                echo 'Version provided is incorrect' . PHP_EOL;
                echo 'List of accepted versions : ' . PHP_EOL;
                foreach ($version_list as $version_l => $revision_l) {
                    echo '- ' . $version_l . PHP_EOL;
                }
                die;
            }
            if ($revision > $version_list[$version]) {
                echo 'Revision provided is incorrect' . PHP_EOL;
                echo 'Max revision allowed for selected version : ' . $version_list[$version] . PHP_EOL;
                die;
            }
        } else {
            $need_to_create_version_table = false;
            if (!empty($argv[1]) || !empty($argv[2])) {
                echo 'Upgrade system is already installed, parameters so are ignored' . PHP_EOL;
            }
        }
        //add verification
        if (!$need_to_create_version_table && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', 165)) {
            $core_tool = new AdminTool();
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
                $core_tool->initByCode('update_core');
            } else {
                $core_tool->initById('11');
            }
            if ($core_tool->isAlreadyLaunch()) {
                echo 'A core update is already ongoing, should it be marked as failed ? (Y/N)';
                ob_flush();
                $stdin = fopen('php://stdin', 'r');
                $response = fgetc($stdin);
                if (strtolower($response) != 'y') {
                    echo "Aborted.\n";
                    die;
                } else {
                    $core_tool->setToolError($core_tool->getId(),true);
                }
            }
            $db_tool = new AdminTool();
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
                $db_tool->initByCode(AdminTool::CODE_UPDATE_DATABASE_VERSION);
            } else {
                $db_tool->initById('5');
            }
            if ($db_tool->isAlreadyLaunch()) {
                echo 'A database upgrade is ongoing, should it be marked as failed ? (Y/N)';
                ob_flush();
                $stdin = fopen('php://stdin', 'r');
                $response = fgetc($stdin);
                if (strtolower($response) != 'y') {
                    echo "Aborted.\n";
                    die;
                } else {
                    $db_tool->setToolError($db_tool->getId(),true);
                }
            }
            /** @var AdminTool $core_tool */
            if (!empty(VideoConversionQueue::get_conversion_queue(['not_complete'=>true]))) {
                echo 'A video conversion is ongoing, do you want to continue update ? (Y/N)';
                ob_flush();
                $stdin = fopen('php://stdin', 'r');
                $response = fgetc($stdin);
                if (strtolower($response) != 'y') {
                    echo "Aborted.\n";
                    die;
                }
            }
        }
    } catch (\Exception $e) {
        throw $e;
    }

} else {
    if (empty($_REQUEST['version']) || empty($_REQUEST['revision'])) {
        error_lang_cli('Version or revision is missing');
        $error = true;
    }

    $revision = $_REQUEST['revision'];
    $version = $_REQUEST['version'];
}

$regex_version = '(\d+\.\d+\.\d+)';
$mysqlReq = System::MIN_MYSQL_VERSION;
assign('mysqlReq', $mysqlReq);
$cmd = 'mysql --version';
exec($cmd, $mysql_client_output);
$match_mysql = [];
preg_match($regex_version, $mysql_client_output[0], $match_mysql);
$clientMySqlVersion = $match_mysql[0] ?? false;
if (version_compare($clientMySqlVersion, $mysqlReq) < 0) {
    error_lang_cli(sprintf('Current version of MySQL Client is %s, minimal version %s is required. Please update' . PHP_EOL, $clientMySqlVersion, $mysqlReq));
    $error = true;
}

$serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
preg_match($regex_version, $serverMySqlVersion, $match_mysql);
$serverMySqlVersion = $match_mysql[0] ?? false;
if (version_compare($serverMySqlVersion, $mysqlReq) < 0) {
    error_lang_cli(sprintf('Current version of MySQL Server is %s, minimal version %s is required. Please update' . PHP_EOL, $serverMySqlVersion, $mysqlReq));
    $error = true;
}

if ($need_to_create_version_table) {
    $revisions = getRevisions();
    if (!array_key_exists($version, $revisions) || ($revisions[$version]) < $revision) {
        error_lang_cli('Revision provided is incorrect');
        $error = true;
    }
    $table_version_path = DirPath::get('sql') . 'table_version.sql';
    $lines = file($table_version_path);
    if (empty($lines)) {
        error_lang_cli('Version system initialisation failed because table_version.sql is missing or empty ; please make sure your code is up-to-date and table_version.sql file is correct.');
        $error = true;
    }
}
if ($error) {
    if (php_sapi_name() != 'cli') {
        echo json_encode([
            'success' => false
            , 'msg'   => getTemplateMsg()
        ]);
    }
    return false;
}

$templine = '';
$file_OK = false;
if (php_sapi_name() != 'cli') {
//create progress file
    try {
        $path_file_temp = DirPath::get('files') . 'temp' . DIRECTORY_SEPARATOR . 'process_migration';
        if (file_exists($path_file_temp)) {
            unlink($path_file_temp);
        }
        $file_temp = fopen($path_file_temp, 'w');
        if ($file_temp) {
            fclose($file_temp);
            $file_OK = true;
        }
    } catch (Exception $exception) {}
}
try {
    if ($need_to_create_version_table) {
        execute_sql_file($table_version_path);

        $sql = 'INSERT IGNORE INTO ' . tbl('version') . ' (id, version, revision) VALUES (1, \'' . mysql_clean($version) . '\' , ' . (int)$revision . ')';
        Clipbucket_db::getInstance()->execute($sql);
    }

    $files = Update::getInstance()->getUpdateFiles(false, $version, $revision);

    $installed_plugins = Clipbucket_db::getInstance()->select(tbl('plugins'), '*');
    $files = array_merge($files, get_plugins_files_to_upgrade($installed_plugins));

    $match = [];
    $nb_files = count($files);
    foreach ($files as $i => $file) {
        /** @var Migration $instance */
        $instance = execute_migration_file($file);
        if ($file_OK) {
            file_put_contents($path_file_temp, json_encode([
                'elements_total' => $nb_files,
                'elements_done'  => $i + 1,
                'current_file'   => $file
            ]));
        }
    }
    $version_final = $instance ? $instance->getVersion() : Update::getInstance()->getCurrentDBVersion();
    $revision_final = $instance ? $instance->getRevision() : Update::getInstance()->getCurrentDBRevision();
    $msg = 'Your database has been successfully updated to version ' . htmlentities($version_final . ' - revision ' . (int)$revision_final);
    if (php_sapi_name() != 'cli') {
        echo json_encode([
            'success' => true
        ]);
        sessionMessageHandler::add_message($msg, 'm');
    } else {
        echo $msg . PHP_EOL;
    }
    if ($file_OK) {
        unlink($path_file_temp);
    }
} catch (\Exception $e) {
    $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3}|commercial)\/(\D)(\d{5})\.php/';
    $match = [];
    preg_match($regex, $file, $match);
    if (php_sapi_name() != 'cli') {
        e('An SQL error occured during update ' . $match['1'] . ' - revision ' . (int)$match['3'] . ' (' . basename($file) . '). Please update manually to this revision and the restart update process from this revision.');
        if ($e->getMessage() != '') {
            error_log($e->getMessage());
        }
        echo json_encode([
            'success' => false
            , 'msg'   => getTemplateMsg()
        ]);
    } else {
        echo 'An SQL error occured during update ' . $match['1'] . ' - revision ' . (int)$match['3'] . ' (' . basename($file) . '). Please update manually to this revision and the restart update process from this revision.';
    }
    return false;
}
