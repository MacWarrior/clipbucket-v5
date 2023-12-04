<?php
require_once("Rest.inc.php");
include('../includes/config.inc.php');
include('global.php');

class API extends REST
{
    public $data = '';
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = '';
    const DB = "rest";

    private $db = null;


    private $max_video_limit = 20;
    private $videos_limit = 20;
    private $content_limit = 20;

    public function __construct()
    {
        parent::__construct();// Init parent contructor
    }

    //Public method for access api.
    //This method dynamically call the method based on the query string
    public function processApi()
    {
        $func = strtolower(trim(str_replace("/", '', $_REQUEST['mode'])));
        if ((int)method_exists($this, $func) > 0) {
            $this->$func();
        } else {
            $this->response('', 404);
        }
        // If the method not exist with in this class, response would be "Page not found".
    }

    //Encode array into JSON
    private function json($data)
    {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

    // Get Categories
    private function getCategories()
    {
        $data = [];
        $type = $_REQUEST['type'];

        if ($type == 'u' || $type == 'user' || $type == 'users') {
            global $userquery;
            $categories = $userquery->getCbCategories(['indexes_only' => true]);
            if (!empty($categories)) {
                $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $categories];
                $this->response($this->json($data));
            } else {
                $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
                $this->response($this->json($data));
            }
        } elseif ($type == 'v' || $type == 'video' || $type == 'videos') {
            global $cbvid;
            $categories = $cbvid->getCbCategories(['indexes_only' => true]);
            if (!empty($categories)) {
                $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $categories];
                $this->response($this->json($data));
            } else {
                $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
                $this->response($this->json($data));
            }
        } elseif ($type == "p" || $type == 'photo' || $type == 'photos') {
            global $cbcollection;
            $categories = $cbcollection->getCbCategories(['indexes_only' => true]);
            if (!empty($categories)) {
                $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $categories];
                $this->response($this->json($data));
            } else {
                $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
                $this->response($this->json($data));
            }
        }
    }

    // Get Videos

    private function getVideos()
    {
        $request = $_REQUEST;

        $blacklist_fields = [
            'password', 'video_password', 'avcode', 'session'
        ];
        if (isset($request['page'])) {
            $page = (int)$request['page'];
        } else {
            $page = 1;
        }

        $get_limit = create_query_limit($page, $this->videos_limit);

        $request['limit'] = $get_limit;

        $vids = $request['video_id'];
        if ($vids) {
            $vids = explode(',', $vids);
            $request['videoids'] = $vids;
        }

        global $cbvid;
        $videos = $cbvid->get_videos($request);

        $new_videos = [];
        global $userquery;
        if ($videos) {
            foreach ($videos as $video) {
                $video['title'] = utf8_encode($video['title']);
                $video['description'] = utf8_encode($video['description']);
                $video['thumbs'] = ['default' => get_thumb($video), 'big' => get_thumb($video, 'big')];

                $video['url'] = $video['video_link'] = $video['videoLink'] = video_link($video);
                $video['avatar'] = $video['user_photo'] = $video['displayPic'] = $userquery->avatar($video);

                foreach ($blacklist_fields as $field)
                    unset($video[$field]);

                $new_videos[] = $video;
            }
        }

        if (!empty($new_videos)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $new_videos];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Comments
    private function getComments()
    {
        $request = $_REQUEST;
        $params = [];
        $limit = config('comments_per_page');

        $page = $request['page'];

        if (!$page || !is_numeric($page) || $page < 1) {
            $page = 1;
        }

        if (!$limit || !is_numeric($limit) || $limit < 1) {
            $limit = 20;
        }

        $params['type'] = $request['type'];
        $params['type_id'] = $request['type_id'];
        $params['limit'] = create_query_limit($page, $limit);

        $comments = Comments::getAll($params);

        $blacklist_fields = [
            'password', 'video_password', 'avcode', 'session'
        ];

        $the_comments = [];

        if ($comments) {
            foreach ($comments['comments'] as $comment) {
                if ($comment) {
                    foreach ($blacklist_fields as $field) {
                        unset($comment[$field]);
                    }
                    $the_comments[] = $comment;
                }
            }
        }

        if (!empty($the_comments)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $the_comments];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Fields
    private function getFields()
    {
        global $Upload;
        $groups = $Upload->load_video_fields(null);

        $new_groups = [];
        foreach ($groups as $group) {
            $new_fields = [];
            foreach ($group['fields'] as $field) {
                if ($field) {
                    $new_fields[] = $field;
                }
            }

            $group['fields'] = $new_fields;
            $new_groups[] = $group;
        }

        if (!empty($new_groups)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $new_groups];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Playlists
    private function getPlaylists()
    {
        $request = $_REQUEST;
        $uid = mysql_clean($request['userid']);
        global $cbvid;
        $playlists = $cbvid->action->get_playlists($uid);

        if (!empty($playlists)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $playlists];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }


    // Get Playlists Items
    private function getPlaylistItems()
    {
        $request = $_REQUEST;
        $pid = mysql_clean($request['playlist_id']);
        global $cbvid;
        $items = $cbvid->get_playlist_items($pid);

        $blacklist_fields = [
            'password', 'video_password', 'avcode', 'session'
        ];

        global $userquery;
        if (!empty($items)) {
            $new_videos = [];
            foreach ($items as $video) {
                if (!$video['email']) {
                    $udetails = $userquery->get_user_details($video['userid']);
                }
                $video = array_merge($video, $udetails);

                $video['thumbs'] = ['default' => get_thumb($video)];
                $video['url'] = $video['video_link'] = $video['videoLink'] = video_link($video);
                $video['avatar'] = $video['user_photo'] = $video['displayPic'] = $userquery->avatar($video);

                foreach ($blacklist_fields as $field) {
                    unset($video[$field]);
                }

                $new_videos[] = $video;
            }
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $new_videos];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }

    }

    // Get Configs
    private function getConfigs()
    {
        $array = [
            'baseurl'         => BASEURL,
            'title'           => TITLE,
            'file_upload_url' => '/api/file_uploader.php',
            'session'         => session_id()
        ];

        $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $array];
        $this->response($this->json($data));
    }

    // Video Flag Options
    private function videoFlagOptions()
    {
        $flags = get_flag_options();

        $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $flags];
        $this->response($this->json($data));
    }

    // Get Subscribers
    private function getSubscribers()
    {
        $request = $_REQUEST;
        $uid = $request['userid'];
        if (!$uid) {
            $uid = user_id();
        }

        if (!$uid) {
            $data = ['code' => '418', 'status' => 'failure', 'msg' => 'Please Login', 'data' => ''];
            $this->response($this->json($data));
        }

        global $userquery;
        $subscribers = $userquery->get_user_subscribers_detail($uid);

        if ($subscribers) {
            $blacklist_fields = [
                'password', 'video_password', 'avcode', 'session'
            ];
            $the_subscribers = [];
            foreach ($subscribers as $subscriber) {
                foreach ($blacklist_fields as $field) {
                    unset($subscriber[$field]);
                }
                $the_subscribers[] = $subscriber;
            }

        }

        if (!empty($the_subscribers)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $the_subscribers];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Subscriptions
    private function getSubscriptions()
    {
        $request = $_REQUEST;
        $uid = $request['userid'];
        if (!$uid) {
            $uid = user_id();
        }

        if (!$uid) {
            $data = ['code' => '418', 'status' => 'failure', 'msg' => 'Please Login', 'data' => ''];
            $this->response($this->json($data));
        }

        global $userquery;
        $subscribers = $userquery->get_user_subscriptions($uid);

        if ($subscribers) {
            $the_subscribers = [];
            foreach ($subscribers as $subscriber) {
                $blacklist_fields = [
                    'password', 'video_password', 'avcode', 'session'
                ];
                foreach ($blacklist_fields as $field) {
                    unset($subscriber[$field]);
                }
                $the_subscribers[] = $subscriber;
            }
        }

        if (!empty($the_subscribers)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $the_subscribers];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Favorite Videos
    private function getFavoriteVideos()
    {
        $request = $_REQUEST;
        $limit = 20;

        $page = $request['page'];
        if (!$page || !is_numeric($page) || $page < 1) {
            $page = 1;
        }

        $get_limit = create_query_limit($page, $limit);
        $uid = $request['userid'];
        if (!$uid) {
            $uid = user_id();
        }

        if (!$uid) {
            $data = ['code' => '418', 'status' => 'failure', 'msg' => 'Please Login', 'data' => ''];
            $this->response($this->json($data));
        }

        $blacklist_fields = [
            'password', 'video_password', 'avcode', 'session'
        ];

        global $cbvid;
        $params = ['userid' => $uid, 'limit' => $get_limit];
        $videos = $cbvid->action->get_favorites($params);
        $params['count_only'] = 'yes';
        $total_rows = $cbvid->action->get_favorites($params);

        global $userquery;
        if ($total_rows > 0) {
            $new_videos = [];
            foreach ($videos as $video) {
                if (!$video['email']) {
                    $udetails = $userquery->get_user_details($video['userid']);
                }

                $video = array_merge($video, $udetails);

                $video['thumbs'] = ['default' => get_thumb($video)];
                $video['url'] = $video['video_link'] = $video['videoLink'] = video_link($video);
                $video['avatar'] = $video['user_photo'] = $video['displayPic'] = $userquery->avatar($video);

                foreach ($blacklist_fields as $field) {
                    unset($video[$field]);
                }

                $new_videos[] = $video;
            }

            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $new_videos];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Users
    private function getUsers()
    {
        $request = $_REQUEST;

        $page = $request['page'];
        if (!$page || !is_numeric($page) || $page < 1) {
            $page = 1;
        }

        $get_limit = create_query_limit($page, $this->videos_limit);

        $request['limit'] = $get_limit;

        $users = get_users($request);

        global $userquery;
        $new_users = [];
        if ($users) {
            foreach ($users as $user) {
                $user['avatar'] = $user['user_photo'] = $userquery->avatar($user);
                $new_users[] = $user;
            }
        }

        $user_api_fields = [
            'username', 'first_name', 'last_name', 'fullname',
            'avatar', 'avatar_url',
            'userid', 'email',
            'total_videos',
            'total_photos', 'total_collections',
        ];

        $final_users = [];
        if ($new_users) {
            foreach ($new_users as $user) {
                $final_user = [];
                foreach ($user_api_fields as $field) {
                    $final_user[$field] = $user[$field];
                }
                $final_users[] = $final_user;
            }
        }

        if (!empty($final_users)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $final_users];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Photos
    private function getPhotos()
    {
        $request = $_REQUEST;

        $page = $request['page'];
        if (!$page || !is_numeric($page) || $page < 1) {
            $page = 1;
        }

        $get_limit = create_query_limit($page, $this->videos_limit);

        $request['limit'] = $get_limit;

        if (VERSION < 3) {
            $request['user'] = $request['userid'];
        }

        //$request['order'] = tbl('video.'.$request['order']);
        global $cbphoto;
        $photos = $cbphoto->get_photos($request);
        //header('Content-Type: text/html; charset=utf-8');

        $new_photos = [];
        if ($photos) {
            foreach ($photos as $photo) {
                $photo['photo_title'] = utf8_encode($photo['photo_title']);
                $photo['photo_description'] = utf8_encode($photo['photo_description']);
                $photo['photo_link'] = $cbphoto->photo_links($photo, 'view_photo');
                $photo['photo_thumb'] = [
                    'm' => get_image_file([
                        'details' => $photo,
                        'size'    => 'm',
                        'output'  => 'non_html'
                    ]),
                    'l' => get_image_file([
                        'details' => $photo,
                        'size'    => 'l',
                        'output'  => 'non_html'
                    ])
                ];

                //$photo['thumbs'] = array('default' => get_thumb($photo), 'big' => get_thumb($photo, 'big'));

                $new_photos[] = $photo;
            }
        }
        //echo $db->db_query;
        //echo json_encode($new_photos);

        if (!empty($new_photos)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $new_photos];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Friends
    private function getFriends()
    {
        $request = $_REQUEST;

        $uid = $request['userid'];
        if (!$uid) {
            $uid = user_id();
        }

        if (!$uid) {
            $data = ['code' => '418', 'status' => 'failure', 'msg' => 'Please Login', 'data' => ''];
            $this->response($this->json($data));
        }

        global $userquery;
        $friends = $userquery->get_contacts($uid);

        if (!empty($friends)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $friends];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get Feeds
    private function getFeeds()
    {
        $request = $_REQUEST;


        $page = $request['page'];
        if (!$page || !is_numeric($page) || $page < 1) {
            $page = 1;
        }

        $id = mysql_clean($request['id']);
        $page = mysql_clean($page);
        $type = mysql_clean($request['type']);

        $limit = 20;
        $get_limit = create_query_limit($page, $limit);

        $params = ['id' => $id, 'limit' => $get_limit, 'type' => $type];

        global $cbfeeds;
        $feeds = [];

        $feeds = $cbfeeds->get_feeds($params);

        $the_feeds = [];

        if (!empty($feeds)) {
            foreach ($feeds as $feed) {
                $feed['comments'] = json_encode($feed['comments']);
                $the_feeds[] = $feed;
            }
            //echo json_encode($the_feeds);
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $the_feeds];
            $this->response($this->json($data));
        } else {
            //echo json_encode(array('err' => error()));
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Get User
    private function getUser()
    {
        $request = $_REQUEST;

        $userid = mysql_clean($request['userid']);
        $user = [];
        global $userquery;
        if ($userid) {
            $user = $userquery->get_user_details_with_profile($userid);
        }

        if ($user) {
            $user['avatar'] = $user['user_photo'] = $userquery->avatar($user);
            $user['avatars']['medium'] = $userquery->avatar($user, 'medium');
            $user['avatars']['xmedium'] = $userquery->avatar($user, 'xmedium');
            $user['avatars']['large'] = $userquery->avatar($user, 'large');
            // $user['name'] = name($user);
            //echo json_encode($user);
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $user];
            $this->response($this->json($data));
        } else {
            //echo json_encode(array('err'=>'User does not exist'));
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

    // Home Page
    private function home_page()
    {
        define('API_HOME_PAGE', 'yes');

        global $cbvid;
        $videos = $cbvid->get_videos(['featured' => 'yes', 'limit' => 10, 'order' => 'featured_date DESC']);

        global $userquery;
        $new_videos = [];
        if ($videos) {

            foreach ($videos as $video) {
                $video['title'] = utf8_encode($video['title']);
                $video['description'] = utf8_encode($video['description']);
                $video['thumbs'] = ['default' => get_thumb($video), 'big' => get_thumb($video, 'big'), '640x480' => get_thumb($video, '640x480')];
                $video['url'] = $video['video_link'] = $video['videoLink'] = video_link($video);
                $video['avatar'] = $video['user_photo'] = $video['displayPic'] = $userquery->avatar($video);
                $video['avatars']['medium'] = $userquery->avatar($video, 'small');
                $video['avatars']['xmedium'] = $userquery->avatar($video, 'xmedium');
                $video['avatars']['large'] = $userquery->avatar($video, 'large');
                $new_videos[] = $video;
            }
        }

        $featured = $new_videos;

        $categories = $cbvid->getCbCategories([
            'cond'  => " ( category_id = '1' OR category_id = '16' OR category_id = '26' OR category_id = '15' ) ",
            'limit' => 4,
            'type'  => 'v'
        ]);


        $cat_videos = [];

        foreach ($categories as $category) {
            $cat_vid = [
                'name' => $category['category_name'],
                'id'   => $category['category_id'],
            ];

            $videos = $cbvid->get_videos(['limit' => 10, 'category' => $category['category_id'], 'order' => ' date_added desc ']);

            $new_videos = [];
            if ($videos) {
                foreach ($videos as $video) {
                    $video['title'] = utf8_encode($video['title']);
                    $video['description'] = utf8_encode($video['description']);
                    $video['thumbs'] = ['default' => get_thumb($video), 'big' => get_thumb($video, 'big'), '640x480' => get_thumb($video, '640x480')];

                    $video['url'] = $video['video_link'] = $video['videoLink'] = video_link($video);
                    $video['avatar'] = $video['user_photo'] = $video['displayPic'] = $userquery->avatar($video);
                    $video['avatars']['medium'] = $userquery->avatar($video, 'medium');
                    $video['avatars']['xmedium'] = $userquery->avatar($video, 'xmedium');
                    $video['avatars']['large'] = $userquery->avatar($video, 'large');

                    $new_videos[] = $video;
                }
            }
            $cat_vid['videos'] = $new_videos;
            $cat_videos[] = $cat_vid;
        }

        $home = [
            'featured'   => $featured,
            'categories' => $cat_videos
        ];
        //echo json_encode($home);
        if (!empty($featured) || !empty($cat_videos)) {
            $data = ['code' => '200', 'status' => 'success', 'msg' => 'success', 'data' => $home];
            $this->response($this->json($data));
        } else {
            $data = ['code' => '204', 'status' => 'success', 'msg' => 'No Record Found', 'data' => ''];
            $this->response($this->json($data));
        }
    }

}

// Initiate Library
$api = new API;
$api->processApi();
