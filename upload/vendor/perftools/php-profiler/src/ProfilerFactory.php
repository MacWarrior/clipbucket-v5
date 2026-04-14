<?php

namespace Xhgui\Profiler;

use Xhgui\Profiler\Exception\ProfilerException;
use Xhgui\Profiler\Profilers\ProfilerInterface;

/**
 * @internal
 */
final class ProfilerFactory
{
    /**
     * Creates Profiler instance that can be used.
     *
     * It returns first profiler, that is usable in testing them in this order:
     * 2) tideways_xhprof
     * 2) tideways
     * 1) uprofiler
     * 3) xhprof
     *
     * @return ProfilerInterface|null
     */
    public static function create(Config $config)
    {
        $adapters = array(
            Profiler::PROFILER_TIDEWAYS_XHPROF => function () {
                return new Profilers\TidewaysXHProf();
            },
            Profiler::PROFILER_TIDEWAYS => function () {
                return new Profilers\Tideways();
            },
            Profiler::PROFILER_UPROFILER => function () {
                return new Profilers\UProfiler();
            },
            Profiler::PROFILER_XHPROF => function () {
                return new Profilers\XHProf();
            },
        );

        if (isset($config['profiler'])) {
            $profiler = $config['profiler'];
            if (!isset($adapters[$profiler])) {
                throw new ProfilerException("Specified profiler '$profiler' is not supported");
            }

            $adapters = array(
                $profiler => $adapters[$profiler],
            );
        }

        foreach ($adapters as $factory) {
            $adapter = $factory($config);
            if ($adapter->isSupported()) {
                return $adapter;
            }
        }

        return null;
    }
}
