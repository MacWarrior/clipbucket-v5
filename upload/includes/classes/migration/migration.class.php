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

    /**
     * @throws Exception
     */
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
     * @throws Exception
     */
    private static function getConstraints(array $params_exists = [], array $params_not_exists = []): array
    {
        $conditions = [];

        if (method_exists('Clipbucket_db', 'getTableName')) {
            // Temp fix : Case when you just updated to revision 187 with core update function ; previous function name is still loaded
            $dbname = Clipbucket_db::getInstance()->getTableName();
        } else {
            $dbname = Clipbucket_db::getInstance()->getDBName();
        }

        if (!empty($params_exists)) {
            if( (!empty($params_exists['column']) || !empty($params_exists['columns'])) && empty($params_exists['table']) ){
                if( in_dev() ){
                    $msg = 'Table constraint has to be specified in alterTable with column constraint, in migration ';
                } else {
                    $msg = 'A technical error occurred on migration ';
                }
                throw new Exception($msg . get_called_class());
            }

            if (!empty($params_exists['column'])) {
                $conditions_column = [];
                $conditions_column[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                $conditions_column[] = 'TABLE_NAME = \'' . tbl($params_exists['table']) . '\'';
                $conditions_column[] = 'COLUMN_NAME = \'' . mysql_clean($params_exists['column']) . '\'';

                $conditions[] = '(
                    SELECT COUNT(*) FROM information_schema.COLUMNS WHERE
                    ' . implode(' AND ', $conditions_column) . ' LIMIT 1
                ) = 1';
            } else if (!empty($params_exists['columns'])) {
                foreach ($params_exists['columns'] as $column) {
                    $conditions_column = [];
                    $conditions_column[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                    $conditions_column[] = 'TABLE_NAME = \'' . tbl($params_exists['table']) . '\'';
                    $conditions_column[] = 'COLUMN_NAME = \'' . mysql_clean($column) . '\'';

                    $conditions[] = '(
                        SELECT COUNT(*) FROM information_schema.COLUMNS WHERE
                        ' . implode(' AND ', $conditions_column) . ' LIMIT 1
                    ) = 1';
                }
            } else if (!empty($params_exists['table'])) {
                $conditions_table = [];
                $conditions_table[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                $conditions_table[] = 'TABLE_NAME = \'' . tbl($params_exists['table']) . '\'';

                $conditions[] = '(
                    SELECT COUNT(*) FROM information_schema.COLUMNS WHERE
                    ' . implode(' AND ', $conditions_table) . ' LIMIT 1
                ) >= 1';
            }

            if (!empty($params_exists['constraint'])) {
                if( empty($params_exists['constraint']['type']) ){
                    if( in_dev() ){
                        $msg = 'Missing constraint type, in migration ';
                    } else {
                        $msg = 'A technical error occurred on migration ';
                    }
                    throw new Exception($msg . get_called_class());
                }

                $type = $params_exists['constraint']['type'];
                switch($type){
                    case 'FULLTEXT':
                    case 'UNIQUE':
                        $required_values = ['name', 'table'];
                        break;

                    case 'FOREIGN KEY':
                    case 'CONSTRAINT':
                        $required_values = ['name'];
                        break;

                    case 'PRIMARY KEY':
                        $required_values = ['table'];
                        break;

                    default:
                        if( in_dev() ){
                            $msg = 'Unsupported constraint type : ' . $type . ', in migration ';
                        } else {
                            $msg = 'A technical error occurred on migration ';
                        }
                        throw new Exception($msg . get_called_class());
                }

                if( !empty($required_values) ){
                    foreach($required_values as $value){
                        if( empty($params_exists['constraint'][$value]) ){
                            if( in_dev() ){
                                $msg = 'Missing constraint ' . $value . ' for type ' . $type . ', in migration ';
                            } else {
                                $msg = 'A technical error occurred on migration ';
                            }
                            throw new Exception($msg . get_called_class());
                        }
                    }
                }

                $conditions_constraint = [];
                $table_constraint = '';
                switch($type){
                    case 'FULLTEXT':
                        $table_constraint = 'STATISTICS';
                        $conditions_constraint[] = 'INDEX_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'INDEX_NAME = \'' . $params_exists['constraint']['name'] . '\'';
                        $conditions_constraint[] = 'TABLE_NAME = \'' . tbl($params_exists['constraint']['table']) . '\'';
                        break;

                    case 'UNIQUE':
                        $table_constraint = 'TABLE_CONSTRAINTS';
                        $conditions_constraint[] = 'CONSTRAINT_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_NAME = \'' . mysql_clean($params_exists['constraint']['name']) . '\'';
                        $conditions_constraint[] = 'TABLE_NAME = \'' . tbl($params_exists['constraint']['table']) . '\'';
                        break;

                    case 'FOREIGN KEY':
                    case 'CONSTRAINT':
                        $table_constraint = 'TABLE_CONSTRAINTS';
                        $conditions_constraint[] = 'CONSTRAINT_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_NAME = \'' . mysql_clean($params_exists['constraint']['name']) . '\'';
                        break;

                    case 'PRIMARY KEY':
                        $table_constraint = 'TABLE_CONSTRAINTS';
                        $conditions_constraint[] = 'CONSTRAINT_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'TABLE_NAME = \'' . tbl($params_exists['constraint']['table']) . '\'';
                        break;
                }

                $conditions[] = '(
                    SELECT COUNT(*) FROM information_schema.' . $table_constraint . ' WHERE
                    ' . implode(' AND ', $conditions_constraint) . ' LIMIT 1
                ) = 1';
            }

        }

        if (!empty($params_not_exists)) {
            if( (!empty($params_not_exists['column']) || !empty($params_not_exists['columns'])) && empty($params_not_exists['table']) ){
                if( in_dev() ){
                    $msg = 'Table constraint has to be specified in alterTable with column constraint, in migration ';
                } else {
                    $msg = 'A technical error occurred on migration ';
                }
                throw new Exception($msg . get_called_class());
            }

            if (!empty($params_not_exists['column'])) {
                $conditions_column = [];
                $conditions_column[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                $conditions_column[] = 'TABLE_NAME = \'' . tbl($params_not_exists['table']) . '\'';
                $conditions_column[] = 'COLUMN_NAME = \'' . mysql_clean($params_not_exists['column']) . '\'';

                $conditions[] = '(
                    SELECT COUNT(*) FROM information_schema.COLUMNS WHERE
                    ' . implode(' AND ', $conditions_column) . ' LIMIT 1
                ) = 0';
            } else if (!empty($params_not_exists['columns'])) {
                foreach ($params_not_exists['columns'] as $column) {
                    $conditions_column = [];
                    $conditions_column[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                    $conditions_column[] = 'TABLE_NAME = \'' . tbl($params_not_exists['table']) . '\'';
                    $conditions_column[] = 'COLUMN_NAME = \'' . mysql_clean($column) . '\'';

                    $conditions[] = '(
                        SELECT COUNT(*) FROM information_schema.COLUMNS WHERE
                        ' . implode(' AND ', $conditions_column) . ' LIMIT 1
                    ) = 0';
                }
            } else if (!empty($params_not_exists['table'])) {
                $conditions_table = [];
                $conditions_table[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                $conditions_table[] = 'TABLE_NAME = \'' . tbl($params_not_exists['table']) . '\'';

                $conditions[] = '(
                    SELECT COUNT(*) FROM information_schema.COLUMNS WHERE
                    ' . implode(' AND ', $conditions_table) . ' LIMIT 1
                ) = 0';
            }

            if (!empty($params_not_exists['constraint'])) {
                if( empty($params_not_exists['constraint']['type']) ){
                    if( in_dev() ){
                        $msg = 'Missing constraint type, in migration ';
                    } else {
                        $msg = 'A technical error occurred on migration ';
                    }
                    throw new Exception($msg . get_called_class());
                }

                $type = $params_not_exists['constraint']['type'];
                switch($type){
                    case 'FULLTEXT':
                    case 'UNIQUE':
                        $required_values = ['name', 'table'];
                        break;

                    case 'FOREIGN KEY':
                    case 'CONSTRAINT':
                        $required_values = ['name'];
                        break;

                    case 'PRIMARY KEY':
                        $required_values = ['table'];
                        break;

                    default:
                        if( in_dev() ){
                            $msg = 'Unsupported constraint type : ' . $type . ', in migration ';
                        } else {
                            $msg = 'A technical error occurred on migration ';
                        }
                        throw new Exception($msg . get_called_class());
                }

                if( !empty($required_values) ){
                    foreach($required_values as $value){
                        if( empty($params_not_exists['constraint'][$value]) ){
                            if( in_dev() ){
                                $msg = 'Missing constraint ' . $value . ' for type ' . $type . ', in migration ';
                            } else {
                                $msg = 'A technical error occurred on migration ';
                            }
                            throw new Exception($msg . get_called_class());
                        }
                    }
                }

                $conditions_constraint = [];
                $table_constraint = '';
                switch($type){
                    case 'FULLTEXT':
                        $table_constraint = 'STATISTICS';
                        $conditions_constraint[] = 'INDEX_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'TABLE_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'INDEX_NAME = \'' . $params_not_exists['constraint']['name'] . '\'';
                        $conditions_constraint[] = 'TABLE_NAME = \'' . tbl($params_not_exists['constraint']['table']) . '\'';
                        break;

                    case 'UNIQUE':
                        $table_constraint = 'TABLE_CONSTRAINTS';
                        $conditions_constraint[] = 'CONSTRAINT_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_NAME = \'' . mysql_clean($params_not_exists['constraint']['name']) . '\'';
                        $conditions_constraint[] = 'TABLE_NAME = \'' . tbl($params_not_exists['constraint']['table']) . '\'';
                        break;

                    case 'FOREIGN KEY':
                    case 'CONSTRAINT':
                        $table_constraint = 'TABLE_CONSTRAINTS';
                        $conditions_constraint[] = 'CONSTRAINT_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_NAME = \'' . mysql_clean($params_not_exists['constraint']['name']) . '\'';
                        break;

                    case 'PRIMARY KEY':
                        $table_constraint = 'TABLE_CONSTRAINTS';
                        $conditions_constraint[] = 'CONSTRAINT_TYPE = \'' . $type . '\'';
                        $conditions_constraint[] = 'CONSTRAINT_SCHEMA = \'' . $dbname . '\'';
                        $conditions_constraint[] = 'TABLE_NAME = \'' . tbl($params_not_exists['constraint']['table']) . '\'';
                        break;
                }

                $conditions[] = '(
                    SELECT COUNT(*) FROM information_schema.' . $table_constraint . ' WHERE
                    ' . implode(' AND ', $conditions_constraint) . ' LIMIT 1
                ) = 0';
            }
        }

        return $conditions;
    }

    /**
     * @param $sql_alter
     * @param array $params_exists fields available : table, column, columns, constraint
     * @param array $params_not_exists
     * @throws Exception
     */
    public static function alterTable($sql_alter, array $params_exists = [], array $params_not_exists = [])
    {
        $conditions = self::getConstraints($params_exists, $params_not_exists);

        try {
            Clipbucket_db::getInstance()->commit();
        }
        catch(Exception $e){}

        $sql_foreign_key = 'SET FOREIGN_KEY_CHECKS=0;';
        self::query($sql_foreign_key);

        $sql = 'set @var=if((SELECT true WHERE
        ' . implode(' AND ', $conditions) . ' LIMIT 1)
        , \'' . addslashes($sql_alter) . '\'
        ,\'SELECT 1\');';
        self::query($sql);

        $sql_foreign_key = 'SET FOREIGN_KEY_CHECKS=1;';
        self::query($sql_foreign_key);

        try{
            self::query('prepare stmt from @var;');
            self::query('execute stmt;');
            self::query('deallocate prepare stmt;');
        }
        catch(Exception $e){
            $msg = 'SQL : ' . $sql . "\n";
            throw new Exception($msg . $e->getMessage());
        }

        try {
            Clipbucket_db::getInstance()->begin_transaction();
        }
        catch(Exception $e){}
    }

    /**
     * @throws Exception
     */
    public static function constrainedQuery($sql_query, array $params_exists = [], array $params_not_exists = [])
    {
        $conditions = self::getConstraints($params_exists, $params_not_exists);

        $sql = 'set @var=if((SELECT true WHERE
        ' . implode(' AND ', $conditions) . ' LIMIT 1)
        , \'' . addslashes($sql_query) . '\'
        ,\'SELECT 1\');';
        self::query($sql);

        try{
            self::query('prepare stmt from @var;');
            self::query('execute stmt;');
            self::query('deallocate prepare stmt;');
        }
        catch(Exception $e){
            $msg = 'SQL : ' . $sql . "\n";
            throw new Exception($msg . $e->getMessage());
        }
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
        $sql = self::prepare($sql);
        Clipbucket_db::getInstance()->executeThrowException($sql);
    }
    /**
     * @throws Exception
     */
    public static function req($sql): array
    {
        $sql = self::prepare($sql);
        return Clipbucket_db::getInstance()->_select($sql);
    }

    /**
     * @param $sql
     * @return string
     */
    public static function prepare($sql): string
    {
        $sql = preg_replace("/{tbl_prefix}/", TABLE_PREFIX, $sql);
        $sql = preg_replace("/{dbname}/", Clipbucket_db::getInstance()->getDBName(), $sql);
        return $sql;
    }

    /**
     * @param string $code
     * @param string $tool_function ex AdminTool::function
     * @param string|null $frequency
     * @param bool $is_automatable
     * @return void
     * @throws Exception
     */
    public static function insertTool(string $code, string $tool_function, $frequency = null, bool $is_automatable = false)
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

    /**
     * @param int $id_type
     * @param string $name
     * @param string $description
     * @param array $array_values
     * @return void
     * @throws Exception
     */
    public static function generatePermission(int $id_type, string $name, string $description, array $array_values)
    {

        $sql = 'INSERT IGNORE INTO `' . tbl(UserLevel::getTableNameLevelPermission()) . '` (`id_user_permission_types`, `permission_name`, `permission_description`) 
        VALUES ('.mysql_clean($id_type).', \''.mysql_clean($name).'\', \''.mysql_clean($description).'\');';
        Clipbucket_db::getInstance()->executeThrowException($sql);
        $inserted_id = Clipbucket_db::getInstance()->insert_id();

        foreach ($array_values as $user_level_id => $value) {
            UserLevel::insertUserPermissionValue($user_level_id, $inserted_id, $value);
        }
    }
    public function start(){}

}
