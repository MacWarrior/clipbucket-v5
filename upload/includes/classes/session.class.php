<?php
/**
 * Rally simple session class
 * Author Arslan Hassan <arslan@clip-bucket.com>
 * http://clip-bucket.com/
 */

class Session
{
	var $tbl = 'sessions';
	var $id= '';
	var $overwrite = false;
	
	//Use cookies over sessions
	var $cookie = true;
	var $timeout = 3600; //1 hour
	
	/**
	 * offcourse, its a constructor
	 */
	function __construct()
	{
		$this->id = session_id() ;
		$this->timeout  = COOKIE_TIMEOUT;
	}

	/**
	 * Function used to add session
	 *
	 * @param      $user
	 * @param      $name
	 * @param bool $value
	 * @param bool $reg
	 *
	 * @todo: Find a proper solution to avoid database crashing because of sessions insertion and updation
	 */

	function add_session($user,$name,$value=false,$reg=false)
	{
		global $db,$pages;
		if(!$value)
			$value = $this->id;
		
		$sessions = $this->get_user_session($user,$name,true);
		
		if(count($sessions)>0)
		{
			$db->delete(tbl($this->tbl),array('session_string','session'),array($name,$this->id));
		}
		
		$cur_url = $pages->GetCurrentUrl();
		
		if(THIS_PAGE!='cb_install')
		{
			if($name === "guest" && config("store_guest_session") !== "yes"){
				// do nothing
			} else {
				$db->insert(tbl($this->tbl),array('session_user','session','session_string','ip','session_value','session_date',
				'last_active','referer','agent','current_page'),
				array($user,$this->id,$name,$_SERVER['REMOTE_ADDR'],$value,now(),now(),getArrayValue($_SERVER, 'HTTP_REFERER'),$_SERVER['HTTP_USER_AGENT'],$cur_url));
			}
		}
		if($reg)
		{
			//Finally Registering session
			$this->session_val($name,$value);
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
	 */
	function get_user_session($user,$session_name=false,$phpsess=false)
	{
		global $db;
		$session_cond = false;
		if($session_name)
			$session_cond = " session_string='".mysql_clean($session_name)."'";
		if($phpsess)
		{
			if($session_cond)
				$session_cond .= " AND ";
			$session_cond .= " session ='".$this->id."' ";
		}
		return $db->select(tbl($this->tbl),'*',$session_cond);
	}
	
	/**
	 * Function used to get sessins
     *
     * @todo : They are updated on every page refresh, highly  critical for performance.
	 */
	function get_sessions()
	{
		global $db,$pages;
		$results = $db->select(tbl($this->tbl),'*'," session ='".$this->id."' ");
		
		$cur_url = $pages->GetCurrentUrl();
		
		if(getConstant('THIS_PAGE')!='cb_install')
		{
			if(getConstant('THIS_PAGE')!='ajax') {
				$db->update(tbl($this->tbl),array("last_active","current_page"),array(now(),$cur_url)," session='".$this->id."' ");
			}else {
				$db->update(tbl($this->tbl),array("last_active"),array(now())," session='".$this->id."' ");
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
	function session_val($name,$value)
	{
		$_SESSION[$name] = $value;
	}

    /**
     * Function used to set register session and set its value
     *
     * @param $name
     * @param $val
     */
	function set_session($name,$val)
	{
		if($this->cookie)
		{
			setcookie($name,$val,time()+$this->timeout,'/');
		} else {
			$_SESSION[$name] = $val;
		}
	}
	function set($name,$val)
	{
		$this->set_session($name,$val);
	}

    /**
     * Function used to remove session value
     *
     * @param $name
     */
	function unset_session($name)
	{
		if($this->cookie)
		{
			unset($_COOKIE[$name]);
			setcookie($name,'',0);
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
		if($this->cookie)
		{
			if(isset($_COOKIE[$name]))
				return $_COOKIE[$name];
		}else
		{
			if(isset($_SESSION[$name]))
			return $_SESSION[$name];
		}
	}
	//replica
	function get($name){ return $this->get_session($name); }
	
	/**
	 * Destroy Session
	 */
	function destroy()
	{
		global $db;
		$db->delete(tbl($this->tbl),array('session'),array($this->id));
		session_destroy();
	}

    /**
     * Function set cookie
     *
     * @param $name
     * @param $val
     */
	function set_cookie($name,$val)
	{
		setcookie($name,($val),3600+time(),'/');
	}

    /**
     * Function get cookie
     *
     * @param $name
     *
     * @return bool|string
     */
	function get_cookie($name)
	{
		if(isset($_COOKIE[$name]))
			return stripslashes(($_COOKIE[$name]));
		return false;
	}

	function kick($id)
	{
		global $db;
		//Getting little details from sessions such that
		//some lower class user can kick admins out ;)
		$results = $db->select(tbl("sessions")." LEFT JOIN (".tbl("users").") ON 
		(".tbl("sessions").".session_user=".tbl("users").".userid)", tbl("sessions").".*,
		".tbl("users").".level","session_id='".$id."'");
		
		$results = $results[0];
		
		if($results['level']==1)
		{
			e("You cannot kick administrators");
			return false;
		}
		$db->delete(tbl($this->tbl),array("session_id"),array($id));
		return true;
	}
}
