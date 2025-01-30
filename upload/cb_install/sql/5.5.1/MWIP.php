<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_loop_data` (
            `id_histo` INT,
            `loop_index` INT,
            `data` TEXT,
            PRIMARY KEY (id_histo, loop_index)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools_loop_data`
            ADD CONSTRAINT `tools_loop_data_id_tool_histo` FOREIGN KEY (`id_histo`) REFERENCES `{tbl_prefix}tools_histo` (`id_histo`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'tools_loop_data',
            'column' => 'id_histo'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'tools_loop_data_id_tool_histo'
            ]
        ]);
    }
}
