<?php

class VideoTranslations
{
    public static function isEnabled(): bool
    {
        return (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999'));
    }

    public static function defaultLanguageId(): int
    {
        return (int)(Language::getDefaultLanguage()['language_id'] ?? Language::$english_id);
    }

    public static function displayJoin(string $video = 'video'): string
    {
        if (!self::isEnabled()) {
            return '';
        }

        $language_id = defined('FRONT_END') && FRONT_END ? (int)Language::getInstance()->lang_id : self::defaultLanguageId();
        return ' LEFT JOIN (SELECT videoid AS translated_videoid, language_id, video_title, video_description
            FROM ' . tbl('videos_translations') . ') AS video_translation
            ON video_translation.translated_videoid = ' . $video . '.videoid
            AND video_translation.language_id = (
                SELECT translation.language_id FROM ' . cb_sql_table('videos_translations', 'translation') . '
                WHERE translation.videoid = ' . $video . '.videoid
                    AND translation.video_title REGEXP \'[^[:space:]]\'
                ORDER BY (translation.language_id = ' . $language_id . ') DESC,
                    (IFNULL(translation.video_description, \'\') REGEXP \'[^[:space:]]\') DESC,
                    (translation.language_id = ' . (int)Language::$english_id . ') DESC,
                    translation.language_id ASC
                LIMIT 1
            ) ';
    }

    public static function displayTitle(string $video = 'video'): string
    {
        return self::isEnabled() ? 'COALESCE(video_translation.video_title, \'untitled\')' : $video . '.title';
    }

    public static function displayFields(string $video = 'video'): array
    {
        if (!self::isEnabled()) {
            return [$video . '.title', $video . '.description'];
        }

        return [self::displayTitle($video) . ' AS title', 'IF(video_translation.language_id IS NULL, \'\', video_translation.video_description) AS description'];
    }

    public static function titleOrder($order)
    {
        if (!self::isEnabled() || !$order || !preg_match('/^(?:video\.)?title\s+(ASC|DESC)$/i', trim($order), $matches)) {
            return $order;
        }

        return self::displayTitle() . ' ' . strtoupper($matches[1]) . ', video.videoid ASC';
    }

    public static function searchTitle(string $query, bool $fulltext = true, string $video = 'video'): string
    {
        $query = mysql_clean($query);
        $column = self::isEnabled() ? 'translation.video_title' : $video . '.title';
        $like = 'LOWER(' . $column . ') LIKE \'%' . $query . '%\'';
        $match = 'MATCH(' . $column . ') AGAINST (\'' . $query . '\' IN NATURAL LANGUAGE MODE)';
        $condition = $fulltext ? '(' . $like . ' OR ' . $match . ')' : $like;
        return self::isEnabled() ? self::exists($condition, $video) : $condition;
    }

    public static function exists(string $condition, string $video = 'video'): string
    {
        return 'EXISTS (SELECT 1 FROM ' . cb_sql_table('videos_translations', 'translation') . ' WHERE translation.videoid = ' . $video . '.videoid AND (' . $condition . '))';
    }

    public static function searchScore(string $expression): string
    {
        return '(SELECT MAX(' . $expression . ') FROM ' . cb_sql_table('videos_translations', 'translation') . ' WHERE translation.videoid = video.videoid)';
    }

    public static function getAll(int $video_id): array
    {
        return $video_id ? (self::getForVideos([$video_id])[$video_id] ?? []) : [];
    }

    public static function getForVideos(array $video_ids): array
    {
        if (!$video_ids || !self::isEnabled()) {
            return [];
        }

        $rows = Clipbucket_db::getInstance()->select(tbl('videos_translations'),
            'videoid, language_id, video_title AS title, video_description AS description',
            'videoid IN (' . implode(', ', array_map('intval', $video_ids)) . ')');
        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['videoid']][$row['language_id']] = $row;
        }
        return $translations;
    }

    private static function formLanguages(): array
    {
        $languages = array_column(Language::getInstance()->get_langs(true), null, 'language_id');
        $default = Language::getDefaultLanguage();
        if ($default) {
            $languages[$default['language_id']] = $default;
        }
        return $languages;
    }

    public static function getFormLanguages(array $video = [], ?array $submitted = null): array
    {
        if (!self::isEnabled()) {
            return [];
        }

        $languages = self::formLanguages();
        if ($submitted !== null) {
            $translations = is_array($submitted['video_translations'] ?? null) ? $submitted['video_translations'] : [];
        } elseif (empty($video['videoid'])) {
            $translations = [self::defaultLanguageId() => $video];
        } else {
            $translations = self::getAll((int)$video['videoid']);
        }

        $selected = (int)($submitted['selected_video_language'] ?? 0);
        if (!isset($languages[$selected])) {
            $selected = 0;
        }
        foreach ($languages as $id => &$language) {
            foreach (['title', 'description'] as $field) {
                $value = $translations[$id][$field] ?? '';
                $language[$field] = is_string($value) ? $value : '';
            }
            $language['is_specified'] = (int)(trim($language['title']) !== '') + (int)(trim($language['description']) !== '');
            $language['is_shown'] = false;
            if (!$selected && $language['is_specified']) {
                $selected = $id;
            }
        }
        unset($language);
        $selected = $selected ?: array_key_first($languages);
        if ($selected) {
            $languages[$selected]['is_shown'] = true;
        }
        return $languages;
    }

    public static function validateForm(array $input, array $fields): void
    {
        $languages = self::formLanguages();
        $translations = $input['video_translations'];
        $default_id = self::defaultLanguageId();
        if (!is_array($translations)) {
            e(lang('missing_params'));
            return;
        }
        $translations += [$default_id => []];
        foreach ($translations as $id => $translation) {
            if (!isset($languages[$id]) || !is_array($translation)) {
                e(lang('language_does_not_exist'));
                continue;
            }
            $has_title = is_string($translation['title'] ?? null) && trim($translation['title']) !== '';
            $has_description = is_string($translation['description'] ?? null) && trim($translation['description']) !== '';
            foreach (['title' => $fields['title'], 'description' => $fields['desc']] as $name => $field) {
                $value = $translation[$name] ?? null;
                $label = $languages[$id]['language_name'] . ' — ' . $field['title'];
                if (!is_string($value) || (($id === $default_id || $has_title || $has_description) && trim($value) === '')) {
                    e(lang('all_fields_req') . ' — ' . display_clean($label));
                    continue;
                }
                if (trim($value) === '') {
                    continue;
                }
                $min = (int)($field['min_length'] ?? config('min_video_desc'));
                $max = (int)($field['max_length'] ?? config('max_video_desc'));
                $length = mb_strlen(str_replace("\r\n", "\n", $value));
                if ($length < $min || $length > $max) {
                    e(lang('please_enter_val_bw_min_max', [display_clean($label), $min, $max]));
                }
            }
        }
    }

    public static function values(array $input): array
    {
        if (isset($input['video_translations'])) {
            return $input['video_translations'];
        }

        return [self::defaultLanguageId() => ['title' => $input['title'], 'description' => $input['description']]];
    }

    public static function save(int $video_id, array $translations, bool $from_form = false): void
    {
        if (!self::isEnabled()) {
            return;
        }

        $db = Clipbucket_db::getInstance();
        $table = tbl('videos_translations');
        $default_id = $from_form ? self::defaultLanguageId() : 0;
        foreach ($translations as $language_id => $translation) {
            $key = 'videoid = ' . $video_id . ' AND language_id = ' . (int)$language_id;
            if ($from_form && (int)$language_id !== $default_id && trim($translation['title']) === '' && trim($translation['description']) === '') {
                $db->executeThrowException('DELETE FROM ' . $table . ' WHERE ' . $key);
                continue;
            }

            $fields = ['videoid', 'language_id'];
            $values = [$video_id, (int)$language_id];
            $updates = [];
            foreach (['title', 'description'] as $field) {
                if (array_key_exists($field, $translation)) {
                    $column = 'video_' . $field;
                    $fields[] = $column;
                    $values[] = $translation[$field] === null ? 'NULL' : '\'' . mysql_clean($translation[$field]) . '\'';
                    $updates[] = $column . ' = VALUES(' . $column . ')';
                }
            }
            if ($updates) {
                $db->executeThrowException('INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ON DUPLICATE KEY UPDATE ' . implode(', ', $updates));
            }
        }
    }
}
