<?php
define('THIS_PAGE', 'user_category');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('admin_access');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('users'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_categories'), 'url' => DirPath::getUrl('admin_area') . 'user_category.php'];

//Form Processing
if (isset($_POST['add_category'])) {
    userquery::getInstance()->thumb_dir = 'users';
    userquery::getInstance()->add_category($_POST);
}

//Making Category as Default
if (isset($_GET['make_default'])) {
    $cid = mysql_clean($_GET['make_default']);
    userquery::getInstance()->make_default_category($cid);
}

//Edit Category
if (isset($_GET['category']) && !empty($_GET['category']) && is_numeric($_GET['category'])) {
    $id_category = $_GET['category'];
    assign('edit_category', 'show');
    if (isset($_POST['update_category'])) {
        userquery::getInstance()->thumb_dir = 'users';
        userquery::getInstance()->update_category($_POST);
    }

    $cat_details = userquery::getInstance()->get_category($id_category);
    $breadcrumb[2] = ['title' => 'Editing : ' . display_clean($cat_details['category_name']), 'url' => DirPath::getUrl('admin_area') . 'user_category.php?category=' . display_clean($id_category)];
    assign('cat_details', $cat_details);
}

//Delete Category
if (isset($_GET['delete_category'])) {
    userquery::getInstance()->delete_category($_GET['delete_category']);
}

$cats = userquery::getInstance()->get_categories();
//Updating Category Order
if (isset($_POST['update_order'])) {
    foreach ($cats as $cat) {
        if (!empty($cat['category_id'])) {
            $order = $_POST['category_order_' . $cat['category_id']];
            userquery::getInstance()->update_cat_order($cat['category_id'], $order);
        }
    }
    $cats = userquery::getInstance()->get_categories();
}

//Assign Category Values
assign('category', $cats);
assign('total', userquery::getInstance()->total_categories());
subtitle('User Category Manager');
template_files('user_category.html');
display_it();
