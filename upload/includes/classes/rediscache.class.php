<?php

class CacheRedis
{
    public $client;
    private $isEnabled;
    private static $_instance;
    public $nbget = 0;
    public $nbset = 0;

    private $prefix = '';

    /**
     * @return self
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public static function getInstance(): CacheRedis
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new CacheRedis(false, []);
        }
        return self::$_instance;
    }


    /**
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public function __construct($enabled, $params)
    {
        $this->isEnabled = ($enabled == 'yes');
        if ($this->isEnabled) {
            $this->init($params);
        }
    }

    /**
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    private function init($params)
    {
        try {
            $this->client = new Predis\Client($params);
            $this->client->connect();
            $this->client->incr('counter');
        } catch (Predis\Connection\ConnectionException $e) {
            $this->isEnabled = false;
            if (in_dev()) {
                //TODO translate without Language class
                e('Cannot connect to Redis server');
            } else {
                throw $e;
            }
        } catch (Predis\Response\ServerException $e) {
            $this->isEnabled = false;
            if (in_dev()) {
                //TODO translate without Language class
                e('You need to authenticate to Redis server');
            } else {
                throw $e;
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        self::$_instance = $this;
        $this->prefix = VERSION . '_' . REV;
    }

    /**
     * @param string $key
     * @return null|mixed
     */
    public function get($key)
    {
        if ($this->isEnabled) {
            $result = $this->client->get($this->prefix . ':' . $key);
            if ($result !== null) {
                $this->nbget++;
            }
            return self::unredislize($result);
        }
        return null;
    }

    public function set($key, $value, $timeExpired): bool
    {
        if ($this->isEnabled) {
            $this->nbset++;
            $this->client->setex($this->prefix . ':' . $key, $timeExpired, self::redislize($value));
            return true;
        }
        return false;
    }

    public function connect($pass)
    {
        $this->client->connect($pass);
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }


    private static function redislize($data): string
    {
        // Only serialize if it's not a string or a integer
        if (!is_string($data) && !is_integer($data)) {
            return urlencode(serialize($data));
        }
        // Encode string to escape wrong saves
        return urlencode($data);
    }

    /**
     * @param $data
     * @return mixed|string
     */
    private static function unredislize($data)
    {
        $data = urldecode($data);
        // unserialize data if we can
        $unserializedData = unserialize($data);
        if ($unserializedData !== false) {
            return $unserializedData;
        }
        return $data;
    }

    /**
     * @return void
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public static function flushAll()
    {
        if (self::getInstance()->isEnabled) {
            self::getInstance()->client->flushall();
        }
    }

    /**
     * @param $key
     * @return void
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public static function flushKeyStart($key)
    {
        $redisCache = self::getInstance();
        if ($redisCache->isEnabled) {
            $keys = $redisCache->client->keys($redisCache->prefix . ':' . $key . '*');
            $redisCache->client->del($keys);
        }
    }

}
