<?php

class Tmdb
{
    const API_URL = 'https://api.themoviedb.org/3/';

    const IMAGE_URL = 'https://image.tmdb.org/t/p/original';

    private $curl;
    private static $instance;

    private static $fields_title = ['movie'=>'title','series'=>'name'];
    private static $fields_date = ['movie'=>'release_date','series'=>'first_air_date'];

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
        if (!empty($return['error']) || $response['success']===false) {
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

    public function searchSeries($search, $page = 1)
    {
        return $this->requestAPI('search/tv', [
            'query' => $search,
            'page'  => $page
        ]);
    }

    public function seriesDetail($serie_id)
    {
        return $this->requestAPI('tv/' . $serie_id);
    }

    public function seriesCredits($serie_id)
    {
        return $this->requestAPI('tv/' . $serie_id . '/credits');
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

    public function seriesCurrentLanguageAgeRestriction($series_id)
    {
        $results = $this->requestAPI('tv/' . $series_id . '/content_ratings')['response']['results'];
        $restriction = array_search(strtoupper($this->language), array_column($results, 'iso_3166_1'));
        if ($restriction !== false) {
            $result = (!empty($results[$restriction]['release_dates']['rating']) ? $results[$restriction]['release_dates']['rating'] : 0);
            if (!is_numeric($result)) {
                $result = preg_replace('\D', '', $result);
            }
            return $result;
        }
        return 0;
    }

    public function moviePosterBackdrops($movie_id)
    {
        return $this->requestAPI('movie/' . $movie_id . '/images', ['language' => '']);
    }
    public function seriesPosterBackdrops($serie_id)
    {
        return $this->requestAPI('tv/' . $serie_id . '/images', ['language' => '']);
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function requestAPI($url, $param = [])
    {
        if (!isset($param['language'])) {
            $param['language'] = $this->language;
        }
        $param['include_adult'] = config('enable_tmdb_mature_content') == 'yes' ? 'true' : 'false';
        return $this->curl->exec($url, $param);
    }

    /**
     * Suppression du type dans la déclaration pour permettre la valeur par défaut
     * à partir de la version 7.1 de PHP => mettre ?type devant les paramètres
     * @param string $query
     * @param string $type
     * @param string $sort
     * @param string $sort_order
     * @param string $limit
     * @param bool $count
     * @param string $year
     * @return array|int
     * @throws Exception
     */
    public function getCacheFromQuery(string $query,  $type = 'movie',  $sort = 'release_date',  $sort_order = 'DESC', $limit = '1',  $count = false,  $year = '0000')
    {
        $search_adult = '';
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '20')) {
            if (config('enable_tmdb_mature_content') !== 'yes') {
                $search_adult = ' AND is_adult = FALSE';
            }
        }
        $sql_limit = '';
        if (!empty($limit)) {
            $sql_limit = 'LIMIT ' . create_query_limit($limit, config('tmdb_search'));
        }

        $sql_year = '';
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '106') && ($year != '0000' && !empty($year))) {
            $sql_year = ' AND YEAR(`release_date`) = ' . mysql_clean($year);
        }
        $sql_type = '';

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '194')) {
            $sql_type = 'AND type = \'' . mysql_clean($type) . '\' 
            AND language = \'' . $this->language. '\'';
        }
        $sql = 'SELECT TSR.* 
                FROM ' . tbl('tmdb_search') . ' TS
                INNER JOIN ' . tbl('tmdb_search_result') . ' TSR ON TS.id_tmdb_search = TSR.id_tmdb_search
                WHERE search_key = \'' . mysql_clean(strtolower($query)) . '\' ' . $search_adult . ' 
                ' . $sql_type . '
                ' . $sql_year . '
                ORDER BY ' . mysql_clean($sort) . ' ' . mysql_clean($sort_order) . '
                ' . $sql_limit;
        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($count) {
            return count($result);
        }
        return $result;
    }

    /**
     * @param string $query
     * @param string $type
     * @return array|null
     * @throws Exception
     */
    public function getSearchInfo(string $query, $type = 'movie')
    {
        $sql = 'SELECT * 
                FROM ' . tbl('tmdb_search') . ' TS
                WHERE search_key = \'' . mysql_clean(strtolower($query)) . '\' ';

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '194')) {
            $sql .= ' AND type = \''.mysql_clean($type).'\'
                AND language = \'' . $this->language. '\'';
        }
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
     * @param string $type
     * @param array $results
     * @param int $total_results
     * @param array $years
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function setQueryInCache(string $query, string $type, array $results, int $total_results, array $years)
    {
        $fields = [
            'search_key',
            'total_results'
        ];
        $values = [
            strtolower($query),
            $total_results
        ];
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '106')) {
            $fields[] = 'list_years';
            $values[] = json_encode($years);
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '194')) {
            $fields[] = 'type';
            $values[] = $type;
            $fields[] = 'language';
            $values[] = $this->language;
        }
        Clipbucket_db::getInstance()->insert(tbl('tmdb_search'), $fields, $values);
        $id_tmdb_search = Clipbucket_db::getInstance()->insert_id();

        $can_is_adult = false;
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '20')) {
            $can_is_adult = true;
        }

        $sql_insert = 'INSERT INTO ' . tbl('tmdb_search_result') . ' (id_tmdb_search, title, overview,release_date, poster_path, id_tmdb_movie ' . ($can_is_adult ? ', is_adult' : '') . ') VALUES ';
        $insert_line = [];
        foreach ($results as $result) {
            $insert_line[] = ' (' . $id_tmdb_search . ', \'' . mysql_clean($result[self::$fields_title[$type]]) . '\'
            , \'' . mysql_clean($result['overview']) . '\'
            , ' . (empty($result[self::$fields_date[$type]]) ? 'null' : '\'' . mysql_clean($result[self::$fields_date[$type]]) . '\'') . '
            , \'' . mysql_clean($result['poster_path']) . '\', ' . mysql_clean($result['id'])
                . ($can_is_adult ? ', ' . ($result['adult'] ? 'true' : 'false') : '')
                . ') ';
        }
        $sql_insert .= implode(', ', $insert_line);
        return Clipbucket_db::getInstance()->execute($sql_insert);
    }

    /**
     * @param int $videoid
     * @param int $tmdb_id
     * @param string $type
     * @return void
     * @throws Exception
     */
    public function importDataFromTmdb(int $videoid, int $tmdb_id, $type = 'movie')
    {
        $video_info = Video::getInstance()->getOne([
            'videoid' => $videoid
        ]);
        if (empty($video_info)) {
            e(lang('class_vdo_del_err'));
        }

        switch ($type) {
            default:
                $type = 'movie';
            case 'movie':
                $credits = $this->movieCredits($tmdb_id)['response'];
                $details = $this->movieDetail($tmdb_id)['response'];
                break;
            case 'series':
                $credits = $this->seriesCredits($tmdb_id)['response'];
                $details = $this->seriesDetail($tmdb_id)['response'];
                break;
        }

        $update_video = false;

        $video_info['datecreated'] = $details[self::$fields_date[$type]];
        if (config('tmdb_get_title') == 'yes' && !empty($details[self::$fields_title[$type]])) {
            $video_info['title'] = $details[self::$fields_title[$type]];
            $update_video = true;
        }
        if (config('tmdb_get_description') == 'yes' && !empty($details['overview'])) {
            $video_info['description'] = $details['overview'];
            $update_video = true;
        }
        if (config('tmdb_get_age_restriction') == 'yes') {
            switch ($type) {
                case 'movie':
                default:
                    $credentials = $this->movieCurrentLanguageAgeRestriction($tmdb_id);
                    break;
                case 'series':
                    $credentials = $this->seriesCurrentLanguageAgeRestriction($tmdb_id);
                    break;
            }
            $video_info['age_restriction'] = $credentials;
            if (!$credentials && config('enable_tmdb_mature_content') == 'yes' && $details['adult']) {
                $video_info['age_restriction'] = config('tmdb_mature_content_age');
            }
            $update_video = true;
        }
        if ($update_video) {
            CBvideo::getInstance()->update_video($video_info);
        }

        if (config('tmdb_get_poster') == 'yes' && config('enable_video_poster') == 'yes') {
            Video::getInstance()->dropPictures($video_info, 'poster');

            switch ($type) {
                case 'movie':
                default:
                    $posters = $this->moviePosterBackdrops($tmdb_id)['response']['posters'];
                    break;
                case 'series':
                    $posters = $this->seriesPosterBackdrops($tmdb_id)['response']['posters'];
                    break;
            }

            $language_posters = array_filter($posters, function ($elem) {
                return $elem['iso_639_1'] == $this->language || $elem['iso_639_1'] == 'null';
            });
            if (count($language_posters) > 0) {
                $poster_iterate = $language_posters;
            } else {
                $poster_iterate = $posters;
            }
            foreach ($poster_iterate as $poster) {
                $path_without_slash = str_replace('/', '', $poster['file_path']);
                $url = self::IMAGE_URL . $poster['file_path'];
                $tmp_path = DirPath::get('temp') . $path_without_slash;
                file_put_contents($tmp_path, file_get_contents($url));
                Upload::getInstance()->upload_thumbs($video_info['file_name'], [
                    'tmp_name' => [$tmp_path],
                    'name'     => [$path_without_slash],
                ], $video_info['file_directory'], 'p');
            }

            if (empty(errorhandler::getInstance()->get_error())) {
                errorhandler::getInstance()->flush();
            }
        }

        if (config('tmdb_get_backdrop') == 'yes' && config('enable_video_backdrop') == 'yes') {
            Video::getInstance()->dropPictures($video_info, 'backdrop');

            switch ($type) {
                case 'movie':
                default:
                    $backdrops = $this->moviePosterBackdrops($tmdb_id)['response']['backdrops'];
                    break;
                case 'series':
                    $backdrops = $this->seriesPosterBackdrops($tmdb_id)['response']['backdrops'];
                    break;
            }

            $language_backdrops = array_filter($backdrops, function ($elem) {
                return $elem['iso_639_1'] == $this->language || $elem['iso_639_1'] == 'null';
            });
            if (count($language_backdrops) > 0) {
                $backdrop_iterate = $language_backdrops;
            } else {
                $backdrop_iterate = $backdrops;
            }
            foreach ($backdrop_iterate as $backdrop) {
                $path_without_slash = str_replace('/', '', $backdrop['file_path']);
                $url = self::IMAGE_URL . $backdrop['file_path'];
                $tmp_path = DirPath::get('temp') . $path_without_slash;
                file_put_contents($tmp_path, file_get_contents($url));
                Upload::getInstance()->upload_thumbs($video_info['file_name'], [
                    'tmp_name' => [$tmp_path],
                    'name'     => [$path_without_slash],
                ], $video_info['file_directory'], 'b');
            }

            if (empty(errorhandler::getInstance()->get_error())) {
                errorhandler::getInstance()->flush();
            }
        }

        if (config('tmdb_get_genre') == 'yes' && config('enable_video_genre') == 'yes') {
            $genre_tags = [];
            foreach ($details['genres'] as $genre) {
                $genre_tags[] = trim($genre['name']);
            }
            Tags::saveTags(implode(',', $genre_tags), 'genre', $_POST['videoid']);
        }

        if (config('tmdb_get_actors') == 'yes' && config('enable_video_actor') == 'yes') {
            $actors_tags = [];
            foreach ($credits['cast'] as $actor) {
                $actors_tags[] = trim($actor['name']);
            }
            Tags::saveTags(implode(',', $actors_tags), 'actors', $_POST['videoid']);
        }

        $producer_tags = [];
        $executive_producer_tags = [];
        $director_tags = [];
        $crew_tags = [];
        foreach ($credits['crew'] as $crew) {
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

        if (config('tmdb_get_producer') == 'yes' && config('enable_video_producer') == 'yes') {
            Tags::saveTags(implode(',', $producer_tags), 'producer', $_POST['videoid']);
        }

        if (config('tmdb_get_executive_producer') == 'yes' && config('enable_video_executive_producer') == 'yes') {
            Tags::saveTags(implode(',', $executive_producer_tags), 'executive_producer', $_POST['videoid']);
        }

        if (config('tmdb_get_director') == 'yes' && config('enable_video_director') == 'yes') {
            Tags::saveTags(implode(',', $director_tags), 'director', $_POST['videoid']);
        }

        if (config('tmdb_get_crew') == 'yes' && config('enable_video_crew') == 'yes') {
            Tags::saveTags(implode(',', $crew_tags), 'crew', $_POST['videoid']);
        }
    }

    /**
     * @throws Exception
     */
    public function getInfoTmdb(int $videoid, string $type, $params, string $fileName = ''): array
    {
        switch ($type) {
            case 'movie':
            case 'series':
                break;
            default:
                if( System::isInDev() ){
                    $msg = 'Wrong TMDB type : ' . $type;
                    error_log($msg);
                    DiscordLog::sendDump($msg);
                }
                $type = 'movie';
                break;
        }

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
        if( in_array($sort_order, ['ASC', 'DESC']) ){
            $sort_order = 'DESC';
        }

        $cache_results = $this->getSearchInfo($title, $type);
        if (!empty($cache_results)) {
            $years = json_decode($cache_results[0]['list_years'], true);
        } else {
            $tmdb_results = [];
            $page_tmdb = 1;
            $years = [];
            do {
                switch ($type) {
                    case 'movie':
                        $results = $this->searchMovie($title, $page_tmdb)['response'];
                        $date_field = 'release_date';
                        break;
                    case 'series':
                        $results = $this->searchSeries($title, $page_tmdb)['response'];
                        $date_field = 'first_air_date';
                        break;
                    default:
                        $results=['results'=>[]];
                        break;
                }
                $total_rows = $results['total_results'];
                $tmdb_results = array_merge($tmdb_results, $results['results']);

                foreach ($results['results'] as $result) {
                    $year = substr($result[$date_field], 0, 4);
                    if (!empty($year)) {
                        if (!array_key_exists($year, $years) ) {
                            $years[$year]['year'] = $year;
                            $years[$year]['count'] = 1;
                        } else {
                            $years[$year]['count']++;
                        }
                    }
                }
                $page_tmdb++;
                if (!empty($results['error'])) {
                    e(lang($results['error']));
                    break;
                }
            } while (!empty($results['results']));
            if (!empty($tmdb_results)) {
                rsort($years);
                try {
                    $this->setQueryInCache($title, $type,$tmdb_results, $total_rows, $years);
                } catch (Exception $e) {
                    e($e->getMessage());
                }
            }
        }
        $final_results = $this->getCacheFromQuery($title, $type, $sort, $sort_order, $_POST['page']??'', false, $params['year']);

        //use different sql to get numbers of rows
        $total_rows = $this->getCacheFromQuery($title, $type, $sort, $sort_order, 0, true, $params['year']);
        $total_pages = count_pages($total_rows, config('tmdb_search'));
        return [
            'final_results' => $final_results,
            'total_pages'   => $total_pages,
            'title'         => $title,
            'years'         => $years,
            'sort_order'    => $sort_order,
            'videoid'       => $video_info['videoid']
        ];
    }
}
