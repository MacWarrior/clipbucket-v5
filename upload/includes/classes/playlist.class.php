<?php

/**
 * This class is used to manage Playlist
 * and Quicklist for ClipBucket
 *
 * @Author : Arslan hassan (te haur kaun o sukda :p)
 * @License: CBLA
 * @Since : Bakra Eid 2009
 */


class Playlist
{
    /**
     * Database Tables
     */
    /**
     * @param bool $param_first_only
     * @return string
     */
    public static function getGenericConstraints(): string
    {
        $dob = user_dob();
        $sql_age_restrict = '(playlists.age_restriction IS NULL OR TIMESTAMPDIFF(YEAR, \'' . mysql_clean($dob) . '\', NOW()) >= playlists.age_restriction )';
        $cond = '( (playlists.privacy = \'public\' AND playlists.age_restriction IS NULL ';


        $current_user_id = user_id();
        if ($current_user_id) {
            $cond .= ' OR playlists.userid = ' . $current_user_id . ')';
            $cond .= ' OR (playlists.privacy = \'public\' AND '.$sql_age_restrict.')';
        } else {
            $cond .= ')';
        }
        $cond .= ')';
        return $cond;
    }

}