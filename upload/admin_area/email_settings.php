<?php
require_once '../includes/admin_config.php';

global $userquery, $pages, $cbemail, $eh, $Cbucket, $myquery;
$userquery->admin_login_check();
$userquery->login_check('web_config_access');

$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'General Configurations', 'url' => ''];
$breadcrumb[1] = ['title' => 'Email Templates', 'url' => ADMIN_BASEURL . '/email_settings.php'];

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
