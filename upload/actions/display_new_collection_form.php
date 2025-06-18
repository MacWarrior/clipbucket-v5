<?php
define('THIS_PAGE', 'info_tmdb');
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR .'includes'.DIRECTORY_SEPARATOR.'config.inc.php';

assign('reqFields', Collections::getInstance()->load_required_fields(['type'=>'photos']));
assign('otherFields', Collections::getInstance()->load_other_fields(['type'=>'photos']));
echo templateWithMsgJson('blocks/new_collection_form.html');
