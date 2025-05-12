<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00043 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_user_self_deletion','no');

        self::generateTranslation('option_enable_user_self_deletion', [
            'fr'=>'Autoriser les utilisateur à supprimer leur compte',
            'en'=>'Allow users to delete their own account'
        ]);
        self::generateTranslation('drop_my_account', [
            'fr'=>'Supprimer mon compte',
            'en'=>'Drop my account'
        ]);
        self::generateTranslation('account_deletion', [
            'fr'=>'Suppression du compte',
            'en'=>'Account deletion'
        ]);
        self::generateTranslation('account_deletion_confirmation', [
            'fr'=>'Êtes-vous sûr de vouloir supprimer votre compte ?',
            'en'=>'Are you sure you want to delete your account?'
        ]);
        self::generateTranslation('account_deletion_confirmation_info', [
            'fr'=>'Tous vos éléments et votre compte seront supprimés.',
            'en'=>'All your items and your account will be deleted.'
        ]);
        self::generateTranslation('account_deletion_yes', [
            'fr'=>'Oui, supprimer !',
            'en'=>'Yes, drop it!'
        ]);
        self::generateTranslation('account_deleted', [
            'fr'=>'Votre compte a bien été supprimé.',
            'en'=>'Your account has been deleted.'
        ]);
    }
}
