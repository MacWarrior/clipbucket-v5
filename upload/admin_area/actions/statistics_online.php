<?php
const THIS_PAGE = 'statistics_online';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$ongoing_conversion = VideoConversionQueue::getAll(['count' => true, 'not_complete' => true]);
$online_users = userquery::getInstance()->get_online_users();
$html = '<p>
        ' . lang('ongoing_videos_conversions') . ' : <b>' . $ongoing_conversion . '</b>
    </p>
    <p>
        ' . lang('online_users') . ' :<b>' . count($online_users) . '</b>
    </p> 
    ';
$progress_tools = [];
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
    $progress_tools = AdminTool::getTools([
        '  tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title IN(\'in_progress\',\'stopping\'))'
    ]);
}
if (count($progress_tools) > 0) {
    $html .= '<h4>'.lang('ongoing_tools').'</h4>';
}
foreach ($progress_tools as $tool) {
    $html .= '
<br/>
    <div class="row">
    <div class="col-md-3">
        <span >
            '.lang($tool['language_key_label']).'
        </span>
    </div>
    <div class="col-md-9">
        <div style="text-align: center;  ">
            <div style="padding: 6px;"><span >'.round($tool['pourcentage_progress'], 2).'</span>%
                (<span >'.$tool['elements_done'].'</span> / <span >'.$tool['elements_total'].'</span>)
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="'.$tool['pourcentage_progress'].'"
                     aria-valuemin="0" aria-valuemax="100" style="width:'.$tool['pourcentage_progress'].'%">
                </div>
            </div>
        </div>
    </div>
</div>';
}

echo json_encode([
    'html' => $html
]);