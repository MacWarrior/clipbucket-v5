<?php

class Funscript
{
    public static function getVideoScript(array $video): ?string
    {
        $directory = str_replace('\\', '/', $video['file_directory'] ?? '');
        $file_name = $video['file_name'] ?? '';
        if ( !preg_match('~^\d{4}/\d{2}/\d{2}$~D', $directory) || !preg_match('/^[a-zA-Z0-9_-]+$/D', $file_name) ) {
            return null;
        }

        $root = realpath(DirPath::get('files') . 'funscripts');
        if ( $root === false ) {
            return null;
        }
        $path = realpath($root . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $file_name . '-01.funscript');
        if ( $path === false || !str_starts_with($path, $root . DIRECTORY_SEPARATOR) || !is_file($path) || !is_readable($path) || filesize($path) > 16777216 ) {
            return null;
        }

        $content = file_get_contents($path);
        $script = $content === false ? null : json_decode($content, true);
        if ( !is_array($script) || empty($script['actions']) || !is_array($script['actions']) || count($script['actions']) > 500000 ) {
            return null;
        }

        $actions = [];
        foreach ($script['actions'] as $action) {
            if ( !is_array($action) || !isset($action['at'], $action['pos']) || !is_int($action['at']) || $action['at'] < 0 || $action['at'] > 9007199254740991
                || (!is_int($action['pos']) && !is_float($action['pos'])) || !is_finite((float)$action['pos']) || $action['pos'] < 0 || $action['pos'] > 100 ) {
                return null;
            }
            $actions[] = ['at' => $action['at'], 'pos' => $action['pos']];
        }

        // Only playback data is embedded; metadata is not needed by the player.
        $json = json_encode(['actions' => $actions, 'inverted' => ($script['inverted'] ?? false) === true], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        return $json === false ? null : $json;
    }
}
