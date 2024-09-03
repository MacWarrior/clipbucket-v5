<?php
require_once dirname(__FILE__, 2).'/includes/admin_config.php';

$need_to_create_version_table = true;
errorhandler::getInstance()->flush_error();
$error=false;
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
            if (!empty($argv[1]) || !empty($argv[2]) ) {
                echo 'Upgrade system is already installed, parameters so are ignored' . PHP_EOL;
            }
        }
    } catch (\Exception $e) {
        throw $e;
    }

} else {
    userquery::getInstance()->admin_login_check();
    if (empty($_REQUEST['version']) || empty($_REQUEST['revision'])) {
        error_lang_cli('Version or revision is missing');
        $error = true;
    }

    $revision = $_REQUEST['revision'];
    $version = $_REQUEST['version'];
}

$regex_version = '(\d+\.\d+\.\d+)';
$mysqlReq='5.6.0';
assign('mysqlReq', $mysqlReq);
$cmd = 'mysql --version';
exec($cmd, $mysql_client_output);
$match_mysql = [];
preg_match($regex_version, $mysql_client_output[0], $match_mysql);
$clientMySqlVersion = $match_mysql[0] ?? false;
if(version_compare($clientMySqlVersion, $mysqlReq) < 0) {
    error_lang_cli(sprintf('Current version of MySQL Client is %s, minimal version %s is required. Please update'. PHP_EOL, $clientMySqlVersion, $mysqlReq));
    $error=true;
}

$serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
preg_match($regex_version, $serverMySqlVersion, $match_mysql);
$serverMySqlVersion = $match_mysql[0] ?? false;
if(version_compare($serverMySqlVersion, $mysqlReq) < 0) {
    error_lang_cli(sprintf('Current version of MySQL Server is %s, minimal version %s is required. Please update'. PHP_EOL, $serverMySqlVersion, $mysqlReq));
    $error=true;
}

if ($need_to_create_version_table) {
    $revisions = getRevisions();
    if (!array_key_exists($version, $revisions) || ($revisions[$version]) < $revision) {
        error_lang_cli('Revision provided is incorrect');
        $error=true;
    }
    $table_version_path = DirPath::get('sql') . 'table_version.sql';
    $lines = file($table_version_path);
    if (empty($lines)) {
        error_lang_cli('Version system initialisation failed because table_version.sql is missing or empty ; please make sure your code is up-to-date and table_version.sql file is correct.');
        $error=true;
    }
}
if( $error ) {
    if (php_sapi_name() != 'cli') {
        echo json_encode([
            'success' => false
            , 'msg'   => getTemplateMsg()
        ]);
    }
    return false;
}

$templine = '';
try {
    if ($need_to_create_version_table) {
        execute_sql_file($table_version_path);

        $sql = 'INSERT IGNORE INTO ' . tbl('version') . ' (id, version, revision) VALUES (1, \'' . mysql_clean($version) . '\' , ' . mysql_clean((int)$revision) . ')';
        Clipbucket_db::getInstance()->execute($sql);
    }

    $files = Update::getInstance()->getUpdateFiles(false, $version, $revision);

    $installed_plugins = Clipbucket_db::getInstance()->select(tbl('plugins'), '*');
    $files = array_merge($files, get_plugins_files_to_upgrade($installed_plugins));

    $match = [];
    foreach ($files as $file) {
        /** @var Migration $instance  */
        $instance = execute_migration_file($file);
    }
    if (php_sapi_name() != 'cli') {
        echo json_encode([
            'success' => true
            , 'msg'   => htmlentities($instance->getVersion() . ' - revision ' . (int)$instance->getRevision())
        ]);
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
