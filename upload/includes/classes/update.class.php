<?php
class Update
{
    private static $update;
    private static $urlGit = 'https://raw.githubusercontent.com/MacWarrior/clipbucket-v5/master/upload/changelog';
    private static $files = [];
    private $tableName = '';
    private $fields = [];
    private $dbVersion = [];
    private $latest = [];
    private $changelog = [];
    private $state = '';
    private $version = '';
    private $versionCode = '';
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

    public function flush(){
        $this->dbVersion = [];
        $this->version = '';
        $this->revision = '';
    }

    public function getDBVersion(): array
    {
        if( empty($this->dbVersion) ){
            $select = implode(', ', $this->getAllFields());
            try{
                $result = Clipbucket_db::getInstance()->select(cb_sql_table($this->tableName), $select, false, false, false, false, 30, 'version')[0];
            }
            catch (Exception $e){
                return [
                    'version' => '-1',
                    'revision' => '-1'
                ];
            }

            $this->dbVersion = [
                'version' => $result['version'],
                'revision' => $result['revision']
            ];
        }

        return $this->dbVersion;
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

    private function getDistantFile($filename): array
    {
        if( !empty(self::$files[$filename]) ){
            return self::$files[$filename];
        }

        $file_url = self::$urlGit . '/' . $filename;

        $context = get_proxy_settings('file_get_contents', 2);
        $file_content = json_decode(file_get_contents($file_url, false, $context), true);

        if( empty($file_content) ){
            return [];
        }

        self::$files[$filename] = $file_content;
        return self::$files[$filename];
    }

    private function getCurrentCoreLatest(): array
    {
        if( empty($this->latest) ){
            $filepath_latest = DirPath::get('changelog') . 'latest.json';
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

    private function getCurrentCoreVersionCode(): string
    {
        if( empty($this->versionCode) ){
            $this->versionCode = $this->getCurrentCoreLatest()['dev'];
        }

        return $this->versionCode;
    }

    /**
     * @throws Exception
     */
    public function getCurrentCoreVersion(): string
    {
        if( empty($this->version) ){
            $this->version = $this->getChangelog($this->getCurrentCoreVersionCode())['version'];
        }

        return $this->version;
    }

    /**
     * @throws Exception
     */
    private function getChangelog($version): array
    {
        if( empty($this->changelog[$version]) ){
            if (strpos($version, '.') !== false) {
                $version = str_replace('.','', $version);
            }
            $filepath_changelog = DirPath::get('changelog') . $version . '.json';

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
        if( empty($this->revision) ){
            $this->revision = $this->getChangelog($this->getCurrentCoreVersion())['revision'];
        }
        return $this->revision;
    }

    /**
     * @throws Exception
     */
    private function getWebVersion()
    {
        if( empty($this->webVersion) ){
            $type = $this->getCurrentCoreState();
            $versions = $this->getDistantFile('latest.json');
            $versions_url = self::$urlGit . '/latest.json';
            if (empty($versions[$type])) {
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
            $changelog = $this->getDistantFile($version.'.json');
            $changelog_url = self::$urlGit . '/' . $version . '.json';

            if (empty($changelog['revision'])) {
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

        $folders = glob(DirPath::get('sql') . '[0-9]**', GLOB_ONLYDIR);
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
            $file_rev = (int) preg_replace('/\D/', '', pathinfo($file)['filename']);
            if ($file_rev > $this->getCurrentDBRevision() && $file_rev <= REV) {
                $this->needCodeDBUpdate = true;
                return true;
            }
        }
        $this->needCodeDBUpdate = false;
        return false;
    }

    /**
     * @throws Exception
     */
    public function isWIPFile(): bool
    {
        if (!in_dev()) {
            return false;
        }
        if (file_exists(DirPath::get('sql') . $this->getCurrentDBVersion() . DIRECTORY_SEPARATOR . 'MWIP.php')) {
            return true;
        }
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
            $version = str_replace('.', '', $this->getCurrentDBVersion());
        } else if (strpos($version, '.') !== false) {
            $version = str_replace('.', '', $version);
        }

        if( empty($revision) ){
            $revision = $this->getCurrentDBRevision();
        }

        //Get folders superior or equal to current version
        $folders = array_filter(glob(DirPath::get('sql') . '[0-9]**', GLOB_ONLYDIR)
            , function ($dir) use ($version) {
                return str_replace('.', '', basename($dir)) >= $version;
            });

        $files = [];
        if ($version == '4.2-RC1-premium') {
            $files[] = DirPath::get('sql') . 'commercial' . DIRECTORY_SEPARATOR . '00001.sql';
        }

        foreach ($folders as $folder) {
            //get files in folder minus . and .. folders
            $folder_files = array_diff(scandir($folder), ['..', '.']);
            $folder_version = str_replace('.', '', basename($folder));

            // Exclude older and future versions
            if( $version > $folder_version || $folder_version > $this->getCurrentCoreVersionCode() ){
                break;
            }

            foreach($folder_files AS $file){
                $file_rev = (int) preg_replace('/\D/', '', pathinfo($file)['filename']);

                // Exclude future revisions
                if( $folder_version == $this->getCurrentCoreVersionCode() && $file_rev > $this->getCurrentCoreRevision() ){
                    break;
                }

                if( // For current version, include next revisions
                    ($folder_version == $version && $file_rev > $revision)
                    ||
                    // For next versions, include all revisions
                    $folder_version > $version
                ){
                    $files[] = $folder . DIRECTORY_SEPARATOR . $file;
                }
            }
        }

        return ($count ? count($files) : $files);
    }

    /**
     * @throws Exception
     */
    private function pluginsNeedDBUpdate(): bool
    {
        return $this->getPluginUpdateFiles(true) >= 1;
    }

    /**
     * @throws Exception
     */
    public function getPluginUpdateFiles($count = false)
    {
        $plugins_installed = Plugin::getInstance()->getAll();

        $update_files = get_plugins_files_to_upgrade($plugins_installed);
        return ($count ? count($update_files) : $update_files);
    }

    /**
     * @throws Exception
     */
    public function displayGlobalSQLUpdateAlert($current_updating = false)
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

        assign('current_updating', $current_updating);
        assign('launch_wip', $this->isWIPFile());

        assign('need_core_update', false);
        assign('show_core_update', false);
        if( config('enable_update_checker') == '1' && $this->isManagedWithGit()) {
            assign('need_core_update', !$this->isCoreUpToDate());
            assign('show_core_update', true);
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
        $dbversion = Update::getInstance()->getDBVersion();

        if( $dbversion['version'] == '-1' ){
            if (BACK_END) {
                e('Version system isn\'t installed, please connect and follow upgrade instructions.');
            } elseif (in_dev()) {
                e('Version system isn\'t installed, please contact your administrator.');
            }
            return false;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function isCoreUpToDate(): bool
    {
        if( !ini_get('allow_url_fopen')
            || !$this->getWebVersion()
            || $this->getWebRevision() === false
        ){
            return true;
        }

        if( $this->getCurrentCoreVersionCode() > $this->getWebVersion()
            || ($this->getCurrentCoreVersionCode() == $this->getWebVersion() && $this->getCurrentCoreRevision() >= $this->getWebRevision())
        ){
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function getCoreUpdateStatus(): string
    {
        if( !ini_get('allow_url_fopen')
            || !$this->getWebVersion()
            || $this->getWebRevision() === false
        ){
            return 'red';
        }

        if( $this->isCoreUpToDate() ){
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

        $current_version = $this->getCurrentCoreVersionCode();
        $current_revision = $this->getCurrentCoreRevision();
        $current_state = $this->getCurrentCoreState();
        $web_version = $this->getWebVersion();
        $web_revision = $this->getWebRevision();

        $html .= '<div class="well changelog"><h5>Current version : <b>' . $current_version . '</b> - Revision <b>' . $current_revision . '</b> <i>(' . ucfirst($current_state) . ')</i><br/>';
        $html .= 'Latest version <i>(' . ucfirst($current_state) . ')</i> : <b>' . $web_version . '</b> - Revision <b>' . $web_revision . '</b></h5></div>';

        $is_new_version = $current_version > $web_version || ($current_version == $web_version && $current_revision > $web_revision);

        if ($current_version == $web_version && $current_revision == $web_revision) {
            $html .= '<h3 style="text-align:center;">Your ClipbucketV5 seems up-to-date !</h3>';
        } else {
            if ($is_new_version) {
                $html .= '<h3 style="text-align:center;">Keep working on this new version ! :)</h3>';
            } else {
                $html .= '<h3 style="text-align:center;">Update <b>' . $web_version . '</b> - Revision <b>' . $web_revision . '</b> is available !</h3>';

                if ($current_version != $web_version) {
                    $html .= $this->getChangelogHTML($this->getWebChangelog());
                } else {
                    $diff = $this->getChangelogDiff($this->getChangelog($this->getCurrentCoreVersionCode()), $this->getWebChangelog());
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

        $files = glob(DirPath::get('changelog') . '[0-9]*' . '.json');
        foreach ($files as $file) {
            $changelog = json_decode(file_get_contents($file), true);
            $versions[$changelog['version']] = $changelog['revision'];
        }
        return $versions;
    }

    public function isGitInstalled(): bool
    {
        $functions = ['exec', 'shell_exec'];
        foreach ($functions as $function) {
            if( !System::check_php_function($function, 'web', false) ){
                return false;
            }
        }

        $git_path = System::get_binaries('git');
        if( empty($git_path) || !file_exists($git_path) ){
            return false;
        }

        $output = shell_exec($git_path . ' --version 2>&1');
        return stripos($output, 'git version') !== false;
    }

    public function isManagedWithGit(): bool
    {
        if( !$this->isGitInstalled() ){
            return false;
        }

        $dir = DirPath::get('root');
        chdir($dir);
        $output = shell_exec(System::get_binaries('git') . ' rev-parse --is-inside-work-tree 2>&1');

        if( trim($output) === 'true' ){
            return true;
        }

        $test = $this->checkAndfixGitSafeDirectory($output);
        if( $test ){
            return true;
        }
        return false;
    }

    private function checkAndfixGitSafeDirectory($output): bool
    {
        if( stripos($output, '--add safe.directory') === false ){
            return true;
        }

        $git_command = substr($output, stripos($output, 'git config'));

        $pattern = '/safe\.directory (.+)$/';
        preg_match($pattern, $git_command, $matches);

        if (!isset($matches[1])) {
            return false;
        }

        $filePath = trim($matches[1], " \t\n\r\0\x0B'");

        $output = shell_exec(System::get_binaries('git') . ' config --global --add safe.directory ' . $filePath);
        if( empty($output) ){
            return true;
        }
        return false;
    }

    private function getGitRootDirectory(): string
    {
        return shell_exec(System::get_binaries('git') . ' rev-parse --show-toplevel');
    }

    private function resetGitRepository(string $root_directory): bool
    {
        chdir($root_directory);

        $output = shell_exec(System::get_binaries('git') . ' reset --hard');
        if( !$output ){
            return false;
        }

        $filepath_install_me = DirPath::get('temp') . 'install.me';
        $filepath_install_me_not = $filepath_install_me . '.not';
        if( file_exists($filepath_install_me) && !file_exists($filepath_install_me_not) ){
            unlink($filepath_install_me);
        }
        return true;
    }

    private function updateGitRepository(string $root_directory)
    {
        chdir($root_directory);

        return shell_exec(System::get_binaries('git') . ' pull');
    }

    public static function updateGitSources(): bool
    {
        $update = Update::getInstance();
        if( !$update->isGitInstalled() || !$update->isManagedWithGit() ){
            return false;
        }

        $root_directory = $update->getGitRootDirectory();
        if( !$root_directory ){
            return false;
        }

        if( !$update->resetGitRepository($root_directory) ){
            return false;
        }

        if( !$update->updateGitRepository($root_directory) ){
            return false;
        }

        return true;
    }

    /**
     * @param $version
     * @param $revision
     * @return bool
     */
    public static function IsCurrentDBVersionIsHigherOrEqualTo($version, $revision): bool
    {
        $version_db = Update::getInstance()->getDBVersion();
        return ($version_db['version'] > $version || ($version_db['version'] == $version && $version_db['revision'] >= $revision));
    }

    /**
     * @throws Exception
     */
    public static function IsUpdateProcessing(): bool
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo(AdminTool::MIN_VERSION_CODE, AdminTool::MIN_REVISION_CODE)) {
            $and = ' AND code IN (\'update_core\', \''.AdminTool::CODE_UPDATE_DATABASE_VERSION.'\')';
        } else {
            $and = ' AND id_tool IN (11, 5)';
        }
        $tools = AdminTool::getTools([
            ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM '.tbl('tools_histo_status').' WHERE language_key_title = \'in_progress\') ' . $and
        ]);
        return !empty($tools);
    }

}