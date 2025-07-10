<?php
define('THIS_PAGE', 'form_category');
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$type = mysql_clean($_POST['type'] ?? '');

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
