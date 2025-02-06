<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00260 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('user_permission_types') . ' CHANGE user_permission_type_desc user_permission_type_code varchar(225)',
            [
                'table'  => 'user_permission_types',
                'column' => 'user_permission_type_desc'
            ], [
                'table'  => 'user_permission_types',
                'column' => 'user_permission_type_code'
            ]);

        self::query('UPDATE `{tbl_prefix}user_permission_types` SET user_permission_type_name = \'viewing_permission\', user_permission_type_code = \'VIEW\' WHERE user_permission_type_name LIKE \'Viewing Permission\'');
        self::query('UPDATE `{tbl_prefix}user_permission_types` SET user_permission_type_name = \'uploading_permission\', user_permission_type_code = \'UPLOAD\' WHERE user_permission_type_name LIKE \'Uploading Permission\'');
        self::query('UPDATE `{tbl_prefix}user_permission_types` SET user_permission_type_name = \'administration_permission\', user_permission_type_code = \'ADMIN\' WHERE user_permission_type_name LIKE \'Administrator Permission\'');
        self::query('UPDATE `{tbl_prefix}user_permission_types` SET user_permission_type_name = \'general_permission\', user_permission_type_code = \'GENERAL\' WHERE user_permission_type_name LIKE \'General Permission\'');

        self::alterTable('ALTER TABLE ' . tbl('user_permission_types') . ' MODIFY COLUMN user_permission_type_code varchar(7) NOT NULL', [
            'table'  => 'user_permission_types',
            'column' => 'user_permission_type_code'
        ]);

        self::generateTranslation('viewing_permission', [
            'fr' => 'Permissions de visionnage',
            'en' => 'Viewing permissions'
        ]);

        self::generateTranslation('uploading_permission', [
            'fr' => 'Permissions de téléchargement',
            'en' => 'Uploading permissions'
        ]);

        self::generateTranslation('administration_permission', [
            'fr' => 'Permissions d\'administration',
            'en' => 'Administration permissions'
        ]);

        self::generateTranslation('general_permission', [
            'fr' => 'Permissions générales',
            'en' => 'General permissions'
        ]);
    }
}
