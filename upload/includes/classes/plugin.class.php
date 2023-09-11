<?php
class CBPlugin
{
    function __construct(){}

    /**
     * get plugin list
     */
    function getPlugins(): array
    {
        #first we will read the plugin directory
        #Current Plugin Class will read files only, not subdirectories
        $dir = PLUG_DIR;
        $dir_list = scandir($dir);
        foreach ($dir_list as $item) {
            if ($item == '..' || $item == '.' || substr($item, 0, 1) == '_' || substr($item, 0, 1) == '.') {
                continue;
            }

            //Now Checking if its file, not a directory
            if (!is_dir(PLUG_DIR . DIRECTORY_SEPARATOR . $item)) {
                $item_list[] = $item;
            } else {
                $sub_dir = $item;
                $sub_dir_list = scandir(PLUG_DIR . DIRECTORY_SEPARATOR . $item);
                foreach ($sub_dir_list as $item) {
                    if ($item == '..' || $item == '.' || substr($item, 0, 1) == '_' || substr($item, 0, 1) == '.') {
                        continue;
                    }
                    if (!is_dir(PLUG_DIR . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR . $item)) {
                        //Now Checking if its file, not a directory
                        $subitem_list[$sub_dir][] = $item;
                    }
                }
            }
        }

        //Our Plugin List has plugin main files only, now star reading files
        foreach ($item_list as $plugin_file) {
            $plugin_details = $this->get_plugin_details($plugin_file);
            if (!empty($plugin_details['name'])) {
                $plugins_array[] = $plugin_details;
            }
        }

        //Now Reading Sub Dir Files
        foreach ($subitem_list as $sub_dir => $sub_dir_list) {
            foreach ($sub_dir_list as $plugin_file) {
                $plugin_details = $this->get_plugin_details($plugin_file, $sub_dir);
                $plugin_details['folder'] = $sub_dir;
                if (!empty($plugin_details['name'])) {
                    $plugins_array[] = $plugin_details;
                }
            }
        }

        return $plugins_array;
    }

    /**
     * Function used to get new plugins, that are not installed yet
     * @throws Exception
     */
    function getNewPlugins()
    {
        //first get list of all plugins
        $plugin_list = $this->getPlugins();

        //Now Checking if plugin is installed or not
        if (!empty($plugin_list)) {
            $plug_array = [];
            foreach ($plugin_list as $plugin) {
                if (!$this->is_installed($plugin['file'])) {
                    $plug_array[] = $plugin;
                }
            }
            return $plug_array;
        }
    }

    /**
     * Function used to get new plugins, that are not installed yet
     * @throws Exception
     */
    function getInstalledPlugins()
    {
        global $db;

        $active_query = null;
        if (FRONT_END) {
            $active_query = 'plugin_active=\'yes\'';
        }

        $results = $db->select(tbl('plugins'), '*', $active_query, false, false, false, 60);

        $plug_array = [];
        if (is_array($results)) {
            foreach ($results as $result) {
                //Now Checking if plugin is installed or not
                $this_plugin = $this->get_plugin_details($result['plugin_file'], $result['plugin_folder']);
                if ($this_plugin) {
                    $result['file'] = $result['plugin_file'];
                    $result['folder'] = $result['plugin_folder'];
                    $plugin = array_merge($result, $this_plugin);
                    $plug_array[] = $plugin;
                }
            }
        }

        return $plug_array;
    }

    /**
     * @param      $file
     * @param null $v
     * @param null $folder
     *
     * @return bool
     * @throws Exception
     */
    function is_installed($file, $v = null, $folder = null): bool
    {
        global $db;

        $folder_check = '';
        if ($folder) {
            $folder_check = " AND plugin_folder ='$folder'";
        }

        $details = $db->select(tbl('plugins'), "plugin_file", "plugin_file='" . $file . "' $folder_check");
        if (count($details) > 0) {
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
    function get_plugin_details($plug_file, $sub_dir = null)
    {
        if ($sub_dir != '') {
            $sub_dir = $sub_dir . DIRECTORY_SEPARATOR;
        }

        $file = PLUG_DIR . DIRECTORY_SEPARATOR . $sub_dir . $plug_file;

        if (file_exists($file) && is_file($file)) {
            // We don't need to write to the file, so just open for reading.
            $fp = fopen($file, 'r');
            // Pull only the first 8kiB of the file in.
            $plugin_data = fread($fp, 8192);
            // PHP will close file handle, but we are good citizens.
            fclose($fp);
            preg_match('/Plugin Name:(.*)$/mi'       , $plugin_data, $name);
            preg_match('/Website:(.*)$/mi'           , $plugin_data, $website);
            preg_match('/Version:(.*)/mi'            , $plugin_data, $version);
            preg_match('/Description:(.*)$/mi'       , $plugin_data, $description);
            preg_match('/Author:(.*)$/mi'            , $plugin_data, $author);
            preg_match('/Author Website:(.*)$/mi'    , $plugin_data, $author_website);
            preg_match('/ClipBucket Version:(.*)$/mi', $plugin_data, $cbversion);

            $details_array = [
                'name',
                'website',
                'version',
                'description',
                'author',
                'author_website',
                'cbversion'
            ];
            foreach ($details_array as $detail) {
                $plugin_array[$detail] = (isset(${$detail}[1])) ? trim(${$detail}[1]) : false;
            }

            $plugin_array['compatibility'] = ($plugin_array['cbversion'] == VERSION);

            $plugin_array['file'] = $plug_file;
            if (isset($code[1])) {
                $plugin_array['code'] = preg_replace('/\s/', '', $code[1]);
            }

            return $plugin_array;
        }
        return false;
    }

    /**
     * ClipBucket Internal Plugin Installer
     *
     * @param      $pluginFile
     * @param null $folder
     *
     * @return bool|string
     * @throws Exception
     */
    function installPlugin($pluginFile, $folder = null)
    {
        $plug_details = $this->get_plugin_details($pluginFile, $folder);

        if (!$plug_details) {
            $msg = e(lang('plugin_no_file_err'));
        }
        if (empty($plug_details['name'])) {
            $msg = e(lang('plugin_file_detail_err'));
        }
        if ($this->is_installed($pluginFile, $folder)) {
            $msg = e(lang('plugin_installed_err'));
        }

        if (empty($msg)) {
            $file_folder = $folder;
            if ($folder != '') {
                $folder = $folder . DIRECTORY_SEPARATOR;
            }
            $plug_details = $this->get_plugin_details($folder . $pluginFile);

            $plug_install_file = PLUG_DIR . DIRECTORY_SEPARATOR . $folder . 'install_' . $pluginFile;
            if (file_exists($plug_install_file)) {
                require_once($plug_install_file);
            }

            dbInsert(
                tbl('plugins'),
                [
                    'plugin_file',
                    'plugin_active',
                    'plugin_folder',
                    'plugin_version'
                ],
                [
                    $pluginFile,
                    'yes',
                    $file_folder,
                    $plug_details['version']
                ]
            );

            //Checking For the installation SQL
            e(lang('plugin_install_msg'), 'm');
            return PLUG_DIR . DIRECTORY_SEPARATOR . $folder . $pluginFile;
        }
        return false;
    }

    /**
     * Function used to activate plugin
     *
     * @param        $plugin_file
     * @param string $active
     * @param null $folder
     *
     * @return null
     * @throws Exception
     */
    function pluginActive($plugin_file, $active = 'yes', $folder = null)
    {
        global $db;

        if ($folder) {
            $folder_query = " AND plugin_folder = '$folder'";
        }

        if ($this->is_installed($plugin_file)) {
            $db->execute('UPDATE ' . tbl('plugins') . " SET plugin_active='" . $active . "' WHERE plugin_file='" . $plugin_file . "' $folder_query");
            $active_msg = $active == 'yes' ? 'activated' : 'deactiveted';
            $msg = e(sprintf(lang('plugin_has_been_s'), $active_msg), 'm');
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
     * @throws Exception
     */
    function uninstallPlugin($file, $folder = null)
    {
        global $db;
        if ($this->is_installed($file)) {
            if ($folder) {
                $folder_query = " AND plugin_folder = '$folder'";
            }

            if ($folder != '') {
                $folder = $folder . DIRECTORY_SEPARATOR;
            }

            $db->execute('DELETE FROM ' . tbl('plugins') . " WHERE plugin_file='" . $file . "' $folder_query");

            $plug_uninstall_file = PLUG_DIR . DIRECTORY_SEPARATOR . $folder . 'uninstall_' . $file;
            if (file_exists($plug_uninstall_file)) {
                require_once($plug_uninstall_file);
            }
            $msg = e(lang('plugin_uninstalled'), 'm');
        } else {
            $msg = e(lang('plugin_no_install_err'));
        }
        return $msg;
    }

}
