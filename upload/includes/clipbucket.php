<?php
$update = Update::getInstance();

define('STATE', strtoupper($update->getCurrentCoreState()));
define('VERSION', $update->getCurrentCoreVersion());
define('REV', $update->getCurrentCoreRevision());
