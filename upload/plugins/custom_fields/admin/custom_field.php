<?php
// TODO : Complete URL
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Custom Field', 'url' => ''];
$breadcrumb[1] = ['title' => 'View Custom Field', 'url' => ''];

$test = "test";
assign('test', $test);
template_files(DirPath::get('plugins') . 'customfield/admin/custom_field.html', true);
