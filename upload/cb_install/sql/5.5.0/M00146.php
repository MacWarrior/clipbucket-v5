<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00146 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP INDEX `userid_2`', [
            'table' => 'collections',
            'column'     => 'userid_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP INDEX `featured_2`', [
            'table' => 'collections',
            'column'     => 'featured_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}conversion_queue` DROP INDEX `cqueue_conversion_2`;', [
            'table' => 'conversion_queue',
            'column'     => 'cqueue_conversion_2'
        ]);


        self::alterTable('ALTER TABLE `{tbl_prefix}favorites` DROP INDEX `userid_2`;', [
            'table' => 'favorites',
            'column'     => 'userid_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages` DROP INDEX `language_default_2`', [
            'table' => 'languages',
            'column'     => 'language_default_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages` DROP INDEX `language_code_2`', [
            'table' => 'languages',
            'column'     => 'language_code_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}pages` DROP INDEX `active_2`;', [
            'table' => 'pages',
            'column'     => 'active_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `last_viewed_2`;', [
            'table' => 'photos',
            'column'     => 'last_viewed_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `userid_2`;', [
            'table' => 'photos',
            'column'     => 'userid_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `collection_id_2`;', [
            'table' => 'photos',
            'column'     => 'collection_id_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `featured_2`;', [
            'table' => 'photos',
            'column'     => 'featured_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `last_viewed_3`;', [
            'table' => 'photos',
            'column'     => 'last_viewed_3'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `rating_2`;', [
            'table' => 'photos',
            'column'     => 'rating_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `total_comments_2`;', [
            'table' => 'photos',
            'column'     => 'total_comments_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP INDEX `total_comments_2`;', [
            'table' => 'photos',
            'column'     => 'total_comments_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}sessions` DROP INDEX `session_2`;', [
            'table' => 'sessions',
            'column'     => 'session_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` DROP INDEX `username_2`;', [
            'table' => 'users',
            'column'     => 'username_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels_permissions` DROP INDEX `user_level_id_2`;', [
            'table' => 'user_levels_permissions',
            'column'     => 'user_level_id_2'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `last_viewed_2`',[
            'table' => 'video',
            'column'     => 'last_viewed_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `userid_2`',[
            'table' => 'video',
            'column'     => 'userid_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `userid_3`',[
            'table' => 'video',
            'column'     => 'userid_3'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `featured_2`',[
            'table' => 'video',
            'column'     => 'featured_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `last_viewed_3`',[
            'table' => 'video',
            'column'     => 'last_viewed_3'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `rating_2`',[
            'table' => 'video',
            'column'     => 'rating_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `comments_count_2`',[
            'table' => 'video',
            'column'     => 'comments_count_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `last_viewed_4`',[
            'table' => 'video',
            'column'     => 'last_viewed_4'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `status_2`',[
            'table' => 'video',
            'column'     => 'status_2'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `userid_4`',[
            'table' => 'video',
            'column'     => 'userid_4'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `videoid_2`',[
            'table' => 'video',
            'column'     => 'videoid_2'
        ]);
    }
}