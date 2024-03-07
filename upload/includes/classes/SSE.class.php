<?php

class SSE
{
    /**
     *
     * @param callable $function MUST RETURN OUTPUT
     * @return void
     */
    public static function processSSE(callable $function, $sleep)
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        header('connection: keep-alive');
        ignore_user_abort(false);
        if (session_id()) {
            session_write_close();
        }
        if (ob_get_level() == 0) {
            ob_start();
        }

        while (true) {
            if (connection_aborted()) {
                exit();
            }
            $return = $function();
            if (empty($return['output'])) {
                error_log('missing output for sse');
                exit();
            }
            if (!empty($return['sleep'])) {
                $sleep = $return['sleep'];
            }
            $output = $return['output'];
            $output_beffering = ini_get('output_buffering') ?? 4096;
            $output .= str_pad('', $output_beffering) . "\n\n";
            echo $output;
            ob_flush();
            flush();
            sleep($sleep);
        }
    }
}