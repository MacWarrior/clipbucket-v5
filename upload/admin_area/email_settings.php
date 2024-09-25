<?php
define('THIS_PAGE', 'email_settings');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $cbemail, $eh, $Cbucket, $myquery;
userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');

pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('email_template'), 'url' => DirPath::getUrl('admin_area') . 'email_settings.php'];

//Updating email templates
if (isset($_POST['update'])) {
    $templates = $cbemail->get_templates();

    foreach ($templates as $template) {
        $params = ['id'  => $template['email_template_id'], 'subj' => $_POST['subject' . $template['email_template_id']],
                   'msg' => $_POST['message' . $template['email_template_id']]];
        $cbemail->update_template($params);
        $eh->flush();
        e('Email templates have been updated', 'm');
    }
}

subtitle('Email Settings');
template_files('email_settings.html');
display_it();
