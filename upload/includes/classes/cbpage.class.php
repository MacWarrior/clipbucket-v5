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
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return false;
        }
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
            $fields = ['page_name', 'userid', 'date_added', 'active', 'page_order'];
            $values = [$name, User::getInstance()->getCurrentUserID(), now(), 'yes', $this->getMaxPageOrder()];
            $insert_id = Clipbucket_db::getInstance()->insert(tbl($this->page_tbl), $fields, $values);
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
                foreach ($content as $lang_id => $content_trad) {
                    $this->insertOrUpdatePageTranslation($insert_id, $lang_id, $title[$lang_id], $content_trad);
                }
            }
            return true;
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
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $result = Clipbucket_db::getInstance()->select(tbl($this->page_tbl), '*', ' page_id = ' . (int)$id);
        } else {
            $result = Clipbucket_db::getInstance()->select(
                cb_sql_table($this->page_tbl) . ' LEFT JOIN ' . cb_sql_table('pages_translations') . ' 
                     ON ' . $this->page_tbl . '.page_id = pages_translations.page_id AND pages_translations.language_id = ' . Language::getInstance()->lang_id
                , $this->page_tbl . '.*, CASE WHEN pages_translations.page_content != \'\' THEN pages_translations.page_content ELSE (SELECT page_content FROM '.tbl('pages_translations').' WHERE page_id = '.(int)$id.' AND page_content != \'\' limit 1) END as page_content
            , CASE WHEN pages_translations.page_title != \'\' THEN pages_translations.page_title ELSE (SELECT page_title FROM '.tbl('pages_translations').' WHERE page_id = '.(int)$id.' AND page_title != \'\' limit 1) END as page_title, pages_translations.language_id'
                , ' '.$this->page_tbl.'.page_id =' . (int)$id
            );
        }
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * @param $id
     * @param $lang_id
     * @return false|mixed
     * @throws Exception
     */
    function getPageTranslation($id, $lang_id = null, $get_other_language_if_empty = false): mixed
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return ['page_content' => ' ', 'page_title' => ''];
        }
        if (empty($lang_id)) {
            $lang_id = Language::getInstance()->lang_id;
        }
        $page_content = 'page_content';
        $page_title = 'page_title';
        if ($get_other_language_if_empty) {
            $page_content =' CASE WHEN pages_translations.page_content != \'\' THEN pages_translations.page_content ELSE (SELECT page_content FROM '.tbl('pages_translations').' WHERE page_id = '.(int)$id.' AND page_content != \'\' limit 1) END as page_content';
            $page_title = 'CASE WHEN pages_translations.page_title != \'\' THEN pages_translations.page_title ELSE (SELECT page_title FROM '.tbl('pages_translations').' WHERE page_id = '.(int)$id.' AND page_title != \'\' limit 1) END as page_title, pages_translations.language_id';
        }
        return Clipbucket_db::getInstance()->select(cb_sql_table('pages_translations')
            , $page_content . ', ' . $page_title
            , 'page_id = ' . (int)$id . ' AND language_id = ' . (int)$lang_id)[0] ?? false;
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
        $join = '';
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
        $select = $this->page_tbl. '.*';
        if (isset($params['translated_code'])) {
            $join = ' LEFT JOIN ' . cb_sql_table('pages_translations') . ' ON ' . $this->page_tbl . '.page_id = pages_translations.page_id AND pages_translations.language_id = ' . Language::getInstance()->lang_id;
            $select .= ', IFNULL(pages_translations.page_title, ' . $this->page_tbl . '.page_name) as display_name ';
        }

        $result = Clipbucket_db::getInstance()->select(cb_sql_table($this->page_tbl) . $join, $select, empty($conds) ? '1' : implode(' AND ', $conds), $limit, $order);
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
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return false;
        }
        $id = $param['page_id'];
        $name = strtolower($param['page_name']);
        $title = $param['page_title'];
        $content = $param['page_content'];

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
            $fields = ['page_name'];
            $values = [$name];
            if (!empty($content)) {
                foreach ($content as $lang_id => $content_trad) {
                    $this->insertOrUpdatePageTranslation($id, $lang_id, $title[$lang_id], $content_trad);
                }
            }
            Clipbucket_db::getInstance()->update(tbl($this->page_tbl), $fields,
                $values, ' page_id = ' . (int)$id);
            e(lang('page_updated'), 'm');
            return true;
        } else {
            return false;
        }
    }

    function insertOrUpdatePageTranslation($page_id, $lang_id, $page_title, $page_content)
    {
        $sql = 'INSERT INTO ' . tbl('pages_translations') . ' (page_id, language_id, page_title ,page_content) VALUES ( ' . (int)$page_id . ', ' .(int)$lang_id . ', \''.mysql_clean(trim($page_title)).'\', \''.mysql_clean(trim($page_content)).'\')
        ON DUPLICATE KEY UPDATE page_content = VALUES(page_content), page_title = VALUES(page_title)';
       return \Clipbucket_db::getInstance()->execute($sql);
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
            Clipbucket_db::getInstance()->delete(tbl('pages_translations'), ['page_id'], [mysql_clean($id)]);
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
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['active'], ['yes'], ' page_id = ' . (int)$id);
                e(lang('page_activated'), 'm');
                break;

            case 'deactivate';
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['active'], ['no'], ' page_id = ' . (int)$id);
                e(lang('page_deactivated'), 'm');
                break;

            case 'delete';
                if ($page['delete_able'] == 'yes') {
                    cbpage::getInstance()->delete_page($id);
                    e(lang('page_deleted'), 'm');
                } else {
                    e(lang('you_cant_delete_this_page'), 'w');
                }
                break;

            case 'display':
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['display'], ['yes'], ' page_id = ' . (int)$id);
                e(lang('page_display_changed'), 'm');
                break;

            case 'hide':
                Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['display'], ['no'], ' page_id = ' . (int)$id);
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
        $result = Clipbucket_db::getInstance()->count(tbl($this->page_tbl), 'page_id', 'page_id = ' . (int)$id . ' AND active=\'yes\'');
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
            Clipbucket_db::getInstance()->update(tbl($this->page_tbl), ['page_order'], [$_POST['page_ord_' . $page['page_id']]], ' page_id = ' . (int)$page['page_id']);
        }
    }
}
