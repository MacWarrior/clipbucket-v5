<?php
const THIS_PAGE = 'view_page';
const PARENT_PAGE = 'home';
require 'includes/config.inc.php';

pages::getInstance()->page_redir();

$pid = $_GET['pid'];
$pid = mysql_clean($pid);

$page = cbpage::getInstance()->get_page($pid);

if($page['active'] == 'no' && !User::getInstance()->hasAdminAccess()){
    redirect_to(DirPath::getUrl('root'));
}

if ($page) {
    assign('page', $page);
    subtitle($page['page_title']);
} else {
    redirect_to(cblink(['name' => 'error_404']));
}

//Displaying The Template
template_files('view_page.html');
display_it();
