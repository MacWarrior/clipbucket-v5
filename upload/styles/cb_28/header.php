<?php
global $Cbucket;
if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addCSS([
    'bootstrap.min.css'                  => 'admin',
    'font-awesome.min.css'               => 'admin',
    'icon-font.css'                      => 'admin',
    'custom-elements.css'                => 'admin',
    'all' . $min_suffixe . '.css'        => 'admin',
    'clipbucket' . $min_suffixe . '.css' => 'admin',
    'jquery_ui' . $min_suffixe . '.css'  => 'admin'
]);

$Cbucket->addJS([
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
