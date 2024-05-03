<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00301 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('uploaded', [
            'en'    => 'Uploaded',
            'fr'    => 'Téléversés',
            'de'    => 'Hochgeladen',
            'pt-BR' => 'Enviado'
        ]);

        self::generateTranslation('photo_tags', [
            'en'    => 'Photo Tags',
            'fr'    => 'Mots clés photos',
            'de'    => 'Foto-Tags',
            'pt-BR' => 'Tags de Fotos'
        ]);

        self::generateTranslation('collection_is', [
            'en'    => 'Collection is %s',
            'fr'    => 'La collection est %s',
            'de'    => 'Sammlung ist %s',
            'pt-BR' => 'A Coleção é %s'
        ]);

        $sql = 'UPDATE `{tbl_prefix}user_levels_permissions` SET `allow_create_collection` = \'no\' WHERE `user_level_permission_id` = 4;';
        self::query($sql);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'collection_is_private\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
    }
}