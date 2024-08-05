<?php
define('THIS_PAGE', 'file_results');
include(dirname(__FILE__, 2) . '/includes/config.inc.php');

if(empty($_POST['file_name'])){
    die();
}

$file_name = $_POST['file_name'];
$log_file = DirPath::get('temp') . $file_name . '_curl_log.cblog';
//For PHP < 5.3.0
$dummy_file = DirPath::get('temp') . $file_name . '_curl_dummy.cblog';

if (file_exists($dummy_file)) {
    //Read the data
    $data = file_get_contents($dummy_file);
    $data = json_decode($data, true);

    $file = $data['file_name'];
    $started = $data['time_started'];

    //Total File Size
    $total_size = $data['file_size'];

    $byte_size = $data['byte_size'];

    //Let check whats the file size right now
    $data['byte_size'] = $now_file_size = filesize(DirPath::get('temp') . $file);

    //Bytes Transfered
    $cur_speed = $now_file_size - $byte_size;

    //Time Eta
    $download_bytes = $total_size - $now_file_size;
    if ($cur_speed > 0) {
        $time_eta = $download_bytes / $cur_speed;
    } else {
        $time_eta = 0;
    }

    //Time Took
    $time_took = time() - $started;

    $curl_info = [
        'total_size'     => $total_size,
        'downloaded'     => $now_file_size,
        'speed_download' => $cur_speed,
        'time_eta'       => $time_eta,
        'time_took'      => $time_took,
        'file_name'      => $file
    ];

    $fo = fopen($log_file, 'w+');
    fwrite($fo, json_encode($curl_info));
    fclose($fo);

    $fo = fopen($dummy_file, 'w+');
    fwrite($fo, json_encode($data));
    fclose($fo);

    if ($total_size == $now_file_size) {
        unlink($dummy_file);
    }
}

if (file_exists($log_file)) {
    $details = file_get_contents($log_file);
    $details = json_decode($details, true);
    echo json_encode($details);
}
