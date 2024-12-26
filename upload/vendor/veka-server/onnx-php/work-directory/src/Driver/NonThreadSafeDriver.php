<?php

declare(strict_types=1);

namespace FFI\WorkDirectory\Driver;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal FFI\WorkDirectory
 */
final class NonThreadSafeDriver implements DriverInterface
{
    public function get()
    {
        return \getcwd() ?: null;
    }

    public function set($directory): bool
    {
        return \chdir($directory);
    }
}
