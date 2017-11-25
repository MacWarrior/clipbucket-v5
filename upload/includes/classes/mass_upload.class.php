<?php
	/*
	****************************************************************
	| Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.
	| @ Author 	: ArslanHassan
	| @ Software 	: ClipBucket , © PHPBucket.com
	****************************************************************
	****************************************************************
	Copyright (c) 2007-2008 Clip-Bucket.com. All rights reserved.
	****************************************************************
	**/

	class mass_upload extends Upload
	{
		var $dirsep = "/";

		/**
		 * FUNCTION USED TO GET FILES FROM DIRECTORY
		 *
		 * @param        $source_folder
		 * @param string $ext
		 * @param int    $sec
		 *
		 * @return bool
		 */
		function glob_files($source_folder, $ext='*', $sec=0)
		{
			if( !is_dir( $source_folder ) ) {
				die ( "Invalid directory.\n\n" );
			}

			$FILES = glob($source_folder.$this->dirsep."*.".$ext);

			foreach($FILES as $key => $file)
			{
				if( is_dir($file) )
					continue;

				if( filemtime( $file ) > $sec )
				{
					$FILE_LIST[$key]['path']		= substr( $file, 0, ( strrpos( $file, $this->dirsep ) +1 ) );
					$FILE_LIST[$key]['file']		= substr( $file, ( strrpos( $file, $this->dirsep ) +1 ) );
					$FILE_LIST[$key]['title']		= getName($FILE_LIST[$key]['file']);
					$FILE_LIST[$key]['description']	= getName($FILE_LIST[$key]['file']);
					$FILE_LIST[$key]['tags']		= gentags(str_replace(" ",",",getName($FILE_LIST[$key]['file'])));
					$FILE_LIST[$key]['size']		= formatfilesize( filesize($file) );
					$FILE_LIST[$key]['date']		= date('Y-m-d G:i:s', filemtime( $file ) );
				}
			}
			if(!empty($FILE_LIST)){
				return $FILE_LIST;
			}
			return false;
		}

		/**
		 * Function used to get list of available files that can be processed
		 */
		function get_files()
		{
			$files = $this->glob_files(MASS_UPLOAD_DIR);
			return $files;
		}

		/**
		 * function used to get video files only3
		 * @return array
		 * @internal param bool $with_path
		 *
		 */
		function get_video_files()
		{
			require_once(BASEDIR.'/includes/classes/conversion/ffmpeg.class.php');
			$exts = get_vid_extensions();

			$vid_files = array();
			$files = $this->get_files();
			if(is_array($files))
			{
				foreach($files as $file)
				{
					$ext = getext($file['file']);
					if(in_array($ext,$exts))
					{
						$file['tracks'] = FFMpeg::get_video_tracks($file['path'].$file['file']);
						$file = array_merge($file, FFMpeg::get_video_basic_infos($file['path'].$file['file']));

						$vid_files[] = $file;
					}
				}
			}
			return $vid_files;
		}

		function get_video_files_list_clear()
		{
			return $this->get_video_files_list( true);
		}

		function get_video_files_list($listonly = false, $dir = MASS_UPLOAD_DIR, &$count = 0)
		{
			require_once(BASEDIR.'/includes/classes/conversion/ffmpeg.class.php');
			$allowed_exts = get_vid_extensions();
			$FILES = glob($dir.$this->dirsep.'*');
			$FILE_LIST = array();

			foreach($FILES as $file)
			{
				$filename = substr( $file, ( strrpos( $file, $this->dirsep ) +1 ));
				if( is_dir($file) )
				{
					$new_files = $this->get_video_files_list($listonly, $file, $count);
					if($new_files)
					{
						if( $listonly )
						{
							$FILE_LIST = array_merge($FILE_LIST, $new_files);
						} else {
							$FILE_LIST[$file]['dirname'] = $filename;
							$FILE_LIST[$file]['files'] = $new_files;
						}
					}
					continue;
				}

				if( is_file($file) )
				{
					$file_extension = getext($filename);

					if(in_array($file_extension, $allowed_exts))
					{
						$video_file = array();
						$video_file['path']			= substr( $file, 0, ( strrpos( $file, $this->dirsep ) +1 ) );
						$video_file['file']			= $filename;
						$video_file['title']		= getName($filename);
						$video_file['description']	= getName($filename);
						$video_file['tags']			= gentags(str_replace(" ",",",getName($filename)));
						$video_file['size']			= formatfilesize( filesize($file) );
						$video_file['date']			= date('Y-m-d G:i:s', filemtime($file) );
						$video_file['count']		= $count;
						if( $tracks = FFMpeg::get_video_tracks($file) )
							$video_file['tracks'] 	= $tracks;
						$video_file = array_merge($video_file, FFMpeg::get_video_basic_infos($file));

						$FILE_LIST[] = $video_file;
						$count++;
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
			$mass_file  = $file_arr['path'].'/'.$file;
			$con_que=CON_DIR.'/'.$file_key.'.mp4';
			$temp_file = TEMP_DIR.'/'.$file_key.'.'.getExt($file);
			if(file_exists($mass_file) && is_file($mass_file))
			{
				copy($mass_file,$temp_file);
				copy($temp_file,$con_que);
				return $file_key.'.'.getExt($file);
			}
			return false;
		}
	}
