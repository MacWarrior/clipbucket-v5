<?php

declare(strict_types=1);

namespace FFI\Env;

/**
 * @psalm-type StatusType = Status::*
 */
final class Status
{
    /**
     * @var StatusType
     */
    const NOT_AVAILABLE = 0x00;

    /**
     * @var StatusType
     */
    const DISABLED = 0x01;

    /**
     * @var StatusType
     */
    const ENABLED = 0x02;

    /**
     * @var StatusType
     */
    const CLI_ENABLED = 0x03;
}
