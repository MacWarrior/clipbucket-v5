<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('tools_seems_stuck_since_mark_as_failed', [
            'fr'=>'L\'outil semble coincé depuis %s, marquer comme échoué ?',
            'en'=>'The tool seems stuck since %s, mark as failed ?'
        ]);

        self::generateTranslation('confirm_mark_as_failed', [
            'fr'=>'Voulez-vous vraiment marquer cet outil comme échoué ?',
            'en'=>'Do you really want to mark this tool as failed ?'
        ]);
    }

}
