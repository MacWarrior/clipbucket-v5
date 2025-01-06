<?php

namespace FFI\Env\Exception;

use FFI\Env\Runtime;
use FFI\Env\Status;

/**
 * @psalm-import-type StatusType from Status
 */
class EnvironmentException extends \DomainException
{
    /**
     * @var string
     */
    const ERROR_NOT_AVAILABLE = 'An [ext-ffi] not available';

    /**
     * @var string
     */
    const ERROR_CLI_REQUIRED =
        'An [ext-ffi] can only be run in "cli" mode, but the current mode ' .
        'is "%s" does not meet required runtime parameters';

    /**
     * @var string
     */
    const ERROR_FFI_DISABLED =
        'An [ext-ffi] disabled in your php.ini';

    /**
     * @var string
     */
    const ERROR_UNKNOWN = 'Unknown Error';

    /**
     * @param int|null $status
     * @return string
     */
    public static function getErrorMessageFromStatus($status = null)
    {
        if ($status === null) {
            $status = Runtime::getStatus();
        }

        switch ($status) {
            case Status::NOT_AVAILABLE:
                return self::ERROR_NOT_AVAILABLE;

            case Status::CLI_ENABLED:
                return sprintf(self::ERROR_CLI_REQUIRED, PHP_SAPI);

            case Status::DISABLED:
                return self::ERROR_FFI_DISABLED;

            default:
                return self::ERROR_UNKNOWN;
        }
    }

    /**
     * @param int|null $status
     * @param \Throwable|null $previous
     * @return self
     */
    public static function fromStatus($status = null, \Throwable $previous = null)
    {
        if ($status === null) {
            $status = Runtime::getStatus();
        }

        $message = static::getErrorMessageFromStatus($status);

        return new self($message, $status, $previous);
    }
}
