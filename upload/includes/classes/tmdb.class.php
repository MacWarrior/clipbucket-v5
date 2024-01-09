<?php

class Tmdb
{

    const API_URL = 'https://api.themoviedb.org/3/';
    private $curl;
    private static $instance;

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
            return self::$instance;
        }
        return self::$instance;
    }

    public function searchMovie($search)
    {
        $return = $this->curl->exec('search/movie',[
            'query'=>$search
        ]);
        return $return;
    }

    public function movieDetail($movie_id)
    {
        $return = $this->curl->exec('search/movie',[
            'query'=>$movie_id
        ]);
        return $return;
    }

    public function movieCredits($movie_id)
    {
        $return = $this->curl->exec('search/movie/' . $movie_id . '/credits');
        return $return;
    }

    public function setLanguage($language)
    {

    }

    public function personDetail($person_id)
    {

    }
}