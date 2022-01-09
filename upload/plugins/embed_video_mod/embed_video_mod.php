<?php
global $Cbucket;

$Cbucket->upload_opt_list['embed_code_div'] = array(
    'title' => 'Embed Code',
    'load_func' => 'load_embed_form',
);

if (!function_exists('validate_embed_code'))
{
    /**
     * Function used create duration from input
     * @param int DURATION
     */
    if (!function_exists('validate_duration'))
    {
        function validate_duration($time)
        {
            if (empty($time)){
                return true;
            }
            $time = explode(':', $time);
            if (count($time) > 0 && is_array($time))
            {
                $total = count($time);

                if ($total == 3)
                {
                    $hrs = $time[0] * 60 * 60;
                    $mins = $time[1] * 60;
                    $secs = $time[2];
                } elseif ($total == 2) {
                    $hrs = 0;
                    $mins = $time[0] * 60;
                    $secs = $time[1];
                } else {
                    $hrs = 0;
                    $mins = 0;
                    $secs = $time[0];
                }
                $sec = $hrs + $mins + $secs;
                if (!empty($sec)){
                    return $sec;
                }
                e(lang('invalid_duration'));
            } else {
                if (is_numeric($time)){
                    return $time;
                }
                e(lang('invalid_duration'));
            }
        }
    }

    /**
     * Function used to validate embed code
     */
    function validate_embed_code($val)
    {
        // This is the culprit
        if (empty($val) || $val == 'none'){
            return 'none';
        }
        return $val;
    }

    /**
     * Function used to load embed form
     */
    function load_embed_form($params)
    {
        global $file_name;
        if ($params['class']){
            $class = ' ' . $params['class'];
        }
        assign('objId', RandomString(5));
        assign('class', $class);
        Template(PLUG_DIR . '/embed_video_mod/form.html', false);
    }

    $embed_field_array['embed_code'] = array(
        'title' => 'Embed Code',
        'name' => 'embed_code',
        'db_field' => 'embed_code',
        'required' => 'no',
        'validate_function' => 'validate_embed_code',
        'use_func_val' => true,
        'clean_func' => array('clean_embed_code'),
        'type' => 'textarea',
        'use_if_value' => true,
        'hint_2' => 'Type "none" to set as empty',
        'size' => '45',
        'rows' => 5
    );

    $embed_field_array['duration'] = array(
        'title' => 'Video duration',
        'name' => 'duration',
        'db_field' => 'duration',
        'required' => 'no',
        'validate_function' => 'validate_duration',
        'use_func_val' => true,
        'display_admin' => 'no_display',
        'use_if_value' => true,
    );

    $embed_field_array['thumb_file_field'] = array(
        'title' => 'Thumb File',
        'type' => 'fileField',
        'name' => 'thumb_file',
        'required' => 'no',
        'validate_function' => 'upload_thumb',
        'display_admin' => 'no_display',
    );

    function clean_embed_code($input)
    {
        $input = htmlspecialchars($input);
        return $input;
    }

    /**
     * Function used to check embed video
     * if video is embeded , it will check its code 
     * if everthing goes ok , it will change its status to successfull
     * @param array VID
     */
    function embed_video_check($vid)
    {
        global $myquery, $db;
        if (is_array($vid)){
            $vdetails = $vid;
        } else {
            $vdetails = $myquery->get_video_details($vid);
        }

        if (!empty($vdetails['embed_code']) && $vdetails['embed_code'] != ' ' && $vdetails['embed_code'] != 'none') {
            //Parsing Emebd Codek, Getting Referal URL if possible and add AUTPLAY on of option 
            $ref_url = get_refer_url_from_embed_code(unhtmlentities(stripslashes($vdetails['embed_code'])));
            $ref_url = $ref_url['url'];
            $db->update(tbl("video"), array("status", "refer_url"), array('Successful', $ref_url), " videoid='$vid'");
        }
    }

    /**
     * Function used to play embed code
     *
     * @param array Video details
     *
     * @return bool|string
     */
    function play_embed_video($data)
    {
        global $swfobj;
        $vdetails = $data['vdetails'];
        $file = get_video_file($vdetails, false, false);
        if (!$file || $file == 'no_video.mp4') {
            if (!empty($vdetails['embed_code']) && $vdetails['embed_code'] != 'none') {
                $iframe = $vdetails['embed_code'];
                $iframe = str_replace('height=', 'height="'.$data['height'].'"', $iframe);
                $iframe = str_replace('width=', 'width="'.$data['width'].'"', $iframe);
                $embed_code = $iframe;
                $embed_code = unhtmlentities($embed_code);

                $swfobj->EmbedCode($embed_code,$data['player_div']);
                return $swfobj->code;
            }
        }
        return false;
    }

    /**
     * Function used to get refer url from youtube embed code
     */
    function get_refer_url_from_embed_code($code)
    {
        //ONLY POSSIBLE WITH YOUTUBE , MORE WILL BE ADDED LATER
        preg_match("/src=\"(.*)\"/Ui", $code, $matches);
        $src = $matches[1];
        //Checking for youtube
        preg_match("/youtube\.com/", $src, $ytcom);
        preg_match("/youtube-nocookie\.com/", $src, $ytnccom);

        if (!empty($ytcom[0]) || !empty($ytnccom[0])) {
            preg_match("/\/v\/([a-zA-Z0-9_-]+)/", $src, $srcs);
            $srcs = explode("&", $srcs[1]);
            $ytcode = $srcs[0];
            if (!$ytcode) {
                preg_match("/\/embed\/(.*)/", $src, $srcs);
                $srcs = explode("&", $srcs[1]);
                $ytcode = $srcs[0];
            }
            //Creating Youtube VIdeo URL 
            $yturl = "http://www.youtube.com/watch?v=" . $ytcode;
            $results['url'] = $yturl;
            $results['ytcode'] = $ytcode;
            $results['website'] = 'youtube';
            return $results;
        }
        return false;
    }

    //If Youtube
    function is_ref_youtube($url)
    {
        preg_match("/youtube\.com/", $url, $ytcom);
        return $ytcom;
    }

    register_after_video_upload_action('embed_video_check');
    register_custom_upload_field($embed_field_array);
    $Cbucket->add_header(PLUG_DIR . '/embed_video_mod/header.html');
    register_actions_play_video('play_embed_video');
}
