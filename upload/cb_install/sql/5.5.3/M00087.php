<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00087 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        \AdminTool::test_get_method1();
    }
}
