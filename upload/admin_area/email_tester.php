<?php
define('THIS_PAGE', 'email_tester');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('email_tester'), 'url' => DirPath::getUrl('admin_area') . 'email_tester.php'];

if (isset($_POST['start_test'])) {
    try {
        $to_email = $_POST['to_email'];
        if (empty($to_email)) {
            throw new \Exception('Please provide a recipient email');
        }

        $to_email = filter_var($to_email, FILTER_SANITIZE_EMAIL);
        $to_email = filter_var($to_email, FILTER_VALIDATE_EMAIL);
        if ($to_email === false) {
            throw new \Exception('Please provide a valid recipient email address');
        }

        $to_name = $_POST['to_name'];
        if (empty($to_name) || !is_string($to_name)) {
            $to_name = $to_email;
        }

        $from_email = $_POST['from_email'];
        if (empty($from_email)) {
            $from_email = SUPPORT_EMAIL;
        }

        $from_email = filter_var($from_email, FILTER_SANITIZE_EMAIL);
        $from_email = filter_var($from_email, FILTER_VALIDATE_EMAIL);
        if ($from_email === false) {
            throw new \Exception('Please provide a valid sender email address');
        }

        $from_name = $_POST['from_name'];
        if (empty($from_name) || !is_string($from_name)) {
            $from_name = ClipBucket::getInstance()->configs['site_title'];
        }

        $code = $_POST['email_template'];
        if ($code != -1) {
            $cbemail = CBEmail::getInstance();
            $template = $cbemail->get_template($code);

            if ($template) {
                $dv = $_POST['dv'];
                $variables = [];

                if (!empty($dv)) {
                    foreach ($dv as $key => $v) {
                        $variables[$v['name']] = empty($v['value']) ? $v['name'] : $v['value'];
                    }
                }

                $subject = $cbemail->replace($template['email_template_subject'], $variables);
                $body = $cbemail->replace($template['email_template'], $variables);
            }
        } else {
            $subject = trim($_POST['subject']);
            if (empty($subject) || $subject == '') {
                throw new \Exception('Please provide test email subject');
            }

            $body = trim($_POST['body']);
            if (empty($body) || $body == '') {
                throw new \Exception('Please provide test email body');
            }
        }

        $mail = [
            'to'        => $to_email,
            'to_name'   => $to_name,
            'from'      => $from_email,
            'from_name' => $from_name,
            'subject'   => $subject,
            'content'   => $body
        ];

        $test = cbmail($mail, true);

        if ($test == false) {
            e(lang('mail_not_send', $to_email));
        } else {
            e(lang('mail_send', $to_email), 'm');
        }

    } catch (\Exception $e) {
        e($e->getMessage());
    }
}

$templates = $cbemail->get_templates();
$list = [];
$_templates = [];

$macros = [
    '{website_title}' => TITLE,
    '{baseurl}'       => BASEURL,
    '@baseurl'        => BASEURL,
    '{website_url}'   => BASEURL,
    '{date_format}'   => cbdate(DATE_FORMAT),
    '{date}'          => cbdate(),
    '{username}'      => user_name(),
    '{userid}'        => user_id(),
    '{first_name}'    => userquery::getInstance()->udetails['first_name'],
    '{last_name}'     => userquery::getInstance()->udetails['last_name'],
    '{name}'          => name(userquery::getInstance()->udetails),
    '{user}'          => name(userquery::getInstance()->udetails),
    '{email}'         => userquery::getInstance()->udetails['email'],
    '{date_year}'     => cbdate('Y'),
    '{date_month}'    => cbdate('m'),
    '{date_day}'      => cbdate('d'),
    '{now}'           => NOW()
];

if (!empty($templates)) {
    foreach ($templates as $template) {
        $code = $template['email_template_code'];
        $list[$code] = $template['email_template_name'];

        $HTML_template = DirPath::get('styles') . 'global/v4/email_templates/' . $code . '.html';

        if (file_exists($HTML_template)) {
            $body = file_get_contents($HTML_template);
        } else {
            $body = $template['email_template'];
        }

        $_templates[$code] = [
            'subject' => $template['email_template_subject'],
            'body'    => $body
        ];
    }
}

assign('list', $list);
assign('_templates', $_templates);
assign('macros', $macros);

subtitle("Email Tester");
template_files('email_tester.html');
display_it();
