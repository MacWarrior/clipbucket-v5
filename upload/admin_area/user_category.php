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


//Making Category as Default
if (isset($_GET['make_default'])) {
    Category::getInstance()->makeDefault('user', $_GET['make_default']);
}

if (!empty($_POST)) {
//@TODO rework check vals
    if (empty($_POST['category_name'])) {
        e(lang('add_cat_no_name_err'));
    } elseif (!empty(Category::getInstance()->getAll([
            'category_type' => Category::getInstance()->getIdsCategoriesType('user'),
            'condition'     => 'category_name like \'%' . mysql_clean($_POST['category_name']) . '%\'',
            'first_only'    => true
        ])) && ($_POST['cur_name'] != $_POST['category_name'])) {
        e(lang('add_cat_erro'));
    } elseif (!empty($_POST['category_id'])) {
        $id_category = $_POST['category_id'];
        if (isset($_POST['update_category'])) {
            Category::getInstance()->update($_POST);
        }
    } else {
        $params = $_POST;
        $params['id_category_type'] = Category::getInstance()->getIdsCategoriesType('user');
        $id_category = Category::getInstance()->insert($params);
    }

    if (!empty($_FILES['category_thumb']['tmp_name'])) {
        Category::getInstance()->add_category_thumb($id_category, $_FILES['category_thumb']);
    }
}
$cat_details = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType('user'),
    'category_id'   => $id_category ?? ($_GET['category'] ?? 0),
    'first_only'    => true
]);
assign('cat_details', $cat_details);

if (!empty($_GET['category']) && is_numeric($_GET['category'])) {
    if (empty($cat_details)) {
        e(lang('unknow_categ'));
    } else {
        $breadcrumb[2] = [
            'title' => 'Editing : ' . display_clean($cat_details['category_name']),
            'url'   => DirPath::getUrl('admin_area') . '/user_category.php?category=' . display_clean($id_category)
        ];
    }
}

//Delete Category
if (isset($_GET['delete_category'])) {
    Category::getInstance()->delete($_GET['delete_category']);
}

//Updating Category Order
if (isset($_POST['update_order'])) {
    foreach ($_POST['category_order'] as $key => $item) {
        Category::getInstance()->update([
            'category_id'    => $key,
            'category_order' => $item
        ]);
    }
}

$cats = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType('user')
]);

//Assign Category Values
assign('category', $cats);
assign('total', $cats = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType('user'),
    'count'
]));
subtitle('User Category Manager');
template_files('user_category.html');
display_it();
