<?php
define('THIS_PAGE', 'mass_uploader');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once(DirPath::get('classes') . 'sLog.php');
global $Cbucket, $userquery, $pages, $cbmass, $Upload, $cbvid, $breadcrumb;
$userquery->admin_login_check();
$pages->page_redir();

$delMassUpload = config('delete_mass_upload');

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Mass Upload Videos', 'url' => DirPath::getUrl('admin_area') . 'mass_uploader.php'];

$cats = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType('video')
]);
assign('cats', $cats);

if (isset($_POST['mass_upload_video'])) {
    $files = $cbmass->get_video_files_list_clear();
    $vtitle = $_POST['title'];

    foreach ($files as $file) {
        $hash = hash('sha512', $file['path'] . $file['file']);
        if (!isset($_POST[$hash])) {
            continue;
        }

        $file_key = time() . RandomString(5);
        $file_arr = $file;
        $file_path = $file['path'];
        $file_orgname = $file['file'];

        $file_title = $_POST[$hash . '_title'];
        $file_description = $_POST[$hash . '_description'];
        $file_tags = $_POST[$hash . '_tags'];
        $file_categories = $_POST[$hash . '_cat'];

        $file_track = '';
        if (isset($_POST[$hash . '_track'])) {
            $file_track = $_POST[$hash . '_track'];
        }

        $file_directory = create_dated_folder();
        $array = [
            'title'             => $file_title
            , 'description'     => $file_description
            , 'tags'            => $file_tags
            , 'category'        => $file_categories
            , 'file_name'       => $file_key
            , 'file_directory'  => $file_directory
            , 'allow_comments'  => 'yes'
            , 'comment_voting'  => 'yes'
            , 'allow_rating'    => 'yes'
            , 'allow_embedding' => 'yes'
        ];

        $vid = $Upload->submit_upload($array);

        if (error()) {
            e('Unable to upload "' . $file_arr['title'] . '"', 'e');
        } else {
            e('"' . $file_arr['title'] . '" has been uploaded successfully', 'm');
        }

        if ($vid) {
            //Moving file to temp dir and Inserting in conversion queue...
            $file_name = $cbmass->move_to_temp($file_arr, $file_key);

            create_dated_folder(DirPath::get('logs'));
            $logFile = DirPath::get('logs') . $file_directory . DIRECTORY_SEPARATOR . $file_key . '.log';
            $log = new SLog($logFile);

            $log->newSection('Pre-Check Configurations');
            $log->writeLine('File to be converted', 'Initializing File <strong>' . $file_name . '</strong> and pre checking configurations...', true);

            $results = $Upload->add_conversion_queue($file_name);
            $str1 = date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');
            $str = $str1 . DIRECTORY_SEPARATOR;
            mkdir(DirPath::get('videos') . $str, 0755, true);
            $fields['file_directory'] = $str1;
            $fname = explode('.', $file_name);
            $cond = 'file_name=' . '\'' . $fname[0] . '\'';
            $result = Clipbucket_db::getInstance()->db_update(tbl('video'), $fields, $cond);
            $result = exec(System::get_binaries('php') . ' -q ' . DirPath::get('actions')  . 'video_convert.php ' . $file_name . ' ' . $file_key . ' ' . $file_directory . ' ' . $logFile . ' ' . $file_track . ' > /dev/null &');
            if (file_exists(DirPath::get('conversion_queue') . $file_name)) {
                unlink(DirPath::get('conversion_queue') . $file_name);
                foreach ($vtitle as $title) {
                    $resul1 = glob(DirPath::get('files') . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . $title . '.*');
                    unlink($resul1[0]);
                }
            }

            if ($delMassUpload != 'no') {
                if (is_writable($file_path . $file_orgname)) {
                    $unlink = unlink($file_path . $file_orgname);
                    if (!$unlink) {
                        e('Can\'t delete file "' . $file_path . $file_orgname . '"', 'w');
                    }
                } else {
                    e('File "' . $file_path . $file_orgname . '" is not writable', 'w');
                }
            }
        }
    }
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'jquery-ui-1.13.2.min.js'                               => 'admin'
    ,'tag-it'.$min_suffixe.'.js'                            => 'admin'
    ,'pages/mass_uploader/mass_uploader'.$min_suffixe.'.js' => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'      => 'admin'
    ,'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);


subtitle('Mass Uploader');
template_files('mass_uploader.html');
display_it();
