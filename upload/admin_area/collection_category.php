<?php
define('THIS_PAGE', 'collection_category');

global $cbcollection, $breadcrumb;
require_once '../includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => lang('collections'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_categories'), 'url' => DirPath::getUrl('admin_area') . 'collection_category.php'];

//Form Processing
if (isset($_POST['add_category'])) {
    $cbcollection->thumb_dir = 'collections';
    $cbcollection->add_category($_POST);
}

//Making Category as Default
if (isset($_GET['make_default'])) {
    $cid = mysql_clean($_GET['make_default']);
    $cbcollection->make_default_category($cid);
}

//Edit Category
if (isset($_GET['category'])) {
    assign('edit_category', 'show');
    if (isset($_POST['update_category'])) {
        $cbcollection->thumb_dir = 'collections';
        $cbcollection->update_category($_POST);
    }
    $cat_details = $cbcollection->get_category($_GET['category']);

    assign('cat_details', $cat_details);

    $breadcrumb[2] = ['title' => 'Editing : ' . display_clean($cat_details['category_name']), 'url' => DirPath::getUrl('admin_area') . 'collection_category.php?category=' . display_clean($_GET['category'])];
}

//Delete Category
if (isset($_GET['delete_category'])) {
    $cbcollection->delete_category($_GET['delete_category']);
}

$cats = $cbcollection->get_categories();

//Updating Category Order
if (isset($_POST['update_order'])) {
    foreach ($cats as $cat) {
        if (!empty($cat['category_id'])) {
            $order = $_POST['category_order_' . $cat['category_id']];
            $cbcollection->update_cat_order($cat['category_id'], $order);
        }
    }
    $cats = $cbcollection->get_categories();
}

//Assign Category Values
assign('category', $cats);
assign('total', count($cats));

subtitle('Collection Category Manager');
Assign('msg', @$msg);

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
ClipBucket::getInstance()->addAdminJS(['jquery-ui-1.13.2.min.js' => 'global']);
ClipBucket::getInstance()->addAdminJS(['pages/collection_category/collection_category'.$min_suffixe.'.js' => 'admin']);

template_files('collection_category.html');
display_it();
