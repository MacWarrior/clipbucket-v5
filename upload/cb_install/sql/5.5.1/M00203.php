<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00203 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT INTO `{tbl_prefix}user_profile` (`userid`, `profile_title`, `profile_desc`, `featured_video`, `about_me`, `schools`, `occupation`, `companies`, `hobbies`, `fav_movies`, `fav_music`, `fav_books`, `background`, `voters`) 
                    SELECT DISTINCT `{tbl_prefix}users`.`userid`, \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'
                    FROM `{tbl_prefix}users` 
                    LEFT JOIN `{tbl_prefix}user_profile` ON `{tbl_prefix}users`.`userid` = `{tbl_prefix}user_profile`.`userid` 
                    WHERE `{tbl_prefix}user_profile`.`user_profile_id` IS NULL AND `{tbl_prefix}users`.`userid` != 0';
        self::query($sql);
    }
}