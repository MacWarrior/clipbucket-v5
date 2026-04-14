<?php

namespace Xhgui\Profiler;

use Xhgui\Profiler\Exception\ProfilerException;
use Xhgui\Profiler\Saver\SaverInterface;
use Xhgui_Saver;
use Xhgui_Saver_Interface;

/**
 * @internal
 */
final class SaverFactory
{
    /**
     * @param string $saveHandler
     * @param Config $config
     * @return SaverInterface|null
     */
    public static function create($saveHandler, Config $config)
    {
        switch ($saveHandler) {
            case Profiler::SAVER_FILE:
                $defaultConfig = array(
                    'filename' => null,
                );
                $userConfig = isset($config['save.handler.file']) && is_array($config['save.handler.file']) ? $config['save.handler.file'] : array();
                $saverConfig = array_merge($defaultConfig, $userConfig);
                $saver = new Saver\FileSaver($saverConfig['filename']);
                break;

            case Profiler::SAVER_UPLOAD:
                $defaultConfig = array(
                    'uri' => null, // @deprecated
                    'url' => null,
                    'token' => null,
                    'timeout' => 3,
                    'verify' => true,
                );
                $userConfig = isset($config['save.handler.upload']) && is_array($config['save.handler.upload']) ? $config['save.handler.upload'] : array();
                $saverConfig = array_merge($defaultConfig, $userConfig);
                $saver = new Saver\UploadSaver(
                    $saverConfig['url'] ?: $saverConfig['uri'],
                    $saverConfig['token'],
                    $saverConfig['timeout'],
                    $saverConfig['verify']
                );
                break;

            case Profiler::SAVER_STACK:
                $defaultConfig = array(
                    'savers' => array(),
                    'saveAll' => false,
                );
                $userConfig = isset($config['save.handler.stack']) && is_array($config['save.handler.stack']) ? $config['save.handler.stack'] : array();
                $saverConfig = array_merge($defaultConfig, $userConfig);

                $savers = array();
                foreach ($saverConfig['savers'] as $saver) {
                    $instance = self::create($saver, $config);
                    if ($instance) {
                        $savers[] = $instance;
                    }
                }
                $saver = new Saver\StackSaver($savers, $saverConfig['saveAll']);
                break;
            default:
                // create via xhgui-collector
                if (!class_exists('\Xhgui_Saver')) {
                    throw new ProfilerException("For {$saveHandler} you need to install xhgui-collector package: composer require perftools/xhgui-collector");
                }
                $config = self::migrateConfig($config, $saveHandler);
                $legacySaver = Xhgui_Saver::factory($config->toArray());
                $saver = self::getAdapter($legacySaver);
                break;
        }

        if (!$saver || !$saver->isSupported()) {
            return null;
        }

        return $saver;
    }

    /**
     * Prepare config for Xhgui_Saver specific to $saveHandler
     *
     * @param Config $config
     * @param string $saveHandler
     * @return Config
     */
    private static function migrateConfig(Config $config, $saveHandler)
    {
        switch ($saveHandler) {
            case Profiler::SAVER_MONGODB:
                if (isset($config['save.handler.mongodb']['dsn'])) {
                    $config['db.host'] = $config['save.handler.mongodb']['dsn'];
                }
                if (isset($config['save.handler.mongodb']['database'])) {
                    $config['db.db'] = $config['save.handler.mongodb']['database'];
                }
                if (isset($config['save.handler.mongodb']['options'])) {
                    $config['db.options'] = $config['save.handler.mongodb']['options'];
                } else {
                    $config['db.options'] = array();
                }
                if (isset($config['save.handler.mongodb']['driverOptions'])) {
                    $config['db.driverOptions'] = $config['save.handler.mongodb']['driverOptions'];
                } else {
                    $config['db.driverOptions'] = array();
                }
                break;
            case Profiler::SAVER_PDO:
                if (isset($config['save.handler.pdo'])) {
                    $config['pdo'] = $config['save.handler.pdo'];
                }
                break;
        }

        $config['save.handler'] = $saveHandler;

        return $config;
    }

    private static function getAdapter(Xhgui_Saver_Interface $saver)
    {
        $adapters = array(
            new Saver\PdoSaver($saver),
            new Saver\MongoSaver($saver),
        );

        $available = array_filter($adapters, function (SaverInterface $adapter) {
            return $adapter->isSupported();
        });

        return current($available) ?: null;
    }
}
