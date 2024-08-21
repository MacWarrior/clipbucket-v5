<?php

namespace FFI\WorkDirectory\Driver;

use FFI\CData;

/**
 * @psalm-suppress all
 *
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal FFI\WorkDirectory
 */
abstract class UnixAwareThreadSafeDriver extends ThreadSafeDriver
{
    /**
     * @var string
     */
    const STDLIB = '
        char *getenv(const char *name);
        int setenv(const char *name, const char *value, int overwrite);
    ';

    /**
     * @var \FFI
     */
    private $ffi;

    public function __construct()
    {
        parent::__construct();
        $this->boot();
    }

    private function boot()
    {
        $this->ffi = \FFI::cdef(self::STDLIB);
    }

    /**
     * @return string
     */
    abstract protected static function getEnvVariableName();

    public function get()
    {
        /**
         * Note: The getenv function returns a pointer to a string associated
         * with the matched list member. The string pointed to shall not be
         * modified by the program, but may be overwritten by a subsequent
         * call to the getenv function.
         *
         * @var CData $directory
         */
        $directory = $this->ffi->getenv(static::getEnvVariableName());

        if ($directory === null) {
            return $this->fallback;
        }

        return \FFI::string($directory) ?: $this->fallback;
    }

    public function set($directory):bool
    {
        return $this->ffi->setenv(static::getEnvVariableName(), $directory, 1) === 0;
    }

    public function __unserialize(array $data)
    {
        parent::__unserialize($data);
        $this->boot();
    }
}
