<?php
require_once '../includes/admin_config.php';
define('THIS_PAGE', 'language_setting');
global $userquery, $pages, $Cbucket;

$userquery->admin_login_check();
$userquery->login_check('web_config_access');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Language Settings', 'url' => DirPath::getUrl('admin_area') . 'language_settings.php'];

$ll = Language::getInstance()->get_langs(false, true);
foreach ($ll as &$language) {
    $language['pourcentage_traduction'] = $language['nb_trads'] * 100 / $language['nb_codes'];
}

$restorable_langs = get_restorable_languages($ll);

assign('restore_lang_options', $restorable_langs);
//Get List Of Languages
assign('language_list', $ll);
Assign('msg', $msg);

if (!empty($_GET['edit_language']) && Language::getInstance()->getLangById($_GET['edit_language'])) {

    assign('edit_lang', 'yes');
    $detail = Language::getInstance()->getLangById($_GET['edit_language']);
    assign('lang_details', $detail);
    $breadcrumb[2] = ['title' => 'Editing : ' . display_clean($detail['language_name']), 'url' => DirPath::getUrl('admin_area') . 'language_settings.php?edit_language=' . display_clean($_GET['edit_language'])];
    $edit_id = mysql_clean($_GET['edit_language']);
    $limit = RESULTS;

    $current_page = $_GET['page'];
    $current_page = is_numeric($current_page) && $current_page > 0 ? $current_page : 1;

    $curr_limit = ($current_page - 1) * $limit . ',' . $limit;

    if (!empty($_GET['search'])) {
        $extra_param = " ( translation LIKE '%" . mysql_clean($_GET['search']) . "%' OR language_key LIKE '%" . mysql_clean($_GET['search']) . "%')";
    }

    $lang_phrases = Language::getInstance()->getAllTranslations($edit_id, 'LK.id_language_key, LT.language_id, language_key, translation', $curr_limit, $extra_param);
    $total_phrases = Language::getInstance()->countTranslations($edit_id, $extra_param);

    assign('lang_phrases', $lang_phrases);

    //Collecting Data for Pagination
    $total_pages = $total_phrases / $limit;
    $total_pages = round($total_pages + 0.49, 0);
    //Pagination
    $pages->paginate($total_pages, $current_page);
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
ClipBucket::getInstance()->addAdminJS(['pages/language_settings/language_settings'.$min_suffixe.'.js' => 'admin']);

assign('client_id', $Cbucket->configs['clientid']);
assign('secret_Id', $Cbucket->configs['secretId']);
subtitle('Language Settings');
template_files('language_settings.html');
display_it();
