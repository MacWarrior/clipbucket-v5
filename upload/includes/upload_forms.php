<?php
/**
 * Loading Upload Form
 *
 * @param $params
 */
function load_upload_form($params)
{
    assign('params',$params);
    Template(STYLES_DIR.'/global/upload_form.html',false);
}

function load_remote_upload_form($params=NULL)
{
    assign('params',$params);
    Template(STYLES_DIR.'/global/remote_upload_form.html',false);
    return false;
}
