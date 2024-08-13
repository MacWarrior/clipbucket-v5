<?php
define('THIS_PAGE', 'ajax');
require_once dirname(__DIR__, 3) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('admin_access');
pages::getInstance()->page_redir();

if (isset($_POST)) {
    $data = $_POST;
    $flds = [];
    $vals = [];

    foreach ($data as $network => $link) {
        if (!empty($network)) {
            $flds[] = '`' . $network . '`';
        }

        if (!empty($link)) {
            $vals[] = $link;
        } else {
            $vals[] = '';
        }
    }
    Clipbucket_db::getInstance()->update(tbl(cb_social_beast::$table_name), $flds, $vals, " id IS NOT NULL");
}
