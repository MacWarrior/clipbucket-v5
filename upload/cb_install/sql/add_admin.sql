INSERT INTO `{tbl_prefix}users` (`userid`, `featured_video`, `username`, `user_session_key`, `user_session_code`, `password`, `email`, `usr_status`, `msg_notify`, `avatar`, `avatar_url`, `sex`, `dob`, `country`, `level`, `avcode`, `doj`, `last_logged`, `num_visits`, `session`, `ip`, `signup_ip`, `time_zone`, `featured`, `featured_date`, `profile_hits`, `total_watched`, `total_videos`, `total_comments`, `total_photos`, `total_collections`, `comments_count`, `last_commented`, `ban_status`, `upload`, `subscribers`, `total_subscriptions`, `background`, `background_color`, `background_url`, `background_repeat`, `last_active`, `banned_users`, `welcome_email_sent`, `total_downloads`) VALUES
(1, '', 'admin', '777750fea4d3bd585bf47dc1873619fc', 10192, '777750fea4d3bd585bf47dc1873619fc', 'webmaster@website', 'Ok', 'yes', '0', '', 'male', '1989-10-14', 'PK', 1, '08c5a7bd48', CURRENT_TIMESTAMP, '2011-02-10 10:22:41', 86, 'pub6e7fq5oj76vakuov2j03hm1', '127.0.0.1', '', 0, 'No', '2009-12-03 15:14:20', 0, 0, 0, 0, 0, 0, 0, '2011-02-07 12:56:46', 'no', '0', 0, 1, '0', '#ed0000', '', 'no-repeat', '2011-02-14 08:43:25', '', 'yes', 0);

SET @type_category = (
    SELECT id_category_type
    FROM `{tbl_prefix}categories_type`
    WHERE name LIKE 'user'
);

INSERT INTO `{tbl_prefix}users_categories` (id_user, id_category)
 ( SELECT 1, category_id FROM `{tbl_prefix}categories` WHERE id_category_type = @type_category AND category_name LIKE 'Gurus' LIMIT 1);

INSERT INTO `{tbl_prefix}user_profile` (`user_profile_id`, `show_my_collections`, `userid`, `profile_title`, `profile_desc`, `featured_video`, `first_name`, `last_name`, `show_dob`, `postal_code`, `time_zone`, `web_url`, `hometown`, `city`, `online_status`, `show_profile`, `allow_comments`, `allow_ratings`, `allow_subscription`, `content_filter`, `icon_id`, `browse_criteria`, `about_me`, `education`, `schools`, `occupation`, `companies`, `relation_status`, `hobbies`, `fav_movies`, `fav_music`, `fav_books`, `background`, `rating`, `voters`, `rated_by`, `show_my_videos`, `show_my_photos`, `show_my_subscriptions`, `show_my_subscribers`, `show_my_friends`) VALUES
(1, 'yes', 1, '', '', '', '', '', 'yes', '', 0, '', '', '', 'online', 'all', 'yes', 'yes', 'yes', 'Nothing', 0, NULL, '', '0', '', '', '', '0', '', '', '', '', '', 0, '', 2, 'yes', 'yes', 'yes', 'yes', 'yes');
