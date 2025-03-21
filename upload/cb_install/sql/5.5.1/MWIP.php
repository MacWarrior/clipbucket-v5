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
        self::generateTranslation('default_sort', [
            'fr'=>'Tri par défaut',
            'en'=>'Default sort'
        ]);

        //add cloumn
        self::query('CREATE TABLE IF NOT EXISTS `'.tbl('sorts').'` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `label` varchar(255) NOT NULL,
            `type` varchar(255) NOT NULL,
            `is_default` BOOLEAN NOT NULL DEFAULT FALSE,
            UNIQUE KEY `uk_label_type` (`label`, `type`),
            INDEX (`type`)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;      
        ');

        self::query('INSERT IGNORE INTO ' . tbl('sorts') .' ( `label`, `type`, is_default) VALUES 
            (\'most_old\', \'videos\', false),
            (\'most_recent\', \'videos\', true),
            (\'most_viewed\', \'videos\', false),
            (\'top_rated\', \'videos\', false),
            (\'longer\', \'videos\', false),
            (\'shorter\', \'videos\', false),
            (\'viewed_recently\', \'videos\', false),
            (\'most_commented\', \'videos\', false),
            (\'featured\', \'videos\', false),
            (\'most_recent\', \'photos\', true),
            (\'most_old\', \'photos\', false),
            (\'most_viewed\', \'photos\', false),
            (\'top_rated\', \'photos\', false),
            (\'most_commented\', \'photos\', false),
            (\'viewed_recently\', \'photos\', false),
            (\'featured\', \'photos\', false),
            (\'most_recent\', \'collections\', true),
            (\'most_old\', \'collections\', false),
            (\'most_items\', \'collections\', false),
            (\'most_commented\', \'collections\', false),
            (\'top_rated\', \'collections\', false),
            (\'featured\', \'collections\', false),
            (\'most_recent\', \'channels\', true),
            (\'most_old\', \'channels\', false),
            (\'most_viewed\', \'photos\', false),
            (\'top_rated\', \'channels\', false),
            (\'featured\', \'channels\', false),
            (\'most_items\', \'channels\', false),
            (\'most_commented\', \'channels\', false);
        ');

        //order include in label
        self::alterTable('ALTER TABLE ' . tbl(\Collection::getInstance()->getTableName()) . ' ADD COLUMN sort_type INT NULL;', [
            'table' => \Collection::getInstance()->getTableName()
        ],[
            'table' => \Collection::getInstance()->getTableName(),
            'column' => 'sort_type'
        ]);

        self::alterTable('ALTER TABLE ' . tbl(\Collection::getInstance()->getTableName()) . ' ADD CONSTRAINT `sort_type_ibfk_1` FOREIGN KEY (`sort_type`) REFERENCES '.tbl('sorts').' (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'sorts',
            'column' => 'label'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'sort_type_ibfk_1'
            ]
        ]);

        self::query('UPDATE ' . tbl(\Collection::getInstance()->getTableName()) . ' AS C SET `sort_type` = (SELECT `id` FROM '.tbl('sorts').' AS S  WHERE S.type=C.type AND S.label = \'most_old\')');

        self::updateTranslationKey('most_old', 'sort_by_most_old');
        self::updateTranslationKey('most_recent', 'sort_by_most_recent');
        self::updateTranslationKey('most_viewed', 'sort_by_most_viewed');
        self::updateTranslationKey('top_rated', 'sort_by_top_rated');
        self::updateTranslationKey('longer_video', 'sort_by_longer');
        self::updateTranslationKey('shorter_video', 'sort_by_shorter');
        self::updateTranslationKey('viewed_recently', 'sort_by_viewed_recently');
        self::updateTranslationKey('most_commented', 'sort_by_most_commented');
        self::updateTranslationKey('sort_most_items', 'sort_by_most_items');

        self::generateTranslation('sort_by_most_viewed', ['fr'=>'Plus visionnés']);
        self::generateTranslation('sort_by_most_items', ['fr'=>'Le plus d\'éléments']);
        self::generateTranslation('sort_by_most_old', [
            'fr'=>'Plus Ancien',
            'en'=>'Most Old'
        ]);
        self::generateTranslation('sort_by_featured', [
            'fr'=>'Vedette',
            'en'=>'Featured'
        ]);
        self::generateTranslation('sort_by_most_commented', ['fr'=>'Plus commentés']);

    }
}
