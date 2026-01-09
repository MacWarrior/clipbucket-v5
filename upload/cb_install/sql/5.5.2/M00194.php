<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00194 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}categories` CHANGE `is_default` `is_default` ENUM(\'yes\',\'no\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL',[
            'table' => 'categories',
            'column'=>'is_default'
        ]);
        $sql = 'UPDATE `{tbl_prefix}categories` SET is_default=NULL WHERE is_default=\'no\'';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}categories` CHANGE `is_default` `is_default` BOOLEAN NULL',[
            'table' => 'categories',
            'column'=>'is_default'
        ]);
        $sql = 'SELECT MIN(category_id) AS min_categ_default, id_category_type FROM `{tbl_prefix}categories` WHERE is_default = TRUE GROUP BY id_category_type,is_default HAVING count(is_default) > 1';
        $result = self::req($sql);
        foreach ($result as $item) {
            $sql = 'UPDATE `{tbl_prefix}categories` SET is_default=NULL WHERE category_id > '.$item['min_categ_default'].' AND id_category_type = '.$item['id_category_type'];
            self::query($sql);
        }
        self::alterTable('ALTER TABLE '.tbl('categories').' ADD CONSTRAINT unique_default_per_type UNIQUE(is_default,id_category_type) ',[
            'table' => 'categories',
            'columns'=>['is_default','id_category_type']
        ], [
            'constraint' => [
                'type' => 'UNIQUE',
                'name' => 'unique_default_per_type',
                'table' => 'categories'
            ]
        ]);
    }

}
