<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00118 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `rated_by`;', [
            'table'  => 'video',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `voter_ids`;', [
            'table'  => 'video',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `rating`;', [
            'table'  => 'video',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `rated_by`;', [
            'table'  => 'user_profile',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `voters`;', [
            'table'  => 'user_profile',
            'column' => 'voters'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `rating`;', [
            'table'  => 'user_profile',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `rated_by`;', [
            'table'  => 'collections',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `voters`;', [
            'table'  => 'collections',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `rating`;', [
            'table'  => 'collections',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `rated_by`;', [
            'table'  => 'photos',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `voters`;', [
            'table'  => 'photos',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `rating`;', [
            'table'  => 'photos',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` DROP COLUMN `voted`;', [
            'table'  => 'users',
            'column' => 'voted'
        ]);
    }
}
