<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00146 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('view_comment', [
           'fr'=>'Voir les commentaires',
           'en'=>'View comments'
       ]);
       self::generateTranslation('view_all_comments', [
           'fr'=>'Voir tous les commentaires',
           'en'=>'View all comments'
       ]);
       self::generateTranslation('view_video_comments', [
           'fr'=>'Voir les commentaires des vidéos',
           'en'=>'View video comments'
       ]);
       self::generateTranslation('view_collection_comments', [
           'fr'=>'Voir les commentaires des collections',
           'en'=>'View collection comments'
       ]);
       self::generateTranslation('view_photo_comments', [
           'fr'=>'Voir les commentaires des photos',
           'en'=>'View photo comments'
       ]);
       self::generateTranslation('confirm_delete_comment', [
           'fr'=>'Voulez-vous vraiment supprimer le(s) commentaire(s) sélectionné(s) ?',
           'en'=>'Do you really want to delete selected comment(s) ?'
       ]);
       self::generateTranslation('comment_id', [
           'fr'=>'ID du commentaire',
           'en'=>'Comment ID'
       ]);
    }
}
