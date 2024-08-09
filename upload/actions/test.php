<?php

define('THIS_PAGE', 'launch_tool');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');
require_once('../includes/classes/AIVision.class.php');

/** Set the directory where the library will be downloaded, if it not set then it will be stored inside vendor directory */
Onnx\Library::setFolder(__DIR__.'/../ai/');

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
    ,'modelNameOrPath' => __DIR__.'/../ai/models/model.onnx'// https://huggingface.co/suko/nsfw
]);

/** Load models */
$ia->loadModel();

/** analyse one image */
$tags = $ia->getTags(__DIR__.'/../ai/images/test_image.jpg');

var_dump($tags);