<?php

class mass_upload extends Upload
{
    function get_video_files_list_clear()
    {
        return $this->get_video_files_list(true);
    }

    /**
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    function get_video_files_list($listonly = false, $dir = null)
    {
        if( is_null($dir) ){
            $dir = DirPath::get('mass_uploads');
        } else if (substr($dir, -1) !== DIRECTORY_SEPARATOR) {
            $dir .= DIRECTORY_SEPARATOR;
        }

        require_once DirPath::get('classes') . 'conversion/ffmpeg.class.php';
        $cache_key = 'vid_info:';
        $allowed_exts = get_vid_extensions();
        $FILES = scandir($dir);
        $FILE_LIST = [];

        foreach ($FILES as $filename) {
            if (in_array($filename, ['.', '..'])) {
                continue;
            }

            $filepath = $dir . $filename;

            if( !is_readable($filepath) ){
                continue;
            }

            if (is_dir($filepath . DIRECTORY_SEPARATOR)) {
                $new_files = $this->get_video_files_list($listonly, $filepath);

                if ($new_files) {
                    if ($listonly) {
                        $FILE_LIST = array_merge($FILE_LIST, $new_files);
                    } else {
                        $FILE_LIST[$filepath]['dirname'] = $filename;
                        $FILE_LIST[$filepath]['files'] = $new_files;
                    }
                }
                continue;
            }

            if (is_file($filepath)) {
                $file_extension = getext($filename);

                if (in_array($file_extension, $allowed_exts)) {
                    $video_file = CacheRedis::getInstance()->get($cache_key . $filepath);
                    if (empty($video_file)) {
                        $video_file = [];
                        $video_file['path'] = $dir . DIRECTORY_SEPARATOR;
                        $video_file['file'] = $filename;
                        $video_file['title'] = $filename;
                        $video_file['description'] = $filename;
                        $video_file['size'] = formatfilesize(filesize($filepath));
                        if ($tracks = FFMpeg::get_track_title($filepath, 'audio')) {
                            $video_file['tracks'] = $tracks;
                        }
                        $video_file = array_merge($video_file, FFMpeg::get_video_basic_infos($filepath));
                        CacheRedis::getInstance()->set($cache_key . $filepath, $video_file, 900);
                    }

                    $FILE_LIST[] = $video_file;
                }
            }
        }
        if (!empty($FILE_LIST)) {
            return $FILE_LIST;
        }
        return false;
    }

    /**
     * Moving file from MASS UPLOAD DIR TO TEMP DIR
     *
     * @param $file_arr
     * @param $file_key
     *
     * @return bool|string
     */
    function move_to_temp($file_arr, $file_key)
    {
        $file = $file_arr['file'];
        $mass_file = $file_arr['path'] . DIRECTORY_SEPARATOR . $file;
        $temp_file = DirPath::get('temp') . $file_key . '.' . getExt($file);
        if (file_exists($mass_file) && is_file($mass_file)) {
            copy($mass_file, $temp_file);
            return $file_key . '.' . getExt($file);
        }
        return false;
    }
}
