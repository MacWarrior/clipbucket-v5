<?php

namespace Xhgui\Profiler\Saver;

use Xhgui_Saver_Mongo;

/**
 * @property Xhgui_Saver_Mongo $saver
 */
final class MongoSaver extends AbstractSaver
{
    public function isSupported()
    {
        if (!$this->saver instanceof Xhgui_Saver_Mongo) {
            return false;
        }

        return class_exists('MongoClient');
    }

    public function save(array $data)
    {
        if (isset($data['profile'])) {
            $data['profile'] = $this->encodeProfile($data['profile']);
        }

        $result = parent::save($data);

        return !empty($result);
    }

    /**
     * MongoDB can't save keys with values containing a dot:
     *
     *   InvalidArgumentException: invalid document for insert: keys cannot contain ".":
     *   "Zend_Controller_Dispatcher_Standard::loadClass==>load::controllers/ArticleController.php"
     *
     * Replace the dots with underscrore in keys.
     *
     * @see https://github.com/perftools/xhgui/issues/209
     */
    private function encodeProfile(array $profile)
    {
        $results = array();
        foreach ($profile as $k => $v) {
            if (strpos($k, '.') !== false) {
                $k = str_replace('.', '_', $k);
            }
            $results[$k] = $v;
        }

        return $results;
    }
}
