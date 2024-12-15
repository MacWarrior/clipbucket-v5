<?php

define('THIS_PAGE', 'launch_tool');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once DirPath::get('classes') .'admin_tool.class.php';
require_once DirPath::get('classes') .'AIVision.class.php';

/** Set the directory where the library will be downloaded, if it not set then it will be stored inside vendor directory */
Onnx\Library::setFolder(DirPath::get('ai'));

/** Download the library if not found */
Onnx\Library::install();

/** definition du model et de ses parametres */
$ia = new AIVision([
    'tags' => [ 0 => "Naked", 1 => "Safe"]
    ,'rescale_factor' => 0.00392156862745098
    ,'format' => 'rgb'
    ,'height' => 224
    ,'width' => 224
    ,'shape' => 'bhwc'  /* batch channel height width */
    ,'modelType' => 'nsfw'
]);

/** Load models */
$ia->loadModel();

/** analyse one image */
$tags = $ia->getTags(DirPath::get('ai') . 'images' . DIRECTORY_SEPARATOR . 'test_image.jpg');

var_dump($tags);