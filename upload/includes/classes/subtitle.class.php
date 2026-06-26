<?php

class Subtitle
{
    private static string $table_name = "video_subtitle";

    private static string $extension = "vtt";
    /**
     * @param $vdetails
     * @return array|false
     * @throws Exception
     */
    public static function getVideoSubtitles($vdetails): bool|array
    {
        if (empty($vdetails)) {
            return false;
        }

        $results = Clipbucket_db::getInstance()->select(tbl(self::$table_name), 'videoid,number,title', ' videoid=' . $vdetails['videoid']);

        if (count($results) == 0) {
            return false;
        }

        $subtitles = [];
        foreach ($results as $line) {
            $subtitles[] = [
                'url'    => DirPath::getUrl('subtitles') . $vdetails['file_directory'] . '/' . $vdetails['file_name'] . '-' . $line['number'] . '.' . self::$extension,
                'title'  => $line['title'],
                'number' => $line['number']
            ];
        }

        return $subtitles;
    }

    /**
     * @param int $videoid
     * @return string|bool
     * @throws Exception
     */
    public static function getVideoSubtitleLastNum(int $videoid): string|bool
    {
        if (empty($videoid)) {
            return false;
        }
        $results = Clipbucket_db::getInstance()->select(tbl(self::$table_name), 'MAX(number) as number', 'videoid=' . $videoid);
        if (empty($results)) {
            return '00';
        }
        return $results[0]['number'] ?? '00';
    }

    /**
     * @param $vdetails
     * @param string|null $number
     * @throws Exception
     */
    public static function removeSubtitles($vdetails, string $number = null): void
    {
        $directory = DirPath::get('subtitles') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
        $query = 'SELECT * FROM ' . tbl(self::$table_name) . ' WHERE videoid = ' . (int)$vdetails['videoid'];
        if ($number !== null) {
            $query .= ' AND number = \'' . mysql_clean($number) . '\'';
        }
        $result = db_select($query);
        if ($result) {
            foreach ($result as $row) {
                $filepath = $directory . $vdetails['file_name'] . '-' . $row['number'] . '.vtt';
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            $query_delete = 'DELETE FROM ' . tbl(self::$table_name) . ' WHERE videoid = ' . (int)$vdetails['videoid'];
            if ($number !== null) {
                $query_delete .= ' AND number = \'' . mysql_clean($number) . '\'';
            }
            Clipbucket_db::getInstance()->execute($query_delete);
        }
        if ($number !== null) {
            e(str_replace('%s', $number, lang('video_subtitles_deleted_num')), 'm');
        } else {
            e(lang('video_subtitles_deleted'), 'm');
        }
    }

    /**
     * @param $video_id
     * @param string $file_directory
     * @param string $file_name
     * @return int
     * @throws Exception
     */
    public static function getSubtitlesUsage($video_id, string $file_directory, string $file_name): int
    {
        $total = 0;
        $directory = DirPath::get('subtitles') . $file_directory . DIRECTORY_SEPARATOR;
        $query = 'SELECT * FROM ' . tbl(self::$table_name) . ' WHERE videoid = ' . $video_id;
        $result = db_select($query);
        if ($result) {
            foreach ($result as $row) {
                $filepath = $directory . $file_name . '-' . $row['number'] . '.' . self::$extension;
                if (file_exists($filepath)) {
                    $total += filesize($filepath);
                }
            }
        }
        return $total;
    }

    /**
     * @param $videoid
     * @param $number
     * @param $title
     * @throws Exception
     */
    public static function updateSubtitle($videoid, $number, $title): void
    {
        if (!preg_match('/^\d{1,2}$/', $number)) {
            e(lang('invalid_params'));
            return;
        }
        if (Video::getInstance()->getOne(['videoid' => $videoid, 'count' => true])) {
            Clipbucket_db::getInstance()->update(tbl(self::$table_name), ['title'], [$title], ' videoid = ' . (int)$videoid . ' AND number = \'' . mysql_clean($number) . '\'');
        }
    }

    public static function getExtension(): string
    {
        return self::$extension;
    }


}