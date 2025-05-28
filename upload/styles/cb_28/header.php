<?php
$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addCSS([
    'bootstrap.min.css'                                 => 'admin',
    'fortawesome/font-awesome/css/font-awesome.min.css' => 'vendor',
    'icon-font.css'                                     => 'admin',
    'all' . $min_suffixe . '.css'                       => 'admin',
    'clipbucket' . $min_suffixe . '.css'                => 'admin',
    'jquery_ui/jquery_ui' . $min_suffixe . '.css'       => 'libs',
    'select2/select2/dist/css/select2.min.css'          => 'vendor'
]);

$filepath = DirPath::get('styles') . ClipBucket::getInstance()->template . DIRECTORY_SEPARATOR . 'theme' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . User::getInstance()->getActiveTheme() . $min_suffixe . '.css';
if( User::getInstance()->getActiveTheme() != '' && file_exists($filepath) ){
    ClipBucket::getInstance()->addCSS([
        'themes/' . User::getInstance()->getActiveTheme() . $min_suffixe . '.css' => 'admin'
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
    'fast_qlist' . $min_suffixe . '.js'          => 'admin',
    'select2/select2/dist/js/select2.min.js'     => 'vendor'
]);
