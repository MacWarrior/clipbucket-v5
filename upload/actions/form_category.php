<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');
global $userquery;

$userquery->admin_login_check();
$type = mysql_clean($_POST['type']);
if (!empty($_POST['category_id'])) {
    global $breadcrumb;
    $categ = Category::getInstance()->getById($_POST['category_id']);
    $breadcrumb[2] = [
        'title' => 'Editing : ' . display_clean($categ['category_name']),
        'url'   => DirPath::getUrl('admin_area') . 'category.php?type=' . $type . '&category=' . display_clean($_POST['category_id'])
    ];
    assign('categ', $categ);
    $type = Category::getInstance()->getTypeNamesByIds($categ['id_category_type']);
}
assign('type', $type);
display_categ_form();