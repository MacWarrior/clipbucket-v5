<?php

/**
 *  Class Gravatar
 *
 * From Gravatar Help:
 *        "A gravatar is a dynamic image resource that is requested from our server. The request
 *        URL is presented here, broken into its segments."
 * Source:
 *    http://site.gravatar.com/site/implement
 *
 * Usage:
 * <code>
 *        $email = "youremail@yourhost.com";
 *        $default = "http://www.yourhost.com/default_image.jpg";    // Optional
 *        $gravatar = new Gravatar($email, $default);
 *        $gravatar->size = 80;
 *        $gravatar->rating = "G";
 *        $gravatar->border = "FF0000";
 *
 *        echo $gravatar; // Or echo $gravatar->toHTML();
 * </code>
 *
 *    Class Page: http://www.phpclasses.org/browse/package/4227.html
 *
 * @author Lucas Araújo <araujo.lucas@gmail.com>
 * @version 1.0
 * @package Gravatar
 */
class Gravatar
{
    /**
     *    Gravatar's url
     */
    const GRAVATAR_URL = "https://www.gravatar.com/avatar.php";

    /**
     *    Ratings available
     */
    private $GRAVATAR_RATING = ["G", "PG", "R", "X"];

    /**
     *    Query string. key/value
     */
    protected $properties = [
        "gravatar_id" => null,
        "default"     => null,
        "size"        => 80, // The default value
        "rating"      => null,
        "border"      => null,
    ];

    /**
     *    E-mail. This will be converted to md5($email)
     */
    protected $email = "";

    /**
     *    Extra attributes to the IMG tag like ALT, CLASS, STYLE...
     */
    protected $extra = "";

    public function __construct($email = null, $default = null)
    {
        $this->setEmail($email);
        $this->setDefault($default);
    }

    public function setEmail($email)
    {
        if (Email::isValid($email)) {
            $this->email = $email;
            $this->properties['gravatar_id'] = md5(strtolower($this->email));
            return true;
        }
        return false;
    }

    public function setDefault($default)
    {
        $this->properties['default'] = $default;
    }

    public function setRating($rating)
    {
        if (in_array($rating, $this->GRAVATAR_RATING)) {
            $this->properties['rating'] = $rating;
            return true;
        }
        return false;
    }

    public function setSize($size)
    {
        $size = (int)$size;
        if ($size <= 0) {
            $size = null;
        }        // Use the default size
        $this->properties['size'] = $size;
    }

    public function setExtra($extra)
    {
        $this->extra = $extra;
    }

    /**
     *    Object property overloading
     *
     * @param $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return @$this->properties[$var];
    }

    /**
     *    Object property overloading
     *
     * @param $var
     * @param $value
     *
     * @return bool|void
     */
    public function __set($var, $value)
    {
        switch ($var) {
            case "email":
                return $this->setEmail($value);
            case "rating":
                return $this->setRating($value);
            case "default":
                return $this->setDefault($value);
            case "size":
                return $this->setSize($value);
            // Cannot set gravatar_id
            case "gravatar_id":
                return;
        }
        return @$this->properties[$var] = $value;
    }

    /**
     *    Object property overloading
     *
     * @param $var
     *
     * @return bool
     */
    public function __isset($var)
    {
        return isset($this->properties[$var]);
    }

    /**
     *    Object property overloading
     *
     * @param $var
     *
     * @return bool
     */
    public function __unset($var)
    {
        return @$this->properties[$var] == null;
    }

    public function getSrc()
    {
        $url = self::GRAVATAR_URL . "?";
        $first = true;
        foreach ($this->properties as $key => $value) {
            if (isset($value)) {
                if (!$first) {
                    $url .= "&";
                }
                $url .= $key . "=" . urlencode($value);
                $first = false;
            }
        }
        return $url;
    }

    public function toHTML()
    {
        return '<img src="' . $this->getSrc() . '"'
            . (!isset($this->size) ? "" : ' width="' . $this->size . '" height="' . $this->size . '"')
            . $this->extra
            . ' />';
    }

    public function __toString()
    {
        return $this->toHTML();
    }
}
