<?php
define('THIS_PAGE', 'view_page');
define('PARENT_PAGE', 'home');
require 'includes/config.inc.php';
global $pages, $cbpage;

$pages->page_redir();

$pid = $_GET['pid'];
$pid = mysql_clean($pid);

$page = $cbpage->get_page($pid);

if($page['active'] == 'no' && !User::getInstance()->hasAdminAccess()){
    redirect_to(Network::get_server_url());
}

if ($page) {
    assign('page', $page);
    subtitle($page['page_title']);
} else {
   redirect_to('404.php');
}

//Displaying The Template
template_files('view_page.html');
display_it();
