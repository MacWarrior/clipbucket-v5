<?php
/**
 * Loading Upload Form
 *
 * @param $params
 */
function load_upload_form($params)
{
    global $file_name;
    assign('params',$params);
    Template(STYLES_DIR.'/global/upload_form.html',false);
}

function load_remote_upload_form($params=NULL)
{
    global $file_name;
    assign('params',$params);
    Template(STYLES_DIR.'/global/remote_upload_form.html',false);
    return false;
}
