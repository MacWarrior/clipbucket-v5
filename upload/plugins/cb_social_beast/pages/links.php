<?php
define('THIS_PAGE', 'links');
require_once dirname(__DIR__, 3) . '/includes/admin_config.php';

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Plugin Manager', 'url' => ''];
$breadcrumb[1] = ['title' => lang(cb_social_beast::$lang_prefix.'menu'), 'url' => cb_social_beast::getInstance()->pages_url.'links.php'];

require_once dirname(__FILE__, 4) . '/includes/admin_config.php';
userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('admin_access');
pages::getInstance()->page_redir();

$links = cb_social_beast::getAll();
foreach ($links as $key => $link) {
    assign($key, $link);
}

subtitle(lang(cb_social_beast::$lang_prefix.'subtitle'));

template_files('links.html', cb_social_beast::getInstance()->template_dir);
display_it();