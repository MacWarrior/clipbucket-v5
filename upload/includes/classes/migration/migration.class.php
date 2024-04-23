<?php

class Migration
{
    protected $migration;
    protected $revision;
    protected $type;
    protected $version;

    public function __construct()
    {
        $reflector = new ReflectionClass(get_called_class());
        $match = [];
        $regex = '/\/(\d{1,3}\.\d{1,3}\.\d{1,3})\/(\D)(\d{5})\.php/';
        preg_match($regex, $reflector->getFileName(), $match);
        if (empty($match)) {
            $regex = '/.*\/plugins\/(\w+)\/sql\/update\/(\D)(\d{0,3}_\d{0,3}_\d{0,3})\.php/';
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

    public function launch(): bool
    {
        global $db;
        if (!is_callable($this->migration)) {
            $error = 'migration not set';
            DiscordLog::sendDump($error);
            error_log($error);
            return false;
        }
        $db->mysqli->begin_transaction();
        try {
            call_user_func($this->migration);
        } catch (mysqli_sql_exception $e) {
            $db->mysqli->rollback();
            e('ERROR : ' . $e->getMessage());
            error_log('SQL : ' . $templine);
            error_log('ERROR : ' . $e->getMessage());
            DiscordLog::sendDump('ERROR : ' . $e->getMessage());
            throw new Exception('SQL : ' . $templine . "\n" . 'ERROR : ' . $e->getMessage());
        } catch (\Exception $e) {
            $db->mysqli->rollback();
            e($e->getMessage());
            error_log($e->getMessage());
            DiscordLog::sendDump($e->getMessage());
            throw new Exception($e->getMessage());
        }
        $db->mysqli->commit();
        $this->updateVersion();
        return true;
    }

    /**
     * @return void
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public function updateVersion()
    {
        self::sUpdateVersion($this->version, $this->revision, $this->type);
    }

    public static function sUpdateVersion($version, $revision, $type = 'm')
    {
        $db = Clipbucket_db::getInstance();
        if (strtolower($type) == 'p') {
            $sql = 'UPDATE ' . tbl('plugins') . ' SET plugin_version = \'' . mysql_clean($version) . '\' WHERE plugin_folder = \'' . $revision . '\'';
        } else {
            $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean($version) . '\' , revision = ' . mysql_clean($revision) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean($version) . '\' , revision = ' . mysql_clean($revision);
        }
        $db->mysqli->query($sql);
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
     * @return bool|mysqli_result
     * @throws Exception
     */
    public static function generateTranslation(string $translation_key, array $translations)
    {
        $sql = /** @lang MySQL */
            'SET @language_key = \'' . $translation_key . '\' COLLATE utf8mb4_unicode_520_ci;
            INSERT IGNORE INTO `' . tbl('languages_keys') . '` (`language_key`) VALUES (@language_key);
            SET @id_language_key = (SELECT id_language_key FROM `' . tbl('languages_keys') . '` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        foreach ($translations as $language_code => $translation) {
            $sql .= /** @lang MySQL */
                'SET @language_id_' . $language_code . ' = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'' . $language_code . '\');
                INSERT IGNORE INTO `' . tbl('languages_translations') . '` (`id_language_key`, `translation`, `language_id`)
                    VALUES (@language_key, \'' . $translation . '\', @language_id_' . $language_code . ');';
        }
        return Clipbucket_db::getInstance()->execute($sql);
    }

}
