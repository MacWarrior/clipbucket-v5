<?php
	/**
	 * Function used to get config value of ClipBucket
	 * @uses: { class : Cbucket } { var : configs }
	 *
	 * @param $input
	 *
	 * @return bool|string
	 */
    function config($input)
	{
        global $Cbucket;

        if( isset($Cbucket->configs[$input]) ){
        	return $Cbucket->configs[$input];
        }

		if( in_dev() ){
			error_log('Missing config : '.$input);
        }
		return false;
    }

    /**
     * Function used to get player logo
     */
    function website_logo(): string
    {
        $logo_file = config('player_logo_file');
        if($logo_file && file_exists(BASEDIR.'/images/'.$logo_file)){
            return '/images/'.$logo_file;
        }
        return '/images/logo.png';
    }

	/**
	 * createDataFolders()
	 *
	 * create date folders with respect to date. so that no folder gets overloaded
	 * with number of files.
	 *
	 * @param null $headFolder
	 * @param null $custom_date
	 *
	 * @return string
	 * @internal param FOLDER $string , if set to null, sub-date-folders will be created in
	 * all data folders
	 */
    function createDataFolders($headFolder = NULL, $custom_date = NULL)
    {
        $time = time();

        if ($custom_date)
        {
            if(!is_numeric($custom_date)){
                $time = strtotime($custom_date);
            } else {
                $time = $custom_date;
            }
        }

        $folder = date('Y/m/d', $time);

        $data = cb_call_functions('dated_folder');
        if($data){
            return $data;
        }

        if(!$headFolder)
        {
            @mkdir(VIDEOS_DIR . DIRECTORY_SEPARATOR . $folder, 0777, true);
            @mkdir(THUMBS_DIR . DIRECTORY_SEPARATOR . $folder, 0777, true);
            @mkdir(ORIGINAL_DIR . DIRECTORY_SEPARATOR . $folder, 0777, true);
            @mkdir(PHOTOS_DIR . DIRECTORY_SEPARATOR . $folder, 0777, true);
            @mkdir(LOGS_DIR . DIRECTORY_SEPARATOR . $folder, 0777, true);
			@mkdir(AUDIOS_DIR . DIRECTORY_SEPARATOR . $folder, 0777, true);
        } else if (!file_exists($headFolder . DIRECTORY_SEPARATOR . $folder)) {
			@mkdir($headFolder . DIRECTORY_SEPARATOR . $folder, 0777, true);
		}

        return apply_filters($folder, 'dated_folder');
    }

    function create_dated_folder($headFolder = NULL, $custom_date = NULL)
    {
        return createDataFolders($headFolder, $custom_date);
    }

    function cb_create_html_tag($tag = 'p', $self_closing = false, $attrs = array(), $content = null): string
    {
        $open = '<'.$tag;
        $close = ( $self_closing === true ) ? '/>' : '>'.( !is_null( $content ) ? $content : '' ).'</'.$tag.'>';

        $attributes = '';

        if( is_array( $attrs ) and count( $attrs ) > 0 )
        {
            foreach( $attrs as $attr => $value )
            {
                if( strtolower( $attr ) == 'extra' ) {
                    $attributes .= ( $value );
                } else {
                    $attributes .= ' '.$attr.' = "'.$value.'" ';
                }

            }

        }
        return $open.$attributes.$close;
    }

	/**
	 * Pulls categories without needing any parameters
	 * making it easy to use in smarty. Decides type using page
	 *
	 * @param bool $page
	 *
	 * @return array|bool : { array } { $all_cats } { array with all details of all categories }
	 * @since : March 22nd, 2016 ClipBucket 2.8.1
	 * @author : Saqib Razzaq
	 */
    function pullCategories($page = false)
	{
        global $cbvid, $userquery, $cbphoto;
        $params = array();
        if (!$page) {
            $page = THIS_PAGE;
        }

        switch ($page) {
            case 'photos':
                $all_cats = $cbphoto->cbCategories($params);
                break;

            case 'channels':
                $all_cats = $userquery->cbCategories($params);
                break;

            case 'videos':
            default:
                $all_cats = $cbvid->cbCategories($params);
                break;
        }

        if (is_array($all_cats)){
            return $all_cats;
        }
		return false;
    }

	/**
	 * Takes a number and returns more human friendly format of it e.g 1000 == 1K
	 *
	 * @param : { integer } { $num } { number to convert to pretty number}
	 *
	 * @return bool|float|int|mixed|string : { integer } { $kviews } { pretty number after processing }
	 * @since : 24th March, 2016 ClipBucket 2.8.1
	 * @author : Saqib Razzaq
	 */
    function prettyNum($num)
	{
        $prettyNum = preg_replace("/[^0-9\.]/", '', $num);
        if ($prettyNum >= 1000 && $prettyNum < 1000000) {
            $kviews = $prettyNum / 1000;
            if ($prettyNum > 1000) {
                $kviews = round($kviews,0);
            }
            $kviews = $kviews.' K'; // number is in thousands
        } elseif ($prettyNum >= 1000000 && $prettyNum < 1000000000) {
            $kviews = $prettyNum / 1000000;
            $kviews = round($kviews,2);
            $kviews = $kviews.' M'; // number is in millions
        } elseif ($prettyNum >= 1000000000) {
            $kviews = $prettyNum / 1000000000;
            $kviews = round($kviews,2);
            $kviews = $kviews.' B'; // number is in billions
        } elseif ($prettyNum < 1000) {
            return $prettyNum;
        }

        if (!empty($kviews)){
            return $kviews;
        }
		return false;
    }

    /**
    * Handles everything going in ClipBucket development mode
    * @param : { string } { $query } { MySQL query for which to run process }
    * @param : { string } { $query_type } { type of query, select, delete etc }
    * @param : { integer } { $time } { time took to execute query }
    * 
    * @return : { array } { $__devmsgs } { array with all debugging data }
    * @since : 27th May, 2016
    * @author : Saqib Razzaq
    */
    function devWitch($query, $query_type, $time)
	{
        global $__devmsgs;
        $memoryBefore = $__devmsgs['total_memory_used'];
        $memoryNow = memory_get_usage()/1048576;
        $memoryDif = $memoryNow - $memoryBefore;
        $__devmsgs[$query_type.'_queries'][$__devmsgs[$query_type]]['q'] = $query;
        $__devmsgs[$query_type.'_queries'][$__devmsgs[$query_type]]['timetook'] = $time;
        $__devmsgs['total_query_exec_time'] = $__devmsgs['total_query_exec_time'] + $time;
        $__devmsgs[$query_type.'_queries'][$__devmsgs[$query_type]]['memBefore'] = $memoryBefore;
        $__devmsgs[$query_type.'_queries'][$__devmsgs[$query_type]]['memAfter'] = $memoryNow;
        $__devmsgs[$query_type.'_queries'][$__devmsgs[$query_type]]['memUsed'] = $memoryDif;
        $queryDetails = $__devmsgs[$query_type.'_queries'][$__devmsgs[$query_type]];

        $expesiveQuery = $__devmsgs['expensive_query'];
        $cheapestQuery = $__devmsgs['cheapest_query'];
        
        if (empty($expesiveQuery) || empty($cheapestQuery)) {
            $expesiveQuery = $queryDetails;
            $cheapestQuery = $queryDetails;
        } else {
            $memUsed = $queryDetails['memUsed'];
            if ($memUsed > $expesiveQuery['memUsed']) {
                $expesiveQuery = $queryDetails;
            }

            if ($memUsed < $cheapestQuery['memUsed']) {
                $cheapestQuery = $queryDetails;
            }
        }

        $__devmsgs['expensive_query'] = $expesiveQuery;
        $__devmsgs['cheapest_query'] = $cheapestQuery;
        $__devmsgs['total_memory_used'] = $memoryNow;
        $__devmsgs[$query_type] = $__devmsgs[$query_type] + 1;
        $__devmsgs['total_queries'] = $__devmsgs['total_queries'] + 1;

        return $__devmsgs;
    }

    function showDevWitch() {
        $file = BASEDIR.'/styles/global/devmode.html';
        Template($file, false);
    }
