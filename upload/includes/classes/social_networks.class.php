<?php

class SocialNetworks
{
    private static $social_networks;
    private $tablename;
    private $tablename_icons;
    private $fields = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->tablename = 'social_networks_links';
        $this->tablename_icons = 'fontawesome_icons';
        $this->fields = [
            'id_social_networks_link'
            ,'id_fontawesome_icon'
            ,'title'
            ,'url'
            ,'social_network_link_order'
        ];
    }

    public static function getInstance(): self
    {
        if (empty(self::$social_networks)) {
            self::$social_networks = new self();
        }
        return self::$social_networks;
    }

    /**
     * @throws Exception
     */
    public function createSocialNetwork(int $id_fontawesome_icon, string $title, string $url, int $social_network_link_order): bool
    {
        if( empty(trim($title)) ){
            e(lang('title_cannot_be_empty'));
            return false;
        }

        if( empty(trim($url)) ){
            e(lang('url_cannot_be_empty'));
            return false;
        }

        if( !filter_var($url, FILTER_VALIDATE_URL) ){
            e(lang('incorrect_url'));
            return false;
        }

        if( $id_fontawesome_icon == 0 ){
            e(lang('icon_is_required'));
            return false;
        }

        $sql = 'INSERT INTO ' . tbl($this->tablename) . ' (id_fontawesome_icon, title, url, social_network_link_order) VALUES(
            ' . mysql_clean($id_fontawesome_icon) . ',
            \'' . mysql_clean($title) . '\',
            \'' . mysql_clean($url) . '\',
            ' . mysql_clean($social_network_link_order) . '
        )';
        Clipbucket_db::getInstance()->execute($sql);
        return true;
    }

    /**
     * @param $id_social_networks_link
     * @param string $title
     * @param string $url
     * @param int $social_network_link_order
     * @param int $id_fontawesome_icon
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function update($id_social_networks_link, string $title, string $url, int $social_network_link_order, int $id_fontawesome_icon)
    {
        if( empty(trim($title)) ){
            e(lang('title_cannot_be_empty'));
            return false;
        }

        if( empty(trim($url)) ){
            e(lang('url_cannot_be_empty'));
            return false;
        }

        if( !filter_var($url, FILTER_VALIDATE_URL) ){
            e(lang('incorrect_url'));
            return false;
        }

        if( $id_fontawesome_icon == 0 ){
            e(lang('icon_is_required'));
            return false;
        }

        $sql = 'UPDATE ' . tbl($this->tablename) . ' 
            SET title = \'' . mysql_clean($title) . '\',
            url = \'' . mysql_clean($url) . '\',
            social_network_link_order = ' . mysql_clean($social_network_link_order) . ',
            id_fontawesome_icon = ' . mysql_clean($id_fontawesome_icon) . '
           WHERE id_social_networks_link = ' . mysql_clean($id_social_networks_link);
        return Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @param $id_social_networks_link
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function delete($id_social_networks_link)
    {
        $sql = 'DELETE FROM ' . tbl($this->tablename) . ' WHERE id_social_networks_link = ' . mysql_clean($id_social_networks_link) ;
        return Clipbucket_db::getInstance()->execute($sql);
    }

    private function getTableName(): string
    {
        return $this->tablename;
    }

    private function getTableNameIcons(): string
    {
        return $this->tablename_icons;
    }

    private function getFields(): array
    {
        return $this->fields;
    }

    private function getSQLFields($prefix = false): array
    {
        $fields = $this->getFields();

        return array_map(function($field) use ($prefix) {
            $field_name = $this->getTableName() . '.' . $field;
            if( $prefix ){
                $field_name .= ' AS `'.$this->getTableName() . '.' . $field.'`';
            }
            return $field_name;
        }, $fields);
    }

    /**
     * @throws Exception
     */
    public function getAllIcons(): array
    {
        $sql = 'SELECT id_fontawesome_icon, icon FROM ' . tbl($this->tablename_icons);
        return Clipbucket_db::getInstance()->_select($sql);
    }

    /**
     * @param array $params
     * @return array|bool|int
     * @throws Exception
     */
    public function getAll(array $params)
    {
        $param_id_social_networks_link = $params['id_social_networks_link'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $order = '';
        if( $param_order ){
            $order = ' ORDER BY '.$param_order;
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }

        $having = '';
        if( $param_having ){
            $having = ' HAVING '.$param_having;
        }

        $conditions = [];

        if ($param_id_social_networks_link !== false) {
            $conditions[] = 'id_social_networks_link = '. mysql_clean($param_id_social_networks_link);
        }

        $select = $this->getSQLFields();
        $select[] = $this->getTableNameIcons() . '.icon';

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table($this->tablename) . ' 
                LEFT JOIN ' . cb_sql_table($this->tablename_icons) .' ON ' . $this->tablename . '.id_fontawesome_icon = ' . $this->tablename_icons . '.id_fontawesome_icon'
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having
            . $order
            . $limit;
        $result = Clipbucket_db::getInstance()->_select($sql);

        if( $param_count ){
            if( empty($result) ){
                return 0;
            }
            return $result[0]['count'];
        }

        if( !$result ){
            return false;
        }

        if( $param_first_only ){
            return $result[0];
        }

        return $result;
    }

    /**
     * @param array $params
     * @return array|false|int
     * @throws Exception
     */
    public function getOne(array $params)
    {
        $params['first_only'] = true;
        return $this->getAll($params);
    }

    /**
     * @throws Exception
     */
    public static function display(string $mode)
    {
        $params = [
            'order' => 'social_network_link_order ASC'
        ];
        $datas = self::getInstance()->getAll($params);
        if( empty($datas) ){
            return;
        }

        assign('social_links', $datas);
        assign('social_links_class', $mode);

        Template('blocks/social_networks.html');
    }

}