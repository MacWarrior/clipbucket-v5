<?php

class Tags
{
    /**
     * @throws Exception
     */
    public static function getTags($limit = 'false', $cond = false)
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return [];
        }
        global $db;
        $query = 'SELECT T.name AS tag, TT.name AS tag_type, T.id_tag, 
        IF(COUNT(CT.id_tag) = 0 AND COUNT(PT.id_tag) = 0 AND COUNT(PLT.id_tag) = 0 AND COUNT(UT.id_tag) = 0 AND COUNT(VT.id_tag) = 0, true, false) AS can_delete
        FROM ' . tbl('tags') . ' T 
        INNER JOIN ' . tbl('tags_type') . ' TT ON TT.id_tag_type = T.id_tag_type 
        LEFT JOIN ' . tbl('collection_tags') . ' CT ON CT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('photo_tags') . ' PT ON PT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON PLT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('user_tags') . ' UT ON UT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('video_tags') . ' VT ON VT.id_tag = T.id_tag 
        '. ($cond ? 'WHERE '. (is_array($cond) ? implode(' AND ', $cond) : $cond) : '') .'
        GROUP BY T.id_tag
        ';
        if ($limit) {
            $query .= 'LIMIT ' . $limit;
        }

        return $db->_select($query, 0);
    }

    /**
     * @throws Exception
     */
    public static function countTags($cond)
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return 0;
        }
        global $db;
        return $db->count(tbl('tags') . ' T 
        INNER JOIN ' . tbl('tags_type') . ' TT ON TT.id_tag_type = T.id_tag_type 
        LEFT JOIN ' . tbl('collection_tags') . ' CT ON CT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('photo_tags') . ' PT ON PT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON PLT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('user_tags') . ' UT ON UT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('video_tags') . ' VT ON VT.id_tag = T.id_tag ', 'DISTINCT T.name, TT.name, T.id_tag', (is_array($cond) ? implode(' AND ', $cond) : $cond));
    }

    /**
     * @param $id_tag
     * @return false|void
     * @throws Exception
     */
    public static function deleteTag($id_tag)
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return false;
        }
        global $db;
        $query = 'SELECT 
                    IF(COUNT(CT.id_tag) = 0 AND COUNT(PT.id_tag) = 0 AND COUNT(PLT.id_tag) = 0 AND COUNT(UT.id_tag) = 0 AND COUNT(VT.id_tag) = 0, true, false) AS can_delete
                    FROM ' . tbl('tags') . ' T
                    LEFT JOIN ' . tbl('collection_tags') . ' CT ON CT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('photo_tags') . ' PT ON PT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON PLT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('user_tags') . ' UT ON UT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('video_tags') . ' VT ON VT.id_tag = T.id_tag 
                    WHERE T.id_tag = ' . mysql_clean($id_tag);
        $result = $db->_select($query);
        if (!empty($result) && $result[0]['can_delete']) {
            $db->delete(tbl('tags'), ['id_tag'], [$id_tag]);
            e(lang('tag_deleted'), 'm');
        } else {
            e(lang('error'));
        }
    }


    /**
     * @param $name
     * @param $id_tag
     * @return bool
     * @throws Exception
     */
    public static function updateTag($name, $id_tag):bool
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return false;
        }
        global $db;
        if (strlen(trim($name)) <= 2) {
            e(lang('tag_too_short'),'warning');
            return false;
        }
        try {
            $db->update(tbl('tags'), ['name'], [$name], 'id_tag = ' . mysql_clean($id_tag));
            e(lang('tag_updated'), 'm');
            return true;
        } catch (Exception $e) {
            e(lang('error'));
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function saveTags(string $tags, string $object_type, int $object_id): bool
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return false;
        }
        switch ($object_type) {
            case 'video':
                $id_field = 'id_video';
                $table_tag = 'video_tags';
                break;
            case 'photo':
                $id_field = 'id_photo';
                $table_tag = 'photo_tags';
                break;
            case 'collection':
                $id_field = 'id_collection';
                $table_tag = 'collection_tags';
                break;
            case 'profile':
                $id_field = 'id_user';
                $table_tag = 'user_tags';
                break;
            case 'playlist':
                $id_field = 'id_playlist';
                $table_tag = 'playlist_tags';
                break;
            default:
                //TODO
                return false;
        }
        global $db;
        $sql_delete_link = 'DELETE FROM ' . tbl($table_tag) . ' WHERE ' . $id_field . ' = ' . mysql_clean($object_id);
        if (!$db->execute($sql_delete_link, 'delete')) {
            e(lang('error_delete_linking_tags'));
            return false;
        }
        if (!empty($tags)) {
            $sql_id_type = 'SELECT id_tag_type
                       FROM ' . tbl('tags_type') . '
                       WHERE name LIKE \'' . $object_type . '\'';
            $res = $db->_select($sql_id_type);
            if (!empty($res)) {
                $id_type = $res[0]['id_tag_type'];
            } else {
                e(lang('unknown_tag_type'));
                return false;
            }

            $tags_count = substr_count($tags, ',')+1;
            $sql_insert_tag = 'INSERT IGNORE INTO ' . tbl('tags') . ' (id_tag_type, name) (
                WITH RECURSIVE NumberSequence AS (
                    SELECT 0 AS n
                    UNION ALL
                    SELECT n + 1
                    FROM NumberSequence
                    WHERE n <= ' . $tags_count . '
                )
                SELECT DISTINCT
                    ' . mysql_clean($id_type) . '
                    , SUBSTRING_INDEX(SUBSTRING_INDEX(\'' . mysql_clean($tags) . '\', \',\', seq.n + 1), \',\', -1) AS tags
                FROM NumberSequence seq
            )';
            if (!$db->execute($sql_insert_tag, 'insert')) {
                e(lang('technical_error'));
                return false;
            }

            $tag_array = explode(',', $tags);
            $sql_link_tag = 'INSERT IGNORE INTO ' . tbl($table_tag) . ' (`id_tag`, `' . $id_field . '`) (
                SELECT 
                    tags.id_tag
                    ,' . mysql_clean($object_id) . '
                FROM
                    ' . cb_sql_table('tags') . '
                WHERE
                    tags.id_tag_type = ' . mysql_clean($id_type) . '
                    AND tags.name IN(\'' . implode('\',\'', $tag_array) . '\')
            )';
            if (!$db->execute($sql_link_tag, 'insert')) {
                e(lang('technical_error'));
                return false;
            }
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public static function fill_auto_complete_tags($object_type): array
    {
        global $db;
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return [];
        }
        $sql_id_type = 'SELECT id_tag_type
                   FROM ' . tbl('tags_type') . '
                   WHERE name LIKE \'' . $object_type . '\'';
        $res = $db->_select($sql_id_type);
        if (!empty($res)) {
            $id_type = $res[0]['id_tag_type'];
        } else {
            e(lang('unknown_tag_type'));
            return [];
        }
        $query = 'SELECT name FROM ' . tbl('tags') . ' T  WHERE T.id_tag_type = ' . mysql_clean($id_type);
        $result = $db->_select($query, 0);
        return array_map(function ($item) {
            return $item['name'];
        }, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getTagTypes(): array
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return [];
        }
        global $db;
        return $db->select(tbl('tags_type'),'*',false, false, false, false, 300);
    }
}
