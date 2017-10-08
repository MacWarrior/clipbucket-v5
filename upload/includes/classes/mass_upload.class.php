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
				if( filemtime( $file ) > $sec )
				{
					$FILE_LIST[$key]['path']		= substr( $file, 0, ( strrpos( $file, $this->dirsep ) +1 ) );
					$FILE_LIST[$key]['file']		= substr( $file, ( strrpos( $file, $this->dirsep ) +1 ) );
					$FILE_LIST[$key]['title']		= getName($FILE_LIST[$key]['file']);
					$FILE_LIST[$key]['description']	= getName($FILE_LIST[$key]['file']);
					$FILE_LIST[$key]['tags']		= gentags(str_replace(" ",",",getName($FILE_LIST[$key]['file'])));
					$FILE_LIST[$key]['size']		= filesize( $file );
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

						$vid_files[] = $file;
					}
				}
			}
			return $vid_files;
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
			$mass_file  = MASS_UPLOAD_DIR.'/'.$file;
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

		/**
		 * Function used to check weather file exists in mass upload folder or not
		 *
		 * @param $arr
		 *
		 * @return bool
		 */
		function is_mass_file($arr)
		{
			$file = MASS_UPLOAD_DIR.'/'.$arr['file'];
			if(file_exists($file) && is_file($file) && $arr['file'])
				return true;
			return false;
		}
	}
