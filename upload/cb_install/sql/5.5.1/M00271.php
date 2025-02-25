<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00271 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_tasks` (
            `id_histo` INT,
            `loop_index` INT,
            `data` TEXT,
            PRIMARY KEY (id_histo, loop_index)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools_tasks`
            ADD CONSTRAINT `tools_tasks_id_tool_histo` FOREIGN KEY (`id_histo`) REFERENCES `{tbl_prefix}tools_histo` (`id_histo`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'tools_tasks',
            'column' => 'id_histo'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'tools_tasks_id_tool_histo'
            ]
        ]);

        self::generateTranslation('orphan_file_has_been_deleted', [
            'fr'=>'Suppression du fichier orphelin : %s',
            'en'=>'Delete orphan file :  %s'
        ]);

        self::generateTranslation('processing_x_files', [
            'fr'=>'Traitement de %s fichiers ...',
            'en'=>'Processing %s files ...'
        ]);

        self::generateTranslation('x_orphan_files_have_been_deleted', [
            'fr'=>'%s fichiers orphelins ont été supprimés',
            'en'=>'%s orphan files have been deleted'
        ]);

        self::generateTranslation('loading_file_list', [
            'fr'=>'Chargement de la liste des fichiers...',
            'en'=>'Loading file list...'
        ]);
    }
}
