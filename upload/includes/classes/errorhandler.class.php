<?php
/**
 * Very basic error handler
 */
 

class errorhandler extends ClipBucket {

	public $error_list = array();
	public $message_list = array();
	public $warning_list = array();
	public $developer_errors = array();
	
	/**
	* Function used to add new Error
	*/

	private static function add_error($message=NULL,$id=NULL) {
		global $ignore_cb_errors;
		//if id is set, error will be generated from error message list
		if(!$ignore_cb_errors)
			$this->error_list[] = $message;
	}

	
	/**
	* Function usd to add new warning
	*/
	
	private static function add_warning($message=NULL,$id=NULL) {
		$this->warning_list[] = $message;
	}
	
	/**
	* Function used to get error list
	*/
	 
	public function error_list() { 
	 	return $this->error_list;
	 }
	 
	/**
	* Function used to flush errors
	*/
	
	public static function flush_error() {
		$this->error_list = '';
	}
	  
	/**
	* Functio nused to add message_list
	*/

	public static function add_message($message=NULL,$id=NULL) {
		global $ignore_cb_errors;
		//if id is set, error will be generated from error message list
		if(!$ignore_cb_errors)
		$this->message_list[] = $message;
	}
	   
	/**
	* Function used to get message list
	*/

	public function message_list() {
		return $this->message_list;
	}
	
	/**
	* Function used to flush message
	*/
	
	public static function flush_msg() {
		$this->message_list = '';
	}
	
	/**
	* Function used to flush warning
	*/

	public static function flush_warning() {
		$this->warning_list = '';
	}
	
	/**
	* Function used to flush , both message and error
	*/
	
	public static function flush() {
		$this->flush_msg();
		$this->flush_error();
		$this->flush_warning();
	}
	
	/**
	* Function used to add error or either message using simple
	* and small object
	* @param : message, @param :type,@param:id
	*/

	function e($message=NULL,$type='e',$id=NULL) {
	
		switch($type) {
			case 'm':
			case 1:
			case 'msg':
			case 'message':
			$this->add_message($message,$id);
			break;
			
			case 'e':
			case 'err':
			case 'error':
				$this->add_error($message,$id);
			break;
			
			case 'w':
			case 2:
			case 'war':
			case 'warning':
				$this->add_warning($message,$id);
			break;
			
			default:
				$this->error_list($message,$id);
			break;
		}
		
		return $message;
	}

	/**
	* Handles developer related errors to ease up debugging process
	*/

	public function deverr($error, $state = 'm') {
		global $developer_errors;		
		switch ($state) {
			case 'l':
				$state = 'lower_priority';
				break;
			case 'c':
				$state = 'critical_priority';
				break;
			
			default:
				$state = 'medium_priority';
				break;
		}

		if (!$developer_errors) {
			$this->developer_errors[$state][] = $error;
		} else {

		}


		$this->error_list['developer_errors'] = $this->developer_errors;
		pex($this->error_list);
	}
	
}


?>