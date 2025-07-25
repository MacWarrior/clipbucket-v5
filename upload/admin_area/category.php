<?php
const THIS_PAGE = 'category';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('video_moderation',true);
pages::getInstance()->page_redir();

$type = $_GET['type'] ?? 'video';
switch ($type) {
    case 'video':
    default:
        $config = 'enable_video_categories';
        break;
    case 'photo':
        $config = 'enable_photo_categories';
        break;
    case 'collection':
        $config = 'enable_collection_categories';
        break;
    case 'user':
        $config = 'enable_user_category';
        break;
}
if (config($config) != 'yes') {
    redirect_to(DirPath::getUrl('admin_area'));
}
assign('type', $type);
assign('display_type', $type . 's');
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang($type . 's'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_x', strtolower(lang('categories'))),
    'url'   => DirPath::getUrl('admin_area') . 'category.php?type=' . $type
];

if( !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '323') ){
    e('Your database is not up-to-date. Please update your database via this link : <a href="' . DirPath::getUrl('admin_area') . 'admin_tool.php?id_tool=5">' . lang('update') . '</a>', 'e', false);
} else {
    //Making Category as Default
    if (isset($_GET['make_default'])) {
        Category::getInstance()->makeDefault('video', $_GET['make_default']);
    }
    if (!empty($_POST) && empty($_POST['update_order'])) {
        //@TODO rework check vals
        if (empty($_POST['category_name'])) {
            e(lang('add_cat_no_name_err'));
        } elseif (!empty(Category::getInstance()->getAll([
                'category_type' => Category::getInstance()->getIdsCategoriesType($type),
                'condition'     => 'category_name like \'' . mysql_clean($_POST['category_name']) . '\'',
                'first_only'    => true
            ])) && ($_POST['cur_name'] != $_POST['category_name'])) {
            e(lang('add_cat_erro'));
        } elseif (!empty($_POST['category_id'])) {
            $id_category = $_POST['category_id'];
            if (isset($_POST['update_category'])) {
                Category::getInstance()->update($_POST);
                if ($_POST['is_default'] == 'yes') {
                    Category::getInstance()->makeDefault($type, $_POST['category_id']);
                }
            }
        } else {
            $params = $_POST;
            $params['id_category_type'] = Category::getInstance()->getIdsCategoriesType($type);
            $next_order_place = Category::getInstance()->getNextOrderForParent($type, $_POST['parent_id']);
            $params['category_order'] = $next_order_place;
            $inserted_id = Category::getInstance()->insert($params);
            $id_category = $inserted_id;
            if ($_POST['is_default'] == 'yes') {
                Category::getInstance()->makeDefault($type, $inserted_id);
            }
        }

        if (!empty($_FILES['category_thumb']['tmp_name'])) {
            Category::getInstance()->add_category_thumb($id_category, $_FILES['category_thumb']);
        }
    }
    $id_category = $id_category ?? ($_GET['category'] ?? 0);
    $cat_details = Category::getInstance()->getAll([
        'category_type' => Category::getInstance()->getIdsCategoriesType($type),
        'category_id'   => $id_category,
        'first_only'    => true
    ]);
    assign('cat_details', $cat_details);

    if (!empty($_GET['category']) && is_numeric($_GET['category'])) {
        if (empty($cat_details)) {
            e(lang('unknow_categ'));
        } else {
            $breadcrumb[2] = [
                'title' => 'Editing : ' . display_clean($cat_details['category_name']),
                'url'   => DirPath::getUrl('admin_area') . 'category.php?type=' . $type . '&category=' . display_clean($id_category)
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
                'category_id' => $key,
                'category_order' => $item
            ]);
        }
    }

    $cats = Category::getInstance()->getAll([
        'category_type' => Category::getInstance()->getIdsCategoriesType($type)
    ]);

    //Assign Category Values
    assign('category', $cats);
    assign('total', Category::getInstance()->getAll([
        'category_type' => Category::getInstance()->getIdsCategoriesType($type),
        'count'
    ]));
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/category/category'.$min_suffixe.'.js' => 'admin']);

subtitle(lang('manage_categories') . ' - ' . ucfirst(lang($type)));
Assign('msg', @$msg);
template_files('category.html');
display_it();
