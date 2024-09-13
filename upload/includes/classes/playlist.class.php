<?php
class Playlist
{
    private static $playlist;
    private $tablename = '';

    private $fields = [];
    public function getTablename(): string
    {
        return $this->tablename;
    }
    public function __construct()
    {
        $this->tablename = 'playlists';
        $this->fields = [
            'playlist_id',
            'playlist_name',
            'userid',
            'playlist_type',
            'description',
            'privacy',
            'total_items',
            'last_update',
            'runtime',
            'first_item',
            'cover',
            'played',
            'date_added'
        ];
    }

    public static function getInstance(): self
    {
        if( empty(self::$playlist) ){
            self::$playlist = new self();
        }
        return self::$playlist;
    }

    private function getSQLFields($type = '', $prefix = false): array
    {
        $fields = $this->fields;

        return array_map(function($field) use ($prefix) {
            $field_name = $this->getTableName() . '.' . $field;
            if( $prefix ){
                $field_name .= ' AS `'.$this->getTableName() . '.' . $field.'`';
            }
            return $field_name;
        }, $fields);
    }

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @throws Exception
     */
    public static function getGenericConstraints(): string
    {
        if (has_access('admin_access', true)) {
            return '';
        }

        $cond = '(playlists.privacy = \'public\'';

        $current_user_id = user_id();
        if ($current_user_id) {
            $cond .= ' OR playlists.userid = ' . $current_user_id . ')';
            $cond .= ' OR (playlists.privacy = \'public\')';
        } else {
            $cond .= ')';
        }
        return $cond;
    }

    /**
     * @throws Exception
     * @noinspection DuplicatedCode
     */
    public function getAll(array $params = [])
    {
        $param_playlist_id = $params['playlist_id'] ?? false;
        $param_playlist_name = $params['playlist_name'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_playlist_type = $params['playlist_type'] ?? false;
        $param_category = $params['category'] ?? false;
        $param_search = $params['search'] ?? false;
        $param_tags = $params['tags'] ?? false;

        $param_condition = $params['condition'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_exist = $params['exist'] ?? false;

        $conditions = [];
        if ($param_playlist_id) {
            $conditions[] = $this->getTablename() . '.playlist_id = \'' . mysql_clean($param_playlist_id) . '\'';
        }
        if ($param_playlist_name) {
            $conditions[] = $this->getTablename() . '.playlist_name LIKE \'%' . mysql_clean($param_playlist_name) . '%\'';
        }
        if ($param_userid) {
            $conditions[] = $this->getTablename() . '.userid = \'' . mysql_clean($param_userid) . '\'';
        }
        if ($param_tags) {
            $conditions[] = 'tags.name LIKE \'%' . mysql_clean($param_tags) . '%\'';
        }
        if ($param_condition) {
            $conditions[] = '(' . $param_condition . ')';
        }

        $version = Update::getInstance()->getDBVersion();

        if( $param_search ){
            /* Search is done on playlist name, playlist tags */
            $cond = '(MATCH('.$this->getTablename() .'.playlist_name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER('.$this->getTablename() .'.playlist_name) LIKE \'%' . mysql_clean($param_search) . '%\'';
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
                $cond .= 'OR MATCH(tags.name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
            }
            $cond .= ')';

            $conditions[] = $cond;
        }

        if( !has_access('admin_access', true) && !$param_exist ){
            $conditions[] = $this->getGenericConstraints(['show_unlisted' => $param_first_only]);
        }

        if( $param_count ){
            $select = ['COUNT(DISTINCT '.$this->getTablename() .'.playlist_id) AS count'];
        } else {
            $select = $this->getSQLFields();
            $select[] = 'users.username AS user_username';
        }

        $join = [];
        $group = [];
        if( $version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264) ) {
            if( !$param_count ){
                $select[] = 'GROUP_CONCAT( DISTINCT(tags.name) SEPARATOR \',\') AS tags';
            }
            $join[] = 'LEFT JOIN ' . cb_sql_table('playlist_tags') . ' ON playlists.playlist_id = playlist_tags.id_playlist';
            $join[] = 'LEFT JOIN ' . cb_sql_table('tags') .' ON playlist_tags.id_tag = tags.id_tag';
        }

        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
            $join[] = 'LEFT JOIN ' . cb_sql_table('playlists_categories') . ' ON playlists.playlist_id = playlists_categories.id_playlist';
            $join[] = 'LEFT JOIN ' . cb_sql_table('categories') . ' ON playlists_categories.id_category = categories.category_id';

            if( !$param_count ){
                $select[] = 'GROUP_CONCAT( DISTINCT(categories.category_id) SEPARATOR \',\') AS category';
            }

            if( $param_category ){
                if( !is_array($param_category) ){
                    $conditions[] = 'categories.category_id = '.mysql_clean($param_category);
                } else {
                    $conditions[] = 'categories.category_id IN (' . implode(', ', $param_category) . ')';
                }
            }
        }

        if( !$param_count ){
            $group[] = $this->getTablename() .'.playlist_id';
        }

        if( $param_group ){
            $group[] = $param_group;
        }

        $having = '';
        if( $param_having ){
            $having = ' HAVING '.$param_having;
        }

        $order = '';
        if( $param_order ){
            $order = ' ORDER BY '.$param_order;
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table($this->getTableName()) . '
                LEFT JOIN ' . cb_sql_table('users') . ' ON playlists.userid = users.userid '
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having
            . $order
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);

        if( $param_exist ){
            return !empty($result);
        }

        if( $param_count ){
            if( empty($result) ){
                return 0;
            }
            return $result[0]['count'];
        }

        if( $param_first_only ){
            return $result[0] ?? [];
        }
        if( !$result ){
            return false;
        }

        return $result;
    }

    public function getOne(int $playlist_id):array
    {
        return $this->getAll(['playlist_id'=>$playlist_id, 'first_only'=>true]);
    }

}