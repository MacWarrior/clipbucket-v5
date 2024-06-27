<?php
/**
 * TimThumb by Ben Gillbanks and Mark Maunder
 * Based on work done by Tim McDaniels and Darren Hoyt
 * http://code.google.com/p/timthumb/
 *
 * GNU General Public License, version 2
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * Examples and documentation available on the project homepage
 * http://www.binarymoon.co.uk/projects/timthumb/
 *
 * $Rev$
 */

const VERSION = 'CB5.5.1';                     // Version of this script ; original version 2.8.14

const DEBUG_ON = false;                       // Enable debug logging to web server error log (STDERR)
const DEBUG_LEVEL = 1;                        // Debug level 1 is less noisy and 3 is the most noisy
const MEMORY_LIMIT = '30M';                   // Set PHP memory limit
const DISPLAY_ERROR_MESSAGES = true;          // Display error messages. Set to false to turn off errors (good for production websites)
//Image fetching and caching
const ALLOW_EXTERNAL = false;                 // Allow image fetching from external websites. Will check against ALLOWED_SITES if ALLOW_ALL_EXTERNAL_SITES is false
const ALLOW_ALL_EXTERNAL_SITES = false;       // Less secure. 
const FILE_CACHE_ENABLED = true;              // Should we store resized/modified images on disk to speed things up?
const FILE_CACHE_TIME_BETWEEN_CLEANS = 86400; // How often the cache is cleaned
const FILE_CACHE_MAX_FILE_AGE = 86400;        // How old does a file have to be to be deleted from the cache
const FILE_CACHE_SUFFIX = '.cache';    // What to put at the end of all files in the cache directory so we can identify them
const FILE_CACHE_PREFIX = '';                 // What to put at the beg of all files in the cache directory so we can identify them
define('FILE_CACHE_DIRECTORY', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'cb_server_thumb');             // Directory where images are cached. Left blank it will use the system temporary directory (which is better for security)
const MAX_FILE_SIZE = 10485760;               // 10 Megs is 10485760. This is the max internal or external file size that we'll process.
const CURL_TIMEOUT = 20;                      // Timeout duration for Curl. This only applies if you have Curl installed and aren't using PHP's default URL fetching mechanism.
const WAIT_BETWEEN_FETCH_ERRORS = 3600;       // Time to wait between errors fetching remote file
//Browser caching
const BROWSER_CACHE_MAX_AGE = 864000;         // Time to cache in the browser
const BROWSER_CACHE_DISABLE = false;          // Use for testing if you want to disable all browser caching
//Image size and defaults
const MAX_WIDTH = 1500;                       // Maximum image width
const MAX_HEIGHT = 1500;                      // Maximum image height
const NOT_FOUND_IMAGE = '';                   // Image to serve if any 404 occurs
const ERROR_IMAGE = '';                       // Image to serve if an error occurs instead of showing error message
const PNG_IS_TRANSPARENT = false;             // Define if a png image should have a transparent background color. Use False value if you want to display a custom coloured canvas_colour
const DEFAULT_Q = 90;                         // Default image quality
const DEFAULT_ZC = 1;                         // Default zoom/crop setting
const DEFAULT_F = '';                         // Default image filters
const DEFAULT_S = 0;                          // Default sharpen value
const DEFAULT_CC = 'ffffff';                  // Default canvas colour
const DEFAULT_WIDTH = 100;                    // Default thumbnail width
const DEFAULT_HEIGHT = 100;                   // Default thumbnail height
//Image compression is enabled if either of these point to valid paths
//These are now disabled by default because the file sizes of PNGs (and GIFs) are much smaller than we used to generate. 
//They only work for PNGs. GIFs and JPEGs are not affected.

// If ALLOW_EXTERNAL is true and ALLOW_ALL_EXTERNAL_SITES is false, then external images will only be fetched from these domains and their subdomains. 
if (!isset($ALLOWED_SITES)) {
    $ALLOWED_SITES = [
        'flickr.com',
        'staticflickr.com',
        'picasa.com',
        'img.youtube.com',
        'upload.wikimedia.org',
        'photobucket.com',
        'imgur.com',
        'imageshack.us',
        'tinypic.com'
    ];
}
// -------------------------------------------------------------
// -------------- STOP EDITING CONFIGURATION HERE --------------
// -------------------------------------------------------------

timthumb::start();

class timthumb
{
    protected $src = '';
    protected $is404 = false;
    protected $docRoot = '';
    protected $lastURLError = false;
    protected $localImage = '';
    protected $localImageMTime = 0;
    protected $url = false;
    protected $myHost = '';
    protected $isURL = false;
    protected $cachefile = '';
    protected $errors = [];
    protected $toDeletes = [];
    protected $cacheDirectory = '';
    protected $startTime = 0;
    protected $lastBenchTime = 0;
    protected $cropTop = false;
    protected $salt = '';
    protected $fileCacheVersion = 1; //Generally if timthumb.php is modifed (upgraded) then the salt changes and all cache files are recreated. This is a backup mechanism to force regen.
    protected $filePrependSecurityBlock = "<?php die('Execution denied!'); //"; //Designed to have three letter mime type, space, question mark and greater than symbol appended. 6 bytes total.
    protected static $curlDataWritten = 0;
    protected static $curlFH = false;

    public static function start()
    {
        $tim = new timthumb();
        $tim->handleErrors();
        if ($tim->tryBrowserCache()) {
            exit(0);
        }
        $tim->handleErrors();
        if (FILE_CACHE_ENABLED && $tim->tryServerCache()) {
            exit(0);
        }
        $tim->handleErrors();
        $tim->run();
        $tim->handleErrors();
        exit(0);
    }

    public function __construct()
    {
        global $ALLOWED_SITES;
        $this->startTime = microtime(true);
        date_default_timezone_set('UTC');
        $this->debug(1, 'Starting new request from ' . $this->getIP() . ' to ' . $_SERVER['REQUEST_URI']);
        $this->calcDocRoot();
        //On windows systems I'm assuming fileinode returns an empty string or a number that doesn't change. Check this.
        $this->salt = @filemtime(__FILE__) . '-' . @fileinode(__FILE__);
        $this->debug(3, "Salt is: " . $this->salt);
        if (FILE_CACHE_DIRECTORY) {
            $this->cacheDirectory = FILE_CACHE_DIRECTORY;
        } else {
            $this->cacheDirectory = sys_get_temp_dir();
        }
        //Clean the cache before we do anything because we don't want the first visitor after FILE_CACHE_TIME_BETWEEN_CLEANS expires to get a stale image. 
        $this->cleanCache();

        $this->myHost = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']);
        $this->src = $this->param('src');
        $this->url = parse_url($this->src);
        $directory = $this->param('directory');

        if ($_GET['type'] == 'users') {
            $this->src = $directory . preg_replace('/https?:\/\/(?:www\.)?' . $this->myHost . '/i', '', $this->src);
        } else {
            $this->src = 'files/' . $directory . preg_replace('/https?:\/\/(?:www\.)?' . $this->myHost . '/i', '', $this->src);
        }

        if (strlen($this->src) <= 3) {
            $this->error('No image specified');
            return false;
        }

        if (preg_match('/^https?:\/\/[^\/]+/i', $this->src)) {
            $this->debug(2, 'Is a request for an external URL: ' . $this->src);
            $this->isURL = true;
        }

        $this->debug(2, 'Is a request for an internal file: ' . $this->src);
        if ($this->isURL && (!ALLOW_EXTERNAL)) {
            $this->error('You are not allowed to fetch images from an external website.');
            return false;
        }

        if ($this->isURL) {
            if (ALLOW_ALL_EXTERNAL_SITES) {
                $this->debug(2, 'Fetching from all external sites is enabled.');
            } else {
                $this->debug(2, 'Fetching only from selected external sites is enabled.');
                $allowed = false;
                foreach ($ALLOWED_SITES as $site) {
                    if ((strtolower(substr($this->url['host'], -strlen($site) - 1)) === strtolower(".$site")) || (strtolower($this->url['host']) === strtolower($site))) {
                        $this->debug(3, "URL hostname {$this->url['host']} matches $site so allowing.");
                        $allowed = true;
                    }
                }
                if (!$allowed) {
                    return $this->error('You may not fetch images from that site. To enable this site in timthumb, you can either add it to $ALLOWED_SITES and set ALLOW_EXTERNAL=true. Or you can set ALLOW_ALL_EXTERNAL_SITES=true, depending on your security needs.');
                }
            }
        }

        $cachePrefix = ($this->isURL ? '_ext_' : '_int_');
        if ($this->isURL) {
            $arr = explode('&', $_SERVER ['QUERY_STRING']);
            asort($arr);
            $this->cachefile = $this->cacheDirectory . DIRECTORY_SEPARATOR . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . implode('', $arr) . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
        } else {
            $this->localImage = $this->getLocalImagePath($this->src);
            if (!$this->localImage) {
                $this->debug(1, "Could not find the local image: {$this->localImage}");
                $this->error('Could not find the internal image you specified.');
                $this->set404();
                return false;
            }
            $this->debug(1, "Local image path is {$this->localImage}");
            $this->localImageMTime = @filemtime($this->localImage);
            //We include the mtime of the local file in case in changes on disk.
            $this->cachefile = $this->cacheDirectory . DIRECTORY_SEPARATOR . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . $this->localImageMTime . $_SERVER ['QUERY_STRING'] . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
        }
        $this->debug(2, 'Cache file is: ' . $this->cachefile);

        return true;
    }

    public function __destruct()
    {
        foreach ($this->toDeletes as $del) {
            $this->debug(2, "Deleting temp file $del");
            @unlink($del);
        }
    }

    public function run(): bool
    {
        if ($this->isURL) {
            if (!ALLOW_EXTERNAL) {
                $this->debug(1, 'Got a request for an external image but ALLOW_EXTERNAL is disabled so returning error msg.');
                $this->error('You are not allowed to fetch images from an external website.');
                return false;
            }
            $this->debug(3, 'Got request for external image. Starting serveExternalImage.');
            if ($this->param('webshot')) {
                $this->error('You added the webshot parameter but webshots are disabled on this server. You need to set WEBSHOT_ENABLED == true to enable webshots.');
            } else {
                $this->debug(3, 'webshot is NOT set so we\'re going to try to fetch a regular image.');
                $this->serveExternalImage();
            }
        } else {
            $this->debug(3, 'Got request for internal image. Starting serveInternalImage()');
            $this->serveInternalImage();
        }
        return true;
    }

    protected function handleErrors()
    {
        if ($this->haveErrors()) {
            if (NOT_FOUND_IMAGE && $this->is404()) {
                if ($this->serveImg(NOT_FOUND_IMAGE)) {
                    exit(0);
                }
                $this->error('Additionally, the 404 image that is configured could not be found or there was an error serving it.');
            }
            if (ERROR_IMAGE) {
                if ($this->serveImg(ERROR_IMAGE)) {
                    exit(0);
                }
                $this->error('Additionally, the error image that is configured could not be found or there was an error serving it.');
            }
            $this->serveErrors();
            exit(0);
        }
        return false;
    }

    protected function tryBrowserCache()
    {
        if (BROWSER_CACHE_DISABLE) {
            $this->debug(3, 'Browser caching is disabled');
            return false;
        }
        if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $this->debug(3, 'Got a conditional get');
            $mtime = false;
            //We've already checked if the real file exists in the constructor
            if (!is_file($this->cachefile)) {
                //If we don't have something cached, regenerate the cached image.
                return false;
            }
            if ($this->localImageMTime) {
                $mtime = $this->localImageMTime;
                $this->debug(3, "Local real file's modification time is $mtime");
            } else {
                if (is_file($this->cachefile)) { //If it's not a local request then use the mtime of the cached file to determine the 304
                    $mtime = @filemtime($this->cachefile);
                    $this->debug(3, "Cached file's modification time is $mtime");
                }
            }
            if (!$mtime) {
                return false;
            }

            $iftime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
            $this->debug(3, "The conditional get's if-modified-since unixtime is $iftime");
            if ($iftime < 1) {
                $this->debug(3, 'Got an invalid conditional get modified since time. Returning false.');
                return false;
            }
            if ($iftime < $mtime) { //Real file or cache file has been modified since last request, so force refetch.
                $this->debug(3, 'File has been modified since last fetch.');
                return false;
            }
            //Otherwise serve a 304
            $this->debug(3, 'File has not been modified since last get, so serving a 304.');
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            $this->debug(1, 'Returning 304 not modified');
            return true;
        }
        return false;
    }

    protected function tryServerCache(): bool
    {
        $this->debug(3, 'Trying server cache');
        if (file_exists($this->cachefile)) {
            $this->debug(3, "Cachefile {$this->cachefile} exists");
            if ($this->isURL) {
                $this->debug(3, 'This is an external request, so checking if the cachefile is empty which means the request failed previously.');
                if (filesize($this->cachefile) < 1) {
                    $this->debug(3, 'Found an empty cachefile indicating a failed earlier request. Checking how old it is.');
                    //Fetching error occured previously
                    if (time() - @filemtime($this->cachefile) > WAIT_BETWEEN_FETCH_ERRORS) {
                        $this->debug(3, 'File is older than ' . WAIT_BETWEEN_FETCH_ERRORS . ' seconds. Deleting and returning false so app can try and load file.');
                        @unlink($this->cachefile);
                        return false; //to indicate we didn't serve from cache and app should try and load
                    }
                    $this->debug(3, 'Empty cachefile is still fresh so returning message saying we had an error fetching this image from remote host.');
                    $this->set404();
                    $this->error('An error occured fetching image.');
                    return false;
                }
            } else {
                $this->debug(3, "Trying to serve cachefile {$this->cachefile}");
            }
            if ($this->serveCacheFile()) {
                $this->debug(3, "Succesfully served cachefile {$this->cachefile}");
                return true;
            }
            $this->debug(3, "Failed to serve cachefile {$this->cachefile} - Deleting it from cache.");
            //Image serving failed. We can't retry at this point, but lets remove it from cache so the next request recreates it
            @unlink($this->cachefile);
            return true;
        }
        return false;
    }

    protected function error($err): bool
    {
        $this->debug(3, "Adding error message: $err");
        $this->errors[] = $err;
        return false;

    }

    protected function haveErrors(): bool
    {
        if (sizeof($this->errors) > 0) {
            return true;
        }
        return false;
    }

    protected function serveErrors()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        if (!DISPLAY_ERROR_MESSAGES) {
            return;
        }
        $html = '<ul>';
        foreach ($this->errors as $err) {
            $html .= '<li>' . htmlentities($err) . '</li>';
        }
        $html .= '</ul>';
        echo '<h1>A TimThumb error has occured</h1>The following error(s) occured:<br />' . $html . '<br />';
        echo '<br />Query String : ' . htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES);
        echo '<br />TimThumb version : ' . VERSION . '</pre>';
    }

    protected function serveInternalImage(): bool
    {
        $this->debug(3, "Local image path is $this->localImage");
        if (!$this->localImage) {
            $this->sanityFail('localImage not set after verifying it earlier in the code.');
            return false;
        }
        $fileSize = filesize($this->localImage);
        if ($fileSize > MAX_FILE_SIZE) {
            $this->error('The file you specified is greater than the maximum allowed file size.');
            return false;
        }
        if ($fileSize <= 0) {
            $this->error('The file you specified is <= 0 bytes.');
            return false;
        }
        $this->debug(3, 'Calling processImageAndWriteToCache() for local image.');
        if ($this->processImageAndWriteToCache($this->localImage)) {
            $this->serveCacheFile();
            return true;
        }
        return false;
    }

    protected function cleanCache(): bool
    {
        if (FILE_CACHE_TIME_BETWEEN_CLEANS < 0) {
            return true;
        }
        $this->debug(3, 'cleanCache() called');
        $lastCleanFile = $this->cacheDirectory . '/timthumb_cache.time';

        //If this is a new timthumb installation we need to create the file
        if (!is_file($lastCleanFile)) {
            $this->debug(1, "File tracking last clean doesn't exist. Creating $lastCleanFile");
            if (!touch($lastCleanFile)) {
                $this->error('Could not create cache clean timestamp file.');
            }
            return false;
        }
        if (@filemtime($lastCleanFile) < (time() - FILE_CACHE_TIME_BETWEEN_CLEANS)) { //Cache was last cleaned more than 1 day ago
            $this->debug(1, 'Cache was last cleaned more than ' . FILE_CACHE_TIME_BETWEEN_CLEANS . ' seconds ago. Cleaning now.');
            // Very slight race condition here, but worst case we'll have 2 or 3 servers cleaning the cache simultaneously once a day.
            if (!touch($lastCleanFile)) {
                $this->error('Could not create cache clean timestamp file.');
            }
            $files = glob($this->cacheDirectory . DIRECTORY_SEPARATOR . '*' . FILE_CACHE_SUFFIX);
            if ($files) {
                $timeAgo = time() - FILE_CACHE_MAX_FILE_AGE;
                foreach ($files as $file) {
                    if (@filemtime($file) < $timeAgo) {
                        $this->debug(3, "Deleting cache file $file older than max age: " . FILE_CACHE_MAX_FILE_AGE . ' seconds');
                        @unlink($file);
                    }
                }
            }
            return true;
        }

        $this->debug(3, 'Cache was cleaned less than ' . FILE_CACHE_TIME_BETWEEN_CLEANS . ' seconds ago so no cleaning needed.');
        return false;
    }

    protected function processImageAndWriteToCache($localImage): bool
    {
        $sData = getimagesize($localImage);
        $origType = $sData[2];
        $mimeType = $sData['mime'];

        $this->debug(3, "Mime type of image is $mimeType");
        if (!preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $mimeType)) {
            return $this->error('The image being resized is not a valid gif, jpg or png.');
        }

        if (!function_exists('imagecreatetruecolor')) {
            return $this->error('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library');
        }

        if (function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
            $imageFilters = [
                1  => [IMG_FILTER_NEGATE, 0],
                2  => [IMG_FILTER_GRAYSCALE, 0],
                3  => [IMG_FILTER_BRIGHTNESS, 1],
                4  => [IMG_FILTER_CONTRAST, 1],
                5  => [IMG_FILTER_COLORIZE, 4],
                6  => [IMG_FILTER_EDGEDETECT, 0],
                7  => [IMG_FILTER_EMBOSS, 0],
                8  => [IMG_FILTER_GAUSSIAN_BLUR, 0],
                9  => [IMG_FILTER_SELECTIVE_BLUR, 0],
                10 => [IMG_FILTER_MEAN_REMOVAL, 0],
                11 => [IMG_FILTER_SMOOTH, 0]
            ];
        }

        // get standard input properties        
        $new_width = (int)abs($this->param('w', 0));
        $new_height = (int)abs($this->param('h', 0));
        $zoom_crop = (int)$this->param('zc', DEFAULT_ZC);
        $quality = (int)abs($this->param('q', DEFAULT_Q));
        $align = $this->cropTop ? 't' : $this->param('a', 'c');
        $filters = $this->param('f', DEFAULT_F);
        $sharpen = (bool)$this->param('s', DEFAULT_S);
        $canvas_color = $this->param('cc', DEFAULT_CC);
        $canvas_trans = (bool)$this->param('ct', '1');

        // set default width and height if neither are set already
        if ($new_width == 0 && $new_height == 0) {
            $new_width = (int)DEFAULT_WIDTH;
            $new_height = (int)DEFAULT_HEIGHT;
        }

        // ensure size limits can not be abused
        $new_width = min($new_width, MAX_WIDTH);
        $new_height = min($new_height, MAX_HEIGHT);

        // set memory limit to be able to have enough space to resize larger images
        $this->setMemoryLimit();

        // open the existing image
        $image = $this->openImage($mimeType, $localImage);
        if ($image === false) {
            return $this->error('Unable to open image.');
        }

        // Get original width and height
        $width = imagesx($image);
        $height = imagesy($image);
        $origin_x = 0;
        $origin_y = 0;

        // generate new w/h if not provided
        if ($new_width && !$new_height) {
            $new_height = floor($height * ($new_width / $width));
        } else {
            if ($new_height && !$new_width) {
                $new_width = floor($width * ($new_height / $height));
            }
        }

        // scale down and add borders
        if ($zoom_crop == 3) {
            $final_height = $height * ($new_width / $width);

            if ($final_height > $new_height) {
                $new_width = $width * ($new_height / $height);
            } else {
                $new_height = $final_height;
            }
        }

        // create a new true color image
        $canvas = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($canvas, false);

        if (strlen($canvas_color) == 3) { //if is 3-char notation, edit string into 6-char notation
            $canvas_color = str_repeat(substr($canvas_color, 0, 1), 2) . str_repeat(substr($canvas_color, 1, 1), 2) . str_repeat(substr($canvas_color, 2, 1), 2);
        } else {
            if (strlen($canvas_color) != 6) {
                $canvas_color = DEFAULT_CC; // on error return default canvas color
            }
        }

        $canvas_color_R = hexdec(substr($canvas_color, 0, 2));
        $canvas_color_G = hexdec(substr($canvas_color, 2, 2));
        $canvas_color_B = hexdec(substr($canvas_color, 4, 2));

        // Create a new transparent color for image
        // If is a png and PNG_IS_TRANSPARENT is false then remove the alpha transparency
        // (and if is set a canvas color show it in the background)
        if (preg_match('/^image\/png$/i', $mimeType) && !PNG_IS_TRANSPARENT && $canvas_trans) {
            $color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
        } else {
            $color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 0);
        }

        // Completely fill the background of the new image with allocated color.
        imagefill($canvas, 0, 0, $color);

        // scale down and add borders
        if ($zoom_crop == 2) {
            $final_height = $height * ($new_width / $width);

            if ($final_height > $new_height) {
                $origin_x = $new_width / 2;
                $new_width = $width * ($new_height / $height);
                $origin_x = round($origin_x - ($new_width / 2));
            } else {
                $origin_y = $new_height / 2;
                $new_height = $final_height;
                $origin_y = round($origin_y - ($new_height / 2));
            }
        }

        // Restore transparency blending
        imagesavealpha($canvas, true);

        if ($zoom_crop > 0) {
            $src_x = $src_y = 0;
            $src_w = $width;
            $src_h = $height;

            $cmp_x = $width / $new_width;
            $cmp_y = $height / $new_height;

            // calculate x or y coordinate and width or height of source
            if ($cmp_x > $cmp_y) {
                $src_w = round($width / $cmp_x * $cmp_y);
                $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
            } else {
                if ($cmp_y > $cmp_x) {
                    $src_h = round($height / $cmp_y * $cmp_x);
                    $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
                }
            }

            // positional cropping!
            if ($align) {
                if (strpos($align, 't') !== false) {
                    $src_y = 0;
                }
                if (strpos($align, 'b') !== false) {
                    $src_y = $height - $src_h;
                }
                if (strpos($align, 'l') !== false) {
                    $src_x = 0;
                }
                if (strpos($align, 'r') !== false) {
                    $src_x = $width - $src_w;
                }
            }

            imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
        } else {
            // copy and resize part of an image with resampling
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        }

        if ($filters != '' && function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
            // apply filters to image
            $filterList = explode('|', $filters);
            foreach ($filterList as $fl) {

                $filterSettings = explode(',', $fl);
                if (isset ($imageFilters[$filterSettings[0]])) {

                    for ($i = 0; $i < 4; $i++) {
                        if (!isset ($filterSettings[$i])) {
                            $filterSettings[$i] = null;
                        } else {
                            $filterSettings[$i] = (int)$filterSettings[$i];
                        }
                    }

                    switch ($imageFilters[$filterSettings[0]][1]) {
                        case 1:
                            imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]);
                            break;

                        case 2:
                            imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]);
                            break;

                        case 3:
                            imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]);
                            break;

                        case 4:
                            imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3], $filterSettings[4]);
                            break;

                        default:
                            imagefilter($canvas, $imageFilters[$filterSettings[0]][0]);
                            break;
                    }
                }
            }
        }

        // sharpen image
        if ($sharpen && function_exists('imageconvolution')) {

            $sharpenMatrix = [
                [-1, -1, -1],
                [-1, 16, -1],
                [-1, -1, -1]
            ];

            $divisor = 8;
            $offset = 0;

            imageconvolution($canvas, $sharpenMatrix, $divisor, $offset);

        }
        //Straight from Wordpress core code. Reduces filesize by up to 70% for PNG's
        if ((IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor($image) && imagecolortransparent($image) > 0) {
            imagetruecolortopalette($canvas, false, imagecolorstotal($image));
        }

        $imgType = '';
        $tempfile = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
        if (preg_match('/^image\/(?:jpg|jpeg)$/i', $mimeType)) {
            $imgType = 'jpg';
            imagejpeg($canvas, $tempfile, $quality);
        } else {
            if (preg_match('/^image\/png$/i', $mimeType)) {
                $imgType = 'png';
                imagepng($canvas, $tempfile, floor($quality * 0.09));
            } else {
                if (preg_match('/^image\/gif$/i', $mimeType)) {
                    $imgType = 'gif';
                    imagegif($canvas, $tempfile);
                } else {
                    return $this->sanityFail('Could not match mime type after verifying it previously.');
                }
            }
        }

        $this->debug(3, 'Rewriting image with security header.');
        $tempfile4 = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
        $context = stream_context_create();
        $fp = fopen($tempfile, 'r', 0, $context);
        file_put_contents($tempfile4, $this->filePrependSecurityBlock . $imgType . ' ?' . '>'); //6 extra bytes, first 3 being image type 
        file_put_contents($tempfile4, $fp, FILE_APPEND);
        fclose($fp);
        @unlink($tempfile);
        $this->debug(3, 'Locking and replacing cache file.');
        $lockFile = $this->cachefile . '.lock';
        $fh = fopen($lockFile, 'w');
        if (!$fh) {
            return $this->error('Could not open the lockfile for writing an image.');
        }
        if (flock($fh, LOCK_EX)) {
            @unlink($this->cachefile); //rename generally overwrites, but doing this in case of platform specific quirks. File might not exist yet.
            rename($tempfile4, $this->cachefile);
            flock($fh, LOCK_UN);
            fclose($fh);
            @unlink($lockFile);
        } else {
            fclose($fh);
            @unlink($lockFile);
            @unlink($tempfile4);
            return $this->error('Could not get a lock for writing.');
        }
        $this->debug(3, 'Done image replace with security header. Cleaning up and running cleanCache()');
        imagedestroy($canvas);
        imagedestroy($image);
        return true;
    }

    protected function calcDocRoot()
    {
        require_once dirname(__DIR__, 2). DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
        $this->docRoot = DirPath::get('root');
    }

    protected function getLocalImagePath($src)
    {
        $src = ltrim($src, '/'); //strip off the leading '/'
        if (!$this->docRoot) {
            $this->debug(3, 'We have no document root set, so as a last resort, lets check if the image is in the current dir and serve that.');
            //We don't support serving images outside the current dir if we don't have a doc root for security reasons.
            $file = preg_replace('/^.*?([^\/\\\\]+)$/', '$1', $src); //strip off any path info and just leave the filename.

            if (is_file($file)) {
                return $this->realpath($file);
            }
            return $this->error('Could not find your website document root and the file specified doesn\'t exist in timthumbs directory. We don\'t support serving files outside timthumb\'s directory without a document root for security reasons.');
        } else {
            if (!is_dir($this->docRoot)) {
                $this->error('Server path does not exist. Ensure variable $_SERVER[\'DOCUMENT_ROOT\'] is set correctly');
            }
        }

        //Do not go past this point without docRoot set

        //Try src under docRoot
        if (file_exists($this->docRoot . DIRECTORY_SEPARATOR . $src)) {
            $this->debug(3, 'Found file as ' . $this->docRoot . DIRECTORY_SEPARATOR . $src);
            $real = $this->realpath($this->docRoot . DIRECTORY_SEPARATOR . $src);
            if (stripos($real, $this->docRoot) === 0) {
                return $real;
            }
            $this->debug(1, 'Security block: The file specified occurs outside the document root.');
            //allow search to continue
        }
        //Check absolute paths and then verify the real path is under doc root
        $absolute = $this->realpath(DIRECTORY_SEPARATOR . $src);
        if ($absolute && file_exists($absolute)) { //realpath does file_exists check, so can probably skip the exists check here
            $this->debug(3, "Found absolute path: $absolute");
            if (!$this->docRoot) {
                $this->sanityFail('docRoot not set when checking absolute path.');
            }
            if (stripos($absolute, $this->docRoot) === 0) {
                return $absolute;
            }
            $this->debug(1, 'Security block: The file specified occurs outside the document root.');
            //and continue search
        }

        $base = $this->docRoot;

        if (file_exists($base . $src)) {
            return $base . $src;
        }

        return false;
    }

    protected function realpath($path)
    {
        //try to remove any relative paths
        $remove_relatives = '/\w+\/\.\.\//';
        while (preg_match($remove_relatives, $path)) {
            $path = preg_replace($remove_relatives, '', $path);
        }
        //if any remain use PHP realpath to strip them out, otherwise return $path
        //if using realpath, any symlinks will also be resolved
        return preg_match('#^\.\./|/\.\./#', $path) ? realpath($path) : $path;
    }

    protected function toDelete($name)
    {
        $this->debug(3, "Scheduling file $name to delete on destruct.");
        $this->toDeletes[] = $name;
    }

    protected function serveExternalImage(): bool
    {
        if (!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $this->src)) {
            $this->error('Invalid URL supplied.');
            return false;
        }
        $tempfile = tempnam($this->cacheDirectory, 'timthumb');
        $this->debug(3, "Fetching external image into temporary file $tempfile");
        $this->toDelete($tempfile);
        #fetch file here
        if (!$this->getURL($this->src, $tempfile)) {
            @unlink($this->cachefile);
            touch($this->cachefile);
            $this->debug(3, 'Error fetching URL: ' . $this->lastURLError);
            $this->error('Error reading the URL you specified from remote host.' . $this->lastURLError);
            return false;
        }

        $mimeType = $this->getMimeType($tempfile);
        if (!preg_match("/^image\/(?:jpg|jpeg|gif|png)$/i", $mimeType)) {
            $this->debug(3, "Remote file has invalid mime type: $mimeType");
            @unlink($this->cachefile);
            touch($this->cachefile);
            $this->error("The remote file is not a valid image. Mimetype = '" . $mimeType . "'" . $tempfile);
            return false;
        }
        if ($this->processImageAndWriteToCache($tempfile)) {
            $this->debug(3, 'Image processed succesfully. Serving from cache');
            return $this->serveCacheFile();
        }
        return false;
    }

    public static function curlWrite($h, $d): int
    {
        fwrite(self::$curlFH, $d);
        self::$curlDataWritten += strlen($d);
        if (self::$curlDataWritten > MAX_FILE_SIZE) {
            return 0;
        }
        return strlen($d);
    }

    protected function serveCacheFile(): bool
    {
        $this->debug(3, "Serving {$this->cachefile}");
        if (!is_file($this->cachefile)) {
            $this->error('serveCacheFile called in timthumb but we couldn\'t find the cached file.');
            return false;
        }
        $fp = fopen($this->cachefile, 'rb');
        if (!$fp) {
            return $this->error('Could not open cachefile.');
        }
        fseek($fp, strlen($this->filePrependSecurityBlock), SEEK_SET);
        $imgType = fread($fp, 3);
        fseek($fp, 3, SEEK_CUR);
        if (ftell($fp) != strlen($this->filePrependSecurityBlock) + 6) {
            @unlink($this->cachefile);
            return $this->error('The cached image file seems to be corrupt.');
        }
        $imageDataSize = filesize($this->cachefile) - (strlen($this->filePrependSecurityBlock) + 6);
        $this->sendImageHeaders($imgType, $imageDataSize);
        $bytesSent = @fpassthru($fp);
        fclose($fp);
        if ($bytesSent > 0) {
            return true;
        }
        $content = file_get_contents($this->cachefile);
        if ($content != false) {
            $content = substr($content, strlen($this->filePrependSecurityBlock) + 6);
            echo $content;
            $this->debug(3, 'Served using file_get_contents and echo');
            return true;
        }
        $this->error('Cache file could not be loaded.');
        return false;
    }

    protected function sendImageHeaders($mimeType, $dataSize): bool
    {
        if (!preg_match('/^image\//i', $mimeType)) {
            $mimeType = 'image/' . $mimeType;
        }
        if (strtolower($mimeType) == 'image/jpg') {
            $mimeType = 'image/jpeg';
        }
        $gmdate_expires = gmdate('D, d M Y H:i:s', strtotime('now +10 days')) . ' GMT';
        $gmdate_modified = gmdate('D, d M Y H:i:s') . ' GMT';
        // send content headers then display image
        header('Content-Type: ' . $mimeType);
        header('Accept-Ranges: none'); //Changed this because we don't accept range requests
        header('Last-Modified: ' . $gmdate_modified);
        header('Content-Length: ' . $dataSize);
        if (BROWSER_CACHE_DISABLE) {
            $this->debug(3, 'Browser cache is disabled so setting non-caching headers.');
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
        } else {
            $this->debug(3, 'Browser caching is enabled');
            header('Cache-Control: max-age=' . BROWSER_CACHE_MAX_AGE . ', must-revalidate');
            header('Expires: ' . $gmdate_expires);
        }
        return true;
    }

    protected function param($property, $default = '')
    {
        if (isset ($_GET[$property])) {
            return $_GET[$property];
        }
        return $default;
    }

    protected function openImage($mimeType, $src)
    {
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($src);
                break;

            case 'image/png':
                $image = imagecreatefrompng($src);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;

            case 'image/gif':
                $image = imagecreatefromgif($src);
                break;

            default:
                $this->error('Unrecognised mimeType');
                break;
        }

        return $image;
    }

    protected function getIP()
    {
        $rem = @$_SERVER['REMOTE_ADDR'];
        $ff = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $ci = @$_SERVER['HTTP_CLIENT_IP'];
        if (preg_match('/^(?:192\.168|172\.16|10\.|127\.)/', $rem)) {
            if ($ff) {
                return $ff;
            }
            if ($ci) {
                return $ci;
            }
            return $rem;
        }

        if ($rem) {
            return $rem;
        }
        if ($ff) {
            return $ff;
        }
        if ($ci) {
            return $ci;
        }
        return 'UNKNOWN';
    }

    protected function debug($level, $msg)
    {
        if (DEBUG_ON && $level <= DEBUG_LEVEL) {
            $execTime = sprintf('%.6f', microtime(true) - $this->startTime);
            $tick = sprintf('%.6f', 0);
            if ($this->lastBenchTime > 0) {
                $tick = sprintf('%.6f', microtime(true) - $this->lastBenchTime);
            }
            $this->lastBenchTime = microtime(true);
            error_log('TimThumb Debug line ' . __LINE__ . " [$execTime : $tick]: $msg");
        }
    }

    protected function sanityFail($msg): bool
    {
        return $this->error("There is a problem in the timthumb code. Message: Please report this error at <a href='http://code.google.com/p/timthumb/issues/list'>timthumb's bug tracking page</a>: $msg");
    }

    protected function getMimeType($file)
    {
        $info = getimagesize($file);
        if (is_array($info) && $info['mime']) {
            return $info['mime'];
        }
        return '';
    }

    protected function setMemoryLimit()
    {
        $inimem = ini_get('memory_limit');
        $inibytes = timthumb::returnBytes($inimem);
        $ourbytes = timthumb::returnBytes(MEMORY_LIMIT);
        if ($inibytes < $ourbytes) {
            ini_set('memory_limit', MEMORY_LIMIT);
            $this->debug(3, "Increased memory from $inimem to " . MEMORY_LIMIT);
        } else {
            $this->debug(3, 'Not adjusting memory size because the current setting is ' . $inimem . ' and our size of ' . MEMORY_LIMIT . ' is smaller.');
        }
    }

    protected static function returnBytes($size_str)
    {
        switch (substr($size_str, -1)) {
            case 'M':
            case 'm':
                return (int)$size_str * 1048576;
            case 'K':
            case 'k':
                return (int)$size_str * 1024;
            case 'G':
            case 'g':
                return (int)$size_str * 1073741824;
            default:
                return $size_str;
        }
    }

    protected function getURL($url, $tempfile): bool
    {
        $this->lastURLError = false;
        $url = preg_replace('/ /', '%20', $url);
        if (function_exists('curl_init')) {
            $this->debug(3, 'Curl is installed so using it to fetch URL.');
            self::$curlFH = fopen($tempfile, 'w');
            if (!self::$curlFH) {
                $this->error("Could not open $tempfile for writing.");
                return false;
            }
            self::$curlDataWritten = 0;
            $this->debug(3, "Fetching url with curl: $url");
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_WRITEFUNCTION, 'timthumb::curlWrite');
            @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            @curl_setopt($curl, CURLOPT_MAXREDIRS, 10);

            $curlResult = curl_exec($curl);
            fclose(self::$curlFH);
            $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpStatus == 404) {
                $this->set404();
            }
            if ($httpStatus == 302) {
                $this->error('External Image is Redirecting. Try alternate image url');
                return false;
            }
            if ($curlResult) {
                curl_close($curl);
                return true;
            }
            $this->lastURLError = curl_error($curl);
            curl_close($curl);
            return false;
        }

        $img = @file_get_contents($url);
        if ($img === false) {
            $err = error_get_last();
            if (is_array($err) && $err['message']) {
                $this->lastURLError = $err['message'];
            } else {
                $this->lastURLError = $err;
            }
            if (preg_match('/404/', $this->lastURLError)) {
                $this->set404();
            }

            return false;
        }
        if (!file_put_contents($tempfile, $img)) {
            $this->error("Could not write to $tempfile.");
            return false;
        }
        return true;
    }

    protected function serveImg($file): bool
    {
        $s = getimagesize($file);
        if (!($s && $s['mime'])) {
            return false;
        }
        header('Content-Type: ' . $s['mime']);
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        $bytes = @readfile($file);
        if ($bytes > 0) {
            return true;
        }
        $content = @file_get_contents($file);
        if ($content != false) {
            echo $content;
            return true;
        }
        return false;
    }

    protected function set404()
    {
        $this->is404 = true;
    }

    protected function is404(): bool
    {
        return $this->is404;
    }
}
