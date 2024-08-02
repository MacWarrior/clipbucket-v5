<?php

class WhoopsManager
{
    private static $whoops_instance;

    public static function getInstance()
    {
        if (is_null(self::$whoops_instance)) {
            self::$whoops_instance = new Whoops\Run;
        }
        return self::$whoops_instance;
    }
}