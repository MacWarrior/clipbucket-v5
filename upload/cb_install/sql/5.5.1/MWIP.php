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
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_users` (
            videoid BIGINT(20) NOT NULL,
            userid BIGINT(20) NOT NULL,
            PRIMARY KEY (videoid, userid)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_users` ADD CONSTRAINT `video_users_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'video_users',
            'column' => 'videoid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_users_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_users` ADD CONSTRAINT `video_users_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'video_users',
            'column' => 'userid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_users_ibfk_2'
            ]
        ]);


        $limit = 0;
        do {
            $results = \Video::getInstance()->getAll(['limit' => $limit . ', 100']);
            foreach ($results as $result) {
                $user_ids = video_users($result['video_users']);
                foreach ($user_ids as $user_id) {
                    \Clipbucket_db::getInstance()->insert(tbl('video_users'), [
                        'videoid',
                        'userid'
                    ], [
                        $result['videoid'],
                        $user_id
                    ]);
                }
            }
            $limit += 100;
        } while (!empty($results));

        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `video_users`', [
            'table'  => 'video',
            'column' => 'video_users',
        ]);
    }
}
