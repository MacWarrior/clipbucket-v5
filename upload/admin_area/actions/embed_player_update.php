<?php
const THIS_PAGE = 'embed_player_update';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('video_moderation');

switch($_POST['mode'] ?? ''){
    default:
        e(lang('missing_params'));
        $success = false;
        $data = [];
        break;

    case 'enable':
        if( empty($_POST['id_video_embed']) || empty($_POST['enabled']) ){
            e(lang('missing_params'));
            $success = false;
            $data = [];
            break;
        }
        $params = [
            'enabled' => $_POST['enabled']
        ];
        $success = Video::getInstance()->updateEmbedPlayer($params);
        $data = Video::getInstance()->getEmbedPlayers([
            'id_video_embed' => $_POST['id_video_embed']
            ,'first_only' => true
        ]);
        break;

    case 'delete':
        if( empty($_POST['id_video_embed']) ){
            e(lang('missing_params'));
            $success = false;
            $data = [];
            break;
        }

        $success = Video::getInstance()->removeEmbedPlayer(['id_video_embed' => $_POST['id_video_embed']]);
        $data = [];
        break;

    case 'update':

            if( empty($_POST['id_video_embed'])) {
                DiscordLog::sendDump(1);
            }
            if( empty($_POST['id_fontawesome_icon']) ){
                DiscordLog::sendDump(2);
            }
            if( empty($_POST['title']) ){
                DiscordLog::sendDump(3);
            }
            if( empty($_POST['html']) ){
                DiscordLog::sendDump(4);
            }
            if( !isset($_POST['order']) ){
                DiscordLog::sendDump(5);
            }
            if( trim($_POST['order']) == '' ){
                DiscordLog::sendDump(6);
            }

        if( empty($_POST['id_video_embed']) || empty($_POST['id_fontawesome_icon']) || empty($_POST['title']) || empty($_POST['html']) || !isset($_POST['order']) || trim($_POST['order']) == '' ){
            DiscordLog::sendDump($_POST);
            e(lang('missing_params'));
            $success = false;
            $data = [];
            break;
        }
        $params = [
            'id_video_embed' => $_POST['id_video_embed'],
            'id_fontawesome_icon' => $_POST['id_fontawesome_icon'],
            'title' => $_POST['title'],
            'html' => $_POST['html'],
            'order' => $_POST['order']
        ];
        $success = Video::getInstance()->updateEmbedPlayer($params);
        $data = Video::getInstance()->getEmbedPlayers([
            'id_video_embed' => $_POST['id_video_embed']
            ,'first_only' => true
        ]);
        break;

    case 'create':

        $success = true;
        $data = Video::getInstance()->getEmbedPlayers(['id_video_embed' => $id_video_embed]);
        break;
}

echo json_encode([
    'success' => $success,
    'data'    => $data,
    'msg'     => getTemplateMsg()
]);
die();