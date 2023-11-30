<?php
class Playlist
{
    private static $playlist;
    private $tablename = '';
    public function getTablename(): string
    {
        return $this->tablename;
    }
    public function __construct()
    {
        $this->tablename = 'playlists';
    }

    public static function getInstance(): self
    {
        if( empty(self::$playlist) ){
            self::$playlist = new self();
        }
        return self::$playlist;
    }

    /**
     * @throws Exception
     */
    public static function getGenericConstraints(): string
    {
        if (has_access('admin_access', true)) {
            return '';
        }

        $cond = '(playlists.privacy = \'public\'';

        $current_user_id = user_id();
        if ($current_user_id) {
            $cond .= ' OR playlists.userid = ' . $current_user_id . ')';
            $cond .= ' OR (playlists.privacy = \'public\')';
        } else {
            $cond .= ')';
        }
        return $cond;
    }

}