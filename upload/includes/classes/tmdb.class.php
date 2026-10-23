<?php

class Tmdb
{
    const API_URL = 'https://api.themoviedb.org/3/';

    const IMAGE_URL = 'https://image.tmdb.org/t/p/original';

    private $curl;
    private static $instance;

    private static $fields_title = ['movie'=>'title','series'=>'name','season'=>'name','episode'=>'name'];
    private static $fields_date = ['movie'=>'release_date','series'=>'first_air_date','season'=>'air_date','episode'=>'air_date'];

    private $language = '';

    private static $tablename = 'video_tmdb';

    /**
     * @param \Classes\Curl $curl
     * @return void
     * @throws Exception
     */
    public function init(\Classes\Curl $curl)
    {
        $this->curl = $curl;
        $this->requestAPI('authentication');
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

    public function seasonDetail(int $series_id, int $season)
    {
        return $this->requestAPI('tv/' . $series_id . '/season/' . $season);
    }

    public function episodeDetail(int $series_id, int $season, int $episode)
    {
        return $this->requestAPI('tv/' . $series_id . '/season/' . $season . '/episode/' . $episode);
    }

    public function televisionResource(int $series_id, int $season, ?int $episode, string $resource)
    {
        $path = 'tv/' . $series_id . '/season/' . $season;
        if ($episode !== null) {
            $path .= '/episode/' . $episode;
        }
        $params = $resource === 'images' ? ['language' => ''] : [];
        if ($resource === 'images' && $episode !== null) {
            $params['include_image_language'] = $this->language . ',null';
        }
        return $this->requestAPI($path . '/' . $resource, $params);
    }

    public static function requestContext(array $request): array
    {
        $target = $request['target'] ?? 'video';
        if (!in_array($target, ['video', 'collection'], true)) {
            throw new Exception(lang('technical_error'));
        }
        $values = [];
        foreach (['videoid', 'tmdb_video_id', 'season', 'episode'] as $key) {
            $value = $request[$key] ?? null;
            if ($value !== null && (is_array($value) || !preg_match('/^[0-9]+$/D', (string)$value))) {
                throw new Exception(lang('technical_error'));
            }
            $values[$key] = $value === null ? null : (int)$value;
        }
        $values['target'] = $target;
        return $values;
    }

    public function getTarget(int $id, string $target): array
    {
        if ($id <= 0 || !in_array($target, ['video', 'collection'], true)) {
            throw new Exception(lang('technical_error'));
        }
        $object = $target === 'collection'
            ? Collection::getInstance()->getOne(['collection_id' => $id, 'hide_empty_collection'=>false])
            : Video::getInstance()->getOne(['videoid' => $id, 'get_detail' => true]);
        if (empty($object) || ($target === 'collection' && $object['type'] !== 'videos')) {
            throw new Exception(lang($target === 'collection' ? 'collection_not_exist' : 'class_vdo_del_err'));
        }
        return $object;
    }

    public function getNavigation(int $id, string $target, int $series_id, ?int $season = null): array
    {
        $this->getTarget($id, $target);
        if ($series_id <= 0 || ($season !== null && ($season < 0 || $target !== 'video'))) {
            throw new Exception(lang('technical_error'));
        }
        $this->deleteOldCacheEntries();
        $type = $season === null ? 'season' : 'episode';
        $query = 'tv/' . $series_id . ($season === null ? '' : '/season/' . $season);
        $search = $this->getSearchInfo($query, $type);
        if (!$search) {
            $series = $this->seriesDetail($series_id)['response'];
            $details = $season === null ? $series : $this->seasonDetail($series_id, $season)['response'];
            $results = $details[$season === null ? 'seasons' : 'episodes'] ?? [];
            $title = ($series['name'] ?? '') . ($season === null ? '' : ' — ' . lang('tmdb_season') . ' ' . $season);
            $this->setQueryInCache($query, $type, $results, count($results), [], $title);
        } else {
            $title = $search[0]['navigation_title'];
        }
        $results = $this->getCacheFromQuery($query, $type, 'id_tmdb_search_result', 'ASC', 0);
        foreach ($results as &$result) {
            $result['id'] = $result['id_tmdb_movie'];
            $result['name'] = $result['title'];
            $result['air_date'] = $result['release_date'];
            if ($type === 'episode') {
                $result['still_path'] = $result['poster_path'];
            }
        }
        unset($result);
        return [
            'success' => true,
            'title' => $title,
            'results' => $results
        ];
    }

    public function movieCurrentLanguageAgeRestriction($movie_id)
    {
        $results = $this->requestAPI('movie/' . $movie_id . '/release_dates')['response']['results'];
        $restriction = array_search(strtoupper($this->language), array_column($results, 'iso_3166_1'));
        if (empty($restriction) && $this->language == 'en') {
            $restriction = array_search('US', array_column($results, 'iso_3166_1'));
        }
        if ($restriction !== false) {
            foreach ($results[$restriction]['release_dates'] as $certification) {
                if (!empty($certification['certification'])) {
                    if ($certification['certification'] == 'R') {
                        return 17;
                    }
                    return $certification['certification'];
                }
            }
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
        $result = $this->curl->exec($url, $param);
        if (!empty($result['error']) || empty($result['response']) || ($result['response']['success'] ?? true) === false) {
            if (System::isInDev()) {
                DiscordLog::sendDump('Une erreur est survenue lors d’une requête à TMDB (' . $url . ') : ' . print_r($result, true));
            }
            throw new Exception(lang('technical_error'));
        }
        return $result;
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
            $sql_year = ' AND YEAR(`release_date`) = ' . (int)$year;
        }
        $sql_type = '';

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '194')) {
            $sql_type = 'AND type = \'' . mysql_clean($type) . '\' 
            AND language = \'' . mysql_clean($this->language). '\'';
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
                AND language = \'' . mysql_clean($this->language). '\'';
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
    public function setQueryInCache(string $query, string $type, array $results, int $total_results, array $years = [], ?string $title = null)
    {
        if (!isset(self::$fields_title[$type])) {
            throw new Exception(lang('technical_error'));
        }
        $years = $years ?: $this->getSearchYears($results, $type);
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
        $is_navigation = in_array($type, ['season', 'episode'], true);
        if ($is_navigation) {
            $fields[] = 'navigation_title';
            $values[] = $title;
        }
        Clipbucket_db::getInstance()->insert(tbl('tmdb_search'), $fields, $values);
        $id_tmdb_search = Clipbucket_db::getInstance()->insert_id();

        if (!$results) {
            return true;
        }

        $can_is_adult = false;
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '20')) {
            $can_is_adult = true;
        }

        $sql_insert = 'INSERT INTO ' . tbl('tmdb_search_result') . ' (id_tmdb_search, title, overview,release_date, poster_path, id_tmdb_movie ' . ($can_is_adult ? ', is_adult' : '') . ($is_navigation ? ', season_number, episode_number' : '') . ') VALUES ';
        $insert_line = [];
        foreach ($results as $result) {
            $insert_line[] = ' (' . $id_tmdb_search . ', \'' . mysql_clean($result[self::$fields_title[$type]] ?? '') . '\'
            , \'' . mysql_clean($result['overview'] ?? '') . '\'
            , ' . (empty($result[self::$fields_date[$type]]) ? 'null' : '\'' . mysql_clean($result[self::$fields_date[$type]]) . '\'') . '
            , \'' . mysql_clean($result[$type === 'episode' ? 'still_path' : 'poster_path'] ?? '') . '\', ' . (int)$result['id']
                . ($can_is_adult ? ', ' . (!empty($result['adult']) ? 'true' : 'false') : '')
                . ($is_navigation ? ', ' . (isset($result['season_number']) ? (int)$result['season_number'] : 'null')
                    . ', ' . (isset($result['episode_number']) ? (int)$result['episode_number'] : 'null') : '')
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
    public function importDataFromTmdb(int $videoid, int $tmdb_id, string $type = 'movie', string $target = 'video', ?int $season = null, ?int $episode = null): void
    {
        if ($tmdb_id <= 0 || !in_array($target, ['video', 'collection'], true)
            || !in_array($type, $target === 'video' ? ['movie', 'episode'] : ['series', 'season'], true)
            || (in_array($type, ['season', 'episode'], true) && ($season === null || $season < 0))
            || ($type === 'episode' && ($episode === null || $episode < 0))) {
            e(lang('technical_error'));
            return;
        }
        $video_info = $this->getTarget($videoid, $target);
        $images = [];
        switch ($type) {
            case 'movie':
                $credits = $this->movieCredits($tmdb_id)['response'];
                $details = $this->movieDetail($tmdb_id)['response'];
                break;
            case 'series':
                $details = $this->seriesDetail($tmdb_id)['response'];
                $images = $this->seriesPosterBackdrops($tmdb_id)['response'];
                break;
            case 'season':
            case 'episode':
                $series = $this->seriesDetail($tmdb_id)['response'];
                $details = ($type === 'season'
                    ? $this->seasonDetail($tmdb_id, $season)
                    : $this->episodeDetail($tmdb_id, $season, $episode))['response'];
                $images = $this->televisionResource($tmdb_id, $season, $type === 'episode' ? $episode : null, 'images')['response'];
                if ($type === 'episode') {
                    $credits = $this->televisionResource($tmdb_id, $season, $episode, 'credits')['response'];
                    $prefix = ($series['name'] ?? '') . ' — ' . lang('tmdb_season') . ' ' . $season
                        . ' — ' . lang('tmdb_episode') . ' ' . $episode;
                    $details['overview'] = $prefix . (!empty($details['overview']) ? "\n\n" . $details['overview'] : '');
                } elseif (in_array(trim($details['name'] ?? ''), ['Saison ' . $season, lang('tmdb_season') . ' ' . $season], true)) {
                    $details['name'] = ($series['name'] ?? '') . ' - ' . $details['name'];
                }
                break;
        }
        if ($target === 'collection') {
            // Collections have no dedicated genre, credit or certification fields.
            $posters = $images['posters'] ?? [];
            $preferred = array_filter($posters, function ($image) {
                return ($image['iso_639_1'] ?? null) == $this->language || ($image['iso_639_1'] ?? null) == 'null';
            });
            $posters = $preferred ?: $posters;
            if ($posters && !is_callable(['CollectionThumb', 'uploadThumbs'])) {
                e(lang('tmdb_collection_thumb_unavailable'));
                return;
            }
            if (config('tmdb_get_title') === 'yes' && !empty($details['name'])) {
                $video_info['collection_name'] = $details['name'];
            }
            if (config('tmdb_get_description') === 'yes' && !empty($details['overview'])) {
                $video_info['collection_description'] = $details['overview'];
            }
            $video_info['collection_tags'] = $video_info['tags'] ?? '';
            $video_info['category'] = array_column(json_decode($video_info['category_list'] ?? '[]', true) ?: [], 'id');
            $video_info['collection_id_parent'] = $video_info['collection_id_parent'] ?? 'null';
            Collections::getInstance()->update_collection($video_info);
            if (errorhandler::getInstance()->get_error()) {
                return;
            }
            $this->updateExternalRatings($videoid, $details, 'collection');
            if (!$posters) {
                Collection::assignDefaultThumb($videoid);
            } else {
                $files = ['tmp_name' => [], 'name' => []];
                foreach ($posters as $poster) {
                    $name = str_replace('/', '', $poster['file_path']);
                    $path = DirPath::get('temp') . $name;
                    file_put_contents($path, file_get_contents(self::IMAGE_URL . $poster['file_path']));
                    $files['tmp_name'][] = $path;
                    $files['name'][] = $name;
                }
                // Contract supplied by the caller: same arguments as VideoThumbs::uploadThumbs.
                CollectionThumb::uploadThumbs($videoid, $files, 'thumbnail', true);
            }
            return;
        }

        $update_video = $type === 'episode';

        $video_info['datecreated'] = $details[self::$fields_date[$type]];
        if (config('tmdb_get_title') == 'yes' && !empty($details[self::$fields_title[$type]])) {
            $video_info['title'] = $details[self::$fields_title[$type]];
            $update_video = true;
        }
        if (config('tmdb_get_description') == 'yes' && !empty($details['overview'])) {
            $video_info['description'] = $details['overview'];
            $update_video = true;
        }
        if ($type === 'movie' && config('tmdb_get_age_restriction') == 'yes') {
            switch ($type) {
                case 'movie':
                default:
                    $credentials = $this->movieCurrentLanguageAgeRestriction($tmdb_id);
                    break;
                case 'series':
                    $credentials = $this->seriesCurrentLanguageAgeRestriction($tmdb_id);
                    break;
            }
            $credentials = preg_replace('/\D/', '',$credentials);
            $video_info['age_restriction'] = $credentials;
            if (!$credentials && config('enable_tmdb_mature_content') == 'yes' && $details['adult']) {
                $video_info['age_restriction'] = config('tmdb_mature_content_age');
            }
            $update_video = true;
        }
        if ( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '138') ) {
            if (config('enable_external_rate_from_tmdb') == 'yes' ) {
                $video_info['external_rate'] = (float)($details['vote_average'] ?? 0);
                $update_video = $update_video || $type === 'episode';
            }
            if (config('enable_external_ratings_from_tmdb') == 'yes' ) {
                $video_info['external_ratings'] = (int)($details['vote_count'] ?? 0);
                $update_video = $update_video || $type === 'episode';
            }
        }
        if ($update_video) {
            $category_list = json_decode($video_info['category_list'], true);
            $video_info['category'] = array_column($category_list, 'id');
            CBvideo::getInstance()->update_video($video_info);
            if ($type === 'episode' && errorhandler::getInstance()->get_error()) {
                return;
            }
            if ($type === 'movie') {
                $this->updateVideoTmdbInfo($videoid, $tmdb_id, $type);
            }
        }

        if ($type === 'episode') {
            $this->updateVideoTmdbInfo($videoid, (int)$details['id'], 'episode');
            $this->updateExternalRatings($videoid, $details, 'video');
            foreach ($images['stills'] ?? [] as $image) {
                $name = str_replace('/', '', $image['file_path']);
                $path = DirPath::get('temp') . $name;
                file_put_contents($path, file_get_contents(self::IMAGE_URL . $image['file_path']));
                VideoThumbs::uploadThumbs($videoid, [
                    'tmp_name' => [$path],
                    'name' => [$name]
                ], 'thumbnail', false);
            }
        }

        if ($type !== 'episode' && config('tmdb_get_poster') == 'yes' && config('enable_video_poster') == 'yes' && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
            Video::getInstance()->dropPictures($video_info, 'poster', true);

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
                return ($elem['iso_639_1'] ?? null) == $this->language || ($elem['iso_639_1'] ?? null) == 'null';
            });
            if (count($language_posters) > 0) {
                $poster_iterate = $language_posters;
            } else {
                $poster_iterate = $posters;
            }
            $video_thumbs = new VideoThumbs($videoid);
            $video_thumbs->prepareFFmpeg();
            foreach ($poster_iterate as $poster) {
                $path_without_slash = str_replace('/', '', $poster['file_path']);
                $url = self::IMAGE_URL . $poster['file_path'];
                $tmp_path = DirPath::get('temp') . $path_without_slash;
                file_put_contents($tmp_path, file_get_contents($url));
                VideoThumbs::uploadThumbs($video_info['videoid'], [
                    'tmp_name' => [$tmp_path],
                    'name'     => [$path_without_slash]
                ], 'poster', true);
            }
            Video::getInstance()->resetDefaultPicture($videoid, 'poster');

            if (empty(errorhandler::getInstance()->get_error())) {
                errorhandler::getInstance()->flush();
            }
        }

        if (config('tmdb_get_backdrop') == 'yes' && config('enable_video_backdrop') == 'yes' && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
            Video::getInstance()->dropPictures($video_info, 'backdrop',true);

            switch ($type) {
                case 'episode':
                    $backdrops = $images['stills'] ?? [];
                    break;
                case 'movie':
                default:
                    $backdrops = $this->moviePosterBackdrops($tmdb_id)['response']['backdrops'];
                    break;
                case 'series':
                    $backdrops = $this->seriesPosterBackdrops($tmdb_id)['response']['backdrops'];
                    break;
            }

            $language_backdrops = array_filter($backdrops, function ($elem) {
                return ($elem['iso_639_1'] ?? null) == $this->language || ($elem['iso_639_1'] ?? null) == 'null';
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
                VideoThumbs::uploadThumbs($video_info['videoid'], [
                    'tmp_name' => [$tmp_path],
                    'name'     => [$path_without_slash]
                ], 'backdrop', true);
            }
            Video::getInstance()->resetDefaultPicture($videoid, 'backdrop');

            if (empty(errorhandler::getInstance()->get_error())) {
                errorhandler::getInstance()->flush();
            }
        }

        if ($type !== 'episode' && config('tmdb_get_genre') == 'yes' && config('enable_video_genre') == 'yes') {
            $genre_tags = [];
            foreach ($details['genres'] as $genre) {
                $genre_tags[] = trim($genre['name']);
            }
            Tags::saveTags(implode(',', $genre_tags), 'genre', $videoid);
        }

        if (config('tmdb_get_actors') == 'yes' && config('enable_video_actor') == 'yes') {
            $actors_tags = [];
            foreach ($credits['cast'] ?? [] as $actor) {
                $actors_tags[] = str_replace(',','.',trim($actor['name']));
            }
            Tags::saveTags(implode(',', $actors_tags), 'actors', $videoid);
        }

        $producer_tags = [];
        $executive_producer_tags = [];
        $director_tags = [];
        $crew_tags = [];
        foreach ($credits['crew'] ?? [] as $crew) {
            switch (strtolower($crew['job'])) {
                case 'producer':
                    $producer_tags[] = str_replace(',','.',trim($crew['name']));
                    break;
                case 'executive producer':
                    $executive_producer_tags[] = str_replace(',','.',trim($crew['name']));
                    break;
                case 'director':
                case 'co-director':
                    $director_tags[] = str_replace(',','.',trim($crew['name']));
                    break;
                default:
                    $crew_tags[] = str_replace(',','.',trim($crew['name']));
                    break;
            }
        }

        if (config('tmdb_get_producer') == 'yes' && config('enable_video_producer') == 'yes') {
            Tags::saveTags(implode(',', $producer_tags), 'producer', $videoid);
        }

        if (config('tmdb_get_executive_producer') == 'yes' && config('enable_video_executive_producer') == 'yes') {
            Tags::saveTags(implode(',', $executive_producer_tags), 'executive_producer', $videoid);
        }

        if (config('tmdb_get_director') == 'yes' && config('enable_video_director') == 'yes') {
            Tags::saveTags(implode(',', $director_tags), 'director', $videoid);
        }

        if (config('tmdb_get_crew') == 'yes' && config('enable_video_crew') == 'yes') {
            Tags::saveTags(implode(',', $crew_tags), 'crew', $videoid);
        }
        if ($type === 'movie' && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '101') && !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '138')) {
            Clipbucket_db::getInstance()->update(tbl('video'), ['id_tmdb', 'type_tmdb'], [$tmdb_id, $type], 'videoid = ' . $videoid);
        }
        insert_log('import_tmdb', [
            'success'       => 'yes',
            'action_obj_id' => $videoid,
        ]);
    }

    /**
     * @throws Exception
     */
    public function getInfoTmdb(int $videoid, string $type, $params, string $fileName = '', string $target = 'video'): array
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

        if ($target === 'collection') {
            $video_info = $this->getTarget($videoid, $target);
            $type = 'series';
            $video_info['title'] = $video_info['collection_name'];
            $video_info['videoid'] = $videoid;
        } else {
            if (!$videoid && $fileName !== '') {
                $video = Video::getInstance()->getOne(['file_name' => $fileName]);
                $videoid = (int)($video['videoid'] ?? 0);
            }
            $video_info = $this->getTarget($videoid, $target);
        }
        $this->deleteOldCacheEntries();
        $title = !empty($params['video_title']) ? $params['video_title'] : $video_info['title'];
        if (!in_array($params['sort'], ['title', 'release_date'])) {
            unset($params['sort']);
        }
        $sort = empty($params['sort']) ? 'release_date' : $params['sort'];
        $sort_order = empty($params['sort_order']) ? 'DESC' : $params['sort_order'];
        if( !in_array($sort_order, ['ASC', 'DESC']) ){
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
                        break;
                    case 'series':
                        $results = $this->searchSeries($title, $page_tmdb)['response'];
                        break;
                    default:
                        $results=['results'=>[]];
                        break;
                }
                $total_rows = $results['total_results'] ?? 0;
                $tmdb_results = array_merge($tmdb_results, $results['results'] ?? []);

                $page_tmdb++;
                if (!empty($results['error'])) {
                    e(lang($results['error']));
                    break;
                }
            } while (!empty($results['results']));
            $years = $this->getSearchYears($tmdb_results, $type);
            if (empty($results['error'])) {
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
            'sort'          => $sort,
            'videoid'       => $video_info['videoid']
        ];
    }

    /**
     * @param int $videoid
     * @param int $id_tmdb
     * @param string $type_tmdb
     * @return bool
     * @throws Exception
     */
    public function updateVideoTmdbInfo(int $videoid, int $id_tmdb, string $type_tmdb): bool
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '138')) {
            return false;
        }
        $fields = ['tmdb_id', 'tmdb_type'];
        $values = [$id_tmdb, '\''.$type_tmdb.'\''];

        $sql = 'INSERT INTO ' . tbl('video_tmdb') . ' (video_id, '. implode(', ', $fields).') 
        VALUES ( ' . (int)$videoid . ', '.implode(', ', $values).' )
        ON DUPLICATE KEY UPDATE ';
        foreach ($fields as $key => $field) {
            if ($key != 0) {
                $sql .=', ';
            }
            $sql .= $field . ' = VALUES('.$field.') ';
        }
        return Clipbucket_db::getInstance()->execute($sql);
    }

    private function getSearchYears(array $results, string $type): array
    {
        $years = [];
        foreach ($results as $result) {
            $year = substr($result[self::$fields_date[$type]] ?? '', 0, 4);
            if ($year !== '') {
                $years[$year] = ['year' => $year, 'count' => ($years[$year]['count'] ?? 0) + 1];
            }
        }
        rsort($years);
        return $years;
    }

    private function updateExternalRatings(int $id, array $details, string $target): void
    {
        $fields = [];
        $values = [];
        if (config('enable_external_rate_from_tmdb') === 'yes' && isset($details['vote_average'])) {
            $fields[] = 'external_rate';
            $values[] = (float)$details['vote_average'];
        }
        if (config('enable_external_ratings_from_tmdb') === 'yes' && isset($details['vote_count'])) {
            $fields[] = 'external_ratings';
            $values[] = (int)$details['vote_count'];
        }
        if ($fields) {
            $table = $target === 'collection' ? 'collections' : 'video';
            $id_field = $target === 'collection' ? 'collection_id' : 'videoid';
            Clipbucket_db::getInstance()->update(tbl($table), $fields, $values, $id_field . ' = ' . $id);
        }
    }

    public static function getTableName(): string
    {
        return self::$tablename;
    }
}
