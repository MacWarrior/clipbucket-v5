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
            'id_video_embed' => $_POST['id_video_embed']
            ,'enabled'       => ($_POST['enabled'] == 'true') ? '1' : '0'
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
        if( empty($_POST['id_video_embed']) || empty($_POST['id_fontawesome_icon']) || empty($_POST['title']) || empty($_POST['html']) || !isset($_POST['order']) || trim($_POST['order']) == '' ){
            e(lang('missing_params'));
            $success = false;
            $data = [];
            break;
        }

        if( !isValidHTML($_POST['html']) ){
            e(lang('html_code_is_invalid'));
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
        if( empty($_POST['videoid']) || empty($_POST['id_fontawesome_icon']) || empty($_POST['title']) || empty($_POST['html']) || !isset($_POST['order']) ){
            e(lang('missing_params'));
            $success = false;
            $data = [];
            break;
        }

        if( trim($_POST['order']) == '' ){
            $_POST['order'] = 0;
        }

        if( !isValidHTML($_POST['html']) ){
            e(lang('html_code_is_invalid'));
            $success = false;
            $data = [];
            break;
        }

        $id_video_embed = Video::getInstance()->createEmbedPlayer([
            'videoid' => $_POST['videoid']
            ,'id_fontawesome_icon' => $_POST['id_fontawesome_icon']
            ,'title' => $_POST['title']
            ,'html' => $_POST['html']
            ,'order' => $_POST['order']
            ,'enabled' => 1
        ]);

        $list_icons = SocialNetworks::getInstance()->getAllIcons() ?? [];
        assign('list_icons', $list_icons);

        $embed_player_line = Video::getInstance()->getEmbedPlayers([
            'id_video_embed' => $id_video_embed
            ,'first_only' => true
        ]);
        assign('embed_player_line', $embed_player_line);

        $data = [];
        $data['html'] = getTemplate('/blocks/embed_players_line.html');
        $success = true;
        break;
}

echo json_encode([
    'success' => $success,
    'data'    => $data,
    'msg'     => getTemplateMsg()
]);
die();