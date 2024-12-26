<?php
namespace Onnx;

class Library
{

    protected static $folder ;
    const VERSION = '1.20.0';

    const PLATFORMS = [
        'x86_64-linux' => [
            'file' => 'onnxruntime-linux-x64-{{version}}',
            'checksum' => 'aa70d48b22e264b82e83f63245b51ddc9a47ae4a3a66903efaff1ba68b7b5930',
            'lib' => 'libonnxruntime.so.{{version}}',
            'ext' => 'tgz'
        ],
        'aarch64-linux' => [
            'file' => 'onnxruntime-linux-aarch64-{{version}}',
            'checksum' => 'b4d7c6e2c45f8edabe5d28e9bc59ec8d5a4a4af36660cda16e94b2ad85f2a52a',
            'lib' => 'libonnxruntime.so.{{version}}',
            'ext' => 'tgz'
        ],
        'x86_64-darwin' => [
            'file' => 'onnxruntime-osx-x86_64-{{version}}',
            'checksum' => 'd28e603b47b74050f2c30a7069bf3fb371cfba7205d7771f22cabc7b02953757',
            'lib' => 'libonnxruntime.{{version}}.dylib',
            'ext' => 'tgz'
        ],
        'arm64-darwin' => [
            'file' => 'onnxruntime-osx-arm64-{{version}}',
            'checksum' => '2bcfaafa9ff0a3a94f78e3af2f135ffde5bb2d79b08e83a50dbc450b0d20ddae',
            'lib' => 'libonnxruntime.{{version}}.dylib',
            'ext' => 'tgz'
        ],
        'x64-windows' => [
            'file' => 'onnxruntime-win-x64-{{version}}',
            'checksum' => 'b372de85cedd9387a0d4386b982265e8420e5bcc2f29394317e76525b832942e',
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
