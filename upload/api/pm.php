<?php
include('../includes/config.inc.php');
include('global.php');

$request = $_REQUEST;
$mode = $request['mode'];
$page = $request['page'];
$content_limit = 20;

$api_keys = $Cbucket->api_keys;
if ($api_keys) {
    if (!in_array($request['api_key'], $api_keys)) {
        exit(json_encode(['err' => 'App authentication error']));
    }
}

if (!userid()) {
    exit(json_encode(['err' => 'User not logged in']));
}

switch ($mode) {
    case "getThreads":
    case "get_threads":
        $get_limit = create_query_limit($page, $content_limit);
        $request['limit'] = $get_limit;
        $threads = $cbpm->get_threads($request);

        if ($threads) {
            echo json_encode($threads);
        } else {
            echo json_encode(['err' => 'No Threads were Found']);
        }
        break;

    case "getThread":
    case "get_thread":
        $tid = $request['thread_id'];
        $thread = $cbpm->get_thread($tid);

        if ($thread) {
            echo json_encode($thread);
        } else {
            echo json_encode(['err' => 'Thread Not Found']);
        }
        break;

    case "getMessages":
    case "get_messages":
        $get_limit = create_query_limit($page, $content_limit);
        $request['limit'] = $get_limit;
        $messages = $cbpm->get_messages($request);

        if ($messages) {
            echo json_encode($messages);
        } else {
            echo json_encode(['err' => 'No Messages were Found']);
        }
        break;

    case "getNewMessages":
    case "get_new_messages":
        $get_limit = create_query_limit($page, $content_limit);
        $request['limit'] = $get_limit;
        $messages = $cbpm->get_new_messages($request);

        if ($messages) {
            echo json_encode($messages);
        } else {
            echo json_encode(['err' => 'No New Messages were Found']);
        }
        break;

    case "sendMessage":
    case "send_message":
    case "send_msg":
    case "sndMsg":
        $tid = $request['thread_id'];
        if (!$tid) {
            //create new thread
            $recipients = json_decode($request['recipients']);
            $new_thread_id = $cbpm->create_thread(['recipients' => $recipients]);

            if (!$new_thread_id) {
                echo json_encode(['err' => error()]);
                exit();
            }

            echo json_encode(['thread_id' => $response]);
            $request['thread_id'] = $new_thread_id;
        }

        $response = $cbpm->send_message($request);

        if ($response) {
            echo json_encode(['message_id' => $response]);
        } else {
            echo json_encode(['err' => error()]);
        }
        break;

    default:
        echo json_encode(['err' => [lang('Invalid request')]]);
        break;
}
