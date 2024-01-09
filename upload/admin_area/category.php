<?php
define('THIS_PAGE', 'category');

global $cbvid;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_categories'), 'url' => DirPath::getUrl('admin_area') . 'category.php'];

//Form Processing
if (isset($_POST['add_category'])) {
    $cbvid->thumb_dir = 'video';
    $cbvid->add_category($_POST);
}

//Making Category as Default
if (isset($_GET['make_default'])) {
    $cid = mysql_clean($_GET['make_default']);
    $cbvid->make_default_category($cid);
}

//Edit Category
if (isset($_GET['category']) && !empty($_GET['category']) && is_numeric($_GET['category'])) {
    $id_category = $_GET['category'];
    assign('edit_category', 'show');
    if (isset($_POST['update_category'])) {
        $cbvid->thumb_dir = 'video';
        $cbvid->update_category($_POST);
    }

    $cat_details = $cbvid->get_category($id_category);
    $breadcrumb[2] = ['title' => 'Editing : ' . display_clean($cat_details['category_name']), 'url' => DirPath::getUrl('admin_area') . 'category.php?category=' . display_clean($id_category)];
    assign('cat_details', $cat_details);

    $pid = $cbvid->get_category_field($_GET['category'], 'parent_id');

    if ($pid) {
        $selected = $pid;
    }

    $parent_cats = $cbvid->admin_area_cats($selected);
    assign('parent_cats', $parent_cats);
}

//Delete Category
if (isset($_GET['delete_category'])) {
    $cbvid->delete_category($_GET['delete_category']);
}

$cats = $cbvid->get_categories();

//Updating Category Order
if (isset($_POST['update_order'])) {
    foreach ($cats as $cat) {
        if (!empty($cat['category_id'])) {
            $order = $_POST['category_order_' . $cat['category_id']];
            $cbvid->update_cat_order($cat['category_id'], $order);
        }
    }
    $cats = $cbvid->get_categories();
}

//Assign Category Values
assign('category', $cats);
assign('total', $cbvid->total_categories());
subtitle('Video Category Manager');
Assign('msg', @$msg);
template_files('category.html');
display_it();
