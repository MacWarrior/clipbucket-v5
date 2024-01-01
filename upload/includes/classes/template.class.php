<?php

class CBTemplate
{
    /**
     * Function used to set Smarty Functions
     */
    function init()
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->load_smarty();
        }
    }

    function load_smarty()
    {
        global $Smarty;
        $Smarty = new SmartyBC;

        $Smarty->setCompileCheck(true);
        $Smarty->setDebugging(false);
        $Smarty->setTemplateDir(DirPath::get('styles'));
        $Smarty->setCompileDir(DirPath::get('views'));

        if (in_dev()) {
            $Smarty->clearAllCache();
        }
    }

    function create()
    {
        global $Smarty;

        if (!isset($Smarty)) {
            $this->load_smarty();
        }
        return true;
    }

    function setType($type)
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->create();
        }
        $Smarty->type = $type;
    }

    function assign($var, $value)
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->create();
        }
        $Smarty->assign($var, $value);
    }

    function display($filename)
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->create();
        }
        $Smarty->display($filename);
    }

    function fetch($filename)
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->create();
        }
        return $Smarty->fetch($filename);
    }

    /**
     * Function used to get available templates
     */
    function get_templates(): array
    {
        $dir = DirPath::get('styles');
        //Scaning Dir
        $dirs = scandir($dir);
        foreach ($dirs as $tpl) {
            if (substr($tpl, 0, 1) != '.') {
                $tpl_dirs[] = $tpl;
            }
        }
        //Now Checking for template template.xml
        $tpls = [];
        foreach ($tpl_dirs as $tpl_dir) {
            $tpl_details = CBTemplate::get_template_details($tpl_dir);

            if ($tpl_details && $tpl_details['name'] != '') {
                $tpls[$tpl_details['name']] = $tpl_details;
            }
        }

        return $tpls;
    }

    function get_template_details($temp)
    {
        $file = DirPath::get('styles') . $temp . '/template.xml';
        if (file_exists($file)) {
            $content = file_get_contents($file);
            preg_match('/<name>(.*)<\/name>/', $content, $name);
            preg_match('/<author>(.*)<\/author>/', $content, $author);
            preg_match('/<version>(.*)<\/version>/', $content, $version);
            preg_match('/<released>(.*)<\/released>/', $content, $released);
            preg_match('/<description>(.*)<\/description>/', $content, $description);
            preg_match('/<website title="(.*)">(.*)<\/website>/', $content, $website_arr);

            /* For 2.7 and Smarty v3 Support */
            preg_match('/<min_version>(.*)<\/min_version>/', $content, $min_version);
            preg_match('/<smarty_version>(.*)<\/smarty_version>/', $content, $smarty_version);

            $name = $name[1] ?? false;
            $author = $author[1] ?? false;
            $version = $version[1] ?? false;
            $released = $released[1] ?? false;
            $description = $description[1] ?? false;
            $min_version = $min_version[1] ?? false;
            $smarty_version = $smarty_version[1] ?? false;

            $website = ['title' => $website_arr[1], 'link' => $website_arr[2]];

            return [
                'name'           => $name,
                'author'         => $author,
                'version'        => $version,
                'released'       => $released,
                'description'    => $description,
                'website'        => $website,
                'dir'            => $temp,
                'min_version'    => $min_version,
                'smarty_version' => $smarty_version,
                'path'           => DirPath::get('styles') . $temp
            ];
        }
        return false;
    }

    /**
     * Function used to get template thumb
     *
     * @param $template
     *
     * @return string
     */
    function get_preview_thumb($template): string
    {
        $path = DirPath::getUrl('styles') . $template . '/images/preview.';
        $exts = ['png', 'jpg', 'gif'];
        $thumb_path = DirPath::getUrl('images') . 'icons/no_thumb_template.png';
        foreach ($exts as $ext) {
            $file = DirPath::get('root') . $path . $ext;
            if (file_exists($file)) {
                $thumb_path = $path . $ext;
                break;
            }
        }

        return $thumb_path;
    }

    /**
     * Function used to get any template
     */
    function get_any_template()
    {
        $templates = $this->get_templates();
        if (is_array($templates)) {
            foreach ($templates as $template) {
                if (!empty($template['name'])) {
                    return $template['dir'];
                }
            }
        }
        return false;
    }

    /**
     * Function used to check weather given template is ClipBucket Template or not
     * It will read Template XML file
     *
     * @param $folder
     *
     * @return array|bool
     */
    function is_template($folder)
    {
        return $this->get_template_details($folder);
    }

    /**
     * Function used to get list of template file frrom its layout and styles folder
     *
     * @param      $template
     * @param null $type
     *
     * @return array
     */
    function get_template_files($template, $type = null): array
    {
        switch ($type) {
            case 'layout':
            default:
                $style_dir = DirPath::get('styles') . "$template/layout/";
                $files_patt = $style_dir . '*.html';
                $files = glob($files_patt);
                /**
                 * All Files IN Layout Folder
                 */
                $new_files = [];
                foreach ($files as $file) {
                    $new_files[] = str_replace($style_dir, '', $file);
                }

                /**
                 * Now Reading Blocks Folder
                 */
                $blocks = $style_dir . 'blocks/';
                $file_patt = $blocks . '*.html';
                $files = glob($file_patt);
                foreach ($files as $file) {
                    $new_files['blocks'][] = str_replace($blocks, '', $file);
                }
                return $new_files;

            case 'theme':
                $style_dir = DirPath::get('styles') . "$template/theme/";
                $files_patt = $style_dir . '*.css';
                $files = glob($files_patt);
                /**
                 * All Files IN CSS Folder
                 */
                $new_files = [];
                foreach ($files as $file) {
                    $new_files[] = str_replace($style_dir, '', $file);
                }

                return $new_files;
        }
    }
}
