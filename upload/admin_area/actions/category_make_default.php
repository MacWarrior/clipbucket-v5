<?php
const THIS_PAGE = 'category_make_default';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!empty($_POST['category_id'])) {
    Category::getInstance()->makeDefault($_POST['type'], $_POST['category_id']);
}

$cats = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType($_POST['type'])
    ,'parent_only'=>true
]);

//Assign Category Values
assign('categories', $cats);
assign('type', $_POST['type']);
assign('total', $cats = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType($_POST['type']),
    'count'
]));

echo templateWithMsgJson('blocks/category_list.html');
