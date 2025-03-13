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
    redirect_to(DirPath::getUrl('root'));
}

if ($page) {
    assign('page', $page);
    subtitle($page['page_title']);
} else {
    e(lang('page_doesnt_exist'));
    ClipBucket::getInstance()->show_page = false;
}

//Displaying The Template
template_files('view_page.html');
display_it();
