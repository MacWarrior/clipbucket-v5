<?php
/**
* Function used to display flash player for ClipBucket video
* 
* @param : { array } { $param } { an array of parameters }
*/

function flashPlayer($param)
{
    global $Cbucket;
    global $pak_player;
    $param['player_div'] = $param['player_div'] ? $param['player_div'] : 'videoPlayer';
    $height     = $param['height'] ? $param['height'] : config('player_height');
    $width      = $param['width'] ? $param['width'] : config('player_width');
    $param['height'] = $height;
    $param['width'] = $width ;
    if(!$param['autoplay']) {
        $param['autoplay'] = config('autoplay_video');
    }
    assign('player_params',$param);
    if(count($Cbucket->actions_play_video)>0) {
        foreach($Cbucket->actions_play_video as $funcs) {
            if(function_exists($funcs)) {
                $func_data = $funcs($param);
            }
            if($func_data) {
                $player_code = $func_data;
                $show_player  = true;
                break;
            }
        }
    }

    if($player_code) {
        if(!$pak_player && $show_player && !is_bool($player_code)) {
            assign('player_js_code',$player_code);
            Template(PLAYER_DIR.'/player.html',false);
            return false;
        }
        return false;
    }

    return blank_screen($param);
}

/**
 * Function used to display
 * Blank Screen
 * if there is nothing to play or to show
 * then show a blank screen
 */
function blank_screen($data)
{
    global $swfobj;
    $code = '<div class="blank_screen" align="center">No Player or Video File Found - Unable to Play Any Video</div>';
    $swfobj->EmbedCode(unhtmlentities($code),$data['player_div']);
    return $swfobj->code;
}
