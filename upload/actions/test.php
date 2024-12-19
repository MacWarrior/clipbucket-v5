<?php

define('THIS_PAGE', 'launch_tool');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once DirPath::get('classes') .'admin_tool.class.php';
require_once DirPath::get('classes') .'AIVision.class.php';

/** definition du model et de ses parametres */
$ia = new AIVision([
    'tags'            => [ 0 => 'nsfw', 1 => 'safe']
    ,'rescale_factor' => 0.00392156862745098
    ,'height'         => 224
    ,'width'          => 224
    ,'shape'          => 'bhwc'
    ,'modelType'      => 'nsfw'
    ,'autoload'       => true
]);

/** analyse one image */
$tags = $ia->is(DirPath::get('ai') . 'images' . DIRECTORY_SEPARATOR . 'test_image.jpg', 'nsfw');

var_dump($tags);