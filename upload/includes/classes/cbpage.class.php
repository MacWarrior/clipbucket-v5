<?php
class cbpage
{
    private static self $instance;
    public static function getInstance(): self
    {
        if( empty(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    var $page_tbl = '';

    /**
     * _CONTRUCTOR
     */
    function __construct()
    {
        $this->page_tbl = 'pages';
    }

    /**
     * Function used to create new page
     *
     * @param $param array
     *
     * @return bool
     * @throws Exception
     */
    function create_page(array $param): bool
    {
        $name = strtolower($param['page_name']);
        $title = $param['page_title'];
        $content = $param['page_content'];

        if (empty($name)) {
            e(lang('page_name_empty'));
        }
        if (substr_count($name, ' ') > 0) {
            e(lang('page_name_cant_have_space'));
        }
        if (empty($title)) {
            e(lang('page_title_empty'));
        }
        if (empty($content)) {
            e(lang('page_content_empty'));
        }

        if (!error()) {

            $translation_name = 'page_name_' . $name;
            if(empty(Language::getInstance()->arrayTranslation[$translation_name]) && empty(Language::getInstance()->getTranslationByKey($translation_name, Language::$english_id)['translation'])) {
                Migration::generateTranslation($translation_name, [
                    Language::getInstance()->lang => $title
                ]);
                if (CacheRedis::getInstance()->isEnabled()) {
                    CacheRedis::flushKeyStart(Language::getRedisKey());
                }
                Clipbucket_db::getInstance()->insert(tbl($this->page_tbl), ['page_name', 'page_title', 'page_content', 'userid', 'date_added', 'active', 'page_order'],
                    [$name, $title, '|no_mc|' . $content, user_id(), now(), 'yes', $this->getMaxPageOrder()]);
                return true;
            } else {
                e(lang('translation_already_exist_choose_other_name', $translation_name));
            }
        }
        return false;
    }

    /**
     * @throws Exception
     */
    private function getMaxPageOrder(): int
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->page_tbl), 'MAX(page_order)+1 AS max_page_order');
        if (count($result) > 0) {
            return (int)$result[0]['max_page_order'];
        }
        return 0;
    }

    /**
     * Function used to get details using id
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    function get_page($id)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->page_tbl), '*', ' page_id =' . (int)$id);
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * Function used to get all pages from database
     *
     * @param $params
     *
     * @return array|bool
     * @throws Exception
     */
    function get_pages($params = false)
    {
        $order = null;
        $limit = null;
        $conds = [];
        $cond = false;
        if (isset($params['order'])) {
            $order = $params['order'];
        }
        if (isset($params['limit'])) {
            $limit = $params['limit'];
        }

        if (isset($params['active'])) {
            $conds[] = ' active=\'' . $params['active'] . '\'';
        }

        if (isset($params['display_only'])) {
            $conds[] = ' display=\'yes\' ';
        }

        if ($conds) {
            foreach ($conds as $c) {
                if ($cond) {
                    $cond .= ' AND ';
                }

                $cond .= $c;
            }
        }

        $result = Clipbucket_db::getInstance()->select(tbl($this->page_tbl), '*', $cond, $limit, $order);
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to edit page
     *
     * @param $param
     * @return bool|void
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     * @throws Exception
     */
    function edit_page($param)
    {
        $id = $param['page_id'];
        $name = strtolower($param['page_name']);
        $title = $param['page_title'];
        $content = mysql_clean($param['page_content']);

        $page = $this->get_page($id);

        if (!$page) {
            e(lang('page_doesnt_exist'));
        }

        if (substr_count($name, ' ') > 0) {
            e(lang('page_name_cant_have_space'));
        }
        if (empty($name)) {
            e(lang('page_name_empty'));
        }
        if (empty($title)) {
            e(lang('page_title_empty'));
        }
        if (empty($content)) {
            e(lang('page_content_empty'));
        }

        if (!error()) {
            require_once DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

            $translation_name = 'page_name_' . $name;
            if (strtolower($page['page_name']) != $name) {
                if (empty(Language::getInstance()->arrayTranslation[$translation_name]) && empty(Language::getInstance()->getTranslationByKey($translation_name, Language::$english_id)['translation'])) {
                    Migration::deleteTranslation('page_name_' . $page['page_name']);
                    Migration::generateTranslation($translation_name, [
                        Language::getInstance()->lang => $title
                    ]);
                    if (CacheRedis::getInstance()->isEnabled()) {
                        CacheRedis::flushKeyStart(Language::getRedisKey());
                    }
                } else {
                    e(lang('translation_already_exist_choose_other_name', $translation_name));
                    return false;
                }
            }
            if (strtolower($page['page_title']) != strtolower($title)) {
                Migration::updateTranslation('page_name_' . $name, [
                    Language::getInstance()->lang => $title
                ]);
                if (CacheRedis::getInstance()->isEnabled()) {
                    CacheRedis::flushKeyStart(Language::getRedisKey());
                }
            }
            Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['page_name', 'page_title', 'page_content'],
                [$name, $title, '|no_mc|' . $content], ' page_id='.mysql_clean($id));
            e(lang('page_updated'), 'm');
            return true;
        }
    }

    /**
     * Function used to delete page
     *
     * @param $id
     * @throws Exception
     */
    function delete_page($id)
    {
        $page = $this->get_page($id);
        if (!$page) {
            e(lang('page_doesnt_exist'));
        }
        if (!error()) {
            Clipbucket_db::getInstance()->delete(tbl($this->page_tbl), ['page_id'], [mysql_clean($id)]);
            e(lang('page_deleted'), 'm');
        }
    }

    /**
     * Function used to create page link
     *
     * @param $pdetails
     *
     * @return string
     */
    function page_link($pdetails): string
    {
        $base_url = DirPath::getUrl('root');
        if (SEO == 'yes') {
            return $base_url . 'page/' . $pdetails['page_id'] . '/' . SEO(strtolower($pdetails['page_name']));
        }
        return $base_url . 'view_page.php?pid=' . $pdetails['page_id'];
    }

    /**
     * Function used to get page link fro id
     *
     * @param $id
     *
     * @return string
     * @throws Exception
     * @used-by photo_upload.html, signup.html
     */
    function get_page_link($id): string
    {
        $page = $this->get_page($id);
        return $this->page_link($page);
    }

    /**
     * Function used to activate, deactivate or to delete pages
     *
     * @param $type
     * @param $id
     * @throws Exception
     */
    function page_actions($type, $id): void
    {
        $page = $this->get_page($id);
        if (!$page) {
            e(lang('page_doent_exist'));
            return;
        }

        switch ($type) {
            case 'activate';
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['active'], ['yes'], ' page_id='.mysql_clean($id));
                e(lang('page_activated'), 'm');
                break;

            case 'deactivate';
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['active'], ['no'], ' page_id='.mysql_clean($id));
                e(lang('page_deactivated'), 'm');
                break;

            case 'delete';
                if ($page['delete_able'] == 'yes') {
                    Clipbucket_db::getInstance()->delete(tbl($this->page_tbl), ['page_id'], [mysql_clean($id)]);
                    e(lang('page_deleted'), 'm');
                } else {
                    e(lang('you_cant_delete_this_page'), 'w');
                }
                break;

            case 'display':
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['display'], ['yes'], ' page_id='.mysql_clean($id));
                e(lang('page_display_changed'), 'm');
                break;

            case 'hide':
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['display'], ['no'], ' page_id='.mysql_clean($id));
                e(lang('page_display_changed'), 'm');
                break;
        }
    }

    /**
     * function used to check weather page is active or not
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    function is_active($id): bool
    {
        $result = Clipbucket_db::getInstance()->count(tbl($this->page_tbl), 'page_id', 'page_id=' . mysql_clean($id) . ' AND active=\'yes\'');
        if ($result > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to update order
     * @throws Exception
     */
    function update_order()
    {
        $pages = $this->get_pages();
        foreach ($pages as $page) {
            Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['page_order'], [$_POST['page_ord_' . $page['page_id']]], ' page_id=' . mysql_clean($page['page_id']));
        }
    }
}
