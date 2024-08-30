<?php
$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addCSS([
    'bootstrap.min.css'                                 => 'admin',
    'fortawesome/font-awesome/css/font-awesome.min.css' => 'vendor',
    'icon-font.css'                                     => 'admin',
    'custom-elements.css'                               => 'admin',
    'all' . $min_suffixe . '.css'                       => 'admin',
    'clipbucket' . $min_suffixe . '.css'                => 'admin',
    'jquery_ui' . $min_suffixe . '.css'                 => 'admin'
]);

$filepath = DirPath::get('styles') . ClipBucket::getInstance()->template . DIRECTORY_SEPARATOR . 'theme' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . config('default_theme') . $min_suffixe . '.css';
if( config('default_theme') != '' && file_exists($filepath) ){
    ClipBucket::getInstance()->addCSS([
        'themes/' . config('default_theme') . $min_suffixe . '.css' => 'admin'
    ]);
}

ClipBucket::getInstance()->addCSS([
    'themes/default' . $min_suffixe . '.css' => 'admin'
]);

ClipBucket::getInstance()->addJS([
    'components/jquery/jquery.min.js'            => 'vendor',
    'jquery-ui-1.13.2.min.js'                    => 'global',
    'clipbucket' . $min_suffixe . '.js'          => 'admin',
    'jquery_plugs/cookie' . $min_suffixe . '.js' => 'global',
    'functions' . $min_suffixe . '.js'           => 'global',
    'bootstrap' . $min_suffixe . '.js'           => 'admin',
    'custom' . $min_suffixe . '.js'              => 'admin',
    'fast_qlist' . $min_suffixe . '.js'          => 'admin'
]);
