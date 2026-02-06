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
        $sql = 'SELECT MIN(configid) as config_id, name FROM {tbl_prefix}config WHERE 1 GROUP BY name HAVING COUNT(name) > 1';
        $configs = self::req($sql);
        foreach ($configs as $config) {
            self::query('DELETE FROM {tbl_prefix}config WHERE configid != ' . $config['config_id'] . ' AND name = \'' . $config['name'] . '\'');
        }

        self::alterTable('ALTER TABLE {tbl_prefix}config ADD  CONSTRAINT `name` UNIQUE(`name`)', [
            'table' => 'config',
            'column' => 'name'
        ], [
            'constraint' => [
                'table' => 'config',
                'type' => 'UNIQUE',
                'name' => 'name'
            ]
        ]);
    }
}
