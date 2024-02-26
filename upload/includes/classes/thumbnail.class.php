<?php
class Thumbnail
{
    private static $thumbnail;
    private $tablename = '';
    private $fields = [];

    /**
     * @throws Exception
     */
    public function __construct(){
        $this->tablename = 'video_thumbs';

        $this->fields = [
            'videoid'
            ,'resolution'
            ,'num'
            ,'extension'
            ,'version'
            ,'type'
        ];
    }

    public static function getInstance(): self
    {
        if( empty(self::$thumbnail) ){
            self::$thumbnail = new self();
        }
        return self::$thumbnail;
    }

    public function getTableName(): string
    {
        return $this->tablename;
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

    public function getFilePath(array $object, array $thumbnail, array $newResolution = [], string $newExtension = ''): string
    {
        $num = str_pad($thumbnail['num'], 4, '0', STR_PAD_LEFT);

        if( empty($newResolution) ){
            $resolution = $thumbnail['resolution'];
        } else {
            $resolution = $newResolution['width'] . 'x' . $newResolution['height'];
        }

        if( empty($newExtension) ){
            $extension = $thumbnail['extension'];
        } else {
            $extension = $newExtension;
        }

        return DirPath::get('thumbs') . $object['file_directory'] . DIRECTORY_SEPARATOR . $object['file_name'] . '-' . $resolution . '-' . $num . '.' . $extension;
    }

    /**
     * @throws Exception
     */
    public function getOne(array $params = [])
    {
        $params['first_only'] = true;
        return $this->getAll($params);
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params = [])
    {
        $param_videoid = $params['videoid'] ?? false;
        $param_resolution = $params['resolution'] ?? false;
        $param_num = $params['num'] ?? false;
        $param_extension = $params['extension'] ?? false;
        $param_version = $params['version'] ?? false;
        $param_type = $params['type'] ?? false;

        $param_condition = $params['condition'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_exist = $params['exist'] ?? false;
        $param_count = $params['count'] ?? false;

        $conditions = [];
        if( $param_videoid ){
            $conditions[] = $this->getTableName() . '.videoid = \''.mysql_clean($param_videoid).'\'';
        }
        if( $param_resolution ){
            $conditions[] = $this->getTableName() . '.resolution = \''.mysql_clean($param_resolution).'\'';
        }
        if( $param_num ){
            $conditions[] = $this->getTableName() . '.num = \''.mysql_clean($param_num).'\'';
        }
        if( $param_extension ){
            $conditions[] = $this->getTableName() . '.extension = \''.mysql_clean($param_extension).'\'';
        }
        if( $param_version ){
            $conditions[] = $this->getTableName() . '.version = \''.mysql_clean($param_version).'\'';
        }
        if( $param_type ){
            $conditions[] = $this->getTableName() . '.type = \''.mysql_clean($param_type).'\'';
        }

        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
        }

        if( $param_count ){
            $select = ['COUNT( ' . $this->getTableName() . '.videoid) AS count'];
        } else {
            $select = $this->getSQLFields();
        }

        $group = [];

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
                LEFT JOIN ' . cb_sql_table('users') . ' ON video.userid = users.userid '
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

        if( !$result ){
            return false;
        }

        if( $param_first_only ){
            return $result[0];
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function delete(array $video_detail, array $params): bool
    {
        $param_videoid = $video_detail['videoid'] ?? false;
        $param_num = $params['num'] ?? false;
        $param_type = $params['type'] ?? false;
        $param_exclude_resolution = $params['exclude_resolution'] ?? false;
        $param_condition = $params['condition'] ?? false;
        $file_type = false;

        $conditions = [];
        if( $param_videoid ){
            $conditions[] = $this->getTableName() . '.videoid = \'' . mysql_clean($param_videoid) . '\'';
        }
        if( $param_num ){
            $conditions[] = $this->getTableName() . '.num = \'' . mysql_clean($param_num) . '\'';
        }
        if( $param_type ){
            $conditions[] = $this->getTableName() . '.type = \'' . mysql_clean($param_type) . '\'';

            switch($param_type){
                case 'auto':
                    $file_type = '';
                    break;
                case 'custom':
                case 'poster':
                case 'backdrop':
                    $file_type = strtolower(substr($param_type, 0, 1));;
                    break;
                default:
                    e('Unsupported type : ' . $param_type);
                    return false;
            }
        }
        if( $param_exclude_resolution ){
            $conditions[] = $this->getTableName() . '.resolution != \'' . mysql_clean($param_exclude_resolution) . '\'';
        }

        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
        }

        if( empty($conditions) ){
            e('Missing conditions');
            return false;
        }

        $thumbnails = $this->getAll($params);
        if( empty($thumbnails) ){
            // Nothing to do
            return true;
        }

        $dir_path = DirPath::get('thumbs') . $video_detail['file_directory'] . DIRECTORY_SEPARATOR;
        $file_patern =  $video_detail['file_name'] . '*-' . $param_num ?? '*' . $file_type ? ('-' . $file_type . '*') : '';
        $files = glob($dir_path . $file_patern);
        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        // Case when we delete all video thumbnails
        if( count($conditions) == 1 && $param_videoid ){
            $sql ='DELETE FROM ' . tbl($this->getTableName())
                . ' WHERE ' . implode(' AND ', $conditions);
            Clipbucket_db::getInstance()->execute($sql);
            return true;
        }

        foreach($thumbnails as $thumbnail){
            if( $param_type ) {
                if( in_array($param_type, ['auto', 'custom']) ){
                    $type = 'thumbnail';
                } else {
                    $type = $param_type;
                }

                if( $video_detail['default_' . $type] == (int)$thumbnail['num'] ){

                }
            }

            $sql ='DELETE FROM ' . tbl($this->getTableName())
                . ' WHERE 
                        AND videoid = \'' . mysql_clean($thumbnail['videoid']) . '\'
                        AND type = \'' . mysql_clean($thumbnail['type']) . '\'
                        AND resolution = \'' . mysql_clean($thumbnail['resolution']) . '\'
                        AND num = \'' . mysql_clean($thumbnail['num']) . '\'';
            Clipbucket_db::getInstance()->execute($sql);
        }


    }

    /**
     * @throws Exception
     */
    public function insert($params)
    {
        $param_videoid = $params['videoid'];
        $param_resolution = $params['resolution'];
        $param_num = $params['num'];
        $param_extension = $params['extension'];
        $param_type = $params['type'];

        $field_list = ['videoid', 'resolution', 'num', 'extension', 'version', 'type'];
        $field_values = [$param_videoid, $param_resolution, $param_num, $param_extension, VERSION, $param_type];
        Clipbucket_db::getInstance()->insert(tbl('video_thumbs'), $field_list, $field_values);
    }
}