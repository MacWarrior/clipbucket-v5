<?php
class errorhandler extends ClipBucket
{
	public $error_list = array();
	public $message_list = array();
	public $warning_list = array();

    /**
     * @param null $message
     */
	private function add_error($message=NULL) {
	    $this->error_list[] = $message;
	}

    /**
     * @return array
     */
	public function get_error()
    {
        return $this->error_list;
    }

    public function flush_error() {
        $this->error_list = array();
    }

    /**
     * @param null $message
     */
	private function add_warning($message=NULL) {
		$this->warning_list[] = $message;
	}

    public function get_warning()
    {
        return $this->warning_list;
    }

    public function flush_warning() {
        $this->warning_list = array();
    }

    /**
     * Function used to add message_list
     * @param null $message
     */
	public function add_message($message=NULL) {
	    $this->message_list[] = $message;
	}

    public function get_message()
    {
        return $this->message_list;
    }

	public function flush_msg() {
		$this->message_list = array();
	}

	public function flush() {
		$this->flush_msg();
		$this->flush_error();
		$this->flush_warning();
	}

    /**
     * Function for throwing errors that users can see
     * @param : { string } { $message } { error message to throw }
     * @param string $type
     * @return array : { array } { $this->error_list } { an array of all currently logged errors }
     * @author : Arslan Hassan
     *
     */
	function e($message = NULL, $type ='e') {
		switch($type)
        {
			case 'm':
			case 1:
			case 'msg':
			case 'message':
                $this->add_message($message);
                break;

			case 'e':
			case 'err':
			case 'error':
				$this->add_error($message);
			    break;

			case 'w':
			case 2:
			case 'war':
			case 'warning':
			default:
				$this->add_warning($message);
			    break;
		}
		return $this->error_list;
	}

}
