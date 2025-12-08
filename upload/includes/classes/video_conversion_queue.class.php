<?php

class VideoConversionQueue
{
    private static $tableName = 'video_conversion_queue';

    private static $fields = [
        'id',
        'videoid',
        'date_added',
        'date_started',
        'date_ended',
        'is_completed'
    ];

    public static function getAll(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_ids = $params['ids'] ?? false;
        $param_videoid = $params['videoid'] ?? false;
        $param_id = $params['id'] ?? false;
        $param_not_complete = $params['not_complete'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }
        $order = 'date_added ASC';
        if ($param_order) {
            $order = $param_order;
        }

        if ($param_ids) {
            $conditions[] = ' ' . self::$tableName . '.id IN (' . implode(',', $param_ids) . ')';
        }
        if ($param_videoid) {
            $conditions[] = ' ' . self::$tableName . '.videoid = ' . mysql_clean($param_videoid);
        }
        if ($param_id) {
            $conditions[] = ' ' . self::$tableName . '.id = ' . mysql_clean($param_id);
        }
        if ($param_not_complete) {
            $conditions[] = ' ' . self::$tableName . '.is_completed != TRUE';
        }

        if (!$param_count) {
            $select = self::getAllFields();
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableName . '.id) AS count';
        }

        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableName)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(', ', $group))
            . $limit
            . ' ORDER BY ' . $order;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0];
        }
        if ($param_count) {
            return $result[0]['count'];
        }
        return empty($result) ? [] : $result;
    }

    /**
     * @param array $params
     * @return array|int|mixed
     * @throws Exception
     */
    public static function getOne(array $params)
    {
        $params['first_only'] = true;
        return self::getAll($params);
    }

    /**
     * @return array
     */
    private static function getAllFields(): array
    {
        return array_map(function ($field) {
            return self::$tableName . '.' . $field;
        }, self::$fields);
    }

    /**
     * @param int $video_id
     * @return bool|mysqli_result
     * @throws Exception
     */
    public static function insert(int $video_id, $audio_track = null)
    {
        $field = ['videoid'];
        $value = [mysql_clean($video_id)];
        if (!empty($audio_track) && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '186')) {
            $field[] = 'audio_track';
            $value[] = mysql_clean($audio_track);
        }
        return Clipbucket_db::getInstance()->execute('INSERT INTO ' . tbl(self::$tableName) . ' (' . implode(', ', $field) . ') VALUES (' . implode(', ', $value) . ') ');
    }

    /**
     * Function used to get list of items in conversion queue
     * @params $Cond, $limit,$order
     *
     * @param array $cond
     * @param string $limit
     * @param string $order
     *
     * @return array
     * @throws Exception
     */
    public static function get_conversion_queue(array $cond = [], string $limit = '', string $order = 'date_added DESC'): array
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '148')) {
            $result = self::getAll(array_merge($cond, ['limit' => $limit, 'order' => $order]));
        } else {
            $conditions = [];
            if (!empty($cond['ids'])) {
                $conditions[] = ' cqueue_id IN (' . implode(',', $cond['ids']) . ')';
            }
            if (!empty($cond['not_complete'])) {
                $conditions[] = 'time_completed is null or time_completed = \'\' or time_completed = 0';
            }
            $table = 'conversion_queue';
            $result = Clipbucket_db::getInstance()->select(tbl($table), '*', implode(' AND ', $conditions), $limit, $order);
        }

        if (count($result) > 0) {
            return $result;
        }
        return [];
    }

    public static function getTableName(): string
    {
        return self::$tableName;
    }


}