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
        if ($restriction) {
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
     * @return array|null
     * @throws Exception
     */
    public function getCacheFromQuery(string $query, string $sort = 'release_date', string $sort_order = 'DESC', string $limit = '1')
    {
        $search_adult = '';
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo(Tmdb::MIN_VERSION_IS_ADULT, Tmdb::MIN_REVISION_IS_ADULT)) {
            if (config('enable_tmdb_mature_content') == 'yes') {
                $search_adult = ' AND is_adult = TRUE';
            } else {
                $search_adult = ' AND is_adult = FALSE';
            }
        }
        $sql = 'SELECT TSR.* 
                FROM ' . tbl('tmdb_search') . ' TS
                INNER JOIN ' . tbl('tmdb_search_result') . ' TSR ON TS.id_tmdb_search = TSR.id_tmdb_search
                WHERE search_key = \'' . mysql_clean(strtolower($query)) . '\' '. $search_adult . '
                ORDER BY ' . mysql_clean($sort) . ' ' . mysql_clean($sort_order) . '
                LIMIT ' . create_query_limit($limit, config('tmdb_search'));
        return Clipbucket_db::getInstance()->_select($sql);
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
}
