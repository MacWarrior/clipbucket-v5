<?php

declare(strict_types=1);

namespace FFI\WorkDirectory\Driver;

use FFI\WorkDirectory\WorkDirectory;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal FFI\WorkDirectory
 */
interface DriverInterface
{
    /**
     * @see WorkDirectory::get() for more information.
     *
     * @return non-empty-string|null
     */
    public function get();

    /**
     * @psalm-taint-sink file $directory
     * @param non-empty-string $directory
     */
    public function set($directory): bool;
}
