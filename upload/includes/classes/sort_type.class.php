<?php

class SortType
{
    private static $tableName = 'sorts';

    /**
     * @param string $type
     * @return array|false
     * @throws Exception
     */
    public static function getSortTypes($type)
    {
        if (empty($type) || !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            $type = 'photos';
        }
        $sortTypes = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl(self::$tableName) . ' WHERE type = \'' . mysql_clean($type) . '\'');
        return array_combine(
            array_column($sortTypes, 'id'), array_column($sortTypes, 'label')
        );
    }

    public static function getSortLabelById($id)
    {
        if (empty($id) || !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            return '';
        }
        $res = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl(self::$tableName) . ' WHERE id = ' . mysql_clean($id)) ;
        return $res[0]['label'] ?? '';
    }

    public static function getDefaultByType($type)
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            return '';
        }
        $res = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl(self::$tableName) . ' WHERE is_default = TRUE AND type = \'' . mysql_clean($type) . '\'') ;
        return $res[0] ?? [];
    }

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return self::$tableName;
    }
}
