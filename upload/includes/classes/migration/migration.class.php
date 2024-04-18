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
        $regex = '/\/(\d{0,3}\.\d{0,3}\.\d{0,3})\/(\D)(\d{5})\.php/';
        $match = [];
        preg_match($regex, $reflector->getFileName(), $match);

        $this->version = $match[1];
        $this->type = $match[2];
        $this->revision = $match[3];
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
            $sql = 'UPDATE ' . tbl('plugins') . ' SET plugin_version = \'' . mysql_clean($revision) . '\' WHERE plugin_folder = \'' . $version . '\'';
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

}
