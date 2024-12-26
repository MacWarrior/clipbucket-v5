<?php

namespace FFI\WorkDirectory\Driver;

use FFI\CData;

/**
 * @psalm-suppress all
 *
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal FFI\WorkDirectory
 */
final class WindowsThreadSafeDriver extends ThreadSafeDriver
{
    /**
     * @var string
     */
    const DEFAULT_INTERNAL_ENCODING = 'UTF-8';

    /**
     * @var int
     *
     * @link https://learn.microsoft.com/ru-ru/windows/win32/fileio/maximum-file-path-limitation?tabs=registry
     */
    const DEFAULT_EXPECTED_BUFFER_SIZE = 260;

    /**
     * @var string
     */
    const KERNEL32 = '
        extern int SetDllDirectoryA(const char* lpPathName);
        extern int SetDllDirectoryW(uint16_t* lpPathName);
        extern unsigned long GetDllDirectoryA(unsigned long nBufferLength, char* lpBuffer);
        extern unsigned long GetDllDirectoryW(unsigned long nBufferLength, uint16_t* lpBuffer);
    ';

    /**
     * @var \FFI
     */
    private $ffi;

    /**
     * @var string
     */
    private $internal;

    /**
     * @var string
     */
    private $external;

    public function __construct()
    {
        parent::__construct();

        $this->internal = $this->getDefaultInternalEncoding();
        $this->external = $this->getDefaultExternalEncoding();

        $this->boot();
    }

    private function getDefaultInternalEncoding()
    {
        return \mb_internal_encoding() ?: self::DEFAULT_INTERNAL_ENCODING;
    }

    private function getDefaultExternalEncoding()
    {
        return 'UTF-16' . (\unpack('S', "\x01\x00")[1] === 1 ? 'LE' : 'BE');
    }

    private function boot()
    {
        $this->ffi = \FFI::cdef(self::KERNEL32, 'kernel32.dll');
    }

    public function get()
    {
        $bufferSizeDiv2 = self::DEFAULT_EXPECTED_BUFFER_SIZE;
        $uint16Array = $this->ffi->new("uint16_t[$bufferSizeDiv2]", false);
        $uint16ArrayPointer = \FFI::addr($uint16Array[0]);

        $length = $this->ffi->GetDllDirectoryW(self::DEFAULT_EXPECTED_BUFFER_SIZE, $uint16Array);
        $result = null;

        if ($length !== 0) {
            $char8Array = $this->ffi->cast("char*", $uint16ArrayPointer);
            $char8ArrayPointer = \FFI::addr($char8Array[0]);

            $result = \FFI::string($char8ArrayPointer, $length * 2);
            $result = \mb_convert_encoding($result, $this->internal, $this->external);
        }

        try {
            return $result ?: $this->fallback;
        } finally {
            \FFI::free($uint16Array);
        }
    }

    public function set($directory) :bool
    {
        if (\mb_detect_encoding($directory, 'ASCII', true)) {
            return $this->ffi->SetDllDirectoryA($directory) !== 0;
        }

        $directory = \mb_convert_encoding($directory, $this->external, $this->internal) . "\0\0";

        $bytes = \strlen($directory);
        $charArray = $this->ffi->new("char[$bytes]", false);
        $charArrayPointer = \FFI::addr($charArray[0]);

        \FFI::memcpy($charArrayPointer, $directory, $bytes);

        $bytesDiv2 = (int)\ceil($bytes / 2);
        $uint16Array = \FFI::cast("uint16_t[$bytesDiv2]", $charArray);
        $uint16ArrayPointer = \FFI::addr($uint16Array[0]);

        try {
            return $this->ffi->SetDllDirectoryW(\FFI::addr($uint16Array[0])) !== 0;
        } finally {
            \FFI::free($uint16ArrayPointer);
        }
    }

    public function __serialize() :array
    {
        return \array_merge(parent::__serialize(), [
            'internal' => $this->internal,
            'external' => $this->external,
        ]);
    }

    public function __unserialize(array $data)
    {
        parent::__unserialize($data);

        $this->internal = isset($data['internal']) ? $data['internal'] : $this->getDefaultInternalEncoding();
        $this->external = isset($data['external']) ? $data['external'] : $this->getDefaultExternalEncoding();

        $this->boot();
    }
}
