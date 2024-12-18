<?php

use Onnx\DType;
use Onnx\Tensor;

class AIVision
{
    protected $tags = [];
    protected $rescale_factor;
    protected $format;
    protected $height;
    protected $width;
    protected $shape; /* batch channel height width */
    protected $modelFilepath;

    protected $provider = 'CPUExecutionProvider';
    protected $model;

    /**
     * @throws Exception
     */
    public function __construct(array $config = [], $lib = null)
    {
        if( !self::isAvailable() ){
            throw new \Exception( 'FFI extension is not available.' );
        }

        Onnx\Library::setFolder(DirPath::get('ai'));
        Onnx\Library::install();

        if(!empty($lib)) {
            if(!is_file($lib)) {
                throw new \Exception( 'Unable to find the lib file : ' . dirname($lib) );
            }

            \Onnx\FFI::$lib = $lib;
            if (\FFI\WorkDirectory\WorkDirectory::set(dirname($lib)) === false) {
                throw new \Exception( 'FAILED to CWD has been updated to: ' . dirname($lib) );
            }
        }

        $this->modelFilepath = self::getModel($config['modelType'] ?? 'nsfw');
        $this->tags = $config['tags'] ?? [];
        $this->rescale_factor = $config['rescale_factor'] ?? 1;
        $this->format = $config['format'] ?? 'rgb';
        $this->height = $config['height'] ?? 256;
        $this->width = $config['width'] ?? 256;
        $this->shape = $config['shape'] ?? 'bchw';

        if( !empty($config['autoload']) ){
            $this->loadModel();
        }
    }

    private static function getModel(string $type)
    {
        $model_filepath = self::downloadModel('nsfw');

        if( !empty($model_filepath) ){
            return $model_filepath;
        }

        return false;
    }

    private static function downloadModel(string $type)
    {
        switch($type){
            default:
                e('Unknown model type : ' . $type);
                return false;

            case 'nsfw':
                $model_name = 'nsfw.onnx';
                $model_url = 'https://huggingface.co/suko/nsfw/resolve/main/model.onnx';
                break;
        }

        $model_filepath = DirPath::get('ai') . 'models' . DIRECTORY_SEPARATOR . $model_name;
        if( is_file($model_filepath) ){
            return $model_filepath;
        }

        ini_set('display_errors',1);
        error_reporting(E_ALL);

        Network::download_file($model_url, $model_filepath);

        if( is_file($model_filepath) && filesize($model_filepath) > 0 ){
            return $model_filepath;
        }

        if( is_file($model_filepath) ){
            unlink($model_filepath);
        }

        e('Something went wrong during ' . $type . ' model type download');
        return false;
    }

    public static function download($url, $filename) {

    }

    public static function isAvailable(): bool
    {
        $php_cli = System::get_software_version('php_cli');
        if( version_compare($php_cli, '7.4.0', '<') ){
            return false;
        }

        if( !in_array(strtolower(ini_get('ffi.enable')), ['1','on']) ){
            return false;
        }

        if( !in_array(strtolower(System::get_php_cli_config('ffi.enable')), ['1','on']) ){
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function loadModel($model = null) {
        if(!empty($model)) {
            $this->modelFilepath = $model;
        }

        if(empty($this->modelFilepath)) {
            throw new \Exception('model missing');
        }

        /** chargement du model */
        $this->model = new \Onnx\Model($this->modelFilepath);
    }

    /**
     * @throws Exception
     */
    public static function createImageGDFromPath($path) {

        $pathParts = pathinfo( $path);
        switch ( strtolower($pathParts["extension"])) {
            case 'png':
                $image = imagecreatefrompng($path);
                break;
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'gif':
                $image = imagecreatefromgif($path);
                break;
            default:
                throw new \Exception('Format de fichier non reconnu');
        }

        return $image;
    }

    /**
     * @throws Exception
     */
    public static function getGDImageFromImg($image, $width, $height)
    {
        $img = self::createImageGDFromPath($image);

        if(imagesx($img) > imagesy($img)) {
            $reduction = imagesx($img) / $width;
        } else {
            $reduction = imagesy($img) / $height;
        }

        /** converti l'image en $this->dimenssion_imagex$this->dimenssion_image  */
        $image2 = imagecreatetruecolor($width, $height); /* dimmension fixe */
        imagefill($image2,0,0,0x7fff0000); /* remplir avec de la transparence */
        imagecopyresampled($image2, $img, 0, 0, 0, 0, floor(imagesx($img)/$reduction), floor(imagesy($img)/$reduction), imagesx($img), imagesy($img)); /* copier l'image */

        return $image2;
    }

    public static function getPixels($img, $format = 'rgb', $rescale_factor = 1): array
    {
        $pixels = [];
        $width = imagesx($img);
        $height = imagesy($img);

        // Mapping for different formats
        $formats = [
            'bgr' => ['blue', 'green', 'red'],
            'rgb' => ['red', 'green', 'blue'],
        ];

        // Ensure the format exists, otherwise default to 'rgb'
        $format = $formats[strtolower($format)] ?? $formats['rgb'];

        for ($y = 0; $y < $height; $y++) {
            $row = [];
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $color = imagecolorsforindex($img, $rgb);
                $row[] = [
                    $color[$format[0]] * $rescale_factor,
                    $color[$format[1]] * $rescale_factor,
                    $color[$format[2]] * $rescale_factor
                ];
            }
            $pixels[] = $row;
        }
        return $pixels;
    }

    /**
     * @throws Exception
     */
    public function getTags($image): array
    {
        /** resize de l'image pour qu'elle soit dans le bon format */
        $img = self::getGDImageFromImg( $image, $this->width, $this->height );

        /** Extraction des pixels */
        $pixels = self::getPixels($img, $this->format, $this->rescale_factor);

        /** converti le shape  */
        $pixels = $this->transposeImage([$pixels], $this->shape);

        /** Récuperation du nom de l'input depuis le model */
        $input_name = $this->model->inputs()[0]['name'];

        $tensor = Tensor::fromArray($pixels,DType::FLOAT32);

        /** prediction IA */
        $result = $this->model->predict([$input_name => $tensor]);

        return $this->postprocess($result);
    }

    function transposeImage($pixels, $format = 'bhwc')
    {
        if(strtolower($format) == 'bhwc') {
            return $pixels;
        }

        $transposedImage = [];

        if($format == 'bchw') {
            foreach ($pixels as $b => $batch) {
                foreach ($batch as $h => $row) {
                    foreach ($row as $w => $pixel) {
                        foreach ($pixel as $c => $value) {
                            $transposedImage[$b][$c][$h][$w] = $value;
                        }
                    }
                }
            }
        }

        return $transposedImage;
    }

    protected function postprocess($result): array
    {
        $t = [];
        $output_name = $this->model->outputs()[0]['name'];

        foreach ($result[$output_name][0] as $idx => $v) {
            if(empty($this->tags[$idx])) {
                continue;
            }
            $t[$this->tags[$idx]] = $v;
        }

        return $t;
    }

    public function setProvider(string $provider = null)
    {
        if(empty($provider)) {
            $this->provider = 'CPUExecutionProvider';
            return;
        }
        $this->provider = $provider;
    }

    /**
     * @throws Exception
     */
    public function is(string $filepath, string $tag): bool
    {
        $tags = $this->getTags($filepath);
        if( isset($tags[$tag]) && $tags[$tag] > 0.8 ){
            return true;
        }
        return false;
    }

}