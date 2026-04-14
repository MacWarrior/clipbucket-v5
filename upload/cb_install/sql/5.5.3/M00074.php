<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00074 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('own_comment_rating', 'no');

        self::generateTranslation('option_enable_own_comment_rating', [
            'fr' => 'Voter pour ses propres commentaires',
            'en' => 'Rate own comments'
        ]);
        self::generateTranslation('comment_rate_disabled', [
            'fr'=>'Le vote des commentaires est désactivé',
            'en'=>'Comment rating is disabled'
        ]);
        self::generateTranslation('you_cant_rate_own_comment', [
            'fr'=>'Vous ne pouvez voter pour vos propres commentaires',
            'en'=>'You cannot rate your own comment'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}comments` DROP COLUMN `vote`;', [
            'table'  => 'comments',
            'column' => 'vote'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` ADD COLUMN `rating` INT NOT NULL DEFAULT 0;', [],[
            'table'  => 'comments',
            'column' => 'rating'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` ADD COLUMN `rated_by` INT NOT NULL DEFAULT 0;', [], [
            'table'  => 'comments',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` ADD COLUMN voters TEXT ', [], [
            'table'  => 'comments',
            'column' => 'voters'
        ]);

    }
}
