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

        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('memberships') . '` (
            `id_membership` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_level_id` INT(20) NOT NULL,
            `frequency` ENUM (\'daily\', \'weekly\', \'monthly\', \'yearly\'),
            `base_price` DECIMAL,
            `description` VARCHAR (512),
            `storage_quota_included` INT DEFAULT NULL,
            `storage_price_per_go` DECIMAL,
            `disabled` BOOLEAN DEFAULT FALSE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `' . tbl('memberships') . '`
           ADD UNIQUE KEY `user_frequency` (`frequency`, `user_level_id`);', [
                'table' => 'memberships'
            ], [
                'table'           => 'memberships',
                'constraint_name' => 'user_frequency'
            ]);
        self::alterTable('ALTER TABLE `' . tbl('memberships') . '` ADD CONSTRAINT `user_level_membership` FOREIGN KEY (`user_level_id`) REFERENCES `' . tbl('user_levels') . '` (`user_level_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'memberships'
        ], [
            'table'           => 'memberships',
            'constraint_name' => 'user_level_membership'
        ]);
        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('user_memberships') . '` (
            `id_user_membership` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `userid` BIGINT NOT NULL,
            `id_membership` INT NOT NULL,
            `date_start` datetime NOT NULL,
            `date_end` datetime NULL,
            `price` DECIMAL NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `' . tbl('user_memberships') . '` ADD CONSTRAINT `user_membership_user` FOREIGN KEY (`userid`) REFERENCES `' . tbl('users') . '` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;',[
            'table' => 'user_memberships'
        ], [
            'table'           => 'user_memberships',
            'constraint_name' => 'user_membership_user'
        ]);
        self::alterTable('ALTER TABLE `' . tbl('user_memberships') . '` ADD CONSTRAINT `user_membership_membership` FOREIGN KEY (`id_membership`) REFERENCES `' . tbl('memberships') . '` (`id_membership`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'user_memberships'
        ], [
            'table'           => 'user_memberships',
            'constraint_name' => 'user_membership_membership'
        ]);

        self::generateConfig('enable_membership', 'no');
        self::generateTranslation('enable_membership', [
            'fr'=>'Activer les abonnements',
            'en'=>'Enable membership'
        ]);

        self::generateTranslation('memberships', [
            'fr'=>'Abonnements',
            'en'=>'Membership'
        ]);

        self::generateTranslation('storage_price', [
            'fr'=>'Prix de stockage',
            'en'=>'Storage price'
        ]);

        self::generateTranslation('storage_quota', [
            'fr'=>'Quota de stockage',
            'en'=>'Storage quota'
        ]);
        self::generateTranslation('storage_quota_included', [
            'fr'=>'Quota de stockage inclus',
            'en'=>'Storage quota included'
        ]);
        self::generateTranslation('base_price', [
            'fr'=>'Prix initial',
            'en'=>'Base price'
        ]);

        self::generateTranslation('frequency', [
            'fr'=>'Fréquence',
            'en'=>'Frequency'
        ]);

        self::generateTranslation('frequency_daily', [
            'fr'=>'Journalier',
            'en'=>'Daily'
        ]);

        self::generateTranslation('frequency_weekly', [
            'fr'=>'Hebdomadaire',
            'en'=>'Weekly'
        ]);

        self::generateTranslation('frequency_monthly', [
            'fr'=>'Mensuel',
            'en'=>'Monthly'
        ]);

        self::generateTranslation('frequency_yearly', [
            'fr'=>'Annuel',
            'en'=>'Yearly'
        ]);

        self::generateTranslation('editing', [
            'fr'=>'Edition',
            'en'=>'Editing'
        ]);

        self::generateTranslation('add_membership', [
            'fr'=>'Ajouter un niveau d\'abonnement',
            'en'=>'Add membership level'
        ]);
        self::generateTranslation('edit_membership', [
            'fr'=>'Editer un niveau d\'abonnement',
            'en'=>'Edit membership level'
        ]);

        self::generateTranslation('membership_deleted', [
            'fr'=>'L\'abonnement a été supprimé',
            'en'=>'Membership has been deleted'
        ]);

        self::generateTranslation('cant_delete_membership_at_least_one_user', [
            'fr'=>'Impossible de supprimer l\'abonnement car au moins un utilisateur y est attaché',
            'en'=>'Cannot delete this membership, at least one user subscribe to it'
        ]);

        self::generateTranslation('creation', [
            'fr'=>'Création',
            'en'=>'Creation'
        ]);

        self::generateTranslation('must_activate_storage_history', [
            'fr'=>'Vous devez activer l\'option "Activer l\'historique de stockage" pour éditer ce champs',
            'en'=>'You must activate option "Activate storage history" to edit this field'
        ]);

        self::generateTranslation('subscribers', [
            'fr'=>'Abonnés',
            'en'=>'Subscribers'
        ]);

        self::generateTranslation('first_start', [
            'fr'=>'Date de début du premier abonnement',
            'en'=>'First membership start date'
        ]);
        self::generateTranslation('last_end', [
            'fr'=>'Date de fin du dernier abonnement',
            'en'=>'Last membership end date'
        ]);
        self::generateTranslation('nb_membership', [
            'fr'=>'Nombre d\'abonnement',
            'en'=>'Total memberships'
        ]);
        self::generateTranslation('sum_price', [
            'fr'=>'Somme des abonnements',
            'en'=>'Memberships sum'
        ]);

        self::generateTranslation('max_period_storage', [
            'fr'=>'Stockage maximum utilisé durant la période',
            'en'=>'Maximum storage during period'
        ]);

        self::generateTranslation('date_start', [
            'fr'=>'Date de début',
            'en'=>'Date start'
        ]);

        self::generateTranslation('date_end', [
            'fr'=>'Date de fin',
            'en'=>'Date end'
        ]);

        self::generateTranslation('price', [
            'fr'=>'Prix',
            'en'=>'Price'
        ]);
    }
}
