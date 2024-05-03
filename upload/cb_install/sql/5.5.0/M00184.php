<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00184 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('open_debug', [
            'en' => 'SQL requests',
            'fr' => 'Requêtes SQL'
        ]);

        self::generateTranslation('select_queries', [
            'en' => 'Select Queries',
            'fr' => 'Requêtes Select'
        ]);

        self::generateTranslation('update_queries', [
            'en' => 'Update Queries',
            'fr' => 'Requêtes Update'
        ]);

        self::generateTranslation('delete_queries', [
            'en' => 'Delete Queries',
            'fr' => 'Requêtes Delete'
        ]);

        self::generateTranslation('insert_queries', [
            'en' => 'Insert Queries',
            'fr' => 'Requêtes Insert'
        ]);

        self::generateTranslation('execute_queries', [
            'en' => 'Execute Query',
            'fr' => 'Requêtes Execute'
        ]);

        self::generateTranslation('expensive_query', [
            'en' => 'Expensive Queries',
            'fr' => 'Requête la plus lourde'
        ]);

        self::generateTranslation('cheapest_query', [
            'en' => 'Cheapest Queries',
            'fr' => 'Requête la plus légère'
        ]);

        self::generateTranslation('overall_stats', [
            'en' => 'Overall Stats',
            'fr' => 'Statistiques Globales'
        ]);

        self::generateTranslation('base_directory', [
            'en' => 'Base directory',
            'fr' => 'Dossier racine'
        ]);

        self::generateTranslation('queries', [
            'en' => 'Queries',
            'fr' => 'Requêtes'
        ]);

        self::generateTranslation('all_queries', [
            'en' => 'All Queries',
            'fr' => 'Toutes les Requêtes'
        ]);

        self::generateTranslation('total_db_queries', [
            'en' => 'Total DB Queries',
            'fr' => 'Nombre total de requêtes SQL'
        ]);

        self::generateTranslation('total_cache_queries', [
            'en' => 'Total cache Queries',
            'fr' => 'Nombre total de requêtes en cache'
        ]);

        self::generateTranslation('total_execution_time', [
            'en' => 'Total Execution Time',
            'fr' => 'Temps total d\'exécution'
        ]);

        self::generateTranslation('total_memory_used', [
            'en' => 'Total Memory Used',
            'fr' => 'Consomation mémoire totale'
        ]);

        self::generateTranslation('memory_usage', [
            'en' => 'Memory Usage',
            'fr' => 'Consomation mémoire'
        ]);

        self::generateTranslation('everything', [
            'en' => 'Everything',
            'fr' => 'Tout'
        ]);

        self::generateTranslation('display', [
            'en' => 'Display',
            'fr' => 'Afficher'
        ]);
    }
}