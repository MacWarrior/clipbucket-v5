<?php
include("../includes/config.inc.php");

$file_name = $_POST['file'];
$file = DirPath::get('temp') . $file_name;

if (!empty($file_name) && file_exists($file)) {
    echo filesize($file);
}
