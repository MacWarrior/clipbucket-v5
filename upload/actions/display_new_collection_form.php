<?php
define('THIS_PAGE', 'info_tmdb');
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR .'includes'.DIRECTORY_SEPARATOR.'config.inc.php';

global $cbcollection;

assign('reqFields', $cbcollection->load_required_fields(['type'=>'photos']));
echo templateWithMsgJson('blocks/new_collection_form.html');
