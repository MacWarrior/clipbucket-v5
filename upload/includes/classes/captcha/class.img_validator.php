<?php

if (!class_exists("files")) {
    require_once "class.files.php";
}

class img_validator extends files
{
    /**
     * Fonts folder
     * @var string $folder
     */
    var $folder;
    /**
     * Background images folder
     * @var string $img_folder
     */
    var $img_folder;
    /**
     * Letters limit for the given words
     * @var integer $letters_limit
     */
    var $letters_limit = 15;
    /**
     * The generated image will be JPEG or PNG?
     * @var string $image_type
     */
    var $image_type = "jpeg";

    /**
     * Colors themes for the GD generated images. They must be in RGB.
     * The array must start at index 1
     *
     * 0 => background image color
     * 1 => background image border
     * 2 => text color
     * @var array $themes
     */
    var $themes = [
        1 => [[205, 255, 204], [205, 255, 204], [0, 0, 0]],
        2 => [[255, 255, 203], [255, 255, 203], [0, 0, 0]],
        3 => [[102, 203, 255], [102, 203, 255], [0, 0, 0]],
        4 => [[0, 0, 0], [82, 82, 82], [255, 255, 255]],
        5 => [[153, 1, 0], [0, 0, 0], [255, 255, 255]],
    ];
    /**
     * Colors themes for the done BG images
     *
     * 0 => background image name
     * 1 => Red, 2 => Green, 3 => Blue
     * @var array $themes
     */
    var $themes_bg_images = [
        1 => ["bg1.jpg", 0, 0, 0],
        2 => ["bg2.jpg", 0, 0, 0],
        3 => ["bg3.jpg", 0, 0, 0],
        4 => ["bg4.jpg", 0, 0, 0],

    ];
    /**
     * Fonts data
     * 0 => font file,
     * 1 => initial X position for a letter in size 14 texts
     * 2 => initial X position for a letter in size 40 texts
     * 3 => value to reduce of X each new letter in size 14 texts
     * 4 => value to reduce of X each new letter in size 40 texts
     *
     * -> P.S.: The indexes 1, 2, 3 and 4 are used only when the text will be centralized
     */
    var $fonts = [
        /* With this font, all letters are uppercase and the characters limit decrease
        array("acmesab.ttf", 84, 62, 7.0, 18.0),*/
        ["arial.ttf", 85, 70, 5.1, 11.6],
        ["verdana.ttf", 82, 67, 5.6, 12.9],
        ["comicbd.ttf", 83, 68, 5.1, 11.5],
        ["impact.ttf", 80, 55, 5.7, 12.9]
    ];
    /**
     * Image Width
     * @var integer $_width
     */
    var $_width = 180;
    /**
     * Image Height
     * @var integer $_height
     */
    var $_height = 50;

    /**
     * Checks if the system has GD support
     *
     * @param bool $folder
     * @param bool $img_folder
     */
    function __construct($folder = false, $img_folder = false)
    {
        // If doesn't given, uses the default fonts folder
        if (!$folder) {
            $folder = "./img/fonts/";
        }

        // If doesn't given, uses the default background images folder
        if (!$img_folder) {
            $img_folder = "./img/";
        }

        // Sets the background images and fonts dir
        $this->folder = $folder;
        $this->img_folder = $img_folder;

        // Checks if the system has GD loaded on PHP
        if (!function_exists("ImageCreateTrueColor")) { // gd 2.*
            if (!function_exists("ImageCreate")) { // gd 1.*
                $this->_error("You can't run this script because your PHP doesn't have GD library (1.* or 2.*) loaded.", E_USER_ERROR);
            }
        }
    }

    /**
     * Encrypts a word to record the data
     *
     * @param string $word
     *
     * @return false|string
     */
    function encrypts_word($word)
    {
        return substr(md5($word), 1, 10);
    }

    /**
     * Record a word in SESSION
     *
     * @param string $word
     */
    function records_word($word)
    {
        $_SESSION["word_validator"] = base64_encode($this->encrypts_word($word));
        if (empty($_SESSION['word_validator'])) {
            set_cookie_secure('word_validator', base64_encode($this->encrypts_word($word)));
        }
    }

    /**
     * Checks the recorded word with the given on
     *
     * @param $word
     *
     * @return bool
     */
    function checks_word($word)
    {
        if (isset($_SESSION["word_validator"])) {
            $recorded = base64_decode($_SESSION["word_validator"]);
        } else {
            $recorded = base64_decode($_COOKIE["word_validator"]);
        }
        $given = $this->encrypts_word($word);
        if (preg_match($given, $recorded)) {
            $msg = true;
        } else {
            $msg = false;
        }
        return $msg;
    }

    /**
     * Generates a random text, whether a word isn't give or
     * the given word is more than the letters limit
     */
    function generates_text()
    {
        $temp = md5(uniqid(microtime()));
        $temp = hexdec($temp);
        $word = substr($temp, 2, 3) . "-" . substr($temp, 6, 3);

        return $word;
    }

    /**
     * Generates the validation imagem with a given word.
     * If the word isn't provide generate a random word.
     *
     * @param bool $word
     * @param boolean $use_done_images
     * @param string $align
     */
    function generates_image($word = false, $use_done_images = false, $align = "center")
    {
        /**
         * Didn't give a word, generates a random text
         */
        if (!$word) {
            $word = $this->generates_text();
        } else {
            $word_size = strlen($word);

            if ($word_size > $this->letters_limit) {
                $word = $this->generates_text();
            }
        }

        $this->records_word($word);
        $word_size = strlen($word);

        srand((double)microtime() * 1000000);

        /**
         * Chooses a random font
         */
        $fnt = rand(0, count($this->fonts) - 1);
        $font = $this->folder . $this->fonts[$fnt][0];

        /**
         * Sets the X values according to the chosen alignment
         */
        if ($align == "center") {
            /**
             * X position value for only 1 letter of the size 14 text
             */
            $x_small = $this->fonts[$fnt][1];
            $d_small = $this->fonts[$fnt][3];
            /**
             * X position value for only 1 letter of the size 40 text
             */
            $x_big = $this->fonts[$fnt][2];
            $d_big = $this->fonts[$fnt][4];

            /**
             * For each letter of the given word, decreases $d_small of the size 14 text's X position
             * and decreases $d_big of the size 40 text's X position.
             * Remember: if you change the size of the background image, the font and the text's size
             * you must manually recalculate those numbers ($d_small and $d_big),
             * so the text will be always right centered
             */
            for ($i = 1; $i < $word_size; $x_small -= $d_small, $i++) ;
            for ($i = 1; $i < $word_size; $x_big -= $d_big, $i++) ;
        } /**
         * Left
         */
        else {
            $x_small = 2;
            $x_big = 2;
        }

        srand((double)microtime() * 1000000);

        /**
         * The background is already done, so, create the image handle from done BG
         */
        if ($use_done_images) {
            // Chooses randomly a theme
            $theme = rand(1, count($this->themes_bg_images));
            // Start image handle from file
            $background_image = ImageCreateFromJPEG($this->img_folder . $this->themes_bg_images[$theme][0]);
            // Text's colors
            $R = $this->themes_bg_images[$theme][1];
            $G = $this->themes_bg_images[$theme][2];
            $B = $this->themes_bg_images[$theme][3];
        } /**
         * GD Creates the background rectangle
         */
        else {
            // Chooses randomly a theme
            $theme = rand(1, count($this->themes));
            // Start image handle
            $background_image = imagecreatetruecolor($this->_width, $this->_height);
            // Alocates the rectangle's colors
            $fill = ImageColorAllocate($background_image, $this->themes[$theme][0][0], $this->themes[$theme][0][1], $this->themes[$theme][0][2]);
            $border = ImageColorAllocate($background_image, $this->themes[$theme][1][0], $this->themes[$theme][1][1], $this->themes[$theme][1][2]);
            // Creates the rectangle
            ImageFilledRectangle($background_image, 2, 2, 177, 47, $fill);
            ImageRectangle($background_image, 0, 0, 179, 49, $border);
            // Text's colors
            $R = $this->themes[$theme][2][0];
            $G = $this->themes[$theme][2][1];
            $B = $this->themes[$theme][2][2];
        }

        /**
         * Allocate the texts' colors
         */
        $transp_color = imagecolorallocatealpha($background_image, $R, $G, $B, 100);
        $color = imagecolorallocate($background_image, $R, $G, $B);

        /**
         * Writes the word with transparency in the background
         */
        imagettftext($background_image, 40, 0, $x_big, 45, $transp_color, $font, $word);
        /**
         * Writes the main word
         */
        imagettftext($background_image, 14, 0, $x_small, 30, $color, $font, $word);

        /**
         * Prints header and the image
         */
        if ($this->image_type == "jpeg") {
            header("Content-type: image/jpeg");
            imagejpeg($background_image, false, 100);
        } else {
            header("Content-type: image/png");
            imagepng($background_image);
        }

        imagedestroy($background_image);
    }
}
