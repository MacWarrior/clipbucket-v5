<?php

declare(strict_types=1);

namespace FFI\WorkDirectory\Driver;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal FFI\WorkDirectory
 */
final class MacOSThreadSafeDriver extends UnixAwareThreadSafeDriver
{
    /**
     * @var non-empty-string
     */
    const ENV_NAME = 'DYLD_LIBRARY_PATH';

    protected static function getEnvVariableName()
    {
        return self::ENV_NAME;
    }
}
