<?php
namespace Onnx;

class Library
{

    protected static $folder ;
    const VERSION = '1.18.0';

    const PLATFORMS = [
        'x86_64-linux' => [
            'file' => 'onnxruntime-linux-x64-{{version}}',
            'checksum' => 'fa4d11b3fa1b2bf1c3b2efa8f958634bc34edc95e351ac2a0408c6ad5c5504f0',
            'lib' => 'libonnxruntime.so.{{version}}',
            'ext' => 'tgz'
        ],
        'aarch64-linux' => [
            'file' => 'onnxruntime-linux-aarch64-{{version}}',
            'checksum' => 'c278ca7ce725d2b26cf1ec62c93affaec4145a9a3d7721fb5d1af5497136ca76',
            'lib' => 'libonnxruntime.so.{{version}}',
            'ext' => 'tgz'
        ],
        'x86_64-darwin' => [
            'file' => 'onnxruntime-osx-x86_64-{{version}}',
            'checksum' => '3af96893675b295e5e0eb886f470de585089f92f9950158d042fbc02b44ed101',
            'lib' => 'libonnxruntime.{{version}}.dylib',
            'ext' => 'tgz'
        ],
        'arm64-darwin' => [
            'file' => 'onnxruntime-osx-arm64-{{version}}',
            'checksum' => 'c5ff520d2913e3360670979ca4fe43717fc3aa0c0c367a75fbb6f2f15c0cb48d',
            'lib' => 'libonnxruntime.{{version}}.dylib',
            'ext' => 'tgz'
        ],
        'x64-windows' => [
            'file' => 'onnxruntime-win-x64-{{version}}',
            'checksum' => 'a91af21ca8f9bdfa5a1aac3fdd0591384b4e2866d41612925f1758d5522829e7',
            'lib' => 'onnxruntime.dll',
            'ext' => 'zip'
        ]
    ];

    public static function install($event = null)
    {
        $dest = self::defaultLib();
        if (file_exists($dest)) {
            return;
        }

        $dir = self::libDir();
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $file = self::platform('file');
        $ext = self::platform('ext');
        $url = self::withVersion("https://github.com/microsoft/onnxruntime/releases/download/v{{version}}/$file.$ext");
        $contents = file_get_contents($url);

        $checksum = hash('sha256', $contents);
        if ($checksum != self::platform('checksum')) {
            throw new \Exception("Bad checksum: $checksum");
        }

        $tempDest = tempnam(sys_get_temp_dir(), 'onnxruntime') . '.' . $ext;
        file_put_contents($tempDest, $contents);

        $archive = new \PharData($tempDest);
        if ($ext != 'zip') {
            $archive = $archive->decompress();
        }
        $archive->extractTo(self::libDir());
    }

    /**
     * @throws OnnxException
     */
    public static function ThrowExceptionIfLibNotFound()
    {
        $dest = self::defaultLib();
        if (!file_exists($dest)) {
            throw new OnnxException('OnnxRuntime not found');
        }
    }

    public static function defaultLib()
    {
        return self::libDir() . DIRECTORY_SEPARATOR . self::libFile();
    }

    private static function libDir()
    {
        return ( self::$folder ?? dirname(__DIR__)).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR ;
    }

    public static function setFolder(String $path){

        if(!is_dir($path)){
            mkdir($path);
        }

        $path = realpath($path);

        self::$folder = $path;
        FFI::$lib = self::defaultLib();
    }

    private static function libFile()
    {
        return self::withVersion(self::platform('file') . DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR . self::platform('lib'));
    }

    private static function platform($key)
    {
        return self::PLATFORMS[self::platformKey()][$key];
    }

    private static function platformKey()
    {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows') {
            return 'x64-windows';
        } elseif (PHP_OS == 'Darwin') {
            if (php_uname('m') == 'x86_64') {
                return 'x86_64-darwin';
            } else {
                return 'arm64-darwin';
            }
        } else {
            if (php_uname('m') == 'x86_64') {
                return 'x86_64-linux';
            } else {
                return 'aarch64-linux';
            }
        }
    }

    private static function withVersion($str)
    {
        return str_replace('{{version}}', self::VERSION, $str);
    }
}
