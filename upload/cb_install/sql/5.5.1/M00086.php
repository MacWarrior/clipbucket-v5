<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00086 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        execute_sql_file(\DirPath::get('cb_install') . DIRECTORY_SEPARATOR . 'sql' .DIRECTORY_SEPARATOR . 'add_anonymous_user.sql');

        self::query('UPDATE ' . tbl('user_levels') . ' SET user_level_active = \'no\', user_level_is_default = \'no\' WHERE `user_level_name` LIKE \'anonymous\';' );

        self::query('SET @id_anonymous = (SELECT userid FROM  ' . tbl('users') . ' WHERE `username` LIKE \'anonymous\');');
        self::query('UPDATE ' . tbl('collections') . ' AS C 
                    LEFT JOIN ' . tbl('users') . ' AS U ON C.userid = U.userid
                    SET C.userid = @id_anonymous
                    WHERE U.userid IS NULL' );
        self::query('UPDATE ' . tbl('collection_items') . ' AS C 
                    LEFT JOIN ' . tbl('users') . ' AS U ON C.userid = U.userid
                    SET C.userid = @id_anonymous
                    WHERE U.userid IS NULL' );
        self::query('UPDATE ' . tbl('photos') . ' AS P 
                    LEFT JOIN ' . tbl('users') . ' AS U ON P.userid = U.userid
                    SET P.userid = @id_anonymous
                    WHERE U.userid IS NULL' );
        self::query('UPDATE ' . tbl('playlists') . ' AS P 
                    LEFT JOIN ' . tbl('users') . ' AS U ON P.userid = U.userid
                    SET P.userid = @id_anonymous
                    WHERE U.userid IS NULL' );
        self::query('UPDATE ' . tbl('playlist_items') . ' AS P 
                    LEFT JOIN ' . tbl('users') . ' AS U ON P.userid = U.userid
                    SET P.userid = @id_anonymous
                    WHERE U.userid IS NULL' );

        self::generateTranslation('anonymous_locked', [
            'fr'=>'L\'utilisateur anonyme est verrouillé',
            'en'=>'Anonymous user is locked'
        ]);
        self::generateTranslation('anonymous', [
            'fr'=>'Anonyme',
            'en'=>'Anonymous'
        ]);
        self::generateTranslation('user_doesnt_exist', [
            'fr'=>'L\'utilisateur n\'existe pas',
        ]);
    }
}
