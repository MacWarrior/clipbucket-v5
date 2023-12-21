<?php
/**
 * Loading Upload Form
 *
 * @param $params
 */
function enable_video_file_upload($params)
{
    assign('params', $params);
    Template(DirPath::get('styles') . 'global/upload_form.html', false);
}

function enable_video_remote_upload($params = null)
{
    assign('params', $params);
    Template(DirPath::get('styles') . 'global/remote_upload_form.html', false);
    return false;
}
