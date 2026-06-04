<?php
const THIS_PAGE = 'manage_pages';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';
pages::getInstance()->page_redir();

$permission = 'basic_settings';
if( !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '275') ){
    $permission = 'web_config_access';
}
User::getInstance()->hasPermissionOrRedirect($permission,true);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('pages'))), 'url' => DirPath::getUrl('admin_area') . 'manage_pages.php'];

//Activating Page
if (isset($_GET['activate'])) {
    $pid = mysql_clean($_GET['activate']);
    cbpage::getInstance()->page_actions('activate', $pid);
}

//Deactivating Page
if (isset($_GET['deactivate'])) {
    $pid = mysql_clean($_GET['deactivate']);
    cbpage::getInstance()->page_actions('deactivate', $pid);
}

//Deleting
if (isset($_GET['delete'])) {
    $pid = mysql_clean($_GET['delete']);
    cbpage::getInstance()->page_actions('delete', $pid);
}

//Displaying
if (isset($_GET['display'])) {
    $pid = mysql_clean($_GET['display']);
    cbpage::getInstance()->page_actions('display', $pid);
}

//Hiding
if (isset($_GET['hide'])) {
    $pid = mysql_clean($_GET['hide']);
    cbpage::getInstance()->page_actions('hide', $pid);
}

if (isset($_POST['activate_selected']) && is_array($_POST['check_page'])) {
    foreach($_POST['check_page'] as $id){
        cbpage::getInstance()->page_actions('activate', $id);
    }
    if( !error() && !warning() ) {
        errorhandler::getInstance()->flush();
        e('Selected pages have been activated', 'm');
    }
}

if (isset($_POST['deactivate_selected']) && is_array($_POST['check_page'])) {
    foreach($_POST['check_page'] as $id){
        cbpage::getInstance()->page_actions('deactivate', $id);
    }
    if( !error() && !warning() ) {
        errorhandler::getInstance()->flush();
        e('Selected pages have been deactivated', 'm');
    }
}

if (isset($_POST['delete_selected']) && is_array($_POST['check_page'])) {
    foreach($_POST['check_page'] as $id){
        cbpage::getInstance()->page_actions('delete', $id);
    }
    if( !error() && !warning() ) {
        errorhandler::getInstance()->flush();
        e('Selected pages have been deleted', 'm');
    }
}

$mode = $_GET['mode'];

if (isset($_POST['add_page'])) {
    if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
        SessionMessageHandler::add_message('Sorry, you cannot perform this action until the application has been fully updated by an administrator', 'e', User::getInstance()->getDefaultHomepageFromUserLevel());
    }
    if (cbpage::getInstance()->create_page($_POST)) {
        $mode = 'view';
    }
    if (!error()) {
        sessionMessageHandler::add_message(lang('new_page_added_successfully'), 'm', DirPath::getUrl('admin_area') . 'manage_pages.php');
    }
}

//Updating order
if (isset($_POST['update_order'])) {
    cbpage::getInstance()->update_order();
    if( !error() && !warning() ) {
        errorhandler::getInstance()->flush();
        e(lang('page_order_has_been_updated'), 'm');
    }
}
if (empty($mode) || $mode == 'view') {
    if ($_GET['msg']) {
        e(mysql_clean($_GET['msg']), 'm');
    }
    assign('mode', 'manage');
    assign('cbpages', cbpage::getInstance()->get_pages());
} else {
    if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
        SessionMessageHandler::add_message('Sorry, you cannot perform this action until the application has been fully updated by an administrator', 'e', User::getInstance()->getDefaultHomepageFromUserLevel());
    }
    assign('mode', $mode);
    if ($mode == 'edit') {
        if (isset($_POST['update_page'])) {
            $_POST['page_id'] = $_GET['pid'];
            cbpage::getInstance()->edit_page($_POST);
        }
        $page = cbpage::getInstance()->get_page(mysql_clean($_GET['pid']));
        if (!$page) {
            e('Page does not exist');
        }
    }
    $languages = Language::getInstance()->get_langs(true);
    $first_display = 0;
    foreach ($languages as &$language) {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $translations = cbpage::getInstance()->getPageTranslation($page['page_id'], $language['language_id']) ?: null;
            $page['page_contents'][$language['language_id']] = $translations['page_content'] ?? '';
            $page['page_titles'][$language['language_id']] = $translations['page_title'] ?? '';
        } else {
            $page['page_contents'][$language['language_id']] = $page['page_content'];
            $page['page_titles'][$language['language_id']] = $page['page_title'];
        }
        $language['is_specified'] = (bool)$page['page_contents'][$language['language_id']];
        if ($language['is_specified'] && !$first_display) {
            $first_display = $language['language_id'];
            $language['is_shown'] = true;
        } else {
            $language['is_shown'] = false;
        }
    }
    if (!$first_display) {
        $languages[0]['is_shown'] = true;
    }
    assign('page', $page);
    assign('languages', $languages);
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'summernote/summernote' . $min_suffixe . '.js' => 'libs',
    'pages/manage_pages/manage_pages'.$min_suffixe.'.js' => 'admin'
]);
ClipBucket::getInstance()->addAdminCSS([
    'summernote/summernote' . $min_suffixe . '.css'     => 'libs'
]);

subtitle(lang('manage_x', strtolower(lang('pages'))));
template_files('manage_pages.html');
display_it();
