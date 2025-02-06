<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00191 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        if ((int)config('videos_items_search_page') == 30) {
            self::updateConfig('videos_items_search_page', 28);
        }
        if ((int)config('collection_search_result') == 30) {
            self::updateConfig('collection_search_result', 28);
        }
        if ((int)config('photo_search_result') == 30) {
            self::updateConfig('photo_search_result', 28);
        }
    }
}