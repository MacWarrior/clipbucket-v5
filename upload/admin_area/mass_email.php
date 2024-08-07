<?php
define('THIS_PAGE', 'mass_email');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('member_moderation');
pages::getInstance()->page_redir();

if (config('disable_email') == 'yes') {
    redirect_to(BASEURL . DirPath::getUrl('admin_area'));
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Mass Email', 'url' => DirPath::getUrl('admin_area') . 'mass_email.php'];

if (!empty($_GET['email'])) {
    Assign('email', $_GET['email']);
}

$cbemail = CBEmail::getInstance();
//Creating an mass email
if (isset($_POST['create_email'])) {
    if ($cbemail->add_mass_email()) {
        unset($_POST);
    }
}

//Deleting Email
if (isset($_GET['delete'])) {
    $del = mysql_clean($_GET['delete']);
    $cbemail->action($del, 'delete');
}

if (config('disable_email') == 'no') { //Sending Email
    if (isset($_GET['send_email'])) {
        $eId = mysql_clean($_GET['send_email']);
        $email = $cbemail->get_email($eId);
        if ($email) {
            $msgs = $cbemail->send_emails($email);
            assign('msgs', $msgs);

            $email = $cbemail->get_email($eId);
            assign('send_email', $email);
        }
    }
}

//Getting List of emails
$emails = $cbemail->get_mass_emails();
assign('emails', $emails);

//Category Array...
if (is_array($_POST['category'])) {
    $cats_array = [$_POST['category']];
} else {
    preg_match_all('/#([0-9]+)#/', $_POST['category'], $m);
    $cats_array = [$m[1]];
}
$cat_array = [
    lang('vdo_cat'),
    'type'             => 'checkbox',
    'name'             => 'category[]',
    'id'               => 'category',
    'value'            => [$cats_array],
    'hint_1'           => lang('vdo_cat_msg'),
    'display_function' => 'convert_to_categories',
    'category_type'    => 'user'
];
assign('cat_array', $cat_array);

$cats = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType('profile')
]);
assign('cats', $cats);

//Displaying template...
subtitle('Mass Email');
template_files('mass_email.html');
display_it();
