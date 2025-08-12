<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_video_embed_players', 'yes');

        self::generateTranslation('option_enable_video_embed_players', [
            'fr' => 'Activer les lecteurs intégrés',
            'en' => 'Enable embed players'
        ]);

        self::generateTranslation('video_embed_players', [
            'fr' => 'Lecteurs intégrés',
            'en' => 'Embed players'
        ]);

        self::generateTranslation('html', [
            'fr' => 'HTML',
            'en' => 'HTML'
        ]);

        self::generateTranslation('confirm_delete_embed_player', [
            'fr' => 'Êtes-vous sûr de vouloir supprimer ce lecteur intégré ?',
            'en' => 'Are you sure you want to delete this embed player ?'
        ]);

        self::generateTranslation('no_embed_player_to_display', [
            'fr' => 'Aucun lecteur intégré à afficher',
            'en' => 'No embed player to display'
        ]);

        self::generateTranslation('add_new_embed_player', [
            'fr' => 'Ajouter un nouveau lecteur intégré',
            'en' => 'Add new embed player'
        ]);

        self::generateTranslation('html_code_is_invalid', [
            'fr' => 'Le code HTML est incorrect',
            'en' => 'HTML code is invalid'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_embed` (
                    `id_video_embed` int(11) NOT NULL,
                    `videoid` bigint(20) NOT NULL,
                    `id_fontawesome_icon` int(11) DEFAULT NULL,
                    `title` varchar(64) NOT NULL,
                    `html` text NOT NULL,
                    `order` smallint(6) NOT NULL DEFAULT 0,
                    `enabled` tinyint(1) NOT NULL DEFAULT 1
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_embed` ADD PRIMARY KEY (`id_video_embed`), ADD KEY `videoid` (`videoid`), ADD KEY `id_fontawesome_icon` (`id_fontawesome_icon`)', [
            'table'   => 'video_embed',
            'columns' => [
                'id_video_embed'
                ,'videoid'
                ,'id_fontawesome_icon'
            ]
        ], [
            'constraint' => [
                'type'  => 'PRIMARY KEY',
                'table' => 'video_embed'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_embed` MODIFY `id_video_embed` int(11) NOT NULL AUTO_INCREMENT', [
            'table'  => 'video_embed',
            'column' => 'id_video_embed'
        ]);

        $sql_alter = 'ALTER TABLE `{tbl_prefix}video_embed` ADD CONSTRAINT `video_embed_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`)';
        self::alterTable($sql_alter, [
            'table'  => 'video_embed',
            'column' => 'videoid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_embed_ibfk_1'
            ]
        ]);

        $sql_alter = 'ALTER TABLE `{tbl_prefix}video_embed` ADD CONSTRAINT `video_embed_ibfk_2` FOREIGN KEY (`id_fontawesome_icon`) REFERENCES `{tbl_prefix}fontawesome_icons` (`id_fontawesome_icon`)';
        self::alterTable($sql_alter, [
            'table'  => 'video_embed',
            'column' => 'id_fontawesome_icon'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_embed_ibfk_2'
            ]
        ]);
    }

}
