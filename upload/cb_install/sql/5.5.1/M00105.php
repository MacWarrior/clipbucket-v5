<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00105 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('upload_poster', [
            'fr'=>'Téléverser une affiche',
            'en'=>'Upload a poster'
        ]);
        self::generateTranslation('upload_backdrop', [
            'fr'=>'Téléverser un décor',
            'en'=>'Upload a backdrop'
        ]);
        self::generateTranslation('poster_list', [
            'fr'=>'Liste des affiches',
            'en'=>'Poster list'
        ]);
        self::generateTranslation('backdrop_list', [
            'fr'=>'Liste des décors',
            'en'=>'Backdrop list'
        ]);
        self::generateTranslation('posters', [
            'fr'=>'affiches',
            'en'=>'posters'
        ]);
        self::generateTranslation('backdrops', [
            'fr'=>'décors',
            'en'=>'backdrops'
        ]);
        self::generateTranslation('thumbs_upload_successfully', [
            'fr'=>'La vignette a été téléversée avec succès',
            'en'=>'Thumb uploaded successfully'
        ]);
        self::generateTranslation('poster_upload_successfully', [
            'fr'=>'L\'affiche a été téléversée avec succès',
            'en'=>'Poster uploaded successfully'
        ]);
        self::generateTranslation('backdrop_upload_successfully', [
            'fr'=>'Le décor a été téléversé avec succès',
            'en'=>'Backdrop uploaded successfully'
        ]);
        self::generateTranslation('thumbs_delete_successfully', [
            'fr'=>'La vignette a été supprimée avec succès',
            'en'=>'Thumb deleted successfully'
        ]);
        self::generateTranslation('poster_delete_successfully', [
            'fr'=>'L\'affiche a été supprimée avec succès',
            'en'=>'Poster deleted successfully'
        ]);
        self::generateTranslation('backdrop_delete_successfully', [
            'fr'=>'Le décor a été supprimé avec succès',
            'en'=>'Backdrop deleted successfully'
        ]);
        self::generateTranslation('manage_x', [
            'fr'=>'Gestion des %s',
            'en'=>'Manage %s'
        ]);
    }
}