<?php

namespace FFI\Env;

use FFI\Env\Exception\EnvironmentException;

/**
 * @psalm-import-type StatusType from Status
 */
final class Runtime
{
    /**
     * @var string
     */
    const EXT_NAME = 'FFI';

    /**
     * @var string
     */
    const EXT_CONFIG_NAME = 'ffi.enable';

    /**
     * @param int|null $status
     * @return bool
     */
    public static function assertAvailable($status = null)
    {
        if ($status === null) {
            $status = self::getStatus();
        }

        if (self::isAvailable($status)) {
            return true;
        }

        throw EnvironmentException::fromStatus($status);
    }

    /**
     * Returns {@see true} if the current environment (SAPI) supports foreign
     * function interface headers execution/compilation or {@see false} instead.
     *
     * @param int|null $status
     * @return bool
     */
    public static function isAvailable($status = null)
    {
        if ($status === null) {
            $status = self::getStatus();
        }

        if ($status === Status::CLI_ENABLED) {
            return strtolower(PHP_SAPI) === 'cli';
        }

        return $status === Status::ENABLED;
    }

    /**
     * Returns FFI status.
     *
     * @return int
     */
    public static function getStatus()
    {
        if (!extension_loaded(self::EXT_NAME)) {
            return Status::NOT_AVAILABLE;
        }

        switch (self::fetchConfig()) {
            case '1':
                return Status::ENABLED;

            case '0':
                return Status::DISABLED;

            default:
                return Status::CLI_ENABLED;
        }
    }

    /**
     * @return string
     */
    protected static function fetchConfig()
    {
        // - Returns "1" in case of 'ffi.enable=true' or 'ffi.enable=1' in php.ini
        // - Returns "" (empty string) in case of 'ffi.enable=false' or 'ffi.enable=0' in php.ini
        // - Returns "0" in case of direct execution `php -dffi.enable=0 file.php`
        $config = ini_get(self::EXT_CONFIG_NAME) ?: '0';

        return strtolower($config);
    }
}
