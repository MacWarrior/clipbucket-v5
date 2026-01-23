<?php

class CBTemplate
{

    public static $allowed_fields = ['name', 'description', 'title', 'link', 'version','released', 'author'];
    public static function getInstance()
    {
        global $cbtpl;
        return $cbtpl;
    }

    const DEFAULT_TEMPLATE_NAME = 'ClipbucketV5 official';

    /**
     * @param string $field
     * @param string $value
     * @param string $path
     * @return bool
     * @throws Exception
     */
    public static function save(string $field, string $value, string $path): bool
    {
        if (!in_array($field, self::$allowed_fields)) {
            return false;
        }
        $dir = self::secureTemplatePath($path);
        $template_xml = $dir . DIRECTORY_SEPARATOR . 'template.xml';
        if (!file_exists($template_xml)) {
            throw new Exception('template.xml not found');
        }
        if($field == 'link') {
            $field = 'website';
        }
        if ($field == 'released' && preg_match('/[a-zA-Z]/', $value)) {
            throw new Exception(lang('error_format_date'));
        }
        $xml = simplexml_load_file($template_xml);
        if ($field == 'title') {
            $xml->website->attributes()['title'] = $value;
        } elseif ($field == 'website' && !filter_var($value, FILTER_VALIDATE_URL) ) {
            throw new Exception(lang('incorrect_url'));
        } else {
            if (empty($xml->$field)) {
                return false;
            }
            $xml->$field = $value;
        }
        $xml->saveXML($template_xml);
        return true;
    }

    /**
     * Function used to set Smarty Functions
     */
    function init(): void
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->load_smarty();
        }
    }

    function load_smarty(): void
    {
        global $Smarty;
        $Smarty = new SmartyBC;

        $Smarty->setCompileCheck(true);
        $Smarty->setDebugging(false);
        $Smarty->setTemplateDir(DirPath::get('styles'));
        $Smarty->setCompileDir(DirPath::get('views'));

        if (System::isInDev()) {
            $Smarty->clearAllCache();
        }
    }

    function create(): bool
    {
        global $Smarty;

        if (!isset($Smarty)) {
            $this->load_smarty();
        }
        return true;
    }

    function assign($var, $value): void
    {
        global $Smarty;
        if (!isset($Smarty)) {
            $this->create();
        }
        $Smarty->assign($var, $value);
    }

    function display($filename): void
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
            if (!str_starts_with($tpl, '.')) {
                $tpl_dirs[] = $tpl;
            }
        }
        //Now Checking for template template.xml
        $tpls = [];
        foreach ($tpl_dirs as $tpl_dir) {
            $tpl_details = CBTemplate::get_template_details($tpl_dir);
            //TODO check if is copy
            if ($tpl_details && $tpl_details['name'] != '') {
                $tpls[] = $tpl_details;
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
        $url = DirPath::getUrl('styles') . $template . '/images/preview.';
        $path = DirPath::get('styles') . $template . '/images/preview.';
        $exts = ['png', 'jpg', 'gif'];
        $thumb_path = DirPath::getUrl('images') . 'icons/no_thumb_template.jpg';
        foreach ($exts as $ext) {
            $file = $path . $ext;
            if (file_exists($file)) {
                $thumb_path = $url . $ext;
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
                $style_dir = DirPath::get('styles') . $template . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR;
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
                $blocks = $style_dir . 'blocks' . DIRECTORY_SEPARATOR;
                $file_patt = $blocks . '*.html';
                $files = glob($file_patt);
                foreach ($files as $file) {
                    $new_files['blocks'][] = str_replace($blocks, '', $file);
                }
                return $new_files;

            case 'theme':
                $style_dir = DirPath::get('styles') . $template . DIRECTORY_SEPARATOR . 'theme' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR;
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

    /**
     * @return true
     * @throws Exception
     */
    public static function duplicate_default_theme(): bool
    {
        $source = DirPath::get('styles') . ClipBucket::DEFAULT_TEMPLATE;
        $dest = DirPath::get('styles') . ClipBucket::DEFAULT_TEMPLATE . '_' . str_replace('.', '', Update::getInstance()->getCurrentCoreVersion()) . '_' . Update::getInstance()->getCurrentCoreRevision() . '_' . date('YmdHis');
        $permissions = 0755;
        //Copy all folders and files recursively
        self::xcopy($source, $dest, $permissions);
        //change template.xml
        $new_template = $dest . DIRECTORY_SEPARATOR . 'template.xml';
        if (!file_exists($new_template)) {
            throw new Exception('template.xml not found');
        }
        $xml = simplexml_load_file($new_template);
        $xml->name = 'Copy of ' . $xml->name;
        $xml->description = 'Copy of ' . $xml->description;
        $xml->saveXML($new_template);
        return true;
    }

    /**
     * @param $source
     * @param $dest
     * @param $permissions
     * @return bool
     */
    private static function xcopy($source, $dest, $permissions): bool
    {
        $sourceHash = self::hashDirectory($source);
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }
        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // Deep copy directories
            if ($sourceHash != self::hashDirectory($source . DIRECTORY_SEPARATOR . $entry)) {
                self::xcopy($source . DIRECTORY_SEPARATOR . $entry, $dest . DIRECTORY_SEPARATOR . $entry, $permissions);
            }
        }

        // Clean up
        $dir->close();
        return true;
    }


    /**
     * In case of coping a directory inside itself, there is a need to hash check the directory otherwise and infinite loop of coping is generated
     * @param $directory
     * @return false|string
     */
    private static function hashDirectory($directory): bool|string
    {
        if (!is_dir($directory)) {
            return false;
        }
        $files = [];
        $dir = dir($directory);
        while (false !== ($file = $dir->read())) {
            if ($file != '.' and $file != '..') {
                if (is_dir($directory . '/' . $file)) {
                    $files[] = self::hashDirectory($directory . '/' . $file);
                } else {
                    $files[] = md5_file($directory . '/' . $file);
                }
            }
        }
        $dir->close();
        return md5(implode('', $files));
    }

    /**
     * @param string $template
     * @return bool
     */
    public static function remove_template(string $template): bool
    {
        $dir = self::secureTemplatePath($template);
        if ($template == self::getSelectedTemplate()) {
            e(lang('selected_template_cannot_be_deleted'));
            return false;
        }
        if (empty($dir)) {
            return false;
        }
        return delete_directories_recursive($dir);
    }

    /**
     * @param string $template
     * @return bool|string
     */
    private static function secureTemplatePath(string $template): bool|string
    {
        $template = str_replace('.', '', str_replace('..', '', $template));
        $dir = DirPath::get('styles') . $template;
        if (is_dir($dir) && $template != ClipBucket::DEFAULT_TEMPLATE && str_contains(realpath($dir), DirPath::get('styles'))) {
            return $dir;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public static function getSelectedTemplate(): bool|string
    {
        return config('template_dir');
    }
}
