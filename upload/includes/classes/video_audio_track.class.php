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