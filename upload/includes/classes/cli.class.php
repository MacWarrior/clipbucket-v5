<?php

class CLI
{

    private static $cache = [];

    public static function getParams()
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

    public static function isRequiredParam(string $key)
    {
        if (empty(self::getParams()[$key] ?? '')) {
            throw new InvalidArgumentException('param[' . $key . '].missing');
        }
    }

}