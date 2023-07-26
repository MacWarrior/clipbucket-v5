<?php

/**
 * functions related to database
 *
 * @throws Exception
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
function table_fields($fields, $table = false)
{
    $the_fields = '';

    if ($fields) {
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

                if ($table) {
                    $the_tbl = tbl($table) . '.';
                } else {
                    $the_tbl = '';
                }

                $the_fields .= $the_tbl . $field;
            }
        }
    }

    return $the_fields ? $the_fields : false;
}

/**
 * Alias function for table_fields
 *
 * @param $fields
 * @param bool $table
 * @return bool|string
 */
function tbl_fields($fields, $table = false)
{
    return table_fields($fields, $table);
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

function table($table, $as = null)
{
    return cb_sql_table($table, $as);
}

/**
 * Alias function for function cb_select
 *
 * @param $query
 * @param int $cached_time
 * @return array
 * @throws Exception
 */
function select($query, $cached_time=-1): array
{
    global $db;
    return $db->_select($query, $cached_time);
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
        if (basename($folder) == $version) {
            $folder_version = $folder;
        } elseif (basename($folder) > $version) {
            return true;
        }
    }
    $clean_folder = array_diff(scandir($folder_version), ['..', '.']);
    foreach ($clean_folder as $file) {
        if ((int)pathinfo($file)['filename'] > $revision) {
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
                    return
                        //if current version, then only superior revisions
                        ((int)pathinfo($file)['filename'] > $revision && basename($folder) == $version
                            // or all files from superior version
                            || basename($folder) > $version
                        ) ?
                            $folder . DIRECTORY_SEPARATOR . $file
                            : null;
                }, $clean_folder)
            )
        );
    }
    return ($count ? count($files) : $files);
}

/**
 * @throws Exception
 */
function execute_sql_file($path): bool
{
    $lines = file($path);
    if (empty($lines)) {
        e(lang('class_error_occured'));
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
    } catch (Exception $e) {
        $db->mysqli->rollback();
        e('SQL : ' . $templine);
        e('ERROR : ' . $e->getMessage());
        return false;
    }

    $db->mysqli->commit();
    return true;
}

/**
 * @throws Exception
 */
function execute_migration_SQL_file($path): bool
{
    if(!execute_sql_file($path)){
        return false;
    }

    $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3})\/(\d{5})\.sql/';
    $match = [];
    preg_match($regex, $path, $match);

    global $db;
    $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean($match['1']) . '\' , revision = ' . mysql_clean((int)$match['2']) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean($match['1']) . '\' , revision = ' . mysql_clean((int)$match['2']);
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
