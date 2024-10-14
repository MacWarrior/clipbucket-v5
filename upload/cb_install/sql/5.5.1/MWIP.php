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
        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('currency') . '` (
            `id_currency` INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `country` VARCHAR(64) NOT NULL,
            `code` VARCHAR(3) NOT NULL UNIQUE,
            `symbol` VARCHAR(5) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `' . tbl('currency') . '` (`country`, `code`, `symbol`) VALUES 
            (\'Albania Lek\',\'ALL\',\'Lek\'),
            (\'Afghanistan Afghani\',\'AFN\',\'?\'),
            (\'Argentina Peso\',\'ARS\',\'$\'),
            (\'Aruba Guilder\',\'AWG\',\'ƒ\'),
            (\'Australia Dollar\',\'AUD\',\'$\'),
            (\'Azerbaijan Manat\',\'AZN\',\'?\'),
            (\'Bahamas Dollar\',\'BSD\',\'$\'),
            (\'Barbados Dollar\',\'BBD\',\'$\'),
            (\'Belarus Ruble\',\'BYN\',\'Br\'),
            (\'Belize Dollar\',\'BZD\',\'BZ$\'),
            (\'Bermuda Dollar\',\'BMD\',\'$\'),
            (\'Bolivia Bolíviano\',\'BOB\',\'$b\'),
            (\'Bosnia and Herzegovina Convertible Mark\',\'BAM\',\'KM\'),
            (\'Botswana Pula\',\'BWP\',\'P\'),
            (\'Bulgaria Lev\',\'BGN\',\'??\'),
            (\'Brazil Real\',\'BRL\',\'R$\'),
            (\'Brunei Darussalam Dollar\',\'BND\',\'$\'),
            (\'Cambodia Riel\',\'KHR\',\'?\'),
            (\'Canada Dollar\',\'CAD\',\'$\'),
            (\'Cayman Islands Dollar\',\'KYD\',\'$\'),
            (\'Chile Peso\',\'CLP\',\'$\'),
            (\'China Yuan Renminbi\',\'CNY\',\'¥\'),
            (\'Colombia Peso\',\'COP\',\'$\'),
            (\'Costa Rica Colon\',\'CRC\',\'?\'),
            (\'Cuba Peso\',\'CUP\',\'?\'),
            (\'Czech Republic Koruna\',\'CZK\',\'K?\'),
            (\'Denmark Krone\',\'DKK\',\'kr\'),
            (\'Dominican Republic Peso\',\'DOP\',\'RD$\'),
            (\'East Caribbean Dollar\',\'XCD\',\'$\'),
            (\'Egypt Pound\',\'EGP\',\'£\'),
            (\'El Salvador Colon\',\'SVC\',\'$\'),
            (\'Euro Member Countries\',\'EUR\',\'€\'),
            (\'Falkland Islands (Malvinas) Pound\',\'FKP\',\'£\'),
            (\'Fiji Dollar\',\'FJD\',\'$\'),
            (\'Ghana Cedi\',\'GHS\',\'¢\'),
            (\'Gibraltar Pound\',\'GIP\',\'£\'),
            (\'Guatemala Quetzal\',\'GTQ\',\'Q\'),
            (\'Guernsey Pound\',\'GGP\',\'£\'),
            (\'Guyana Dollar\',\'GYD\',\'$\'),
            (\'Honduras Lempira\',\'HNL\',\'L\'),
            (\'Hong Kong Dollar\',\'HKD\',\'$\'),
            (\'Hungary Forint\',\'HUF\',\'Ft\'),
            (\'Iceland Krona\',\'ISK\',\'kr\'),
            (\'India Rupee\',\'INR\',\'?\'),
            (\'Indonesia Rupiah\',\'IDR\',\'Rp\'),
            (\'Iran Rial\',\'IRR\',\'?\'),
            (\'Isle of Man Pound\',\'IMP\',\'£\'),
            (\'Israel Shekel\',\'ILS\',\'?\'),
            (\'Jamaica Dollar\',\'JMD\',\'J$\'),
            (\'Japan Yen\',\'JPY\',\'¥\'),
            (\'Jersey Pound\',\'JEP\',\'£\'),
            (\'Kazakhstan Tenge\',\'KZT\',\'??\'),
            (\'Korea (North) Won\',\'KPW\',\'?\'),
            (\'Korea (South) Won\',\'KRW\',\'?\'),
            (\'Kyrgyzstan Som\',\'KGS\',\'??\'),
            (\'Laos Kip\',\'LAK\',\'?\'),
            (\'Lebanon Pound\',\'LBP\',\'£\'),
            (\'Liberia Dollar\',\'LRD\',\'$\'),
            (\'Macedonia Denar\',\'MKD\',\'???\'),
            (\'Malaysia Ringgit\',\'MYR\',\'RM\'),
            (\'Mauritius Rupee\',\'MUR\',\'?\'),
            (\'Mexico Peso\',\'MXN\',\'$\'),
            (\'Mongolia Tughrik\',\'MNT\',\'?\'),
            (\'Mozambique Metical\',\'MZN\',\'MT\'),
            (\'Namibia Dollar\',\'NAD\',\'$\'),
            (\'Nepal Rupee\',\'NPR\',\'?\'),
            (\'Netherlands Antilles Guilder\',\'ANG\',\'ƒ\'),
            (\'New Zealand Dollar\',\'NZD\',\'$\'),
            (\'Nicaragua Cordoba\',\'NIO\',\'C$\'),
            (\'Nigeria Naira\',\'NGN\',\'?\'),
            (\'Norway Krone\',\'NOK\',\'kr\'),
            (\'Oman Rial\',\'OMR\',\'?\'),
            (\'Pakistan Rupee\',\'PKR\',\'?\'),
            (\'Panama Balboa\',\'PAB\',\'B/.\'),
            (\'Paraguay Guarani\',\'PYG\',\'Gs\'),
            (\'Peru Sol\',\'PEN\',\'S/.\'),
            (\'Philippines Peso\',\'PHP\',\'?\'),
            (\'Poland Zloty\',\'PLN\',\'z?\'),
            (\'Qatar Riyal\',\'QAR\',\'?\'),
            (\'Romania Leu\',\'RON\',\'lei\'),
            (\'Russia Ruble\',\'RUB\',\'?\'),
            (\'Saint Helena Pound\',\'SHP\',\'£\'),
            (\'Saudi Arabia Riyal\',\'SAR\',\'?\'),
            (\'Serbia Dinar\',\'RSD\',\'???.\'),
            (\'Seychelles Rupee\',\'SCR\',\'?\'),
            (\'Singapore Dollar\',\'SGD\',\'$\'),
            (\'Solomon Islands Dollar\',\'SBD\',\'$\'),
            (\'Somalia Shilling\',\'SOS\',\'S\'),
            (\'South Africa Rand\',\'ZAR\',\'R\'),
            (\'Sri Lanka Rupee\',\'LKR\',\'?\'),
            (\'Sweden Krona\',\'SEK\',\'kr\'),
            (\'Switzerland Franc\',\'CHF\',\'CHF\'),
            (\'Suriname Dollar\',\'SRD\',\'$\'),
            (\'Syria Pound\',\'SYP\',\'£\'),
            (\'Taiwan New Dollar\',\'TWD\',\'NT$\'),
            (\'Thailand Baht\',\'THB\',\'?\'),
            (\'Trinidad and Tobago Dollar\',\'TTD\',\'TT$\'),
            (\'Turkey Lira\',\'TRY\',\'?\'),
            (\'Tuvalu Dollar\',\'TVD\',\'$\'),
            (\'Ukraine Hryvnia\',\'UAH\',\'?\'),
            (\'UAE-Dirham\',\'AED\',\'?.?\'),
            (\'United Kingdom Pound\',\'GBP\',\'£\'),
            (\'United States Dollar\',\'USD\',\'$\'),
            (\'Uruguay Peso\',\'UYU\',\'$U\'),
            (\'Uzbekistan Som\',\'UZS\',\'??\'),
            (\'Venezuela Bolívar\',\'VEF\',\'Bs\'),
            (\'Viet Nam Dong\',\'VND\',\'?\'),
            (\'Yemen Rial\',\'YER\',\'?\'),
            (\'Zimbabwe Dollar\',\'ZWD\',\'Z$\')
        ';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('memberships') . '` (
            `id_membership` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_level_id` INT(20) NOT NULL,
            `id_currency` INT(20) NOT NULL,
            `frequency` ENUM (\'daily\', \'weekly\', \'monthly\', \'yearly\'),
            `base_price` DECIMAL DEFAULT 0,
            `description` VARCHAR (512),
            `storage_quota_included` INT DEFAULT 0,
            `storage_price_per_go` DECIMAL DEFAULT 0,
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
        self::alterTable('ALTER TABLE `' . tbl('memberships') . '` ADD CONSTRAINT `user_level_currency` FOREIGN KEY (`id_currency`) REFERENCES `' . tbl('currency') . '` (`id_currency`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'memberships'
        ], [
            'table'           => 'memberships',
            'constraint_name' => 'user_level_currency'
        ]);


        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('user_memberships_status') . '` (
            `id_user_memberships_status` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `language_key_title` VARCHAR(256)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'INSERT INTO `' . tbl('user_memberships_status') . '` (`language_key_title`) 
        SELECT * FROM ( VALUES ROW(\'in_progress\'), ROW(\'completed\'), ROW(\'canceled\'), ROW(\'refunded\')) source_data
        WHERE NOT EXISTS (SELECT * FROM `' . tbl('user_memberships_status') . '`)';
        self::query($sql);

        $sql = 'DROP TABLE IF EXISTS `' . tbl('user_memberships') . '`';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('user_memberships') . '` (
            `id_user_membership` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `userid` BIGINT NOT NULL,
            `id_membership` INT NOT NULL,
            `id_user_memberships_status` INT NOT NULL,
            `date_start` datetime NOT NULL,
            `date_end` datetime NULL,
            `price` DECIMAL NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `' . tbl('user_memberships') . '` ADD CONSTRAINT `user_membership_user` FOREIGN KEY (`userid`) REFERENCES `' . tbl('users') . '` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
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

        self::alterTable('ALTER TABLE `' . tbl('user_memberships') . '` ADD CONSTRAINT `user_membership_membership_status` FOREIGN KEY (`id_user_memberships_status`) REFERENCES `' . tbl('user_memberships_status') . '` (`id_user_memberships_status`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'user_memberships'
        ], [
            'table'           => 'user_memberships',
            'constraint_name' => 'user_membership_membership_status'
        ]);

        self::generateConfig('enable_membership', 'no');
        self::generateTranslation('enable_membership', [
            'fr' => 'Activer les abonnements',
            'en' => 'Enable membership'
        ]);

        self::generateTranslation('memberships', [
            'fr' => 'Abonnements',
            'en' => 'Membership'
        ]);

        self::generateTranslation('storage_price', [
            'fr' => 'Prix de stockage',
            'en' => 'Storage price'
        ]);

        self::generateTranslation('storage_quota', [
            'fr' => 'Quota de stockage',
            'en' => 'Storage quota'
        ]);
        self::generateTranslation('storage_quota_included', [
            'fr' => 'Quota de stockage inclus',
            'en' => 'Storage quota included'
        ]);
        self::generateTranslation('base_price', [
            'fr' => 'Prix initial',
            'en' => 'Base price'
        ]);

        self::generateTranslation('frequency', [
            'fr' => 'Fréquence',
            'en' => 'Frequency'
        ]);

        self::generateTranslation('frequency_daily', [
            'fr' => 'Journalier',
            'en' => 'Daily'
        ]);

        self::generateTranslation('frequency_weekly', [
            'fr' => 'Hebdomadaire',
            'en' => 'Weekly'
        ]);

        self::generateTranslation('frequency_monthly', [
            'fr' => 'Mensuel',
            'en' => 'Monthly'
        ]);

        self::generateTranslation('frequency_yearly', [
            'fr' => 'Annuel',
            'en' => 'Yearly'
        ]);

        self::generateTranslation('editing', [
            'fr' => 'Edition',
            'en' => 'Editing'
        ]);

        self::generateTranslation('add_membership', [
            'fr' => 'Ajouter un niveau d\'abonnement',
            'en' => 'Add membership level'
        ]);
        self::generateTranslation('edit_membership', [
            'fr' => 'Editer un niveau d\'abonnement',
            'en' => 'Edit membership level'
        ]);

        self::generateTranslation('membership_deleted', [
            'fr' => 'L\'abonnement a été supprimé',
            'en' => 'Membership has been deleted'
        ]);

        self::generateTranslation('cant_delete_membership_at_least_one_user', [
            'fr' => 'Impossible de supprimer l\'abonnement car au moins un utilisateur y est attaché',
            'en' => 'Cannot delete this membership, at least one user subscribe to it'
        ]);

        self::generateTranslation('creation', [
            'fr' => 'Création',
            'en' => 'Creation'
        ]);

        self::generateTranslation('must_activate_storage_history', [
            'fr' => 'Vous devez activer l\'option "Activer l\'historique de stockage" pour éditer ce champs',
            'en' => 'You must activate option "Activate storage history" to edit this field'
        ]);

        self::generateTranslation('subscribers', [
            'fr' => 'Abonnés',
            'en' => 'Subscribers'
        ]);

        self::generateTranslation('first_start', [
            'fr' => 'Date de début du premier abonnement',
            'en' => 'First membership start date'
        ]);
        self::generateTranslation('last_end', [
            'fr' => 'Date de fin du dernier abonnement',
            'en' => 'Last membership end date'
        ]);
        self::generateTranslation('nb_membership', [
            'fr' => 'Nombre d\'abonnement',
            'en' => 'Total memberships'
        ]);
        self::generateTranslation('sum_price', [
            'fr' => 'Somme des abonnements',
            'en' => 'Memberships sum'
        ]);

        self::generateTranslation('max_period_storage', [
            'fr' => 'Stockage maximum utilisé durant la période',
            'en' => 'Maximum storage during period'
        ]);

        self::generateTranslation('date_start', [
            'fr' => 'Date de début',
            'en' => 'Date start'
        ]);

        self::generateTranslation('date_end', [
            'fr' => 'Date de fin',
            'en' => 'Date end'
        ]);

        self::generateTranslation('price', [
            'fr' => 'Prix',
            'en' => 'Price'
        ]);

        self::generateTranslation('gb', [
            'fr' => 'Go',
            'en' => 'GB'
        ]);

        self::generateTranslation('per_gb', [
            'fr' => 'par Go',
            'en' => 'per GB'
        ]);

        self::generateTranslation('user_level_successfully_saved', [
            'fr' => 'Le niveau d\'utilisateur a été correctement enregistré',
            'en' => 'User level has been successfully saved'
        ]);

        self::generateTranslation('confirm_delete_user_level', [
            'fr' => 'Voulez-vous vraiment supprimer ce niveau d\'utilisateur ?',
            'en' => 'Are you sure you want to delete this user level ?'
        ]);

        self::generateTranslation('currency', [
            'fr' => 'Monnaie',
            'en' => 'Currency'
        ]);

        self::generateTranslation('missing_currency', [
            'fr' => 'Veuillez sélectionner une monnaie',
            'en' => 'Please select a currency'
        ]);

        self::generateTranslation('free', [
            'fr' => 'Gratuit',
            'en' => 'Free'
        ]);

        self::generateTranslation('none', [
            'fr' => 'Aucun',
            'en' => 'None'
        ]);

        self::generateTranslation('user_level_frequency_already_exist', [
            'fr'=>'La combinaison %s / %s existe déjà',
            'en'=>'Combinaison %s / %s already exist'
        ]);

        self::generateTranslation('current_membership', [
            'fr'=>'Abonnement actuel',
            'en'=>'Current membership'
        ]);

        self::generateTranslation('membership_history', [
            'fr'=>'Historique des abonnements',
            'en'=>'Membership history'
        ]);

        self::generateTranslation('never', [
            'fr'=>'Jamais',
            'en'=>'Never'
        ]);

        self::updateTranslation('com_manage_subs', [
            'fr'=>'Gestion des abonnements de chaine',
            'en'=>'Manage channels subscriptions'
        ]);

        self::generateTranslation('status', [
            'fr'=>'Statut',
            'en'=>'Status'
        ]);
    }
}
