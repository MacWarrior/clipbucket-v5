<?php
class mass_upload extends Upload
{
    function get_video_files_list_clear()
    {
        return $this->get_video_files_list(true);
    }

    function get_video_files_list($listonly = false, $dir = MASS_UPLOAD_DIR)
    {
        require_once(BASEDIR.'/includes/classes/conversion/ffmpeg.class.php');
        $allowed_exts = get_vid_extensions();
        $FILES = scandir($dir);
        $FILE_LIST = array();

        foreach($FILES as $filename)
        {
            if(in_array($filename,array('.','..'))){
                continue;
            }

            $filepath = $dir.DIRECTORY_SEPARATOR.$filename;

            if( is_dir($filepath) ) {
                $new_files = $this->get_video_files_list($listonly, $filepath);

                if($new_files) {
                    if( $listonly ) {
                        $FILE_LIST = array_merge($FILE_LIST, $new_files);
                    } else {
                        $FILE_LIST[$filepath]['dirname'] = $filename;
                        $FILE_LIST[$filepath]['files'] = $new_files;
                    }
                }
                continue;
            }

            if( is_file($filepath) )
            {
                $file_extension = getext($filename);

                if(in_array($file_extension, $allowed_exts))
                {
                    $video_file = array();
                    $video_file['path']			= $dir.DIRECTORY_SEPARATOR;
                    $video_file['file']			= $filename;
                    $video_file['title']		= $filename;
                    $video_file['description']	= $filename;
                    $video_file['tags']			= gentags(str_replace(' ',',',$filename));
                    $video_file['size']			= formatfilesize( filesize($filepath) );
                    if( $tracks = FFMpeg::get_track_title($filepath, 'audio') ){
                        $video_file['tracks'] 	= $tracks;
                    }
                    $video_file = array_merge($video_file, FFMpeg::get_video_basic_infos($filepath));

                    $FILE_LIST[] = $video_file;
                }
            }
        }
        if(!empty($FILE_LIST)){
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
    function move_to_temp($file_arr,$file_key)
    {
        $file = $file_arr['file'];
        $mass_file  = $file_arr['path'].DIRECTORY_SEPARATOR.$file;
        $temp_file = TEMP_DIR.DIRECTORY_SEPARATOR.$file_key.'.'.getExt($file);
        if(file_exists($mass_file) && is_file($mass_file)) {
            copy($mass_file,$temp_file);
            return $file_key.'.'.getExt($file);
        }
        return false;
    }
}
