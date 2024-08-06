<?php

class CLI
{

    private static $cache = [];

    /**
     * @return array
     */
    public static function getParams() :array
    {
        global $argv;
        if (!empty(self::$cache)) {
            return self::$cache;
        }
        $param = [];
        if (isset($argv[0])) {
            $cptr = 0;
            foreach ($argv as $arg) {
                if ($cptr == 0) {
                    $arg = basename($arg);
                    $cptr++;
                }
                $arg = trim($arg);
                $pos = strpos($arg, '=');
                if ($pos !== false) {
                    $name = substr($arg, 0, $pos);
                    $value = substr($arg, $pos + 1);
                    $param[$name] = $value;
                }
                $cptr++;
            }
        }
        self::$cache = $param;
        return $param;
    }

    /**
     * @param string $key
     * @return void
     * @throws Exception
     */
    public static function checkRequiredParam(string $key)
    {
        if (empty(self::getParams()[$key])) {
            throw new Exception('Missing parameter: '.$key);
        }
    }

}