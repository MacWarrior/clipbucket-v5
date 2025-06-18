<?php

class cbfeeds
{
    private static self $instance;
    public static function getInstance(): self
    {
        if( empty(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Function used to add feed in user feed file
     *
     * @param array $feed
     * action => upload,joined,comment,created
     * object => video, photo, group
     * object_id => id of object
     * object_details => details of object
     * uid => user id
     * udetails => user details array
     *
     * @return bool|void
     */
    function addFeed($feed)
    {
        if (!isSectionEnabled('feeds')) {
            return false;
        }

        $uid = $feed['uid'];

        if (!$uid) {
            return false;
        }

        $ufeed = [];

        //Verifying feed action and object
        $action = $this->action($feed['action']);
        $object = $this->getObject($feed['object']);

        if (!$action || !$object) {
            return false;
        }

        //Setting user feed array
        $ufeed['action'] = $action;
        $ufeed['object'] = $object;
        $ufeed['object_id'] = $feed['object_id'];
        $ufeed['userid'] = $uid;
        $ufeed['time'] = time();

        //Unsetting feed array
        unset($feed);

        //Getting user feed file
        $feedFile = $this->getFeedFile($uid);

        //Converting feed using json
        $feed = json_encode($ufeed);
        //Creating unique md5 of feed
        $feedmd5 = md5($feed);
        $ufeed['md5'] = $feedmd5;
        //Recreating Feed
        $feed = json_encode($ufeed);

        //Appending feed in a file
        $file = fopen($feedFile, 'a+');
        fwrite($file, $feed);
        fclose($file);
    }


    /**
     * Function used to get action of feed
     * it will verify weather action is valid or not
     *
     * @param $action
     *
     * @return bool|string
     */
    function action($action)
    {
        $objects = ['signup', 'upload_video', 'upload_photo', 'add_friend', 'add_collection', 'add_playlist', 'add_comment', 'add_favorite'];

        if (!in_array($action, $objects)) {
            return false;
        }
        return $action;
    }


    /**
     * Function used to get object of feed
     * it will verify weather action is valid or not
     *
     * @param $object
     *
     * @return bool|string
     */
    function getObject($object)
    {
        $objects = ['signup', 'video', 'photo', 'group', 'user', 'friend', 'collection', 'post'];

        if (!in_array($object, $objects)) {
            return false;
        }
        return $object;
    }

    /**
     * Function used to get feed file
     *
     * @param $uid
     *
     * @return string
     */
    function getFeedFile($uid): string
    {
        $time = time();
        $ufeedDir = DirPath::get('userfeeds') . $uid;
        //checking user feed folder exists or not
        if (!file_exists($ufeedDir)) {
            mkdir($ufeedDir, 0755, true);
        }
        return $ufeedDir . DIRECTORY_SEPARATOR . $time . '.feed';
    }

    /**
     * Function used to get user feed files
     *
     * @param null $uid
     *
     * @throws Exception
     */
    function getUserFeedsFiles($uid = null): array
    {
        if (!$uid) {
            $uid = user_id();
        }

        $feeds = [];
        $ufeedDir = DirPath::get('userfeeds') . $uid;
        if (file_exists($ufeedDir)) {
            $files = glob($ufeedDir . DIRECTORY_SEPARATOR . '*.feed');
            rsort($files);
            foreach ($files as $file) {
                $feed['content'] = file_get_contents($file);
                $feed['file'] = $file;
                $feeds[] = $feed;
            }

            return $feeds;
        }
        return $feeds;
    }

    /**
     * Function used to get user feed
     *
     * @param array $user
     *
     * @return array
     * @throws Exception
     */
    function getUserFeeds(array $user): array
    {
        $allowed_feeds = 15;
        $uid = $user['userid'];
        $feeds = $this->getUserFeedsFiles($uid);

        if( empty($feeds) ){
            return [];
        }
        $newFeeds = [];
        $count = 0;
        foreach ($feeds as $feed) {
            $count++;

            if ($count > $allowed_feeds) {
                break;
            }
            $feedArray = json_decode($feed['content'], true);
            if ($feed && !empty($feedArray)) {
                $remove_feed = false;
                $farr = $feedArray;

                $action = $farr['action'];
                $object_id = $farr['object_id'];
                $farr['user'] = $user;
                $farr['file'] = getName($feed['file']);
                $farr['datetime'] = nicetime($farr['time'], true);

                $userlink = '<a href="' . userquery::getInstance()->profile_link($user) . '">' . display_clean($user['username']) . '</a>';
                //Creating Links
                switch ($action) {
                    case 'upload_photo':
                        $photo = CBPhotos::getInstance()->get_photo($object_id);

                        //If photo does not exists, simply remove the feed
                        if (!$photo) {
                            $this->deleteFeed($uid, $feed['file']);
                            $remove_feed = true;
                        } else {
                            $objectArr['details'] = $photo;
                            $objectArr['size'] = 't';
                            $objectArr['output'] = 'non_html';
                            $objectArr['alt'] = $photo['photo_title'];
                            $farr['thumb'] = CBPhotos::getInstance()->getFileSmarty($objectArr);
                            $farr['link'] = CBPhotos::getInstance()->photo_links($photo, 'view_item');

                            //Content Title
                            $farr['title'] = $photo['photo_title'];
                            $farr['action_title'] = lang('user_has_uploaded_new_photo', $userlink);

                            $farr['links'][] = ['link' => (CBPhotos::getInstance()->photo_links($photo, 'view_item')), 'text' => lang('view_photo')];

                            $farr['icon'] = 'images.png';
                        }
                        break;

                    case 'upload_video':
                    case 'add_favorite':
                        $video = CBvideo::getInstance()->get_video($object_id);
                        //If photo does not exists, simply remove the feed
                        if (!$video) {
                            $this->deleteFeed($uid, $feed['file']);
                            $remove_feed = true;
                        } elseif (!video_playable($video)) {
                            $remove_feed = true;
                        } else {
                            //Content Title
                            $farr['title'] = $video['title'];
                            if ($action == 'upload_video') {
                                $farr['action_title'] = lang('user_has_uploaded_new_video', $userlink);
                            }
                            if ($action == 'add_favorite') {
                                $farr['action_title'] = lang('user_has_favorited_video', $userlink);
                            }
                            $farr['link'] = video_link($video);
                            $farr['object_content'] = $video['description'];
                            $farr['thumb'] = get_thumb($video);
                            $farr['links'][] = ['link' => video_link($video), 'text' => lang('watch_video')];
                            $farr['icon'] = 'video.png';

                            if ($action == 'add_favorite') {
                                $farr['icon'] = 'heart.png';
                            }
                        }
                        break;

                    case 'signup':
                        $farr['action_title'] = lang('user_joined_us', [$userlink, TITLE, $userlink]);
                        $farr['icon'] = 'user.png';
                        break;

                    case 'add_friend':
                        $friend = userquery::getInstance()->get_user_details($object_id);

                        if (!$friend) {
                            $this->deleteFeed($uid, $feed['file']);
                            $remove_feed = true;
                        } else {
                            $friendlink = '<a href="' . userquery::getInstance()->profile_link($friend) . '">' . display_clean($friend['username']) . '</a>';
                            $farr['action_title'] = lang('user_is_now_friend_with_other', [$userlink, $friendlink]);
                            $farr['icon'] = 'user_add.png';
                        }
                        break;

                    case 'add_collection':
                        $collection = Collections::getInstance()->get_collection($object_id);
                        if (!$collection) {
                            $this->deleteFeed($uid, $feed['file']);
                            $remove_feed = true;
                        } else {
                            $farr['action_title'] = lang('user_has_created_new_collection', $userlink);
                            $farr['thumb'] = Collections::getInstance()->get_thumb($collection, 'small');
                            $farr['title'] = $collection['collection_name'];
                            $collection_link = Collections::getInstance()->collection_links($collection, 'view');
                            $farr['link'] = $collection_link;
                            $farr['object_content'] = $collection['collection_description'] . '<br>' . $collection['total_objects'] . ' ' . $collection['type'];
                            $farr['icon'] = 'photos.png';
                            $farr['links'][] = ['link' => $collection_link, 'text' => lang('view_collection')];
                        }
                        break;

                    case 'add_comment':
                        $params = [];
                        $params['comment_id'] = $object_id;
                        $params['first_only'] = true;
                        $comment = Comments::getAll($params);

                        //If photo does not exists, simply remove the feed
                        if (!$comment) {
                            $this->deleteFeed($uid, $feed['file']);
                            $remove_feed = true;
                        } else {
                            //Content Title
                            $farr['title'] = $comment['title'];
                            $farr['action_title'] = $userlink . ' ' . lang('commented on a post');
                            $farr['link'] = video_link($video);
                            $farr['object_content'] = $video['description'];
                            $farr['thumb'] = get_thumb($video);
                            $farr['links'][] = ['link' => video_link($video), 'text' => lang('watch_video')];
                            $farr['icon'] = 'video.png';
                            if ($action == 'add_favorite') {
                                $farr['icon'] = 'heart.png';
                            }
                        }
                        break;
                }

                if (!$remove_feed) {
                    $newFeeds[$feedArray['time']] = $farr;
                }
            }
        }
        return $newFeeds;
    }


    /**
     * Function used to delete feed
     *
     * @param $uid
     * @param $feedid
     */
    function deleteFeed($uid, $feedid): void
    {
        $ufeedDir = DirPath::get('userfeeds') . $uid . DIRECTORY_SEPARATOR . getName($feedid) . '.feed';
        if (file_exists($ufeedDir)) {
            unlink($ufeedDir);
        }
    }
}