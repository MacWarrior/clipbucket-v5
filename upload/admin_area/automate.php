<?php
require_once '../includes/admin_config.php';

require_once('../includes/classes/automate/cron_expression.class.php');
require_once('../includes/classes/automate/cron_schedule.class.php');
require_once('../includes/classes/automate/automate.class.php');

/* Generating breadcrumb */
global $breadcrumb, $pages,$userquery ;

$userquery->admin_login_check();
$userquery->login_check('web_config_access');
$pages->page_redir();

$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('admin_tool'), 'url' => ADMIN_BASEURL . '/admin_tool.php'];

$automate_list = Automate::getAll();
assign('automate_list', $automate_list);

subtitle( lang('admin_tool'));
template_files('automate.html');
display_it();
