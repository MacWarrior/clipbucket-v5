<?php
global $Cbucket;
$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminCSS([
    'bootstrap.min.css'                                 => 'admin',
    'fortawesome/font-awesome/css/font-awesome.min.css' => 'vendor',
    'select2/select2/dist/css/select2.min.css'          => 'vendor',
    'ace-ie.min.css'                                    => 'admin',
    'styles' . $min_suffixe . '.css'                    => 'admin',
    'open_sans' . $min_suffixe . '.css'                 => 'admin',
    'summernote' . $min_suffixe . '.css'                => 'admin',
    'bootstrap-editable' . $min_suffixe . '.css'        => 'admin'
]);

if (!this_page('admin_login')) {
    ClipBucket::getInstance()->addAdminCSS([
        'ace.min.css'       => 'admin',
        'ace-rtl.min.css'   => 'admin',
        'ace-skins.min.css' => 'admin'
    ]);
}

ClipBucket::getInstance()->addAdminJS([
    'components/jquery/jquery.min.js'              => 'vendor',
    'select2/select2/dist/js/select2.min.js'               => 'vendor',
    'jquery-ui-1.13.2.min.js'                      => 'global',
    'html5shiv' . $min_suffixe . '.js'             => 'admin',
    'respond.min.js'                               => 'admin',
    'ace-extra.min.js'                             => 'admin',
    'clipbucket' . $min_suffixe . '.js'            => 'admin',
    'functions' . $min_suffixe . '.js'             => 'global',
    'admin_functions' . $min_suffixe . '.js'       => 'admin',
    'jquery_plugs/cookie' . $min_suffixe . '.js'   => 'global',
    'summernote/summernote' . $min_suffixe . '.js' => 'admin',
    'main' . $min_suffixe . '.js'                  => 'admin',
    'jquery.amcharts' . $min_suffixe . '.js'       => 'admin',
    'jquery.pie' . $min_suffixe . '.js'            => 'admin',
    'jquery.light' . $min_suffixe . '.js'          => 'admin',
    'jquery.serial' . $min_suffixe . '.js'         => 'admin',
    'bootstrap-editable' . $min_suffixe . '.js'    => 'admin'
]);
