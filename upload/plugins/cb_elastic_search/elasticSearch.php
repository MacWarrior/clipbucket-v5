<?php

/**
 * @link      http://
 * @copyright Copyright (c) 2007 - 2018 by Fahad Abbas
 * @link   https://bitbucket.org/clip-bucket/aditube/src/master/includes/classes/elasticSearch
 */
class ElasticSearch
{
    /**
     * This variable is to define
     *
     * @var string Variable
     */
    protected $apiUrl = '';

    /**
     * This variable is to define
     *
     * @var string Variable
     */
    public $sort = "relevance";

    /**
     * This variable is to define
     *
     * @var int Variable
     */
    public $from = 0;

    /**
     * This variable is to define to fetch results count
     *
     * @var int Variable
     */
    public $size = 10;

    /**
     * This variable is to define
     *
     * @var array Variable
     */
    protected $EsQuery = [];

    /**
     * This variable is to define
     *
     * @var string Variable
     */
    public $publicQuery = "";

    /**
     * This variable is to define
     *
     * @var string Variable
     */
    public $index = "";

    /**
     * This variable is to define
     *
     * @var string Variable
     */
    public $results = "";

    /**
     * This variable is to define
     *
     * @var array Variable
     */
    public $resultsHits = [];

    /**
     * This variable is to define to fetch results count
     *
     * @var array Variable
     */
    public $filters = [
        "category"  => "",
        "author"    => "",
        "object_id" => "",
    ];

    /**
     * This variable is to define mapping of videos Object
     *
     * @object Variable
     */
    public $videoMappingData = [
        "mappings" => [
            "_doc" => [
                "properties" => [
                    "videoid"           => ["type" => "long"],
                    "title"             => ["type" => "text"],
                    "userid"            => [
                        "type" => "long",
                    ],
                    "username"          => ["type" => "text"],
                    "first_name"        => ["type" => "text"],
                    "last_name"         => ["type" => "text"],
                    "description"       => ["type" => "text"],
                    "category"          => [
                        "type"       => "object",
                        "properties" => [
                            "id"   => [
                                "type" => "integer",
                            ],
                            "name" => [
                                "type"      => "text",
                                "fielddata" => true,
                            ]
                        ]
                    ],
                    "tags"              => ["type" => "text"],
                    "videokey"          => ["type" => "text"],
                    "file_name"         => ["type" => "text"],
                    "file_server_path"  => ["type" => "text"],
                    "file_directory"    => ["type" => "text"],
                    "rating"            => ["type" => "text"],
                    "comments_count"    => ["type" => "integer"],
                    "default_thumb"     => ["type" => "integer"],
                    "status"            => ["type" => "text"],
                    "broadcast"         => ["type" => "text"],
                    "views"             => ["type" => "integer"],
                    "date_added"        => [
                        "type" => "date"
                    ]
                ]
            ]
        ]
    ];

    /**
     * This variable is to define mapping of videos Object
     *
     * @object Variable
     */
    public $photoMappingData = [
        "mappings" => [
            "_doc" => [
                "properties" => [
                    "photo_id"       => ["type" => "long"],
                    "title"          => ["type" => "text"],
                    "username"       => ["type" => "text"],
                    "first_name"     => ["type" => "text"],
                    "last_name"      => ["type" => "text"],
                    "description"    => ["type" => "text"],
                    "tags"           => ["type" => "text"],
                    "userid"         => [
                        "type" => "long",
                    ],
                    "collection_id"  => [
                        "type" => "long",
                    ],
                    "photo_key"      => ["type" => "text"],
                    "file_name"      => ["type" => "text"],
                    "file_directory" => ["type" => "text"],
                    "rating"         => ["type" => "text"],
                    "photo_details"  => ["type" => "text"],
                    "active"         => ["type" => "text"],
                    "views"          => ["type" => "integer"],
                    "date_added"     => [
                        "type" => "date"
                    ]
                ]
            ]
        ]
    ];

    /**
     * This variable is to define mapping of videos Object
     *
     * @object Variable
     */
    public $userMappingData = [
        "mappings" => [
            "_doc" => [
                "properties" => [
                    "userid"       => [
                        "type" => "long",
                    ],
                    "username"     => ["type" => "text"],
                    "first_name"   => ["type" => "text"],
                    "last_name"    => ["type" => "text"],
                    "email"        => ["type" => "text"],
                    "category"     => [
                        "type"       => "object",
                        "properties" => [
                            "id"   => [
                                "type" => "integer",
                            ],
                            "name" => [
                                "type"      => "text",
                                "fielddata" => true,
                            ]
                        ]
                    ],
                    "usr_status"   => ["type" => "text"],
                    "views"        => ["type" => "integer"],
                    "total_videos" => ["type" => "integer"],
                    "date_added"   => [
                        "type" => "date"
                    ]
                ]
            ]
        ]
    ];

    /**
     * This variable is to define mapping of videos Object
     *
     * @object Variable
     */
    public $collectionMappingData = [
        "mappings" => [
            "_doc" => [
                "properties" => [
                    "group_id"          => ["type" => "integer"],
                    "group_name"        => ["type" => "text"],
                    "userid"            => [
                        "type" => "long",
                    ],
                    "username"          => [
                        "type"      => "text",
                        "fielddata" => true
                    ],
                    "first_name"        => ["type" => "text"],
                    "last_name"         => ["type" => "text"],
                    "group_description" => ["type" => "text"],
                    "group_tags"        => ["type" => "text"],
                    "group_url"         => ["type" => "text"],
                    "category"          => [
                        "type"       => "object",
                        "properties" => [
                            "id"   => [
                                "type" => "integer",
                            ],
                            "name" => [
                                "type"      => "text",
                                "fielddata" => true,
                            ]
                        ]
                    ],
                    "active"            => ["type" => "text"],
                    "views"             => ["type" => "integer"],
                    "total_videos"      => ["type" => "integer"],
                    "total_members"     => ["type" => "integer"],
                    "total_topics"      => ["type" => "integer"],
                    "date_added"        => [
                        "type" => "date"
                    ]
                ]
            ]
        ]
    ];

    /**
     * The Constructor of Controller Class
     *
     * @constructor Function
     */
    function __construct($index = false)
    {
        $this->apiUrl = config('elastic_server_ip');
        $this->index = $index;
    }

    /**
     * @param   : { $index,$postData } { tablename and mapping Data }
     * @return  : { Array } {Video Array}
     * @throws \Exception
     *
     * @todo    : This method is used to map Mysql Database tables with ES
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { MapIndex($request,$response, $args) }
     *
     * This method is used to map Mysql Database tables with E
     *
     * @since   : { 5th June 2018 }
     */
    public function EsMap($mapData, $extras = false)
    {
        $request = [];

        $request["post_arr"] = json_encode($mapData);
        $request["url"] = $this->apiUrl . '/' . $this->index;
        $request["method"] = $extras["method"];
        $request["headers"] = ['Content-Type: application/json'];
        if ($request["method"] == 'delete') {
            unset($request["post_arr"]);
            unset($request["headers"]);
        }

        $response = generic_curl($request);
        return $response;
    }

    public function EsIndex($IndexData, $extras = false)
    {
        $request = [];

        $request["post_arr"] = $IndexData;
        $request["url"] = $this->apiUrl . '/' . $this->index . '/_doc/' . $extras["id"];
        $request["method"] = $extras["method"];
        $request["headers"] = ['Content-Type: application/json'];
        if ($request["method"] == 'delete' || $request["method"] == 'get') {
            unset($request["post_arr"]);
            unset($request["headers"]);
        }
        $response = generic_curl($request);
        return $response;
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function FormatVideo($video)
    {
        global $cbvid, $userquery;

        $newVideo = (object)[];

        $newVideo->videoid = $video["videoid"];
        $newVideo->userid = $video["userid"];
        $newVideo->title = $video["title"];
        $newVideo->description = htmlspecialchars($video["description"]);
        $newVideo->tags = $video['tags'];

        $categories = $cbvid->get_category_names($video["category"]);
        $category = [];
        if (is_array($categories)) {
            foreach ($categories as $key => $cat) {
                $cattemp["id"] = $cat["category_id"];
                $cattemp["name"] = $cat["category_name"];
                $category[] = $cattemp;
            }
        }

        $user_details = $userquery->get_user_details($video["userid"]);
        if ($user_details) {
            $newVideo->username = $user_details['username'];
            $newVideo->first_name = $user_details['first_name'];
            $newVideo->last_name = $user_details['last_name'];
        }

        $newVideo->category = $category;
        $newVideo->videokey = $video['videokey'];
        $newVideo->file_name = $video['file_name'];
        $newVideo->file_server_path = $video['file_server_path'];
        $newVideo->file_directory = $video['file_directory'];
        $newVideo->rating = $video['rating'];
        $newVideo->comments_count = $video['comments_count'];
        $newVideo->default_thumb = $video['default_thumb'];
        $newVideo->broadcast = $video['broadcast'];
        $newVideo->status = $video['status'];
        $newVideo->views = $video['views'];
        $date = new DateTime($video["date_added"]);
        $newVideo->date_added = $date->format('Y-m-d');
        return json_encode($newVideo);
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function FormatPhoto($photo)
    {
        global $userquery;

        $newPhoto = (object)[];

        $newPhoto->photo_id = $photo["photo_id"];
        $newPhoto->userid = $photo["userid"];
        $newPhoto->collection_id = $photo["collection_id"];
        $newPhoto->photo_title = $photo["photo_title"];
        $newPhoto->photo_description = htmlspecialchars($photo["photo_description"]);
        $newPhoto->photo_tags = $photo['photo_tags'];

        $user_details = $userquery->get_user_details($photo["userid"]);
        if ($user_details) {
            $newPhoto->username = $user_details['username'];
            $newPhoto->first_name = $user_details['first_name'];
            $newPhoto->last_name = $user_details['last_name'];
        }

        $newPhoto->photo_key = $photo['photo_key'];
        $newPhoto->filename = $photo['filename'];
        $newPhoto->file_directory = $photo['file_directory'];
        $newPhoto->rating = $photo['rating'];
        $newPhoto->active = $photo['active'];
        $newPhoto->views = $photo['views'];
        $newPhoto->ext = $photo['ext'];
        $date = new DateTime($photo["date_added"]);
        $newPhoto->date_added = $date->format('Y-m-d');
        return json_encode($newPhoto);
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function FormatUser($user)
    {
        global $userquery;

        $newUser = (object)[];

        $newUser->userid = $user["userid"];
        $newUser->first_name = $user["first_name"];
        $newUser->last_name = $user["last_name"];
        $newUser->username = $user["username"];
        $newUser->email = $user["email"];
        $newUser->views = $user["profile_hits"];
        $newUser->usr_status = $user["usr_status"];
        $categories = $userquery->get_category_names($user["category"]);
        $category = [];
        if (is_array($categories)) {
            foreach ($categories as $key => $cat) {
                $cattemp["id"] = $cat["category_id"];
                $cattemp["name"] = $cat["category_name"];
                $category[] = $cattemp;
            }
        }
        $user_details = $userquery->get_user_details($user["userid"]);
        if ($user_details) {
            $newUser->username = $user_details['username'];
            $newUser->first_name = $user_details['first_name'];
            $newUser->last_name = $user_details['last_name'];
        }
        $newUser->category = $category;
        $newUser->total_videos = $user["total_videos"];
        $newUser->total_photos = $user["total_photos"];
        $newUser->subscribers = $user["subscribers"];
        $newUser->total_subscriptions = $user["total_subscriptions"];
        $date = new DateTime($user["doj"]);
        $newUser->date_added = $date->format('Y-m-d');

        return json_encode($newUser);
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function FormatGroupCollection($group)
    {
        global $cbgroup, $userquery;

        $NewGroup = (object)[];

        $NewGroup->group_id = $group["group_id"];
        $NewGroup->group_name = $group["group_name"];
        $NewGroup->userid = $group["userid"];
        $NewGroup->group_description = htmlspecialchars($group["group_description"]);
        $NewGroup->group_tags = $group["group_tags"];
        $NewGroup->group_url = $group["group_url"];
        $categories = $cbgroup->get_category_names($group["category"]);
        $category = [];
        if (is_array($categories)) {
            foreach ($categories as $key => $cat) {
                $cattemp["id"] = $cat["category_id"];
                $cattemp["name"] = $cat["category_name"];
                $category[] = $cattemp;
            }
        }
        $user_details = $userquery->get_user_details($group["userid"]);
        if ($user_details) {
            $NewGroup->username = $user_details['username'];
            $NewGroup->first_name = $user_details['first_name'];
            $NewGroup->last_name = $user_details['last_name'];
        }
        $NewGroup->category = $category;
        $NewGroup->views = $group["total_views"];
        $NewGroup->total_videos = $group["total_videos"];
        $NewGroup->total_members = $group["total_members"];
        $NewGroup->total_topics = $group["total_topics"];

        $NewGroup->active = $group["active"];
        $date = new DateTime($group["date_added"]);
        $NewGroup->date_added = $date->format('Y-m-d');
        return json_encode($NewGroup);
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function ElasticSearch()
    {
        $request = [];

        $request["post_arr"] = $this->EsQuery;
        if ($this->index) {
            $request["url"] = $this->apiUrl . '/' . $this->index . '/_search/';
        } else {
            $request["url"] = $this->apiUrl . '/_search/';
        }
        $request["method"] = "GET";
        $request["headers"] = ['Content-Type: application/json'];

        $response = generic_curl($request);
        $this->results = $response;
        return $response;
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception if any of the Error come
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function getVideoQueryBool()
    {
        $bool = [];

        $bool_must["should"][] = [
            "wildcard" => [
                "title" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["match" => [
            "description" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["match" => [
            "category.name" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["match" => [
            "tags" => $this->publicQuery
        ]];
        $bool_must["should"][] = [
            "prefix" => [
                "username" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["prefix" => [
            "first_name" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "email" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "last_name" => $this->publicQuery
        ]];
        $bool["must"][] = [
            "bool" => $bool_must
        ];

        if (!has_access("admin_access")) {
            $bool["filter"][] = [
                "match" => [
                    "status" => 'Successful'
                ]
            ];
        }

        return $bool;
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception if any of the Error come
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function getUserQueryBool()
    {
        $bool = [];

        $bool_must["should"][] = [
            "prefix" => [
                "username" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["prefix" => [
            "first_name" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "email" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "last_name" => $this->publicQuery
        ]];

        $bool["must"][] = [
            "bool" => $bool_must
        ];

        if (!has_access("admin_access", true)) {
            $bool["filter"][] = [
                "match" => [
                    "usr_status" => 'Ok'
                ]
            ];
        }

        return $bool;
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception if any of the Error come
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function getGCQueryBool()
    {
        $bool = [];

        $bool_must["should"][] = [
            "match" => [
                "group_name" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["match" => [
            "group_description" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["match" => [
            "group_tags" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["match" => [
            "category.name" => $this->publicQuery
        ]];
        $bool_must["should"][] = [
            "prefix" => [
                "username" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["prefix" => [
            "first_name" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "email" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "last_name" => $this->publicQuery
        ]];


        $bool["must"][] = [
            "bool" => $bool_must
        ];

        if (!has_access("admin_access")) {
            $bool["filter"][] = [
                "match" => [
                    "active" => 'yes'
                ]
            ];
        }

        return $bool;
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception if any of the Error come
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function getAllQueryBool()
    {
        $bool = [];

        //videos
        $bool_must["should"][] = [
            "match" => [
                "title" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["match" => [
            "description" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["match" => [
            "tags" => $this->publicQuery
        ]];
        //users
        $bool_must["should"][] = [
            "prefix" => [
                "username" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["prefix" => [
            "first_name" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "email" => $this->publicQuery
        ]];
        $bool_must["should"][] = ["prefix" => [
            "last_name" => $this->publicQuery
        ]];
        //groups && collections
        $bool_must["should"][] = [
            "match" => [
                "group_name" => $this->publicQuery
            ]];
        $bool_must["should"][] = ["match" => [
            "group_description" => $this->publicQuery
        ]];
        $bool_must["should"][] = [
            "match" => [
                "group_tags" => $this->publicQuery
            ]
        ];

        //all in all
        $bool_must["should"][] = [
            "match" => [
                "category.name" => $this->publicQuery
            ]
        ];

        $bool["must"][] = [
            "bool" => $bool_must
        ];
        if (!has_access("admin_access", true)) {
            $bool["filter"][] = [
                "match" => [
                    "active" => 'yes'
                ]
            ];
            $bool["filter"][] = [
                "match" => [
                    "usr_status" => 'Ok'
                ]
            ];
            $bool["filter"][] = [
                "match" => [
                    "status" => 'Successful'
                ]
            ];
        }
        return $bool;
    }

    /**
     * @param   : { $video } { video to be processed }
     * @return  : { Array } {Video Array}
     * @throws \Exception if any of the Error come
     *
     * @todo    : This method is used to format video for ES sever request
     * @author  : <fahad.dev@iu.com.pk> <Fahad Abbas>
     * @example : { FormatVideo($video) }
     *
     * This method is used to format video for ES sever request
     *
     * @since   : { 30 October 2018 }
     */
    public function buildQuery()
    {

        $bool = [];

        if ($this->index == 'videos') {
            $queryBool = $this->getVideoQueryBool();
        } elseif ($this->index == 'users') {
            $queryBool = $this->getUserQueryBool();
        } elseif ($this->index == 'groups' || $this->index == 'collections') {
            $queryBool = $this->getGCQueryBool();
        } else {
            $queryBool = $this->getAllQueryBool();
        }

        //this must be called on videos index
        if (!empty($this->filters['category'])) {
            $queryBool = [];
            $queryBool["must"][] = [
                "match" => [
                    "category.id" => $this->filters['category']
                ]
            ];
        }
        if (!empty($this->filters['author'])) {
            $queryBool = [];
            $queryBool["must"][] = [
                "match" => [
                    "userid" => $this->filters['author']
                ]
            ];
        }

        ////this must be called on collections / groups index
        if (!empty($this->filters['object_id'])) {
            $queryBool = [];
            $queryBool["must"][] = [
                "match" => [
                    "group_id" => $this->filters['object_id']
                ]
            ];
        }

        $this->EsQuery["query"] = ["bool" => $queryBool];

        if ($this->sort == 'date') {
            $sort["date_added"] = ["order" => "desc"];
        } else {
            if ($this->sort == 'views') {
                $sort["views"] = ["order" => "desc"];
            } else {
                $sort["_score"] = ["order" => "desc"];
            }
        }

        $this->EsQuery["aggs"]["object"] = [
            "terms" => [
                "field" => "_index"
            ],
        ];

        $this->EsQuery["aggs"]["byindex"] = [
            "terms" => [
                "field" => "_index"
            ],

            "aggs" => [
                "author"      => [
                    "terms" => [
                        "field" => "userid"
                    ],
                    "aggs"  => [
                        "platform" => [
                            "top_hits" => [
                                "size"    => 1,
                                "_source" =>
                                    ["include" => [
                                        'userid',
                                        'username',
                                        'first_name',
                                        'last_name',
                                    ]
                                    ]
                            ]
                        ]
                    ]
                ],
                "category"    => [
                    "terms" => [
                        "field" => "category.id",
                    ],
                    "aggs"  => [
                        "platform" => [
                            "top_hits" => [
                                "size"    => 1,
                                "_source" =>
                                    ["include" => ['category']]
                            ]
                        ]
                    ]
                ],
                "collections" => [
                    "terms" => [
                        "field" => "collections.id",
                    ],
                    "aggs"  => [
                        "platform" => [
                            "top_hits" => [
                                "size"    => 1,
                                "_source" =>
                                    ["include" => ['collections']]
                            ]
                        ]
                    ]
                ],
                "groups"      => [
                    "terms" => [
                        "field" => "groups.id",
                    ],
                    "aggs"  => [
                        "platform" => [
                            "top_hits" => [
                                "size"    => 1,
                                "_source" =>
                                    ["include" => ['groups']]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->EsQuery["sort"] = $sort;
        $this->EsQuery["from"] = $this->from;
        $this->EsQuery["size"] = $this->size;
        $this->EsQuery = json_encode($this->EsQuery);
    }

    public function makeFilters()
    {
        $results = json_decode($this->results["result"], 1);
        $aggregations = $results["aggregations"];

        $filters["AUTHOR"] = [];
        $filters["CATEGORY"] = [];
        $filters["COLLECTION"] = [];
        $filters["GROUP"] = [];

        $filters["SOURCE"] = $aggregations["object"]["buckets"];

        $videos_aggregations = [];
        $aggregations = $aggregations["byindex"]["buckets"];
        foreach ($aggregations as $key => $aggs) {
            if ($aggs['key'] == 'videos') {
                $videos_aggregations = $aggs;
            }
        }

        $authors_bucket = $videos_aggregations["author"]["buckets"];
        if (is_array($authors_bucket)) {
            foreach ($authors_bucket as $key => $author) {
                $authors_temp["id"] = $author["key"];
                $authors_temp["counts"] = $author["doc_count"];
                $platform_hits = $author["platform"]["hits"]["hits"];
                if (is_array($platform_hits) && !empty($platform_hits)) {
                    foreach ($platform_hits as $key => $hits) {
                        if ($hits["_source"]["userid"] == $author["key"]) {
                            $authors_temp["source"] = $hits["_source"];
                        }
                    }
                }
                $filters["AUTHOR"][] = $authors_temp;
            }
        }

        $categories_bucket = $videos_aggregations["category"]["buckets"];
        if (is_array($categories_bucket) && !empty($categories_bucket)) {
            foreach ($categories_bucket as $key => $category) {
                $categories_temp["id"] = $category["key"];
                $categories_temp["counts"] = $category["doc_count"];
                $platform_hits = $category["platform"]["hits"]["hits"];
                if (is_array($platform_hits) && !empty($platform_hits)) {
                    foreach ($platform_hits as $key => $hits) {
                        $category_source = $hits["_source"]["category"];
                        //pre($category_source,1);
                        if (is_array($category_source) && !empty($category_source)) {
                            foreach ($category_source as $key => $cat) {
                                if ($cat["id"] == $category["key"]) {
                                    $categories_temp["source"] = $cat["name"];
                                }
                            }
                        }
                    }
                }
                $filters["CATEGORY"][] = $categories_temp;
            }
        }

        $collections_bucket = $videos_aggregations["collections"]["buckets"];
        if (is_array($collections_bucket) && !empty($collections_bucket)) {
            foreach ($collections_bucket as $key => $collection) {
                $collection_temp["id"] = $collection["key"];
                $collection_temp["counts"] = $collection["doc_count"];
                $platform_hits = $collection["platform"]["hits"]["hits"];
                if (is_array($platform_hits) && !empty($platform_hits)) {
                    foreach ($platform_hits as $key => $hits) {
                        $collection_source = $hits["_source"]["collections"];
                        //pre($collection_source,1);
                        if (is_array($collection_source) && !empty($collection_source)) {
                            foreach ($collection_source as $key => $cat) {
                                if ($cat["id"] == $collection["key"]) {
                                    $collection_temp["source"] = $cat["name"];
                                }
                            }
                        }
                    }
                }
                $filters["COLLECTION"][] = $collection_temp;
            }
        }

        $groups_bucket = $videos_aggregations["groups"]["buckets"];
        if (is_array($groups_bucket) && !empty($groups_bucket)) {
            foreach ($groups_bucket as $key => $group) {
                $groups_temp["id"] = $group["key"];
                $groups_temp["counts"] = $group["doc_count"];
                $platform_hits = $group["platform"]["hits"]["hits"];
                if (is_array($platform_hits) && !empty($platform_hits)) {
                    foreach ($platform_hits as $key => $hits) {
                        $group_source = $hits["_source"]["groups"];
                        //pre($group_source,1);
                        if (is_array($group_source) && !empty($group_source)) {
                            foreach ($group_source as $key => $cat) {
                                if ($cat["id"] == $group["key"]) {
                                    $groups_temp["source"] = $cat["name"];
                                }
                            }
                        }
                    }
                }
                $filters["GROUP"][] = $groups_temp;
            }
        }
        return $filters;
    }

}
