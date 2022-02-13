-- Use this SQL script to upgrade from CB official to 5.X


-- upgrade_5.0.sql
UPDATE `{tbl_prefix}action_log` SET action_type = convert(cast(convert(action_type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}action_log` SET action_username = convert(cast(convert(action_username using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}action_log` SET action_useremail = convert(cast(convert(action_useremail using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}action_log` SET action_ip = convert(cast(convert(action_ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}action_log` SET action_details = convert(cast(convert(action_details using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}admin_notes` SET note = convert(cast(convert(note using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}admin_todo` SET todo = convert(cast(convert(todo using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}ads_data` SET ad_name = convert(cast(convert(ad_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}ads_data` SET ad_code = convert(cast(convert(ad_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}ads_data` SET ad_placement = convert(cast(convert(ad_placement using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}ads_placements` SET placement = convert(cast(convert(placement using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}ads_placements` SET placement_name = convert(cast(convert(placement_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collection_categories` SET category_name = convert(cast(convert(category_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collection_categories` SET category_desc = convert(cast(convert(category_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collection_categories` SET date_added = convert(cast(convert(date_added using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collection_items` SET type = convert(cast(convert(type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET collection_name = convert(cast(convert(collection_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET collection_description = convert(cast(convert(collection_description using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET collection_tags = convert(cast(convert(collection_tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET category = convert(cast(convert(category using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET featured = convert(cast(convert(featured using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET broadcast = convert(cast(convert(broadcast using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET allow_comments = convert(cast(convert(allow_comments using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET active = convert(cast(convert(active using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET public_upload = convert(cast(convert(public_upload using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}collections` SET type = convert(cast(convert(type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET type = convert(cast(convert(type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET comment = convert(cast(convert(comment using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET anonym_name = convert(cast(convert(anonym_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET anonym_email = convert(cast(convert(anonym_email using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET vote = convert(cast(convert(vote using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET voters = convert(cast(convert(voters using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET spam_voters = convert(cast(convert(spam_voters using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}comments` SET comment_ip = convert(cast(convert(comment_ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}config` SET name = convert(cast(convert(name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}config` SET value = convert(cast(convert(value using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}conversion_queue` SET cqueue_name = convert(cast(convert(cqueue_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}conversion_queue` SET cqueue_ext = convert(cast(convert(cqueue_ext using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}conversion_queue` SET cqueue_tmp_ext = convert(cast(convert(cqueue_tmp_ext using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}conversion_queue` SET time_started = convert(cast(convert(time_started using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}conversion_queue` SET time_completed = convert(cast(convert(time_completed using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}counters` SET section = convert(cast(convert(section using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}counters` SET query = convert(cast(convert(query using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}counters` SET query_md5 = convert(cast(convert(query_md5 using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}counters` SET date_added = convert(cast(convert(date_added using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}countries` SET iso2 = convert(cast(convert(iso2 using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}countries` SET name = convert(cast(convert(name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}countries` SET name_en = convert(cast(convert(name_en using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}countries` SET iso3 = convert(cast(convert(iso3 using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}email_templates` SET email_template_name = convert(cast(convert(email_template_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}email_templates` SET email_template_code = convert(cast(convert(email_template_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}email_templates` SET email_template_subject = convert(cast(convert(email_template_subject using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}email_templates` SET email_template = convert(cast(convert(email_template using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}email_templates` SET email_template_allowed_tags = convert(cast(convert(email_template_allowed_tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}favorites` SET type = convert(cast(convert(type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}flags` SET type = convert(cast(convert(type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_categories` SET category_name = convert(cast(convert(category_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_categories` SET category_desc = convert(cast(convert(category_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_categories` SET date_added = convert(cast(convert(date_added using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_categories` SET category_thumb = convert(cast(convert(category_thumb using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_posts` SET post_content = convert(cast(convert(post_content using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_topics` SET topic_title = convert(cast(convert(topic_title using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_topics` SET topic_post = convert(cast(convert(topic_post using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}group_topics` SET topic_icon = convert(cast(convert(topic_icon using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}groups` SET group_name = convert(cast(convert(group_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}groups` SET group_admins = convert(cast(convert(group_admins using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}groups` SET group_description = convert(cast(convert(group_description using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}groups` SET group_tags = convert(cast(convert(group_tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}groups` SET group_url = convert(cast(convert(group_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}groups` SET category = convert(cast(convert(category using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}languages` SET language_code = convert(cast(convert(language_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}languages` SET language_name = convert(cast(convert(language_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}languages` SET language_regex = convert(cast(convert(language_regex using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}mass_emails` SET email_subj = convert(cast(convert(email_subj using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}mass_emails` SET email_from = convert(cast(convert(email_from using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}mass_emails` SET email_msg = convert(cast(convert(email_msg using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}mass_emails` SET configs = convert(cast(convert(configs using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}mass_emails` SET users = convert(cast(convert(users using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}messages` SET message_to = convert(cast(convert(message_to using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}messages` SET message_content = convert(cast(convert(message_content using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}messages` SET message_attachments = convert(cast(convert(message_attachments using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}messages` SET message_subject = convert(cast(convert(message_subject using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}modules` SET module_name = convert(cast(convert(module_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}modules` SET module_file = convert(cast(convert(module_file using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}modules` SET active = convert(cast(convert(active using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}modules` SET module_include_file = convert(cast(convert(module_include_file using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}pages` SET page_name = convert(cast(convert(page_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}pages` SET page_title = convert(cast(convert(page_title using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}pages` SET page_content = convert(cast(convert(page_content using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET photo_key = convert(cast(convert(photo_key using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET photo_title = convert(cast(convert(photo_title using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET photo_description = convert(cast(convert(photo_description using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET photo_tags = convert(cast(convert(photo_tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET voters = convert(cast(convert(voters using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET filename = convert(cast(convert(filename using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET file_directory = convert(cast(convert(file_directory using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET ext = convert(cast(convert(ext using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET server_url = convert(cast(convert(server_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET owner_ip = convert(cast(convert(owner_ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}photos` SET photo_details = convert(cast(convert(photo_details using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}phrases` SET lang_iso = convert(cast(convert(lang_iso using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}phrases` SET varname = convert(cast(convert(varname using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}phrases` SET text = convert(cast(convert(text using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlist_items` SET playlist_item_type = convert(cast(convert(playlist_item_type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET playlist_name = convert(cast(convert(playlist_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET playlist_type = convert(cast(convert(playlist_type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET description = convert(cast(convert(description using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET tags = convert(cast(convert(tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET voters = convert(cast(convert(voters using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET last_update = convert(cast(convert(last_update using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET first_item = convert(cast(convert(first_item using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}playlists` SET cover = convert(cast(convert(cover using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugin_config` SET plugin_id_code = convert(cast(convert(plugin_id_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugin_config` SET plugin_config_name = convert(cast(convert(plugin_config_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugin_config` SET plugin_config_value = convert(cast(convert(plugin_config_value using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugin_config` SET player_admin_file = convert(cast(convert(player_admin_file using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugin_config` SET player_include_file = convert(cast(convert(player_include_file using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugins` SET plugin_file = convert(cast(convert(plugin_file using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugins` SET plugin_folder = convert(cast(convert(plugin_folder using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugins` SET plugin_license_type = convert(cast(convert(plugin_license_type using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugins` SET plugin_license_key = convert(cast(convert(plugin_license_key using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}plugins` SET plugin_license_code = convert(cast(convert(plugin_license_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET session = convert(cast(convert(session using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET session_string = convert(cast(convert(session_string using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET session_value = convert(cast(convert(session_value using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET ip = convert(cast(convert(ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET current_page = convert(cast(convert(current_page using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET referer = convert(cast(convert(referer using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}sessions` SET agent = convert(cast(convert(agent using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}stats` SET video_stats = convert(cast(convert(video_stats using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}stats` SET user_stats = convert(cast(convert(user_stats using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}stats` SET group_stats = convert(cast(convert(group_stats using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}subscriptions` SET subscribed_to = convert(cast(convert(subscribed_to using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}template` SET template_name = convert(cast(convert(template_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}template` SET template_dir = convert(cast(convert(template_dir using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_categories` SET category_name = convert(cast(convert(category_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_categories` SET category_desc = convert(cast(convert(category_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_categories` SET date_added = convert(cast(convert(date_added using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_categories` SET category_thumb = convert(cast(convert(category_thumb using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_levels` SET user_level_name = convert(cast(convert(user_level_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_levels_permissions` SET plugins_perms = convert(cast(convert(plugins_perms using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_permission_types` SET user_permission_type_name = convert(cast(convert(user_permission_type_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_permission_types` SET user_permission_type_desc = convert(cast(convert(user_permission_type_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_permissions` SET permission_name = convert(cast(convert(permission_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_permissions` SET permission_code = convert(cast(convert(permission_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_permissions` SET permission_desc = convert(cast(convert(permission_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET profile_title = convert(cast(convert(profile_title using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET profile_desc = convert(cast(convert(profile_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET featured_video = convert(cast(convert(featured_video using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET first_name = convert(cast(convert(first_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET last_name = convert(cast(convert(last_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET avatar = convert(cast(convert(avatar using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET postal_code = convert(cast(convert(postal_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET profile_tags = convert(cast(convert(profile_tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET web_url = convert(cast(convert(web_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET hometown = convert(cast(convert(hometown using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET city = convert(cast(convert(city using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET browse_criteria = convert(cast(convert(browse_criteria using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET about_me = convert(cast(convert(about_me using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET education = convert(cast(convert(education using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET schools = convert(cast(convert(schools using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET occupation = convert(cast(convert(occupation using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET companies = convert(cast(convert(companies using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET relation_status = convert(cast(convert(relation_status using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET hobbies = convert(cast(convert(hobbies using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET fav_movies = convert(cast(convert(fav_movies using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET fav_music = convert(cast(convert(fav_music using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET fav_books = convert(cast(convert(fav_books using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET background = convert(cast(convert(background using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET profile_item = convert(cast(convert(profile_item using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}user_profile` SET voters = convert(cast(convert(voters using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET featured_video = convert(cast(convert(featured_video using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET username = convert(cast(convert(username using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET user_session_key = convert(cast(convert(user_session_key using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET password = convert(cast(convert(password using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET email = convert(cast(convert(email using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET avatar = convert(cast(convert(avatar using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET avatar_url = convert(cast(convert(avatar_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET country = convert(cast(convert(country using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET avcode = convert(cast(convert(avcode using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET session = convert(cast(convert(session using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET ip = convert(cast(convert(ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET signup_ip = convert(cast(convert(signup_ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET upload = convert(cast(convert(upload using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET background = convert(cast(convert(background using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET background_color = convert(cast(convert(background_color using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET background_url = convert(cast(convert(background_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}users` SET banned_users = convert(cast(convert(banned_users using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}validation_re` SET re_name = convert(cast(convert(re_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}validation_re` SET re_code = convert(cast(convert(re_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}validation_re` SET re_syntax = convert(cast(convert(re_syntax using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET videokey = convert(cast(convert(videokey using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET video_password = convert(cast(convert(video_password using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET video_users = convert(cast(convert(video_users using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET username = convert(cast(convert(username using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET title = convert(cast(convert(title using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET file_name = convert(cast(convert(file_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET file_directory = convert(cast(convert(file_directory using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET description = convert(cast(convert(description using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET tags = convert(cast(convert(tags using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET category = convert(cast(convert(category using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET category_parents = convert(cast(convert(category_parents using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET broadcast = convert(cast(convert(broadcast using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET location = convert(cast(convert(location using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET country = convert(cast(convert(country using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET allow_embedding = convert(cast(convert(allow_embedding using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET rated_by = convert(cast(convert(rated_by using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET voter_ids = convert(cast(convert(voter_ids using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET allow_comments = convert(cast(convert(allow_comments using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET comment_voting = convert(cast(convert(comment_voting using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET featured = convert(cast(convert(featured using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET featured_description = convert(cast(convert(featured_description using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET allow_rating = convert(cast(convert(allow_rating using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET active = convert(cast(convert(active using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET favourite_count = convert(cast(convert(favourite_count using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET playlist_count = convert(cast(convert(playlist_count using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET flagged = convert(cast(convert(flagged using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET duration = convert(cast(convert(duration using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET aspect_ratio = convert(cast(convert(aspect_ratio using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET embed_code = convert(cast(convert(embed_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET refer_url = convert(cast(convert(refer_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET uploader_ip = convert(cast(convert(uploader_ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET unique_embed_code = convert(cast(convert(unique_embed_code using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET remote_play_url = convert(cast(convert(remote_play_url using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET server_ip = convert(cast(convert(server_ip using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET file_server_path = convert(cast(convert(file_server_path using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET files_thumbs_path = convert(cast(convert(files_thumbs_path using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET file_thumbs_count = convert(cast(convert(file_thumbs_count using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET filegrp_size = convert(cast(convert(filegrp_size using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET video_version = convert(cast(convert(video_version using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET extras = convert(cast(convert(extras using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video` SET thumbs_version = convert(cast(convert(thumbs_version using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_categories` SET category_name = convert(cast(convert(category_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_categories` SET category_desc = convert(cast(convert(category_desc using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_categories` SET date_added = convert(cast(convert(date_added using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_categories` SET category_thumb = convert(cast(convert(category_thumb using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET file_conversion_log = convert(cast(convert(file_conversion_log using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET encoder = convert(cast(convert(encoder using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET command_used = convert(cast(convert(command_used using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_path = convert(cast(convert(src_path using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_name = convert(cast(convert(src_name using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_ext = convert(cast(convert(src_ext using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_format = convert(cast(convert(src_format using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_duration = convert(cast(convert(src_duration using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_size = convert(cast(convert(src_size using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_bitrate = convert(cast(convert(src_bitrate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_width = convert(cast(convert(src_video_width using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_height = convert(cast(convert(src_video_height using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_wh_ratio = convert(cast(convert(src_video_wh_ratio using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_codec = convert(cast(convert(src_video_codec using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_rate = convert(cast(convert(src_video_rate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_bitrate = convert(cast(convert(src_video_bitrate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_video_color = convert(cast(convert(src_video_color using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_audio_codec = convert(cast(convert(src_audio_codec using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_audio_bitrate = convert(cast(convert(src_audio_bitrate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_audio_rate = convert(cast(convert(src_audio_rate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET src_audio_channels = convert(cast(convert(src_audio_channels using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_path = convert(cast(convert(output_path using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_format = convert(cast(convert(output_format using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_duration = convert(cast(convert(output_duration using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_size = convert(cast(convert(output_size using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_bitrate = convert(cast(convert(output_bitrate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_width = convert(cast(convert(output_video_width using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_height = convert(cast(convert(output_video_height using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_wh_ratio = convert(cast(convert(output_video_wh_ratio using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_codec = convert(cast(convert(output_video_codec using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_rate = convert(cast(convert(output_video_rate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_bitrate = convert(cast(convert(output_video_bitrate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_video_color = convert(cast(convert(output_video_color using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_audio_codec = convert(cast(convert(output_audio_codec using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_audio_bitrate = convert(cast(convert(output_audio_bitrate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_audio_rate = convert(cast(convert(output_audio_rate using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_files` SET output_audio_channels = convert(cast(convert(output_audio_channels using  latin1) as binary) using utf8);
UPDATE `{tbl_prefix}video_views` SET video_id = convert(cast(convert(video_id using  latin1) as binary) using utf8);

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
('password_salt', SUBSTRING(HEX(SHA2(CONCAT(NOW(), RAND(), UUID()), 512)),1, 32) ),
('show_collapsed_checkboxes', '0'),
('enable_advertisement', 'no'),
('chromecast', 'no'),
('vid_cat_width', '120'),
('vid_cat_height', '120');

ALTER TABLE `{tbl_prefix}users` CHANGE `password` `password` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}user_levels_permissions` ADD `view_photos` ENUM('yes', 'no') NOT NULL DEFAULT 'yes' AFTER `view_video`;
ALTER TABLE `{tbl_prefix}user_levels_permissions` ADD `view_collections` ENUM('yes', 'no') NOT NULL DEFAULT 'yes' AFTER `view_photos`;

INSERT INTO `{tbl_prefix}user_permissions` (`permission_type`, `permission_name`, `permission_code`, `permission_desc`, `permission_default`) VALUES
(1, 'View Photos Page', 'view_photos', 'User can view photos page', 'yes'),
(1, 'View Collections Page', 'view_collections', 'User can view collections page', 'yes');

-- Upgrade_5.1.sql
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('chromecast_fix', '1');

UPDATE `{tbl_prefix}config` SET name = 'allowed_video_types' WHERE name = 'allowed_types';
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('allowed_photo_types', 'jpg,jpeg,png');

DELETE FROM `{tbl_prefix}config` WHERE name = 'users_items_subscribers';

UPDATE `{tbl_prefix}config` SET value = CONCAT(value, ',mkv') WHERE name = 'allowed_video_types' AND value NOT LIKE '%mkv%';
UPDATE `{tbl_prefix}config` SET value = CONCAT(value, ',webm') WHERE name = 'allowed_video_types' AND value NOT LIKE '%webm%';

DELETE FROM `{tbl_prefix}config` WHERE name IN(
	'max_topic_title',
	'max_topic_length',
	'groups_list_per_page',
	'grps_items_search_page',
	'users_items_group_page',
	'videos_items_grp_page');

-- upgrade_5.3.sql
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('logo_name', ''),
	('favicon_name', ''),
	('comment_per_page', '10'),
	('force_8bits', '1'),
	('bits_color_warning', '1'),
	('control_bar_logo', 'yes'),
	('contextual_menu_disabled', ''),
	('control_bar_logo_url', '/images/icons/player-logo.png'),
	('player_thumbnails', 'yes'),
	('enable_update_checker', '1');

ALTER TABLE `{tbl_prefix}user_levels_permissions` MODIFY COLUMN `plugins_perms` text NULL DEFAULT NULL;
ALTER TABLE `{tbl_prefix}users`
    MODIFY COLUMN `featured_video` mediumtext DEFAULT '' NOT NULL,
    MODIFY COLUMN `avatar_url` text DEFAULT '' NOT NULL,
    MODIFY COLUMN `featured_date` DATETIME NULL DEFAULT NULL,
	MODIFY COLUMN `total_videos` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_comments` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_photos` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_collections` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `comments_count` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
	MODIFY COLUMN `total_subscriptions` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `background` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `background_color` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `background_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `total_groups` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `banned_users` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `total_downloads` BIGINT(255) NOT NULL DEFAULT '0';

DELETE FROM `{tbl_prefix}config` WHERE name = 'i_magick';

ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `username` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `category_parents` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `blocked_countries` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `voter_ids` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
	MODIFY COLUMN `featured_date` DATETIME NULL DEFAULT NULL,
	MODIFY COLUMN `featured_description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `aspect_ratio` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `embed_code` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `refer_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `downloads` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `unique_embed_code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `remote_play_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `video_files` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `server_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `file_server_path` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `files_thumbs_path` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `file_thumbs_count` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `filegrp_size` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `extras` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `re_conv_status` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `conv_progress` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}video`
	ADD `is_castable` BOOLEAN NOT NULL DEFAULT FALSE,
	ADD `bits_color` tinyint(4) DEFAULT NULL;

ALTER TABLE `{tbl_prefix}user_profile`
	MODIFY COLUMN `user_profile_id` INT(11) NOT NULL AUTO_INCREMENT,
	MODIFY COLUMN `fb_url` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
	MODIFY COLUMN `twitter_url` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
	MODIFY COLUMN `insta_url` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}photos`
	MODIFY COLUMN `views` BIGINT(255) NOT NULL DEFAULT '0',
    MODIFY COLUMN `total_comments` INT(255) NOT NULL DEFAULT '0',
    MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
    MODIFY COLUMN `total_favorites` INT(255) NOT NULL DEFAULT '0',
    MODIFY COLUMN `rating` INT(15) NOT NULL DEFAULT '0',
	MODIFY COLUMN `rated_by` INT(25) NOT NULL DEFAULT '0',
    MODIFY COLUMN `voters` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
    MODIFY COLUMN `downloaded` BIGINT(255) NOT NULL DEFAULT '0',
    MODIFY COLUMN `server_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `photo_details` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}collections`
    MODIFY COLUMN `views` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_comments` BIGINT(20) NOT NULL DEFAULT '0',
    MODIFY COLUMN `last_commented` DATETIME NULL,
    MODIFY COLUMN `total_objects` BIGINT(20) NOT NULL DEFAULT '0',
    MODIFY COLUMN `rating` BIGINT(20) NOT NULL DEFAULT '0',
    MODIFY COLUMN `rated_by` BIGINT(20) NOT NULL DEFAULT '0',
    MODIFY COLUMN `voters` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}action_log`
    MODIFY COLUMN `action_success` ENUM('yes','no') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}comments`
	MODIFY `vote` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY `voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY `spam_votes` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY `spam_voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

-- upgrade_5.3.1.sql
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('enable_update_checker', '1');

ALTER TABLE `{tbl_prefix}user_profile`
	MODIFY COLUMN `user_profile_id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}plugins`
	MODIFY COLUMN `plugin_version` FLOAT NOT NULL DEFAULT '0';

-- upgrade_5.4.0.sql
DELETE FROM `{tbl_prefix}config` WHERE `name` IN (
	'cb_license'
	,'cb_license_local'
	,'use_ffmpeg_vf'
	,'buffer_time'
	,'server_friendly_conversion'
	,'cbhash'
	,'enable_troubleshooter'
	,'debug_level'
	,'sys_os'
	,'con_modules_type'
	,'version_type'
	,'version'
	,'user_comment_opt1'
	,'user_comment_opt2'
	,'user_comment_opt3'
	,'user_comment_opt4'
	,'ffmpeg_type'
	,'date_released'
	,'stream_via'
	,'use_watermark'
	,'hq_output'
	,'date_installed'
	,'date_updated'
	,'max_topic_length'
	,'default_time_zone'
	,'user_max_chr'
	,'captcha_type'
	,'user_rate_opt1'
	,'max_time_wait'
	,'index_featured'
	,'index_recent'
	,'videos_items_columns'
);

DROP TABLE `{tbl_prefix}modules`;

ALTER TABLE `{tbl_prefix}contacts` MODIFY COLUMN `contact_group_id` INT(255) NOT NULL DEFAULT '0';

ALTER TABLE `{tbl_prefix}ads_data`
	MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	DROP `ad_category`;

ALTER TABLE `{tbl_prefix}video_categories`
	MODIFY COLUMN `category_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	MODIFY COLUMN `category_thumb` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}collection_categories`
	MODIFY COLUMN `category_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `category_order` INT(5) NOT NULL DEFAULT '0',
	MODIFY COLUMN `category_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	MODIFY COLUMN `category_thumb` MEDIUMINT(9) NOT NULL DEFAULT '0',
	MODIFY COLUMN `isdefault` ENUM('yes','no') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';

ALTER TABLE `{tbl_prefix}playlists`
	MODIFY COLUMN `playlist_name` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `userid` INT(11) NOT NULL DEFAULT '0',
	MODIFY COLUMN `playlist_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `tags` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `total_comments` INT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_items` INT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `rating` INT(3) NOT NULL DEFAULT '0',
	MODIFY COLUMN `rated_by` INT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `last_update` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `runtime` INT(200) NOT NULL DEFAULT '0',
	MODIFY COLUMN `first_item` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `cover` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `played` INT(255) NOT NULL DEFAULT '0';

-- upgrade_5.4.1.sql
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('email_domain_restriction', ''),
	('proxy_enable', 'no'),
	('proxy_auth', 'no'),
	('proxy_url', ''),
	('proxy_port', ''),
	('proxy_username', ''),
	('proxy_password', '');

DELETE FROM `{tbl_prefix}config` WHERE name IN('mp4boxpath','quick_conv');

UPDATE `{tbl_prefix}config` SET value = 'no' WHERE name = 'enable_advertisement' AND value = '0';

ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `video_password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `userid` INT(11) NULL DEFAULT NULL,
	MODIFY COLUMN `file_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `uploader_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `file_directory` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}comments`
	MODIFY COLUMN `userid` int(60) NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}plugins`
	MODIFY COLUMN `plugin_version` VARCHAR(32) NOT NULL;

ALTER TABLE `{tbl_prefix}users`
	DROP `background_attachement`;

ALTER TABLE `{tbl_prefix}user_profile`
	MODIFY COLUMN `avatar` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_avatar.png';

ALTER TABLE `{tbl_prefix}user_categories`
	MODIFY COLUMN `category_thumb` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}photos`
	MODIFY COLUMN `server_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `photo_details` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}action_log`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}ads_data`
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}collection_categories`
	MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}comments`
	MODIFY COLUMN `voters` text NULL DEFAULT NULL,
	MODIFY COLUMN `spam_voters` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}conversion_queue`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_categories`
	MODIFY COLUMN `date_added` datetime NOT NULL;

ALTER TABLE `{tbl_prefix}group_invitations`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_members`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_videos`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}messages`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}photos`
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    MODIFY COLUMN `server_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `photo_details` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}playlists`
	MODIFY COLUMN `voters` text NULL DEFAULT NULL,
	MODIFY COLUMN `last_update` text NULL DEFAULT NULL,
	MODIFY COLUMN `first_item` text NULL DEFAULT NULL,
	MODIFY COLUMN `cover` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    MODIFY COLUMN `description` mediumtext NOT NULL,
    MODIFY COLUMN `tags` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}playlist_items`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}subscriptions`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}users`
	MODIFY COLUMN `avatar_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `dob` date NOT NULL DEFAULT '1000-01-01',
	MODIFY COLUMN `doj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	MODIFY COLUMN `last_logged` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
	MODIFY COLUMN `last_active` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
    MODIFY COLUMN `featured_video` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}user_categories`
	MODIFY COLUMN `date_added` datetime NOT NULL,
	MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `username` text NULL DEFAULT NULL,
	MODIFY COLUMN `category_parents` text NULL DEFAULT NULL,
	MODIFY COLUMN `blocked_countries` text NULL DEFAULT NULL,
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	MODIFY COLUMN `embed_code` text NULL DEFAULT NULL,
	MODIFY COLUMN `refer_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `remote_play_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `video_files` tinytext NULL DEFAULT NULL,
	MODIFY COLUMN `file_server_path` text NULL DEFAULT NULL,
	MODIFY COLUMN `files_thumbs_path` text NULL DEFAULT NULL,
	MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT '5.4.1',
	MODIFY COLUMN `thumbs_version` varchar(5) NOT NULL DEFAULT '5.4.1',
	MODIFY COLUMN `re_conv_status` tinytext NULL DEFAULT NULL,
	MODIFY COLUMN `conv_progress` text NULL DEFAULT NULL,
    DROP COLUMN `flv`,
    DROP COLUMN `flv_file_url`,
    MODIFY COLUMN `voter_ids` mediumtext NOT NULL,
    MODIFY COLUMN `featured_description` mediumtext NOT NULL,
	MODIFY COLUMN `videokey` MEDIUMTEXT NULL DEFAULT NULL,
	MODIFY COLUMN `video_users` TEXT NOT NULL,
	MODIFY COLUMN `tags` MEDIUMTEXT NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}video_categories`
	MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NULL DEFAULT NULL,
	MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video_favourites`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE `{tbl_prefix}video_resolution` (
	`id_video_resolution` int(11) NOT NULL,
	`title` varchar(32) NOT NULL DEFAULT '',
	`ratio` varchar(8) NOT NULL DEFAULT '',
	`enabled` tinyint(1) NOT NULL DEFAULT 1,
	`width` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`height` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`video_bitrate` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_resolution`
	ADD PRIMARY KEY (`id_video_resolution`),
	ADD UNIQUE KEY `title` (`title`);

ALTER TABLE `{tbl_prefix}video_resolution`
	MODIFY `id_video_resolution` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `{tbl_prefix}video_resolution` (`title`, `ratio`, `enabled`, `width`, `height`, `video_bitrate`) VALUES
	('240p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 0 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_240') END), 428, 240, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_240')),
	('360p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 1 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_360') END), 640, 360, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_360')),
	('480p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 0 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_480') END), 854, 480, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_480')),
	('720p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 1 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_720') END), 1280, 720, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_720')),
	('1080p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 0 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_1080') END), 1920, 1080, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_1080')),
	('1440p', '16/9', 0, 2560, 1440, 7280000),
	('2160p', '16/9', 0, 4096, 2160, 17472000);

DELETE FROM `{tbl_prefix}config` WHERE name IN('gen_240','gen_360','gen_480','gen_720','gen_1080','cb_combo_res','vbrate','vbrate_hd','vbrate_240','vbrate_360','vbrate_480','vbrate_720','vbrate_1080');

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('player_default_resolution', '360');

ALTER TABLE `{tbl_prefix}user_profile`
	MODIFY COLUMN `profile_video` int(255) NOT NULL DEFAULT 0,
	MODIFY COLUMN `profile_item` varchar(25) NOT NULL DEFAULT '',
	MODIFY COLUMN `rating` tinyint(2) NOT NULL DEFAULT 0,
	MODIFY COLUMN `rated_by` int(150) NOT NULL DEFAULT 0;

ALTER TABLE `{tbl_prefix}_video`
	MODIFY COLUMN `datecreated` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP;
UPDATE `{tbl_prefix}_video` SET datecreated = '1000-01-01' WHERE datecreated = '0000-00-00';

-- upgrade_5.5.0.sql
-- REV 3
DELETE FROM `{tbl_prefix}config` WHERE name IN('keep_original');

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('keep_audio_tracks', '1'),
	('keep_subtitles', '1');

-- REV 4
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('extract_subtitles', '1');

CREATE TABLE `{tbl_prefix}video_subtitle` (
	`videoid` bigint(20) NOT NULL,
	`number` varchar(2) NOT NULL,
	`title` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_subtitle`
	ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_subtitle`
	ADD CONSTRAINT `{tbl_prefix}video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

-- REV 5
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('extract_audio_tracks', '1');

CREATE TABLE `{tbl_prefix}video_audio_tracks` (
	`videoid` bigint(20) NOT NULL,
	`number` varchar(2) NOT NULL,
	`title` varchar(64) NOT NULL,
	`channels` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_audio_tracks`
	ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_audio_tracks`
	ADD CONSTRAINT `{tbl_prefix}video_audio_tracks_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

-- REV 6
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('player_subtitles', '1'),
	('subtitle_format', 'webvtt');

-- REV 7
DELETE FROM `{tbl_prefix}config` WHERE name = 'extract_audio_tracks';
DROP TABLE `{tbl_prefix}video_audio_tracks`;

-- REV 8
ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN filegrp_size,
	DROP COLUMN file_thumbs_count,
	DROP COLUMN conv_progress,
	DROP COLUMN is_hd,
	MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT '5.5.0',
	MODIFY COLUMN `thumbs_version` varchar(5) NOT NULL DEFAULT '5.5.0',
    DROP COLUMN has_hd,
    DROP COLUMN has_mobile,
    DROP COLUMN has_hq,
    DROP COLUMN extras,
    DROP COLUMN mass_embed_status,
	MODIFY COLUMN `file_type` VARCHAR(3) NULL DEFAULT NULL;

UPDATE `{tbl_prefix}video` SET file_type = 'mp4';

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('conversion_type', 'mp4');

-- REV 9
DELETE FROM `{tbl_prefix}config` WHERE name IN(
	'high_resolution'
	,'normal_resolution'
	,'videos_list_per_tab'
	,'channels_list_per_tab'
	,'code_dev'
	,'player_div_id'
	,'channel_player_width'
	,'channel_player_height'
	,'use_crons'
    ,'grp_max_title'
    ,'grp_max_desc'
    ,'grp_thumb_width'
    ,'grp_thumb_height'
    ,'grp_categories'
    ,'max_bg_height'
    ,'max_profile_pic_height'
);

-- REV 36
ALTER TABLE `{tbl_prefix}collection_categories`
	MODIFY COLUMN `category_thumb` MEDIUMTEXT NOT NULL;

-- REV 43
ALTER TABLE `{tbl_prefix}collections`
    ADD `collection_id_parent` BIGINT(25) NULL DEFAULT NULL AFTER `collection_id`,
	ADD INDEX(`collection_id_parent`),
	ADD FOREIGN KEY (`collection_id_parent`) REFERENCES `{tbl_prefix}collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('enable_sub_collection', '1');
