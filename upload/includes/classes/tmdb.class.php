<?php

class Tmdb
{

    const API_URL = 'https://api.themoviedb.org/3/';
    private $curl;
    private static $instance;

    private $language = '';

    /**
     * @param \Classes\Curl $curl
     * @return void
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

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->init(new \Classes\Curl(self::API_URL, config('tmdb_token')));
            self::$instance->setLanguage(Language::getInstance()->lang);
            return self::$instance;
        }
        return self::$instance;
    }

    public function searchMovie($search)
    {
        return $this->requestAPI('search/movie',[
            'query'=>$search
        ]);
    }

    public function movieDetail($movie_id)
    {
        return $this->requestAPI('search/movie/' . $movie_id );
    }

    public function movieCredits($movie_id)
    {
        return $this->requestAPI('search/movie/' . $movie_id . '/credits');
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function requestAPI($url, $param = [])
    {
        if (empty($param['language']) ) {
            $param['language'] = $this->language;
        }
        return $this->curl->exec($url, $param);
    }
}