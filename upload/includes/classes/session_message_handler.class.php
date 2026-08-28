<?php

class SessionMessageHandler
{
    private static array $type = ['m', 'w', 'e'];

    /**
     * @param string $message
     * @param string $type
     * @param string $url
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
     * @param array $messages $message = ['message'=>'the message', 'type'=>'w']
     * @param string $url
     * @return bool
     */
    public static function add_messages(array $messages, string $url = ''): bool
    {

        if (empty($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
        foreach ($messages as $message) {
            self::add_message($message['message'], $message['type']);
        }
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
