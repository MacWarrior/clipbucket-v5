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
        self::alterTable('ALTER TABLE ' . tbl('collections') . ' DROP COLUMN `views`',
            [
                'table'  => 'collections',
                'column' => 'views'
            ]
        );
        self::alterTable('ALTER TABLE ' . tbl('collections') . ' ADD COLUMN `thumb_objectid` BIGINT(20) NULL DEFAULT NULL',
            [
                'table'  => 'collections',
            ], [
                'table'  => 'collections',
                'column' => 'thumb_objectid'
            ]
        );

        $collections = \Collection::getInstance()->getAll(['allow_children'=>true]);
        foreach ($collections as $collection) {
            \Collection::assignDefaultThumb($collection['collection_id']);
        }

        self::insertTool('assign_default_thumb', 'AdminTool::assignDefaultThumbForCollections');
        self::generateTranslation('assign_default_thumb_label', [
            'fr'=>'Assigner la vignette par défaut des collections',
            'en'=>'Assign default thumb to collection'
        ]);
        self::generateTranslation('assign_default_thumb_description', [
            'fr'=>'Assigne aux collection la vignette par défaut du premier élément de la collection',
            'en'=>'Assign first element as default thumb for collections'
        ]);
        self::generateTranslation('default_thumb', [
            'fr'=>'Vignette par défaut',
            'en'=>'Default thumb'
        ]);
    }
}
