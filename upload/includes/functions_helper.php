<?php
/**
 * Function used to get config value of ClipBucket
 * @param $input
 *
 * @return bool|string
 * @uses: { class : Cbucket } { var : configs }
 *
 */
function config($input)
{
    if (isset(ClipBucket::getInstance()->configs[$input])) {
        return ClipBucket::getInstance()->configs[$input];
    }

    if (in_dev()) {
        error_log('[CONFIG] Missing config : ' . $input . PHP_EOL);
    }
    return false;
}

/**
 * Function used to get player logo
 */
function website_logo(): string
{
    $logo_file = config('player_logo_file');
    if ($logo_file && file_exists(DirPath::get('images') . $logo_file)) {
        return DirPath::getUrl('images') . $logo_file;
    }
    return DirPath::getUrl('images') . 'logo.png';
}

/**
 * create_dated_folder()
 *
 * create date folders with respect to date. so that no folder gets overloaded
 * with number of files.
 *
 * @param null $headFolder
 * @param null $custom_date
 *
 * @return string
 * @internal param FOLDER $string , if set to null, sub-date-folders will be created in
 * all data folders
 */
function create_dated_folder($headFolder = null, $custom_date = null)
{
    $time = time();

    if ($custom_date) {
        if (!is_numeric($custom_date)) {
            $time = strtotime($custom_date);
        } else {
            $time = $custom_date;
        }
    }

    $folder = date('Y/m/d', $time);

    $data = cb_call_functions('dated_folder');
    if ($data) {
        return $data;
    }

    if (!$headFolder) {
        @mkdir(DirPath::get('videos') . $folder, 0777, true);
        @mkdir(DirPath::get('thumbs') . $folder, 0777, true);
        @mkdir(DirPath::get('original') . $folder, 0777, true);
        @mkdir(DirPath::get('photos') . $folder, 0777, true);
        @mkdir(DirPath::get('logs') . $folder, 0777, true);
        @mkdir(DirPath::get('subtitles') . $folder, 0777, true);
    } else {
        if (!file_exists($headFolder . DIRECTORY_SEPARATOR . $folder)) {
            @mkdir($headFolder . DIRECTORY_SEPARATOR . $folder, 0777, true);
        }
    }

    return apply_filters($folder, 'dated_folder');
}

function cb_create_html_tag($tag = 'p', $self_closing = false, $attrs = [], $content = null): string
{
    $open = '<' . $tag;
    $close = ($self_closing === true) ? '/>' : '>' . (!is_null($content) ? $content : '') . '</' . $tag . '>';

    $attributes = '';

    if (is_array($attrs) and count($attrs) > 0) {
        foreach ($attrs as $attr => $value) {
            if (strtolower($attr) == 'extra') {
                $attributes .= ($value);
            } else {
                $attributes .= ' ' . $attr . ' = "' . $value . '" ';
            }

        }

    }
    return $open . $attributes . $close;
}


/**
 * Takes a number and returns more human friendly format of it e.g 1000 == 1K
 *
 * @param : { integer } { $num } { number to convert to pretty number}
 *
 * @return bool|float|int|mixed|string : { integer } { $kviews } { pretty number after processing }
 * @since : 24th March, 2016 ClipBucket 2.8.1
 * @author : Saqib Razzaq
 */
function prettyNum($num)
{
    $prettyNum = preg_replace("/[^0-9\.]/", '', $num);
    if ($prettyNum >= 1000 && $prettyNum < 1000000) {
        $kviews = $prettyNum / 1000;
        if ($prettyNum > 1000) {
            $kviews = round($kviews, 0);
        }
        $kviews = $kviews . ' K'; // number is in thousands
    } elseif ($prettyNum >= 1000000 && $prettyNum < 1000000000) {
        $kviews = $prettyNum / 1000000;
        $kviews = round($kviews, 2);
        $kviews = $kviews . ' M'; // number is in millions
    } elseif ($prettyNum >= 1000000000) {
        $kviews = $prettyNum / 1000000000;
        $kviews = round($kviews, 2);
        $kviews = $kviews . ' B'; // number is in billions
    } elseif ($prettyNum < 1000) {
        return $prettyNum;
    }

    if (!empty($kviews)) {
        return $kviews;
    }
    return false;
}

/**
 * Handles everything going in ClipBucket development mode
 * @param $query
 * @param $query_type
 * @param $time
 * @param bool $cache
 * @return array : { array } { $__devmsgs } { array with all debugging data }
 * @since : 27th May, 2016
 * @author : Saqib Razzaq
 */
function devWitch($query, $query_type, $time, $cache = false): array
{
    global $__devmsgs;
    $memoryBefore = $__devmsgs['total_memory_used'];
    $memoryNow = memory_get_usage() / 1048576;
    $memoryDif = $memoryNow - $memoryBefore;
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['q'] = $query;
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['timetook'] = $time;
    $__devmsgs['total_query_exec_time'] = $__devmsgs['total_query_exec_time'] + $time;
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['memBefore'] = $memoryBefore;
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['memAfter'] = $memoryNow;
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['memUsed'] = $memoryDif;
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['use_cache'] = $cache ? 'yes' : 'no';
    $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]]['backtrace'] = debug_backtrace_string();
    $queryDetails = $__devmsgs[$query_type . '_queries'][$__devmsgs[$query_type]];

    $expesiveQuery = $__devmsgs['expensive_query'];
    $cheapestQuery = $__devmsgs['cheapest_query'];

    if (empty($expesiveQuery) || empty($cheapestQuery)) {
        $expesiveQuery = $queryDetails;
        $cheapestQuery = $queryDetails;
    } else {
        $memUsed = $queryDetails['memUsed'];
        if ($memUsed > $expesiveQuery['memUsed']) {
            $expesiveQuery = $queryDetails;
        }

        if ($memUsed < $cheapestQuery['memUsed']) {
            $cheapestQuery = $queryDetails;
        }
    }

    $__devmsgs['expensive_query'] = $expesiveQuery;
    $__devmsgs['cheapest_query'] = $cheapestQuery;
    $__devmsgs['total_memory_used'] = $memoryNow;
    $__devmsgs[$query_type] = $__devmsgs[$query_type] + 1;
    $__devmsgs['total_queries'] = !$cache ? $__devmsgs['total_queries'] + 1 : $__devmsgs['total_queries'];
    $__devmsgs['total_cached_queries'] = $cache ? $__devmsgs['total_cached_queries'] + 1 : $__devmsgs['total_cached_queries'];

    return $__devmsgs;
}

function showDevWitch()
{
    $file = DirPath::get('styles') . 'global/devmode.html';
    Template($file, false);
}

/**
 * Send respond to execute ajax return and continue execution
 * @param $callback
 * @param bool $ajax
 */
function sendClientResponseAndContinue($callback, bool $ajax = true)
{
    if (System::can_sse()) {
        ob_end_clean();
        ignore_user_abort(true);

        ob_start();

        header("Connection: close\r\n");
        header("Content-Encoding: none\r\n");

        $callback();

        $size = ob_get_length();
        header("Content-Length: $size");

        // Flush all output.
        ob_end_flush();
        ob_flush();
        flush();

        // Close current session (if it exists).
        if (session_id()) {
            session_write_close();
        }

        if ($ajax) {
            fastcgi_finish_request();
        }
    } else {
        $callback();
    }
}
