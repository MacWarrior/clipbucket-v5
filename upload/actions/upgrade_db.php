<?php
require_once '../includes/admin_config.php';
global $userquery, $eh, $db;
$need_to_create_version_table = true;

$array_42 = ['4.2-RC1-free', '4.2-RC1-premium'];
if (php_sapi_name() == 'cli') {

    try {
        $version_db = $db->select(tbl('version'), 'version, revision')[0];
        $version = $version_db['version'];
        $revision = $version_db['revision'];
        $need_to_create_version_table = false;
        if (!empty($argv[1]) || !empty($argv[2])) {
            echo 'Upgrade system is already installed, parameters so are ignored' . PHP_EOL;
        }
    } catch (Exception $e) {
        if ($e->getMessage() == 'version_not_installed') {
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
            $version_list = getVersions();
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
            throw $e;
        }
    }
} else {
    $userquery->admin_login_check();
    if (empty($_REQUEST['version']) || empty($_REQUEST['revision'])) {
        error_lang_cli('Version or revision is missing');
        return false;
    }

    $revision = $_REQUEST['revision'];
    $version = $_REQUEST['version'];
}

if ($need_to_create_version_table) {
    $revisions = getRevisions();
    if (!array_key_exists($version, $revisions) || ($revisions[$version]) < $revision) {
        error_lang_cli('Revision provided is incorrect');
        return false;
    }
    $table_version_path = DIR_SQL . 'table_version.sql';
    $lines = file($table_version_path);
    if (empty($lines)) {
        error_lang_cli('Version system initialisation failed because table_version.sql is missing or empty ; please make sure your code is up-to-date and table_version.sql file is correct.');
        return false;
    }
}

$eh->flush_error();
$templine = '';
try {
    if ($need_to_create_version_table) {
        execute_sql_file($table_version_path);

        $sql = 'INSERT INTO ' . tbl('version') . ' (id, version, revision) VALUES (1, \'' . mysql_clean($version) . '\' , ' . mysql_clean((int)$revision) . ')';
        $db->mysqli->query($sql);
    }

    $files = get_files_to_upgrade($version, $revision);

    $match = [];
    foreach ($files as $file) {
        $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3})\/(\d{5})\.sql/';
        $match = [];
        preg_match($regex, $file, $match);
        if( !execute_migration_SQL_file($file) ){
            throw new Exception();
        }
    }
    echo json_encode([
        'success' => true
        , 'msg'   => htmlentities($match['1'] . ' - revision ' . (int)$match['2'])
    ]);
} catch (Exception $e) {
    $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3}|commercial)\/(\d{5})\.sql/';
    $match = [];
    preg_match($regex, $file, $match);
    e('An SQL error occured during update ' . $match['1'] . ' - revision ' . (int)$match['2'] . ' (' . basename($file) . '). Please update manually to this revision and the restart update process from this revision.');
    if( $e->getMessage() != '' ){
        error_log($e->getMessage());
    }
    echo json_encode([
        'success' => false
        , 'msg'   => getTemplateMsg()
    ]);
    return false;
}
