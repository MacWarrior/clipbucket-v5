<?php

class Session
{
    const tbl = 'sessions';
    var $id = '';

    //Use cookies over sessions
    var $cookie = true;
    var $timeout = 3600; //1 hour

    private static $session;

    /**
     * offcourse, its a constructor
     */
    function __construct()
    {
        $this->id = session_id();
        $this->timeout = COOKIE_TIMEOUT;
    }

    public static function getInstance(): Session
    {
        if( empty(self::$session) ){
            self::$session = new self();
        }
        return self::$session;
    }

    /**
     * Function used to add session
     *
     * @param      $user
     * @param      $name
     * @param bool $value
     * @param bool $reg
     *
     * @throws Exception
     * @todo: Find a proper solution to avoid database crashing because of sessions insertion and updation
     */
    function add_session($user, $name, $value = false, $reg = false): void
    {
        if (!$value) {
            $value = $this->id;
        }

        $sessions = $this->get_user_session($user, $name, true);

        if (count($sessions) > 0) {
            Clipbucket_db::getInstance()->delete(tbl(self::tbl), ['session_string', 'session'], [$name, $this->id]);
        }

        $cur_url = pages::getInstance()->GetCurrentUrl();

        if ($name == 'guest' && config('store_guest_session') != 'yes') {
            // do nothing
        } else {
            Clipbucket_db::getInstance()->insert(tbl(self::tbl), ['session_user', 'session', 'session_string', 'ip', 'session_value', 'session_date',
                'last_active', 'referer', 'agent', 'current_page'],
                [$user, $this->id, $name, Network::get_remote_ip(), $value, now(), now(), getArrayValue($_SERVER, 'HTTP_REFERER'), $_SERVER['HTTP_USER_AGENT'], $cur_url]);
        }

        if ($reg) {
            //Finally Registering session
            $this->session_val($name, $value);
        }
    }

    /**
     * Function is used to get session
     *
     * @param      $user
     * @param bool $session_name
     * @param bool $phpsess
     *
     * @return array
     * @throws Exception
     */
    function get_user_session($user, $session_name = false, $phpsess = false): array
    {
        $session_cond = false;
        if ($session_name) {
            $session_cond = ' session_string=\'' . mysql_clean($session_name) . '\'';
        }
        if ($phpsess) {
            if ($session_cond) {
                $session_cond .= ' AND ';
            }
            $session_cond .= ' session =\'' . $this->id . '\' ';
        }
        return Clipbucket_db::getInstance()->select(tbl(self::tbl), '*', $session_cond);
    }

    /**
     * Function used to get sessins
     *
     * @throws Exception
     * @todo : They are updated on every page refresh, highly  critical for performance.
     */
    function get_sessions(): array
    {
        $results = Clipbucket_db::getInstance()->select(tbl(self::tbl), '*', 'session =\'' . $this->id . '\' ');

        $cur_url = pages::getInstance()->GetCurrentUrl();

        if (getConstant('THIS_PAGE') != 'cb_install') {
            if (getConstant('THIS_PAGE') != 'ajax') {
                Clipbucket_db::getInstance()->update(tbl(self::tbl), ['last_active', 'current_page'], [now(), $cur_url], ' session=\'' . $this->id . '\' ');
            } else {
                Clipbucket_db::getInstance()->update(tbl(self::tbl), ['last_active'], [now()], ' session=\'' . $this->id . '\' ');
            }
        }

        return $results;
    }

    /**
     * Function used to set session value
     *
     * @param $name
     * @param $value
     */
    function session_val($name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Function used to set register session and set its value
     *
     * @param $name
     * @param $val
     */
    function set_session($name, $val): void
    {
        if ($this->cookie) {
            self::setCookie($name, $val, time() + $this->timeout);
        } else {
            $_SESSION[$name] = $val;
        }
    }

    function set($name, $val): void
    {
        $this->set_session($name, $val);
    }

    /**
     * Function used to remove session value
     *
     * @param $name
     */
    function unset_session($name): void
    {
        if ($this->cookie) {
            unset($_COOKIE[$name]);
            self::setCookie($name, '', 0);
        } else {
            unset($_SESSION[$name]);
        }
    }

    function un_set($name): void
    {
        $this->unset_session($name);
    }

    /**
     * Function used to get session value
     * param VARCHAR name
     *
     * @param $name
     *
     * @return mixed
     */
    function get_session($name)
    {
        if ($this->cookie) {
            if (isset($_COOKIE[$name])) {
                return $_COOKIE[$name];
            }
        } else {
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            }
        }
    }

    //replica
    function get($name)
    {
        return $this->get_session($name);
    }

    public static function start(): void
    {
        ini_set('session.gc_maxlifetime', COOKIE_TIMEOUT);
        session_set_cookie_params([
            'lifetime' => COOKIE_TIMEOUT
            ,'path' => '/'
            ,'httponly' => true
            ,'secure' => Network::is_ssl()
        ]);
        try {
            session_start();
        } catch(Exception $e) {
            session_regenerate_id();
            session_start();
        }
    }

    /**
     * Destroy Session
     * @throws Exception
     */
    function destroy(): void
    {
        Clipbucket_db::getInstance()->delete(tbl(self::tbl), ['session'], [$this->id]);
        session_destroy();
    }

    /**
     * @throws Exception
     */
    function kick($id): bool
    {
        //Getting little details from sessions such that
        //some lower class user can kick admins out ;)
        $results = Clipbucket_db::getInstance()->select(tbl('sessions') . ' LEFT JOIN (' . tbl('users') . ') ON 
		(' . tbl('sessions') . '.session_user=' . tbl('users') . '.userid)', tbl('sessions') . '.*,
		' . tbl('users') . '.level', 'session_id=\'' . $id . '\'');

        $results = $results[0];

        if ($results['level'] == 1) {
            e('You cannot kick administrators');
            return false;
        }
        $this->deleteById($id);
        return true;
    }

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
    public static function deleteById($id): void
    {
        Clipbucket_db::getInstance()->delete(tbl(self::tbl), ['session_id'], [$id]);
    }

    /**
     * @throws Exception
     */
    public static function getCookiesList(): array
    {
        $undefined = '<i>(' . lang('undefined') . ')</i>';
        $cookies = [];

        $cookies[] = [
            'name'         => 'PHPSESSID'
            ,'description' => lang('cookie_description_phpsessid')
            ,'value'       => $_COOKIE['PHPSESSID'] ? display_clean($_COOKIE['PHPSESSID']) : $undefined
            ,'required'    => true
            ,'lifetime'    => format_duration(3600 * 24) . ' - ' . format_duration(3600 * 24 * 7)
            ,'consent'     => self::isCookieConsent('PHPSESSID')
        ];
        if( config('enable_cookie_banner') == 'yes' ){
            $cookies[] = [
                'name'         => 'cookie_consent'
                ,'description' => lang('cookie_description_consent')
                ,'value'       => $_COOKIE['cookie_consent'] ? display_clean($_COOKIE['cookie_consent']) : $undefined
                ,'required'    => true
                ,'lifetime'    => format_duration(3600 * 24 * 365/2)
                ,'consent'     => self::isCookieConsent('cookie_consent')
            ];
        }
        if( config('enable_global_age_restriction') == 'yes' ){
            $cookies[] = [
                'name'         => 'age_restrict'
                ,'description' => lang('cookie_description_age_restrict')
                ,'value'       => $_COOKIE['age_restrict'] ? display_clean($_COOKIE['age_restrict']) : $undefined
                ,'required'    => true
                ,'lifetime'    => 'Session'
                ,'consent'     => self::isCookieConsent('age_restrict')
            ];
        }
        if( config('enable_quicklist') == 'yes' ){
            $cookies[] = [
                'name'         => 'fast_qlist'
                ,'description' => lang('cookie_description_quicklist')
                ,'value'       => $_COOKIE['fast_qlist'] ? display_clean($_COOKIE['fast_qlist']) : $undefined
                ,'required'    => false
                ,'lifetime'    => 'Session'
                ,'consent'     => self::isCookieConsent('fast_qlist')
            ];
            // Temp disabled for now
            /*$cookies[] = [
                'name'         => 'quick_list_box'
                ,'description' => 'quick_list_box ?'
                ,'value'       => $_COOKIE['quick_list_box'] ? display_clean($_COOKIE['quick_list_box']) : $undefined
                ,'required'    => false
                ,'lifetime'    => 'Session'
                ,'consent'     => self::isCookieConsent('quick_list_box')
            ];*/
        }
        if( config('enable_theme_change') == 'yes' ){
            $cookies[] = [
                'name'         => 'user_theme'
                ,'description' => lang('cookie_description_theme')
                ,'value'       => $_COOKIE['user_theme'] ? display_clean($_COOKIE['user_theme']) : $undefined
                ,'required'    => false
                ,'lifetime'    => format_duration(3600)
                ,'consent'     => self::isCookieConsent('user_theme')
            ];
            $cookies[] = [
                'name'         => 'user_theme_os'
                ,'description' => lang('cookie_description_theme_auto')
                ,'value'       => $_COOKIE['user_theme_os'] ? display_clean($_COOKIE['user_theme_os']) : $undefined
                ,'required'    => false
                ,'lifetime'    => format_duration(3600)
                ,'consent'     => self::isCookieConsent('user_theme_os')
            ];
        }
        if( config('allow_language_change') == '1' ){
            $cookies[] = [
                'name'         => 'cb_lang'
                ,'description' => lang('cookie_description_lang')
                ,'value'       => $_COOKIE['cb_lang'] ? display_clean($_COOKIE['cb_lang']) : $undefined
                ,'required'    => false
                ,'lifetime'    => format_duration(3600)
                ,'consent'     => self::isCookieConsent('cb_lang')
            ];
        }

        return $cookies;
    }

    public static function isConsentCookieSet(): bool
    {
        return !empty($_COOKIE['cookie_consent']);
    }

    private static function getConsentCookie(): array
    {
        if( !self::isConsentCookieSet() ){
            return [];
        }

        try{
            return json_decode($_COOKIE['cookie_consent'], true);
        }
        catch(Exception $e){
            return [];
        }
    }

    public static function isCookieConsent(string $cookie): bool
    {
        if( !self::isConsentCookieSet() ){
            return true;
        }

        $cookies_consent = self::getConsentCookie();

        return ($cookies_consent[$cookie] ?? 'no') == 'yes';
    }

    /**
     * @throws Exception
     */
    public static function setCookieConsent($post): void
    {
        if( $post != 'all' ){
            $post = json_decode($post, true);
        }
        $cookies_list = self::getCookiesList();
        $consent = [];
        foreach($cookies_list as $cookie){
            if( $post == 'all' ){
                $consent[$cookie['name']] = 'yes';
                continue;
            }
            $consent[$cookie['name']] = ($post[$cookie['name']] ?? '' == 'yes') ? 'yes' : 'no';
            if( $consent[$cookie['name']] == 'no' ){
                self::unsetCookie($cookie['name']);
            }
        }

        self::setCookie('cookie_consent', json_encode($consent), time() + 3600 * 24 * 365/2);
    }

    public static function setCookie($name, $val, $time = null): void
    {
        if (is_null($time)) {
            $time = time() + 3600;
        }

        setcookie($name, $val, [
            'expires'  => $time,
            'path'     => '/',
            'secure'   => Network::is_ssl(),
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }

    public static function unsetCookie($name):void
    {
        self::setCookie($name, '', time() - 3600*24);
    }

}
