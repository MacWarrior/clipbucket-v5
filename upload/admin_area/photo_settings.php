<?php
const THIS_PAGE = 'photo_settings';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('photos_moderation', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('watermark_settings'), 'url' => DirPath::getUrl('admin_area') . 'photo_settings.php?mode=watermark_settings'];

if ($_POST['update_watermark']) {
    $rows = [
        'watermark_photo',
        'watermark_max_width',
        'watermark_placement'
    ];
    $numeric = ['watermark_max_width'];

    foreach ($rows as $field) {
        $value = $_POST[$field];
        if (in_array($filed, $numeric)) {
            if ($value < 0 || !is_numeric($value)) {
                $value = 1;
            }
        }
        myquery::getInstance()->Set_Website_Details($field, $value);
    }
    if (!empty($_FILES['watermark_file']['tmp_name'])) {
        CBPhotos::getInstance()->update_watermark($_FILES['watermark_file']);
    }

    e("Watermark Settings Have Been Updated", 'm');
    subtitle("Watermark Settings");
}


$row = myquery::getInstance()->Get_Website_Details();
assign('row', $row);

template_files('photo_settings.html');
display_it();
