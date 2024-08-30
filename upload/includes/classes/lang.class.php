<?php

class Language
{
    public $lang = 'en';

    public $lang_id = 1;

    public static $english_id = 1;

    public $lang_iso = 'en';
    public $lang_name = 'English';

    public $arrayTranslation = [];

    private static $_instance = null;

    private $uninstalled = false;

    /**
     * __Constructor
     */
    public function __construct()
    {
    }

    /**
     * @return Language
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Language();
        }
        return self::$_instance;
    }

    public function getLangISO()
    {
        return $this->lang_iso;
    }

    /**
     * INIT
     * @throws Exception
     */
    public function init()
    {
        $lang = getArrayValue($_COOKIE, 'cb_lang');

        //Setting Language
        if (isset($_GET['set_site_lang'])) {
            $lang = $_GET['set_site_lang'];
            if ($this->getLangById($lang)) {
                set_cookie_secure('cb_lang', $lang);
            }
        }

        if (!empty($lang)) {
            $lang_details = $this->getLangById($lang);
        }

        if (isset($lang) && isset($lang_details)) {
            $default = $lang_details;
        } else {
            $default = self::getDefaultLanguage();
        }

        if ($default['language_id']) {
            $this->lang_name = $default['language_name'];
            $this->lang = $this->lang_iso = $default['language_code'];
            $this->lang_id = $default['language_id'];
        }

        $this->loadTranslations($this->lang_id);
    }

    /**
     * Function used to get language phrase
     *
     * @param STRING $language_key
     * @param STRING $language_id
     *
     * @return bool|array
     * @throws Exception
     */
    public function getTranslationByKey($language_key, $language_id)
    {
        if ($this->uninstalled) {
            return false;
        }

        $select = tbl('languages_translations') . ' AS LT
        INNER JOIN ' . tbl('languages_keys') . ' AS LK ON LK.id_language_key = LT.id_language_key';
        $results = Clipbucket_db::getInstance()->select($select, '*', ' LK.language_key = \'' . mysql_clean($language_key) . '\' AND LT.language_id = \'' . mysql_clean($language_id) . '\'');
        if (!empty($results)) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to get language phrase
     *
     * @param STRING $id_language_key
     * @param STRING $language_id
     *
     * @return bool|array
     * @throws Exception
     */
    public function getTranslationByIdKey($id_language_key, $language_id)
    {
        if ($this->uninstalled) {
            return false;
        }

        $select = tbl('languages_translations') . ' AS LT
        INNER JOIN ' . tbl('languages_keys') . ' AS LK ON LK.id_language_key = LT.id_language_key';
        $results = Clipbucket_db::getInstance()->select($select, '*', ' LK.id_language_key = \'' . mysql_clean($id_language_key) . '\' AND LT.language_id = \'' . mysql_clean($language_id) . '\'');
        if (!empty($results)) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to get all phrases of particular language
     *
     * @param null $language_id
     * @param string $fields
     * @param null $limit
     * @param null $extra_param
     *
     * @return array
     * @throws Exception
     */
    public function getAllTranslations($language_id = 1, $fields = 'language_key, translation', $limit = null, $extra_param = null): array
    {
        if ($this->uninstalled) {
            return [];
        }

        $select = tbl('languages_keys') . ' AS LK
        LEFT JOIN ' . tbl('languages_translations') . ' AS LT ON LK.id_language_key = LT.id_language_key AND LT.language_id = ' . mysql_clean($language_id);

        /** concat aaaaaaa to sort when translation is missing */
        return Clipbucket_db::getInstance()->select($select, $fields, $extra_param, $limit, ' CASE WHEN LT.translation IS NULL THEN concat(\'aaaaaaaaaaaaaaaaaaaa\',language_key) ELSE LK.language_key END', false, 3600);
    }

    /**
     * Function used to count phrases
     *
     * @param null $language_id
     * @param null $extra_param
     *
     * @return int
     * @throws Exception
     */
    public function countTranslations($language_id = null, $extra_param = null): int
    {
        if ($this->uninstalled) {
            return false;
        }

        $select = tbl('languages_keys') . ' AS LK
        LEFT JOIN ' . tbl('languages_translations') . ' AS LT ON LK.id_language_key = LT.id_language_key AND LT.language_id = ' . $language_id;

        $results = Clipbucket_db::getInstance()->select($select, 'COUNT(LK.id_language_key) as total', $extra_param);

        if (!empty($results)) {
            return $results[0]['total'];
        }
        return 0;
    }

    /**
     * Function used to modify phrase
     *
     * @param int $id_language_key
     * @param string $translation
     * @param int $language_id
     * @throws Exception
     */
    public function update_phrase($id_language_key, $translation, $language_id = 1)
    {
        //First checking if phrase already exists or not
        if ($this->getTranslationByIdKey($id_language_key, $language_id)) {
            Clipbucket_db::getInstance()->update(tbl('languages_translations'), ['translation'], [mysql_clean($translation)], ' id_language_key = ' . mysql_clean($id_language_key) . ' AND language_id = ' . mysql_clean($language_id));
        } else {
            Clipbucket_db::getInstance()->insert(tbl('languages_translations'), ['translation,id_language_key,language_id'], [mysql_clean($translation), mysql_clean($id_language_key), mysql_clean($language_id)]);
        }
        CacheRedis::flushAll();
    }


    /**
     * Function used to assign phrases as an array
     *
     * @param int $langId
     *
     * @return array
     * @throws Exception
     */
    public function loadTranslations($langId): array
    {
        $lang = [];
        try {
            $phrases = $this->getAllTranslations($langId);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'lang_not_installed') {
                $this->uninstalled = true;
                if (BACK_END) {
                    e('Translation system isn\'t installed, please connect and follow upgrade instructions.');
                } elseif (in_dev()) {
                    e('Translation system isn\'t installed, please contact your administrator.');
                }
                return [];
            }
            throw $e;
        }
        foreach ($phrases as $phrase) {
            $lang[$phrase['language_key']] = $phrase['translation'];
        }
        $this->arrayTranslation = $lang;
        return $lang;
    }

    public function isTranslationSystemInstalled(): bool
    {
        return !$this->uninstalled;
    }


    /**
     * Function used to get list of languages installed
     *
     * @param bool $active
     * @param bool $countTrads
     * @return array
     * @throws Exception
     */
    public function get_langs(bool $active = false, bool $countTrads = false): array
    {
        if ($this->uninstalled) {
            return [];
        }

        if ($active) {
            $cond = ' language_active=\'yes\' ';
        } else {
            $cond = '1 ';
        }

        $select = tbl('languages') . ' L ';
        $field = 'L.* ';
        if ($countTrads) {
            $select .= ' LEFT JOIN ' . tbl('languages_translations') . ' LT ON LT.language_id = L.language_id ';
            $field .= ' , COUNT(LT.id_language_key) AS nb_trads, (SELECT COUNT(id_language_key) FROM ' . tbl('languages_keys') . ') as nb_codes ';
            $cond .= ' GROUP BY L.language_id ';
        }

        return Clipbucket_db::getInstance()->select($select, $field, $cond);
    }

    /**
     * Function used to check
     * weather language existsor not
     * using iso_code or its lang_id
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    public static function getLangById($id)
    {
        $id = mysql_clean($id);
        $results = Clipbucket_db::getInstance()->select(tbl('languages'), '*', 'language_id = ' . mysql_clean($id), false, false, false, 3600);

        if (!empty($results)) {
            return $results[0];
        }
        return false;
    }

    /**
     * Make Language Default
     *
     * @param $lid
     * @throws Exception
     */
    public function make_default($lid)
    {
        $lang = self::getLangById($lid);
        if ($lang) {
            set_cookie_secure('cb_lang', $lid);
            Clipbucket_db::getInstance()->update(tbl('languages'), ['language_default'], ['no'], 'language_default=\'yes\'');
            Clipbucket_db::getInstance()->update(tbl('languages'), ['language_default'], ['yes'], ' language_id=\'' . $lid . '\'');
            e($lang['language_name'] . ' has been set as default language', 'm');
            CacheRedis::flushAll();
        }
    }

    /**
     * function used to get default language
     * @throws Exception
     */
    public static function getDefaultLanguage()
    {
        $result = Clipbucket_db::getInstance()->select(tbl('languages'), '*', 'language_default=\'yes\' ', false, false, false, 3600, 'default_language');
        return $result[0];
    }


    /**
     * Function used to delete language
     *
     * @param $i
     * @throws Exception
     */
    public static function delete_lang($i)
    {
        $lang = self::getLangById($i);
        if (!$lang) {
            e(lang('language_does_not_exist'));
        } elseif ($lang['language_default'] == 'yes' || $i == 1) {
            e(lang('default_lang_del_error'));
        } else {
            Clipbucket_db::getInstance()->delete(tbl('languages_translations'), ['language_id'], [$lang['language_id']]);
            Clipbucket_db::getInstance()->delete(tbl('languages'), ['language_id'], [$lang['language_id']]);
            e(lang('lang_deleted'), 'm');
            CacheRedis::flushAll();
        }
    }

    /**
     * Function used to update language
     *
     * @param $array
     * @throws Exception
     */
    public static function update_lang($array)
    {
        $lang = self::getLangById($array['language_id']);
        if (!$lang) {
            e(lang('language_does_not_exist'));
        } elseif (empty($array['name'])) {
            e(lang('lang_name_empty'));
        } elseif (empty($array['code'])) {
            e(lang('lang_code_empty'));
        } else {
            Clipbucket_db::getInstance()->update(tbl('languages'), ['language_name', 'language_code'], [$array['name'], $array['code']], ' language_id=\'' . $array['language_id'] . '\'');
            e(lang('lang_updated'), 'm');
            CacheRedis::flushAll();
        }
    }

    /**
     * Function used to update language
     *
     * @param $array
     * @throws Exception
     */
    public static function add_lang($array)
    {
        if (empty($array['name'])) {
            e(lang('lang_name_empty'));
        } elseif (empty($array['code'])) {
            e(lang('lang_code_empty'));
        } else {
            Clipbucket_db::getInstance()->insert(tbl('languages'), ['language_name', 'language_default', 'language_code'], [$array['name'], 'no', $array['code']]);
            e(lang('lang_added'), 'm');
        }
    }

    /**
     * @throws Exception
     */
    public function set_lang($ClientId, $secertId)
    {
        $cl = $ClientId;
        $sc = $secertId;
        Clipbucket_db::getInstance()->update(tbl('config'), ['value'], [$cl], ' name=\'clientid\' ');
        Clipbucket_db::getInstance()->update(tbl('config'), ['value'], [$sc], ' name=\'secretId\' ');
    }

    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Function used to update language
     *
     * @param $array
     * @throws Exception
     */
    public static function restore_lang($code)
    {
        if (empty($code)) {
            e(lang('lang_code_empty'));
        } else {
            $restorable_langs = [
                'en'    => 'ENG',
                'fr'    => 'FRA',
                'pt-BR' => 'POR',
                'de'    => 'DEU',
                'esp'   => 'ESP'
            ];

            $path = DirPath::get('sql') . 'language_' . $restorable_langs[$code] . '.sql';
            if (file_exists($path)) {
                execute_sql_file($path);
            }
            e(str_replace('%s', $restorable_langs[$code], lang('lang_restored')), 'm');
            CacheRedis::flushAll();
        }
    }

}
