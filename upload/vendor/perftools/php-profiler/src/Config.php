<?php

namespace Xhgui\Profiler;

use ArrayAccess;
use Xhgui\Profiler\Exception\ProfilerException;

class Config implements ArrayAccess
{
    /** @var array */
    private $config = array();

    public function __construct(array $config = array())
    {
        $this->loadDefaultConfig();
        if ($config) {
            $this->merge($config);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->config;
    }

    /**
     * Create config from defaults, and merge config/config.php if the file exists
     *
     * @return Config
     */
    public static function create()
    {
        $configDir = dirname(__DIR__) . '/config';
        $config = new self();
        if (file_exists($file = $configDir . '/config.php')) {
            $config->load($file);
        }

        return $config;
    }

    /**
     * Load a config file, merge with the currently loaded configuration.
     */
    public function load($filename)
    {
        if (!file_exists($filename)) {
            throw new ProfilerException("File does not exist: $filename");
        }
        $config = require $filename;
        if ($config === 1) {
            throw new ProfilerException("Config did not return an array: $filename");
        }
        $this->merge($config);
    }

    private function merge(array $config)
    {
        $this->config = array_replace($this->config, $config);
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->config[$offset];
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    private function loadDefaultConfig()
    {
        $this->load(__DIR__ . '/../config/config.default.php');
    }
}
