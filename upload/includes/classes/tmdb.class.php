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

    }

    public function movieDetail($movie_id)
    {

    }

    public function movieCredits($movie_id)
    {

    }

    public function setLanguage($language)
    {

    }

    public function personDetail($person_id)
    {

    }
}