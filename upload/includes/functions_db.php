<?php

/**
 * functions related to database
 *
 * @throws \Exception
 */
function db_select($query): array
{
    global $db;
    return $db->_select($query);
}

function cb_query_id($query): string
{
    return md5($query);
}

/**
 * Created by JetBrains PhpStorm.
 * User: Fawaz
 * Date: 8/26/13
 * Time: 3:51 PM
 * To change this template use File | Settings | File Templates.
 */
function tbl($tbl): string
{
    global $DBNAME;
    $prefix = TABLE_PREFIX;
    $tbls = explode(',', $tbl);
    $new_tbls = '';
    foreach ($tbls as $ntbl) {
        if (!empty($new_tbls)) {
            $new_tbls .= ',';
        }
        $new_tbls .= '`' . $DBNAME . '`.' . $prefix . $ntbl;
    }

    return $new_tbls;
}

/**
 * Format array into table fields
 *
 * @param $fields
 * @param bool $table
 * @return bool|string
 */
function table_fields($fields)
{
    if (empty($fields)) {
        return '';
    }

    $the_fields = '';

    $array = $fields;
    foreach ($array as $key => $_fields) {

        if (is_array($_fields)) {
            foreach ($_fields as $field) {
                if ($the_fields) {
                    $the_fields .= ', ';
                }
                $the_fields .= $key . '.' . $field;
            }
        } else {
            $field = $_fields;

            if ($the_fields) {
                $the_fields .= ', ';
            }

            $the_tbl = '';

            $the_fields .= $the_tbl . $field;
        }
    }

    return $the_fields;
}

/**
 * Since we start using AS in our sql queries, it was getting
 * more and more difficult to know how author has defined
 * the table name. Using this, will confirm that table will be
 * defined AS it's name provided in $table.
 *
 * If author still wants to define table name differently, he
 * can provide it in $as
 *
 * @param string $table
 * @param string $as
 * @return string $from_query
 * @author Fawaz Tahir <fawaz.cb@gmail.com>
 */
function cb_sql_table($table, $as = null)
{
    if ($table) {
        return tbl($table) . ' AS ' . ((!is_null($as) and is_string($as)) ? $as : $table);
    }
    return false;
}

/**
 * Alias function for function cb_select
 *
 * @param $query
 * @param int $cached_time
 * @param string $cached_key
 * @return array
 * @throws Exception
 */
function select($query, $cached_time = -1, $cached_key = ''): array
{
    global $db;
    return $db->_select($query, $cached_time, $cached_key);
}

/**
 * @param $version
 * @param $revision
 * @return bool
 */
function check_need_upgrade($version, $revision): bool
{
    $folders = glob(DIR_SQL . '[0-9]**', GLOB_ONLYDIR);
    $folder_version = '';
    foreach ($folders as $folder) {
        $folder_cur_version = basename($folder);
        if ($folder_cur_version == $version) {
            $folder_version = $folder;
        } elseif ($folder_cur_version > $version && $folder_cur_version <= VERSION) {
            return true;
        }
    }
    $clean_folder = array_diff(scandir($folder_version), ['..', '.']);
    foreach ($clean_folder as $file) {
        $file_rev = (int)pathinfo($file)['filename'];
        if ($file_rev > $revision && $file_rev <= REV) {
            return true;
        }
    }
    return false;
}

/**
 * @param $version
 * @param $revision
 * @return bool
 */
function check_need_plugin_upgrade($installed_plugin): bool
{
    global $cbplugin;
    $detail = $cbplugin->get_plugin_details($installed_plugin['plugin_file'], $installed_plugin['plugin_folder']);
    $files = glob(PLUG_DIR . DIRECTORY_SEPARATOR . $installed_plugin['plugin_folder'] . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR . '*.sql');
    foreach ($files as $file) {
        $file_cur_version = pathinfo($file)['filename'];
        if ($file_cur_version > $installed_plugin['plugin_version'] && $file_cur_version <= $detail['version']) {
            return true;
        }
    }
    return false;
}

/**
 * @param $version
 * @param $revision
 * @param $count
 * @return array|int
 */
function get_files_to_upgrade($version, $revision, $count = false)
{
    //Get folders superior or equal to current version
    $folders = array_filter(glob(DIR_SQL . '[0-9]**', GLOB_ONLYDIR)
        , function ($dir) use ($version) {
            return basename($dir) >= $version;
        });

    $files = [];

    if ($version == '4.2-RC1-premium') {
        $files[] = DIR_SQL . 'commercial' . DIRECTORY_SEPARATOR . '00001.sql';
    }
    foreach ($folders as $folder) {
        //get files in folder minus . and .. folders
        $clean_folder = array_diff(scandir($folder), ['..', '.']);
        $files = array_merge(
            $files,
            //clean null files
            array_filter(
            //return absolute path
                array_map(function ($file) use ($revision, $version, $folder) {
                    $file_rev = (int)pathinfo($file)['filename'];
                    $folder_version = basename($folder);
                    return
                        //if current version, then only superior revisions but still under current revision in changelog
                        (
                            ($file_rev > $revision && $folder_version == $version
                                // or all files from superior version but still under current version in changelog
                                || $folder_version > $version
                            )
                            && //check if version and revision or not superior to changelog
                            ($folder_version == VERSION && $file_rev <= REV
                                || $folder_version < VERSION
                            )
                        )
                            ?
                            $folder . DIRECTORY_SEPARATOR . $file
                            : null;
                }, $clean_folder)
            )
        );
    }
    return ($count ? count($files) : $files);
}

/**
 * @param $installed_plugins
 * @param bool $count
 * @return array|int
 */
function get_plugins_files_to_upgrade($installed_plugins, bool $count = false)
{
    global $cbplugin;
    $update_files = [];
    foreach ($installed_plugins as $installed_plugin) {
        $db_version = $installed_plugin['plugin_version'];
        $detail_verision = $cbplugin->get_plugin_details($installed_plugin['plugin_file'], $installed_plugin['plugin_folder'])['version'];
        //get files in update folder
        $folder = PLUG_DIR . DIRECTORY_SEPARATOR . $installed_plugin['plugin_folder'] . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR;
        $files = glob($folder . '*.sql');
        //filter files which are between db version and detail version
        $update_files = array_merge(
            $update_files,
            array_filter(
                array_map(function ($file) use ($db_version, $detail_verision, $folder) {
                    $file_version = pathinfo($file)['filename'];
                    return ($file_version > $db_version && $file_version <= $detail_verision)
                        ? $file
                        : null;
                }, $files)
            )
        );
    }
    return ($count ? count($update_files) : $update_files);
}

function execute_sql_file($path): bool
{
    $lines = file($path);
    if (empty($lines)) {
        error_lang_cli(lang('class_error_occured'));
        return false;
    }
    global $db;
    $templine = '';
    $db->mysqli->begin_transaction();
    try {
        foreach ($lines as $line) {
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $templine = preg_replace("/{tbl_prefix}/", TABLE_PREFIX, $templine);
                $templine = preg_replace("/{dbname}/", $db->db_name, $templine);
                $db->mysqli->query($templine);
                if ($db->mysqli->error != '') {
                    error_log('SQL : ' . $templine);
                    error_log('ERROR : ' . $db->mysqli->error);
                    $db->mysqli->rollback();
                    return false;
                }
                $templine = '';
            }
        }
    } catch (\Exception $e) {
        $db->mysqli->rollback();
        e('SQL : ' . $templine);
        e('ERROR : ' . $e->getMessage());
        error_log('SQL : ' . $templine);
        error_log('ERROR : ' . $e->getMessage());
        return false;
    }

    $db->mysqli->commit();
    return true;
}

/**
 * @throws \Exception
 */
function execute_migration_SQL_file($path): bool
{
    if (!execute_sql_file($path)) {
        return false;
    }


    global $db;
    if (strpos($path, 'plugin') !== false) {
        $plugin_folder = basename(dirname($path, 3));
        $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3})\.sql/';
        $match = [];
        preg_match($regex, $path, $match);
        $sql = 'UPDATE ' . tbl('plugins') . ' SET plugin_version = \'' . mysql_clean($match['1']) . '\' WHERE plugin_folder = \'' . $plugin_folder . '\'';
    } else {
        $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3})\/(\d{5})\.sql/';
        $match = [];
        preg_match($regex, $path, $match);
        $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean($match['1']) . '\' , revision = ' . mysql_clean((int)$match['2']) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean($match['1']) . '\' , revision = ' . mysql_clean((int)$match['2']);
    }
    $db->mysqli->query($sql);
    CacheRedis::flushAll();
    return true;
}

/**
 * @return array
 */
function getRevisions(): array
{
    $versions = array_map(
        function ($dir) {
            return basename($dir);
        }
        , array_filter(glob(DIR_SQL . '*', GLOB_ONLYDIR)
        , function ($dir) {
            return basename($dir) >= '5.3.0' && basename($dir) <= '5.5.0';
        }
    ));
    $revisions = [
        '4.2-RC1-free'    => '1',
        '4.2-RC1-premium' => '1',
        '5.0.0'           => '1',
        '5.1.0'           => '1',
        '5.2.0'           => '1',
    ];
    foreach ($versions as $version) {
        $changelog_url = BASEDIR . DIRECTORY_SEPARATOR . 'changelog' . DIRECTORY_SEPARATOR . str_replace('.', '', $version) . '.json';
        $changelog = json_decode(file_get_contents($changelog_url, false), true);
        //after revision 168, version system should be already ready
        $revisions[$version] = min($changelog['revision'], 168);
    }
    return $revisions;
}

/**
 * @return array
 */
function getVersions(): array
{
    $versions = [
        '4.2-RC1-free'    => '1',
        '4.2-RC1-premium' => '1',
        '5.0.0'           => '1',
        '5.1.0'           => '1',
        '5.2.0'           => '1',
    ];
    $changelog_url = BASEDIR . DIRECTORY_SEPARATOR . 'changelog' . DIRECTORY_SEPARATOR;
    $files = glob($changelog_url . '[0-9]*' . '.json');
    foreach ($files as $file) {
        $changelog = json_decode(file_get_contents($file), true);
        $versions[$changelog['version']] = $changelog['revision'];
    }
    return $versions;
}
