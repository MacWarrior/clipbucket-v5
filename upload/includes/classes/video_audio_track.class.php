<?php

class VideoAudioTrack
{
    private static string $tablename = 'video_audio_tracks';
    /**
     * @param int $videoid
     * @return array
     * @throws Exception
     */
    public static function getAudioTracks(int $videoid): array
    {
        $sql = 'SELECT * FROM ' . tbl(self::$tablename) . ' WHERE videoid = ' . $videoid . ' ORDER BY `order` ';
        return Clipbucket_db::getInstance()->_select($sql);
    }

    /**
     * @throws Exception
     */
    public static function insertFromFile(int $videoid, string $filepath): void
    {
        $existing_tracks = self::getAudioTracks($videoid);
        $existing_numbers = array_column($existing_tracks, 'track_number');
        $order = empty($existing_tracks) ? 0 : max(array_column($existing_tracks, 'order')) + 1;
        $tracks = array_values(FFMpeg::get_track_infos($filepath, 'audio'));
        $without_language = count(array_filter($tracks, function ($track) {
            return $track['language'] == '';
        }));

        foreach ($tracks as $number => $track) {
            if (in_array($number, $existing_numbers)) {
                continue;
            }

            if ($track['language'] != '') {
                $title = $track['language'];
            } elseif ($without_language == 1) {
                $title = 'original version';
            } else {
                $title = $track['title'] != '' ? $track['title'] : (string)$number;
            }

            $sql = 'INSERT IGNORE INTO ' . tbl(self::$tablename) . '(`videoid`, `track_number`, `title`, `order`) VALUES (' . $videoid . ', ' . $number . ', \'' . mysql_clean($title) . '\', ' . $order . ')';
            Clipbucket_db::getInstance()->execute($sql);
            $order++;
        }
    }

    /**
     * @param $params
     * @return bool
     * @throws Exception
     */
    public static function saveAudioTrack($params): bool
    {
        $sql = 'UPDATE ' . tbl(self::$tablename) . ' SET `title` = \'' . mysql_clean($params['title']) . '\' WHERE `videoid` = ' . (int)$params['videoid'] . ' AND `track_number` = ' . (int)$params['track_number'];
        return (bool)Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @param $videoid
     * @param $lines
     * @return bool
     * @throws Exception
     */
    public static function updateAudioTrackOrder($videoid, $lines): bool
    {
        foreach ($lines as $order => $number) {
            $sql = 'UPDATE ' . tbl(self::$tablename) . ' SET `order` =' . (int)$order . ' WHERE `videoid` = ' . (int)$videoid . ' AND `track_number` = ' . (int)$number;
            Clipbucket_db::getInstance()->execute($sql);
        }
        return true;
    }
}
