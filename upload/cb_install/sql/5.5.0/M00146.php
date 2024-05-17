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
        $datas = [
            'collections' => ['userid_2', 'featured_2'],
            'conversion_queue' => ['cqueue_conversion_2'],
            'favorites' => ['userid_2'],
            'languages' => ['language_default_2', 'language_code_2'],
            'pages' => ['active_2'],
            'photos' => ['last_viewed_2', 'userid_2', 'collection_id_2', 'featured_2', 'last_viewed_3', 'rating_2', 'total_comments_2', 'total_comments_2'],
            'sessions' => ['session_2'],
            'users' => ['username_2'],
            'user_levels_permissions' => ['user_level_id_2'],
            'video' => ['last_viewed_2', 'userid_2', 'userid_3', 'featured_2', 'last_viewed_3', 'rating_2', 'comments_count_2', 'last_viewed_4', 'status_2', 'userid_4', 'videoid_2']
        ];

        foreach($datas as $table => $indexs){
            foreach($indexs as $index){
                self::alterTable('ALTER TABLE `{tbl_prefix}' . $table . '` DROP INDEX `' . $index . '`', [
                    'table'  => $table,
                    'column' => $index
                ]);
            }
        }
    }
}