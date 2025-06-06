<?php

class errorhandler
{
    private static self $instance;
    public static function getInstance(): self
    {
        if( empty(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public array $error_list = [];
    public array $message_list = [];
    public array $warning_list = [];

    /**
     * @param null $message
     * @param bool $secure
     */
    private function add_error($message = null, $secure = true): void
    {
        $this->error_list[] = ['val' => $message, 'secure' => $secure];
    }

    /**
     * @return array
     */
    public function get_error(): array
    {
        return $this->error_list;
    }

    public function flush_error(): void
    {
        $this->error_list = [];
    }

    /**
     * @param null $message
     * @param bool $secure
     */
    private function add_warning($message = null, $secure = true): void
    {
        $this->warning_list[] = ['val' => $message, 'secure' => $secure];
    }

    public function get_warning(): array
    {
        return $this->warning_list;
    }

    public function flush_warning(): void
    {
        $this->warning_list = [];
    }

    /**
     * Function used to add message_list
     *
     * @param null $message
     * @param bool $secure
     */
    public function add_message($message = null, $secure = true): void
    {
        $this->message_list[] = ['val' => $message, 'secure' => $secure];
    }

    public function get_message(): array
    {
        return $this->message_list;
    }

    public function flush_msg(): void
    {
        $this->message_list = [];
    }

    public function flush(): void
    {
        $this->flush_msg();
        $this->flush_error();
        $this->flush_warning();
    }

    /**
     * Function for throwing errors that users can see
     *
     * @param  : { string } { $message } { error message to throw }
     * @param string $type
     * @param bool $secure
     *
     * @return array : { array } { $this->error_list } { an array of all currently logged errors }
     */
    function e($message = null, $type = 'e', $secure = true): array
    {
        switch ($type) {
            case 'm':
            case 1:
            case 'msg':
            case 'message':
                $this->add_message($message, $secure);
                break;

            case 'e':
            case 'err':
            case 'error':
                $this->add_error($message, $secure);
                break;

            case 'w':
            case 2:
            case 'war':
            case 'warning':
            default:
                $this->add_warning($message, $secure);
                break;
        }
        return $this->error_list;
    }

}
