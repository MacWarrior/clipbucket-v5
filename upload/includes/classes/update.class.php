<?php
class Update
{
    private static $update;
    private static $urlGit = 'https://raw.githubusercontent.com/MacWarrior/clipbucket-v5/master/upload/changelog';
    private $tableName = '';
    private $fields = [];
    private $dbVersion = [];
    private $latest = [];
    private $changelog = [];
    private $state = '';
    private $version = '';
    private $revision = '';
    private $webVersion = '';
    private $webRevision = '';
    private $webChangelog = [];
    private $needCodeDBUpdate = '';

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->tableName = 'version';
        $this->fields = [
            'id'
            ,'version'
            ,'revision'
        ];
    }

    public static function getInstance(): self
    {
        if( empty(self::$update) ){
            self::$update = new self();
        }
        return self::$update;
    }

    private function getAllFields(): array
    {
        return array_map(function($field) {
            return $this->tableName . '.' . $field;
        }, $this->fields);
    }

    /**
     * @throws Exception
     */
    public function getDBVersion(): array
    {
        if( !empty($this->dbVersion) ){
            return $this->dbVersion;
        }

        $select = implode(', ', $this->getAllFields());
        $result = Clipbucket_db::getInstance()->select(cb_sql_table($this->tableName), $select, false, false, false, false, 30, 'version')[0];

        return [
            'version' => $result['version'],
            'revision' => $result['revision']
        ];
    }

    /**
     * @throws Exception
     */
    public function getCurrentDBVersion(): string
    {
        return $this->getDBVersion()['version'];
    }

    /**
     * @throws Exception
     */
    public function getCurrentDBRevision(): string
    {
        return $this->getDBVersion()['revision'];
    }

    private function getCurrentCoreLatest(): array
    {
        if( empty($this->latest) ){
            $filepath_latest = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'changelog' . DIRECTORY_SEPARATOR.'latest.json';
            $this->latest = json_decode(file_get_contents($filepath_latest), true);
        }

        return $this->latest;
    }

    public function getCurrentCoreState(): string
    {
        if( empty($this->state) ){
            if ($this->getCurrentCoreLatest()['stable'] != $this->getCurrentCoreLatest()['dev']) {
                $this->state = 'dev';
            } else {
                $this->state = 'stable';
            }
        }

        return $this->state;
    }

    public function getCurrentCoreVersion(): string
    {
        if( empty($this->version) ){
            $this->version = $this->getCurrentCoreLatest()['dev'];
        }

        return $this->version;
    }

    /**
     * @throws Exception
     */
    private function getChangelog($version): array
    {
        if( empty($this->changelog[$version]) ){
            $base_filepath = realpath(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'changelog');
            $filepath_changelog = $base_filepath . DIRECTORY_SEPARATOR . $version . '.json';

            if (!file_exists($filepath_changelog)) {
                e(lang('error_occured'));
                e('File don\' exists :' . $filepath_changelog);
                return [];
            }

            $this->changelog[$version] = json_decode(file_get_contents($filepath_changelog), true);
        }

        return $this->changelog[$version];
    }

    /**
     * @throws Exception
     */
    public function getCurrentCoreRevision(): string
    {
        return $this->getChangelog($this->getCurrentCoreVersion())['revision'];
    }

    /**
     * @throws Exception
     */
    private function getWebVersion()
    {
        if( empty($this->webVersion) ){
            $type = $this->getCurrentCoreState();
            $versions_url = self::$urlGit . '/latest.json';
            $context = get_proxy_settings('file_get_contents');
            $versions = json_decode(file_get_contents($versions_url, false, $context), true);
            if (!isset($versions[$type])) {
                e(lang('error_occured'));
                e(lang('error_file_download') . ' : ' . $versions_url);
                return false;
            }

            $this->webVersion = $versions[$type];
        }

        return $this->webVersion;
    }

    /**
     * @throws Exception
     */
    private function getWebChangelog()
    {
        if( empty($this->webChangelog) ){
            $version = $this->getWebVersion();
            $changelog_url = self::$urlGit . '/' . $version . '.json';
            $context = get_proxy_settings('file_get_contents');
            $changelog = json_decode(file_get_contents($changelog_url, false, $context), true);
            if (!isset($changelog['revision'])) {
                e(lang('error_occured'));
                e(lang('error_file_download') . ' : ' . $changelog_url);
                return false;
            }

            $this->webChangelog = $changelog;
        }

        return $this->webChangelog;
    }

    /**
     * @throws Exception
     */
    private function getWebRevision()
    {
        if( empty($this->webRevision) ){
            $changelog = $this->getWebChangelog();
            if (!isset($changelog['revision'])) {
                return false;
            }

            $this->webRevision = $changelog['revision'];
        }

        return $this->webRevision;
    }

    /**
     * @throws Exception
     */
    public function needCodeDBUpdate(): bool
    {
        if( !empty($this->needCodeDBUpdate) ){
            return $this->needCodeDBUpdate;
        }

        if( $this->getCurrentDBVersion() == $this->getCurrentCoreVersion()
            && $this->getCurrentDBRevision() == $this->getCurrentCoreRevision()
        ){
            $this->needCodeDBUpdate = false;
            return false;
        }

        $folders = glob(DIR_SQL . '[0-9]**', GLOB_ONLYDIR);
        $folder_version = '';
        foreach ($folders as $folder) {
            $folder_cur_version = basename($folder);
            if ($folder_cur_version == $this->getCurrentDBVersion()) {
                $folder_version = $folder;
            } elseif ($folder_cur_version > $this->getCurrentDBVersion() && $folder_cur_version <= VERSION) {
                $this->needCodeDBUpdate = true;
                return true;
            }
        }
        $clean_folder = array_diff(scandir($folder_version), ['..', '.']);
        foreach ($clean_folder as $file) {
            $file_rev = (int)pathinfo($file)['filename'];
            if ($file_rev > $this->getCurrentDBRevision() && $file_rev <= REV) {
                $this->needCodeDBUpdate = true;
                return true;
            }
        }
        $this->needCodeDBUpdate = false;
        return false;
    }

    /**
     * @param bool $count
     * @param string $version
     * @param string $revision
     * @return array|int
     * @throws Exception
     */
    public function getUpdateFiles(bool $count = false, string $version = '', string $revision = '')
    {
        if( empty($version) ){
            $version = $this->getCurrentCoreVersion();
        }

        if( empty($revision) ){
            $revision = $this->getCurrentCoreRevision();
        }

        //Get folders superior or equal to current version
        $folders = array_filter(glob(DIR_SQL . '[0-9]**', GLOB_ONLYDIR)
            , function ($dir) use ($version) {
                return basename($dir) >= $version;
            });

        $files = [];

        if ($version == '4.2-RC1-premium') {
            $files[] = DIR_SQL . 'commercial' . DIRECTORY_SEPARATOR . '00001.sql';
        }
        foreach ($folders as $folder) {
            //get files in folder minus . and .. folders
            $clean_folder = array_diff(scandir($folder), ['..', '.']);
            $files = array_merge(
                $files,
                //clean null files
                array_filter(
                //return absolute path
                    array_map(function ($file) use ($revision, $version, $folder) {
                        $file_rev = (int)pathinfo($file)['filename'];
                        $folder_version = basename($folder);
                        return
                            //if current version, then only superior revisions but still under current revision in changelog
                            (
                                ($file_rev > $revision && $folder_version == $version
                                    // or all files from superior version but still under current version in changelog
                                    || $folder_version > $version
                                )
                                && //check if version and revision or not superior to changelog
                                ($folder_version == VERSION && $file_rev <= REV
                                    || $folder_version < VERSION
                                )
                            )
                                ?
                                $folder . DIRECTORY_SEPARATOR . $file
                                : null;
                    }, $clean_folder)
                )
            );
        }
        return ($count ? count($files) : $files);
    }

    /**
     * @throws Exception
     */
    private function pluginsNeedDBUpdate(): bool
    {
        $plugins_installed = Plugin::getInstance()->getAll();
        foreach ($plugins_installed as $plugin) {
            $plugin_details = CBPlugin::getInstance()->get_plugin_details($plugin['plugin_file'], $plugin['plugin_folder']);
            if( !$plugin_details ){
                continue;
            }

            if( $plugin_details['version'] > $plugin['plugin_version'] ){
                return true;
            }
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function getPluginUpdateFiles($count = false)
    {
        $plugins_installed = Plugin::getInstance()->getAll();

        $update_files = [];
        foreach ($plugins_installed as $installed_plugin) {
            $db_version = $installed_plugin['plugin_version'];
            $detail_verision = CBPlugin::getInstance()->get_plugin_details($installed_plugin['plugin_file'], $installed_plugin['plugin_folder'])['version'];
            //get files in update folder
            $folder = PLUG_DIR . DIRECTORY_SEPARATOR . $installed_plugin['plugin_folder'] . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR;
            $files = glob($folder . '*.sql');
            //filter files which are between db version and detail version
            $update_files = array_merge(
                $update_files,
                array_filter(
                    array_map(function ($file) use ($db_version, $detail_verision, $folder) {
                        $file_version = pathinfo($file)['filename'];
                        return ($file_version > $db_version && $file_version <= $detail_verision)
                            ? $file
                            : null;
                    }, $files)
                )
            );
        }
        return ($count ? count($update_files) : $update_files);
    }

    /**
     * @throws Exception
     */
    public function displayGlobalSQLUpdateAlert()
    {
        $nb_db_update = 0;
        if( $this->needCodeDBUpdate() ){
            $nb_db_update += $this->getUpdateFiles(true);
        }

        if( $this->pluginsNeedDBUpdate() ){
            $nb_db_update += $this->getPluginUpdateFiles(true);
        }

        assign('need_db_update', ($nb_db_update > 0));
        if ($nb_db_update > 0) {
            assign('nb_db_update', str_replace('%s', $nb_db_update, lang('need_db_upgrade')));
        }
        Template('msg_update_db.html');
    }

    /**
     * @throws Exception
     */
    public function displayPluginSQLUpdateAlert()
    {
        if( !$this->pluginsNeedDBUpdate() ){
            return;
        }

        $nb_db_update = $this->getPluginUpdateFiles(true);
        assign('nb_db_update', str_replace('%s', $nb_db_update, lang('need_db_upgrade')));
        assign('need_db_update', true);
        assign('is_plugin_db', true);
        Template('msg_update_db.html');
    }

    /**
     * @throws Exception
     */
    public static function isVersionSystemInstalled(): bool
    {
        try {
            $params = [];
            $params['first_only'] = true;
            Plugin::getInstance()->getAll($params);
        } catch (Exception $e) {
            if ($e->getMessage() == 'version_not_installed') {
                if (BACK_END) {
                    e('Version system isn\'t installed, please connect and follow upgrade instructions.');
                } elseif (in_dev()) {
                    e('Version system isn\'t installed, please contact your administrator.');
                }
                return false;
            }
            throw $e;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function getCoreUpdateStatus(): string
    {
        if( !ini_get('allow_url_fopen')
            || !$this->getWebVersion()
            || !$this->getWebRevision()
        ){
            return 'red';
        }

        if( $this->getCurrentCoreVersion() >= $this->getWebVersion()
            && $this->getCurrentCoreRevision() >= $this->getWebRevision()
        ){
            return 'green';
        }

        return 'orange';
    }

    /**
     * @throws Exception
     */
    public function getChangelogHTML($version, $title = null): string
    {
        if( !is_array($version) ){
            $content_json = $this->getChangelog($version);
        } else {
            $content_json = $version;
        }

        $html = '<div class="well changelog">';
        if (is_null($title)) {
            $html .= '<h3>' . $content_json['version'] . ' Changelog - ' . ucfirst($content_json['status']) . '</h3>';
        } else {
            $html .= '<h3>' . $title . '</h3>';
        }
        foreach ($content_json['detail'] as $detail) {
            $html .= '<b>' . $detail['title'] . '</b>';
            if (!isset($detail['description'])) {
                continue;
            }
            $html .= '<ul>';
            foreach ($detail['description'] as $description) {
                $html .= '<li>' . $description . '</li>';
            }
            $html .= '</ul>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * @throws Exception
     */
    function getUpdateHTML(): string
    {
        $html = '';
        if (!ini_get('allow_url_fopen')) {
            $html .= '<div class="well changelog"><h5>' . lang('dashboard_php_config_allow_url_fopen') . '</h5></div>';
        }

        $current_version = $this->getCurrentCoreVersion();
        $current_revision = $this->getCurrentCoreRevision();
        $current_state = $this->getCurrentCoreState();
        $web_version = $this->getWebVersion();
        $web_revision = $this->getWebRevision();

        $html .= '<div class="well changelog"><h5>Current version : <b>' . $current_version . '</b> - Revision <b>' . $current_revision . '</b> <i>(' . ucfirst($current_state) . ')</i><br/>';
        $html .= 'Latest version <i>(' . ucfirst($current_state) . ')</i> : <b>' . $web_version . '</b> - Revision <b>' . $web_revision . '</b></h5></div>';

        $is_new_version = $current_version > $web_version;
        $is_new_revision = $is_new_version || $current_revision > $web_revision;

        if ($current_version == $web_version && $current_revision == $web_revision) {
            $html .= '<h3 style="text-align:center;">Your ClipbucketV5 seems up-to-date !</h3>';
        } else {
            if ($is_new_version || $is_new_revision) {
                $html .= '<h3 style="text-align:center;">Keep working on this new version ! :)</h3>';
            } else {
                $html .= '<h3 style="text-align:center;">Update <b>' . $web_version . '</b> - Revision <b>' . $web_revision . '</b> is available !</h3>';

                if ($current_version != $web_version) {
                    $html .= $this->getChangelogHTML($this->getWebChangelog());
                } else {
                    $diff = $this->getChangelogDiff($this->getChangelog($this->getCurrentCoreVersion()), $this->getWebChangelog());
                    if( !$diff ){
                        $html .= 'The new revision has the same changelog';
                    } else {
                        $html .= $this->getChangelogHTML($diff);
                    }
                }
            }
        }

        if ($current_state == 'dev') {
            $html .= '<div class="well changelog"><h5>Thank you for using the developpement version of ClipbucketV5 !<br/>Please create an <a href="https://github.com/MacWarrior/clipbucket-v5/issues" target="_blank">issue</a> if you encounter any bug.</h5></div>';
        }

        return $html;
    }

    function getChangelogDiff($first, $second)
    {
        $detail_first = $first['detail'];
        $detail_second = $second['detail'];
        $diff = [
            'version'    => $first['version']
            , 'revision' => $first['revision']
            , 'status'   => $first['status']
            , 'detail'   => []
        ];

        foreach ($detail_second as $categ) {
            $categ_exists = false;
            foreach ($detail_first as $categ_first) {
                if ($categ['title'] != $categ_first['title']) {
                    continue;
                }

                foreach ($categ['description'] as $element) {
                    $element_exists = false;
                    foreach ($categ_first['description'] as $element_current) {
                        if ($element == $element_current) {
                            $element_exists = true;
                            break;
                        }
                    }

                    if (!$element_exists) {
                        $element_diff_exists = false;
                        foreach ($diff['detail'] as &$element_diff) {
                            if ($element_diff['title'] == $categ_first['title']) {
                                $element_diff['description'][] = $element;
                                $element_diff_exists = true;
                                break;
                            }
                        }

                        if (!$element_diff_exists) {
                            $diff['detail'][] = [
                                'title'         => $categ_first['title']
                                , 'description' => [$element]
                            ];
                        }
                    }

                }

                $categ_exists = true;
            }

            if (!$categ_exists) {
                $diff['detail'][] = $categ;
            }
        }

        if( empty($diff['detail']) ){
            return false;
        }

        return $diff;
    }

    public function getUpdateVersions(): array
    {
        $versions = [
            '4.2-RC1-free'    => '1',
            '4.2-RC1-premium' => '1',
            '5.0.0'           => '1',
            '5.1.0'           => '1',
            '5.2.0'           => '1',
        ];

        $files = glob(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'changelog' . DIRECTORY_SEPARATOR . '[0-9]*' . '.json');
        foreach ($files as $file) {
            $changelog = json_decode(file_get_contents($file), true);
            $versions[$changelog['version']] = $changelog['revision'];
        }
        return $versions;
    }

}