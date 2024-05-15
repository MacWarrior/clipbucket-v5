<?php

class Tmdb
{
    const API_URL = 'https://api.themoviedb.org/3/';

    const IMAGE_URL = 'https://image.tmdb.org/t/p/original';

    const MIN_VERSION = '5.5.0';
    const MIN_REVISION = '371';

    CONST MIN_VERSION_IS_ADULT = '5.5.1';
    CONST MIN_REVISION_IS_ADULT = '20';

    private $curl;
    private static $instance;

    private $language = '';

    /**
     * @param \Classes\Curl $curl
     * @return void
     * @throws Exception
     */
    public function init(\Classes\Curl $curl)
    {
        $this->curl = $curl;
        $return = $this->curl->exec('authentication');
        $response = $return['response'];
        if (!empty($return['error']) || !$response['success']) {
            throw new \Exception($response['status_message']);
        }
    }

    /**
     * @throws Exception
     */
    public static function getInstance(): Tmdb
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->init(new \Classes\Curl(self::API_URL, config('tmdb_token')));
            self::$instance->setLanguage(Language::getInstance()->lang);
            return self::$instance;
        }
        return self::$instance;
    }

    public function searchMovie($search, $page = 1)
    {
        return $this->requestAPI('search/movie', [
            'query' => $search,
            'page'  => $page
        ]);
    }

    public function movieDetail($movie_id)
    {
        return $this->requestAPI('movie/' . $movie_id);
    }

    public function movieCredits($movie_id)
    {
        return $this->requestAPI('movie/' . $movie_id . '/credits');
    }

    public function movieCurrentLanguageAgeRestriction($movie_id)
    {
        $results = $this->requestAPI('movie/' . $movie_id . '/release_dates')['response']['results'];
        $restriction = array_search(strtoupper($this->language), array_column($results, 'iso_3166_1'));
        if ($restriction !== false) {
            return (!empty($results[$restriction]['release_dates'][0]['certification']) ? $results[$restriction]['release_dates'][0]['certification'] : 0);
        }
        return 0;
    }

    public function moviePosterBackdrops($movie_id)
    {
        return $this->requestAPI('movie/' . $movie_id . '/images', ['include_image_language' => $this->language . ',null']);
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function requestAPI($url, $param = [])
    {
        if (empty($param['language'])) {
            $param['language'] = $this->language;
        }
        $param['include_adult'] = config('enable_tmdb_mature_content') == 'yes' ? 'true' : 'false';
        return $this->curl->exec($url, $param);
    }

    /**
     * @param string $query
     * @param string $sort
     * @param string $sort_order
     * @param string $limit
     * @return array|int
     * @throws Exception
     */
    public function getCacheFromQuery(string $query, string $sort = 'release_date', string $sort_order = 'DESC', string $limit = '1', bool $count = false)
    {
        $search_adult = '';
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo(Tmdb::MIN_VERSION_IS_ADULT, Tmdb::MIN_REVISION_IS_ADULT)) {
            if (config('enable_tmdb_mature_content') !== 'yes') {
                $search_adult = ' AND is_adult = FALSE';
            }
        }
        $sql_limit = '';
        if (!empty($limit)) {
            $sql_limit = 'LIMIT ' . create_query_limit($limit, config('tmdb_search'));
        }

        $sql = 'SELECT TSR.* 
                FROM ' . tbl('tmdb_search') . ' TS
                INNER JOIN ' . tbl('tmdb_search_result') . ' TSR ON TS.id_tmdb_search = TSR.id_tmdb_search
                WHERE search_key = \'' . mysql_clean(strtolower($query)) . '\' '. $search_adult . '
                ORDER BY ' . mysql_clean($sort) . ' ' . mysql_clean($sort_order) . '
                '.$sql_limit
                ;
        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($count) {
            return count($result);
        }
        return $result;
    }

    /**
     * @param string $query
     * @return array|null
     * @throws Exception
     */
    public function getSearchInfo(string $query)
    {
        $sql = 'SELECT * 
                FROM ' . tbl('tmdb_search') . ' TS
                WHERE search_key = \'' . mysql_clean(strtolower($query)) . '\' ';
        return Clipbucket_db::getInstance()->_select($sql);
    }

    /**
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function deleteOldCacheEntries()
    {
        return Clipbucket_db::getInstance()->execute(
            'DELETE FROM ' . tbl('tmdb_search') . ' WHERE datetime_search < DATE_SUB(NOW(), INTERVAL 1 HOUR)'
            , 'delete');
    }

    /**
     * @param string $query
     * @param array $results
     * @param int $total_results
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function setQueryInCache(string $query, array $results, int $total_results)
    {
        Clipbucket_db::getInstance()->insert(tbl('tmdb_search'), ['search_key', 'total_results'], [strtolower($query), $total_results]);
        $id_tmdb_search = Clipbucket_db::getInstance()->insert_id();

        $can_is_adult = false;
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo(Tmdb::MIN_VERSION_IS_ADULT, Tmdb::MIN_REVISION_IS_ADULT)) {
            $can_is_adult = true;
        }

        $sql_insert = 'INSERT INTO ' . tbl('tmdb_search_result') . ' (id_tmdb_search, title, overview,release_date, poster_path, id_tmdb_movie '.($can_is_adult ? ', is_adult': '' ).') VALUES ';
        $insert_line = [];
        foreach ($results as $result) {
            $insert_line[] = ' (' . $id_tmdb_search . ', \'' . mysql_clean($result['title']) . '\'
            , \'' . mysql_clean($result['overview']) . '\'
            , ' . (empty($result['release_date']) ? 'null' : '\'' . mysql_clean($result['release_date']) . '\'') . '
            , \'' . mysql_clean($result['poster_path']) . '\', ' . mysql_clean($result['id'])
            . ($can_is_adult ? ', '. ($result['adult'] ? 'true' : 'false')  : '')
            . ') ';
        }
        $sql_insert .= implode(', ', $insert_line);
        return Clipbucket_db::getInstance()->execute($sql_insert);
    }

    /**
     * @param int $videoid
     * @param int $tmdb_id
     * @return void
     * @throws Exception
     */
    public function importDataFromTmdb(int $videoid, int $tmdb_id)
    {
        $video_info = Video::getInstance()->getOne([
            'videoid' => $videoid
        ]);
        if (empty($video_info)) {
            e(lang('class_vdo_del_err'));
        }
        $movie_credits = Tmdb::getInstance()->movieCredits($tmdb_id)['response'];
        $movie_details = Tmdb::getInstance()->movieDetail($tmdb_id)['response'];

        $update_video = false;

        $video_info['datecreated'] = $movie_details['release_date'];
        if( config('tmdb_get_title') == 'yes' && !empty($movie_details['title']) ) {
            $video_info['title'] = $movie_details['title'];
            $update_video = true;
        }
        if( config('tmdb_get_description') == 'yes' && !empty($movie_details['overview']) ) {
            $video_info['description'] = $movie_details['overview'];
            $update_video = true;
        }
        if( config('tmdb_get_age_restriction') == 'yes' ) {
            $movie_credentials = Tmdb::getInstance()->movieCurrentLanguageAgeRestriction($tmdb_id);
            $video_info['age_restriction'] = $movie_credentials;
            if (!$movie_credentials && config('enable_tmdb_mature_content') == 'yes' && $movie_details['adult']) {
                $video_info['age_restriction'] = config('tmdb_mature_content_age');
            }
            $update_video = true;
        }
        if( $update_video ) {
            CBvideo::getInstance()->update_video($video_info);
        }

        if( config('tmdb_get_poster') == 'yes'  && config('enable_video_poster') == 'yes' ){
            Video::getInstance()->deletePictures($video_info, 'poster');
            $movie_posters = Tmdb::getInstance()->moviePosterBackdrops($tmdb_id)['response']['posters'];
            foreach ($movie_posters as $movie_poster) {
                $path_without_slash = str_replace('/','', $movie_poster['file_path']);
                $url = Tmdb::IMAGE_URL . $movie_poster['file_path'];
                $tmp_path = DirPath::get('temp') . $path_without_slash;
                $resutl = file_put_contents($tmp_path, file_get_contents($url));
                Upload::getInstance()->upload_thumbs($video_info['file_name'], [
                    'tmp_name' => [$tmp_path],
                    'name'     => [$path_without_slash],
                ],  $video_info['file_directory'], 'p');
            }

            if( empty(errorhandler::getInstance()->get_error()) ){
                errorhandler::getInstance()->flush();
            }
        }

        if( config('tmdb_get_backdrop') == 'yes'  && config('enable_video_backdrop') == 'yes' ){
            Video::getInstance()->deletePictures($video_info, 'backdrop');
            $movie_backdrops = Tmdb::getInstance()->moviePosterBackdrops($tmdb_id)['response']['backdrops'];
            foreach ($movie_backdrops as $movie_backdrop) {
                $path_without_slash = str_replace('/','', $movie_backdrop['file_path']);
                $url = Tmdb::IMAGE_URL . $movie_backdrop['file_path'];
                $tmp_path = DirPath::get('temp') . $path_without_slash;
                $resutl = file_put_contents($tmp_path, file_get_contents($url));
                Upload::getInstance()->upload_thumbs($video_info['file_name'], [
                    'tmp_name' => [$tmp_path],
                    'name'     => [$path_without_slash],
                ],  $video_info['file_directory'], 'b');
            }

            if( empty(errorhandler::getInstance()->get_error()) ){
                errorhandler::getInstance()->flush();
            }
        }

        if( config('tmdb_get_genre') == 'yes' && config('enable_video_genre') == 'yes' ) {
            $genre_tags = [];
            foreach ($movie_details['genres'] as $genre) {
                $genre_tags[] = trim($genre['name']);
            }
            Tags::saveTags(implode(',', $genre_tags), 'genre', $_POST['videoid']);
        }

        if( config('tmdb_get_actors') == 'yes' && config('enable_video_actor') == 'yes' ) {
            $actors_tags = [];
            foreach ($movie_credits['cast'] as $actor) {
                $actors_tags[] = trim($actor['name']);
                Tags::saveTags(implode(',', $actors_tags), 'actors', $_POST['videoid']);
            }
        }

        $producer_tags = [];
        $executive_producer_tags = [];
        $director_tags = [];
        $crew_tags = [];
        foreach ($movie_credits['crew'] as $crew) {
            switch (strtolower($crew['job'])) {
                case 'producer':
                    $producer_tags[] = trim($crew['name']);
                    break;
                case 'executive producer':
                    $executive_producer_tags[] = trim($crew['name']);
                    break;
                case 'director':
                case 'co-director':
                    $director_tags[] = trim($crew['name']);
                    break;
                default:
                    $crew_tags[] = trim($crew['name']);
                    break;
            }
        }

        if( config('tmdb_get_producer') == 'yes' && config('enable_video_producer') == 'yes' ) {
            Tags::saveTags(implode(',', $producer_tags), 'producer', $_POST['videoid']);
        }

        if( config('tmdb_get_executive_producer') == 'yes' && config('enable_video_executive_producer') == 'yes' ) {
            Tags::saveTags(implode(',', $executive_producer_tags), 'executive_producer', $_POST['videoid']);
        }

        if( config('tmdb_get_director') == 'yes' && config('enable_video_director') == 'yes' ) {
            Tags::saveTags(implode(',', $director_tags), 'director', $_POST['videoid']);
        }

        if( config('tmdb_get_crew') == 'yes' && config('enable_video_crew') == 'yes' ) {
            Tags::saveTags(implode(',', $crew_tags), 'crew', $_POST['videoid']);
        }
    }

    public function getInfoTmdb($videoid, $params, string $fileName= '')
    {
        $video_info = Video::getInstance()->getOne([
            'videoid' => $videoid
        ]);
        if (empty($video_info)) {
            $video_info = Video::getInstance()->getOne([
                'file_name' => $fileName
            ]);
        }
        if (empty($video_info)) {
            e(lang('class_vdo_del_err'));
        }
        self::getInstance()->deleteOldCacheEntries();
        $title = !empty($params['video_title']) ? $params['video_title'] : $video_info['title'];
        $sort = empty($params['sort']) ? 'release_date' : $params['sort'];
        $sort_order = empty($params['sort_order']) ? 'DESC' : $params['sort_order'];

        $total_rows = 0;
        $cache_results = Tmdb::getInstance()->getSearchInfo($title);
        if (!empty($cache_results)) {
            $total_rows = $cache_results[0]['total_results'];
        } else {
            $tmdb_results = [];
            $page_tmdb = 1;
            do {
                $results = Tmdb::getInstance()->searchMovie($title, $page_tmdb)['response'];
                $total_rows = $results['total_results'];
                $tmdb_results = array_merge($tmdb_results, $results['results']);
                $page_tmdb++;
                if (!empty($results['error'])) {
                    e(lang($results['error']));
                    break;
                }
            } while (!empty($results['results']));

            if (!empty($tmdb_results)) {
                try {
                    Tmdb::getInstance()->setQueryInCache($title, $tmdb_results, $total_rows);
                } catch (Exception $e) {
                    e($e->getMessage());
                }
            }
        }
        $final_results = Tmdb::getInstance()->getCacheFromQuery($title, $sort, $sort_order, $_POST['page']);
        //use different sql to get numbers of rows
        $total_rows = Tmdb::getInstance()->getCacheFromQuery($title, $sort, $sort_order, 0, true);
        $total_pages = count_pages($total_rows, config('tmdb_search'));
        return [
            'final_results' => $final_results,
            'total_pages'   => $total_pages,
            'title'         => $title,
            'sort_order'    => $sort_order,
            'videoid'       => $video_info['videoid']
        ];
    }
}
