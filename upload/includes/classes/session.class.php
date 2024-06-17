<?php

class Session
{
    const tbl = 'sessions';
    var $id = '';

    //Use cookies over sessions
    var $cookie = true;
    var $timeout = 3600; //1 hour

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
        global $sess;
        return $sess;
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
    function add_session($user, $name, $value = false, $reg = false)
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
    function session_val($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Function used to set register session and set its value
     *
     * @param $name
     * @param $val
     */
    function set_session($name, $val)
    {
        if ($this->cookie) {
            set_cookie_secure($name, $val, time() + $this->timeout);
        } else {
            $_SESSION[$name] = $val;
        }
    }

    function set($name, $val)
    {
        $this->set_session($name, $val);
    }

    /**
     * Function used to remove session value
     *
     * @param $name
     */
    function unset_session($name)
    {
        if ($this->cookie) {
            unset($_COOKIE[$name]);
            set_cookie_secure($name, '', 0);
        } else {
            unset($_SESSION[$name]);
        }
    }

    function un_set($name)
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

    /**
     * Destroy Session
     * @throws Exception
     */
    function destroy()
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
    public static function deleteById($id)
    {
        Clipbucket_db::getInstance()->delete(tbl(self::tbl), ['session_id'], [$id]);
    }
}
