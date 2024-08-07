<?php
$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addCSS([
    'bootstrap.min.css'                  => 'admin',
    'font-awesome.min.css'               => 'admin',
    'icon-font.css'                      => 'admin',
    'custom-elements.css'                => 'admin',
    'all' . $min_suffixe . '.css'        => 'admin',
    'clipbucket' . $min_suffixe . '.css' => 'admin',
    'jquery_ui' . $min_suffixe . '.css'  => 'admin'
]);

if( config('default_theme') != '' ){
    ClipBucket::getInstance()->addCSS([
        'themes/' . config('default_theme') . $min_suffixe . '.css' => 'admin'
    ]);
}

ClipBucket::getInstance()->addCSS([
    'themes/default' . $min_suffixe . '.css' => 'admin'
]);

ClipBucket::getInstance()->addJS([
    'jquery-3.7.1.min.js'                        => 'admin',
    'jquery-ui-1.13.2.min.js'                    => 'global',
    'clipbucket' . $min_suffixe . '.js'          => 'admin',
    'jquery_plugs/cookie' . $min_suffixe . '.js' => 'global',
    'functions' . $min_suffixe . '.js'           => 'global',
    'bootstrap' . $min_suffixe . '.js'           => 'admin',
    'uslider_js/jquery.mousewheel.js'            => 'admin',
    'custom' . $min_suffixe . '.js'              => 'admin',
    'ui_plugins.js'                              => 'admin',
    'fast_qlist' . $min_suffixe . '.js'          => 'admin'
]);
