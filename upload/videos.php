<?php
define('THIS_PAGE', 'videos');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('view_videos');
pages::getInstance()->page_redir();

require_once '.' . DIRECTORY_SEPARATOR . 'videos_core.php';
