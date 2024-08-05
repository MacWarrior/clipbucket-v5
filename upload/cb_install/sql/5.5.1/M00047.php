<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00047 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_comments_censor', [
            'fr' => 'Activer la censure des commentaires',
            'en' => 'Enable comments censor'
        ]);

        self::generateTranslation('option_comments_censored_words', [
            'fr' => 'Mots censurés',
            'en' => 'Censored words'
        ]);

        self::generateTranslation('separated_by_commas', [
            'fr' => 'Séparé par des virgules',
            'en' => 'Separated by commas'
        ]);

        self::generateConfig('enable_comments_censor', 'no');
        self::generateConfig('comments_censored_words', '');
    }
}