<?php

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

    /**
     * @return bool
     * @throws Exception
     */
    public function launch(): bool
    {
        Clipbucket_db::getInstance()->begin_transaction();
        try {
            $this->start();
        } catch (mysqli_sql_exception $e) {
            Clipbucket_db::getInstance()->rollback();
            e('ERROR : ' . $e->getMessage());
            error_log('ERROR : ' . $e->getMessage());
            DiscordLog::sendDump('ERROR : ' . $e->getMessage());
            throw new Exception('ERROR : ' . $e->getMessage());
        } catch (Exception $e) {
            Clipbucket_db::getInstance()->rollback();
            e($e->getMessage());
            error_log($e->getMessage());
            DiscordLog::sendDump($e->getMessage());
            throw new Exception($e->getMessage());
        }
        Clipbucket_db::getInstance()->commit();
        $this->updateVersion();
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
            $sql = 'SET @language_id_' . mysql_clean(strtolower($language_code)) . ' = (SELECT `language_id` FROM `' . tbl('languages') . '` WHERE language_code = \'' . mysql_clean(strtolower($language_code)) . '\');';
            Clipbucket_db::getInstance()->executeThrowException($sql);

            $sql = ' INSERT IGNORE INTO `' . tbl('languages_translations') . '` (`id_language_key`, `translation`, `language_id`) VALUES (@language_key, \'' . $translation . '\', @language_id_' . mysql_clean(strtolower($language_code)) . ');';
            Clipbucket_db::getInstance()->executeThrowException($sql);
        }
    }

    public function start(){}


}
