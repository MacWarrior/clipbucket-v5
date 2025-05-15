<?php

class SortType
{
    private static string $tableName = 'sorts';

    /**
     * @param string $type
     * @throws Exception
     */
    public static function getSortTypes($type): array
    {
        if (empty($type) || !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            $type = 'photos';
        }
        $sortTypes = Clipbucket_db::getInstance()->_select('SELECT id, label, type, is_default FROM ' . tbl(self::$tableName) . ' WHERE type = \'' . mysql_clean($type) . '\'');
        return array_combine(
            array_column($sortTypes, 'id'), array_column($sortTypes, 'label')
        );
    }

    /**
     * @throws Exception
     */
    public static function getSortLabelById($id)
    {
        if (empty($id) || !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            return '';
        }
        $res = Clipbucket_db::getInstance()->_select('SELECT id, label, type, is_default FROM ' . tbl(self::$tableName) . ' WHERE id = ' . (int)$id) ;
        return $res[0]['label'] ?? '';
    }

    /**
     * @throws Exception
     */
    public static function getDefaultByType($type)
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            return '';
        }
        $res = Clipbucket_db::getInstance()->_select('SELECT id, label, type, is_default FROM ' . tbl(self::$tableName) . ' WHERE is_default = TRUE AND type = \'' . mysql_clean($type) . '\'') ;
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
