<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $photo_sort_ids = array_keys(\SortType::getSortTypes('photos'));
        $sql = 'SELECT collection_id FROM `{tbl_prefix}collections` WHERE `type`=\'videos\' AND `sort_type` IN (' . implode(',', $photo_sort_ids) . ')';
        $res = self::req($sql);
        $default_id = \SortType::getDefaultByType('videos')['id'];
        foreach ($res as $re) {
            $sql_update = 'UPDATE `{tbl_prefix}collections` SET `sort_type` = ' . $default_id . ' WHERE `collection_id` = ' . $re['collection_id'];
            self::query($sql_update);
        }
    }
}
