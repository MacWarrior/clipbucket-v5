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

        $sql_age_restrict = '';
        if( config('enable_age_restriction') == 'yes' && config('enable_blur_restricted_content') != 'yes' ){
            $cond .= ' AND playlists.age_restriction IS NULL';
            $dob = user_dob();
            $sql_age_restrict = ' AND (playlists.age_restriction IS NULL OR TIMESTAMPDIFF(YEAR, \'' . mysql_clean($dob) . '\', NOW()) >= playlists.age_restriction )';
        }

        $current_user_id = user_id();
        if ($current_user_id) {
            $cond .= ' OR playlists.userid = ' . $current_user_id . ')';
            $cond .= ' OR (playlists.privacy = \'public\'' . $sql_age_restrict . ')';
        } else {
            $cond .= ')';
        }
        return $cond;
    }

}