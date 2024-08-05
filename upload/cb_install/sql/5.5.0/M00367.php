<?php

namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00367 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'SET @constraint_name = (SELECT CONSTRAINT_NAME
                        FROM information_schema.key_column_usage
                        WHERE CONSTRAINT_SCHEMA = DATABASE()
                          AND TABLE_NAME = \'{tbl_prefix}tools\'
                          AND COLUMN_NAME = \'id_tools_status\'
                          AND REFERENCED_TABLE_NAME IS NOT NULL);';
        self::query($sql);
        $sql = 'SET @sql = \'ALTER TABLE `{tbl_prefix}tools` DROP FOREIGN KEY @constraint_name;\';';
        self::query($sql);
        $sql = 'SET @sql = REPLACE(@sql, \'@constraint_name\', @constraint_name);';
        self::query($sql);
        $sql = 'PREPARE alterTable FROM @sql;';
        self::query($sql);
        $sql = 'EXECUTE alterTable;';
        self::query($sql);
        $sql = 'DEALLOCATE PREPARE alterTable;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools` DROP COLUMN id_tools_status', [
            'table'  => 'tools',
            'column' => 'id_tools_status'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools` DROP COLUMN elements_total', [
            'table'  => 'tools',
            'column' => 'elements_total'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools` DROP COLUMN elements_done', [
            'table'  => 'tools',
            'column' => 'elements_done'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools_status` RENAME `{tbl_prefix}tools_histo_status`;', ['table' => 'tools_status']);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools_histo_status` CHANGE `id_tools_status` `id_tools_histo_status` INT NOT NULL AUTO_INCREMENT;', [
            'table'  => 'tools_histo_status',
            'column' => 'id_tools_status'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_histo`
                (
                    `id_histo`              INT      NOT NULL AUTO_INCREMENT,
                    `id_tool`               INT      NOT NULL,
                    `id_tools_histo_status` INT      NOT NULL,
                    `date_start`            DATETIME NOT NULL,
                    `date_end`              DATETIME NULL,
                    `elements_total`        INT      NULL,
                    `elements_done`         INT      NULL,
                    PRIMARY KEY (`id_histo`)
                ) ENGINE = InnoDB
                  DEFAULT CHARSET = utf8mb4
                  COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'ALTER TABLE `{tbl_prefix}tools_histo` ADD CONSTRAINT `id_tools_histo` FOREIGN KEY (`id_tool`) REFERENCES `{tbl_prefix}tools` (`id_tool`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'tools_histo',
            'column' => 'id_tool'
        ], [
            'constraint_name'    => 'id_tools_histo',
            'constraint_type'   => 'FOREIGN KEY',
            'constraint_schema' => '{dbname}'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}tools_histo` ADD CONSTRAINT `id_tools_histo_status` FOREIGN KEY (`id_tools_histo_status`) REFERENCES `{tbl_prefix}tools_histo_status` (`id_tools_histo_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;';
        self::alterTable($sql, [
            'table'  => 'tools_histo',
            'column' => 'id_tools_histo_status'
        ], [
            'constraint_name'   => 'id_tools_histo_status',
            'constraint_type'   => 'FOREIGN KEY',
            'constraint_schema' => '{dbname}'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_histo_log`
        (
            `id_log`   INT          NOT NULL AUTO_INCREMENT,
            `id_histo` INT          NOT NULL,
            `datetime` DATETIME     NOT NULL,
            `message`  VARCHAR(256) NOT NULL,
            PRIMARY KEY (`id_log`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'ALTER TABLE `{tbl_prefix}tools_histo_log`
            ADD CONSTRAINT `id_tools_histo_log` FOREIGN KEY (`id_histo`) REFERENCES `{tbl_prefix}tools_histo` (`id_histo`) ON DELETE NO ACTION ON UPDATE NO ACTION;';
        self::alterTable($sql, [
            'table'  => 'tools_histo_log',
            'column' => 'id_histo'
        ], [
            'constraint_name'    => 'id_tools_histo_log',
            'constraint_type'   => 'FOREIGN KEY',
            'constraint_schema' => '{dbname}'
        ]);

        $sql = 'UPDATE `{tbl_prefix}tools` SET function_name = REPLACE(function_name, \'AdminTool::\', \'\');';
        self::query($sql);

        self::generateTranslation('no_logs', [
            'en' => 'No logs to display',
            'fr' => 'Aucuns journaux à afficher'
        ]);

        self::generateTranslation('show_log', [
            'en' => 'Show last logs',
            'fr' => 'Afficher les derniers journaux'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `code` VARCHAR(32) NOT NULL;';
        self::alterTable($sql, [
            'table'  => 'tools'
        ], [
            'table'  => 'tools',
            'column' => 'code'
        ]);

        $sql = 'UPDATE `{tbl_prefix}tools` SET `code` = REPLACE( language_key_label,\'_label\', \'\');';
        self::query($sql);
        $sql = 'CREATE TEMPORARY TABLE `tmp_ids` SELECT MIN(`id_tool`) FROM `{tbl_prefix}tools` GROUP BY `code`;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}tools` WHERE `id_tool` NOT IN(SELECT * FROM `tmp_ids`);';
        self::query($sql);
        $sql = 'ALTER TABLE `{tbl_prefix}tools` ADD UNIQUE (`code`);';
        self::alterTable($sql, [
            'table'  => 'tools',
            'column' => 'code'
        ], [
            'constraint_name'   => 'code',
            'constraint_type'   => 'UNIQUE',
            'constraint_schema' => '{dbname}'
        ]);

        self::generateTranslation('tool_started', [
            'en' => 'Tool started',
            'fr' => 'Outil lancé'
        ]);
        self::generateTranslation('tool_stopped', [
            'en' => 'Tool ended',
            'fr' => 'Outil terminé'
        ]);
    }
}