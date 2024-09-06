<?php

class sessionMessageHandler
{
    private static $type = ['m', 'w', 'e'];

    /**
     * @param string $message
     * @param string $type
     * @return bool
     */
    public static function add_message(string $message, string $type = 'm', string $url = ''): bool
    {
        if (!in_array($type, self::$type)) {
            return false;
        }
        if (empty($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
        $_SESSION['messages'][] = [
            'message'=>$message,
            'type'=>$type
        ];
        if (!empty($url)) {
            redirect_to($url);
        }
        return true;
    }

    /**
     * @return array
     */
    public static function get_messages(): array
    {
        $messages = [];
        if (!empty($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
        }

        return $messages;
    }
}
