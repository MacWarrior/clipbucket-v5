<?php

namespace Xhgui\Profiler\Saver;

interface SaverInterface
{
    /**
     * @return bool
     */
    public function isSupported();

    /**
     * @return bool
     */
    public function save(array $data);
}
