<?php
// This script runs only via command line
ini_set('max_execution_time', '0');
define('THIS_PAGE', 'automate');

include(dirname(__FILE__) . '/../includes/config.inc.php');
require_once(BASEDIR . '/includes/classes/automate/cron_expression.class.php');
require_once('../includes/classes/automate/cron_schedule.class.php');
require_once(BASEDIR . '/includes/classes/automate/automate.class.php');
require_once(BASEDIR . '/includes/classes/cli.class.php');

/**
 * config for cron should be without parameters : php automate.php
 * example for call one task : php automate.php id=7
 */

$param = CLI::getParams();
if (isset($param['id'])) {
    Automate::start_task( (int) $param['id']);
} else {
    Automate::start_service();
}