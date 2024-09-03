<?php
class CBreindex
{
    var $indexing = false; // Tells whether indexing is completed or not
    var $vtbl = 'video';
    var $utbl = 'users';
    
    /**
     * Function is used to calculate
     * the percentage of total figure
     */
    function percent($percent, $total): string
    {
        return number_format($percent * $total / 100);
    }

    /**
     * Function used to count
     * indexes
     * @throws Exception
     */
    function count_index($type, $params): array
    {
        $arr = [];

        switch ($type) {
            case 'user':
            case 'u':
                if ($params['video_count']) {
                    $video_count = Clipbucket_db::getInstance()->count(tbl($this->vtbl),
                        tbl($this->vtbl) . '.videoid',
                        tbl($this->vtbl) . '.userid = ' . $params['user'] . ' AND ' . tbl($this->vtbl) . '.active = \'yes\' AND ' . tbl($this->vtbl) . '.status = \'Successful\'');
                    $arr[] = $video_count;
                }

                if ($params['comment_added']) {
                    $comment_params = [];
                    $comment_params['count'] = true;
                    $comment_params['userid'] = $params['user'];
                    $arr[] = Comments::getAll($comment_params);
                }

                // Counting user subscribers
                if ($params['subscribers_count']) {
                    $subtbl = tbl('subscriptions');
                    $subscribers_count = Clipbucket_db::getInstance()->count($subtbl,
                        $subtbl . '.subscription_id',
                        $subtbl . '.subscribed_to = ' . $params['user']);
                    $arr[] = $subscribers_count;
                }

                // Counting user subscriptions
                if ($params['subscriptions_count']) {
                    $subtbl = tbl('subscriptions');
                    $subscriptions_count = Clipbucket_db::getInstance()->count($subtbl,
                        $subtbl . '.subscription_id',
                        $subtbl . '.userid = ' . $params['user']);
                    $arr[] = $subscriptions_count;
                }

                if ($params['collections_count']) {
                    global $cbcollection;
                    $details = ['user' => $params['user'], 'active' => 'yes', 'count_only' => true];
                    $collection_count = $cbcollection->get_collections($details);
                    $arr[] = $collection_count;
                }

                if ($params['photos_count']) {
                    global $cbphoto;
                    $details = ['user' => $params['user'], 'active' => 'yes', 'count_only' => true];
                    $photos_count = $cbphoto->get_photos($details);
                    $arr[] = $photos_count;
                }

                return $arr;

            default:
            case 'videos':
            case 'vid':
            case 'v':
                if ($params['video_comments']) {
                    $comment_params = [];
                    $comment_params['count'] = true;
                    $comment_params['type'] = 'v';
                    $comment_params['type_id'] = $params['video_id'];
                    $arr[] = Comments::getAll($comment_params);
                }

                if ($params['favs_count']) {
                    $ftbl = tbl('favorites');
                    $favs_count = Clipbucket_db::getInstance()->count($ftbl,
                        $ftbl . '.favorite_id',
                        $ftbl . '.id = ' . $params['video_id'] . ' AND ' . $ftbl . '.type = \'v\'');
                    $arr[] = $favs_count;
                }

                if ($params['playlist_count']) {
                    $ptbl = tbl('playlist_items');
                    $playlist_count = Clipbucket_db::getInstance()->count($ptbl,
                        $ptbl . '.playlist_item_id',
                        $ptbl . '.object_id = ' . $params['video_id'] . ' AND ' . $ptbl . '.playlist_item_type = \'v\'');
                    $arr[] = $playlist_count;
                }

                return $arr;

            case 'photos':
            case 'p':
            case 'photo':
                if ($params['favorite_count']) {
                    $fav_count = Clipbucket_db::getInstance()->count(tbl('favorites'), 'favorite_id', tbl('favorites.id') . ' = ' . $params['photo_id'] . ' AND ' . tbl('favorites.type') . ' = \'p\' ');
                    $arr[] = $fav_count;
                }

                if ($params['total_comments']) {
                    $comment_params = [];
                    $comment_params['count'] = true;
                    $comment_params['type'] = 'p';
                    $comment_params['type_id'] = $params['photo_id'];
                    $arr[] = Comments::getAll($comment_params);
                }

                return $arr;

            case 'collections':
            case 'collection':
            case 'cl':
                if ($params['favorite_count']) {
                    $fav_count = Clipbucket_db::getInstance()->count(tbl('favorites'), 'favorite_id', tbl('favorites.id') . ' = ' . $params['collection_id'] . ' AND ' . tbl('favorites.type') . ' = \'cl\' ');
                    $arr[] = $fav_count;
                }

                if ($params['total_comments']) {
                    $comment_params = [];
                    $comment_params['count'] = true;
                    $comment_params['type'] = 'cl';
                    $comment_params['type_id'] = $params['collection_id'];
                    $arr[] = Comments::getAll($comment_params);
                }

                if ($params['total_items']) {
                    $item_count = Clipbucket_db::getInstance()->count(tbl('collection_items'), 'ci_id', tbl('collection_items.collection_id') . ' = ' . $params['collection_id']);
                    $arr[] = $item_count;
                }

                return $arr;
        }
    }

    /**
     * Function used to update
     * indexes
     * @throws Exception
     */
    function update_index($type, $params = null)
    {
        switch ($type) {
            case 'user':
            case 'u':
                Clipbucket_db::getInstance()->update(tbl($this->utbl), $params['fields'], $params['values'], tbl($this->utbl) . '.userid = ' . $params['user']);
                break;

            case 'videos':
            case 'vid':
            case 'v':
                Clipbucket_db::getInstance()->update(tbl($this->vtbl), $params['fields'], $params['values'], tbl($this->vtbl) . '.videoid = ' . $params['video_id']);
                break;

            case 'photos':
            case 'photo':
            case 'p':
            case 'foto':
            case 'piture':
                Clipbucket_db::getInstance()->update(tbl('photos'), $params['fields'], $params['values'], tbl('photos.photo_id') . ' = ' . $params['photo_id']);
                break;

            case 'collection':
            case 'cl':
                Clipbucket_db::getInstance()->update(tbl('collections'), $params['fields'], $params['values'], tbl('collections.collection_id') . ' = ' . $params['collection_id']);
                break;
        }
    }

    /**
     * Function used to extract
     * fields
     */
    function extract_fields($type, $arr)
    {
        $fields = [];

        switch ($type) {
            case 'user':
            case 'u':
                if (is_array($arr)) {
                    if (array_key_exists('video_count', $arr)) {
                        $fields[] = 'total_videos';
                    }

                    if (array_key_exists('comment_added', $arr)) {
                        $fields[] = 'total_comments';
                    }

                    if (array_key_exists('subscribers_count', $arr)) {
                        $fields[] = 'subscribers';
                    }

                    if (array_key_exists('subscriptions_count', $arr)) {
                        $fields[] = 'total_subscriptions';
                    }

                    if (array_key_exists('collections_count', $arr)) {
                        $fields[] = 'total_collections';
                    }

                    if (array_key_exists('photos_count', $arr)) {
                        $fields[] = 'total_photos';
                    }
                    $result = $fields;
                } else {
                    $result = $arr;
                }

                return $result;

            case 'videos':
            case 'vid':
            case 'v':
                if (is_array($arr)) {
                    if (array_key_exists('video_comments', $arr)) {
                        $fields[] = 'comments_count';
                    }

                    if (array_key_exists('favs_count', $arr)) {
                        $fields[] = 'favourite_count';
                    }

                    if (array_key_exists('playlist_count', $arr)) {
                        $fields[] = 'playlist_count';
                    }

                    $result = $fields;
                } else {
                    $result = $arr;
                }

                return $result;

            case 'photos':
            case 'photo':
            case 'p':
            case 'piture':
                if (is_array($arr)) {
                    if (array_key_exists('favorite_count', $arr)) {
                        $fields[] = 'total_favorites';
                    }

                    if (array_key_exists('total_comments', $arr)) {
                        $fields[] = 'total_comments';
                    }

                    $result = $fields;
                } else {
                    $result = $arr;
                }

                return $result;

            case 'collections':
            case 'collection':
            case 'cl':
                if (is_array($arr)) {
                    if (array_key_exists('favorite_count', $arr)) {
                        $fields[] = 'total_favorites';
                    }

                    if (array_key_exists('total_comments', $arr)) {
                        $fields[] = 'total_comments';
                    }

                    if (array_key_exists('total_items', $arr)) {
                        $fields[] = 'total_objects';
                    }

                    $result = $fields;
                } else {
                    $result = $arr;
                }

                return $result;
        }
    }
}
