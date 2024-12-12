<?php

declare(strict_types=1);

namespace FFI\WorkDirectory\Driver;

use FFI\Env\Runtime;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal FFI\WorkDirectory
 */
abstract class ThreadSafeDriver implements DriverInterface
{
    /**
     * @var non-empty-string|null
     */
    protected $fallback;

    public function __construct()
    {
        Runtime::assertAvailable();

        $this->fallback = $this->getInitialCurrentWorkingDirectory();
    }

    /**
     * @return non-empty-string|null
     */
    private function getInitialCurrentWorkingDirectory()
    {
        if ($directory = \getcwd()) {
            return $directory;
        }

        if (isset($_SERVER['SCRIPT_NAME']) && $directory = \dirname($_SERVER['SCRIPT_NAME'])) {
            return $directory;
        }

        if (isset($_SERVER['SCRIPT_FILENAME']) && $directory = \dirname($_SERVER['SCRIPT_FILENAME'])) {
            return $directory;
        }

        if (isset($_SERVER['PHP_SELF']) && $directory = \dirname($_SERVER['PHP_SELF'])) {
            return $directory;
        }

        return null;
    }

    /**
     * @return array{fallback:non-empty-string|null}
     */
    public function __serialize(): array
    {
        return ['fallback' => $this->fallback];
    }

    /**
     * @param array{fallback:non-empty-string|null} $data
     */
    public function __unserialize(array $data)
    {
        $this->fallback = $data['fallback'] ?? $this->getInitialCurrentWorkingDirectory();
    }
}
