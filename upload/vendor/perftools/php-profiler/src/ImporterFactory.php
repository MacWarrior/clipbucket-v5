<?php

namespace Xhgui\Profiler;

use RuntimeException;

final class ImporterFactory
{
    public static function create()
    {
        $config = Config::create();
        $saver = SaverFactory::create($config['save.handler'], $config);
        if (!$saver) {
            throw new RuntimeException("Unable to obtain saver");
        }

        return new Importer($saver);
    }
}
