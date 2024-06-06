<?php

namespace OxygenzSAS\Discord;

use CURLFile;
use DateTime;
use DateTimeZone;
use Error;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LogLevel;

class Discord extends \Psr\Log\AbstractLogger implements MiddlewareInterface
{

    // webhooks des channels
    public $channel ;

    public $applicationName ;

    private static $PieceJointeNameForNextSend =  'piece_jointe.log';

    public function __construct(string $channel, String $applicationName) {
        $this->channel = $channel;
        $this->applicationName = $applicationName;
    }

    /** Fonction requise pour le Middleware */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        ob_start();
        $level = ob_get_level();

        try {
            $response = $handler->handle($request);
        } catch (\Throwable $exception) {
            $this->log(LogLevel::ERROR,'', ['exception' => $exception]);
            throw $exception;
        } finally {
            while (ob_get_level() >= $level) {
                ob_end_clean();
            }
        }

        return $response;
    }

    /**
     * @param ErrorException $exception
     * @return string
     */
    private static function getExceptionTraceAsString($exception) {
        $rtn = "";
        $count = 0;
        foreach ($exception->getTrace() as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = array();
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }
                $args = join(", ", $args);
            }
            $current_file = "[internal function]";
            if(isset($frame['file'])) {
                $current_file = $frame['file'];
            }
            $current_line = "";
            if(isset($frame['line'])) {
                $current_line = $frame['line'];
            }
            $rtn .= sprintf( "#%s %s(%s): %s(%s)\n",
                $count,
                $current_file,
                $current_line,
                $frame['function'],
                $args );
            $count++;
        }
        return $rtn;
    }

    /**
     * @param $message
     * @return array
     * @throws Exception
     */
    private function getMessageFromException($message)
    {
        if(method_exists($message,'getTrace')){
            $trace = self::getExceptionTraceAsString($message);

            if(empty($trace)){
                if($message instanceof Error) {
                    $trace = $message->getFile().' ('.$message->getLine().')';
                } else {
                    $trace = 'Aucun detail sur l\'erreur disponible';
                }
            }

            $msg = "```".PHP_EOL;
            $msg .= $trace.PHP_EOL;
            $msg .= "```".PHP_EOL;
        }

        $tz = 'Europe/Paris';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp

        $date = 'Emis le '.$dt->format('d-m-Y à H:i:s');

        if(method_exists($message,'getSeverity')){
            $type = self::getTypeFromException($message->getSeverity());
        }

        return array( $date, $message->getMessage(), ($msg ?? null), ($type ?? LogLevel::ERROR));
    }

    private static function getTypeFromException($severity){

        switch($severity) {

            case E_COMPILE_ERROR :
            case E_PARSE :
            case E_ERROR :
                $type = LogLevel::CRITICAL;
                break;

            default :
            case E_USER_ERROR :
            case E_RECOVERABLE_ERROR :
                $type = LogLevel::ERROR;
                break;

            case E_USER_WARNING :
            case E_WARNING :
            case E_COMPILE_WARNING :
            case E_CORE_WARNING :
                $type = LogLevel::WARNING;
                break;

            case E_USER_NOTICE :
            case E_NOTICE :
            case E_STRICT :
                $type = LogLevel::NOTICE;
                break;

            case E_DEPRECATED :
            case E_USER_DEPRECATED :
                $type = LogLevel::INFO;
                break;
        }

        return $type;
    }

    private function sendCurl($hookObject, $whith_retry = true, $file_data = null){
        $filepath = '';
        try{
            if(!empty($file_data)){
                $file_data = trim($file_data, '```');

                $filepath = sys_get_temp_dir().'/discord_log_file_'.microtime();
                file_put_contents($filepath, $file_data);

                // truncate le fichier s'il depasse 7.9Mo ( limit discord = 8Mo )
                $limit_upload_discord = 7900000; /* 7.9Mo */
                if(filesize($filepath) > $limit_upload_discord) {
                    $fp = fopen($filepath, "r+");
                    ftruncate($fp, $limit_upload_discord);
                    fclose($fp);
                }

                $hookObject['file'] = new CURLFile($filepath,null, self::$PieceJointeNameForNextSend );

                self::$PieceJointeNameForNextSend = 'piece_jointe.log';
            }
        }catch(Exception $e){}

        $ch = curl_init( $this->channel );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $hookObject);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_exec( $ch );

        // check the HTTP status code of the request
        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) ) {
            if($whith_retry) {
                self::retry_mode_light($hookObject);
            }
        } else {
            if ($resultStatus < 200 || $resultStatus > 299 ) {
                if($whith_retry) {
                    self::retry_mode_light($hookObject);
                }
            }
        }

        try{
            if(!empty($filepath)) {
                unlink($filepath);
            }
        }catch(Exception $e) {}
    }

    private function retry_mode_light($hookObject_original){
        $limit_size_message = 240;
        $hookObject = json_decode($hookObject_original['payload_json']);
        $uncut_hookObject = '';
        try{
            $uncut_hookObject = $hookObject->embeds[0]->description;
        }catch(Exception $e){}

        foreach ( $hookObject->embeds as &$embed) {

            if(strlen($embed->description) > $limit_size_message){
                $embed->description = mb_strimwidth($embed->description, 0, $limit_size_message, "...").'```';
            }

            if(strlen($embed->title) > $limit_size_message){
                $embed->title = mb_strimwidth($embed->title, 0, $limit_size_message, "...");
            }

            if(isset($embed->fields)){
                foreach ( $embed->fields as &$fields) {
                    if(strlen($fields->name) > $limit_size_message){
                        $fields->name = mb_strimwidth($fields->name, 0, $limit_size_message, "...");
                    }
                }
            }
        }

        $hookObject_original['payload_json'] = json_encode($hookObject);
        $this->sendCurl($hookObject_original, false, $uncut_hookObject);
    }

    public function log($level, $message, array $context = []): void
    {
        if(!is_string($message)){
            $message = (String) $message;
        }

        $embeds = [
        ];

        if(!empty($context)){

            /**
             * Verifier s'il existe une exception
             */
            if(isset($context['exception'])){
                list($date, $title, $description_exception, $level_exception) = $this->getMessageFromException($context['exception']);
                $embeds_exception = $this->getEmbed($title, $description_exception, $level_exception, $date);
                unset($context['exception']);
            }

            /** verifie s'il y a des données */
            if(!empty($context)){
                $message = "$message".PHP_EOL;
                $message .= "```".PHP_EOL;
                $message .= print_r($context, true).PHP_EOL;
                $message .= "```".PHP_EOL;
            }

        }

        /** si presence d'un message */
        if(!empty($message)){
            $embeds[] = $this->getEmbed('', $message, $level);
        }

        /** si presence d'une exception */
        if(isset($embeds_exception)){
            $embeds[] = $embeds_exception;
        }

        if(empty($embeds)){
            return ;
        }

        $obj = [
            /*
             * The general "message" shown above your embeds
             */
            "content" => null,
            /*
             * The username shown in the message
             */
            "username" => $this->applicationName,
            /*
             * The image location for the senders image
             */
            "avatar_url" => null,

            /*
             * Whether or not to read the message in Text-to-speech
             */
            "tts" => false,
            /*
             * An array of Embeds
             */
            "embeds" => $embeds

        ];

        try {       
            $hookObject = json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR );
        }catch(\Throwable $e ) {
            try {               
                $obj = mb_convert_encoding($obj, 'UTF-8', 'auto');
            }catch(\Throwable $e ) {
                throw new \Exception('Discord Issue :: only utf-8 characters can be json_encoded and mb_convert_encoding failed');
            }
            $hookObject = json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR );
        }
        
        $hookObject = array (
            'payload_json' => $hookObject
        );

        $this->sendCurl($hookObject);
    }

    private function getEmbed($title, $message, $level, $date = '')
    {

        switch($level){

            case LogLevel::EMERGENCY  :
                $color = hexdec("ff0000");
                $error_name = 'EMERGENCY';
                break;

            case LogLevel::ALERT :
                $color = hexdec("ff0000");
                $error_name = 'ALERT';
                break;

            case LogLevel::CRITICAL :
                $color = hexdec("ff0000");
                $error_name = 'CRITICAL';
                break;

            case LogLevel::ERROR :
                $color = hexdec("ff0000");
                $error_name = 'ERROR';
                break;

            case LogLevel::WARNING :
                $color = hexdec("e8a92c");
                $error_name = 'WARNING';
                break;

            case LogLevel::NOTICE :
                $color = hexdec("00aeff");
                $error_name = 'NOTICE';
                break;

            case LogLevel::INFO :
                $color = hexdec("d3d3d3");
                $error_name = 'INFO';
                break;

            case LogLevel::DEBUG :
                $color = hexdec("d3d3d3");
                $error_name = 'DEBUG';
                break;

            default :
                throw new \Psr\Log\InvalidArgumentException();
        }

        if(empty($date)){
            $dt = new DateTime("now");
            $date = 'Emis le '.$dt->format('d-m-Y à H:i:s');
        }

        $title = mb_convert_encoding($title, 'UTF-8', 'UTF-8');
        $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');

        return [
            "title" => preg_replace('/[^[:print:]\r\nÀ-ÿ]/', '', $title ?? null) ?? null,

            "description" => preg_replace('/[^[:print:]\r\nÀ-ÿ]/', '', $message ?? null) ?? null,

            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",

            // The integer color to be used on the left side of the embed
            "color" => $color,

            // Author object
            "author" => ["name" => $error_name],
            "content" => "",
//            "timestamp": "2015-12-31T12:00:00.000Z",
            "footer" => [ "text" => $date ]
        ];
    }
}
