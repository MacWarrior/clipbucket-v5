<?php
/**
 *                                      ,--.""
 *  Come on guys, we're         __,----( o ))
 *  gonna misse the mi...      ,'--.      , (
 *  the mi...           -"",:-(    o ),-'/  ;
 *  the migration.        ( o) `o  _,'\ / ;(
 *                         `-;_-<'\_|-'/ '  )
 *                             `.`-.__/ '   |
 *                \`.            `. .__,   ;
 *                 )_;--.         \`       |
 *                /'(__,-:         )      ;
 *              ;'    (_,-:     _,::     .|
 *             ;       ( , ) _,':::'    ,;
 *            ;         )-,;'  `:'     .::
 *            |         `'  ;         `:::\
 *            :       ,'    '            `:\
 *            ;:    '  _,-':         .'     `-.
 *             ';::..,'  ' ,        `   ,__    `.
 */
class Migration
{
    /** @var mixed */
    protected $revision;
    /** @var mixed */
    protected $type;
    /** @var array|mixed|string|string[] */
    protected $version;

    public function __construct()
    {
        $reflector = new ReflectionClass(get_called_class());
        $match = [];
        $regex = '/\\' . DIRECTORY_SEPARATOR . '(\d{1,3}\.\d{1,3}\.\d{1,3})\\' . DIRECTORY_SEPARATOR . '(\D)(\d{5})\.php/';
        preg_match($regex, $reflector->getFileName(), $match);
        if (empty($match)) {
            $regex = '/.*\\' . DIRECTORY_SEPARATOR . 'plugins\\' . DIRECTORY_SEPARATOR . '(\w+)\\' . DIRECTORY_SEPARATOR . 'sql\\' . DIRECTORY_SEPARATOR . 'update\\' . DIRECTORY_SEPARATOR . '(\D)(\d{0,3}_\d{0,3}_\d{0,3})\.php/';
            preg_match($regex, $reflector->getFileName(), $match);

            $this->version = str_replace('_', '.', $match[3]);
            $this->type = $match[2];
            //plugin name
            $this->revision = $match[1];
        } else {
            $this->version = $match[1];
            $this->type = $match[2];
            $this->revision = $match[3];
        }
    }

    /**
     * @param bool $upgrade_version
     * @return bool
     * @throws Exception
     */
    public function launch(bool $upgrade_version = true): bool
    {
        Clipbucket_db::getInstance()->begin_transaction();
        try {
            $this->start();
        } catch (mysqli_sql_exception $e) {
            Clipbucket_db::getInstance()->rollback();
            if( in_dev() ){
                e('ERROR : ' . $e->getMessage());
                DiscordLog::sendDump('ERROR : ' . $e->getMessage());
            }
            error_log('ERROR : ' . $e->getMessage());
            throw new Exception('ERROR : ' . $e->getMessage());
        } catch (Exception $e) {
            Clipbucket_db::getInstance()->rollback();
            e($e->getMessage());
            error_log($e->getMessage());
            DiscordLog::sendDump($e->getMessage());
            throw new Exception($e->getMessage());
        }
        Clipbucket_db::getInstance()->commit();
        if ($upgrade_version) {
            $this->updateVersion();
        }
        return true;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function updateVersion()
    {
        self::sUpdateVersion($this->version, $this->revision, $this->type);
    }

    /**
     * @param $version
     * @param $revision
     * @param $type
     * @return void
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     * @throws Exception
     */
    public static function sUpdateVersion($version, $revision, $type = 'm')
    {
        if (strtolower($type) == 'p') {
            $sql = 'UPDATE ' . tbl('plugins') . ' SET plugin_version = \'' . mysql_clean($version) . '\' WHERE plugin_folder = \'' . $revision . '\'';
        } else {
            $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean($version) . '\' , revision = ' . mysql_clean($revision) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean($version) . '\' , revision = ' . mysql_clean($revision);
        }
        Clipbucket_db::getInstance()->executeThrowException($sql);
        CacheRedis::flushAll();
        Update::getInstance()->flush();
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $translation_key
     * @param array $translations ex: ['fr' => 'Bonjour', 'en' => 'Hello']
     * @throws Exception
     */
    public static function generateTranslation(string $translation_key, array $translations)
    {
        $sql = 'SET @language_key = \'' . mysql_clean(strtolower($translation_key)) . '\' COLLATE utf8mb4_unicode_520_ci; ';
        Clipbucket_db::getInstance()->executeThrowException($sql);

        $sql = 'INSERT IGNORE INTO `' . tbl('languages_keys') . '` (`language_key`) VALUES (@language_key);';
        Clipbucket_db::getInstance()->executeThrowException($sql);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `' . tbl('languages_keys') . '` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        Clipbucket_db::getInstance()->executeThrowException($sql);

        foreach ($translations as $language_code => $translation) {
            $language_id_sql = '@' . preg_replace('/\W/', '_', 'language_id_' . mysql_clean(strtolower($language_code)));
            $sql = 'SET ' . $language_id_sql . ' = (SELECT `language_id` FROM `' . tbl('languages') . '` WHERE language_code = \'' . mysql_clean(strtolower($language_code)) . '\');';
            Clipbucket_db::getInstance()->executeThrowException($sql);

            $sql = 'INSERT IGNORE INTO `' . tbl('languages_translations') . '` (`id_language_key`, `translation`, `language_id`) VALUES (@id_language_key, \'' . mysql_clean($translation) . '\', ' . $language_id_sql . ');';
            Clipbucket_db::getInstance()->executeThrowException($sql);
        }
    }

    /**
     * @throws Exception
     */
    public static function deleteTranslation(string $translation_key)
    {
        $sql = 'DELETE FROM `' . tbl('languages_translations') . '`
            WHERE `id_language_key` = (
                SELECT id_language_key FROM `' . tbl('languages_keys') . '`
                WHERE `language_key` = \''.mysql_clean($translation_key) . '\'
                );';
        Clipbucket_db::getInstance()->executeThrowException($sql);

        $sql = 'DELETE FROM `' . tbl('languages_keys') . '`
            WHERE `language_key` = \''.mysql_clean($translation_key) . '\';';
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }

    public static function updateTranslation(string $translation_key, array $translations)
    {
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `' . tbl('languages_keys') . '` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = \'' . mysql_clean(strtolower($translation_key)) . '\' );';
        Clipbucket_db::getInstance()->executeThrowException($sql);

        foreach ($translations as $language_code => $translation) {
            $language_id_sql = '@' . preg_replace('/\W/', '_', 'language_id_' . mysql_clean(strtolower($language_code)));
            $sql = 'SET ' . $language_id_sql . ' = (SELECT `language_id` FROM `' . tbl('languages') . '` WHERE language_code = \'' . mysql_clean(strtolower($language_code)) . '\');';
            Clipbucket_db::getInstance()->executeThrowException($sql);

            $sql = 'UPDATE `' . tbl('languages_translations') . '` SET `translation` = \'' . mysql_clean($translation) . '\' WHERE id_language_key = @id_language_key AND language_id = ' . $language_id_sql . ';';
            Clipbucket_db::getInstance()->executeThrowException($sql);
        }
    }

    /**
     * @param $sql_alter
     * @param array $params_exists fields available : table, column, constraint_name, constraint_type, constraint_schema
     * @param array $params_not_exists
     * @throws Exception
     */
    public static function alterTable($sql_alter, array $params_exists = [], array $params_not_exists = [])
    {
        $table = 'COLUMNS';
        $conditions = [];
        $conditions[] = 'TABLE_SCHEMA = \'{dbname}\'';

        if (!empty($params_exists['table'])) {
            $conditions[] = 'TABLE_NAME = \'' . tbl($params_exists['table']) . '\'';
        }

        if (!empty($params_exists['column'])) {
            $conditions[] = 'COLUMN_NAME = \'' . mysql_clean($params_exists['column']) . '\'';
            if( empty($params_exists['table']) ){
                if( in_dev() ){
                    $msg = 'Table constraint has to be specified in alterTable with column constraint, in migration '.get_called_class();
                } else {
                    $msg = 'A technical error occured on migration '.get_called_class();
                }
                throw new Exception($msg);
            }
        }
        if (!empty($params_exists['columns'])) {
            $conditions[] = 'COLUMN_NAME IN (\'' . implode('\',\'', $params_exists['columns']) . '\')';
            if( empty($params_exists['table']) ){
                if( in_dev() ){
                    $msg = 'Table constraint has to be specified in alterTable with columns constraint, in migration '.get_called_class();
                } else {
                    $msg = 'A technical error occured on migration '.get_called_class();
                }
                throw new Exception($msg);
            }
        }

        if (!empty($params_exists['constraint_name'])) {
            $conditions[] = 'CONSTRAINT_NAME = \'' . mysql_clean($params_exists['constraint_name']) . '\'';
            $table = 'TABLE_CONSTRAINTS';
        }

        if (!empty($params_exists['constraint_type'])) {
            $conditions[] = 'CONSTRAINT_TYPE = \'' . mysql_clean($params_exists['constraint_type']) . '\'';
            $table = 'TABLE_CONSTRAINTS';
        }

        if (!empty($params_exists['constraint_schema'])) {
            $conditions[] = 'CONSTRAINT_SCHEMA = \'' . mysql_clean($params_exists['constraint_schema']) . '\'';
            $table = 'TABLE_CONSTRAINTS';
        }

        if (!empty($params_not_exists)) {
            $table_not_exists = 'COLUMNS';
            $conditions_not_exists = [];
            $conditions_not_exists[] = 'TABLE_SCHEMA = \'{dbname}\'';
            if (!empty($params_not_exists['table'])) {
                $conditions_not_exists[] = 'TABLE_NAME = \'' . tbl($params_not_exists['table']) . '\'';
            }

            if (!empty($params_not_exists['column'])) {
                $conditions_not_exists[] = 'COLUMN_NAME = \'' . mysql_clean($params_not_exists['column']) . '\'';
                if( empty($params_not_exists['table']) ){
                    if( in_dev() ){
                        $msg = 'Table constraint has to be specified in alterTable with column constraint, in migration '.get_called_class();
                    } else {
                        $msg = 'A technical error occured on migration '.get_called_class();
                    }
                    throw new Exception($msg);
                }
            }
            if (!empty($params_not_exists['columns'])) {
                $conditions_not_exists[] = 'COLUMN_NAME IN (\'' . implode('\',\'', $params_not_exists['columns']) . '\')';
                if( empty($params_not_exists['table']) ){
                    if( in_dev() ){
                        $msg = 'Table constraint has to be specified in alterTable with columns constraint, in migration '.get_called_class();
                    } else {
                        $msg = 'A technical error occured on migration '.get_called_class();
                    }
                    throw new Exception($msg);
                }
            }

            if (!empty($params_not_exists['constraint_name'])) {
                $conditions_not_exists[] = 'CONSTRAINT_NAME = \'' . mysql_clean($params_not_exists['constraint_name']) . '\'';
                $table_not_exists = 'TABLE_CONSTRAINTS';
            }

            if (!empty($params_not_exists['constraint_type'])) {
                $conditions_not_exists[] = 'CONSTRAINT_TYPE = \'' . mysql_clean($params_not_exists['constraint_type']) . '\'';
                $table_not_exists = 'TABLE_CONSTRAINTS';
            }

            if (!empty($params_not_exists['constraint_schema'])) {
                $conditions_not_exists[] = 'CONSTRAINT_SCHEMA = \'' . mysql_clean($params_not_exists['constraint_schema']) . '\'';
                $table_not_exists = 'TABLE_CONSTRAINTS';
            }
            $conditions[] = '(
                SELECT COUNT(*) FROM information_schema.' . $table_not_exists . ' WHERE
                ' . implode(' AND ', $conditions_not_exists) . ' LIMIT 1
                ) = 0 ';
        }

        $sql = 'set @var=if((SELECT true FROM information_schema.' . $table . ' WHERE
        ' . implode(' AND ', $conditions) . ' LIMIT 1)
        , \'' . addslashes($sql_alter) . '\'
        ,\'SELECT 1\');';
        self::query($sql);
        self::query('prepare stmt from @var;');
        self::query('execute stmt;');
        self::query('deallocate prepare stmt;');
    }

    /**
     * @throws Exception
     */
    public static function generateConfig(string $config_name, string $config_value)
    {
        $sql = 'INSERT IGNORE INTO `' . tbl('config') . '` (`name`, `value`) VALUES (\''.mysql_clean($config_name).'\', \''.mysql_clean($config_value).'\');';
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }

    /**
     * @throws Exception
     */
    public static function deleteConfig(string $config_name)
    {
        $sql = 'DELETE FROM `' . tbl('config') . '` WHERE name = \''.mysql_clean($config_name).'\';';
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }

    /**
     * @throws Exception
     */
    public static function updateConfig(string $config_name, string $config_value)
    {
        $sql = 'UPDATE `' . tbl('config') . '` SET value = \''.mysql_clean($config_value).'\' WHERE name = \''.mysql_clean($config_name).'\';';
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }

    /**
     * @throws Exception
     */
    public static function query($sql)
    {
        $sql = preg_replace("/{tbl_prefix}/", TABLE_PREFIX, $sql);
        $sql = preg_replace("/{dbname}/", Clipbucket_db::getInstance()->getTableName(), $sql);
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }

    /**
     * @param string $code
     * @param string $tool_function ex AdminTool::function
     * @param string|null $frequency
     * @param bool $is_automatable
     * @return void
     * @throws Exception
     */
    public static function insertTool(string $code, string $tool_function, string $frequency = null, bool $is_automatable = false)
    {
        $label = mysql_clean($code);

        $fields = ['language_key_label', 'language_key_description', 'function_name', 'code'];
        $values = [
            '\'' . $label . '_label\''
            ,'\'' . $label . '_description\''
            ,'\'' . mysql_clean($tool_function) . '\''
            ,'\'' . $label . '\''
        ];

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '99') ){
            $fields[] = 'frequency';
            $values[] = '\'' . mysql_clean($frequency) . '\'';

            $fields[] = 'is_automatable';
            $values[] = $is_automatable ? '1' : '0';

            $fields[] = 'previous_calculated_datetime';
            $values[] = 'CURRENT_TIMESTAMP';
        }

        $fields_txt = implode(', ', $fields);
        $values_txt = implode(', ', $values);

        $sql = 'INSERT IGNORE INTO ' . tbl('tools') . ' (' . $fields_txt . ') VALUES (' . $values_txt . ');';
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }

    public function start(){}

}
