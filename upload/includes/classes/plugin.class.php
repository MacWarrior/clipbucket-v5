<?php

class CBPlugin extends ClipBucket
{
	//var $admin_plug_menu = CBucket::AdminMenu;
	function __construct() {}
	
	/**
	* get plugin list 
	*/
	function getPlugins()
	{
		#first we will read the plugin directory
		#Current Plugin Class will read files only, not sub directories
		$dir = PLUG_DIR;
		$dir_list = scandir($dir);
		foreach($dir_list as $item) {
			if($item=='..' || $item=='.' || substr($item,0,1)=='_'|| substr($item,0,1)=='.') {
				//Skip $item_list[] = $item;
				//$sub_dir_list = scandir(PLUG_DIR.'/'.$item);
			} else {
				//Now Checking if its file, not a directory
				if(!is_dir(PLUG_DIR.'/'.$item)) {
					$item_list[] = $item;
				} else {
					$sub_dir = $item;
					$sub_dir_list = scandir(PLUG_DIR.'/'.$item);
					foreach($sub_dir_list as $item) {
						if($item=='..' || $item=='.' || substr($item,0,1)=='_'|| substr($item,0,1)=='.') {
							//Skip $item_list[] = $item;
							//$sub_dir_list = scandir(PLUG_DIR.'/'.$item);
						} else if(!is_dir(PLUG_DIR.'/'.$sub_dir.'/'.$item)){
							//Now Checking if its file, not a directory
                            $subitem_list[$sub_dir][] = $item;
						}
					}
				}
			}
		}
		
		//Our Plugin List has plugin main files only, now star reading files
		foreach($item_list as $plugin_file) {
			$plugin_details = $this->getPluginDetails($plugin_file);
			if(!empty($plugin_details['name']))
			$plugins_array[]= $plugin_details;
		}
		
		//Now Reading Sub Dir Files
		foreach($subitem_list as $sub_dir => $sub_dir_list ) {
			foreach($subitem_list[$sub_dir] as $plugin_file) {
				$plugin_details = $this->getPluginDetails($plugin_file,$sub_dir);
				$plugin_details['folder'] = $sub_dir;
				if(!empty($plugin_details['name'])) {
				    $plugins_array[] = $plugin_details;
                }
			}
		}
		
		return $plugins_array;
	}
	
	function getPluginList()
	{
		return $this->getPlugins();
	}
	
	
	/**
	 * Function used to get new plugins, that are not installed yet
	 */
	function getNewPlugins()
	{
		//first get list of all plugins
		$plugin_list = $this->getPluginList();
		
		//Now Checking if plugin is installed or not
		if(is_array($plugin_list)) {
			foreach($plugin_list as $plugin) {
				if(!$this->is_installed($plugin['file'])){
				    $plug_array[] = $plugin;
                }
			}
			return $plug_array;
		}
	}
	
	
	/**
	 * Function used to get new plugins, that are not installed yet
	 */
	function getInstalledPlugins()
	{
		global $db;
		//first get list of all plugins
		$plugin_list = $this->getPluginList();
		
		if(FRONT_END){
			$active_query = " plugin_active='yes' ";
        } else {
			$active_query = NULL;
        }
		$results = $db->select(tbl('plugins'),'*',$active_query);
		
		if(is_array($results)){
            foreach($results as $result) {
                //Now Checking if plugin is installed or not
                $this_plugin = $this->get_plugin_details($result['plugin_file'],$result['plugin_folder']);
                if($this_plugin) {
                    $result['file'] = $result['plugin_file'];
                    $result['folder'] = $result['plugin_folder'];
                    $plugin = array_merge($result,$this_plugin);
                    $plug_array[] = $plugin;
                }
            }
        }

		return $plug_array ?? false;
	}

	/**
	 * Function used to check weather plugin is instlled or not
	 *
	 * @param      $file
	 * @param null $v
	 * @param null $folder
	 *
	 * @return bool
	 */
	function is_installed($file,$v=NULL,$folder=NULL)
	{
		global $db;

		if($folder){
			$folder_check = " AND plugin_folder ='$folder'";
        }

		$details = $db->select(tbl("plugins"),"plugin_file","plugin_file='".$file."' $version_check $folder_check");
		if(count($details)>0){
			return true;
        }
		return false;
	}


	/**
	 * get plugin details
	 *
	 * @param      $plug_file
	 * @param null $sub_dir
	 *
	 * @return array|bool
	 */
	function get_plugin_details($plug_file,$sub_dir=NULL)
	{
		if($sub_dir!=''){
			$sub_dir = $sub_dir.DIRECTORY_SEPARATOR;
        }
			
		$file = PLUG_DIR.'/'.$sub_dir.$plug_file;

		if(file_exists($file) && is_file($file)) {
			// We don't need to write to the file, so just open for reading.
			$fp = fopen($file, 'r');
			// Pull only the first 8kiB of the file in.
			$plugin_data = fread( $fp, 8192 );
			// PHP will close file handle, but we are good citizens.
			fclose($fp);
			preg_match( '/Plugin Name:(.*)$/mi', $plugin_data, $name );
			preg_match( '/Website:(.*)$/mi', $plugin_data, $website );
			preg_match( '/Version:(.*)/mi', $plugin_data, $version );
			preg_match( '/Description:(.*)$/mi', $plugin_data, $description );
			preg_match( '/Author:(.*)$/mi', $plugin_data, $author );
			preg_match( '/Author Website:(.*)$/mi', $plugin_data, $author_page );
			preg_match( '/ClipBucket Version:(.*)$/mi', $plugin_data, $cbversion );
			preg_match( '/Plugin Type:(.*)$/mi', $plugin_data, $type );
			
			$details_array = array(
                'name',
                'website',
                'version',
                'description',
                'author',
                'cbversion',
                'code',
                'author_page',
                'type'
            );
			foreach ($details_array as $detail) {
				$plugin_array[$detail]= (isset(${$detail}[1])) ? ${$detail}[1] : false;
			}
			$plugin_array['file'] = $plug_file;
			if(isset($code[1])){
				$plugin_array['code'] = preg_replace('/\s/', '', $code[1]);
            }
			
			return $plugin_array;
		}
		return false;
	}

	function getPluginDetails($file,$sub_dir=NULL)
	{
		return $this->get_plugin_details($file,$sub_dir);
	}

    /**
     * Function used to get plugin details from database
     *
     * @param      $file
     * @param null $folder
     *
     * @return mixed
     */
	 function getPlugin($file,$folder=NULL)
	 {
	     global $db;
		 if($folder){
		 	$folder_query = " AND plugin_folder = '$folder'";
         }
			
		 $result = $db->select(tbl("plugins"),"*"," plugin_file ='".$file."' $folder_query" );
		 return $result[0];
	 }

    /**
     * ClipBucket Internal Plugin Installer
     *
     * @param      $pluginFile
     * @param null $folder
     *
     * @return bool|string
     */
	 function installPlugin($pluginFile,$folder=NULL)
	 {
		 $plug_details = $this->get_plugin_details($pluginFile,$folder);

		 if(!$plug_details){
		 	$msg = e(lang('plugin_no_file_err'));
         }
		 if(empty($plug_details['name'])){
		 	$msg = e(lang('plugin_file_detail_err'));
         }
		 if($this->is_installed($pluginFile,$folder)){
		 	$msg = e(lang('plugin_installed_err'));
         }
		
        if(empty($msg))
        {
            $file_folder = $folder;
            if($folder!=''){
                $folder  = $folder.DIRECTORY_SEPARATOR;
            }
            $plug_details = $this->getPluginDetails($folder.$pluginFile);

            if(file_exists(PLUG_DIR.DIRECTORY_SEPARATOR.$folder.'install_'.$pluginFile)){
                require_once(PLUG_DIR.DIRECTORY_SEPARATOR.$folder.'install_'.$pluginFile);
            }

            dbInsert
            (
                tbl('plugins'),
                array(
                    'plugin_file',
                    'plugin_license_type',
                    'plugin_license_key',
                    'plugin_license_code',
                    'plugin_active',
                    'plugin_folder',
                    'plugin_version'
                ),
                array(
                    $pluginFile,
                    $plug_details['license_type'],
                    $plug_details['license_key'],
                    $plug_details['license_code'],
                    'yes',
                    $file_folder,
                    $plug_details['version']
                )
            );
			 
            //Checking For the installation SQL
            $msg = e(lang('plugin_install_msg'),'m');
            define('NEW_INSTALL',false);
            return PLUG_DIR.DIRECTORY_SEPARATOR.$folder.$pluginFile;
        }
        return false;
	 }

    /**
     * Function used to activate plugin
     *
     * @param        $plugin_file
     * @param string $active
     * @param null   $folder
     *
     * @return null
     */
	 function pluginActive($plugin_file,$active='yes',$folder=NULL){
		global $db;
		
		if($folder){
		 	$folder_query = " AND plugin_folder = '$folder'";
        }
			
		if($this->is_installed($plugin_file)) {
			$db->Execute("UPDATE ".tbl("plugins")." SET plugin_active='".$active."' WHERE plugin_file='".$plugin_file."' $folder_query");
			$active_msg = $active=='yes' ? 'activated' : 'deactiveted';
			$msg = e(sprintf(lang("plugin_has_been_s"),$active_msg),'m');
		} else {
			$msg = e(lang('plugin_no_install_err'));
		}
		return $msg;
	 }

    /**
     * Function used to activate plugin
     *
     * @param      $file
     * @param null $folder
     *
     * @return null
     */
	 function uninstallPlugin($file,$folder=NULL){
		global $db;
		if($this->is_installed($file)) {
			if($folder){
		 		$folder_query = " AND plugin_folder = '$folder'";
            }
				
			if($folder!=''){
				$folder  = $folder.'/';
            }

			$db->Execute("DELETE FROM ".tbl("plugins")." WHERE plugin_file='".$file."' $folder_query");
			if(file_exists(PLUG_DIR.'/'.$folder.'uninstall_'.$file)){
			    require_once(PLUG_DIR.'/'.$folder.'uninstall_'.$file);
            }
			$msg = e(lang("plugin_uninstalled"),"m");
		} else {
			$msg = e(lang('plugin_no_install_err'));
		}
		return $msg;
	 }
	 
}
