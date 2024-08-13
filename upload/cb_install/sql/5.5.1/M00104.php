<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00104 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('unknown_type', [
            'fr'=>'Type inconnu',
            'en'=>'Unknown type'
        ]);

        self::insertTool('calc_user_storage', 'AdminTool::calcUserStorage', '0 1 * * *', true);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}users_storage_histo`
                (
                    `id_user`       BIGINT   NOT NULL,
                    `datetime`      DATETIME NOT NULL DEFAULT NOW(),
                    `storage_used`  BIGINT   NOT NULL,
                    PRIMARY KEY (`id_user`, `datetime`)
                ) ENGINE = InnoDB
                  DEFAULT CHARSET = utf8mb4
                  COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}users_storage_histo` ADD CONSTRAINT `id_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;', [
            'table'  => 'users_storage_histo',
            'column' => 'id_user'
        ], [
            'constraint_name' => 'id_user_ibfk_1',
            'contraint_type'  => 'FOREIGN KEY'
        ]);

        self::generateTranslation('calc_user_storage_label', [
            'fr'=>'Calcul utilisation disque utilisateur',
            'en'=>'Calc user storage'
        ]);
        self::generateTranslation('calc_user_storage_description', [
            'fr'=>'Calcul pour un utilisateur le poids de tous ses fichiers uploadés',
            'en'=>'Calc for a user weight of all his uploaded files'
        ]);

        self::generateConfig('enable_storage_history', 'no');
        self::generateConfig('enable_storage_history_fo', 'no');

        self::generateTranslation('enable_storage_history', [
            'fr' => 'Activer l\'historique de stockage',
            'en' => 'Enable storage history'
        ]);
        self::generateTranslation('enable_storage_history_fo', [
            'fr' => 'Afficher l\'historique de stockage sur le front office',
            'en' => 'Display storage history on front office'
        ]);
        self::generateTranslation('user_current_storage', [
            'fr'=>'Espace utilisé actuellement',
            'en'=>'Current storage used'
        ]);
        self::generateTranslation('storage_use', [
            'fr'=>'Espace utilisé',
            'en'=>'Storage use'
        ]);
        self::generateTranslation('storage_history', [
            'fr'=>'Historique de l\'espace utilisé',
            'en'=>'Storage history'
        ]);
    }
}