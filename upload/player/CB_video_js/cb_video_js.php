<?php
/*
	Player Name: VideoJS
	Description: Official CBV5 player
	Author: Oxygenz
    Author Website: https://clipbucket.oxygenz.fr/
	Version: 2.0.7
    Released: 2024-12-12
    Website: https://github.com/MacWarrior/clipbucket-v5
 */

class CB_video_js
{
    /**
     * @throws Exception
     */
    private function load_dependancies()
    {
        $player_name = self::class;

        $min_suffixe = in_dev() ? '' : '.min';
        ClipBucket::getInstance()->addAllJS([
            $player_name.'/js/video'.$min_suffixe.'.js' => 'player'
            ,$player_name.'/lang/'.get_current_language().'.js' => 'player'
            ,$player_name.'/plugin/clipbucket/videojs-clipbucket'.$min_suffixe.'.js' => 'player'
            ,$player_name.'/plugin/playinline/iphone-inline-video'.$min_suffixe.'.js' => 'player'
            ,$player_name.'/plugin/resolution/videojs-resolution'.$min_suffixe.'.js' => 'player'
            ,$player_name.'/plugin/hls-quality-selector/videojs-hls-quality-selector'.$min_suffixe.'.js' => 'player'
        ]);

        ClipBucket::getInstance()->addAllCSS([
            $player_name.'/css/video-js'.$min_suffixe.'.css' => 'player'
            ,$player_name.'/plugin/clipbucket/videojs-clipbucket'.$min_suffixe.'.css' => 'player'
            ,$player_name.'/plugin/resolution/videojs-resolution'.$min_suffixe.'.css' => 'player'
        ]);

        if( config('chromecast') == 'yes' ){
            ClipBucket::getInstance()->addAllJS([
                $player_name.'/plugin/chromecast/cast_sender.js' => 'player'
                ,$player_name.'/plugin/chromecast/videojs-chromecast'.$min_suffixe.'.js' => 'player'
            ]);
            ClipBucket::getInstance()->addAllCSS([$player_name.'/plugin/chromecast/videojs-chromecast'.$min_suffixe.'.css' => 'player']);
        }

        if( config('player_thumbnails') == 'yes' ){
            ClipBucket::getInstance()->addAllJS([$player_name.'/plugin/thumbnails/videojs-thumbnails'.$min_suffixe.'.js' => 'player']);
            ClipBucket::getInstance()->addAllCSS([$player_name.'/plugin/thumbnails/videojs-thumbnails'.$min_suffixe.'.css' => 'player']);
        }

        if( config('enable_advertisement') == 'yes' ){
            ClipBucket::getInstance()->addAllJS([
                $player_name.'/plugin/ads/videojs-contrib-ads'.$min_suffixe.'.js' => 'player'
                ,$player_name.'/plugin/ads/videojs.ads'.$min_suffixe.'.js' => 'player'
                ,$player_name.'/plugin/ads/videojs.ima.js' => 'player'
            ]);

            ClipBucket::getInstance()->addAllCSS([
                $player_name.'/plugin/ads/videojs.ads'.$min_suffixe.'.css' => 'player'
                ,$player_name.'/plugin/clipbucket/videojs-clipbucket'.$min_suffixe.'.css' => 'player'
                ,$player_name.'/plugin/resolution/videojs-resolution'.$min_suffixe.'.css' => 'player'
                ,$player_name.'/plugin/ads/videojs.ima.css' => 'player'
            ]);

        }
    }

    private function register_actions_play_video()
    {
        register_actions_play_video('load_player', self::class);
    }

    /**
     * @throws Exception
     */
    public static function load_player($data): bool
    {
        $vdetails = $data['vdetails'];

        assign('video_files', Video::getInstance($vdetails['videoid'])->getQualityLinks('stream'));

        assign('vdata',$vdetails);
        assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
        Template(DirPath::get('player') . self::class .DIRECTORY_SEPARATOR . 'cb_video_js.html',false);
        return true;
    }

    public static function getVideoQualityFromFilePath($filepath): string
    {
        $quality = explode('-', basename($filepath));
        $quality = explode('.',end($quality));
        return $quality[0];
    }

    /**
     * @throws Exception
     */
    public static function getVideoResolutionTitleFromFilePath($filepath): string
    {
        global $myquery;
        $quality = self::getVideoQualityFromFilePath($filepath);
        return $myquery->getVideoResolutionTitleFromHeight($quality);
    }

    /**
     * @throws Exception
     * @used-by cb_video_js.html
     */
    public static function getDefaultVideo(array $video_files)
    {
        if( empty($video_files) ){
            return false;
        }

        $player_default_resolution = myquery::getinstance()->getVideoResolutionTitleFromHeight(config('player_default_resolution'));

        if( isset($video_files[$player_default_resolution]) ){
            return $player_default_resolution;
        }

        return 'high';
    }

    /**
     * @throws Exception
     */
    function __construct(){
        $this->load_dependancies();
        $this->register_actions_play_video();
    }
}

new CB_video_js();
