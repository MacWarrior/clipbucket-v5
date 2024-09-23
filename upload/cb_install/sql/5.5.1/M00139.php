<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00139 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN allow_comments', [
                'table'  => 'playlists',
                'column' => 'allow_comments'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN allow_rating', [
                'table'  => 'playlists',
                'column' => 'allow_rating'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN total_comments', [
                'table'  => 'playlists',
                'column' => 'total_comments'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN rating', [
                'table'  => 'playlists',
                'column' => 'rating'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN rated_by', [
                'table'  => 'playlists',
                'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN voters', [
                'table'  => 'playlists',
                'column' => 'voters'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' ADD FULLTEXT KEY `playlist_name` (`playlist_name`)' , [
            'table'  => 'playlists',
            'column' => 'playlist_name'
        ]);

    }
}
