<?php
define('THIS_PAGE', 'ajax');
require '../includes/config.inc.php';

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    switch ($mode) {
        case 'check_email':
            $email = mysql_clean($_POST['email']);
            $check = Clipbucket_db::getInstance()->select(tbl('users'), "email", " email='$email'");
            if ($check) {
                echo 'emailExists';
                break;
            }

            if (!userquery::getInstance()->check_email_domain($_POST['email'])) {
                echo 'unauthorized';
                break;
            }

            echo 'OK';
            break;

        case 'userExists':
            $username = mysql_clean($_POST['username']);
            $check = Clipbucket_db::getInstance()->select(tbl('users'), "username", " username='$username'");
            if (!$check) {
                echo 'NO';
            }
            break;

        case 'get_video':
            {
                $response = [];
                try {
                    global $cbvid;
                    $videoid = (int)$_POST['videoid'];
                    $videoDetails = $cbvid->get_video($videoid);
                    if ($videoDetails && video_playable($videoDetails)) {
                        assign('video', $videoDetails);
                        $related_videos = get_videos(['title' => $videoDetails['title'], 'tags' => $videoDetails['tags'], 'exclude' => $videoDetails['videoid'], 'show_related' => 'yes', 'limit' => 12, 'order' => 'date_added DESC']);
                        if (!$related_videos) {
                            $related_videos = get_videos(['exclude' => $videoid, 'limit' => 12, 'order' => 'date_added DESC']);
                        }
                        foreach ($related_videos as $video) {
                            $video['imageSrc'] = get_thumb($video, false, '168x105');
                            $video['url'] = video_link($video);
                            $related_videos_temp[] = $video;
                        }
                        $related_videos = $related_videos_temp;
                        assign('related_videos', $related_videos);
                        $data = Fetch("blocks/videos/video_block.html");
                        $response['video'] = $data;

                        $response['video_link'] = video_link($videoDetails);
                        $response['video_details'] = $videoDetails;
                        $response['success'] = true;
                        $response['message'] = "success";
                    } else {
                        if (msg()) {
                            $msg = msg_list();
                        }
                        if (error()) {
                            $msg = error_list();
                        }
                        if (!$msg) {
                            $msg = "Oops ! Something went worng in Playing this video!";
                        } else {
                            $msg = $msg[0]['val'];
                        }
                        $response['failure'] = true;
                        $response['message'] = $msg;
                    }
                } catch (\Exception $e) {
                    $response['failure'] = true;
                    $response['message'] = $e->getMessage();
                }
                echo json_encode($response);

            }
            break;

        default:
            # code...
            break;
    }
}
