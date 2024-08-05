<?php

namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00160 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}languages_keys`(
            `id_language_key` INT          NOT NULL AUTO_INCREMENT,
            `language_key`    VARCHAR(256) NOT NULL,
            PRIMARY KEY (`id_language_key`),
            UNIQUE (`language_key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}languages_translations`(
            `language_id`     INT(11)      NOT NULL,
            `id_language_key` INT(11)      NOT NULL,
            `translation`     VARCHAR(1024) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages_translations` ADD PRIMARY KEY (`language_id`, `id_language_key`), ADD KEY `language_id` (`language_id`), ADD KEY `id_language_key` (`id_language_key`);', [
            'table'   => 'languages_translations',
            'columns' => [
                'language_id',
                'id_language_key'
            ]
        ], [
            'table'           => 'languages_translations',
            'constraint_name' => 'PRIMARY',
            'constraint_type' => 'PRIMARY KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages_translations` ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'languages_translations',
            'column' => 'language_id'
        ], [
            'constraint_name' => 'languages_translations_ibfk_1',
            'contraint_type'  => 'FOREIGN KEY'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages_translations` ADD CONSTRAINT `languages_translations_ibfk_2` FOREIGN KEY (`id_language_key`) REFERENCES `{tbl_prefix}languages_keys` (`id_language_key`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'languages_translations',
            'column' => 'id_language_key'
        ], [
            'constraint_name' => 'languages_translations_ibfk_2',
            'contraint_type'  => 'FOREIGN KEY'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key) VALUES (\'ad_name_error\'), (\'ad_code_error\'), (\'ad_exists_error1\'), (\'ad_exists_error2\'), (\'ad_add_msg\'), (\'ad_msg\'), (\'ad_update_msg\'), (\'ad_del_msg\'), (\'ad_deactive\'), (\'ad_active\'), (\'ad_placment_delete_msg\'), (\'ad_placement_err1\'), (\'ad_placement_err2\'), (\'ad_placement_err3\'), (\'ad_placement_msg\'), (\'cat_img_error\'), (\'cat_exist_error\'), (\'cat_add_msg\'), (\'cat_update_msg\'), (\'grp_err\'), (\'grp_fr_msg\'), (\'grp_fr_msg1\'), (\'grp_ac_msg\'), (\'grp_dac_msg\'), (\'grp_del_msg\'), (\'editor_pic_up\'), (\'editor_pic_down\'), (\'plugin_install_msg\'), (\'plugin_no_file_err\'), (\'plugin_file_detail_err\'), (\'plugin_installed_err\'), (\'plugin_no_install_err\'), (\'grp_name_error\'), (\'grp_name_error1\'), (\'grp_des_error\'), (\'grp_tags_error\'), (\'grp_url_error\'), (\'grp_url_error1\'), (\'grp_url_error2\'), (\'grp_tpc_error\'), (\'grp_comment_error\'), (\'grp_join_error\'), (\'grp_prvt_error\'), (\'grp_inact_error\'), (\'grp_join_error1\'), (\'grp_exist_error\'), (\'grp_tpc_error1\'), (\'grp_cat_error\'), (\'grp_tpc_error2\'), (\'grp_tpc_error3\'), (\'grp_tpc_msg\'), (\'grp_comment_msg\'), (\'grp_vdo_msg\'), (\'grp_vdo_msg1\'), (\'grp_vdo_msg2\'), (\'grp_mem_msg\'), (\'grp_mem_msg1\'), (\'grp_inv_msg\'), (\'grp_tpc_msg1\'), (\'grp_tpc_msg2\'), (\'grp_fr_msg2\'), (\'grp_inv_msg1\'), (\'grp_av_msg\'), (\'grp_da_msg\'), (\'grp_post_msg\'), (\'grp_update_msg\'), (\'grp_owner_err\'), (\'grp_owner_err1\'), (\'grp_owner_err2\'), (\'grp_prvt_err1\'), (\'grp_rmv_msg\'), (\'grp_tpc_err4\'), (\'grp_title_topic\'), (\'grp_add_title\'), (\'usr_sadmin_err\'), (\'usr_cpass_err\'), (\'usr_pass_err\'), (\'usr_email_err\'), (\'usr_cpass_err1\'), (\'usr_pass_err1\'), (\'usr_cmt_err\'), (\'usr_cmt_err1\'), (\'usr_cmt_err2\'), (\'usr_cmt_err3\'), (\'usr_cmt_err4\'), (\'usr_cmt_del_msg\'), (\'usr_cmt_del_err\'), (\'usr_cnt_err\'), (\'usr_cnt_err1\'), (\'usr_sub_err\'), (\'usr_exist_err\'), (\'usr_ccode_err\'), (\'usr_exist_err1\'), (\'usr_exist_err2\'), (\'usr_uname_err\'), (\'usr_uname_err2\'), (\'usr_pass_err2\'), (\'usr_email_err1\'), (\'usr_email_err2\'), (\'usr_email_err3\'), (\'usr_pcode_err\'), (\'usr_fname_err\'), (\'usr_lname_err\'), (\'usr_uname_err3\'), (\'usr_pass_err3\'), (\'usr_dob_err\'), (\'usr_ament_err\'), (\'usr_reg_err\'), (\'usr_ban_err\'), (\'usr_login_err\'), (\'usr_sadmin_msg\'), (\'usr_pass_msg\'), (\'usr_cnt_msg\'), (\'usr_sub_msg\'), (\'usr_uname_email_msg\'), (\'usr_rpass_email_msg\'), (\'usr_pass_email_msg\'), (\'usr_email_msg\'), (\'usr_del_msg\'), (\'usr_dels_msg\'), (\'usr_ac_msg\'), (\'usr_dac_msg\'), (\'usr_mem_ac\'), (\'usr_mems_ac\'), (\'usr_fr_msg\'), (\'usr_ufr_msg\'), (\'usr_frs_msg\'), (\'usr_ufrs_msg\'), (\'usr_uban_msg\'), (\'usr_uuban_msg\'), (\'usr_ubans_msg\'), (\'usr_uubans_msg\'), (\'usr_pass_reset_conf\'), (\'usr_dear_user\'), (\'usr_pass_reset_msg\'), (\'usr_rpass_msg\'), (\'usr_rpass_req_msg\'), (\'usr_uname_req_msg\'), (\'usr_uname_recovery\'), (\'usr_add_succ_msg\'), (\'usr_upd_succ_msg\'), (\'usr_activation_msg\'), (\'usr_activation_err\'), (\'usr_activation_em_msg\'), (\'usr_activation_em_err\'), (\'usr_no_msg_del_err\'), (\'usr_sel_msg_del_msg\'), (\'usr_pof_upd_msg\'), (\'usr_arr_no_ans\'), (\'usr_arr_elementary\'), (\'usr_arr_hi_school\'), (\'usr_arr_some_colg\'), (\'usr_arr_assoc_deg\'), (\'usr_arr_bach_deg\'), (\'usr_arr_mast_deg\'), (\'usr_arr_phd\'), (\'usr_arr_post_doc\'), (\'usr_arr_single\'), (\'usr_arr_married\'), (\'usr_arr_comitted\'), (\'usr_arr_open_marriage\'), (\'usr_arr_open_relate\'), (\'title_crt_new_msg\'), (\'title_forgot\'), (\'title_inbox\'), (\'title_sent\'), (\'title_usr_contact\'), (\'title_usr_fav_vids\'), (\'title_edit_video\'), (\'vdo_title_err\'), (\'vdo_des_err\'), (\'vdo_tags_err\'), (\'vdo_cat_err\'), (\'vdo_cat_err1\'), (\'vdo_sub_email_msg\'), (\'vdo_has_upload_nv\'), (\'vdo_del_selected\'), (\'vdo_cheat_msg\'), (\'vdo_limits_warn_msg\'), (\'vdo_cmt_del_msg\'), (\'vdo_iac_msg\'), (\'vdo_is_in_process\'), (\'vdo_upload_allow_err\'), (\'vdo_download_allow_err\'), (\'vdo_edit_owner_err\'), (\'vdo_embed_code_wrong\'), (\'vdo_seconds_err\'), (\'vdo_mins_err\'), (\'vdo_thumb_up_err\'), (\'class_error_occured\'), (\'class_cat_del_msg\'), (\'class_vdo_del_msg\'), (\'class_vdo_fr_msg\'), (\'class_fr_msg1\'), (\'class_vdo_act_msg\'), (\'class_vdo_act_msg1\'), (\'class_vdo_update_msg\'), (\'class_comment_err\'), (\'class_comment_err1\'), (\'class_comment_err2\'), (\'class_comment_err3\'), (\'class_comment_err4\'), (\'class_comment_err5\'), (\'class_comment_msg\'), (\'class_comment_err6\'), (\'class_comment_err7\'), (\'class_vdo_fav_err\'), (\'class_vdo_fav_msg\'), (\'class_vdo_flag_err\'), (\'class_vdo_flag_msg\'), (\'class_vdo_flag_rm\'), (\'class_send_msg_err\'), (\'class_invalid_user\'), (\'class_subj_err\'), (\'class_msg_err\'), (\'class_sent_you_msg\'), (\'class_sent_prvt_msg\'), (\'class_click_inbox\'), (\'class_click_login\'), (\'class_email_notify\'), (\'class_msg_has_sent_to\'), (\'class_inbox_del_msg\'), (\'class_sent_del_msg\'), (\'class_msg_exist_err\'), (\'class_vdo_del_err\'), (\'class_unsub_msg\'), (\'class_sub_exist_err\'), (\'class_vdo_rm_fav_msg\'), (\'class_vdo_fav_err1\'), (\'class_cont_del_msg\'), (\'class_cot_err\'), (\'class_vdo_ep_err1\'), (\'class_vdo_exist_err\'), (\'class_img_gif_err\'), (\'class_img_png_err\'), (\'class_img_jpg_err\'), (\'class_logo_msg\'), (\'com_forgot_username\'), (\'com_join_now\'), (\'com_my_account\'), (\'com_manage_vids\'), (\'com_view_channel\'), (\'com_my_inbox\'), (\'com_welcome\'), (\'com_top_mem\'), (\'com_vidz\'), (\'com_sign_up_now\'), (\'com_my_videos\'), (\'com_my_channel\'), (\'com_my_subs\'), (\'com_user_no_contacts\'), (\'com_user_no_vides\'), (\'com_user_no_vid_com\'), (\'com_view_all_contacts\'), (\'com_view_fav_all_videos\'), (\'com_login_success_msg\'), (\'com_logout_success_msg\'), (\'com_not_redirecting\'), (\'com_not_redirecting_msg\'), (\'com_manage_contacts\'), (\'com_send_message\'), (\'com_manage_fav\'), (\'com_manage_subs\'), (\'com_subscribe_to\'), (\'com_total_subs\'), (\'com_total_vids\'), (\'com_date_subscribed\'), (\'com_search_results\'), (\'com_advance_results\'), (\'com_search_results_in\'), (\'videos_being_watched\'), (\'latest_added_videos\'), (\'most_viewed\'), (\'recently_added\'), (\'featured\'), (\'highest_rated\'), (\'most_discussed\'), (\'style_change\'), (\'rss_feed_latest_title\'), (\'rss_feed_featured_title\'), (\'rss_feed_most_viewed_title\'), (\'lang_folder\'), (\'reg_closed\'), (\'reg_for\'), (\'is_currently_closed\'), (\'about_us\'), (\'account\'), (\'added\'), (\'advertisements\'), (\'all\'), (\'active\'), (\'activate\'), (\'deactivate\'), (\'age\'), (\'approve\'), (\'approved\'), (\'approval\'), (\'books\'), (\'browse\'), (\'by\'), (\'cancel\'), (\'categories\'), (\'category\'), (\'channels\'), (\'check_all\'), (\'click_here\'), (\'comments\'), (\'comment\'), (\'community\'), (\'companies\'), (\'contacts\'), (\'contact_us\'), (\'country\'), (\'created\'), (\'date\'), (\'date_added\'), (\'date_joined\'), (\'dear\'), (\'delete\'), (\'add\'), (\'delete_selected\'), (\'des_title\'), (\'duration\'), (\'education\'), (\'email\'), (\'embed\'), (\'embed_code\'), (\'favourite\'), (\'favourited\'), (\'favourites\'), (\'female\'), (\'filter\'), (\'forgot\'), (\'friends\'), (\'FROM\'), (\'gender\'), (\'groups\'), (\'hello\'), (\'help\'), (\'hi\'), (\'hobbies\'), (\'home\'), (\'inbox\'), (\'interests\'), (\'join_now\'), (\'joined\'), (\'join\'), (\'keywords\'), (\'latest\'), (\'leave\'), (\'location\'), (\'login\'), (\'logout\'), (\'male\'), (\'members\'), (\'messages\'), (\'message\'), (\'minute\'), (\'minutes\'), (\'most_members\'), (\'most_recent\'), (\'most_videos\'), (\'music\'), (\'my_account\'), (\'next\'), (\'no\'), (\'no_user_exists\'), (\'no_video_exists\'), (\'occupations\'), (\'optional\'), (\'owner\'), (\'password\'), (\'please\'), (\'privacy\'), (\'privacy_policy\'), (\'random\'), (\'rate\'), (\'request\'), (\'related\'), (\'reply\'), (\'results\'), (\'relationship\'), (\'second\'), (\'seconds\'), (\'SELECT\'), (\'send\'), (\'sent\'), (\'signup\'), (\'subject\'), (\'tags\'), (\'times\'), (\'to\'), (\'type\'), (\'update\'), (\'upload\'), (\'url\'), (\'verification\'), (\'videos\'), (\'viewing\'), (\'welcome\'), (\'website\'), (\'yes\'), (\'of\'), (\'on\'), (\'previous\'), (\'rating\'), (\'ratings\'), (\'remote_upload\'), (\'remove\'), (\'search\'), (\'services\'), (\'show_all\'), (\'signupup\'), (\'sort_by\'), (\'subscriptions\'), (\'subscribers\'), (\'tag_title\'), (\'track_title\'), (\'time\'), (\'top\'), (\'tos_title\'), (\'username\'), (\'views\'), (\'proccession_wait\'), (\'mostly_viewed\'), (\'most_comments\'), (\'group\'), (\'not_logged_in\'), (\'fill_auth_form\'), (\'insufficient_privileges\'), (\'admin_disabled_you\'), (\'recover_password\'), (\'submit\'), (\'reset_Fields\'), (\'admin_reg_req\'), (\'lang_change\'), (\'lang_changed\'), (\'lang_choice\'), (\'if_not_redir\'), (\'style_changed\'), (\'style_choice\'), (\'vdo_edit_vdo\'), (\'vdo_stills\'), (\'vdo_watch_video\'), (\'vdo_video_details\'), (\'vdo_title\'), (\'vdo_desc\'), (\'vdo_cat\'), (\'vdo_cat_msg\'), (\'vdo_tags_msg\'), (\'vdo_br_opt\'), (\'vdo_br_opt1\'), (\'vdo_br_opt2\'), (\'vdo_date_loc\'), (\'vdo_date_rec\'), (\'vdo_for_date\'), (\'vdo_add_eg\'), (\'vdo_share_opt\'), (\'vdo_allow_comm\'), (\'vdo_dallow_comm\'), (\'vdo_comm_vote\'), (\'vdo_allow_com_vote\'), (\'vdo_dallow_com_vote\'), (\'vdo_allow_rating\'), (\'vdo_embedding\'), (\'vdo_embed_opt1\'), (\'vdo_update_title\'), (\'vdo_inactive_msg\'), (\'vdo_click_here\'), (\'vdo_continue_upload\'), (\'vdo_upload_step1\'), (\'vdo_upload_step2\'), (\'vdo_upload_step3\'), (\'vdo_select_vdo\'), (\'vdo_enter_remote_url\'), (\'vdo_enter_embed_code_msg\'), (\'vdo_enter_embed_code\'), (\'vdo_enter_druation\'), (\'vdo_select_vdo_thumb\'), (\'vdo_having_trouble\'), (\'vdo_if_having_problem\'), (\'vdo_clic_to_manage_all\'), (\'vdo_manage_vdeos\'), (\'vdo_status\'), (\'vdo_rawfile\'), (\'vdo_video_upload_complete\'), (\'vdo_thanks_you_upload_complete_1\'), (\'vdo_thanks_you_upload_complete_2\'), (\'vdo_after_it_has_process\'), (\'vdo_embed_this_video_on_web\'), (\'vdo_copy_and_paste_the_code\'), (\'vdo_upload_another_video\'), (\'vdo_goto_my_videos\'), (\'vdo_sperate_emails_by\'), (\'vdo_personal_msg\'), (\'vdo_related_tags\'), (\'vdo_reply_to_this\'), (\'vdo_add_reply\'), (\'vdo_share_video\'), (\'vdo_about_this_video\'), (\'vdo_post_to_a_services\'), (\'vdo_commentary\'), (\'vdo_post_a_comment\'), (\'grp_add_vdo_msg\'), (\'grp_no_vdo_msg\'), (\'grp_add_to\'), (\'grp_add_vdos\'), (\'grp_name_title\'), (\'grp_tag_title\'), (\'grp_des_title\'), (\'grp_tags_msg\'), (\'grp_tags_msg1\'), (\'grp_url_title\'), (\'grp_url_msg\'), (\'grp_cat_tile\'), (\'grp_vdo_uploads\'), (\'grp_forum_posting\'), (\'grp_join_opt1\'), (\'grp_join_opt2\'), (\'grp_join_opt3\'), (\'grp_vdo_opt1\'), (\'grp_vdo_opt2\'), (\'grp_vdo_opt3\'), (\'grp_post_opt1\'), (\'grp_post_opt2\'), (\'grp_post_opt3\'), (\'grp_crt_grp\'), (\'grp_thumb_title\'), (\'grp_upl_thumb\'), (\'grp_must_be\'), (\'grp_90x90\'), (\'grp_thumb_warn\'), (\'grp_del_confirm\'), (\'grp_del_success\'), (\'grp_click_go_grps\'), (\'grp_edit_grp_title\'), (\'grp_manage_vdos\'), (\'grp_manage_mems\'), (\'grp_del_group_title\'), (\'grp_add_vdos_title\'), (\'grp_join_grp_title\'), (\'grp_leave_group_title\'), (\'grp_invite_grp_title\'), (\'grp_view_mems\'), (\'grp_view_vdos\'), (\'grp_create_grp_title\'), (\'grp_most_members\'), (\'grp_most_discussed\'), (\'grp_invite_msg\'), (\'grp_invite_msg1\'), (\'grp_invite_msg2\'), (\'grp_url_title1\'), (\'grp_invite_msg3\'), (\'grp_join_confirm_msg\'), (\'grp_join_msg_succ\'), (\'grp_click_here_to_go\'), (\'grp_leave_confirm\'), (\'grp_leave_succ_msg\'), (\'grp_manage_members_title\'), (\'grp_for_approval\'), (\'grp_rm_videos\'), (\'grp_rm_mems\'), (\'grp_groups_title\'), (\'grp_joined_title\'), (\'grp_remove_group\'), (\'grp_bo_grp_found\'), (\'grp_joined_groups\'), (\'grp_owned_groups\'), (\'grp_edit_this_grp\'), (\'grp_topics_title\'), (\'grp_topic_title\'), (\'grp_posts_title\'), (\'grp_discus_title\'), (\'grp_author_title\'), (\'grp_replies_title\'), (\'grp_last_post_title\'), (\'grp_viewl_all_videos\'), (\'grp_add_new_topic\'), (\'grp_attach_video\'), (\'grp_add_topic\'), (\'grp_please_login\'), (\'grp_please_join\'), (\'grp_inactive_account\'), (\'grp_about_this_grp\'), (\'grp_no_vdo_err\'), (\'grp_posted_by\'), (\'grp_add_new_comment\'), (\'grp_add_comment\'), (\'grp_pls_login_comment\'), (\'grp_pls_join_comment\'), (\'usr_activation_title\'), (\'usr_actiavation_msg\'), (\'usr_actiavation_msg1\'), (\'usr_activation_code_tl\'), (\'usr_compose_msg\'), (\'usr_inbox_title\'), (\'usr_sent_title\'), (\'usr_to_title\'), (\'usr_or_select_frm_list\'), (\'usr_attach_video\'), (\'user_attached_video\'), (\'usr_send_message\'), (\'user_no_message\'), (\'user_delete_message_msg\'), (\'user_forgot_message\'), (\'user_forgot_message_2\'), (\'user_pass_reset_msg\'), (\'user_pass_forgot_msg\'), (\'user_veri_code\'), (\'user_reocover_user\'), (\'user_user_forgot_msg\'), (\'user_recover\'), (\'user_reset\'), (\'user_inactive_msg\'), (\'user_dashboard\'), (\'user_manage_prof_chnnl\'), (\'user_manage_friends\'), (\'user_prof_channel\'), (\'user_message_box\'), (\'user_new_messages\'), (\'user_goto_inbox\'), (\'user_goto_sentbox\'), (\'user_compose_new\'), (\'user_total_subs_users\'), (\'user_you_have\'), (\'user_fav_videos\'), (\'user_your_vids_watched\'), (\'user_times\'), (\'user_you_have_watched\'), (\'user_channel_profiles\'), (\'user_channel_views\'), (\'user_channel_comm\'), (\'user_manage_prof\'), (\'user_you_created\'), (\'user_you_joined\'), (\'user_create_group\'), (\'user_manage_my_account\'), (\'user_manage_my_videos\'), (\'user_manage_my_channel\'), (\'user_sent_box\'), (\'user_manage_channel\'), (\'user_manage_my_contacts\'), (\'user_manage_contacts\'), (\'user_manage_favourites\'), (\'user_mem_login\'), (\'user_already_have\'), (\'user_forgot_username\'), (\'user_forgot_password\'), (\'user_create_your\'), (\'all_fields_req\'), (\'user_valid_email_addr\'), (\'user_allowed_format\'), (\'user_confirm_pass\'), (\'user_reg_msg_0\'), (\'user_reg_msg_1\'), (\'user_date_of_birth\'), (\'user_enter_text_as_img\'), (\'user_refresh_img\'), (\'user_i_agree_to_the\'), (\'user_thanks_for_reg\'), (\'user_email_has_sent\'), (\'user_and_activation\'), (\'user_details_you_now\'), (\'user_upload_share_vds\'), (\'user_make_friends\'), (\'user_send_messages\'), (\'user_grow_your_network\'), (\'user_rate_comment\'), (\'user_make_customize\'), (\'user_to_upload_vid\'), (\'user_click_to_login\'), (\'user_view_my_channel\'), (\'user_change_pass\'), (\'user_email_settings\'), (\'user_profile_settings\'), (\'user_usr_prof_chnl_edit\'), (\'user_personal_info\'), (\'user_fname\'), (\'user_lname\'), (\'user_gender\'), (\'user_relat_status\'), (\'user_display_age\'), (\'user_about_me\'), (\'user_website_url\'), (\'user_eg_website\'), (\'user_prof_info\'), (\'user_education\'), (\'user_school_colleges\'), (\'user_occupations\'), (\'user_companies\'), (\'user_sperate_by_commas\'), (\'user_interests_hobbies\'), (\'user_fav_movs_shows\'), (\'user_fav_music\'), (\'user_fav_books\'), (\'user_user_avatar\'), (\'user_upload_avatar\'), (\'user_channel_info\'), (\'user_channel_title\'), (\'user_channel_description\'), (\'user_channel_permission\'), (\'user_allow_comments_msg\'), (\'user_dallow_comments_msg\'), (\'user_allow_rating\'), (\'user_dallow_rating\'), (\'user_allow_rating_msg1\'), (\'user_dallow_rating_msg1\'), (\'user_channel_feature_vid\'), (\'user_select_vid_for_fr\'), (\'user_chane_channel_bg\'), (\'user_remove_bg\'), (\'user_currently_you_d_have_pic\'), (\'user_change_email\'), (\'user_email_address\'), (\'user_new_email\'), (\'user_notify_me\'), (\'user_old_pass\'), (\'user_new_pass\'), (\'user_c_new_pass\'), (\'user_doesnt_exist\'), (\'user_do_not_have_contact\'), (\'user_no_fav_video_exist\'), (\'user_have_no_vide\'), (\'user_s_channel\'), (\'user_last_login\'), (\'user_send_message\'), (\'user_add_contact\'), (\'user_dob\'), (\'user_movies_shows\'), (\'user_add_comment\'), (\'user_no_fr_video\'), (\'user_view_all_video_of\'), (\'menu_home\'), (\'menu_inbox\'), (\'vdo_cat_err2\'), (\'user_subscribe_message\'), (\'user_subscribe_subject\'), (\'you_already_logged\'), (\'you_not_logged_in\'), (\'invalid_user\'), (\'vdo_cat_err3\'), (\'embed_code_invalid_err\'), (\'invalid_duration\'), (\'vid_thumb_changed\'), (\'vid_thumb_change_err\'), (\'upload_vid_thumbs_msg\'), (\'video_thumb_delete_msg\'), (\'video_thumb_delete_err\'), (\'no_comment_del_perm\'), (\'my_text_context\'), (\'user_contains_disallow_err\'), (\'add_cat_erro\'), (\'add_cat_no_name_err\'), (\'cat_default_err\'), (\'pic_upload_vali_err\'), (\'cat_dir_make_err\'), (\'cat_set_default_ok\'), (\'vid_thumb_removed_msg\'), (\'vid_files_removed_msg\'), (\'vid_log_delete_msg\'), (\'vdo_multi_del_erro\'), (\'add_fav_message\'), (\'obj_not_exists\'), (\'already_fav_message\'), (\'obj_report_msg\'), (\'obj_report_err\'), (\'user_no_exist_wid_username\'), (\'share_video_no_user_err\'), (\'today\'), (\'yesterday\'), (\'thisweek\'), (\'lastweek\'), (\'thismonth\'), (\'lastmonth\'), (\'thisyear\'), (\'lastyear\'), (\'favorites\'), (\'alltime\'), (\'insufficient_privileges_loggin\'), (\'profile_title\'), (\'show_dob\'), (\'profile_tags\'), (\'profile_desc\'), (\'online_status\'), (\'show_profile\'), (\'allow_ratings\'), (\'postal_code\'), (\'temp_file_load_err\'), (\'no_date_provided\'), (\'bad_date\'), (\'users_videos\'), (\'please_login_subscribe\'), (\'users_subscribers\'), (\'user_no_subscribers\'), (\'user_subscriptions\'), (\'user_no_subscriptions\'), (\'usr_avatar_bg_update\'), (\'user_email_confirm_email_err\'), (\'email_change_msg\'), (\'no_edit_video\'), (\'confirm_del_video\'), (\'remove_fav_video_confirm\'), (\'remove_fav_photo_confirm\'), (\'remove_fav_collection_confirm\'), (\'fav_remove_msg\'), (\'unknown_favorite\'), (\'vdo_multi_del_fav_msg\'), (\'unknown_sender\'), (\'please_enter_message\'), (\'unknown_reciever\'), (\'no_pm_exist\'), (\'pm_sent_success\'), (\'msg_delete_inbox\'), (\'msg_delete_outbox\'), (\'private_messags_deleted\'), (\'ban_users\'), (\'spe_users_by_comma\'), (\'user_ban_msg\'), (\'no_user_ban_msg\'), (\'thnx_sharing_msg\'), (\'no_own_commen_rate\'), (\'no_comment_exists\'), (\'thanks_rating_comment\'), (\'please_login_create_playlist\'), (\'user_have_no_playlists\'), (\'play_list_with_this_name_arlready_exists\'), (\'please_enter_playlist_name\'), (\'new_playlist_created\'), (\'playlist_not_exist\'), (\'playlist_item_not_exist\'), (\'playlist_item_delete\'), (\'play_list_updated\'), (\'you_dont_hv_permission_del_playlist\'), (\'playlist_delete_msg\'), (\'playlist_name\'), (\'add_new_playlist\'), (\'this_thing_added_playlist\'), (\'this_already_exist_in_pl\'), (\'edit_playlist\'), (\'remove_playlist_item_confirm\'), (\'remove_playlist_confirm\'), (\'avcode_incorrect\'), (\'group_join_login_err\'), (\'manage_playlist\'), (\'my_notifications\'), (\'users_contacts\'), (\'type_flags_removed\'), (\'terms_of_serivce\'), (\'users\'), (\'login_to_mark_as_spam\'), (\'no_own_commen_spam\'), (\'already_spammed_comment\'), (\'spam_comment_ok\'), (\'arslan_hassan\'), (\'you_not_allowed_add_grp_vids\'), (\'sel_vids_updated\'), (\'unable_find_download_file\'), (\'you_cant_edit_group\'), (\'you_cant_invite_mems\'), (\'you_cant_moderate_group\'), (\'page_doesnt_exist\'), (\'pelase_select_img_file_for_vdo\'), (\'new_mem_added\'), (\'this_vdo_not_working\'), (\'email_template_not_exist\'), (\'email_subj_empty\'), (\'email_msg_empty\'), (\'email_tpl_has_updated\'), (\'page_name_empty\'), (\'page_title_empty\'), (\'page_content_empty\'), (\'new_page_added_successfully\'), (\'page_updated\'), (\'page_deleted\'), (\'page_activated\'), (\'page_deactivated\'), (\'you_cant_delete_this_page\'), (\'ad_placement_err4\'), (\'grp_details_updated\'), (\'you_cant_del_topic\'), (\'you_cant_del_user_topics\'), (\'topics_deleted\'), (\'you_cant_delete_grp_topics\'), (\'you_not_allowed_post_topics\'), (\'you_cant_add_this_vdo\'), (\'video_added\'), (\'you_cant_del_this_vdo\'), (\'video_removed\'), (\'user_not_grp_mem\'), (\'user_already_group_mem\'), (\'invitations_sent\'), (\'you_not_grp_mem\'), (\'you_cant_delete_this_grp\'), (\'grp_deleted\'), (\'you_cant_del_grp_mems\'), (\'mems_deleted\'), (\'you_cant_del_grp_vdos\'), (\'thnx_for_voting\'), (\'you_hv_already_rated_vdo\'), (\'please_login_to_rate\'), (\'you_not_subscribed\'), (\'you_cant_delete_this_user\'), (\'you_dont_hv_perms\'), (\'user_subs_hv_been_removed\'), (\'user_subsers_hv_removed\'), (\'you_already_sent_frend_request\'), (\'friend_added\'), (\'friend_request_sent\'), (\'friend_confirm_error\'), (\'friend_confirmed\'), (\'friend_request_not_found\'), (\'you_cant_confirm_this_request\'), (\'friend_request_already_confirmed\'), (\'user_no_in_contact_list\'), (\'user_removed_from_contact_list\'), (\'cant_find_level\'), (\'please_enter_level_name\'), (\'level_updated\'), (\'level_del_sucess\'), (\'level_not_deleteable\'), (\'pass_mismatched\'), (\'user_blocked\'), (\'user_already_blocked\'), (\'you_cant_del_user\'), (\'user_vids_hv_deleted\'), (\'user_contacts_hv_removed\'), (\'all_user_inbox_deleted\'), (\'all_user_sent_messages_deleted\'), (\'pelase_enter_something_for_comment\'), (\'please_enter_your_name\'), (\'please_enter_your_email\'), (\'template_activated\'), (\'error_occured_changing_template\'), (\'phrase_code_empty\'), (\'phrase_text_empty\'), (\'language_does_not_exist\'), (\'name_has_been_added\'), (\'name_already_exists\'), (\'lang_doesnt_exist\'), (\'no_file_was_selected\'), (\'err_reading_file_content\'), (\'cant_find_lang_name\'), (\'cant_find_lang_code\'), (\'no_phrases_found\'), (\'language_already_exists\'), (\'lang_added\'), (\'error_while_upload_file\'), (\'default_lang_del_error\'), (\'lang_deleted\'), (\'lang_name_empty\'), (\'lang_code_empty\'), (\'lang_regex_empty\'), (\'lang_code_already_exist\'), (\'lang_updated\'), (\'player_activated\'), (\'error_occured_while_activating_player\'), (\'plugin_has_been_s\'), (\'plugin_uninstalled\'), (\'perm_code_empty\'), (\'perm_name_empty\'), (\'perm_already_exist\'), (\'perm_type_not_valid\'), (\'perm_added\'), (\'perm_deleted\'), (\'perm_doesnt_exist\'), (\'acitvation_html_message\'), (\'acitvation_html_message2\'), (\'admin_panel\'), (\'moderate_videos\'), (\'moderate_users\'), (\'revert_back_to_admin\'), (\'more_options\'), (\'downloading_string\'), (\'download_redirect_msg\'), (\'account_details\'), (\'profile_details\'), (\'update_profile\'), (\'please_select_img_file\'), (\'or\'), (\'pelase_enter_image_url\'), (\'user_bg\'), (\'user_bg_img\'), (\'please_enter_bg_color\'), (\'bg_repeat_type\'), (\'fix_bg\'), (\'delete_this_img\'), (\'current_email\'), (\'confirm_new_email\'), (\'no_subs_found\'), (\'video_info_all_fields_req\'), (\'update_group\'), (\'default\'), (\'grp_info_all_fields_req\'), (\'date_recorded_location\'), (\'update_video\'), (\'click_here_to_recover_user\'), (\'click_here_reset_pass\'), (\'remember_me\'), (\'howdy_user\'), (\'notifications\'), (\'playlists\'); ';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key) VALUES (\'friend_requests\'), (\'after_meny_guest_msg\'), (\'being_watched\'), (\'change_style_of_listing\'), (\'website_members\'), (\'guest_homeright_msg\'), (\'reg_for_free\'), (\'rand_vids\'), (\'t_10_users\'), (\'pending\'), (\'confirm\'), (\'no_contacts\'), (\'you_dont_hv_any_grp\'), (\'you_dont_joined_any_grp\'), (\'leave_groups\'), (\'manage_grp_mems\'), (\'pending_mems\'), (\'active_mems\'), (\'disapprove\'), (\'manage_grp_vids\'), (\'pending_vids\'), (\'no_pending_vids\'), (\'no_active_videos\'), (\'active_videos\'), (\'manage_playlists\'), (\'total_items\'), (\'play_now\'), (\'no_video_in_playlist\'), (\'view\'), (\'you_dont_hv_fav_vids\'), (\'private_messages\'), (\'new_private_msg\'), (\'search_for_s\'), (\'signup_success_usr_ok\'), (\'signup_success_usr_emailverify\'), (\'if_you_already_hv_account\'), (\'signup_message_under_login\'), (\'new_mems_signup_here\'), (\'register_as_our_website_member\'), (\'video_complete_msg\'), (\'upload_right_guide\'), (\'report_this_user\'), (\'add_to_favs\'), (\'report_this\'), (\'share_this\'), (\'add_to_playlist\'), (\'view_profile\'), (\'subscribe\'), (\'uploaded_by_s\'), (\'more\'), (\'link_this_video\'), (\'click_to_download_video\'), (\'name\'), (\'email_wont_display\'), (\'please_login_to_comment\'), (\'marked_as_spam_comment_by_user\'), (\'spam\'), (\'user_commented_time\'), (\'no_comments\'), (\'view_video\'), (\'topic_icon\'), (\'group_options\'), (\'info\'), (\'basic_info\'), (\'group_owner\'), (\'total_mems\'), (\'total_topics\'), (\'grp_url\'), (\'more_details\'), (\'view_all_mems\'), (\'view_all_vids\'), (\'topic_title\'), (\'last_reply\'), (\'topic_by_user\'), (\'no_topics\'), (\'last_post_time_by_user\'), (\'profile_views\'), (\'last_logged_in\'), (\'last_active\'), (\'total_logins\'), (\'total_videos_watched\'), (\'view_group\'), (\'you_dont_hv_any_pm\'), (\'date_sent\'), (\'show_hide\'), (\'quicklists\'), (\'are_you_sure_rm_grp\'), (\'are_you_sure_del_grp\'), (\'change_avatar\'), (\'change_bg\'), (\'uploaded_videos\'), (\'video_playlists\'), (\'add_contact_list\'), (\'topic_post\'), (\'invite\'), (\'time_ago\'), (\'from_now\'), (\'lang_has_been_activated\'), (\'lang_has_been_deactivated\'), (\'lang_default_no_actions\'), (\'private_video_error\'), (\'email_send_confirm\'), (\'name_was_empty\'), (\'invalid_email\'), (\'pelase_enter_reason\'), (\'please_enter_something_for_message\'), (\'comm_disabled_for_vid\'), (\'coments_disabled_profile\'), (\'file_size_exceeds\'), (\'vid_rate_disabled\'), (\'chane_lang\'), (\'recent\'), (\'viewed\'), (\'top_rated\'), (\'commented\'), (\'searching_keyword_in_obj\'), (\'no_results_found\'), (\'please_enter_val_bw_min_max\'), (\'no_new_subs_video\'), (\'inapp_content\'), (\'copyright_infring\'), (\'sexual_content\'), (\'violence_replusive_content\'), (\'disturbing\'), (\'other\'), (\'pending_requests\'), (\'friend_add_himself_error\'), (\'contact_us_msg\'), (\'successful\'), (\'failed\'), (\'required_fields\'), (\'more_fields\'), (\'remote_upload_file\'), (\'please_enter_remote_file_url\'), (\'remoteDownloadStatusDiv\'), (\'upload_data_now\'), (\'save_data\'), (\'saving\'), (\'upload_file\'), (\'grab_from_youtube\'), (\'upload_video_button\'), (\'upload_videos_can_be\'), (\'photo_not_exist\'), (\'photo_success_deleted\'), (\'cant_edit_photo\'), (\'you_hv_already_rated_photo\'), (\'photo_rate_disabled\'), (\'need_photo_details\'), (\'embedding_is_disabled\'), (\'photo_activated\'), (\'photo_deactivated\'), (\'photo_featured\'), (\'photo_unfeatured\'), (\'photo_updated_successfully\'), (\'success_delete_file\'), (\'no_watermark_found\'), (\'watermark_updated\'), (\'upload_png_watermark\'), (\'photo_non_readable\'), (\'wrong_mime_type\'), (\'you_dont_have_photos\'), (\'you_dont_have_fav_photos\'), (\'manage_orphan_photos\'), (\'manage_favorite_photos\'), (\'manage_photos\'), (\'you_dont_have_orphan_photos\'), (\'item_not_exist\'), (\'collection_not_exist\'), (\'selected_collects_del\'), (\'manage_collections\'), (\'manage_categories\'), (\'flagged_collections\'), (\'create_collection\'), (\'selected_items_removed\'), (\'edit_collection\'), (\'manage_collection_items\'), (\'manage_favorite_collections\'), (\'total_fav_collection_removed\'), (\'total_photos_deleted\'), (\'total_fav_photos_removed\'), (\'photos_upload\'), (\'no_items_found_in_collect\'), (\'manage_items\'), (\'add_new_collection\'), (\'update_collection\'), (\'update_photo\'), (\'no_collection_found\'), (\'photo_title\'), (\'photo_caption\'), (\'photo_tags\'), (\'collection\'), (\'photo\'), (\'video\'), (\'pic_allow_embed\'), (\'pic_dallow_embed\'), (\'pic_allow_rating\'), (\'pic_dallow_rating\'), (\'add_more\'), (\'collect_name_er\'), (\'collect_descp_er\'), (\'collect_tag_er\'), (\'collect_cat_er\'), (\'collect_borad_pub\'), (\'collect_allow_public_up\'), (\'collect_pub_up_dallow\'), (\'collect_pub_up_allow\'), (\'collection_name\'), (\'collection_description\'), (\'collection_tags\'), (\'collect_category\'), (\'collect_added_msg\'), (\'collect_not_exist\'), (\'no_upload_opt\'), (\'uploaded\'), (\'photos\'), (\'cat_all\'), (\'upload_desktop_msg\'), (\'upload_remote_video_msg\'), (\'embed_video_msg\'), (\'link_video_msg\'), (\'browse_photos\'), (\'photo_is_saved_now\'), (\'photo_success_heading\'), (\'share_embed\'), (\'item_added_in_collection\'), (\'object_exists_collection\'), (\'collect_tag_hint\'), (\'collect_broad_pri\'), (\'collect_item_removed\'), (\'most_downloaded\'), (\'total_videos\'), (\'collection_featured\'), (\'collection_unfeatured\'), (\'upload_right_guide_photo\'), (\'upload_right_guide_vid\'), (\'collection_deactivated\'), (\'collection_activated\'), (\'collection_updated\'), (\'cant_edit_collection\'), (\'object_not_in_collect\'), (\'object_does_not_exists\'), (\'cant_perform_action_collect\'), (\'collection_deleted\'), (\'collection_not_exists\'), (\'collect_items_deleted\'), (\'photo_title_err\'), (\'rand_photos\'), (\'this_has_set_profile_item\'), (\'profile_item_removed\'), (\'make_profile_item\'), (\'remove_profile_item\'), (\'content_type_empty\'), (\'watch_video_page\'), (\'watch_on_photo_page\'), (\'found_no_videos\'), (\'found_no_photos\'), (\'collections\'), (\'related_videos\'), (\'this_video_found_in_no_collection\'), (\'more_from\'), (\'this_collection\'), (\'vdo_broadcast_unlisted\'), (\'video_link\'), (\'channel_settings\'), (\'channel_account_settings\'), (\'account_settings\'), (\'allow_subscription\'), (\'allow_subscription_hint\'), (\'channel_title\'), (\'channel_desc\'), (\'show_my_friends\'), (\'show_my_videos\'), (\'show_my_photos\'), (\'show_my_subscriptions\'), (\'show_my_subscribers\'), (\'profile_basic_info\'), (\'profile_education_interests\'), (\'channel_profile_settings\'), (\'show_my_collections\'), (\'user_doesnt_any_collection\'), (\'unsubscribe\'), (\'you_have_already_voted_channel\'), (\'channel_rating_disabled\'), (\'user_activity\'), (\'you_cant_view_profile\'), (\'only_friends_view_channel\'), (\'collect_type\'), (\'add_to_my_collection\'), (\'total_collections\'), (\'total_photos\'), (\'comments_made\'), (\'block_users\'), (\'tp_del_confirm\'), (\'you_need_owners_approval_to_view_group\'), (\'you_cannot_rate_own_collection\'), (\'collection_rating_not_allowed\'), (\'you_cant_rate_own_video\'), (\'you_cant_rate_own_channel\'), (\'you_cannot_rate_own_photo\'), (\'cant_pm_banned_user\'), (\'you_are_not_allowed_to_view_user_channel\'), (\'you_cant_send_pm_yourself\'), (\'please_enter_confimation_ode\'), (\'vdo_brd_confidential\'), (\'video_password\'), (\'set_video_password\'), (\'video_pass_protected\'), (\'please_enter_video_password\'), (\'video_is_password_protected\'), (\'invalid_video_password\'), (\'logged_users_only\'), (\'specify_video_users\'), (\'video_users\'), (\'not_logged_video_error\'), (\'no_user_subscribed_to_uploader\'), (\'subs_email_sent_to_users\'), (\'user_has_uploaded_new_photo\'), (\'please_provide_valid_userid\'), (\'user_joined_us\'), (\'user_has_uploaded_new_video\'), (\'user_has_created_new_group\'), (\'total_members\'), (\'watch_video\'), (\'view_photo\'), (\'user_has_joined_group\'), (\'user_is_now_friend_with_other\'), (\'user_has_created_new_collection\'), (\'view_collection\'), (\'user_has_favorited_video\'), (\'activity\'), (\'no_activity\'), (\'feed_has_been_deleted\'), (\'you_cant_del_this_feed\'), (\'you_cant_sub_yourself\'), (\'manage_my_album\'), (\'you_dont_have_permission_to_update_this_video\'), (\'group_is_public\'), (\'collection_thumb\'), (\'collection_is_private\'), (\'edit_type_collection\'), (\'comm_disabled_for_collection\'), (\'share_this_type\'), (\'seperate_usernames_with_comma\'), (\'view_all\'), (\'album_privacy_updated\'), (\'you_dont_have_any_videos\'), (\'update_blocked_use\'), (\'you_dont_have_fav_collections\'), (\'remote_play\'), (\'remote_upload_example\'), (\'update_blocked_user_list\'), (\'group_is_private\'), (\'no_user_associated_with_email\'), (\'pass_changed_success\'), (\'add_as_friend\'), (\'block_user\'), (\'send_message\'), (\'no_item_was_selected_to_delete\'), (\'playlist_items_have_been_removed\'), (\'you_not_grp_mem_or_approved\'), (\'no_playlist_was_selected_to_delete\'), (\'featured_videos\'), (\'recent_videos\'), (\'featured_users\'), (\'top_collections\'), (\'top_playlists\'), (\'load_more\'), (\'no_playlists\'), (\'featured_photos\'), (\'no_channel_found\'), (\'download\'), (\'add_to\'), (\'player_size\'), (\'small\'), (\'medium\'), (\'large\'), (\'iframe\'), (\'embed_object\'), (\'add_to_my_favorites\'), (\'please_select_playlist\'), (\'create_new_playlist\'), (\'select_playlist\'), (\'report_video\'), (\'report_text\'), (\'flag_video\'), (\'comment_as\'), (\'more_replies\'), (\'photo_description\'), (\'flag\'), (\'update_cover\'), (\'unfriend\'), (\'accept_request\'), (\'online\'), (\'offline\'), (\'upload_video\'), (\'upload_photo\'), (\'upload_beats_guide\'), (\'admin_area\'), (\'view_channels\'), (\'my_channel\'), (\'manage_videos\'), (\'cancel_request\'), (\'contact\'), (\'no_featured_videos_found\'), (\'no_recent_videos_found\'), (\'no_collection_found_alert\'), (\'select_collection_upload\'), (\'no_collection_upload\'), (\'create_new_collection_btn\'), (\'photo_upload_tab\'), (\'no_videos_found\'), (\'latest_videos\'), (\'videos_details\'), (\'option\'), (\'flagged_obj\'), (\'watched\'), (\'since\'), (\'last_Login\'), (\'no_friends_in_list\'), (\'no_pending_friend\'), (\'hometown\'), (\'city\'), (\'schools\'), (\'occupation\'), (\'you_dont_have_videos\'), (\'write_msg\'), (\'content\'), (\'no_video\'), (\'back_to_collection\'), (\'long_txt\'), (\'make_my_album\'), (\'public\'), (\'private\'), (\'for_friends\'), (\'submit_now\'), (\'drag_drop\'), (\'upload_more_videos\'), (\'selected_files\'), (\'upload_in_progress\'), (\'complete_of_video\'), (\'playlist_videos\'), (\'popular_videos\'), (\'uploading\'), (\'select_photos\'), (\'uploading_in_progress\'), (\'complete_of_photo\'), (\'upload_more_photos\'), (\'save_details\'), (\'related_photos\'), (\'no_photos_found\'), (\'search_keyword_feed\'), (\'contacts_manager\'), (\'weak_pass\'), (\'create_account_msg\'), (\'get_your_account\'), (\'type_password_here\'), (\'type_username_here\'), (\'terms_of_service\'), (\'upload_vid_thumb_msg\'), (\'agree\'), (\'terms\'), (\'and\'), (\'policy\'), (\'watch\'), (\'edit_video\'), (\'del_video\'), (\'processing\'), (\'last_one\'), (\'creating_collection_is_disabled\'), (\'creating_playlist_is_disabled\'), (\'inactive\'), (\'vdo_actions\'), (\'view_ph\'), (\'edit_ph\'), (\'delete_ph\'), (\'title_ph\'), (\'view_edit_playlist\'), (\'no_playlist_found\'), (\'playlist_owner\'), (\'playlist_privacy\'), (\'add_to_collection\'), (\'video_added_to_playlist\'), (\'subscribe_btn\'), (\'report_usr\'), (\'un_reg_user\'), (\'my_playlists\'), (\'play\'), (\'no_vid_in_playlist\'), (\'website_offline\'), (\'loading\'), (\'hour\'), (\'hours\'), (\'day\'), (\'days\'), (\'week\'), (\'weeks\'), (\'month\'), (\'months\'), (\'year\'), (\'years\'), (\'decade\'), (\'decades\'), (\'your_name\'), (\'your_email\'), (\'type_comment_box\'), (\'guest\'), (\'anonymous\'), (\'no_comment_added\'), (\'register_min_age_request\'), (\'select_category\'), (\'custom\'), (\'no_playlist_exists\'), (\'edit\'), (\'create_new_account\'), (\'search_too_short\'), (\'playlist_allow_comments\'), (\'playlist_allow_rating\'), (\'playlist_description\'), (\'playlists_have_been_removed\'), (\'confirm_collection_delete\'), (\'please_select_collection\'), (\'please_enter_collection_name\'), (\'select_collection\'), (\'resolution\'), (\'filesize\'), (\'empty_next\'), (\'no_items\'), (\'user_recover_user\'), (\'edited_by\'), (\'reply_to\'), (\'mail_type\'), (\'host\'), (\'port\'), (\'user\'), (\'auth\'), (\'mail_not_send\'), (\'mail_send\'), (\'title\'), (\'show_comments\'), (\'hide_comments\'), (\'description\'), (\'users_categories\'), (\'popular_users\'), (\'channel\'), (\'embed_type\'), (\'confirm_del_photo\'), (\'vdo_inactive\'), (\'photo_tags_error\'), (\'signups\'), (\'active_users\'), (\'user_name_invalid_len\'), (\'username_spaces\'), (\'photo_caption_err\'), (\'photo_tags_err\'), (\'photo_collection_err\'), (\'details\'), (\'technical_error\'), (\'inserted\'), (\'castable_status_fixed\'), (\'castable_status_failed\'), (\'castable_status_check\'), (\'castable\'), (\'non_castable\'), (\'videos_manager\'), (\'update_bits_color\'), (\'bits_color\'), (\'bits_color_compatibility\'), (\'player_logo_reset\'), (\'player_settings_updated\'), (\'player_settings\'), (\'quality\'), (\'error_occured\'), (\'error_file_download\'), (\'dashboard_update_status\'), (\'dashboard_changelogs\'), (\'dashboard_php_config_allow_url_fopen\'), (\'signup_error_email_unauthorized\'), (\'video_detail_saved\'), (\'video_subtitles_deleted\'), (\'collection_no_parent\'), (\'collection_parent\'), (\'comments_disabled_for_photo\'), (\'plugin_editors_picks\'), (\'plugin_editors_picks_added\'), (\'plugin_editors_picks_removed\'), (\'plugin_editors_picks_removed_plural\'), (\'plugin_editors_picks_add_error\'), (\'plugin_editors_picks_add_to\'), (\'plugin_editors_picks_remove_from\'), (\'plugin_editors_picks_remove_confirm\'), (\'plugin_global_announcement\'), (\'plugin_global_announcement_subtitle\'), (\'plugin_global_announcement_edit\'), (\'plugin_global_announcement_updated\'), (\'page_upload_video_limits\'), (\'page_upload_video_select\'), (\'page_upload_photo_limits\'), (\'video_resolution_auto\'), (\'video_thumbs_regenerated\'), (\'video_allow_comment_vote\'), (\'language\'), (\'progression\');';
        self::query($sql);

        self::generateTranslation('ad_name_error', [
            'en' => 'Please enter a name for the Advertisment'
        ]);
        self::generateTranslation('ad_code_error', [
            'en' => 'Error : Please enter a code for the Advertisement'
        ]);
        self::generateTranslation('ad_exists_error1', [
            'en' => 'Advertisement does not exist'
        ]);
        self::generateTranslation('ad_exists_error2', [
            'en' => 'Error : Advertisement with this name already exist'
        ]);
        self::generateTranslation('ad_add_msg', [
            'en' => 'Advertisment was added succesfully'
        ]);
        self::generateTranslation('ad_msg', [
            'en' => 'Ad Has Been '
        ]);
        self::generateTranslation('ad_update_msg', [
            'en' => 'Advertisment has been Updated'
        ]);
        self::generateTranslation('ad_del_msg', [
            'en' => 'Advertisement has been Deleted'
        ]);
        self::generateTranslation('ad_deactive', [
            'en' => 'Deactivated'
        ]);
        self::generateTranslation('ad_active', [
            'en' => 'Activated'
        ]);
        self::generateTranslation('ad_placment_delete_msg', [
            'en' => 'Placement has been Removed'
        ]);
        self::generateTranslation('ad_placement_err1', [
            'en' => 'Placement already exists'
        ]);
        self::generateTranslation('ad_placement_err2', [
            'en' => 'Please Enter a name for the Placement'
        ]);
        self::generateTranslation('ad_placement_err3', [
            'en' => 'Please Enter a Code for the Placement'
        ]);
        self::generateTranslation('ad_placement_msg', [
            'en' => 'Placement has been Added'
        ]);
        self::generateTranslation('cat_img_error', [
            'en' => 'Please Upload JPEG, GIF or PNG image only'
        ]);
        self::generateTranslation('cat_exist_error', [
            'en' => 'Category doesn\'t exist'
        ]);
        self::generateTranslation('cat_add_msg', [
            'en' => 'Category has been added successfully'
        ]);
        self::generateTranslation('cat_update_msg', [
            'en' => 'Category has been updated'
        ]);
        self::generateTranslation('grp_err', [
            'en' => 'Group Doesn\'t Exist'
        ]);
        self::generateTranslation('grp_fr_msg', [
            'en' => 'Group has been set as featured'
        ]);
        self::generateTranslation('grp_fr_msg1', [
            'en' => 'Selected Groups Have Been Removed From The Featured List'
        ]);
        self::generateTranslation('grp_ac_msg', [
            'en' => 'Selected Groups Have Been Activated'
        ]);
        self::generateTranslation('grp_dac_msg', [
            'en' => 'Selected Groups Have Been Dectivated'
        ]);
        self::generateTranslation('grp_del_msg', [
            'en' => 'Group has been deleted'
        ]);
        self::generateTranslation('editor_pic_up', [
            'en' => 'Video Has Been Moved Up'
        ]);
        self::generateTranslation('editor_pic_down', [
            'en' => 'Video Has Been Moved Down'
        ]);
        self::generateTranslation('plugin_install_msg', [
            'en' => 'Plugin has been installed'
        ]);
        self::generateTranslation('plugin_no_file_err', [
            'en' => 'No file was found'
        ]);
        self::generateTranslation('plugin_file_detail_err', [
            'en' => 'Unknown plugin details found'
        ]);
        self::generateTranslation('plugin_installed_err', [
            'en' => 'Plugin already installed'
        ]);
        self::generateTranslation('plugin_no_install_err', [
            'en' => 'Plugin is not installed'
        ]);
        self::generateTranslation('grp_name_error', [
            'en' => 'Please enter group name'
        ]);
        self::generateTranslation('grp_name_error1', [
            'en' => 'Group Name Already Exists'
        ]);
        self::generateTranslation('grp_des_error', [
            'en' => 'Please Enter A Little Description For The Group'
        ]);
        self::generateTranslation('grp_tags_error', [
            'en' => 'Please Enter Tags For The Group'
        ]);
        self::generateTranslation('grp_url_error', [
            'en' => 'Please enter valid url for the Group'
        ]);
        self::generateTranslation('grp_url_error1', [
            'en' => 'Please enter Valid URL name'
        ]);
        self::generateTranslation('grp_url_error2', [
            'en' => 'Group URL Already Exists, Please Choose a Different URL'
        ]);
        self::generateTranslation('grp_tpc_error', [
            'en' => 'Please enter a topic to add'
        ]);
        self::generateTranslation('grp_comment_error', [
            'en' => 'You must enter a comment'
        ]);
        self::generateTranslation('grp_join_error', [
            'en' => 'You have already joined this group'
        ]);
        self::generateTranslation('grp_prvt_error', [
            'en' => 'This Group Is Private, Please Login to View this Group'
        ]);
        self::generateTranslation('grp_inact_error', [
            'en' => 'This Group Is Inactive, Please Contact Administrator for the problem'
        ]);
        self::generateTranslation('grp_join_error1', [
            'en' => 'You Have Not Joined This Group Yet'
        ]);
        self::generateTranslation('grp_exist_error', [
            'en' => 'Sorry, Group Doesn\'t Exist'
        ]);
        self::generateTranslation('grp_tpc_error1', [
            'en' => 'This Topic is not approved by the Group Owner'
        ]);
        self::generateTranslation('grp_cat_error', [
            'en' => 'Please Select A Category For Your group'
        ]);
        self::generateTranslation('grp_tpc_error2', [
            'en' => 'Please enter a topic to add'
        ]);
        self::generateTranslation('grp_tpc_error3', [
            'en' => 'Your Topic Requires Approval From The Owner Of This Group'
        ]);
        self::generateTranslation('grp_tpc_msg', [
            'en' => 'Topic has been added'
        ]);
        self::generateTranslation('grp_comment_msg', [
            'en' => 'Comment has been added'
        ]);
        self::generateTranslation('grp_vdo_msg', [
            'en' => 'Videos Deleted'
        ]);
        self::generateTranslation('grp_vdo_msg1', [
            'en' => 'Videos Added Successfully'
        ]);
        self::generateTranslation('grp_vdo_msg2', [
            'en' => 'Videos Have Been Approved'
        ]);
        self::generateTranslation('grp_mem_msg', [
            'en' => 'Member Has Been Deleted'
        ]);
        self::generateTranslation('grp_mem_msg1', [
            'en' => 'Member Has Been Approved'
        ]);
        self::generateTranslation('grp_inv_msg', [
            'en' => 'Your Invitation Has Been Sent'
        ]);
        self::generateTranslation('grp_tpc_msg1', [
            'en' => 'Topic has been deleted'
        ]);
        self::generateTranslation('grp_tpc_msg2', [
            'en' => 'Topic Has Been Approved'
        ]);
        self::generateTranslation('grp_fr_msg2', [
            'en' => 'Group has been removed FROM featured list'
        ]);
        self::generateTranslation('grp_inv_msg1', [
            'en' => 'Has Invited You To Join '
        ]);
        self::generateTranslation('grp_av_msg', [
            'en' => 'Group has been activated'
        ]);
        self::generateTranslation('grp_da_msg', [
            'en' => 'Group has been deactivated'
        ]);
        self::generateTranslation('grp_post_msg', [
            'en' => 'Post Has Been Deleted'
        ]);
        self::generateTranslation('grp_update_msg', [
            'en' => 'Group has been updated'
        ]);
        self::generateTranslation('grp_owner_err', [
            'en' => 'Only Owner Can Add Videos To This Group'
        ]);
        self::generateTranslation('grp_owner_err1', [
            'en' => 'You are not owner of this group'
        ]);
        self::generateTranslation('grp_owner_err2', [
            'en' => 'You are the owner of this group. You cannot leave your group.'
        ]);
        self::generateTranslation('grp_prvt_err1', [
            'en' => 'This group is private, you need invitiation FROM its owner in order to join'
        ]);
        self::generateTranslation('grp_rmv_msg', [
            'en' => 'Selected Groups Have Been Removed From Your Account'
        ]);
        self::generateTranslation('grp_tpc_err4', [
            'en' => 'Sorry, Topic Doesn\'t Exist'
        ]);
        self::generateTranslation('grp_title_topic', [
            'en' => 'Groups - Topic - '
        ]);
        self::generateTranslation('grp_add_title', [
            'en' => '- Add Video'
        ]);
        self::generateTranslation('usr_sadmin_err', [
            'en' => 'You Cannot Set SuperAdmin Username as Blank'
        ]);
        self::generateTranslation('usr_cpass_err', [
            'en' => 'Confirm Password Doesn\'t Match'
        ]);
        self::generateTranslation('usr_pass_err', [
            'en' => 'Old password is incorrect'
        ]);
        self::generateTranslation('usr_email_err', [
            'en' => 'Please Provide A Valid Email Address'
        ]);
        self::generateTranslation('usr_cpass_err1', [
            'en' => 'Password confirmation is incorrect'
        ]);
        self::generateTranslation('usr_pass_err1', [
            'en' => 'Password is Incorrect'
        ]);
        self::generateTranslation('usr_cmt_err', [
            'en' => 'You Must Login First To Comment'
        ]);
        self::generateTranslation('usr_cmt_err1', [
            'en' => 'Please Type Something In the Comment Box'
        ]);
        self::generateTranslation('usr_cmt_err2', [
            'en' => 'You cannot comment on your video'
        ]);
        self::generateTranslation('usr_cmt_err3', [
            'en' => 'You Have Already Posted a Comment on this channel.'
        ]);
        self::generateTranslation('usr_cmt_err4', [
            'en' => 'Comment Has Been Added'
        ]);
        self::generateTranslation('usr_cmt_del_msg', [
            'en' => 'Comment Has Been Deleted'
        ]);
        self::generateTranslation('usr_cmt_del_err', [
            'en' => 'An Error Occured While deleting a Comment'
        ]);
        self::generateTranslation('usr_cnt_err', [
            'en' => 'You Cannot Add Yourself as a Contact'
        ]);
        self::generateTranslation('usr_cnt_err1', [
            'en' => 'You Have Already Added This User To Your Contact List'
        ]);
        self::generateTranslation('usr_sub_err', [
            'en' => 'You are already subscribed to %s'
        ]);
        self::generateTranslation('usr_exist_err', [
            'en' => 'User Doesn\'t Exist'
        ]);
        self::generateTranslation('usr_ccode_err', [
            'en' => 'Verification code you entered was wrong'
        ]);
        self::generateTranslation('usr_exist_err1', [
            'en' => 'Sorry, No User Exists With This Email'
        ]);
        self::generateTranslation('usr_exist_err2', [
            'en' => 'Sorry , User Doesn\'t Exist'
        ]);
        self::generateTranslation('usr_uname_err', [
            'en' => 'Username is empty'
        ]);
        self::generateTranslation('usr_uname_err2', [
            'en' => 'Username already exists'
        ]);
        self::generateTranslation('usr_pass_err2', [
            'en' => 'Password Is Empty'
        ]);
        self::generateTranslation('usr_email_err1', [
            'en' => 'Email is Empty'
        ]);
        self::generateTranslation('usr_email_err2', [
            'en' => 'Please Enter A Valid Email Address'
        ]);
        self::generateTranslation('usr_email_err3', [
            'en' => 'Email Address Is Already In Use'
        ]);
        self::generateTranslation('usr_pcode_err', [
            'en' => 'Postal Codes Only Contain Numbers'
        ]);
        self::generateTranslation('usr_fname_err', [
            'en' => 'First Name Is Empty'
        ]);
        self::generateTranslation('usr_lname_err', [
            'en' => 'Last Name Is Empty'
        ]);
        self::generateTranslation('usr_uname_err3', [
            'en' => 'Username Contains Unallowed Characters'
        ]);
        self::generateTranslation('usr_pass_err3', [
            'en' => 'Passwords MisMatched'
        ]);
        self::generateTranslation('usr_dob_err', [
            'en' => 'Please Select Date Of Birth'
        ]);
        self::generateTranslation('usr_ament_err', [
            'en' => 'Sorry, you need to agree to the terms of use and privacy policy to create an account'
        ]);
        self::generateTranslation('usr_reg_err', [
            'en' => 'Sorry, Registrations Are Temporarily Not Allowed, Please Try Again Later'
        ]);
        self::generateTranslation('usr_ban_err', [
            'en' => 'User account is banned, please contact website administrator'
        ]);
        self::generateTranslation('usr_login_err', [
            'en' => 'Username and Password Didn\'t Match'
        ]);
        self::generateTranslation('usr_sadmin_msg', [
            'en' => 'Super Admin Has Been Updated'
        ]);
        self::generateTranslation('usr_pass_msg', [
            'en' => 'Your Password Has Been Changed'
        ]);
        self::generateTranslation('usr_cnt_msg', [
            'en' => 'This User Has Been Added To Your Contact List'
        ]);
        self::generateTranslation('usr_sub_msg', [
            'en' => 'You are now subsribed to %s'
        ]);
        self::generateTranslation('usr_uname_email_msg', [
            'en' => 'We Have Sent you an Email containing Your Username, Please Check It'
        ]);
        self::generateTranslation('usr_rpass_email_msg', [
            'en' => 'An Email Has Been Sent To You. Please Follow the Instructions there to Reset Your Password'
        ]);
        self::generateTranslation('usr_pass_email_msg', [
            'en' => 'Password has been changed successfully'
        ]);
        self::generateTranslation('usr_email_msg', [
            'en' => 'Email Settings Has Been Updated'
        ]);
        self::generateTranslation('usr_del_msg', [
            'en' => 'User has been deleted'
        ]);
        self::generateTranslation('usr_dels_msg', [
            'en' => 'Selected Users Have Been Deleted'
        ]);
        self::generateTranslation('usr_ac_msg', [
            'en' => 'User has been activated'
        ]);
        self::generateTranslation('usr_dac_msg', [
            'en' => 'User has been deactivated'
        ]);
        self::generateTranslation('usr_mem_ac', [
            'en' => 'Selected Members Have Been Activated'
        ]);
        self::generateTranslation('usr_mems_ac', [
            'en' => 'Selected Members Have Been Deactivated'
        ]);
        self::generateTranslation('usr_fr_msg', [
            'en' => 'User Has Been Made a Featured Member'
        ]);
        self::generateTranslation('usr_ufr_msg', [
            'en' => 'User Has Been Unfeatured'
        ]);
        self::generateTranslation('usr_frs_msg', [
            'en' => 'Selected Users Have Been Set As Featured'
        ]);
        self::generateTranslation('usr_ufrs_msg', [
            'en' => 'Selected Users Have Been Removed From The Featured List'
        ]);
        self::generateTranslation('usr_uban_msg', [
            'en' => 'User Has Been Banned'
        ]);
        self::generateTranslation('usr_uuban_msg', [
            'en' => 'User Has Been Unbanned'
        ]);
        self::generateTranslation('usr_ubans_msg', [
            'en' => 'Selected Members Have Been Banned'
        ]);
        self::generateTranslation('usr_uubans_msg', [
            'en' => 'Selected Members Have Been Unbanned'
        ]);
        self::generateTranslation('usr_pass_reset_conf', [
            'en' => 'Password Reset Confirmation'
        ]);
        self::generateTranslation('usr_dear_user', [
            'en' => 'Dear User'
        ]);
        self::generateTranslation('usr_pass_reset_msg', [
            'en' => 'You Requested A Password Reset, Follow The Link To Reset Your Password'
        ]);
        self::generateTranslation('usr_rpass_msg', [
            'en' => 'Password Has Been Reset'
        ]);
        self::generateTranslation('usr_rpass_req_msg', [
            'en' => 'You Requested A Password Reset, Here is your new password : '
        ]);
        self::generateTranslation('usr_uname_req_msg', [
            'en' => 'You Requested to Recover Your Username, Here is your username: '
        ]);
        self::generateTranslation('usr_uname_recovery', [
            'en' => 'Username Recovery Email'
        ]);
        self::generateTranslation('usr_add_succ_msg', [
            'en' => 'User Has Been Added'
        ]);
        self::generateTranslation('usr_upd_succ_msg', [
            'en' => 'User has been updated'
        ]);
        self::generateTranslation('usr_activation_msg', [
            'en' => 'Your account has been activated. Now you can login to your account and upload videos'
        ]);
        self::generateTranslation('usr_activation_err', [
            'en' => 'This user is already activated'
        ]);
        self::generateTranslation('usr_activation_em_msg', [
            'en' => 'We have sent you an email containing your activation code, please check your mail box'
        ]);
        self::generateTranslation('usr_activation_em_err', [
            'en' => 'Email Doesn\'t Exist or a User With This Email is already Activated'
        ]);
        self::generateTranslation('usr_no_msg_del_err', [
            'en' => 'No Message Was Selected To Delete'
        ]);
        self::generateTranslation('usr_sel_msg_del_msg', [
            'en' => 'Selected Messages Have Been Deleted'
        ]);
        self::generateTranslation('usr_pof_upd_msg', [
            'en' => 'Profile has been updated'
        ]);
        self::generateTranslation('usr_arr_no_ans', [
            'en' => 'no answer'
        ]);
        self::generateTranslation('usr_arr_elementary', [
            'en' => 'Elementary'
        ]);
        self::generateTranslation('usr_arr_hi_school', [
            'en' => 'High School'
        ]);
        self::generateTranslation('usr_arr_some_colg', [
            'en' => 'Some College'
        ]);
        self::generateTranslation('usr_arr_assoc_deg', [
            'en' => 'Associates Degree'
        ]);
        self::generateTranslation('usr_arr_bach_deg', [
            'en' => 'Bachelor\'s Degree'
        ]);
        self::generateTranslation('usr_arr_mast_deg', [
            'en' => 'Master\'s Degree'
        ]);
        self::generateTranslation('usr_arr_phd', [
            'en' => 'Ph.D.'
        ]);
        self::generateTranslation('usr_arr_post_doc', [
            'en' => 'Postdoctoral'
        ]);
        self::generateTranslation('usr_arr_single', [
            'en' => 'Single'
        ]);
        self::generateTranslation('usr_arr_married', [
            'en' => 'Married'
        ]);
        self::generateTranslation('usr_arr_comitted', [
            'en' => 'Comitted'
        ]);
        self::generateTranslation('usr_arr_open_marriage', [
            'en' => 'Open Marriage'
        ]);
        self::generateTranslation('usr_arr_open_relate', [
            'en' => 'Open Relationship'
        ]);
        self::generateTranslation('title_crt_new_msg', [
            'en' => 'Compose New Message'
        ]);
        self::generateTranslation('title_forgot', [
            'en' => 'Forgot Something? Find it now !'
        ]);
        self::generateTranslation('title_inbox', [
            'en' => ' - Inbox'
        ]);
        self::generateTranslation('title_sent', [
            'en' => ' - Sent Folder'
        ]);
        self::generateTranslation('title_usr_contact', [
            'en' => '\'s Contact List'
        ]);
        self::generateTranslation('title_usr_fav_vids', [
            'en' => '%s\'s Favorite Videos'
        ]);
        self::generateTranslation('title_edit_video', [
            'en' => 'Edit Video - '
        ]);
        self::generateTranslation('vdo_title_err', [
            'en' => 'Please Enter Video Title'
        ]);
        self::generateTranslation('vdo_des_err', [
            'en' => 'Please Enter Video Description'
        ]);
        self::generateTranslation('vdo_tags_err', [
            'en' => 'Please Enter Tags For The Video'
        ]);
        self::generateTranslation('vdo_cat_err', [
            'en' => 'Please Choose At least 1 Category'
        ]);
        self::generateTranslation('vdo_cat_err1', [
            'en' => 'You Can Only Choose Up to 3 Categories'
        ]);
        self::generateTranslation('vdo_sub_email_msg', [
            'en' => ' and therefore this message is sent to you automatically that '
        ]);
        self::generateTranslation('vdo_has_upload_nv', [
            'en' => 'Has Uploaded New Video'
        ]);
        self::generateTranslation('vdo_del_selected', [
            'en' => 'Selected Videos Have Been Deleted'
        ]);
        self::generateTranslation('vdo_cheat_msg', [
            'en' => 'Please Don\'t Try To Cheat'
        ]);
        self::generateTranslation('vdo_limits_warn_msg', [
            'en' => 'Please Don\'t Try To Cross Your Limits'
        ]);
        self::generateTranslation('vdo_cmt_del_msg', [
            'en' => 'Comment Has Been Deleted'
        ]);
        self::generateTranslation('vdo_iac_msg', [
            'en' => 'Video Is Inactive - Please Contact Admin For Details'
        ]);
        self::generateTranslation('vdo_is_in_process', [
            'en' => 'Video Is Being Processed - Please Contact Administrator for further details'
        ]);
        self::generateTranslation('vdo_upload_allow_err', [
            'en' => 'Uploading Is Not Allowed By Website Owner'
        ]);
        self::generateTranslation('vdo_download_allow_err', [
            'en' => 'Video Downloading Is Not Allowed'
        ]);
        self::generateTranslation('vdo_edit_owner_err', [
            'en' => 'You Are Not Video Owner'
        ]);
        self::generateTranslation('vdo_embed_code_wrong', [
            'en' => 'Embed Code Was Wrong'
        ]);
        self::generateTranslation('vdo_seconds_err', [
            'en' => 'Wrong Value Entered For Seconds Field'
        ]);
        self::generateTranslation('vdo_mins_err', [
            'en' => 'Wrong Value Entered For Minutes Field'
        ]);
        self::generateTranslation('vdo_thumb_up_err', [
            'en' => 'Error In Uploading Thumb'
        ]);
        self::generateTranslation('class_error_occured', [
            'en' => 'Sorry, An Error Occured'
        ]);
        self::generateTranslation('class_cat_del_msg', [
            'en' => 'Category has been deleted'
        ]);
        self::generateTranslation('class_vdo_del_msg', [
            'en' => 'Video has been deleted'
        ]);
        self::generateTranslation('class_vdo_fr_msg', [
            'en' => 'Video has been marked as «Featured Video»'
        ]);
        self::generateTranslation('class_fr_msg1', [
            'en' => 'Video has been removed FROM «Featured Videos»'
        ]);
        self::generateTranslation('class_vdo_act_msg', [
            'en' => 'Video has been activated'
        ]);
        self::generateTranslation('class_vdo_act_msg1', [
            'en' => 'Video has been deactivated'
        ]);
        self::generateTranslation('class_vdo_update_msg', [
            'en' => 'Video details have been updated'
        ]);
        self::generateTranslation('class_comment_err', [
            'en' => 'You Must Login Before Postings Comments'
        ]);
        self::generateTranslation('class_comment_err1', [
            'en' => 'Please Type Something In The Comment Box'
        ]);
        self::generateTranslation('class_comment_err2', [
            'en' => 'You Cannot Post a Comment on  Your Own Video'
        ]);
        self::generateTranslation('class_comment_err3', [
            'en' => 'You Have Already Posted a Comment, Please Wait for the others.'
        ]);
        self::generateTranslation('class_comment_err4', [
            'en' => 'You Have Already Replied To That a Comment, Please Wait for the others.'
        ]);
        self::generateTranslation('class_comment_err5', [
            'en' => 'You Cannot Post a Reply To Yourself'
        ]);
        self::generateTranslation('class_comment_msg', [
            'en' => 'Comment Has Been Added'
        ]);
        self::generateTranslation('class_comment_err6', [
            'en' => 'Please login to rate comment'
        ]);
        self::generateTranslation('class_comment_err7', [
            'en' => 'You have already rated this comment'
        ]);
        self::generateTranslation('class_vdo_fav_err', [
            'en' => 'This Video is Already Added To Your Favorites'
        ]);
        self::generateTranslation('class_vdo_fav_msg', [
            'en' => 'This Video Has Been Added To Your Favorites'
        ]);
        self::generateTranslation('class_vdo_flag_err', [
            'en' => 'You Have Already Flagged This Video'
        ]);
        self::generateTranslation('class_vdo_flag_msg', [
            'en' => 'This Video Has Been Flagged As Inappropriate'
        ]);
        self::generateTranslation('class_vdo_flag_rm', [
            'en' => 'Flag(s) Has\/Have Been Removed'
        ]);
        self::generateTranslation('class_send_msg_err', [
            'en' => 'Please Enter a Username or Select any User to Send Message'
        ]);
        self::generateTranslation('class_invalid_user', [
            'en' => 'Invalid Username'
        ]);
        self::generateTranslation('class_subj_err', [
            'en' => 'Message subject was empty'
        ]);
        self::generateTranslation('class_msg_err', [
            'en' => 'Please Type Something In Message Box'
        ]);
        self::generateTranslation('class_sent_you_msg', [
            'en' => 'Sent You A Message'
        ]);
        self::generateTranslation('class_sent_prvt_msg', [
            'en' => 'Sent You A Private Message on '
        ]);
        self::generateTranslation('class_click_inbox', [
            'en' => 'Please Click here To View Your Inbox'
        ]);
        self::generateTranslation('class_click_login', [
            'en' => 'Click Here To Login'
        ]);
        self::generateTranslation('class_email_notify', [
            'en' => 'Email Notification'
        ]);
        self::generateTranslation('class_msg_has_sent_to', [
            'en' => 'Message Has Been Sent To '
        ]);
        self::generateTranslation('class_inbox_del_msg', [
            'en' => 'Message Has Been Delete From Inbox '
        ]);
        self::generateTranslation('class_sent_del_msg', [
            'en' => 'Message Has Been Delete From Sent Folder'
        ]);
        self::generateTranslation('class_msg_exist_err', [
            'en' => 'Message Doesn\'t Exist'
        ]);
        self::generateTranslation('class_vdo_del_err', [
            'en' => 'Video does not exist'
        ]);
        self::generateTranslation('class_unsub_msg', [
            'en' => 'You have been unsubscribed sucessfully'
        ]);
        self::generateTranslation('class_sub_exist_err', [
            'en' => 'Subscription Does Not Exist'
        ]);
        self::generateTranslation('class_vdo_rm_fav_msg', [
            'en' => 'Video Has Been Removed From Favourites'
        ]);
        self::generateTranslation('class_vdo_fav_err1', [
            'en' => 'This Video Is Not In Your Favourites List'
        ]);
        self::generateTranslation('class_cont_del_msg', [
            'en' => 'Contact Has Been Deleted'
        ]);
        self::generateTranslation('class_cot_err', [
            'en' => 'Sorry, This Contact Is Not In Your Contact List'
        ]);
        self::generateTranslation('class_vdo_ep_err1', [
            'en' => 'You Have Already Picked 10 Videos Please Delete Alteast One to Add More'
        ]);
        self::generateTranslation('class_vdo_exist_err', [
            'en' => 'Sorry, Video Doesn\'t Exist'
        ]);
        self::generateTranslation('class_img_gif_err', [
            'en' => 'Please Upload Gif Image Only'
        ]);
        self::generateTranslation('class_img_png_err', [
            'en' => 'Please Upload Png Image Only'
        ]);
        self::generateTranslation('class_img_jpg_err', [
            'en' => 'Please Upload Jpg Image Only'
        ]);
        self::generateTranslation('class_logo_msg', [
            'en' => 'Logo Has Been Changed. Please Clear Cache If You Are Not Able To See the Changed Logo'
        ]);
        self::generateTranslation('com_forgot_username', [
            'en' => 'Forgot Username | Password'
        ]);
        self::generateTranslation('com_join_now', [
            'en' => 'Join Now'
        ]);
        self::generateTranslation('com_my_account', [
            'en' => 'My Account'
        ]);
        self::generateTranslation('com_manage_vids', [
            'en' => 'Manage Videos'
        ]);
        self::generateTranslation('com_view_channel', [
            'en' => 'View My Channel'
        ]);
        self::generateTranslation('com_my_inbox', [
            'en' => 'My Inbox'
        ]);
        self::generateTranslation('com_welcome', [
            'en' => 'Welcome'
        ]);
        self::generateTranslation('com_top_mem', [
            'en' => 'Top Members '
        ]);
        self::generateTranslation('com_vidz', [
            'en' => 'Videos'
        ]);
        self::generateTranslation('com_sign_up_now', [
            'en' => 'Sign Up Now !'
        ]);
        self::generateTranslation('com_my_videos', [
            'en' => 'My Videos'
        ]);
        self::generateTranslation('com_my_channel', [
            'en' => 'My Channel'
        ]);
        self::generateTranslation('com_my_subs', [
            'en' => 'My Subscriptions'
        ]);
        self::generateTranslation('com_user_no_contacts', [
            'en' => 'User Does Not Have Any Contact'
        ]);
        self::generateTranslation('com_user_no_vides', [
            'en' => 'User Does Not Have Any Favourite Video'
        ]);
        self::generateTranslation('com_user_no_vid_com', [
            'en' => 'User Has No Video Comments'
        ]);
        self::generateTranslation('com_view_all_contacts', [
            'en' => 'View All Contacts of'
        ]);
        self::generateTranslation('com_view_fav_all_videos', [
            'en' => 'View All Favourite Videos Of'
        ]);
        self::generateTranslation('com_login_success_msg', [
            'en' => 'You Have Been Successfully Logged In.'
        ]);
        self::generateTranslation('com_logout_success_msg', [
            'en' => 'You Have Been Successfully Logged Out.'
        ]);
        self::generateTranslation('com_not_redirecting', [
            'en' => 'You are now Redirecting .'
        ]);
        self::generateTranslation('com_not_redirecting_msg', [
            'en' => 'if your are not redirecting'
        ]);
        self::generateTranslation('com_manage_contacts', [
            'en' => 'Manage Contacts '
        ]);
        self::generateTranslation('com_send_message', [
            'en' => 'Send Message'
        ]);
        self::generateTranslation('com_manage_fav', [
            'en' => 'Manage Favorites '
        ]);
        self::generateTranslation('com_manage_subs', [
            'en' => 'Manage Subscriptions'
        ]);
        self::generateTranslation('com_subscribe_to', [
            'en' => 'Subscribe to %s\'s channel'
        ]);
        self::generateTranslation('com_total_subs', [
            'en' => 'Total Subscribtions'
        ]);
        self::generateTranslation('com_total_vids', [
            'en' => 'Total Videos'
        ]);
        self::generateTranslation('com_date_subscribed', [
            'en' => 'Date Subscribed'
        ]);
        self::generateTranslation('com_search_results', [
            'en' => 'Search Results'
        ]);
        self::generateTranslation('com_advance_results', [
            'en' => 'Advanced Search'
        ]);
        self::generateTranslation('com_search_results_in', [
            'en' => 'Search Results In'
        ]);
        self::generateTranslation('videos_being_watched', [
            'en' => 'Recently Viewed...'
        ]);
        self::generateTranslation('latest_added_videos', [
            'en' => 'Recent Additions'
        ]);
        self::generateTranslation('most_viewed', [
            'en' => 'Most Viewed'
        ]);
        self::generateTranslation('recently_added', [
            'en' => 'Recently Added'
        ]);
        self::generateTranslation('featured', [
            'en' => 'Featured'
        ]);
        self::generateTranslation('highest_rated', [
            'en' => 'Highest Rated'
        ]);
        self::generateTranslation('most_discussed', [
            'en' => 'Most Discussed'
        ]);
        self::generateTranslation('style_change', [
            'en' => 'Style Change'
        ]);
        self::generateTranslation('rss_feed_latest_title', [
            'en' => 'RSS Feed for Most Recent Videos'
        ]);
        self::generateTranslation('rss_feed_featured_title', [
            'en' => 'RSS Feed for Featured Videos'
        ]);
        self::generateTranslation('rss_feed_most_viewed_title', [
            'en' => 'RSS Feed for Most Popular Videos'
        ]);
        self::generateTranslation('lang_folder', [
            'en' => 'en'
        ]);
        self::generateTranslation('reg_closed', [
            'en' => 'Registration Closed'
        ]);
        self::generateTranslation('reg_for', [
            'en' => 'Registration for'
        ]);
        self::generateTranslation('is_currently_closed', [
            'en' => 'is currently closed'
        ]);
        self::generateTranslation('about_us', [
            'en' => 'About Us'
        ]);
        self::generateTranslation('account', [
            'en' => 'Account'
        ]);
        self::generateTranslation('added', [
            'en' => 'Added'
        ]);
        self::generateTranslation('advertisements', [
            'en' => 'Advertisements'
        ]);
        self::generateTranslation('all', [
            'en' => 'All'
        ]);
        self::generateTranslation('active', [
            'en' => 'Active'
        ]);
        self::generateTranslation('activate', [
            'en' => 'Activate'
        ]);
        self::generateTranslation('deactivate', [
            'en' => 'Deactivate'
        ]);
        self::generateTranslation('age', [
            'en' => 'Age'
        ]);
        self::generateTranslation('approve', [
            'en' => 'Approve'
        ]);
        self::generateTranslation('approved', [
            'en' => 'Approved'
        ]);
        self::generateTranslation('approval', [
            'en' => 'Approval'
        ]);
        self::generateTranslation('books', [
            'en' => 'Books'
        ]);
        self::generateTranslation('browse', [
            'en' => 'Browse'
        ]);
        self::generateTranslation('by', [
            'en' => 'by'
        ]);
        self::generateTranslation('cancel', [
            'en' => 'Cancel'
        ]);
        self::generateTranslation('categories', [
            'en' => 'Categories'
        ]);
        self::generateTranslation('category', [
            'en' => 'Category'
        ]);
        self::generateTranslation('channels', [
            'en' => 'Channels'
        ]);
        self::generateTranslation('check_all', [
            'en' => 'Check All'
        ]);
        self::generateTranslation('click_here', [
            'en' => 'Click Here'
        ]);
        self::generateTranslation('comments', [
            'en' => 'Comments'
        ]);
        self::generateTranslation('comment', [
            'en' => 'Comment'
        ]);
        self::generateTranslation('community', [
            'en' => 'Community'
        ]);
        self::generateTranslation('companies', [
            'en' => 'Companies'
        ]);
        self::generateTranslation('contacts', [
            'en' => 'Contacts'
        ]);
        self::generateTranslation('contact_us', [
            'en' => 'Contact Us'
        ]);
        self::generateTranslation('country', [
            'en' => 'Country'
        ]);
        self::generateTranslation('created', [
            'en' => 'Created'
        ]);
        self::generateTranslation('date', [
            'en' => 'Date'
        ]);
        self::generateTranslation('date_added', [
            'en' => 'Date Added'
        ]);
        self::generateTranslation('date_joined', [
            'en' => 'Date Joined'
        ]);
        self::generateTranslation('dear', [
            'en' => 'Dear'
        ]);
        self::generateTranslation('delete', [
            'en' => 'Delete'
        ]);
        self::generateTranslation('add', [
            'en' => 'Add'
        ]);
        self::generateTranslation('delete_selected', [
            'en' => 'Delete Selected'
        ]);
        self::generateTranslation('des_title', [
            'en' => 'Description:'
        ]);
        self::generateTranslation('duration', [
            'en' => 'Duration'
        ]);
        self::generateTranslation('education', [
            'en' => 'Education'
        ]);
        self::generateTranslation('email', [
            'en' => 'email'
        ]);
        self::generateTranslation('embed', [
            'en' => 'Embed'
        ]);
        self::generateTranslation('embed_code', [
            'en' => 'Embed Code'
        ]);
        self::generateTranslation('favourite', [
            'en' => 'Favorite'
        ]);
        self::generateTranslation('favourited', [
            'en' => 'Favorited'
        ]);
        self::generateTranslation('favourites', [
            'en' => 'Favorites'
        ]);
        self::generateTranslation('female', [
            'en' => 'Female'
        ]);
        self::generateTranslation('filter', [
            'en' => 'Filter'
        ]);
        self::generateTranslation('forgot', [
            'en' => 'Forgot'
        ]);
        self::generateTranslation('friends', [
            'en' => 'Friends'
        ]);
        self::generateTranslation('FROM', [
            'en' => 'From'
        ]);
        self::generateTranslation('gender', [
            'en' => 'Gender'
        ]);
        self::generateTranslation('groups', [
            'en' => 'Groups'
        ]);
        self::generateTranslation('hello', [
            'en' => 'Hello'
        ]);
        self::generateTranslation('help', [
            'en' => 'Help'
        ]);
        self::generateTranslation('hi', [
            'en' => 'Hi'
        ]);
        self::generateTranslation('hobbies', [
            'en' => 'Hobbies'
        ]);
        self::generateTranslation('home', [
            'en' => 'Home'
        ]);
        self::generateTranslation('inbox', [
            'en' => 'Inbox'
        ]);
        self::generateTranslation('interests', [
            'en' => 'Interests'
        ]);
        self::generateTranslation('join_now', [
            'en' => 'Join Now'
        ]);
        self::generateTranslation('joined', [
            'en' => 'Joined'
        ]);
        self::generateTranslation('join', [
            'en' => 'Join'
        ]);
        self::generateTranslation('keywords', [
            'en' => 'Keywords'
        ]);
        self::generateTranslation('latest', [
            'en' => 'Latest'
        ]);
        self::generateTranslation('leave', [
            'en' => 'Leave'
        ]);
        self::generateTranslation('location', [
            'en' => 'Location'
        ]);
        self::generateTranslation('login', [
            'en' => 'Login'
        ]);
        self::generateTranslation('logout', [
            'en' => 'Logout'
        ]);
        self::generateTranslation('male', [
            'en' => 'Male'
        ]);
        self::generateTranslation('members', [
            'en' => 'Members'
        ]);
        self::generateTranslation('messages', [
            'en' => 'Messages'
        ]);
        self::generateTranslation('message', [
            'en' => 'Message'
        ]);
        self::generateTranslation('minute', [
            'en' => 'minute'
        ]);
        self::generateTranslation('minutes', [
            'en' => 'minutes'
        ]);
        self::generateTranslation('most_members', [
            'en' => 'Most Members'
        ]);
        self::generateTranslation('most_recent', [
            'en' => 'Most Recent'
        ]);
        self::generateTranslation('most_videos', [
            'en' => 'Most Videos'
        ]);
        self::generateTranslation('music', [
            'en' => 'Music'
        ]);
        self::generateTranslation('my_account', [
            'en' => 'My Account'
        ]);
        self::generateTranslation('next', [
            'en' => 'Next'
        ]);
        self::generateTranslation('no', [
            'en' => 'No'
        ]);
        self::generateTranslation('no_user_exists', [
            'en' => 'No User Exists'
        ]);
        self::generateTranslation('no_video_exists', [
            'en' => 'No Video Exists'
        ]);
        self::generateTranslation('occupations', [
            'en' => 'Occupations'
        ]);
        self::generateTranslation('optional', [
            'en' => 'optional'
        ]);
        self::generateTranslation('owner', [
            'en' => 'Owner'
        ]);
        self::generateTranslation('password', [
            'en' => 'password'
        ]);
        self::generateTranslation('please', [
            'en' => 'Please'
        ]);
        self::generateTranslation('privacy', [
            'en' => 'Privacy'
        ]);
        self::generateTranslation('privacy_policy', [
            'en' => 'Privacy Policy'
        ]);
        self::generateTranslation('random', [
            'en' => 'Random'
        ]);
        self::generateTranslation('rate', [
            'en' => 'Rate'
        ]);
        self::generateTranslation('request', [
            'en' => 'Request'
        ]);
        self::generateTranslation('related', [
            'en' => 'Related'
        ]);
        self::generateTranslation('reply', [
            'en' => 'Reply'
        ]);
        self::generateTranslation('results', [
            'en' => 'Results'
        ]);
        self::generateTranslation('relationship', [
            'en' => 'Relationship'
        ]);
        self::generateTranslation('second', [
            'en' => 'second'
        ]);
        self::generateTranslation('seconds', [
            'en' => 'seconds'
        ]);
        self::generateTranslation('SELECT', [
            'en' => 'Select'
        ]);
        self::generateTranslation('send', [
            'en' => 'Send'
        ]);
        self::generateTranslation('sent', [
            'en' => 'Sent'
        ]);
        self::generateTranslation('signup', [
            'en' => 'Signup'
        ]);
        self::generateTranslation('subject', [
            'en' => 'Subject'
        ]);
        self::generateTranslation('tags', [
            'en' => 'Tags'
        ]);
        self::generateTranslation('times', [
            'en' => 'Times'
        ]);
        self::generateTranslation('to', [
            'en' => 'To'
        ]);
        self::generateTranslation('type', [
            'en' => 'Type'
        ]);
        self::generateTranslation('update', [
            'en' => 'Update'
        ]);
        self::generateTranslation('upload', [
            'en' => 'Upload'
        ]);
        self::generateTranslation('url', [
            'en' => 'Url'
        ]);
        self::generateTranslation('verification', [
            'en' => 'Verification'
        ]);
        self::generateTranslation('videos', [
            'en' => 'Videos'
        ]);
        self::generateTranslation('viewing', [
            'en' => 'Viewing'
        ]);
        self::generateTranslation('welcome', [
            'en' => 'Welcome'
        ]);
        self::generateTranslation('website', [
            'en' => 'Website'
        ]);
        self::generateTranslation('yes', [
            'en' => 'Yes'
        ]);
        self::generateTranslation('of', [
            'en' => 'of'
        ]);
        self::generateTranslation('on', [
            'en' => 'on'
        ]);
        self::generateTranslation('previous', [
            'en' => 'Previous'
        ]);
        self::generateTranslation('rating', [
            'en' => 'Rating'
        ]);
        self::generateTranslation('ratings', [
            'en' => 'Ratings'
        ]);
        self::generateTranslation('remote_upload', [
            'en' => 'Remote Upload'
        ]);
        self::generateTranslation('remove', [
            'en' => 'Remove'
        ]);
        self::generateTranslation('search', [
            'en' => 'Search'
        ]);
        self::generateTranslation('services', [
            'en' => 'Services'
        ]);
        self::generateTranslation('show_all', [
            'en' => 'Show All'
        ]);
        self::generateTranslation('signupup', [
            'en' => 'Sign Up'
        ]);
        self::generateTranslation('sort_by', [
            'en' => 'Sort'
        ]);
        self::generateTranslation('subscriptions', [
            'en' => 'Subscriptions'
        ]);
        self::generateTranslation('subscribers', [
            'en' => 'Subscribers'
        ]);
        self::generateTranslation('tag_title', [
            'en' => 'Tags'
        ]);
        self::generateTranslation('track_title', [
            'en' => 'Audio track'
        ]);
        self::generateTranslation('time', [
            'en' => 'time'
        ]);
        self::generateTranslation('top', [
            'en' => 'Top'
        ]);
        self::generateTranslation('tos_title', [
            'en' => 'Terms of Use'
        ]);
        self::generateTranslation('username', [
            'en' => 'Username'
        ]);
        self::generateTranslation('views', [
            'en' => 'Views'
        ]);
        self::generateTranslation('proccession_wait', [
            'en' => 'Processing, Please Wait'
        ]);
        self::generateTranslation('mostly_viewed', [
            'en' => 'Most Viewed'
        ]);
        self::generateTranslation('most_comments', [
            'en' => 'Most Comments'
        ]);
        self::generateTranslation('group', [
            'en' => 'Group'
        ]);
        self::generateTranslation('not_logged_in', [
            'en' => 'You are not logged in or you do not have permission to access this page. This could be due to one of several reasons:'
        ]);
        self::generateTranslation('fill_auth_form', [
            'en' => 'You are not logged in. Fill in the form below and try again.'
        ]);
        self::generateTranslation('insufficient_privileges', [
            'en' => 'You may not have sufficient privileges to access this page.'
        ]);
        self::generateTranslation('admin_disabled_you', [
            'en' => 'The site administrator may have disabled your account, or it may be awaiting activation.'
        ]);
        self::generateTranslation('recover_password', [
            'en' => 'Recover Password'
        ]);
        self::generateTranslation('submit', [
            'en' => 'Submit'
        ]);
        self::generateTranslation('reset_Fields', [
            'en' => 'Reset Fields'
        ]);
        self::generateTranslation('admin_reg_req', [
            'en' => 'The administrator may have required you to register before you can view this page.'
        ]);
        self::generateTranslation('lang_change', [
            'en' => 'Language Change'
        ]);
        self::generateTranslation('lang_changed', [
            'en' => 'Your language has been changed'
        ]);
        self::generateTranslation('lang_choice', [
            'en' => 'Language'
        ]);
        self::generateTranslation('if_not_redir', [
            'en' => 'Click here to continue if you are not automatically redirected.'
        ]);
        self::generateTranslation('style_changed', [
            'en' => 'Your style has been changed'
        ]);
        self::generateTranslation('style_choice', [
            'en' => 'Style'
        ]);
        self::generateTranslation('vdo_edit_vdo', [
            'en' => 'Edit Video'
        ]);
        self::generateTranslation('vdo_stills', [
            'en' => 'Video Stills'
        ]);
        self::generateTranslation('vdo_watch_video', [
            'en' => 'Watch Video'
        ]);
        self::generateTranslation('vdo_video_details', [
            'en' => 'Video Details'
        ]);
        self::generateTranslation('vdo_title', [
            'en' => 'Title'
        ]);
        self::generateTranslation('vdo_desc', [
            'en' => 'Description'
        ]);
        self::generateTranslation('vdo_cat', [
            'en' => 'Video Category'
        ]);
        self::generateTranslation('vdo_cat_msg', [
            'en' => 'You May Select Up To %s Categories'
        ]);
        self::generateTranslation('vdo_tags_msg', [
            'en' => 'Tags are separated by commas ie Arslan Hassan, Awesome, ClipBucket'
        ]);
        self::generateTranslation('vdo_br_opt', [
            'en' => 'Broadcast Options'
        ]);
        self::generateTranslation('vdo_br_opt1', [
            'en' => 'Public - Share your video with Everyone! (Recommended)'
        ]);
        self::generateTranslation('vdo_br_opt2', [
            'en' => 'Private - Viewable by you and your friends only.'
        ]);
        self::generateTranslation('vdo_date_loc', [
            'en' => 'Date And Location'
        ]);
        self::generateTranslation('vdo_date_rec', [
            'en' => 'Date Recorded'
        ]);
        self::generateTranslation('vdo_for_date', [
            'en' => 'format MM \/ DD \/ YYYY '
        ]);
        self::generateTranslation('vdo_add_eg', [
            'en' => 'e.g London Greenland, Sialkot Mubarak Pura'
        ]);
        self::generateTranslation('vdo_share_opt', [
            'en' => 'Sharing and privacy options'
        ]);
        self::generateTranslation('vdo_allow_comm', [
            'en' => 'Allow Comments '
        ]);
        self::generateTranslation('vdo_dallow_comm', [
            'en' => 'Do Not Allow Comments'
        ]);
        self::generateTranslation('vdo_comm_vote', [
            'en' => 'Comments Voting'
        ]);
        self::generateTranslation('vdo_allow_com_vote', [
            'en' => 'Allow Voting on Comments'
        ]);
        self::generateTranslation('vdo_dallow_com_vote', [
            'en' => 'Do Not Allow on Comments'
        ]);
        self::generateTranslation('vdo_allow_rating', [
            'en' => 'Allow Rating on this video'
        ]);
        self::generateTranslation('vdo_embedding', [
            'en' => 'Embedding'
        ]);
        self::generateTranslation('vdo_embed_opt1', [
            'en' => 'People can play this video on other websites'
        ]);
        self::generateTranslation('vdo_update_title', [
            'en' => 'Update'
        ]);
        self::generateTranslation('vdo_inactive_msg', [
            'en' => 'Your Account is Inactive. Please Activate it to Upload Videos, To Activate your account Please'
        ]);
        self::generateTranslation('vdo_click_here', [
            'en' => 'Click Here'
        ]);
        self::generateTranslation('vdo_continue_upload', [
            'en' => 'Continue to Upload'
        ]);
        self::generateTranslation('vdo_upload_step1', [
            'en' => 'Video Upload'
        ]);
        self::generateTranslation('vdo_upload_step2', [
            'en' => 'Video Step %s\/2'
        ]);
        self::generateTranslation('vdo_upload_step3', [
            'en' => '(Step 2\/2)'
        ]);
        self::generateTranslation('vdo_select_vdo', [
            'en' => 'Select a video to upload.'
        ]);
        self::generateTranslation('vdo_enter_remote_url', [
            'en' => 'Enter Url Of The Video.'
        ]);
        self::generateTranslation('vdo_enter_embed_code_msg', [
            'en' => 'Enter Embed Video Code FROM other websites ie Youtube or Metacafe.'
        ]);
        self::generateTranslation('vdo_enter_embed_code', [
            'en' => 'Enter Embed Code'
        ]);
        self::generateTranslation('vdo_enter_druation', [
            'en' => 'Enter Duration'
        ]);
        self::generateTranslation('vdo_select_vdo_thumb', [
            'en' => 'Select Video Thumb'
        ]);
        self::generateTranslation('vdo_having_trouble', [
            'en' => 'Having Trouble?'
        ]);
        self::generateTranslation('vdo_if_having_problem', [
            'en' => 'if you are having problems with the uploader'
        ]);
        self::generateTranslation('vdo_clic_to_manage_all', [
            'en' => 'Click Here To Manage All Videos'
        ]);
        self::generateTranslation('vdo_manage_vdeos', [
            'en' => 'Manage Videos '
        ]);
        self::generateTranslation('vdo_status', [
            'en' => 'Status'
        ]);
        self::generateTranslation('vdo_rawfile', [
            'en' => 'RawFile'
        ]);
        self::generateTranslation('vdo_video_upload_complete', [
            'en' => 'Video Upload - Upload Complete'
        ]);
        self::generateTranslation('vdo_thanks_you_upload_complete_1', [
            'en' => 'Thank you! Your upload is complete'
        ]);
        self::generateTranslation('vdo_thanks_you_upload_complete_2', [
            'en' => 'This video will be available in'
        ]);
        self::generateTranslation('vdo_after_it_has_process', [
            'en' => 'after it has finished processing.'
        ]);
        self::generateTranslation('vdo_embed_this_video_on_web', [
            'en' => 'Embed this video on your website.'
        ]);
        self::generateTranslation('vdo_copy_and_paste_the_code', [
            'en' => 'Copy and paste the code below to embed this video.'
        ]);
        self::generateTranslation('vdo_upload_another_video', [
            'en' => 'Upload Another Video'
        ]);
        self::generateTranslation('vdo_goto_my_videos', [
            'en' => 'Goto My Videos'
        ]);
        self::generateTranslation('vdo_sperate_emails_by', [
            'en' => 'seperate emails by commas'
        ]);
        self::generateTranslation('vdo_personal_msg', [
            'en' => 'Personal Message'
        ]);
        self::generateTranslation('vdo_related_tags', [
            'en' => 'Related Tags'
        ]);
        self::generateTranslation('vdo_reply_to_this', [
            'en' => 'Reply To This '
        ]);
        self::generateTranslation('vdo_add_reply', [
            'en' => 'Add Reply'
        ]);
        self::generateTranslation('vdo_share_video', [
            'en' => 'Share Video'
        ]);
        self::generateTranslation('vdo_about_this_video', [
            'en' => 'About This Video'
        ]);
        self::generateTranslation('vdo_post_to_a_services', [
            'en' => 'Post to an Aggregating Service'
        ]);
        self::generateTranslation('vdo_commentary', [
            'en' => 'Commentary'
        ]);
        self::generateTranslation('vdo_post_a_comment', [
            'en' => 'Post A Comment'
        ]);
        self::generateTranslation('grp_add_vdo_msg', [
            'en' => 'Add Videos To Group '
        ]);
        self::generateTranslation('grp_no_vdo_msg', [
            'en' => 'You Don\'t Have Any Video'
        ]);
        self::generateTranslation('grp_add_to', [
            'en' => 'Add To Group'
        ]);
        self::generateTranslation('grp_add_vdos', [
            'en' => 'Add Videos'
        ]);
        self::generateTranslation('grp_name_title', [
            'en' => 'Group name'
        ]);
        self::generateTranslation('grp_tag_title', [
            'en' => 'Tags:'
        ]);
        self::generateTranslation('grp_des_title', [
            'en' => 'Description:'
        ]);
        self::generateTranslation('grp_tags_msg', [
            'en' => 'Enter one or more tags, separated by spaces.'
        ]);
        self::generateTranslation('grp_tags_msg1', [
            'en' => 'Enter one or more tags, separated by spaces. Tags  are keywords used to describe your group so it can be easily found by  other users. For example, if you have a group for surfers, you might  tag it: surfing, beach, waves.'
        ]);
        self::generateTranslation('grp_url_title', [
            'en' => 'Choose a unique group name URL:'
        ]);
        self::generateTranslation('grp_url_msg', [
            'en' => 'Enter 3-18 characters with no spaces (such as «skateboarding skates»), that will become part of your group\'s web address. Please note, the group name URL you pick is permanent and can\'t be changed.'
        ]);
        self::generateTranslation('grp_cat_tile', [
            'en' => 'Group Category:'
        ]);
        self::generateTranslation('grp_vdo_uploads', [
            'en' => 'Video Uploads:'
        ]);
        self::generateTranslation('grp_forum_posting', [
            'en' => 'Forum Posting:'
        ]);
        self::generateTranslation('grp_join_opt1', [
            'en' => 'Public, anyone can join.'
        ]);
        self::generateTranslation('grp_join_opt2', [
            'en' => 'Protected, requires founder approval to join.'
        ]);
        self::generateTranslation('grp_join_opt3', [
            'en' => 'Private, by founder invite only, only members can view group details.'
        ]);
        self::generateTranslation('grp_vdo_opt1', [
            'en' => 'Post videos immediately.'
        ]);
        self::generateTranslation('grp_vdo_opt2', [
            'en' => 'Founder approval required before video is available.'
        ]);
        self::generateTranslation('grp_vdo_opt3', [
            'en' => 'Only Founder can add new videos.'
        ]);
        self::generateTranslation('grp_post_opt1', [
            'en' => 'Post topics immediately.'
        ]);
        self::generateTranslation('grp_post_opt2', [
            'en' => 'Founder approval required before topic is available.'
        ]);
        self::generateTranslation('grp_post_opt3', [
            'en' => 'Only Founder can create a new topic.'
        ]);
        self::generateTranslation('grp_crt_grp', [
            'en' => 'Create Group'
        ]);
        self::generateTranslation('grp_thumb_title', [
            'en' => 'Group Thumb'
        ]);
        self::generateTranslation('grp_upl_thumb', [
            'en' => 'Upload Group Thumb'
        ]);
        self::generateTranslation('grp_must_be', [
            'en' => 'Must Be'
        ]);
        self::generateTranslation('grp_90x90', [
            'en' => '90  x 90 Ratio Will Give Best Quality'
        ]);
        self::generateTranslation('grp_thumb_warn', [
            'en' => 'Do Not Upload Vulgar or Copyrighted Material'
        ]);
        self::generateTranslation('grp_del_confirm', [
            'en' => 'Are You Sure You Want To Delete This Group'
        ]);
        self::generateTranslation('grp_del_success', [
            'en' => 'You Have Successfully Deleted'
        ]);
        self::generateTranslation('grp_click_go_grps', [
            'en' => 'Click Here To Go To Groups'
        ]);
        self::generateTranslation('grp_edit_grp_title', [
            'en' => 'Edit Group'
        ]);
        self::generateTranslation('grp_manage_vdos', [
            'en' => 'Manage Videos'
        ]);
        self::generateTranslation('grp_manage_mems', [
            'en' => 'Manage Members'
        ]);
        self::generateTranslation('grp_del_group_title', [
            'en' => 'Delete Group'
        ]);
        self::generateTranslation('grp_add_vdos_title', [
            'en' => 'Add Videos'
        ]);
        self::generateTranslation('grp_join_grp_title', [
            'en' => 'Join Group'
        ]);
        self::generateTranslation('grp_leave_group_title', [
            'en' => 'Leave Group'
        ]);
        self::generateTranslation('grp_invite_grp_title', [
            'en' => 'Invite Members'
        ]);
        self::generateTranslation('grp_view_mems', [
            'en' => 'View Members'
        ]);
        self::generateTranslation('grp_view_vdos', [
            'en' => 'View Videos'
        ]);
        self::generateTranslation('grp_create_grp_title', [
            'en' => 'Create A New Group'
        ]);
        self::generateTranslation('grp_most_members', [
            'en' => 'Most Members'
        ]);
        self::generateTranslation('grp_most_discussed', [
            'en' => 'Most Discussed'
        ]);
        self::generateTranslation('grp_invite_msg', [
            'en' => 'Invite Users To This Group'
        ]);
        self::generateTranslation('grp_invite_msg1', [
            'en' => 'Has Invited You To Join'
        ]);
        self::generateTranslation('grp_invite_msg2', [
            'en' => 'Enter Emails or Usernames (seperate by commas)'
        ]);
        self::generateTranslation('grp_url_title1', [
            'en' => 'Group url'
        ]);
        self::generateTranslation('grp_invite_msg3', [
            'en' => 'Send Invitation'
        ]);
        self::generateTranslation('grp_join_confirm_msg', [
            'en' => 'Are You Sure You Want To Join This Group'
        ]);
        self::generateTranslation('grp_join_msg_succ', [
            'en' => 'You have successfully joined group'
        ]);
        self::generateTranslation('grp_click_here_to_go', [
            'en' => 'Click Here To Go To'
        ]);
        self::generateTranslation('grp_leave_confirm', [
            'en' => 'Are You Sure You Want To Leave This Group'
        ]);
        self::generateTranslation('grp_leave_succ_msg', [
            'en' => 'You have left the group'
        ]);
        self::generateTranslation('grp_manage_members_title', [
            'en' => 'Manage Members '
        ]);
        self::generateTranslation('grp_for_approval', [
            'en' => 'For Approval'
        ]);
        self::generateTranslation('grp_rm_videos', [
            'en' => 'Remove Videos'
        ]);
        self::generateTranslation('grp_rm_mems', [
            'en' => 'Remove Members'
        ]);
        self::generateTranslation('grp_groups_title', [
            'en' => 'Manage Groups'
        ]);
        self::generateTranslation('grp_joined_title', [
            'en' => 'Manage Joined Groups'
        ]);
        self::generateTranslation('grp_remove_group', [
            'en' => 'Remove Group'
        ]);
        self::generateTranslation('grp_bo_grp_found', [
            'en' => 'No Group Found'
        ]);
        self::generateTranslation('grp_joined_groups', [
            'en' => 'Joined Groups'
        ]);
        self::generateTranslation('grp_owned_groups', [
            'en' => 'Owned Groups'
        ]);
        self::generateTranslation('grp_edit_this_grp', [
            'en' => 'Edit This Group'
        ]);
        self::generateTranslation('grp_topics_title', [
            'en' => 'Topics'
        ]);
        self::generateTranslation('grp_topic_title', [
            'en' => 'Topic'
        ]);
        self::generateTranslation('grp_posts_title', [
            'en' => 'Posts'
        ]);
        self::generateTranslation('grp_discus_title', [
            'en' => 'Discussions'
        ]);
        self::generateTranslation('grp_author_title', [
            'en' => 'Author'
        ]);
        self::generateTranslation('grp_replies_title', [
            'en' => 'Replies'
        ]);
        self::generateTranslation('grp_last_post_title', [
            'en' => 'Last Post '
        ]);
        self::generateTranslation('grp_viewl_all_videos', [
            'en' => 'View All Videos of This Group'
        ]);
        self::generateTranslation('grp_add_new_topic', [
            'en' => 'Add New Topic'
        ]);
        self::generateTranslation('grp_attach_video', [
            'en' => 'Attach Video '
        ]);
        self::generateTranslation('grp_add_topic', [
            'en' => 'Add Topic'
        ]);
        self::generateTranslation('grp_please_login', [
            'en' => 'Please login to post topics'
        ]);
        self::generateTranslation('grp_please_join', [
            'en' => 'Please Join This Group To Post Topics'
        ]);
        self::generateTranslation('grp_inactive_account', [
            'en' => 'Your Account Is Inactive And Requires Activation From The Group Owner'
        ]);
        self::generateTranslation('grp_about_this_grp', [
            'en' => 'About This Group '
        ]);
        self::generateTranslation('grp_no_vdo_err', [
            'en' => 'This Group Has No Vidoes'
        ]);
        self::generateTranslation('grp_posted_by', [
            'en' => 'Posted by'
        ]);
        self::generateTranslation('grp_add_new_comment', [
            'en' => 'Add New Comment'
        ]);
        self::generateTranslation('grp_add_comment', [
            'en' => 'Add Comment'
        ]);
        self::generateTranslation('grp_pls_login_comment', [
            'en' => 'Please Login To Post Comments'
        ]);
        self::generateTranslation('grp_pls_join_comment', [
            'en' => 'Please Join This Group To Post Comments'
        ]);
        self::generateTranslation('usr_activation_title', [
            'en' => 'User Activation'
        ]);
        self::generateTranslation('usr_actiavation_msg', [
            'en' => 'Enter Your Username and Activation Code that has been sent to your email.'
        ]);
        self::generateTranslation('usr_actiavation_msg1', [
            'en' => 'Request Activation Code'
        ]);
        self::generateTranslation('usr_activation_code_tl', [
            'en' => 'Activation Code'
        ]);
        self::generateTranslation('usr_compose_msg', [
            'en' => 'Compose Message'
        ]);
        self::generateTranslation('usr_inbox_title', [
            'en' => 'Inbox'
        ]);
        self::generateTranslation('usr_sent_title', [
            'en' => 'Sent'
        ]);
        self::generateTranslation('usr_to_title', [
            'en' => 'To: (Enter Username)'
        ]);
        self::generateTranslation('usr_or_select_frm_list', [
            'en' => 'or SELECT FROM contact list'
        ]);
        self::generateTranslation('usr_attach_video', [
            'en' => 'Attach Video'
        ]);
        self::generateTranslation('user_attached_video', [
            'en' => 'Attached Video'
        ]);
        self::generateTranslation('usr_send_message', [
            'en' => 'Send Message'
        ]);
        self::generateTranslation('user_no_message', [
            'en' => 'No Message'
        ]);
        self::generateTranslation('user_delete_message_msg', [
            'en' => 'Delete This Message'
        ]);
        self::generateTranslation('user_forgot_message', [
            'en' => 'Forgot password'
        ]);
        self::generateTranslation('user_forgot_message_2', [
            'en' => 'Dont Worry, recover it now'
        ]);
        self::generateTranslation('user_pass_reset_msg', [
            'en' => 'Password Reset'
        ]);
        self::generateTranslation('user_pass_forgot_msg', [
            'en' => 'if you have forgot your password, please enter you username and verification code in the box, and password reset instructions will be sent to your mail box.'
        ]);
        self::generateTranslation('user_veri_code', [
            'en' => 'Verification Code'
        ]);
        self::generateTranslation('user_reocover_user', [
            'en' => 'Recover Username'
        ]);
        self::generateTranslation('user_user_forgot_msg', [
            'en' => 'Forgot Username?'
        ]);
        self::generateTranslation('user_recover', [
            'en' => 'Recover'
        ]);
        self::generateTranslation('user_reset', [
            'en' => 'Reset'
        ]);
        self::generateTranslation('user_inactive_msg', [
            'en' => 'Your account is inactive, please activate your account by going to <a href=\".\/activation.php\">activation page<\/a>'
        ]);
        self::generateTranslation('user_dashboard', [
            'en' => 'Dash Board'
        ]);
        self::generateTranslation('user_manage_prof_chnnl', [
            'en' => 'Manage Profile &amp; Channel'
        ]);
        self::generateTranslation('user_manage_friends', [
            'en' => 'Manage Friends &amp; Contacts'
        ]);
        self::generateTranslation('user_prof_channel', [
            'en' => 'Profile\/Channel'
        ]);
        self::generateTranslation('user_message_box', [
            'en' => 'Message Box'
        ]);
        self::generateTranslation('user_new_messages', [
            'en' => 'New Messages'
        ]);
        self::generateTranslation('user_goto_inbox', [
            'en' => 'Go to Inbox'
        ]);
        self::generateTranslation('user_goto_sentbox', [
            'en' => 'Go to Sent Box'
        ]);
        self::generateTranslation('user_compose_new', [
            'en' => 'Compose New Messages'
        ]);
        self::generateTranslation('user_total_subs_users', [
            'en' => 'Total Subscribed Users'
        ]);
        self::generateTranslation('user_you_have', [
            'en' => 'You Have'
        ]);
        self::generateTranslation('user_fav_videos', [
            'en' => 'Favorite Videos'
        ]);
        self::generateTranslation('user_your_vids_watched', [
            'en' => 'Your Videos Watched'
        ]);
        self::generateTranslation('user_times', [
            'en' => 'Times'
        ]);
        self::generateTranslation('user_you_have_watched', [
            'en' => 'You Have Watched'
        ]);
        self::generateTranslation('user_channel_profiles', [
            'en' => 'Channel and Profile'
        ]);
        self::generateTranslation('user_channel_views', [
            'en' => 'Channel Views'
        ]);
        self::generateTranslation('user_channel_comm', [
            'en' => 'Channel Comments '
        ]);
        self::generateTranslation('user_manage_prof', [
            'en' => 'Manage Profile \/ Channel'
        ]);
        self::generateTranslation('user_you_created', [
            'en' => 'You Have Created'
        ]);
        self::generateTranslation('user_you_joined', [
            'en' => 'You Have Joined'
        ]);
        self::generateTranslation('user_create_group', [
            'en' => 'Create New Group'
        ]);
        self::generateTranslation('user_manage_my_account', [
            'en' => 'Manage My Account '
        ]);
        self::generateTranslation('user_manage_my_videos', [
            'en' => 'Manage My Videos'
        ]);
        self::generateTranslation('user_manage_my_channel', [
            'en' => 'Manage My Channel'
        ]);
        self::generateTranslation('user_sent_box', [
            'en' => 'My sent items'
        ]);
        self::generateTranslation('user_manage_channel', [
            'en' => 'Manage Channel'
        ]);
        self::generateTranslation('user_manage_my_contacts', [
            'en' => 'Manage My Contacts'
        ]);
        self::generateTranslation('user_manage_contacts', [
            'en' => 'Manage Contacts'
        ]);
        self::generateTranslation('user_manage_favourites', [
            'en' => 'Manage Favourite Videos'
        ]);
        self::generateTranslation('user_mem_login', [
            'en' => 'Members Login'
        ]);
        self::generateTranslation('user_already_have', [
            'en' => 'Please Login Here if You Already have an account of'
        ]);
        self::generateTranslation('user_forgot_username', [
            'en' => 'Forgot Username'
        ]);
        self::generateTranslation('user_forgot_password', [
            'en' => 'Forgot Password'
        ]);
        self::generateTranslation('user_create_your', [
            'en' => 'Create Your '
        ]);
        self::generateTranslation('all_fields_req', [
            'en' => 'All Fields Are Required'
        ]);
        self::generateTranslation('user_valid_email_addr', [
            'en' => 'Valid Email Address'
        ]);
        self::generateTranslation('user_allowed_format', [
            'en' => 'Letters A-Z or a-z , Numbers 0-9 and Underscores _'
        ]);
        self::generateTranslation('user_confirm_pass', [
            'en' => 'Confirm Password'
        ]);
        self::generateTranslation('user_reg_msg_0', [
            'en' => 'Register as '
        ]);
        self::generateTranslation('user_reg_msg_1', [
            'en' => 'member, its free and easy just fill out the form below'
        ]);
        self::generateTranslation('user_date_of_birth', [
            'en' => 'Date Of Birth'
        ]);
        self::generateTranslation('user_enter_text_as_img', [
            'en' => 'Enter Text As Seen In The Image'
        ]);
        self::generateTranslation('user_refresh_img', [
            'en' => 'Refresh Image'
        ]);
        self::generateTranslation('user_i_agree_to_the', [
            'en' => 'I Agree to  <a href=\"%s\" target=\"_blank\">Terms of Service<\/a> and <a href=\"%s\" target=\"_blank\" >Privacy Policy<\/a>'
        ]);
        self::generateTranslation('user_thanks_for_reg', [
            'en' => 'Thank You For Registering on '
        ]);
        self::generateTranslation('user_email_has_sent', [
            'en' => 'An email has been sent to your inbox containing Your Account'
        ]);
        self::generateTranslation('user_and_activation', [
            'en' => '&amp; Activation'
        ]);
        self::generateTranslation('user_details_you_now', [
            'en' => 'Details. You may now do the following things on our network'
        ]);
        self::generateTranslation('user_upload_share_vds', [
            'en' => 'Upload, Share Videos'
        ]);
        self::generateTranslation('user_make_friends', [
            'en' => 'Make Friends'
        ]);
        self::generateTranslation('user_send_messages', [
            'en' => 'Send Messages'
        ]);
        self::generateTranslation('user_grow_your_network', [
            'en' => 'Grow Your Networks by Inviting more Friends'
        ]);
        self::generateTranslation('user_rate_comment', [
            'en' => 'Rate and Comment Videos'
        ]);
        self::generateTranslation('user_make_customize', [
            'en' => 'Make and Customize Your Channel'
        ]);
        self::generateTranslation('user_to_upload_vid', [
            'en' => 'To Upload Video, You Need to Activate your account first, activation details has been sent to your email account, it may take sometimes to reach your inbox'
        ]);
        self::generateTranslation('user_click_to_login', [
            'en' => 'Click here To Login To Your Account'
        ]);
        self::generateTranslation('user_view_my_channel', [
            'en' => 'View My Channel'
        ]);
        self::generateTranslation('user_change_pass', [
            'en' => 'Change Password'
        ]);
        self::generateTranslation('user_email_settings', [
            'en' => 'Email Settings'
        ]);
        self::generateTranslation('user_profile_settings', [
            'en' => 'Profile Settings'
        ]);
        self::generateTranslation('user_usr_prof_chnl_edit', [
            'en' => 'User Profile &amp; Channel Edit'
        ]);
        self::generateTranslation('user_personal_info', [
            'en' => 'Personal Information'
        ]);
        self::generateTranslation('user_fname', [
            'en' => 'First Name'
        ]);
        self::generateTranslation('user_lname', [
            'en' => 'Last Name'
        ]);
        self::generateTranslation('user_gender', [
            'en' => 'Gender'
        ]);
        self::generateTranslation('user_relat_status', [
            'en' => 'Relationship Status'
        ]);
        self::generateTranslation('user_display_age', [
            'en' => 'Display Age'
        ]);
        self::generateTranslation('user_about_me', [
            'en' => 'About Me'
        ]);
        self::generateTranslation('user_website_url', [
            'en' => 'Website Url'
        ]);
        self::generateTranslation('user_eg_website', [
            'en' => 'e.g www.cafepixie.com'
        ]);
        self::generateTranslation('user_prof_info', [
            'en' => 'Professional Information'
        ]);
        self::generateTranslation('user_education', [
            'en' => 'Education'
        ]);
        self::generateTranslation('user_school_colleges', [
            'en' => 'Schools \/ Colleges'
        ]);
        self::generateTranslation('user_occupations', [
            'en' => 'Occupation(s)'
        ]);
        self::generateTranslation('user_companies', [
            'en' => 'Companies'
        ]);
        self::generateTranslation('user_sperate_by_commas', [
            'en' => 'seperate with commas'
        ]);
        self::generateTranslation('user_interests_hobbies', [
            'en' => 'Interests and Hobbies'
        ]);
        self::generateTranslation('user_fav_movs_shows', [
            'en' => 'Favorite Movies &amp; Shows'
        ]);
        self::generateTranslation('user_fav_music', [
            'en' => 'Favorite Music'
        ]);
        self::generateTranslation('user_fav_books', [
            'en' => 'Favorite Books'
        ]);
        self::generateTranslation('user_user_avatar', [
            'en' => 'User Avatar'
        ]);
        self::generateTranslation('user_upload_avatar', [
            'en' => 'Upload Avatar'
        ]);
        self::generateTranslation('user_channel_info', [
            'en' => 'Channel Info'
        ]);
        self::generateTranslation('user_channel_title', [
            'en' => 'Channel Title'
        ]);
        self::generateTranslation('user_channel_description', [
            'en' => 'Channel Description'
        ]);
        self::generateTranslation('user_channel_permission', [
            'en' => 'Channel Permissions'
        ]);
        self::generateTranslation('user_allow_comments_msg', [
            'en' => 'users can comment'
        ]);
        self::generateTranslation('user_dallow_comments_msg', [
            'en' => 'users cannot comment'
        ]);
        self::generateTranslation('user_allow_rating', [
            'en' => 'Allow Rating'
        ]);
        self::generateTranslation('user_dallow_rating', [
            'en' => 'Do Not Allow Rating'
        ]);
        self::generateTranslation('user_allow_rating_msg1', [
            'en' => 'users can rate'
        ]);
        self::generateTranslation('user_dallow_rating_msg1', [
            'en' => 'users cannot rate'
        ]);
        self::generateTranslation('user_channel_feature_vid', [
            'en' => 'Channel Featured Video'
        ]);
        self::generateTranslation('user_select_vid_for_fr', [
            'en' => 'Select Video To set as Featured'
        ]);
        self::generateTranslation('user_chane_channel_bg', [
            'en' => 'Change Channel Background'
        ]);
        self::generateTranslation('user_remove_bg', [
            'en' => 'Remove Background'
        ]);
        self::generateTranslation('user_currently_you_d_have_pic', [
            'en' => 'Currently You Don\'t Have a Background Picture'
        ]);
        self::generateTranslation('user_change_email', [
            'en' => 'Change Email'
        ]);
        self::generateTranslation('user_email_address', [
            'en' => 'Email Address'
        ]);
        self::generateTranslation('user_new_email', [
            'en' => 'New Email'
        ]);
        self::generateTranslation('user_notify_me', [
            'en' => 'Notify Me When User Sends Me A Message'
        ]);
        self::generateTranslation('user_old_pass', [
            'en' => 'Old Password'
        ]);
        self::generateTranslation('user_new_pass', [
            'en' => 'New Password'
        ]);
        self::generateTranslation('user_c_new_pass', [
            'en' => 'Confirm New Password'
        ]);
        self::generateTranslation('user_doesnt_exist', [
            'en' => 'User Doesn\'t Exist'
        ]);
        self::generateTranslation('user_do_not_have_contact', [
            'en' => 'User Does Not Have Any Contacts'
        ]);
        self::generateTranslation('user_no_fav_video_exist', [
            'en' => 'User does not have any Favorite Videos selected'
        ]);
        self::generateTranslation('user_have_no_vide', [
            'en' => 'User doesn\'t have any videos'
        ]);
        self::generateTranslation('user_s_channel', [
            'en' => '%s\'s Channel'
        ]);
        self::generateTranslation('user_last_login', [
            'en' => 'Last Login'
        ]);
        self::generateTranslation('user_send_message', [
            'en' => 'Send Message'
        ]);
        self::generateTranslation('user_add_contact', [
            'en' => 'Add Contact'
        ]);
        self::generateTranslation('user_dob', [
            'en' => 'DoB'
        ]);
        self::generateTranslation('user_movies_shows', [
            'en' => 'Movies &amp; Shows'
        ]);
        self::generateTranslation('user_add_comment', [
            'en' => 'Add Comment '
        ]);
        self::generateTranslation('user_no_fr_video', [
            'en' => 'User Has Not Selected Any Video To Set As Featured'
        ]);
        self::generateTranslation('user_view_all_video_of', [
            'en' => 'View All Videos of '
        ]);
        self::generateTranslation('menu_home', [
            'en' => 'Home'
        ]);
        self::generateTranslation('menu_inbox', [
            'en' => 'Inbox'
        ]);
        self::generateTranslation('vdo_cat_err2', [
            'en' => 'You cannot SELECT more than %d categories'
        ]);
        self::generateTranslation('user_subscribe_message', [
            'en' => 'Hello %subscriber%\nYou Have Subscribed To %user% and therefore this message is sent to you automatically, because %user% Has Uploaded a New Video\n\n%website_title%'
        ]);
        self::generateTranslation('user_subscribe_subject', [
            'en' => '%user% has uploaded a new video'
        ]);
        self::generateTranslation('you_already_logged', [
            'en' => 'You are already logged in'
        ]);
        self::generateTranslation('you_not_logged_in', [
            'en' => 'You are not logged in'
        ]);
        self::generateTranslation('invalid_user', [
            'en' => 'Invalid User'
        ]);
        self::generateTranslation('vdo_cat_err3', [
            'en' => 'Please SELECT at least 1 category'
        ]);
        self::generateTranslation('embed_code_invalid_err', [
            'en' => 'Invalid video embed code'
        ]);
        self::generateTranslation('invalid_duration', [
            'en' => 'Invalid duration'
        ]);
        self::generateTranslation('vid_thumb_changed', [
            'en' => 'Video default thumb has been changed'
        ]);
        self::generateTranslation('vid_thumb_change_err', [
            'en' => 'Video thumbnail was not found'
        ]);
        self::generateTranslation('upload_vid_thumbs_msg', [
            'en' => 'All video thumbs have been uploaded'
        ]);
        self::generateTranslation('video_thumb_delete_msg', [
            'en' => 'Video thumb has been deleted'
        ]);
        self::generateTranslation('video_thumb_delete_err', [
            'en' => 'Could not delete video thumb'
        ]);
        self::generateTranslation('no_comment_del_perm', [
            'en' => 'You dont have permission to delete this comment'
        ]);
        self::generateTranslation('my_text_context', [
            'en' => 'My test context'
        ]);
        self::generateTranslation('user_contains_disallow_err', [
            'en' => 'Username contains disallowed characters'
        ]);
        self::generateTranslation('add_cat_erro', [
            'en' => 'Category already exists'
        ]);
        self::generateTranslation('add_cat_no_name_err', [
            'en' => 'Please enter a name for the category'
        ]);
        self::generateTranslation('cat_default_err', [
            'en' => 'Default cannot be deleted, please choose another category as «default» and then delete this one'
        ]);
        self::generateTranslation('pic_upload_vali_err', [
            'en' => 'Please upload valid JPG, GIF or PNG image'
        ]);
        self::generateTranslation('cat_dir_make_err', [
            'en' => 'Unable to create the category thumb directory'
        ]);
        self::generateTranslation('cat_set_default_ok', [
            'en' => 'Category has been set as default'
        ]);
        self::generateTranslation('vid_thumb_removed_msg', [
            'en' => 'Video thumbs have been removed'
        ]);
        self::generateTranslation('vid_files_removed_msg', [
            'en' => 'Video files have been removed'
        ]);
        self::generateTranslation('vid_log_delete_msg', [
            'en' => 'Video log has been deleted'
        ]);
        self::generateTranslation('vdo_multi_del_erro', [
            'en' => 'Videos has have been deleted'
        ]);
        self::generateTranslation('add_fav_message', [
            'en' => 'This %s has been added to your favorites'
        ]);
        self::generateTranslation('obj_not_exists', [
            'en' => '%s does not exist'
        ]);
        self::generateTranslation('already_fav_message', [
            'en' => 'This %s is already added to your favorites'
        ]);
        self::generateTranslation('obj_report_msg', [
            'en' => 'This %s has been reported'
        ]);
        self::generateTranslation('obj_report_err', [
            'en' => 'You have already reported this %s'
        ]);
        self::generateTranslation('user_no_exist_wid_username', [
            'en' => '\'%s\' does not exist'
        ]);
        self::generateTranslation('share_video_no_user_err', [
            'en' => 'Please enter usernames or emails to send this %s'
        ]);
        self::generateTranslation('today', [
            'en' => 'Today'
        ]);
        self::generateTranslation('yesterday', [
            'en' => 'Yesterday'
        ]);
        self::generateTranslation('thisweek', [
            'en' => 'This Week'
        ]);
        self::generateTranslation('lastweek', [
            'en' => 'Last Week'
        ]);
        self::generateTranslation('thismonth', [
            'en' => 'This Month'
        ]);
        self::generateTranslation('lastmonth', [
            'en' => 'Last Month'
        ]);
        self::generateTranslation('thisyear', [
            'en' => 'This Year'
        ]);
        self::generateTranslation('lastyear', [
            'en' => 'Last Year'
        ]);
        self::generateTranslation('favorites', [
            'en' => 'Favorites'
        ]);
        self::generateTranslation('alltime', [
            'en' => 'All Time'
        ]);
        self::generateTranslation('insufficient_privileges_loggin', [
            'en' => 'You cannot access this page, please login or register'
        ]);
        self::generateTranslation('profile_title', [
            'en' => 'Profile Title'
        ]);
        self::generateTranslation('show_dob', [
            'en' => 'Show Date of Birth'
        ]);
        self::generateTranslation('profile_tags', [
            'en' => 'Profile Tags'
        ]);
        self::generateTranslation('profile_desc', [
            'en' => 'Profile Description'
        ]);
        self::generateTranslation('online_status', [
            'en' => 'User Status'
        ]);
        self::generateTranslation('show_profile', [
            'en' => 'Show Profile'
        ]);
        self::generateTranslation('allow_ratings', [
            'en' => 'Allow Profile Ratings'
        ]);
        self::generateTranslation('postal_code', [
            'en' => 'Postal Code'
        ]);
        self::generateTranslation('temp_file_load_err', [
            'en' => 'Unable to load tempalte file \'%s\' in directory \'%s\''
        ]);
        self::generateTranslation('no_date_provided', [
            'en' => 'No date provided'
        ]);
        self::generateTranslation('bad_date', [
            'en' => 'Never'
        ]);
        self::generateTranslation('users_videos', [
            'en' => '%s\'s Videos'
        ]);
        self::generateTranslation('please_login_subscribe', [
            'en' => 'Please login to Subsribe %s'
        ]);
        self::generateTranslation('users_subscribers', [
            'en' => '%s\'s Subscribers'
        ]);
        self::generateTranslation('user_no_subscribers', [
            'en' => '%s has no subsribers'
        ]);
        self::generateTranslation('user_subscriptions', [
            'en' => '%s\'s Subscriptions'
        ]);
        self::generateTranslation('user_no_subscriptions', [
            'en' => '%s has no subscriptions'
        ]);
        self::generateTranslation('usr_avatar_bg_update', [
            'en' => 'User avatar and background have been updated'
        ]);
        self::generateTranslation('user_email_confirm_email_err', [
            'en' => 'Confirm email mismatched'
        ]);
        self::generateTranslation('email_change_msg', [
            'en' => 'Email has been changed successfully'
        ]);
        self::generateTranslation('no_edit_video', [
            'en' => 'You cannot edit this video'
        ]);
        self::generateTranslation('confirm_del_video', [
            'en' => 'Are you sure you want to delete this video ?'
        ]);
        self::generateTranslation('remove_fav_video_confirm', [
            'en' => 'Are you sure you want to remove this video FROM your favorites ?'
        ]);
        self::generateTranslation('remove_fav_photo_confirm', [
            'en' => 'Are you sure you want to remove this photo FROM your favorites ?'
        ]);
        self::generateTranslation('remove_fav_collection_confirm', [
            'en' => 'Are you sure you want to remove this collection FROM your favorites ?'
        ]);
        self::generateTranslation('fav_remove_msg', [
            'en' => '%s has been removed FROM your favorites'
        ]);
        self::generateTranslation('unknown_favorite', [
            'en' => 'Unknown favorite %s'
        ]);
        self::generateTranslation('vdo_multi_del_fav_msg', [
            'en' => 'Videos have been removed FROM your favorites'
        ]);
        self::generateTranslation('unknown_sender', [
            'en' => 'Unknown Sender'
        ]);
        self::generateTranslation('please_enter_message', [
            'en' => 'Please enter something for message'
        ]);
        self::generateTranslation('unknown_reciever', [
            'en' => 'Unknown reciever'
        ]);
        self::generateTranslation('no_pm_exist', [
            'en' => 'Private message does not exist'
        ]);
        self::generateTranslation('pm_sent_success', [
            'en' => 'Private message has been sent successfully'
        ]);
        self::generateTranslation('msg_delete_inbox', [
            'en' => 'Message has been deleted FROM inbox'
        ]);
        self::generateTranslation('msg_delete_outbox', [
            'en' => 'Message has been deleted FROM your outbox'
        ]);
        self::generateTranslation('private_messags_deleted', [
            'en' => 'Private messages have been deleted'
        ]);
        self::generateTranslation('ban_users', [
            'en' => 'Ban Users'
        ]);
        self::generateTranslation('spe_users_by_comma', [
            'en' => 'separate usernames by comma'
        ]);
        self::generateTranslation('user_ban_msg', [
            'en' => 'User block list has been updated'
        ]);
        self::generateTranslation('no_user_ban_msg', [
            'en' => 'No user is banned FROM your account!'
        ]);
        self::generateTranslation('thnx_sharing_msg', [
            'en' => 'Thanks for sharing this %s'
        ]);
        self::generateTranslation('no_own_commen_rate', [
            'en' => 'You cannot rate your own comment'
        ]);
        self::generateTranslation('no_comment_exists', [
            'en' => 'Comment does not exist'
        ]);
        self::generateTranslation('thanks_rating_comment', [
            'en' => 'Thanks for rating comment'
        ]);
        self::generateTranslation('please_login_create_playlist', [
            'en' => 'Please login to creat playlists'
        ]);
        self::generateTranslation('user_have_no_playlists', [
            'en' => 'User has no playlists'
        ]);
        self::generateTranslation('play_list_with_this_name_arlready_exists', [
            'en' => 'Playlist with name \'%s\' already exists'
        ]);
        self::generateTranslation('please_enter_playlist_name', [
            'en' => 'Please enter playlist name'
        ]);
        self::generateTranslation('new_playlist_created', [
            'en' => 'New playlist has been created'
        ]);
        self::generateTranslation('playlist_not_exist', [
            'en' => 'Playlist does not exist'
        ]);
        self::generateTranslation('playlist_item_not_exist', [
            'en' => 'Playlist item does not exist'
        ]);
        self::generateTranslation('playlist_item_delete', [
            'en' => 'Playlist item has been deleted'
        ]);
        self::generateTranslation('play_list_updated', [
            'en' => 'Playlist has been updated'
        ]);
        self::generateTranslation('you_dont_hv_permission_del_playlist', [
            'en' => 'You do not have permission to delete the playlist'
        ]);
        self::generateTranslation('playlist_delete_msg', [
            'en' => 'Playlist has been deleted'
        ]);
        self::generateTranslation('playlist_name', [
            'en' => 'Playlist Name'
        ]);
        self::generateTranslation('add_new_playlist', [
            'en' => 'Add Playlist'
        ]);
        self::generateTranslation('this_thing_added_playlist', [
            'en' => 'This %s has been added to playlist'
        ]);
        self::generateTranslation('this_already_exist_in_pl', [
            'en' => 'This %s already exists in your playlist'
        ]);
        self::generateTranslation('edit_playlist', [
            'en' => 'Edit Playlist'
        ]);
        self::generateTranslation('remove_playlist_item_confirm', [
            'en' => 'Are you sure you want to remove this FROM your playlist'
        ]);
        self::generateTranslation('remove_playlist_confirm', [
            'en' => 'Are you sure you want to delete this playlist?'
        ]);
        self::generateTranslation('avcode_incorrect', [
            'en' => 'Activation code is incorrect'
        ]);
        self::generateTranslation('group_join_login_err', [
            'en' => 'Please login in order to join this group'
        ]);
        self::generateTranslation('manage_playlist', [
            'en' => 'Manage playlist'
        ]);
        self::generateTranslation('my_notifications', [
            'en' => 'My notifications'
        ]);
        self::generateTranslation('users_contacts', [
            'en' => '%s\'s contacts'
        ]);
        self::generateTranslation('type_flags_removed', [
            'en' => '%s flags have been removed'
        ]);
        self::generateTranslation('terms_of_serivce', [
            'en' => 'Terms of services'
        ]);
        self::generateTranslation('users', [
            'en' => 'Users'
        ]);
        self::generateTranslation('login_to_mark_as_spam', [
            'en' => 'Please login to mark as spam'
        ]);
        self::generateTranslation('no_own_commen_spam', [
            'en' => 'You cannot mark your own comment as spam'
        ]);
        self::generateTranslation('already_spammed_comment', [
            'en' => 'You have already marked this comment as spam'
        ]);
        self::generateTranslation('spam_comment_ok', [
            'en' => 'Comment has been marked as spam'
        ]);
        self::generateTranslation('arslan_hassan', [
            'en' => 'Arslan Hassan'
        ]);
        self::generateTranslation('you_not_allowed_add_grp_vids', [
            'en' => 'You are not member of this group so cannot add videos'
        ]);
        self::generateTranslation('sel_vids_updated', [
            'en' => 'Selected videos have been updated'
        ]);
        self::generateTranslation('unable_find_download_file', [
            'en' => 'Unable to find download file'
        ]);
        self::generateTranslation('you_cant_edit_group', [
            'en' => 'You cannot edit this group'
        ]);
        self::generateTranslation('you_cant_invite_mems', [
            'en' => 'You cannot invite members'
        ]);
        self::generateTranslation('you_cant_moderate_group', [
            'en' => 'You cannot moderate this group'
        ]);
        self::generateTranslation('page_doesnt_exist', [
            'en' => 'Page does not exist'
        ]);
        self::generateTranslation('pelase_select_img_file_for_vdo', [
            'en' => 'Please SELECT image file for video thumb'
        ]);
        self::generateTranslation('new_mem_added', [
            'en' => 'New member has been added'
        ]);
        self::generateTranslation('this_vdo_not_working', [
            'en' => 'This video might not work properly'
        ]);
        self::generateTranslation('email_template_not_exist', [
            'en' => 'Email template does not exist'
        ]);
        self::generateTranslation('email_subj_empty', [
            'en' => 'Email subject was empty'
        ]);
        self::generateTranslation('email_msg_empty', [
            'en' => 'Email message was empty'
        ]);
        self::generateTranslation('email_tpl_has_updated', [
            'en' => 'Email Template has been updated'
        ]);
        self::generateTranslation('page_name_empty', [
            'en' => 'Page name was empty'
        ]);
        self::generateTranslation('page_title_empty', [
            'en' => 'Page title was empty'
        ]);
        self::generateTranslation('page_content_empty', [
            'en' => 'Page content was empty'
        ]);
        self::generateTranslation('new_page_added_successfully', [
            'en' => 'New page has been added successfully'
        ]);
        self::generateTranslation('page_updated', [
            'en' => 'Page has been updated'
        ]);
        self::generateTranslation('page_deleted', [
            'en' => 'Page has been deleted successfully'
        ]);
        self::generateTranslation('page_activated', [
            'en' => 'Page has been activated'
        ]);
        self::generateTranslation('page_deactivated', [
            'en' => 'Page has been deactivated'
        ]);
        self::generateTranslation('you_cant_delete_this_page', [
            'en' => 'You cannot delete this page'
        ]);
        self::generateTranslation('ad_placement_err4', [
            'en' => 'Placement does not exist'
        ]);
        self::generateTranslation('grp_details_updated', [
            'en' => 'Group details have been updated'
        ]);
        self::generateTranslation('you_cant_del_topic', [
            'en' => 'You cannot delete this topic'
        ]);
        self::generateTranslation('you_cant_del_user_topics', [
            'en' => 'You cannot delete user topics'
        ]);
        self::generateTranslation('topics_deleted', [
            'en' => 'Topics have been deleted'
        ]);
        self::generateTranslation('you_cant_delete_grp_topics', [
            'en' => 'You cannot delete group topics'
        ]);
        self::generateTranslation('you_not_allowed_post_topics', [
            'en' => 'You are not allowed to post topics'
        ]);
        self::generateTranslation('you_cant_add_this_vdo', [
            'en' => 'You cannot add this video'
        ]);
        self::generateTranslation('video_added', [
            'en' => 'Video has been added'
        ]);
        self::generateTranslation('you_cant_del_this_vdo', [
            'en' => 'You cannot remove this video'
        ]);
        self::generateTranslation('video_removed', [
            'en' => 'Video has been removed'
        ]);
        self::generateTranslation('user_not_grp_mem', [
            'en' => 'User is not group member'
        ]);
        self::generateTranslation('user_already_group_mem', [
            'en' => 'User has already joined this group'
        ]);
        self::generateTranslation('invitations_sent', [
            'en' => 'Invitations have been sent'
        ]);
        self::generateTranslation('you_not_grp_mem', [
            'en' => 'You are not a member of this group'
        ]);
        self::generateTranslation('you_cant_delete_this_grp', [
            'en' => 'You cannot delete this group'
        ]);
        self::generateTranslation('grp_deleted', [
            'en' => 'Group has been deleted'
        ]);
        self::generateTranslation('you_cant_del_grp_mems', [
            'en' => 'You cannot delete group members'
        ]);
        self::generateTranslation('mems_deleted', [
            'en' => 'Members have been deleted'
        ]);
        self::generateTranslation('you_cant_del_grp_vdos', [
            'en' => 'You cannot delete group videos'
        ]);
        self::generateTranslation('thnx_for_voting', [
            'en' => 'Thanks for voting'
        ]);
        self::generateTranslation('you_hv_already_rated_vdo', [
            'en' => 'You have already rated this video'
        ]);
        self::generateTranslation('please_login_to_rate', [
            'en' => 'Please login to rate'
        ]);
        self::generateTranslation('you_not_subscribed', [
            'en' => 'You are not subscribed'
        ]);
        self::generateTranslation('you_cant_delete_this_user', [
            'en' => 'You cannot delete this user'
        ]);
        self::generateTranslation('you_dont_hv_perms', [
            'en' => 'You don\'t have sufficient permissions'
        ]);
        self::generateTranslation('user_subs_hv_been_removed', [
            'en' => 'User subscriptions have been removed'
        ]);
        self::generateTranslation('user_subsers_hv_removed', [
            'en' => 'User subscribers have been removed'
        ]);
        self::generateTranslation('you_already_sent_frend_request', [
            'en' => 'You have already sent friend request'
        ]);
        self::generateTranslation('friend_added', [
            'en' => 'Friend has been added'
        ]);
        self::generateTranslation('friend_request_sent', [
            'en' => 'Friend request has been sent'
        ]);
        self::generateTranslation('friend_confirm_error', [
            'en' => 'Either the user has not requested your friend request or you have already confirmed it'
        ]);
        self::generateTranslation('friend_confirmed', [
            'en' => 'Friend has been confirmed'
        ]);
        self::generateTranslation('friend_request_not_found', [
            'en' => 'No friend request found'
        ]);
        self::generateTranslation('you_cant_confirm_this_request', [
            'en' => 'You cannot confirm this request'
        ]);
        self::generateTranslation('friend_request_already_confirmed', [
            'en' => 'Friend request is already confirmed'
        ]);
        self::generateTranslation('user_no_in_contact_list', [
            'en' => 'User is not in your contact list'
        ]);
        self::generateTranslation('user_removed_from_contact_list', [
            'en' => 'User has been removed FROM your contact list'
        ]);
        self::generateTranslation('cant_find_level', [
            'en' => 'Cannot find level'
        ]);
        self::generateTranslation('please_enter_level_name', [
            'en' => 'Please enter level name'
        ]);
        self::generateTranslation('level_updated', [
            'en' => 'Level has been updated'
        ]);
        self::generateTranslation('level_del_sucess', [
            'en' => 'User level has been deleted, all users of this level has been transfered to %s'
        ]);
        self::generateTranslation('level_not_deleteable', [
            'en' => 'This level is not deletable'
        ]);
        self::generateTranslation('pass_mismatched', [
            'en' => 'Passwords Mismatched'
        ]);
        self::generateTranslation('user_blocked', [
            'en' => 'User has been blocked'
        ]);
        self::generateTranslation('user_already_blocked', [
            'en' => 'User is already blocked'
        ]);
        self::generateTranslation('you_cant_del_user', [
            'en' => 'You cannot block this user'
        ]);
        self::generateTranslation('user_vids_hv_deleted', [
            'en' => 'User videos have been deleted'
        ]);
        self::generateTranslation('user_contacts_hv_removed', [
            'en' => 'User contacts have been removed'
        ]);
        self::generateTranslation('all_user_inbox_deleted', [
            'en' => 'All User inbox messages have been deleted'
        ]);
        self::generateTranslation('all_user_sent_messages_deleted', [
            'en' => 'All user sent messages have been deleted'
        ]);
        self::generateTranslation('pelase_enter_something_for_comment', [
            'en' => 'Please type something in a comment box'
        ]);
        self::generateTranslation('please_enter_your_name', [
            'en' => 'Please enter your name'
        ]);
        self::generateTranslation('please_enter_your_email', [
            'en' => 'Please enter your email'
        ]);
        self::generateTranslation('template_activated', [
            'en' => 'Template has been activated'
        ]);
        self::generateTranslation('error_occured_changing_template', [
            'en' => 'An error occured while changing the template'
        ]);
        self::generateTranslation('phrase_code_empty', [
            'en' => 'Phrase code was empty'
        ]);
        self::generateTranslation('phrase_text_empty', [
            'en' => 'Phrase text was empty'
        ]);
        self::generateTranslation('language_does_not_exist', [
            'en' => 'Language does not exist'
        ]);
        self::generateTranslation('name_has_been_added', [
            'en' => '%s has been added'
        ]);
        self::generateTranslation('name_already_exists', [
            'en' => '\'%s\' already exist'
        ]);
        self::generateTranslation('lang_doesnt_exist', [
            'en' => 'language does not exist'
        ]);
        self::generateTranslation('no_file_was_selected', [
            'en' => 'No file was selected'
        ]);
        self::generateTranslation('err_reading_file_content', [
            'en' => 'Error reading file content'
        ]);
        self::generateTranslation('cant_find_lang_name', [
            'en' => 'Cant find language name'
        ]);
        self::generateTranslation('cant_find_lang_code', [
            'en' => 'Cant find language code'
        ]);
        self::generateTranslation('no_phrases_found', [
            'en' => 'No phrases were found'
        ]);
        self::generateTranslation('language_already_exists', [
            'en' => 'Language already exists'
        ]);
        self::generateTranslation('lang_added', [
            'en' => 'Language has been added successfully'
        ]);
        self::generateTranslation('error_while_upload_file', [
            'en' => 'Error occured while uploading language file'
        ]);
        self::generateTranslation('default_lang_del_error', [
            'en' => 'This is the default language, please SELECT another language as «default» and then delete this pack'
        ]);
        self::generateTranslation('lang_deleted', [
            'en' => 'Language pack has been deleted'
        ]);
        self::generateTranslation('lang_name_empty', [
            'en' => 'Language name was empty'
        ]);
        self::generateTranslation('lang_code_empty', [
            'en' => 'Language code was empty'
        ]);
        self::generateTranslation('lang_regex_empty', [
            'en' => 'Language regular expression was empty'
        ]);
        self::generateTranslation('lang_code_already_exist', [
            'en' => 'Language code already exists'
        ]);
        self::generateTranslation('lang_updated', [
            'en' => 'Language has been updated'
        ]);
        self::generateTranslation('player_activated', [
            'en' => 'Player has been activated'
        ]);
        self::generateTranslation('error_occured_while_activating_player', [
            'en' => 'An error occured while activating player'
        ]);
        self::generateTranslation('plugin_has_been_s', [
            'en' => 'Plugin has been %s'
        ]);
        self::generateTranslation('plugin_uninstalled', [
            'en' => 'Plugin has been Uninstalled'
        ]);
        self::generateTranslation('perm_code_empty', [
            'en' => 'Permission code is empty'
        ]);
        self::generateTranslation('perm_name_empty', [
            'en' => 'Permission name is empty'
        ]);
        self::generateTranslation('perm_already_exist', [
            'en' => 'Permission already exists'
        ]);
        self::generateTranslation('perm_type_not_valid', [
            'en' => 'Permission type is not valid'
        ]);
        self::generateTranslation('perm_added', [
            'en' => 'New Permission has been added'
        ]);
        self::generateTranslation('perm_deleted', [
            'en' => 'Permission has been deleted'
        ]);
        self::generateTranslation('perm_doesnt_exist', [
            'en' => 'Permission does not exist'
        ]);
        self::generateTranslation('acitvation_html_message', [
            'en' => 'Please enter your username and activation code in order to activate your account, please check your inbox for the Activation code, if you didn\'t get one, please request it by filling the next form'
        ]);
        self::generateTranslation('acitvation_html_message2', [
            'en' => 'Please enter your email address to request your activation code'
        ]);
        self::generateTranslation('admin_panel', [
            'en' => 'Admin Panel'
        ]);
        self::generateTranslation('moderate_videos', [
            'en' => 'Moderate Videos'
        ]);
        self::generateTranslation('moderate_users', [
            'en' => 'Moderate Users'
        ]);
        self::generateTranslation('revert_back_to_admin', [
            'en' => 'Revert back to admin'
        ]);
        self::generateTranslation('more_options', [
            'en' => 'More Options'
        ]);
        self::generateTranslation('downloading_string', [
            'en' => 'Downloading %s ...'
        ]);
        self::generateTranslation('download_redirect_msg', [
            'en' => '<a href=\"%s\">click here if you don\'t redirect automatically<\/a> - <a href=\"%s\"> Click Here to Go Back to Video Page<\/a>'
        ]);
        self::generateTranslation('account_details', [
            'en' => 'Account Details'
        ]);
        self::generateTranslation('profile_details', [
            'en' => 'Profile Details'
        ]);
        self::generateTranslation('update_profile', [
            'en' => 'Update Profile'
        ]);
        self::generateTranslation('please_select_img_file', [
            'en' => 'Please SELECT image file'
        ]);
        self::generateTranslation('or', [
            'en' => 'or'
        ]);
        self::generateTranslation('pelase_enter_image_url', [
            'en' => 'Please Enter Image URL'
        ]);
        self::generateTranslation('user_bg', [
            'en' => 'Channel Background'
        ]);
        self::generateTranslation('user_bg_img', [
            'en' => 'Channel Background Image'
        ]);
        self::generateTranslation('please_enter_bg_color', [
            'en' => 'Please Enter Background Color'
        ]);
        self::generateTranslation('bg_repeat_type', [
            'en' => 'Background Repeat Type (if using image as a background)'
        ]);
        self::generateTranslation('fix_bg', [
            'en' => 'Fix Background'
        ]);
        self::generateTranslation('delete_this_img', [
            'en' => 'Delete this image'
        ]);
        self::generateTranslation('current_email', [
            'en' => 'Current Email'
        ]);
        self::generateTranslation('confirm_new_email', [
            'en' => 'Confirm New Email'
        ]);
        self::generateTranslation('no_subs_found', [
            'en' => 'No subscriptions found'
        ]);
        self::generateTranslation('video_info_all_fields_req', [
            'en' => 'Video Information - All fields are required'
        ]);
        self::generateTranslation('update_group', [
            'en' => 'Update Group'
        ]);
        self::generateTranslation('default', [
            'en' => 'Default'
        ]);
        self::generateTranslation('grp_info_all_fields_req', [
            'en' => 'Group Information - All Fields Are Required'
        ]);
        self::generateTranslation('date_recorded_location', [
            'en' => 'Date recorded &amp; Location'
        ]);
        self::generateTranslation('update_video', [
            'en' => 'Update Video'
        ]);
        self::generateTranslation('click_here_to_recover_user', [
            'en' => 'Click here to recover username'
        ]);
        self::generateTranslation('click_here_reset_pass', [
            'en' => 'Click here to reset password'
        ]);
        self::generateTranslation('remember_me', [
            'en' => 'Remember Me'
        ]);
        self::generateTranslation('howdy_user', [
            'en' => 'Howdy %s'
        ]);
        self::generateTranslation('notifications', [
            'en' => 'Notifications'
        ]);
        self::generateTranslation('playlists', [
            'en' => 'Playlists'
        ]);
        self::generateTranslation('friend_requests', [
            'en' => 'Friend Requests'
        ]);
        self::generateTranslation('after_meny_guest_msg', [
            'en' => 'Welcome Guest ! Please <a href=\"%s\">Login<\/a> or <a href=\"%s\">Register<\/a>'
        ]);
        self::generateTranslation('being_watched', [
            'en' => 'Being Watched'
        ]);
        self::generateTranslation('change_style_of_listing', [
            'en' => 'Change Style of Listing'
        ]);
        self::generateTranslation('website_members', [
            'en' => '%s Members'
        ]);
        self::generateTranslation('guest_homeright_msg', [
            'en' => 'Watch, Upload, Share and more'
        ]);
        self::generateTranslation('reg_for_free', [
            'en' => 'Register for free'
        ]);
        self::generateTranslation('rand_vids', [
            'en' => 'Random Videos'
        ]);
        self::generateTranslation('t_10_users', [
            'en' => 'Top 10 Users'
        ]);
        self::generateTranslation('pending', [
            'en' => 'Pending'
        ]);
        self::generateTranslation('confirm', [
            'en' => 'Confirm'
        ]);
        self::generateTranslation('no_contacts', [
            'en' => 'No Contacts'
        ]);
        self::generateTranslation('you_dont_hv_any_grp', [
            'en' => 'You do not have any groups'
        ]);
        self::generateTranslation('you_dont_joined_any_grp', [
            'en' => 'You have not joined any groups'
        ]);
        self::generateTranslation('leave_groups', [
            'en' => 'Leave Groups'
        ]);
        self::generateTranslation('manage_grp_mems', [
            'en' => 'Manage Group Members'
        ]);
        self::generateTranslation('pending_mems', [
            'en' => 'Pending Members'
        ]);
        self::generateTranslation('active_mems', [
            'en' => 'Active Members'
        ]);
        self::generateTranslation('disapprove', [
            'en' => 'Disapprove'
        ]);
        self::generateTranslation('manage_grp_vids', [
            'en' => 'Manage Group Videos'
        ]);
        self::generateTranslation('pending_vids', [
            'en' => 'Pending Videos'
        ]);
        self::generateTranslation('no_pending_vids', [
            'en' => 'No Pending Videos'
        ]);
        self::generateTranslation('no_active_videos', [
            'en' => 'No Active Videos'
        ]);
        self::generateTranslation('active_videos', [
            'en' => 'Active Videos'
        ]);
        self::generateTranslation('manage_playlists', [
            'en' => 'Manage Playlists'
        ]);
        self::generateTranslation('total_items', [
            'en' => 'Total Items'
        ]);
        self::generateTranslation('play_now', [
            'en' => 'PLAY NOW'
        ]);
        self::generateTranslation('no_video_in_playlist', [
            'en' => 'This playlist has no video'
        ]);
        self::generateTranslation('view', [
            'en' => 'View'
        ]);
        self::generateTranslation('you_dont_hv_fav_vids', [
            'en' => 'You do not have any favorite videos'
        ]);
        self::generateTranslation('private_messages', [
            'en' => 'Private Messages'
        ]);
        self::generateTranslation('new_private_msg', [
            'en' => 'New private message'
        ]);
        self::generateTranslation('search_for_s', [
            'en' => 'Search For %s'
        ]);
        self::generateTranslation('signup_success_usr_ok', [
            'en' => '<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">Just One More Step<\/h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 14px;\">Your are just one step behind FROM becoming an official memeber of our website.  Please check your email, we have sent you a confirmation email which contains a confirmation link FROM our website, Please click it to complete your registration.<\/p>'
        ]);
        self::generateTranslation('signup_success_usr_emailverify', [
            'en' => '<h2 style=\"font-family:Arial,Verdana,sans-serif; margin:5px 5px 8px;\">Welcome To our community<\/h2>\r\n    \t<p style=\"margin:0px 5px; line-height:18px; font-size:11px;\">Your email has been confirmed, Please <strong><a href=\"%s\">click here to login<\/a><\/strong> and continue as our registered member.<\/p>'
        ]);
        self::generateTranslation('if_you_already_hv_account', [
            'en' => 'if you already have an account, please login here '
        ]);
        self::generateTranslation('signup_message_under_login', [
            'en' => ' <p>Our website is the home for video online:<\/p>\r\n          \r\n            <ul><li><strong>Watch<\/strong> millions  of videos<\/li><li><strong>Share favorites<\/strong> with friends and family<\/li>\r\n            <li><strong>Connect with other users<\/strong> who share your interests<\/li><li><strong>Upload your videos<\/strong> to a worldwide audience\r\n\r\n<\/li><\/ul>'
        ]);
        self::generateTranslation('new_mems_signup_here', [
            'en' => 'New Members Signup Here'
        ]);
        self::generateTranslation('register_as_our_website_member', [
            'en' => 'Register as a member, it\'s free and easy just '
        ]);
        self::generateTranslation('video_complete_msg', [
            'en' => '<h2>Video Upload Has Been Completed<\/h2>\r\n<span class=\"header1\">Thank you! Your upload is complete.<\/span><br>\r\n<span class=\"tips\">This video will be available in <a href=\"%s\"><strong>My Videos<\/strong><\/a> after it has finished processing.<\/span>  \r\n<div class=\"upload_link_button\" align=\"center\">\r\n    <ul>\r\n        <li><a href=\"%s\" >Upload Another Video<\/a><\/li>\r\n        <li><a href=\"%s\" >Go to My Videos<\/a><\/li>\r\n    <\/ul>\r\n<div class=\'clearfix\'><\/div>\r\n<\/div>\r\n'
        ]);
        self::generateTranslation('upload_right_guide', [
            'en' => ' <div>\r\n            <div>\r\n              <p>\r\n                <strong>\r\n                <strong>Important:<\/strong>\r\n                Do not upload any TV shows, music videos, music concerts, or  commercials without permission unless they consist entirely of content  you created yourself.<\/strong><\/p>\r\n                <p>The \r\n                <a href=\"#\">Copyright Tips page<\/a> and the \r\n                <a href=\"#\">Community Guidelines<\/a> can help you determine whether your video infringes someone else\'s copyright.<\/p>\r\n                <p>By clicking \"Upload Video\'), you are representing that this video does not violate Our website\'s \r\n                <a id=\"terms-of-use-link\" href=\"#\">Terms of Use<\/a> \r\n                and that you own all copyrights in this video or have authorization to upload it.<\/p>\r\n            <\/div>\r\n        <\/div>'
        ]);
        self::generateTranslation('report_this_user', [
            'en' => 'Report This User'
        ]);
        self::generateTranslation('add_to_favs', [
            'en' => 'My Favorite!'
        ]);
        self::generateTranslation('report_this', [
            'en' => 'Report'
        ]);
        self::generateTranslation('share_this', [
            'en' => 'Share this'
        ]);
        self::generateTranslation('add_to_playlist', [
            'en' => 'Add to Playlist'
        ]);
        self::generateTranslation('view_profile', [
            'en' => 'View Profile'
        ]);
        self::generateTranslation('subscribe', [
            'en' => 'Subscribe'
        ]);
        self::generateTranslation('uploaded_by_s', [
            'en' => 'Uploaded by %s'
        ]);
        self::generateTranslation('more', [
            'en' => 'More'
        ]);
        self::generateTranslation('link_this_video', [
            'en' => 'Link This Video'
        ]);
        self::generateTranslation('click_to_download_video', [
            'en' => 'Click Here To Download This Video'
        ]);
        self::generateTranslation('name', [
            'en' => 'Name'
        ]);
        self::generateTranslation('email_wont_display', [
            'en' => 'Email (Won\'t display)'
        ]);
        self::generateTranslation('please_login_to_comment', [
            'en' => 'Please login to comment'
        ]);
        self::generateTranslation('marked_as_spam_comment_by_user', [
            'en' => 'Marked as spam, commented by <em>%s<\/em>'
        ]);
        self::generateTranslation('spam', [
            'en' => 'Spam'
        ]);
        self::generateTranslation('user_commented_time', [
            'en' => '<a href=\"%s\">%s<\/a> commented %s'
        ]);
        self::generateTranslation('no_comments', [
            'en' => 'No one has commented on this %s yet'
        ]);
        self::generateTranslation('view_video', [
            'en' => 'View Video'
        ]);
        self::generateTranslation('topic_icon', [
            'en' => 'Topic Icon'
        ]);
        self::generateTranslation('group_options', [
            'en' => 'Group option'
        ]);
        self::generateTranslation('info', [
            'en' => 'Info'
        ]);
        self::generateTranslation('basic_info', [
            'en' => 'Basic info'
        ]);
        self::generateTranslation('group_owner', [
            'en' => 'Group Owner'
        ]);
        self::generateTranslation('total_mems', [
            'en' => 'Total Members'
        ]);
        self::generateTranslation('total_topics', [
            'en' => 'Total Topics'
        ]);
        self::generateTranslation('grp_url', [
            'en' => 'Group URL'
        ]);
        self::generateTranslation('more_details', [
            'en' => 'More Details'
        ]);
        self::generateTranslation('view_all_mems', [
            'en' => 'View All Members'
        ]);
        self::generateTranslation('view_all_vids', [
            'en' => 'View All Videos'
        ]);
        self::generateTranslation('topic_title', [
            'en' => 'Topic Title'
        ]);
        self::generateTranslation('last_reply', [
            'en' => 'Last Reply'
        ]);
        self::generateTranslation('topic_by_user', [
            'en' => '<a href=\"%s\">%s<\/a><\/span> by <a href=\"%s\">%s<\/a>'
        ]);
        self::generateTranslation('no_topics', [
            'en' => 'No Topics'
        ]);
        self::generateTranslation('last_post_time_by_user', [
            'en' => '%s<br \/>\r\nby <a href=\"%s\">%s'
        ]);
        self::generateTranslation('profile_views', [
            'en' => 'Profile views'
        ]);
        self::generateTranslation('last_logged_in', [
            'en' => 'Last logged in'
        ]);
        self::generateTranslation('last_active', [
            'en' => 'Last active'
        ]);
        self::generateTranslation('total_logins', [
            'en' => 'Total logins'
        ]);
        self::generateTranslation('total_videos_watched', [
            'en' => 'Total videos watched'
        ]);
        self::generateTranslation('view_group', [
            'en' => 'View Group'
        ]);
        self::generateTranslation('you_dont_hv_any_pm', [
            'en' => 'No messages to display'
        ]);
        self::generateTranslation('date_sent', [
            'en' => 'Date sent'
        ]);
        self::generateTranslation('show_hide', [
            'en' => 'show - hide'
        ]);
        self::generateTranslation('quicklists', [
            'en' => 'Quicklists'
        ]);
        self::generateTranslation('are_you_sure_rm_grp', [
            'en' => 'Are you sure you want to remove this group ?'
        ]);
        self::generateTranslation('are_you_sure_del_grp', [
            'en' => 'Are you sure you want to delete this group?'
        ]);
        self::generateTranslation('change_avatar', [
            'en' => 'Change Avatar'
        ]);
        self::generateTranslation('change_bg', [
            'en' => 'Change Background'
        ]);
        self::generateTranslation('uploaded_videos', [
            'en' => 'Uploaded Videos'
        ]);
        self::generateTranslation('video_playlists', [
            'en' => 'Video Playlists'
        ]);
        self::generateTranslation('add_contact_list', [
            'en' => 'Add Contact List'
        ]);
        self::generateTranslation('topic_post', [
            'en' => 'Topic Post'
        ]);
        self::generateTranslation('invite', [
            'en' => 'Invite'
        ]);
        self::generateTranslation('time_ago', [
            'en' => '%s %s ago'
        ]);
        self::generateTranslation('from_now', [
            'en' => '%s %s FROM now'
        ]);
        self::generateTranslation('lang_has_been_activated', [
            'en' => 'Language has been activated'
        ]);
        self::generateTranslation('lang_has_been_deactivated', [
            'en' => 'Language has been deactivated'
        ]);
        self::generateTranslation('lang_default_no_actions', [
            'en' => 'Language is default so you cannot perform actions on it'
        ]);
        self::generateTranslation('private_video_error', [
            'en' => 'This video is private, only uploader friends can view this video'
        ]);
        self::generateTranslation('email_send_confirm', [
            'en' => 'An email has been sent to our web administrator, we will respond you soon'
        ]);
        self::generateTranslation('name_was_empty', [
            'en' => 'Name was empty'
        ]);
        self::generateTranslation('invalid_email', [
            'en' => 'Invalid Email'
        ]);
        self::generateTranslation('pelase_enter_reason', [
            'en' => 'Reason'
        ]);
        self::generateTranslation('please_enter_something_for_message', [
            'en' => 'Please enter something in message box'
        ]);
        self::generateTranslation('comm_disabled_for_vid', [
            'en' => 'Comments Disabled For This Video'
        ]);
        self::generateTranslation('coments_disabled_profile', [
            'en' => 'Comments disabled for this profile'
        ]);
        self::generateTranslation('file_size_exceeds', [
            'en' => 'File size exceeds \'%s kbs\''
        ]);
        self::generateTranslation('vid_rate_disabled', [
            'en' => 'Video rating is disabled'
        ]);
        self::generateTranslation('chane_lang', [
            'en' => '- Change Language -'
        ]);
        self::generateTranslation('recent', [
            'en' => 'Recent'
        ]);
        self::generateTranslation('viewed', [
            'en' => 'Viewed'
        ]);
        self::generateTranslation('top_rated', [
            'en' => 'Top Rated'
        ]);
        self::generateTranslation('commented', [
            'en' => 'Commented'
        ]);
        self::generateTranslation('searching_keyword_in_obj', [
            'en' => 'Searching \'%s\' in %s'
        ]);
        self::generateTranslation('no_results_found', [
            'en' => 'No results found'
        ]);
        self::generateTranslation('please_enter_val_bw_min_max', [
            'en' => 'Please enter \'%s\' value between \'%s\' and \'%s\''
        ]);
        self::generateTranslation('no_new_subs_video', [
            'en' => 'No new videos found in subscriptions'
        ]);
        self::generateTranslation('inapp_content', [
            'en' => 'Inappropriate Content'
        ]);
        self::generateTranslation('copyright_infring', [
            'en' => 'Copyright infringement'
        ]);
        self::generateTranslation('sexual_content', [
            'en' => 'Sexual Content'
        ]);
        self::generateTranslation('violence_replusive_content', [
            'en' => 'Violence or repulsive content'
        ]);
        self::generateTranslation('disturbing', [
            'en' => 'Disturbing'
        ]);
        self::generateTranslation('other', [
            'en' => 'Other'
        ]);
        self::generateTranslation('pending_requests', [
            'en' => 'Pending requests'
        ]);
        self::generateTranslation('friend_add_himself_error', [
            'en' => 'You cannot add yourself as a friend'
        ]);
        self::generateTranslation('contact_us_msg', [
            'en' => 'Your comments are important to us and we will address them as quickly as possible. Provision of the information requested on this form is voluntary. The information is being collected to provide additional information requested by you and assists us in improving our services.'
        ]);
        self::generateTranslation('successful', [
            'en' => 'Successful'
        ]);
        self::generateTranslation('failed', [
            'en' => 'Failed'
        ]);
        self::generateTranslation('required_fields', [
            'en' => 'Required fields'
        ]);
        self::generateTranslation('more_fields', [
            'en' => 'More fields'
        ]);
        self::generateTranslation('remote_upload_file', [
            'en' => 'uploading file <span id=\\\"remoteFileName\\\"><\/span>, please wait...'
        ]);
        self::generateTranslation('please_enter_remote_file_url', [
            'en' => 'Please enter remote file url'
        ]);
        self::generateTranslation('remoteDownloadStatusDiv', [
            'en' => '<div class=\"remoteDownloadStatus\" id=\"remoteDownloadStatus\" >Downloaded \r\n                <span id=\"status\">-- of --<\/span> @ \r\n                <span id=\"dspeed\">-- Kpbs<\/span>, EST \r\n                <span id=\"eta\">--:--<\/span>, Time took \r\n                <span id=\"time_took\">--:--<\/span>\r\n            <\/div>'
        ]);
        self::generateTranslation('upload_data_now', [
            'en' => 'Upload Data Now!'
        ]);
        self::generateTranslation('save_data', [
            'en' => 'Save Data'
        ]);
        self::generateTranslation('saving', [
            'en' => 'Saving...'
        ]);
        self::generateTranslation('upload_file', [
            'en' => 'Upload File'
        ]);
        self::generateTranslation('grab_from_youtube', [
            'en' => 'Grab FROM youtube'
        ]);
        self::generateTranslation('upload_video_button', [
            'en' => 'Browse videos'
        ]);
        self::generateTranslation('upload_videos_can_be', [
            'en' => '<span style=\\\"font-weight: bold; font-size: 13px;\\\">Videos can be<\/span>     <ul>         <li>High Definition<\/li>         <li>Up to %s in size<\/li>         <li>Up to %s in length<\/li>         <li>A wide variety of formats<\/li>     <\/ul>'
        ]);
        self::generateTranslation('photo_not_exist', [
            'en' => 'Photo does not exist.'
        ]);
        self::generateTranslation('photo_success_deleted', [
            'en' => 'Photo has been deleted successfully.'
        ]);
        self::generateTranslation('cant_edit_photo', [
            'en' => 'You can not edit this photo.'
        ]);
        self::generateTranslation('you_hv_already_rated_photo', [
            'en' => 'You have already rated this photo.'
        ]);
        self::generateTranslation('photo_rate_disabled', [
            'en' => 'Photo rating is disabled.'
        ]);
        self::generateTranslation('need_photo_details', [
            'en' => 'Need photo details.'
        ]);
        self::generateTranslation('embedding_is_disabled', [
            'en' => 'Embedding is disabled by user.'
        ]);
        self::generateTranslation('photo_activated', [
            'en' => 'Photo is activated.'
        ]);
        self::generateTranslation('photo_deactivated', [
            'en' => 'Photo is deactivated.'
        ]);
        self::generateTranslation('photo_featured', [
            'en' => 'Photo is marked featured.'
        ]);
        self::generateTranslation('photo_unfeatured', [
            'en' => 'Photo is marked unfeatured.'
        ]);
        self::generateTranslation('photo_updated_successfully', [
            'en' => 'Photo is updated successfully.'
        ]);
        self::generateTranslation('success_delete_file', [
            'en' => '%s files has been deleted successfully.'
        ]);
        self::generateTranslation('no_watermark_found', [
            'en' => 'Can not find watermark file.'
        ]);
        self::generateTranslation('watermark_updated', [
            'en' => 'Watermark is updated'
        ]);
        self::generateTranslation('upload_png_watermark', [
            'en' => 'Please upload 24-bit PNG file.'
        ]);
        self::generateTranslation('photo_non_readable', [
            'en' => 'Photo is not readable.'
        ]);
        self::generateTranslation('wrong_mime_type', [
            'en' => 'Wrong MIME type provided.'
        ]);
        self::generateTranslation('you_dont_have_photos', [
            'en' => 'You dont have any photos'
        ]);
        self::generateTranslation('you_dont_have_fav_photos', [
            'en' => 'You dont have any favorite photos'
        ]);
        self::generateTranslation('manage_orphan_photos', [
            'en' => 'Manage Orphan Photos'
        ]);
        self::generateTranslation('manage_favorite_photos', [
            'en' => 'Manage Favorite Photos'
        ]);
        self::generateTranslation('manage_photos', [
            'en' => 'Manage Photos'
        ]);
        self::generateTranslation('you_dont_have_orphan_photos', [
            'en' => 'You dont have any orphan photos'
        ]);
        self::generateTranslation('item_not_exist', [
            'en' => 'Item does not exist.'
        ]);
        self::generateTranslation('collection_not_exist', [
            'en' => 'Collection does not exist'
        ]);
        self::generateTranslation('selected_collects_del', [
            'en' => 'Selected collections have been deleted.'
        ]);
        self::generateTranslation('manage_collections', [
            'en' => 'Manage Collections'
        ]);
        self::generateTranslation('manage_categories', [
            'en' => 'Manage Categories'
        ]);
        self::generateTranslation('flagged_collections', [
            'en' => 'Flagged Collections'
        ]);
        self::generateTranslation('create_collection', [
            'en' => 'Create Collection'
        ]);
        self::generateTranslation('selected_items_removed', [
            'en' => 'Selected %s have been removed.'
        ]);
        self::generateTranslation('edit_collection', [
            'en' => 'Edit Collection'
        ]);
        self::generateTranslation('manage_collection_items', [
            'en' => 'Manage Collection Items'
        ]);
        self::generateTranslation('manage_favorite_collections', [
            'en' => 'Manage Favorite Collections'
        ]);
        self::generateTranslation('total_fav_collection_removed', [
            'en' => '%s collections have been removed FROM favorites.'
        ]);
        self::generateTranslation('total_photos_deleted', [
            'en' => '%s photos have been deleted successfully.'
        ]);
        self::generateTranslation('total_fav_photos_removed', [
            'en' => '%s photos have been removed FROM favorites.'
        ]);
        self::generateTranslation('photos_upload', [
            'en' => 'Photo Upload'
        ]);
        self::generateTranslation('no_items_found_in_collect', [
            'en' => 'No item found in this collection'
        ]);
        self::generateTranslation('manage_items', [
            'en' => 'Manage Items'
        ]);
        self::generateTranslation('add_new_collection', [
            'en' => 'Add New Collection'
        ]);
        self::generateTranslation('update_collection', [
            'en' => 'Update Collection'
        ]);
        self::generateTranslation('update_photo', [
            'en' => 'Update Photo'
        ]);
        self::generateTranslation('no_collection_found', [
            'en' => 'You dont have any collection'
        ]);
        self::generateTranslation('photo_title', [
            'en' => 'Photo Title'
        ]);
        self::generateTranslation('photo_caption', [
            'en' => 'Photo Caption'
        ]);
        self::generateTranslation('photo_tags', [
            'en' => 'Photo Tags'
        ]);
        self::generateTranslation('collection', [
            'en' => 'Collection'
        ]);
        self::generateTranslation('photo', [
            'en' => 'Photo'
        ]);
        self::generateTranslation('video', [
            'en' => 'video'
        ]);
        self::generateTranslation('pic_allow_embed', [
            'en' => 'Enable photo embedding'
        ]);
        self::generateTranslation('pic_dallow_embed', [
            'en' => 'Disable photo embedding'
        ]);
        self::generateTranslation('pic_allow_rating', [
            'en' => 'Enable photo rating'
        ]);
        self::generateTranslation('pic_dallow_rating', [
            'en' => 'Disable photo rating'
        ]);
        self::generateTranslation('add_more', [
            'en' => 'Add More'
        ]);
        self::generateTranslation('collect_name_er', [
            'en' => 'Collection name is empty'
        ]);
        self::generateTranslation('collect_descp_er', [
            'en' => 'Collection description is empty'
        ]);
        self::generateTranslation('collect_tag_er', [
            'en' => 'Collection tags are empty'
        ]);
        self::generateTranslation('collect_cat_er', [
            'en' => 'Select collection category'
        ]);
        self::generateTranslation('collect_borad_pub', [
            'en' => 'Make collection public'
        ]);
        self::generateTranslation('collect_allow_public_up', [
            'en' => 'Public Upload'
        ]);
        self::generateTranslation('collect_pub_up_dallow', [
            'en' => 'Disallow other users to add items.'
        ]);
        self::generateTranslation('collect_pub_up_allow', [
            'en' => 'Allow other users to add items.'
        ]);
        self::generateTranslation('collection_name', [
            'en' => 'Collection name'
        ]);
        self::generateTranslation('collection_description', [
            'en' => 'Collection description'
        ]);
        self::generateTranslation('collection_tags', [
            'en' => 'Collection tags'
        ]);
        self::generateTranslation('collect_category', [
            'en' => 'Collection category'
        ]);
        self::generateTranslation('collect_added_msg', [
            'en' => 'Collection has been added'
        ]);
        self::generateTranslation('collect_not_exist', [
            'en' => 'Collection does not exist'
        ]);
        self::generateTranslation('no_upload_opt', [
            'en' => 'No uploading option allowed by {title}, please contact website administrator.'
        ]);
        self::generateTranslation('photos', [
            'en' => 'Photos'
        ]);
        self::generateTranslation('cat_all', [
            'en' => 'All'
        ]);
        self::generateTranslation('upload_desktop_msg', [
            'en' => 'Upload videos directly FROM your desktop and share it online with our community '
        ]);
        self::generateTranslation('upload_remote_video_msg', [
            'en' => 'Upload videos FROM other websites or server, simply enter its URL and click on Upload or you can enter Youtube Url and click Grab from youtube to upload video directly from youtube without entering its details'
        ]);
        self::generateTranslation('embed_video_msg', [
            'en' => 'Embed videos FROM different website using their \"video embed code\" , simply enter embed code, enter video duration and SELECT its thumb, fill in the required details and click on upload.'
        ]);
        self::generateTranslation('link_video_msg', [
            'en' => 'If you would LIKE to upload a video without having to wait for upload and proccessing phase to complete, simply put your video URL here along with a few other details and enjoy.'
        ]);
        self::generateTranslation('browse_photos', [
            'en' => 'Browse photos'
        ]);
        self::generateTranslation('photo_is_saved_now', [
            'en' => 'Photo collection has been saved'
        ]);
        self::generateTranslation('photo_success_heading', [
            'en' => 'Photo collection has been updated successfully'
        ]);
        self::generateTranslation('share_embed', [
            'en' => 'Shared \/ Embed'
        ]);
        self::generateTranslation('item_added_in_collection', [
            'en' => '%s successfully added in collection.'
        ]);
        self::generateTranslation('object_exists_collection', [
            'en' => '%s already exist in collection.'
        ]);
        self::generateTranslation('collect_tag_hint', [
            'en' => 'alpha bravo charlie, ptv classics, hasb-e-haal'
        ]);
        self::generateTranslation('collect_broad_pri', [
            'en' => 'Make collection private'
        ]);
        self::generateTranslation('collect_item_removed', [
            'en' => '%s is removed FROM collection.'
        ]);
        self::generateTranslation('most_downloaded', [
            'en' => 'Most downloaded'
        ]);
        self::generateTranslation('total_videos', [
            'en' => 'Total videos'
        ]);
        self::generateTranslation('collection_featured', [
            'en' => 'Collection featured.'
        ]);
        self::generateTranslation('collection_unfeatured', [
            'en' => 'Collection unfeatured.'
        ]);
        self::generateTranslation('upload_right_guide_photo', [
            'en' => '<strong>Important: Do not upload any photo that can be construed as Obscenity, copyrighted material, harassment, or spam.<\/strong>\r\n<p>By continuing \"Your Upload\'), you are representing that these photos do not violate Our website\'s <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Terms of Use<\/span><\/a> and that you own all copyrights of these photos or have authorization to upload it.<\/p>'
        ]);
        self::generateTranslation('upload_right_guide_vid', [
            'en' => '<strong>Important: Do not upload any video that can be construed as Obscenity, copyrighted material, harassment, or spam.<\/strong>\r\n<p>By continuing \"Your Upload\'), you are representing that these videos do not violate Our website\'s <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Terms of Use<\/span><\/a> and that you own all copyrights of these videos or have authorization to upload it.<\/p>'
        ]);
        self::generateTranslation('collection_deactivated', [
            'en' => 'Collection deactivated.'
        ]);
        self::generateTranslation('collection_activated', [
            'en' => 'Collection activated.'
        ]);
        self::generateTranslation('collection_updated', [
            'en' => 'Collection updated.'
        ]);
        self::generateTranslation('cant_edit_collection', [
            'en' => 'You can not edit this collection'
        ]);
        self::generateTranslation('object_not_in_collect', [
            'en' => '%s does not exist in this collection'
        ]);
        self::generateTranslation('object_does_not_exists', [
            'en' => '%s does not exist.'
        ]);
        self::generateTranslation('cant_perform_action_collect', [
            'en' => 'You can not perform such actions on this collection.'
        ]);
        self::generateTranslation('collection_deleted', [
            'en' => 'Collection deleted successfully.'
        ]);
        self::generateTranslation('collection_not_exists', [
            'en' => 'Collection does not exist.'
        ]);
        self::generateTranslation('collect_items_deleted', [
            'en' => 'Collection items deleted successfully.'
        ]);
        self::generateTranslation('photo_title_err', [
            'en' => 'Please enter valid photo title'
        ]);
        self::generateTranslation('rand_photos', [
            'en' => 'Random photos'
        ]);
        self::generateTranslation('this_has_set_profile_item', [
            'en' => 'This %s has been set as your profile item'
        ]);
        self::generateTranslation('profile_item_removed', [
            'en' => 'Profile item has been removed'
        ]);
        self::generateTranslation('make_profile_item', [
            'en' => 'Make profile item'
        ]);
        self::generateTranslation('remove_profile_item', [
            'en' => 'Remove profile item'
        ]);
        self::generateTranslation('content_type_empty', [
            'en' => 'Content Type is empty. Please tell us what type of content you want.'
        ]);
        self::generateTranslation('watch_video_page', [
            'en' => 'Watch on video page'
        ]);
        self::generateTranslation('watch_on_photo_page', [
            'en' => 'Watch this on photo page'
        ]);
        self::generateTranslation('found_no_videos', [
            'en' => 'Found no videos'
        ]);
        self::generateTranslation('found_no_photos', [
            'en' => 'Found no photos'
        ]);
        self::generateTranslation('collections', [
            'en' => 'Collections'
        ]);
        self::generateTranslation('related_videos', [
            'en' => 'Related Videos'
        ]);
        self::generateTranslation('this_video_found_in_no_collection', [
            'en' => 'This video is found in following collections'
        ]);
        self::generateTranslation('more_from', [
            'en' => 'More FROM %s'
        ]);
        self::generateTranslation('this_collection', [
            'en' => 'Collection : %s'
        ]);
        self::generateTranslation('vdo_broadcast_unlisted', [
            'en' => 'Unlisted (anyone with the link and\/or password can view)'
        ]);
        self::generateTranslation('video_link', [
            'en' => 'Video link'
        ]);
        self::generateTranslation('channel_settings', [
            'en' => 'Channel settings'
        ]);
        self::generateTranslation('channel_account_settings', [
            'en' => 'Channel & Account Settings'
        ]);
        self::generateTranslation('account_settings', [
            'en' => 'Account settings'
        ]);
        self::generateTranslation('allow_subscription', [
            'en' => 'Allow subscription'
        ]);
        self::generateTranslation('allow_subscription_hint', [
            'en' => 'Allow members to subscribe to your channel?'
        ]);
        self::generateTranslation('channel_title', [
            'en' => 'Channel title'
        ]);
        self::generateTranslation('channel_desc', [
            'en' => 'Channel description'
        ]);
        self::generateTranslation('show_my_friends', [
            'en' => 'Show my friends'
        ]);
        self::generateTranslation('show_my_videos', [
            'en' => 'Show my videos'
        ]);
        self::generateTranslation('show_my_photos', [
            'en' => 'Show my photos'
        ]);
        self::generateTranslation('show_my_subscriptions', [
            'en' => 'Show my subscriptions'
        ]);
        self::generateTranslation('show_my_subscribers', [
            'en' => 'Show my subscribers'
        ]);
        self::generateTranslation('profile_basic_info', [
            'en' => 'Basic info'
        ]);
        self::generateTranslation('profile_education_interests', [
            'en' => 'Education, Hobbies, etc'
        ]);
        self::generateTranslation('channel_profile_settings', [
            'en' => 'Channel & Profile Settings'
        ]);
        self::generateTranslation('show_my_collections', [
            'en' => 'Show my collections'
        ]);
        self::generateTranslation('user_doesnt_any_collection', [
            'en' => 'User doesn\'t have any collections.'
        ]);
        self::generateTranslation('unsubscribe', [
            'en' => 'Unsubscribe'
        ]);
        self::generateTranslation('you_have_already_voted_channel', [
            'en' => 'You have already voted this channel'
        ]);
        self::generateTranslation('channel_rating_disabled', [
            'en' => 'Channel voting is disabled'
        ]);
        self::generateTranslation('user_activity', [
            'en' => 'User activity'
        ]);
        self::generateTranslation('you_cant_view_profile', [
            'en' => 'You don\'t have permission to view this channel :\/'
        ]);
        self::generateTranslation('only_friends_view_channel', [
            'en' => 'Only %s\'s friends can view this channel'
        ]);
        self::generateTranslation('collect_type', [
            'en' => 'Collection type'
        ]);
        self::generateTranslation('add_to_my_collection', [
            'en' => 'Add this to my collection'
        ]);
        self::generateTranslation('total_collections', [
            'en' => 'Total collections'
        ]);
        self::generateTranslation('total_photos', [
            'en' => 'Total photos'
        ]);
        self::generateTranslation('comments_made', [
            'en' => 'Comments made'
        ]);
        self::generateTranslation('block_users', [
            'en' => 'Block users'
        ]);
        self::generateTranslation('tp_del_confirm', [
            'en' => 'Are you sure you want to delete this topic?'
        ]);
        self::generateTranslation('you_need_owners_approval_to_view_group', [
            'en' => 'You need owners approval in order to view this group'
        ]);
        self::generateTranslation('you_cannot_rate_own_collection', [
            'en' => 'You cannot rate your own collection'
        ]);
        self::generateTranslation('collection_rating_not_allowed', [
            'en' => 'Collection rating is now allowed'
        ]);
        self::generateTranslation('you_cant_rate_own_video', [
            'en' => 'You cannot rate your own video'
        ]);
        self::generateTranslation('you_cant_rate_own_channel', [
            'en' => 'You cannot rate your own channel'
        ]);
        self::generateTranslation('you_cannot_rate_own_photo', [
            'en' => 'You cannot rate your own photo'
        ]);
        self::generateTranslation('cant_pm_banned_user', [
            'en' => 'You cannot send private messages to %s'
        ]);
        self::generateTranslation('you_are_not_allowed_to_view_user_channel', [
            'en' => 'You are not allowed to view %s\'s channel'
        ]);
        self::generateTranslation('you_cant_send_pm_yourself', [
            'en' => 'You cannot send private messages to yourself'
        ]);
        self::generateTranslation('please_enter_confimation_ode', [
            'en' => 'Please enter verification code'
        ]);
        self::generateTranslation('vdo_brd_confidential', [
            'en' => 'Confidential (Only for specified users)'
        ]);
        self::generateTranslation('video_password', [
            'en' => 'Video password'
        ]);
        self::generateTranslation('set_video_password', [
            'en' => 'Enter video password to make it \"password protected\"'
        ]);
        self::generateTranslation('video_pass_protected', [
            'en' => 'This video is password protected, you must enter a valid password in order to view this video'
        ]);
        self::generateTranslation('please_enter_video_password', [
            'en' => 'Please enter valid password in order to watch this video'
        ]);
        self::generateTranslation('video_is_password_protected', [
            'en' => '%s is password protected'
        ]);
        self::generateTranslation('invalid_video_password', [
            'en' => 'Invalid video password'
        ]);
        self::generateTranslation('logged_users_only', [
            'en' => 'Logged only (only logged in users can watch)'
        ]);
        self::generateTranslation('specify_video_users', [
            'en' => 'Enter username who can watch this video , separated by comma'
        ]);
        self::generateTranslation('video_users', [
            'en' => 'Video users'
        ]);
        self::generateTranslation('not_logged_video_error', [
            'en' => 'You cannot watch this video because you are not logged in'
        ]);
        self::generateTranslation('no_user_subscribed_to_uploader', [
            'en' => 'No user has subscribed to %s'
        ]);
        self::generateTranslation('subs_email_sent_to_users', [
            'en' => 'Subscription email has been sent to %s user%s'
        ]);
        self::generateTranslation('user_has_uploaded_new_photo', [
            'en' => '%s has uploaded a new photo'
        ]);
        self::generateTranslation('please_provide_valid_userid', [
            'en' => 'please provide valid userid'
        ]);
        self::generateTranslation('user_joined_us', [
            'en' => '%s has joined %s , say hello to %s'
        ]);
        self::generateTranslation('user_has_uploaded_new_video', [
            'en' => '%s has uploaded a new video'
        ]);
        self::generateTranslation('user_has_created_new_group', [
            'en' => '%s has created a new group'
        ]);
        self::generateTranslation('total_members', [
            'en' => 'Total members'
        ]);
        self::generateTranslation('watch_video', [
            'en' => 'Watch video'
        ]);
        self::generateTranslation('view_photo', [
            'en' => 'View photo'
        ]);
        self::generateTranslation('user_has_joined_group', [
            'en' => '%s has joined a new group'
        ]);
        self::generateTranslation('user_is_now_friend_with_other', [
            'en' => '%s and %s are now friends'
        ]);
        self::generateTranslation('user_has_created_new_collection', [
            'en' => '%s has created a new collection'
        ]);
        self::generateTranslation('view_collection', [
            'en' => 'View collection'
        ]);
        self::generateTranslation('user_has_favorited_video', [
            'en' => '%s has added a video to favorites'
        ]);
        self::generateTranslation('activity', [
            'en' => 'Activity'
        ]);
        self::generateTranslation('no_activity', [
            'en' => '%s has no recent activity'
        ]);
        self::generateTranslation('feed_has_been_deleted', [
            'en' => 'Activity feed has been deleted'
        ]);
        self::generateTranslation('you_cant_del_this_feed', [
            'en' => 'You cannot delete this feed'
        ]);
        self::generateTranslation('you_cant_sub_yourself', [
            'en' => 'You cannot subscribe yourself'
        ]);
        self::generateTranslation('manage_my_album', [
            'en' => 'Manage my album'
        ]);
        self::generateTranslation('you_dont_have_permission_to_update_this_video', [
            'en' => 'You don\'t have permission to update this video'
        ]);
        self::generateTranslation('group_is_public', [
            'en' => 'Group is public'
        ]);
        self::generateTranslation('collection_thumb', [
            'en' => 'Collection thumb'
        ]);
        self::generateTranslation('collection_is_private', [
            'en' => 'Collction is private'
        ]);
        self::generateTranslation('edit_type_collection', [
            'en' => 'Editing %s'
        ]);
        self::generateTranslation('comm_disabled_for_collection', [
            'en' => 'Comments disabled for this collection'
        ]);
        self::generateTranslation('share_this_type', [
            'en' => 'Share this %s'
        ]);
        self::generateTranslation('seperate_usernames_with_comma', [
            'en' => 'Seperate usernames with comma'
        ]);
        self::generateTranslation('view_all', [
            'en' => 'View all'
        ]);
        self::generateTranslation('album_privacy_updated', [
            'en' => 'Album privacy has been updated'
        ]);
        self::generateTranslation('you_dont_have_any_videos', [
            'en' => 'You do not have any videos'
        ]);
        self::generateTranslation('update_blocked_use', [
            'en' => 'Blocked user-list has been updated'
        ]);
        self::generateTranslation('you_dont_have_fav_collections', [
            'en' => 'You do not have any favorite collection'
        ]);
        self::generateTranslation('remote_play', [
            'en' => 'Remote play'
        ]);
        self::generateTranslation('remote_upload_example', [
            'en' => 'e.g http:\/\/clipbucket.com\/sample.flv http:\/\/www.youtube.com\/watch?v=QfRAHfquzM0'
        ]);
        self::generateTranslation('update_blocked_user_list', [
            'en' => 'Update blocked users list'
        ]);
        self::generateTranslation('group_is_private', [
            'en' => 'Group is private'
        ]);
        self::generateTranslation('no_user_associated_with_email', [
            'en' => 'No user is associated with this email address'
        ]);
        self::generateTranslation('pass_changed_success', [
            'en' => '<div class=\"simple_container\">\r\n    \t<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">Password has been changed, please check your email<\/h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 11px;\">You password has been successfully changed, please check your inbox for the newly generated password, once you login please change it accordingly by going to your account and click on change password.<\/p>\r\n <\/div>'
        ]);
        self::generateTranslation('add_as_friend', [
            'en' => 'Add as friend'
        ]);
        self::generateTranslation('block_user', [
            'en' => 'Block user'
        ]);
        self::generateTranslation('send_message', [
            'en' => 'Send message'
        ]);
        self::generateTranslation('no_item_was_selected_to_delete', [
            'en' => 'No item was selected to delete'
        ]);
        self::generateTranslation('playlist_items_have_been_removed', [
            'en' => 'Playlist items have been removed'
        ]);
        self::generateTranslation('you_not_grp_mem_or_approved', [
            'en' => 'You have not joined or an approved member of this group'
        ]);
        self::generateTranslation('no_playlist_was_selected_to_delete', [
            'en' => 'Select some playlist first.'
        ]);
        self::generateTranslation('featured_videos', [
            'en' => 'Featured Videos'
        ]);
        self::generateTranslation('recent_videos', [
            'en' => 'Recent Videos'
        ]);
        self::generateTranslation('featured_users', [
            'en' => 'Featured Users'
        ]);
        self::generateTranslation('top_collections', [
            'en' => 'Top Collections'
        ]);
        self::generateTranslation('top_playlists', [
            'en' => 'Top Playlists'
        ]);
        self::generateTranslation('load_more', [
            'en' => 'Load More'
        ]);
        self::generateTranslation('no_playlists', [
            'en' => 'No playlists found'
        ]);
        self::generateTranslation('featured_photos', [
            'en' => 'Featured Photos'
        ]);
        self::generateTranslation('no_channel_found', [
            'en' => 'No Channel Found'
        ]);
        self::generateTranslation('download', [
            'en' => 'Download'
        ]);
        self::generateTranslation('add_to', [
            'en' => 'Add to'
        ]);
        self::generateTranslation('player_size', [
            'en' => 'Player Size'
        ]);
        self::generateTranslation('small', [
            'en' => 'Small'
        ]);
        self::generateTranslation('medium', [
            'en' => 'Medium'
        ]);
        self::generateTranslation('large', [
            'en' => 'Large'
        ]);
        self::generateTranslation('iframe', [
            'en' => 'Iframe'
        ]);
        self::generateTranslation('embed_object', [
            'en' => 'Embed Object'
        ]);
        self::generateTranslation('add_to_my_favorites', [
            'en' => 'Add to Favorites'
        ]);
        self::generateTranslation('please_select_playlist', [
            'en' => 'Please SELECT playlist name FROM following'
        ]);
        self::generateTranslation('create_new_playlist', [
            'en' => 'Create new playlist'
        ]);
        self::generateTranslation('select_playlist', [
            'en' => 'SELECT FROM playlist'
        ]);
        self::generateTranslation('report_video', [
            'en' => 'Report Video'
        ]);
        self::generateTranslation('report_text', [
            'en' => 'Please SELECT the category that most closely reflects your concern about the video, so that we can review it and determine whether it violates our Community Guidelines or isn\'t appropriate for all viewers. Abusing this feature is also a violation of the Community Guidelines, so don\'t do it. '
        ]);
        self::generateTranslation('flag_video', [
            'en' => 'Flag this video'
        ]);
        self::generateTranslation('comment_as', [
            'en' => 'Comment as'
        ]);
        self::generateTranslation('more_replies', [
            'en' => 'More Replies'
        ]);
        self::generateTranslation('photo_description', [
            'en' => 'Photo description'
        ]);
        self::generateTranslation('flag', [
            'en' => 'Flag'
        ]);
        self::generateTranslation('update_cover', [
            'en' => 'Update Cover'
        ]);
        self::generateTranslation('unfriend', [
            'en' => 'Unfriend'
        ]);
        self::generateTranslation('accept_request', [
            'en' => 'Accept Request'
        ]);
        self::generateTranslation('online', [
            'en' => 'online'
        ]);
        self::generateTranslation('offline', [
            'en' => 'offline'
        ]);
        self::generateTranslation('upload_video', [
            'en' => 'Upload Video'
        ]);
        self::generateTranslation('upload_photo', [
            'en' => 'Upload Photo'
        ]);
        self::generateTranslation('upload_beats_guide', [
            'en' => '<strong>Important: Do not upload any audios that can be construed as Obscenity, copyrighted material, harassment, or spam.<\/strong>\r\n<p>By continuing \"Your Upload\'), you are representing that these audios do not violate Our website\'s Terms of Use and that you own all copyrights of these audios or have authorization to upload it.<\/p>'
        ]);
        self::generateTranslation('admin_area', [
            'en' => 'Admin Area'
        ]);
        self::generateTranslation('view_channels', [
            'en' => 'View Channels'
        ]);
        self::generateTranslation('my_channel', [
            'en' => 'My Channel'
        ]);
        self::generateTranslation('manage_videos', [
            'en' => 'Manage Videos'
        ]);
        self::generateTranslation('cancel_request', [
            'en' => 'Cancel Request'
        ]);
        self::generateTranslation('contact', [
            'en' => 'Contact'
        ]);
        self::generateTranslation('no_featured_videos_found', [
            'en' => 'No featured videos found'
        ]);
        self::generateTranslation('no_recent_videos_found', [
            'en' => 'no recent videos found'
        ]);
        self::generateTranslation('no_collection_found_alert', [
            'en' => 'No Collection Found! You must create a collection before uploading any photo'
        ]);
        self::generateTranslation('select_collection_upload', [
            'en' => 'Select Collection'
        ]);
        self::generateTranslation('no_collection_upload', [
            'en' => 'no collection found'
        ]);
        self::generateTranslation('create_new_collection_btn', [
            'en' => 'Create New Collection'
        ]);
        self::generateTranslation('photo_upload_tab', [
            'en' => 'Photo Upload'
        ]);
        self::generateTranslation('no_videos_found', [
            'en' => 'No Videos Found !'
        ]);
        self::generateTranslation('latest_videos', [
            'en' => 'Latest Videos'
        ]);
        self::generateTranslation('videos_details', [
            'en' => 'Videos Details'
        ]);
        self::generateTranslation('option', [
            'en' => 'Option'
        ]);
        self::generateTranslation('flagged_obj', [
            'en' => 'Flagged Objects'
        ]);
        self::generateTranslation('watched', [
            'en' => 'Watched'
        ]);
        self::generateTranslation('since', [
            'en' => 'since'
        ]);
        self::generateTranslation('last_Login', [
            'en' => 'Last Login'
        ]);
        self::generateTranslation('no_friends_in_list', [
            'en' => 'You have no friends in your list'
        ]);
        self::generateTranslation('no_pending_friend', [
            'en' => 'No Pending Friend Requests'
        ]);
        self::generateTranslation('hometown', [
            'en' => 'hometown'
        ]);
        self::generateTranslation('city', [
            'en' => 'City'
        ]);
        self::generateTranslation('schools', [
            'en' => 'schools'
        ]);
        self::generateTranslation('occupation', [
            'en' => 'occupation'
        ]);
        self::generateTranslation('you_dont_have_videos', [
            'en' => 'You don\'t have videos'
        ]);
        self::generateTranslation('write_msg', [
            'en' => 'write message'
        ]);
        self::generateTranslation('content', [
            'en' => 'content'
        ]);
        self::generateTranslation('no_video', [
            'en' => 'No Video'
        ]);
        self::generateTranslation('back_to_collection', [
            'en' => 'Back to Collection'
        ]);
        self::generateTranslation('long_txt', [
            'en' => 'All the photos uploaded are dependent on their collections/albums. When you remove some photo FROM collection/album, this will not delete photo permenently. It will move photo here. You can also use this to make your photos private. Direct link is available for you to share with your friends.'
        ]);
        self::generateTranslation('make_my_album', [
            'en' => 'Make my album'
        ]);
        self::generateTranslation('public', [
            'en' => 'public'
        ]);
        self::generateTranslation('private', [
            'en' => 'Private'
        ]);
        self::generateTranslation('for_friends', [
            'en' => 'For friends'
        ]);
        self::generateTranslation('submit_now', [
            'en' => 'Submit Now'
        ]);
        self::generateTranslation('drag_drop', [
            'en' => 'Drag &amp; Drop Files Here'
        ]);
        self::generateTranslation('upload_more_videos', [
            'en' => 'Upload More Videos'
        ]);
        self::generateTranslation('selected_files', [
            'en' => 'Selected Files'
        ]);
        self::generateTranslation('upload_in_progress', [
            'en' => 'Uploading in progress'
        ]);
        self::generateTranslation('complete_of_video', [
            'en' => 'Complete of Video'
        ]);
        self::generateTranslation('playlist_videos', [
            'en' => 'Playlist videos'
        ]);
        self::generateTranslation('popular_videos', [
            'en' => 'Popular Videos'
        ]);
        self::generateTranslation('uploading', [
            'en' => 'Uploading'
        ]);
        self::generateTranslation('select_photos', [
            'en' => 'Select Photos'
        ]);
        self::generateTranslation('uploading_in_progress', [
            'en' => 'Uploading in progress '
        ]);
        self::generateTranslation('complete_of_photo', [
            'en' => 'Complete of Photo'
        ]);
        self::generateTranslation('upload_more_photos', [
            'en' => 'Upload More Photos'
        ]);
        self::generateTranslation('save_details', [
            'en' => 'Save Details'
        ]);
        self::generateTranslation('related_photos', [
            'en' => 'Related Photos'
        ]);
        self::generateTranslation('no_photos_found', [
            'en' => 'No Photos Found !'
        ]);
        self::generateTranslation('search_keyword_feed', [
            'en' => 'Search keyword here'
        ]);
        self::generateTranslation('contacts_manager', [
            'en' => 'Contacts Manager'
        ]);
        self::generateTranslation('weak_pass', [
            'en' => 'Password is weak'
        ]);
        self::generateTranslation('create_account_msg', [
            'en' => 'Join to start sharing videos and photos. It only takes a couple of minutes to create your free account'
        ]);
        self::generateTranslation('get_your_account', [
            'en' => 'Create Account'
        ]);
        self::generateTranslation('type_password_here', [
            'en' => 'Type password'
        ]);
        self::generateTranslation('type_username_here', [
            'en' => 'Type username'
        ]);
        self::generateTranslation('terms_of_service', [
            'en' => 'Terms of service'
        ]);
        self::generateTranslation('upload_vid_thumb_msg', [
            'en' => 'Thumbs uploaded successfuly'
        ]);
        self::generateTranslation('agree', [
            'en' => 'I Agree to'
        ]);
        self::generateTranslation('terms', [
            'en' => 'Terms of Service'
        ]);
        self::generateTranslation('and', [
            'en' => 'and'
        ]);
        self::generateTranslation('policy', [
            'en' => 'Privacy Policy'
        ]);
        self::generateTranslation('watch', [
            'en' => 'Watch'
        ]);
        self::generateTranslation('edit_video', [
            'en' => 'Edit'
        ]);
        self::generateTranslation('del_video', [
            'en' => 'Delete'
        ]);
        self::generateTranslation('processing', [
            'en' => 'Processing'
        ]);
        self::generateTranslation('last_one', [
            'en' => 'aye'
        ]);
        self::generateTranslation('creating_collection_is_disabled', [
            'en' => 'Creating collection is disabled'
        ]);
        self::generateTranslation('creating_playlist_is_disabled', [
            'en' => 'Creating playlist is disabled'
        ]);
        self::generateTranslation('inactive', [
            'en' => 'Inactive'
        ]);
        self::generateTranslation('vdo_actions', [
            'en' => 'Actions'
        ]);
        self::generateTranslation('view_ph', [
            'en' => 'View'
        ]);
        self::generateTranslation('edit_ph', [
            'en' => 'Edit'
        ]);
        self::generateTranslation('delete_ph', [
            'en' => 'Delete'
        ]);
        self::generateTranslation('title_ph', [
            'en' => 'Title'
        ]);
        self::generateTranslation('view_edit_playlist', [
            'en' => 'View\/Edit'
        ]);
        self::generateTranslation('no_playlist_found', [
            'en' => 'No Playlist Found'
        ]);
        self::generateTranslation('playlist_owner', [
            'en' => 'Owner'
        ]);
        self::generateTranslation('playlist_privacy', [
            'en' => 'Privacy'
        ]);
        self::generateTranslation('add_to_collection', [
            'en' => 'Add to collection'
        ]);
        self::generateTranslation('video_added_to_playlist', [
            'en' => 'This video has been added to playlist'
        ]);
        self::generateTranslation('subscribe_btn', [
            'en' => 'Subscribe'
        ]);
        self::generateTranslation('report_usr', [
            'en' => 'Report'
        ]);
        self::generateTranslation('un_reg_user', [
            'en' => 'Unregistered user'
        ]);
        self::generateTranslation('my_playlists', [
            'en' => 'My Playlists'
        ]);
        self::generateTranslation('play', [
            'en' => 'Play now'
        ]);
        self::generateTranslation('no_vid_in_playlist', [
            'en' => 'No video found in this playlist!'
        ]);
        self::generateTranslation('website_offline', [
            'en' => 'ATTENTION: THIS WEBSITE IS IN OFFLINE MODE'
        ]);
        self::generateTranslation('loading', [
            'en' => 'Loading'
        ]);
        self::generateTranslation('hour', [
            'en' => 'hour'
        ]);
        self::generateTranslation('hours', [
            'en' => 'hours'
        ]);
        self::generateTranslation('day', [
            'en' => 'day'
        ]);
        self::generateTranslation('days', [
            'en' => 'days'
        ]);
        self::generateTranslation('week', [
            'en' => 'week'
        ]);
        self::generateTranslation('weeks', [
            'en' => 'weeks'
        ]);
        self::generateTranslation('month', [
            'en' => 'month'
        ]);
        self::generateTranslation('months', [
            'en' => 'months'
        ]);
        self::generateTranslation('year', [
            'en' => 'year'
        ]);
        self::generateTranslation('years', [
            'en' => 'years'
        ]);
        self::generateTranslation('decade', [
            'en' => 'decade'
        ]);
        self::generateTranslation('decades', [
            'en' => 'decades'
        ]);
        self::generateTranslation('your_name', [
            'en' => 'Your Name'
        ]);
        self::generateTranslation('your_email', [
            'en' => 'Your Email'
        ]);
        self::generateTranslation('type_comment_box', [
            'en' => 'Please type something in comment box'
        ]);
        self::generateTranslation('guest', [
            'en' => 'Guest'
        ]);
        self::generateTranslation('anonymous', [
            'en' => 'Anonymous'
        ]);
        self::generateTranslation('no_comment_added', [
            'en' => 'No Comments Added'
        ]);
        self::generateTranslation('register_min_age_request', [
            'en' => 'You must be atleast %s year old to register'
        ]);
        self::generateTranslation('select_category', [
            'en' => 'Please SELECT your category'
        ]);
        self::generateTranslation('custom', [
            'en' => 'custom'
        ]);
        self::generateTranslation('no_playlist_exists', [
            'en' => 'No playlist exists'
        ]);
        self::generateTranslation('edit', [
            'en' => 'Edit'
        ]);
        self::generateTranslation('create_new_account', [
            'en' => 'Create new account'
        ]);
        self::generateTranslation('search_too_short', [
            'en' => 'Search query %s is too short. Open up!'
        ]);
        self::generateTranslation('playlist_allow_comments', [
            'en' => 'Allow Comments'
        ]);
        self::generateTranslation('playlist_allow_rating', [
            'en' => 'Allow Rating'
        ]);
        self::generateTranslation('playlist_description', [
            'en' => 'Description'
        ]);
        self::generateTranslation('playlists_have_been_removed', [
            'en' => 'Playlists have been removed'
        ]);
        self::generateTranslation('confirm_collection_delete', [
            'en' => 'Do you really want to delete this collection ?'
        ]);
        self::generateTranslation('please_select_collection', [
            'en' => 'Please SELECT collection name FROM following'
        ]);
        self::generateTranslation('please_enter_collection_name', [
            'en' => 'Please enter collection name'
        ]);
        self::generateTranslation('select_collection', [
            'en' => 'SELECT FROM collection'
        ]);
        self::generateTranslation('resolution', [
            'en' => 'Resolution'
        ]);
        self::generateTranslation('filesize', [
            'en' => 'File size'
        ]);
        self::generateTranslation('empty_next', [
            'en' => 'Playlist reached to its limit!'
        ]);
        self::generateTranslation('no_items', [
            'en' => 'No items'
        ]);
        self::generateTranslation('user_recover_user', [
            'en' => 'Forgot Username'
        ]);
        self::generateTranslation('edited_by', [
            'en' => 'edited by'
        ]);
        self::generateTranslation('reply_to', [
            'en' => 'Reply to'
        ]);
        self::generateTranslation('mail_type', [
            'en' => 'Mail type'
        ]);
        self::generateTranslation('host', [
            'en' => 'Host'
        ]);
        self::generateTranslation('port', [
            'en' => 'Port'
        ]);
        self::generateTranslation('user', [
            'en' => 'User'
        ]);
        self::generateTranslation('auth', [
            'en' => 'Auth'
        ]);
        self::generateTranslation('mail_not_send', [
            'en' => 'Unable to send email <strong>%s</strong>'
        ]);
        self::generateTranslation('mail_send', [
            'en' => 'Email successfully send to <strong>%s</strong>'
        ]);
        self::generateTranslation('title', [
            'en' => 'Title'
        ]);
        self::generateTranslation('show_comments', [
            'en' => 'Show comments'
        ]);
        self::generateTranslation('hide_comments', [
            'en' => 'Hide comments'
        ]);
        self::generateTranslation('description', [
            'en' => 'Description'
        ]);
        self::generateTranslation('users_categories', [
            'en' => 'Users Categories'
        ]);
        self::generateTranslation('popular_users', [
            'en' => 'Popular Users'
        ]);
        self::generateTranslation('channel', [
            'en' => 'Channel'
        ]);
        self::generateTranslation('embed_type', [
            'en' => 'Embed type'
        ]);
        self::generateTranslation('confirm_del_photo', [
            'en' => 'Are you sure you want to delete this photo ?'
        ]);
        self::generateTranslation('vdo_inactive', [
            'en' => 'Video is inactive'
        ]);
        self::generateTranslation('photo_tags_error', [
            'en' => 'Please specify tags for the Photo'
        ]);
        self::generateTranslation('signups', [
            'en' => 'Signups'
        ]);
        self::generateTranslation('active_users', [
            'en' => 'Active Users'
        ]);
        self::generateTranslation('uploaded', [
            'en' => 'Uploaded'
        ]);
        self::generateTranslation('user_name_invalid_len', [
            'en' => 'Username length is invalid'
        ]);
        self::generateTranslation('username_spaces', [
            'en' => 'Username can\'t contain spaces'
        ]);
        self::generateTranslation('photo_caption_err', [
            'en' => 'Please Enter Photo Description'
        ]);
        self::generateTranslation('photo_tags_err', [
            'en' => 'Please Enter Tags For The Photo'
        ]);
        self::generateTranslation('photo_collection_err', [
            'en' => 'You must specify a collection for this photo'
        ]);
        self::generateTranslation('details', [
            'en' => 'Details'
        ]);
        self::generateTranslation('technical_error', [
            'en' => 'A technical error occurred !'
        ]);
        self::generateTranslation('inserted', [
            'en' => 'Inserted'
        ]);
        self::generateTranslation('castable_status_fixed', [
            'en' => '%s castable status has been fixed'
        ]);
        self::generateTranslation('castable_status_failed', [
            'en' => '%s can\'t be casted correctly because it has %s audio channels, please reconvert video with chromecast option enabled'
        ]);
        self::generateTranslation('castable_status_check', [
            'en' => 'Check Castable Status'
        ]);
        self::generateTranslation('castable', [
            'en' => 'Castable'
        ]);
        self::generateTranslation('non_castable', [
            'en' => 'Non-Castable'
        ]);
        self::generateTranslation('videos_manager', [
            'en' => 'Videos Manager'
        ]);
        self::generateTranslation('update_bits_color', [
            'en' => 'Update bits colors'
        ]);
        self::generateTranslation('bits_color', [
            'en' => 'bits colors'
        ]);
        self::generateTranslation('bits_color_compatibility', [
            'en' => 'The video format make it not playable on some browsers LIKE Firefox, Safari, ...'
        ]);
        self::generateTranslation('player_logo_reset', [
            'en' => 'Player Logo has been reset'
        ]);
        self::generateTranslation('player_settings_updated', [
            'en' => 'Player Settings have been updated'
        ]);
        self::generateTranslation('player_settings', [
            'en' => 'Player Settings'
        ]);
        self::generateTranslation('quality', [
            'en' => 'Quality'
        ]);
        self::generateTranslation('error_occured', [
            'en' => 'Oops... Something wrong happend...'
        ]);
        self::generateTranslation('error_file_download', [
            'en' => 'Can\'t get file'
        ]);
        self::generateTranslation('dashboard_update_status', [
            'en' => 'Update status'
        ]);
        self::generateTranslation('dashboard_changelogs', [
            'en' => 'Changelogs'
        ]);
        self::generateTranslation('dashboard_php_config_allow_url_fopen', [
            'en' => 'Please enable \'allow_url_fopen\' to benefit of changelogs'
        ]);
        self::generateTranslation('signup_error_email_unauthorized', [
            'en' => 'Email not allowed'
        ]);
        self::generateTranslation('video_detail_saved', [
            'en' => 'Video details has been saved'
        ]);
        self::generateTranslation('video_subtitles_deleted', [
            'en' => 'Video subtitles has been deleted'
        ]);
        self::generateTranslation('collection_no_parent', [
            'en' => 'No parent'
        ]);
        self::generateTranslation('collection_parent', [
            'en' => 'Parent collection'
        ]);
        self::generateTranslation('comments_disabled_for_photo', [
            'en' => 'Comments disabled for this photo'
        ]);
        self::generateTranslation('plugin_editors_picks', [
            'en' => 'Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_added', [
            'en' => 'Video has been added to Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_removed', [
            'en' => 'Video has been removed FROM Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_removed_plural', [
            'en' => 'Selected video has been removed FROM Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_add_error', [
            'en' => 'Video is already in the Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_add_to', [
            'en' => 'Add to Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_from', [
            'en' => 'Remove FROM Editor\'s Pick'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_confirm', [
            'en' => 'Are you sure you want to remove selected videos FROM Editor\'s Pick ?'
        ]);
        self::generateTranslation('plugin_global_announcement', [
            'en' => 'Global Announcement'
        ]);
        self::generateTranslation('plugin_global_announcement_subtitle', [
            'en' => 'Global Announcement Manager'
        ]);
        self::generateTranslation('plugin_global_announcement_edit', [
            'en' => 'Edit global announcement'
        ]);
        self::generateTranslation('plugin_global_announcement_updated', [
            'en' => 'Global announcement has been updated'
        ]);
        self::generateTranslation('page_upload_video_limits', [
            'en' => 'Each video may not exceed %s MB in size or %s minutes in length and must be in a common video format'
        ]);
        self::generateTranslation('page_upload_video_select', [
            'en' => ' Select Video'
        ]);
        self::generateTranslation('page_upload_photo_limits', [
            'en' => 'Each photo may not exceed %s MB in size and must be in a common image format'
        ]);
        self::generateTranslation('video_resolution_auto', [
            'en' => 'Auto'
        ]);
        self::generateTranslation('video_thumbs_regenerated', [
            'en' => 'Video thumbs has been regenerated successfully'
        ]);
        self::generateTranslation('video_allow_comment_vote', [
            'en' => 'Allow votes on comments'
        ]);
        self::generateTranslation('language', [
            'en' => 'Language'
        ]);
        self::generateTranslation('progression', [
            'en' => 'Progression'
        ]);

        /** FR **/

        self::generateTranslation('ad_name_error', [
            'fr' => 'Merci d\'entrer un nom pour la publicité'
        ]);
        self::generateTranslation('ad_code_error', [
            'fr' => 'Erreur : Merci d\'entrer un code pour la publicité'
        ]);
        self::generateTranslation('ad_exists_error1', [
            'fr' => 'La publicité n\'existe pas'
        ]);
        self::generateTranslation('ad_exists_error2', [
            'fr' => 'Erreur : Une publicité avec le même nom existe déjà'
        ]);
        self::generateTranslation('ad_add_msg', [
            'fr' => 'La publicité a été ajouté avec succès'
        ]);
        self::generateTranslation('ad_update_msg', [
            'fr' => 'La publicité a été mise à jour'
        ]);
        self::generateTranslation('ad_del_msg', [
            'fr' => 'La publicité a été supprimé'
        ]);
        self::generateTranslation('ad_deactive', [
            'fr' => 'Désactivée'
        ]);
        self::generateTranslation('ad_active', [
            'fr' => 'Activée'
        ]);
        self::generateTranslation('ad_placment_delete_msg', [
            'fr' => 'Le placement a été supprimé'
        ]);
        self::generateTranslation('ad_placement_err1', [
            'fr' => 'Placement existe déjà'
        ]);
        self::generateTranslation('ad_placement_err2', [
            'fr' => 'Merci d\'entrer un nom pour le placement'
        ]);
        self::generateTranslation('ad_placement_err3', [
            'fr' => 'Merci d\'entrer un code pour le placement'
        ]);
        self::generateTranslation('ad_placement_msg', [
            'fr' => 'Le placement a été ajouté'
        ]);
        self::generateTranslation('cat_img_error', [
            'fr' => 'Merci de téléverser uniquement des images aau format JPEG, GIF ou PNG'
        ]);
        self::generateTranslation('cat_exist_error', [
            'fr' => 'La catégorie n\'existe pas'
        ]);
        self::generateTranslation('cat_add_msg', [
            'fr' => 'La catégorie a été ajoutée'
        ]);
        self::generateTranslation('cat_update_msg', [
            'fr' => 'Category a été mise à jour'
        ]);
        self::generateTranslation('grp_err', [
            'fr' => 'Le groupe n\'existe pas'
        ]);
        self::generateTranslation('grp_fr_msg', [
            'fr' => 'Le groupe a été msi en avant'
        ]);
        self::generateTranslation('grp_fr_msg1', [
            'fr' => 'Le groupe sélectionné a été supprimé de la liste de mise en avant'
        ]);
        self::generateTranslation('grp_ac_msg', [
            'fr' => 'Le groupe sélectionné a été activé'
        ]);
        self::generateTranslation('grp_dac_msg', [
            'fr' => 'Le groupe sélectionné a été désactivé'
        ]);
        self::generateTranslation('grp_del_msg', [
            'fr' => 'Le groupe a été supprimé'
        ]);
        self::generateTranslation('editor_pic_up', [
            'fr' => 'La vidéo a été déplacé vers le haut'
        ]);
        self::generateTranslation('editor_pic_down', [
            'fr' => 'La vidéo a été déplacé vers le bas'
        ]);
        self::generateTranslation('plugin_install_msg', [
            'fr' => 'Le plugin a été installé'
        ]);
        self::generateTranslation('plugin_no_file_err', [
            'fr' => 'Aucun fichier n\'a été trouvé'
        ]);
        self::generateTranslation('plugin_file_detail_err', [
            'fr' => 'Il manque des informations sur le plugin'
        ]);
        self::generateTranslation('plugin_installed_err', [
            'fr' => 'Le plugin est déjà installé'
        ]);
        self::generateTranslation('plugin_no_install_err', [
            'fr' => 'Le plugin n\'est pas installé'
        ]);
        self::generateTranslation('grp_name_error', [
            'fr' => 'Merci d\'entrer un nom de groupe'
        ]);
        self::generateTranslation('grp_name_error1', [
            'fr' => 'Ce nom de groupe existe déjà'
        ]);
        self::generateTranslation('grp_des_error', [
            'fr' => 'Merci d\'entrer une description rapide pour ce groupe'
        ]);
        self::generateTranslation('grp_tags_error', [
            'fr' => 'Merci d\'entrer des tags pour ce groupe'
        ]);
        self::generateTranslation('grp_url_error', [
            'fr' => 'Merci d\'entrer une URL valide pour ce groupe'
        ]);
        self::generateTranslation('grp_url_error1', [
            'fr' => 'Merci d\'entrer un nom d\'URL valide'
        ]);
        self::generateTranslation('grp_url_error2', [
            'fr' => 'Ce groupe d\'URL existe déjà, merci d\'en choisir une autre'
        ]);
        self::generateTranslation('grp_tpc_error', [
            'fr' => 'Merci d\'entrer un sujet à ajouter'
        ]);
        self::generateTranslation('grp_comment_error', [
            'fr' => 'VOus devez saisir un commentaire'
        ]);
        self::generateTranslation('grp_join_error', [
            'fr' => 'Vous avez déjà rejoint ce groupe'
        ]);
        self::generateTranslation('grp_prvt_error', [
            'fr' => 'Ce groupe est privé, merci de vous identifier pour voir ce groupe'
        ]);
        self::generateTranslation('grp_inact_error', [
            'fr' => 'Ce groupe est inactif, merci de contacter votre admnistrateur'
        ]);
        self::generateTranslation('grp_join_error1', [
            'fr' => 'Vous n\'avez pas encore rejoint ce groupe'
        ]);
        self::generateTranslation('grp_exist_error', [
            'fr' => 'Désolé, ce groupe n\'existe pas'
        ]);
        self::generateTranslation('grp_tpc_error1', [
            'fr' => 'Ce sujet n\'est pas approuvé par le propriétaire du groupe'
        ]);
        self::generateTranslation('grp_cat_error', [
            'fr' => 'Merci de sélectionner une catégorie pour votre groupe'
        ]);
        self::generateTranslation('grp_tpc_error2', [
            'fr' => 'Merci d\'entrer un sujet pour cette publicité'
        ]);
        self::generateTranslation('grp_tpc_error3', [
            'fr' => 'Votre sujet doit être approuvé par le propriétaire du groupe'
        ]);
        self::generateTranslation('grp_tpc_msg', [
            'fr' => 'Votre sujet a été ajouté'
        ]);
        self::generateTranslation('grp_comment_msg', [
            'fr' => 'Le commentaire a été ajouté'
        ]);
        self::generateTranslation('grp_vdo_msg', [
            'fr' => 'La vidéo a été supprimée'
        ]);
        self::generateTranslation('grp_vdo_msg1', [
            'fr' => 'La vidéo a été ajoutée avec succès'
        ]);
        self::generateTranslation('grp_vdo_msg2', [
            'fr' => 'La vidéo a été approuvée'
        ]);
        self::generateTranslation('grp_mem_msg', [
            'fr' => 'Le membre a été supprimée'
        ]);
        self::generateTranslation('grp_mem_msg1', [
            'fr' => 'Le membre a été approuvé'
        ]);
        self::generateTranslation('grp_inv_msg', [
            'fr' => 'Votre inviation a été envoyée'
        ]);
        self::generateTranslation('grp_tpc_msg1', [
            'fr' => 'Le sujet a été supprimé'
        ]);
        self::generateTranslation('grp_tpc_msg2', [
            'fr' => 'Le sujet a été approuvé'
        ]);
        self::generateTranslation('grp_fr_msg2', [
            'fr' => 'Le groupe a été supprimé de la liste de mise en avant'
        ]);
        self::generateTranslation('grp_inv_msg1', [
            'fr' => 'vous a invité à rejoindre'
        ]);
        self::generateTranslation('grp_av_msg', [
            'fr' => 'Le groupe a été activé'
        ]);
        self::generateTranslation('grp_da_msg', [
            'fr' => 'Le groupe a été désactivé'
        ]);
        self::generateTranslation('grp_post_msg', [
            'fr' => 'Le message a été supprimé'
        ]);
        self::generateTranslation('grp_update_msg', [
            'fr' => 'Le groupe a été mis à jour'
        ]);
        self::generateTranslation('grp_owner_err', [
            'fr' => 'Seul le propriétaire du groupe peut ajouter des vidéos'
        ]);
        self::generateTranslation('grp_owner_err1', [
            'fr' => 'Vous n\'êtes pas le propriétaire du groupe'
        ]);
        self::generateTranslation('grp_owner_err2', [
            'fr' => 'Vous n\'êtes pas le propriétaire du groupe. Vous ne pouvez pas quitter le groupe.'
        ]);
        self::generateTranslation('grp_prvt_err1', [
            'fr' => 'Ce groupe est privé, vous avez besoin d\'une invitation pour pouvoir le rejoindre'
        ]);
        self::generateTranslation('grp_rmv_msg', [
            'fr' => 'Le groupe sélectionné a été suppriméé de votre compte'
        ]);
        self::generateTranslation('grp_tpc_err4', [
            'fr' => 'Désolé, le sujet n\'existe pas'
        ]);
        self::generateTranslation('grp_title_topic', [
            'fr' => 'Groupe - Sujet - '
        ]);
        self::generateTranslation('grp_add_title', [
            'fr' => '- Ajouter une vidéo'
        ]);
        self::generateTranslation('usr_sadmin_err', [
            'fr' => 'Vous ne pouvez pas mettre l\'identifiant du SuperAdmin à vide'
        ]);
        self::generateTranslation('usr_cpass_err', [
            'fr' => 'Le mot de passe de confirmation ne correspond pas'
        ]);
        self::generateTranslation('usr_pass_err', [
            'fr' => 'L\'ancien mot de passe est incorrect'
        ]);
        self::generateTranslation('usr_email_err', [
            'fr' => 'Merci d\'entrer une adresse email valide'
        ]);
        self::generateTranslation('usr_cpass_err1', [
            'fr' => 'Le mot de passe de confirmation est incorrect'
        ]);
        self::generateTranslation('usr_pass_err1', [
            'fr' => 'Le mot de passe est incorrect'
        ]);
        self::generateTranslation('usr_cmt_err', [
            'fr' => 'Vous devez vous connecter pour écrire un commentaire'
        ]);
        self::generateTranslation('usr_cmt_err1', [
            'fr' => 'Merci d\'écrire quelque chose dans le champs commentaire'
        ]);
        self::generateTranslation('usr_cmt_err2', [
            'fr' => 'Vous ne pouvez pas commenter votre vidéo'
        ]);
        self::generateTranslation('usr_cmt_err3', [
            'fr' => 'Vous avez déjà commenté cette chaine'
        ]);
        self::generateTranslation('usr_cmt_err4', [
            'fr' => 'Votre commentaire a été ajouté'
        ]);
        self::generateTranslation('usr_exist_err', [
            'fr' => 'Cet utilisateur n\'existe pas'
        ]);
        self::generateTranslation('usr_uname_err', [
            'fr' => 'L\'identifiant est vide'
        ]);
        self::generateTranslation('usr_uname_err2', [
            'fr' => 'L\'identifiant est déjà utilisé'
        ]);
        self::generateTranslation('usr_pass_err2', [
            'fr' => 'Le mot de passe est vide'
        ]);
        self::generateTranslation('usr_email_err1', [
            'fr' => 'L\'email est vide'
        ]);
        self::generateTranslation('usr_email_err2', [
            'fr' => 'L\'adresse email n\'est pas valide'
        ]);
        self::generateTranslation('usr_email_err3', [
            'fr' => 'L\'adresse email est déjà utilisée'
        ]);
        self::generateTranslation('usr_pass_err3', [
            'fr' => 'Les mots de passes le correspondent pas'
        ]);
        self::generateTranslation('usr_ban_err', [
            'fr' => 'Votre compte est banni, veuillez contacter l\'administrateur du site'
        ]);
        self::generateTranslation('usr_login_err', [
            'fr' => 'Le couple identifiant/mot de passe ne correspond à aucun compte'
        ]);
        self::generateTranslation('usr_sadmin_msg', [
            'fr' => 'Super Admin a été mis à jour'
        ]);
        self::generateTranslation('usr_sub_msg', [
            'fr' => 'Vous êtes à présent inscrit à %s'
        ]);
        self::generateTranslation('usr_email_msg', [
            'fr' => 'Email Settings a été mis à jour'
        ]);
        self::generateTranslation('usr_dels_msg', [
            'fr' => 'Les membres sélectionnés ont été supprimés'
        ]);
        self::generateTranslation('usr_uban_msg', [
            'fr' => 'L\'utilisateur a été banni'
        ]);
        self::generateTranslation('usr_add_succ_msg', [
            'fr' => 'L\'utilisateur a été mis à jour'
        ]);
        self::generateTranslation('usr_upd_succ_msg', [
            'fr' => 'User a été mis à jour'
        ]);
        self::generateTranslation('usr_pof_upd_msg', [
            'fr' => 'Le profile a été mis à jour'
        ]);
        self::generateTranslation('usr_arr_no_ans', [
            'fr' => 'Non renseigné'
        ]);
        self::generateTranslation('class_vdo_fr_msg', [
            'fr' => 'La vidéo a été ajouté aux vidéos vedettes'
        ]);
        self::generateTranslation('class_fr_msg1', [
            'fr' => 'La vidéo a été retirée des vidéos vedettes'
        ]);
        self::generateTranslation('class_vdo_act_msg', [
            'fr' => 'La vidéo a été activée'
        ]);
        self::generateTranslation('class_vdo_act_msg1', [
            'fr' => 'La vidéo a été désactivée'
        ]);
        self::generateTranslation('class_vdo_update_msg', [
            'fr' => 'Les détails de la vidéo ont été mis à jours'
        ]);
        self::generateTranslation('class_unsub_msg', [
            'fr' => 'Désinscription enregistrée'
        ]);
        self::generateTranslation('class_vdo_exist_err', [
            'fr' => 'Désolé, cette vidéo n\'existe pas'
        ]);
        self::generateTranslation('com_forgot_username', [
            'fr' => 'Identifiant | Mot de passe oublié'
        ]);
        self::generateTranslation('com_my_account', [
            'fr' => 'Mon compte'
        ]);
        self::generateTranslation('com_manage_vids', [
            'fr' => 'Gestion des Vidéos'
        ]);
        self::generateTranslation('com_vidz', [
            'fr' => 'Vidéos'
        ]);
        self::generateTranslation('com_manage_fav', [
            'fr' => 'Gérer les favoris'
        ]);
        self::generateTranslation('com_advance_results', [
            'fr' => 'Recherche avancée'
        ]);
        self::generateTranslation('featured', [
            'fr' => 'Vedette'
        ]);
        self::generateTranslation('lang_folder', [
            'fr' => 'en'
        ]);
        self::generateTranslation('all', [
            'fr' => 'Tous'
        ]);
        self::generateTranslation('active', [
            'fr' => 'Actif'
        ]);
        self::generateTranslation('activate', [
            'fr' => 'Activer'
        ]);
        self::generateTranslation('deactivate', [
            'fr' => 'Désactiver'
        ]);
        self::generateTranslation('age', [
            'fr' => 'Age'
        ]);
        self::generateTranslation('by', [
            'fr' => 'par'
        ]);
        self::generateTranslation('cancel', [
            'fr' => 'Annuler'
        ]);
        self::generateTranslation('categories', [
            'fr' => 'Catégories'
        ]);
        self::generateTranslation('category', [
            'fr' => 'Catégorie'
        ]);
        self::generateTranslation('channels', [
            'fr' => 'Chaînes'
        ]);
        self::generateTranslation('comments', [
            'fr' => 'Commentaires'
        ]);
        self::generateTranslation('comment', [
            'fr' => 'Commentaire'
        ]);
        self::generateTranslation('country', [
            'fr' => 'Pays'
        ]);
        self::generateTranslation('date', [
            'fr' => 'Date'
        ]);
        self::generateTranslation('date_added', [
            'fr' => 'Date d\'ajout'
        ]);
        self::generateTranslation('delete', [
            'fr' => 'Supprimer'
        ]);
        self::generateTranslation('add', [
            'fr' => 'Ajouter'
        ]);
        self::generateTranslation('delete_selected', [
            'fr' => 'Supprimer la sélection'
        ]);
        self::generateTranslation('des_title', [
            'fr' => 'Description:'
        ]);
        self::generateTranslation('duration', [
            'fr' => 'Durée'
        ]);
        self::generateTranslation('education', [
            'fr' => 'Education'
        ]);
        self::generateTranslation('email', [
            'fr' => 'email'
        ]);
        self::generateTranslation('female', [
            'fr' => 'Femme'
        ]);
        self::generateTranslation('filter', [
            'fr' => 'Filtrer'
        ]);
        self::generateTranslation('friends', [
            'fr' => 'Amis'
        ]);
        self::generateTranslation('FROM', [
            'fr' => 'De'
        ]);
        self::generateTranslation('gender', [
            'fr' => 'Genre'
        ]);
        self::generateTranslation('groups', [
            'fr' => 'Groups'
        ]);
        self::generateTranslation('joined', [
            'fr' => 'Inscription'
        ]);
        self::generateTranslation('latest', [
            'fr' => 'Dernière'
        ]);
        self::generateTranslation('location', [
            'fr' => 'Localisation'
        ]);
        self::generateTranslation('login', [
            'fr' => 'Connexion'
        ]);
        self::generateTranslation('logout', [
            'fr' => 'Déconnexion'
        ]);
        self::generateTranslation('male', [
            'fr' => 'Homme'
        ]);
        self::generateTranslation('messages', [
            'fr' => 'Messages'
        ]);
        self::generateTranslation('message', [
            'fr' => 'Message'
        ]);
        self::generateTranslation('minute', [
            'fr' => 'minute'
        ]);
        self::generateTranslation('minutes', [
            'fr' => 'minutes'
        ]);
        self::generateTranslation('most_recent', [
            'fr' => 'Plus récent'
        ]);
        self::generateTranslation('music', [
            'fr' => 'Musique'
        ]);
        self::generateTranslation('my_account', [
            'fr' => 'Mon Compte'
        ]);
        self::generateTranslation('next', [
            'fr' => 'Suivant'
        ]);
        self::generateTranslation('no', [
            'fr' => 'Non'
        ]);
        self::generateTranslation('occupations', [
            'fr' => 'Occupations'
        ]);
        self::generateTranslation('optional', [
            'fr' => 'optionnel'
        ]);
        self::generateTranslation('password', [
            'fr' => 'Mot de passe'
        ]);
        self::generateTranslation('reply', [
            'fr' => 'Répondre'
        ]);
        self::generateTranslation('second', [
            'fr' => 'seconde'
        ]);
        self::generateTranslation('seconds', [
            'fr' => 'secondes'
        ]);
        self::generateTranslation('send', [
            'fr' => 'Envoyer'
        ]);
        self::generateTranslation('sent', [
            'fr' => 'Envoyé'
        ]);
        self::generateTranslation('signup', [
            'fr' => 'S\'inscrire'
        ]);
        self::generateTranslation('subject', [
            'fr' => 'Sujet'
        ]);
        self::generateTranslation('tags', [
            'fr' => 'Mots clés'
        ]);
        self::generateTranslation('to', [
            'fr' => 'À'
        ]);
        self::generateTranslation('type', [
            'fr' => 'Type'
        ]);
        self::generateTranslation('update', [
            'fr' => 'Mettre à jour'
        ]);
        self::generateTranslation('upload', [
            'fr' => 'Téléverser'
        ]);
        self::generateTranslation('url', [
            'fr' => 'Url'
        ]);
        self::generateTranslation('verification', [
            'fr' => 'Verification'
        ]);
        self::generateTranslation('videos', [
            'fr' => 'Vidéos'
        ]);
        self::generateTranslation('yes', [
            'fr' => 'Oui'
        ]);
        self::generateTranslation('of', [
            'fr' => 'of'
        ]);
        self::generateTranslation('on', [
            'fr' => 'on'
        ]);
        self::generateTranslation('previous', [
            'fr' => 'Précédent'
        ]);
        self::generateTranslation('rating', [
            'fr' => 'Note'
        ]);
        self::generateTranslation('ratings', [
            'fr' => 'Notes'
        ]);
        self::generateTranslation('remove', [
            'fr' => 'Retirer'
        ]);
        self::generateTranslation('search', [
            'fr' => 'Rechercher'
        ]);
        self::generateTranslation('services', [
            'fr' => 'Services'
        ]);
        self::generateTranslation('subscriptions', [
            'fr' => 'Abonnements'
        ]);
        self::generateTranslation('subscribers', [
            'fr' => 'Abonnés'
        ]);
        self::generateTranslation('tag_title', [
            'fr' => 'Mots clés'
        ]);
        self::generateTranslation('track_title', [
            'fr' => 'Piste audio'
        ]);
        self::generateTranslation('username', [
            'fr' => 'Identifiant'
        ]);
        self::generateTranslation('views', [
            'fr' => 'Vues'
        ]);
        self::generateTranslation('mostly_viewed', [
            'fr' => 'Plus vues'
        ]);
        self::generateTranslation('most_comments', [
            'fr' => 'Plus commentées'
        ]);
        self::generateTranslation('group', [
            'fr' => 'Groupe'
        ]);
        self::generateTranslation('style_choice', [
            'fr' => 'Style'
        ]);
        self::generateTranslation('vdo_title', [
            'fr' => 'Titre'
        ]);
        self::generateTranslation('vdo_desc', [
            'fr' => 'Description'
        ]);
        self::generateTranslation('vdo_cat', [
            'fr' => 'Catégories de la vidéo'
        ]);
        self::generateTranslation('vdo_cat_msg', [
            'fr' => 'Vous pouvez sélectionner jusqu\'à %s catégories'
        ]);
        self::generateTranslation('vdo_allow_comm', [
            'fr' => 'Autoriser les commentaires'
        ]);
        self::generateTranslation('vdo_allow_rating', [
            'fr' => 'Autoriser la notation de la vidéo'
        ]);
        self::generateTranslation('vdo_embed_opt1', [
            'fr' => 'Autoriser la publication sur d\'autres sites'
        ]);
        self::generateTranslation('vdo_manage_vdeos', [
            'fr' => 'Gestion des Vidéos'
        ]);
        self::generateTranslation('vdo_status', [
            'fr' => 'Statut'
        ]);
        self::generateTranslation('grp_des_title', [
            'fr' => 'Description:'
        ]);
        self::generateTranslation('grp_manage_vdos', [
            'fr' => 'Gestion des Vidéos'
        ]);
        self::generateTranslation('grp_view_vdos', [
            'fr' => 'Afficher les vidéos'
        ]);
        self::generateTranslation('grp_manage_members_title', [
            'fr' => 'Gestion des utilisateurs'
        ]);
        self::generateTranslation('grp_discus_title', [
            'fr' => 'Discussions'
        ]);
        self::generateTranslation('grp_add_comment', [
            'fr' => 'Ajouter un commentaire'
        ]);
        self::generateTranslation('usr_activation_title', [
            'fr' => 'User Activation'
        ]);
        self::generateTranslation('user_forgot_message', [
            'fr' => 'Mot de passe oublié'
        ]);
        self::generateTranslation('user_recover', [
            'fr' => 'Récupérer'
        ]);
        self::generateTranslation('user_reset', [
            'fr' => 'Réinitialiser'
        ]);
        self::generateTranslation('user_fav_videos', [
            'fr' => 'Vidéos favorites'
        ]);
        self::generateTranslation('user_forgot_username', [
            'fr' => 'Identifiant oublié'
        ]);
        self::generateTranslation('user_forgot_password', [
            'fr' => 'Mot de passe oublié'
        ]);
        self::generateTranslation('all_fields_req', [
            'fr' => 'Tous les champs sont nécessaires'
        ]);
        self::generateTranslation('user_allowed_format', [
            'fr' => 'Lettres A-Z ou a-z, Nombres 0-9 et Underscores _'
        ]);
        self::generateTranslation('user_confirm_pass', [
            'fr' => 'Confirmation du mot de passe'
        ]);
        self::generateTranslation('user_date_of_birth', [
            'fr' => 'Date de naissance'
        ]);
        self::generateTranslation('user_i_agree_to_the', [
            'fr' => 'J\'accepte les  <a href="%s" target="_blank">Conditions d\'utilisation<\/a> et la <a href="%s" target="_blank" >Politique de confidentialité<\/a>'
        ]);
        self::generateTranslation('user_and_activation', [
            'fr' => '&amp; Activation'
        ]);
        self::generateTranslation('user_relat_status', [
            'fr' => 'Relation'
        ]);
        self::generateTranslation('user_eg_website', [
            'fr' => 'e.g www.cafepixie.com'
        ]);
        self::generateTranslation('user_occupations', [
            'fr' => 'Occupation(s)'
        ]);
        self::generateTranslation('user_companies', [
            'fr' => 'Companies'
        ]);
        self::generateTranslation('user_user_avatar', [
            'fr' => 'Avatar de l\'utilisateur'
        ]);
        self::generateTranslation('user_change_email', [
            'fr' => 'Change Email'
        ]);
        self::generateTranslation('user_email_address', [
            'fr' => 'Adresse email'
        ]);
        self::generateTranslation('user_s_channel', [
            'fr' => 'Chaîne de %s'
        ]);
        self::generateTranslation('user_last_login', [
            'fr' => 'Dernière connexion'
        ]);
        self::generateTranslation('user_send_message', [
            'fr' => 'Envoyer un message'
        ]);
        self::generateTranslation('user_add_comment', [
            'fr' => 'Commenter'
        ]);
        self::generateTranslation('vdo_cat_err2', [
            'fr' => 'Vous ne pouvez pas sélectionner plus de %d catégories'
        ]);
        self::generateTranslation('user_subscribe_subject', [
            'fr' => '%user% a mis en ligne une nouvelle vidéo'
        ]);
        self::generateTranslation('you_already_logged', [
            'fr' => 'Vous êtes déjà connecté'
        ]);
        self::generateTranslation('you_not_logged_in', [
            'fr' => 'Vous n\'êtes pas connecté'
        ]);
        self::generateTranslation('vid_thumb_changed', [
            'fr' => 'La vignette par défaut de la vidéo a été changée'
        ]);
        self::generateTranslation('video_thumb_delete_msg', [
            'fr' => 'La vignette de la vidéo a été supprimée'
        ]);
        self::generateTranslation('add_cat_erro', [
            'fr' => 'Cette catégorie existe déjà'
        ]);
        self::generateTranslation('cat_set_default_ok', [
            'fr' => 'La catégorie a été définie par défaut'
        ]);
        self::generateTranslation('vid_thumb_removed_msg', [
            'fr' => 'La catégorie a été définie par défaut'
        ]);
        self::generateTranslation('vid_files_removed_msg', [
            'fr' => 'Les fichiers de la vidéo ont été supprimés'
        ]);
        self::generateTranslation('vid_log_delete_msg', [
            'fr' => 'Les logs de la vidéo ont été supprimés'
        ]);
        self::generateTranslation('vdo_multi_del_erro', [
            'fr' => 'Les vidéos ont été supprimées'
        ]);
        self::generateTranslation('add_fav_message', [
            'fr' => 'Cette %s a été ajoutée à vos favoris'
        ]);
        self::generateTranslation('obj_not_exists', [
            'fr' => '%s n\'existe pas'
        ]);
        self::generateTranslation('already_fav_message', [
            'fr' => 'Cette %s a déjà été ajoutée à vos favoris'
        ]);
        self::generateTranslation('obj_report_msg', [
            'fr' => 'Cette %s a été signalée'
        ]);
        self::generateTranslation('obj_report_err', [
            'fr' => 'Vous avez déjà signalé cette %s'
        ]);
        self::generateTranslation('today', [
            'fr' => 'Aujourd\'hui'
        ]);
        self::generateTranslation('yesterday', [
            'fr' => 'Hier'
        ]);
        self::generateTranslation('thisweek', [
            'fr' => 'Cette semaine'
        ]);
        self::generateTranslation('lastweek', [
            'fr' => 'Semaine dernière'
        ]);
        self::generateTranslation('thismonth', [
            'fr' => 'Ce mois'
        ]);
        self::generateTranslation('lastmonth', [
            'fr' => 'Mois dernier'
        ]);
        self::generateTranslation('thisyear', [
            'fr' => 'Cette année'
        ]);
        self::generateTranslation('lastyear', [
            'fr' => 'Année dernière'
        ]);
        self::generateTranslation('favorites', [
            'fr' => 'Favorites'
        ]);
        self::generateTranslation('alltime', [
            'fr' => 'Toujours'
        ]);
        self::generateTranslation('bad_date', [
            'fr' => 'Jamais'
        ]);
        self::generateTranslation('users_videos', [
            'fr' => '%s\'s Videos'
        ]);
        self::generateTranslation('please_login_subscribe', [
            'fr' => 'Veuillez vous connecter pour vous abonner à %s'
        ]);
        self::generateTranslation('usr_avatar_bg_update', [
            'fr' => 'L\'avatar et l\'image de fond ont été mises à jour'
        ]);
        self::generateTranslation('remove_fav_video_confirm', [
            'fr' => 'Êtes-vous sûr de vouloir supprimer cette vidéo de vos favoris ?'
        ]);
        self::generateTranslation('remove_fav_photo_confirm', [
            'fr' => 'Êtes-vous sûr de vouloir supprimer cette photo de vos favoris ?'
        ]);
        self::generateTranslation('remove_fav_collection_confirm', [
            'fr' => 'Êtes-vous sûr de vouloir supprimer cette collection de vos favoris ?'
        ]);
        self::generateTranslation('fav_remove_msg', [
            'fr' => 'La %s a été retirée de vos favoris'
        ]);
        self::generateTranslation('unknown_favorite', [
            'fr' => '%s favorite introuvable'
        ]);
        self::generateTranslation('unknown_sender', [
            'fr' => 'Le destinataire n\'existe pas'
        ]);
        self::generateTranslation('user_ban_msg', [
            'fr' => 'User block list a été mise à jour'
        ]);
        self::generateTranslation('no_user_ban_msg', [
            'fr' => 'No user is banned FROM your account!'
        ]);
        self::generateTranslation('thnx_sharing_msg', [
            'fr' => 'Merci d\'avoir partagé cette %s'
        ]);
        self::generateTranslation('no_own_commen_rate', [
            'fr' => 'You cannot rate your own comment'
        ]);
        self::generateTranslation('no_comment_exists', [
            'fr' => 'Comment does not exist'
        ]);
        self::generateTranslation('thanks_rating_comment', [
            'fr' => 'Thanks for rating comment'
        ]);
        self::generateTranslation('please_login_create_playlist', [
            'fr' => 'Please login to creat playlists'
        ]);
        self::generateTranslation('user_have_no_playlists', [
            'fr' => 'User has no playlists'
        ]);
        self::generateTranslation('play_list_with_this_name_arlready_exists', [
            'fr' => 'La playlist \'%s\' existe déjà'
        ]);
        self::generateTranslation('please_enter_playlist_name', [
            'fr' => 'Veuillez entrer un nom pour la playlist'
        ]);
        self::generateTranslation('new_playlist_created', [
            'fr' => 'La playlist a été créée'
        ]);
        self::generateTranslation('playlist_not_exist', [
            'fr' => 'Cette playlist n\'existe pas'
        ]);
        self::generateTranslation('playlist_item_not_exist', [
            'fr' => 'L\'élément de la playlist n\'existe pas'
        ]);
        self::generateTranslation('playlist_item_delete', [
            'fr' => 'L\'élément a été retiré de la playlist'
        ]);
        self::generateTranslation('play_list_updated', [
            'fr' => 'Playlist a été mise à jour'
        ]);
        self::generateTranslation('you_dont_hv_permission_del_playlist', [
            'fr' => 'You do not have permission to delete the playlist'
        ]);
        self::generateTranslation('playlist_delete_msg', [
            'fr' => 'La playlist a été supprimée'
        ]);
        self::generateTranslation('playlist_name', [
            'fr' => 'Nom de la playlist'
        ]);
        self::generateTranslation('add_new_playlist', [
            'fr' => 'Créer la Playlist'
        ]);
        self::generateTranslation('this_already_exist_in_pl', [
            'fr' => 'This %s existe déjà dans votre playlist'
        ]);
        self::generateTranslation('edit_playlist', [
            'fr' => 'Editer la Playlist'
        ]);
        self::generateTranslation('remove_playlist_confirm', [
            'fr' => 'Êtes-vous sûr de vouloir supprimer cette playlist ?'
        ]);
        self::generateTranslation('users', [
            'fr' => 'Utilisateurs'
        ]);
        self::generateTranslation('no_own_commen_spam', [
            'fr' => 'Vous ne pouvez pas noter votre propre commentaire comme spam'
        ]);
        self::generateTranslation('arslan_hassan', [
            'fr' => 'Arslan Hassan'
        ]);
        self::generateTranslation('this_vdo_not_working', [
            'fr' => 'Cette vidéo ne fonctionne pas correctement'
        ]);
        self::generateTranslation('email_tpl_has_updated', [
            'fr' => 'Email Template a été mis à jour'
        ]);
        self::generateTranslation('page_updated', [
            'fr' => 'Page a été mise à jour'
        ]);
        self::generateTranslation('thnx_for_voting', [
            'fr' => 'Merci d\'avoir voté'
        ]);
        self::generateTranslation('level_updated', [
            'fr' => 'Level a été mis à jour'
        ]);
        self::generateTranslation('template_activated', [
            'fr' => 'Le thème a été activé'
        ]);
        self::generateTranslation('language_already_exists', [
            'fr' => 'Language existe déjà'
        ]);
        self::generateTranslation('lang_code_already_exist', [
            'fr' => 'Language code existe déjà'
        ]);
        self::generateTranslation('lang_updated', [
            'fr' => 'Language a été mis à jour'
        ]);
        self::generateTranslation('plugin_uninstalled', [
            'fr' => 'Le plugin a été désinstallé'
        ]);
        self::generateTranslation('perm_already_exist', [
            'fr' => 'Permission existe déjà'
        ]);
        self::generateTranslation('account_details', [
            'fr' => 'Détails du compte'
        ]);
        self::generateTranslation('please_select_img_file', [
            'fr' => 'Veuillez sélectionner une image'
        ]);
        self::generateTranslation('or', [
            'fr' => 'ou'
        ]);
        self::generateTranslation('pelase_enter_image_url', [
            'fr' => 'Veuillez saisir une URL d\'image'
        ]);
        self::generateTranslation('delete_this_img', [
            'fr' => 'Supprimer cette image'
        ]);
        self::generateTranslation('remember_me', [
            'fr' => 'Se souvenir de moi'
        ]);
        self::generateTranslation('notifications', [
            'fr' => 'Notifications'
        ]);
        self::generateTranslation('playlists', [
            'fr' => 'Playlists'
        ]);
        self::generateTranslation('manage_playlists', [
            'fr' => 'Gestion des Playlists'
        ]);
        self::generateTranslation('total_items', [
            'fr' => 'Total d\'éléments'
        ]);
        self::generateTranslation('view', [
            'fr' => 'Vue'
        ]);
        self::generateTranslation('you_dont_hv_fav_vids', [
            'fr' => 'Vous n\'avez aucune vidéo favorite'
        ]);
        self::generateTranslation('signup_success_usr_ok', [
            'fr' => '<h2 style="margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;">Dernière étape<\/h2>     \t<p style="margin: 0px 5px; line-height: 18px; font-size: 14px;">Un email de validation viens de vous être envoyé, il contient un lien permettant l\'activation définitive de votre compte.<\/p>'
        ]);
        self::generateTranslation('report_this_user', [
            'fr' => 'Signaler cet utilisateur'
        ]);
        self::generateTranslation('report_this', [
            'fr' => 'Signaler'
        ]);
        self::generateTranslation('share_this', [
            'fr' => 'Partager'
        ]);
        self::generateTranslation('add_to_playlist', [
            'fr' => 'Ajouter à la playlist'
        ]);
        self::generateTranslation('view_profile', [
            'fr' => 'Afficher le profile'
        ]);
        self::generateTranslation('subscribe', [
            'fr' => 'S\'abonner'
        ]);
        self::generateTranslation('more', [
            'fr' => 'Plus'
        ]);
        self::generateTranslation('link_this_video', [
            'fr' => 'Lien de la vidéo'
        ]);
        self::generateTranslation('name', [
            'fr' => 'Nom'
        ]);
        self::generateTranslation('spam', [
            'fr' => 'Spam'
        ]);
        self::generateTranslation('view_video', [
            'fr' => 'Voir la vidéo'
        ]);
        self::generateTranslation('info', [
            'fr' => 'Info'
        ]);
        self::generateTranslation('basic_info', [
            'fr' => 'Informations basiques'
        ]);
        self::generateTranslation('grp_url', [
            'fr' => 'Group URL'
        ]);
        self::generateTranslation('time_ago', [
            'fr' => 'Il y a %s %s'
        ]);
        self::generateTranslation('from_now', [
            'fr' => 'Depuis %s %s'
        ]);
        self::generateTranslation('comm_disabled_for_vid', [
            'fr' => 'Les commentaires sont désactivés pour cette vidéo'
        ]);
        self::generateTranslation('recent', [
            'fr' => 'Plus récent'
        ]);
        self::generateTranslation('viewed', [
            'fr' => 'Vue'
        ]);
        self::generateTranslation('top_rated', [
            'fr' => 'Mieux noté'
        ]);
        self::generateTranslation('commented', [
            'fr' => 'Commenté'
        ]);
        self::generateTranslation('searching_keyword_in_obj', [
            'fr' => 'Recherche de \'%s\' dans %s'
        ]);
        self::generateTranslation('no_results_found', [
            'fr' => 'Aucun résultat disponible'
        ]);
        self::generateTranslation('please_enter_val_bw_min_max', [
            'fr' => 'Le champ \'%s\' doit avoir une taille comprise entre \'%s\' et \'%s\''
        ]);
        self::generateTranslation('inapp_content', [
            'fr' => 'Contenu inapproprié'
        ]);
        self::generateTranslation('copyright_infring', [
            'fr' => 'Violation de copyright'
        ]);
        self::generateTranslation('sexual_content', [
            'fr' => 'Contneu à caractère sexuel'
        ]);
        self::generateTranslation('violence_replusive_content', [
            'fr' => 'Contenu violent'
        ]);
        self::generateTranslation('disturbing', [
            'fr' => 'Contenu troublant'
        ]);
        self::generateTranslation('other', [
            'fr' => 'Autre'
        ]);
        self::generateTranslation('failed', [
            'fr' => 'Echec'
        ]);
        self::generateTranslation('required_fields', [
            'fr' => 'Champs requis'
        ]);
        self::generateTranslation('upload_file', [
            'fr' => 'Téléverser un fichier'
        ]);
        self::generateTranslation('photo_featured', [
            'fr' => 'La photo a été ajoutée aux photos vedettes'
        ]);
        self::generateTranslation('photo_unfeatured', [
            'fr' => 'La photo a été retirée des photos vedettes'
        ]);
        self::generateTranslation('you_dont_have_photos', [
            'fr' => 'Vous n\'avez aucune photo'
        ]);
        self::generateTranslation('you_dont_have_fav_photos', [
            'fr' => 'Vous n\'avez aucune photo favorites'
        ]);
        self::generateTranslation('manage_favorite_photos', [
            'fr' => 'Gestion des Photos favorites'
        ]);
        self::generateTranslation('manage_photos', [
            'fr' => 'Gestion des photos'
        ]);
        self::generateTranslation('collection_not_exist', [
            'fr' => 'Cette collection n\'existe pas'
        ]);
        self::generateTranslation('manage_collections', [
            'fr' => 'Gestion des collections'
        ]);
        self::generateTranslation('manage_categories', [
            'fr' => 'Gestion des Categories'
        ]);
        self::generateTranslation('create_collection', [
            'fr' => 'Création d\'une collection'
        ]);
        self::generateTranslation('selected_items_removed', [
            'fr' => 'Les %s sélectionnées ont été retirées'
        ]);
        self::generateTranslation('collection', [
            'fr' => 'Collection'
        ]);
        self::generateTranslation('photo', [
            'fr' => 'Photo'
        ]);
        self::generateTranslation('video', [
            'fr' => 'vidéo'
        ]);
        self::generateTranslation('photos', [
            'fr' => 'Photos'
        ]);
        self::generateTranslation('photo_success_heading', [
            'fr' => 'La collection de photo a été mise à jour'
        ]);
        self::generateTranslation('share_embed', [
            'fr' => 'Partager \/ Intégrer'
        ]);
        self::generateTranslation('item_added_in_collection', [
            'fr' => 'La %s a été ajoutée à la collection'
        ]);
        self::generateTranslation('object_exists_collection', [
            'fr' => 'La %s fait déjà partie de la collection'
        ]);
        self::generateTranslation('collection_deleted', [
            'fr' => 'La collection a été supprimée'
        ]);
        self::generateTranslation('related_videos', [
            'fr' => 'Vidéos similaires'
        ]);
        self::generateTranslation('profile_basic_info', [
            'fr' => 'Informations basiques'
        ]);
        self::generateTranslation('unsubscribe', [
            'fr' => 'Se désabonner'
        ]);
        self::generateTranslation('you_have_already_voted_channel', [
            'fr' => 'Vous avez déjà voté pour cette chaîne'
        ]);
        self::generateTranslation('user_activity', [
            'fr' => 'Activités de l\'utilisateur'
        ]);
        self::generateTranslation('collect_type', [
            'fr' => 'Type de collection'
        ]);
        self::generateTranslation('add_to_my_collection', [
            'fr' => 'Ajouter à ma collection'
        ]);
        self::generateTranslation('you_cant_rate_own_video', [
            'fr' => 'Vous ne pouvez voter pour vos propres vidéos'
        ]);
        self::generateTranslation('you_cannot_rate_own_photo', [
            'fr' => 'Vous ne pouvez voter pour vos propres photos'
        ]);
        self::generateTranslation('user_has_uploaded_new_video', [
            'fr' => '%s a mis en ligne une nouvelle vidéo'
        ]);
        self::generateTranslation('view_photo', [
            'fr' => 'Voir la photo'
        ]);
        self::generateTranslation('user_has_created_new_collection', [
            'fr' => '%s a créé une nouvelle collection'
        ]);
        self::generateTranslation('view_collection', [
            'fr' => 'Voir la collection'
        ]);
        self::generateTranslation('comm_disabled_for_collection', [
            'fr' => 'Les commentaires sont désactivés pour cette collection'
        ]);
        self::generateTranslation('share_this_type', [
            'fr' => 'Partager cette %s'
        ]);
        self::generateTranslation('seperate_usernames_with_comma', [
            'fr' => 'Séparer les identifiants par des virgules'
        ]);
        self::generateTranslation('add_as_friend', [
            'fr' => 'Ajouter comme amis'
        ]);
        self::generateTranslation('no_item_was_selected_to_delete', [
            'fr' => 'Aucun élement n\'a été sélectionné pour le retrait'
        ]);
        self::generateTranslation('no_playlist_was_selected_to_delete', [
            'fr' => 'Veuillez sélectionner une playlist'
        ]);
        self::generateTranslation('featured_videos', [
            'fr' => 'Vidéos Vedettes'
        ]);
        self::generateTranslation('recent_videos', [
            'fr' => 'Vidéos Récentes'
        ]);
        self::generateTranslation('load_more', [
            'fr' => 'Charger plus'
        ]);
        self::generateTranslation('no_playlists', [
            'fr' => 'Aucune playlist disponible'
        ]);
        self::generateTranslation('download', [
            'fr' => 'Télécharger'
        ]);
        self::generateTranslation('add_to', [
            'fr' => 'Ajouter à'
        ]);
        self::generateTranslation('add_to_my_favorites', [
            'fr' => 'Ajouter aux favoris'
        ]);
        self::generateTranslation('please_select_playlist', [
            'fr' => 'Veuillez sélectionner une playlist ci-dessous'
        ]);
        self::generateTranslation('create_new_playlist', [
            'fr' => 'Créer une nouvelle playlist'
        ]);
        self::generateTranslation('select_playlist', [
            'fr' => 'Sélectionner une playlist'
        ]);
        self::generateTranslation('report_video', [
            'fr' => 'Signaler la vidéo'
        ]);
        self::generateTranslation('comment_as', [
            'fr' => 'Commenter en tant que'
        ]);
        self::generateTranslation('update_cover', [
            'fr' => 'Mettre à jour la couverture'
        ]);
        self::generateTranslation('unfriend', [
            'fr' => 'Retirer des amis'
        ]);
        self::generateTranslation('accept_request', [
            'fr' => 'Accepter la demande'
        ]);
        self::generateTranslation('online', [
            'fr' => 'En ligne'
        ]);
        self::generateTranslation('offline', [
            'fr' => 'Hors ligne'
        ]);
        self::generateTranslation('upload_video', [
            'fr' => 'Téléverser une vidéo'
        ]);
        self::generateTranslation('upload_photo', [
            'fr' => 'Téléverser une photo'
        ]);
        self::generateTranslation('admin_area', [
            'fr' => 'Administration'
        ]);
        self::generateTranslation('view_channels', [
            'fr' => 'Voir les chaînes'
        ]);
        self::generateTranslation('my_channel', [
            'fr' => 'Ma chaîne'
        ]);
        self::generateTranslation('manage_videos', [
            'fr' => 'Gestion des Vidéos'
        ]);
        self::generateTranslation('cancel_request', [
            'fr' => 'Annuler la demande'
        ]);
        self::generateTranslation('no_featured_videos_found', [
            'fr' => 'Aucune vidéo vedette disponible'
        ]);
        self::generateTranslation('no_recent_videos_found', [
            'fr' => 'Aucune vidéo récente disponible'
        ]);
        self::generateTranslation('create_new_collection_btn', [
            'fr' => 'Créer une nouvelle collection'
        ]);
        self::generateTranslation('no_videos_found', [
            'fr' => 'Aucune vidéo trouvée !'
        ]);
        self::generateTranslation('latest_videos', [
            'fr' => 'Dernières vidéos'
        ]);
        self::generateTranslation('since', [
            'fr' => 'Depuis'
        ]);
        self::generateTranslation('last_Login', [
            'fr' => 'Dernière connexion'
        ]);
        self::generateTranslation('no_friends_in_list', [
            'fr' => 'Vous n\'avez aucun amis ajouté'
        ]);
        self::generateTranslation('no_pending_friend', [
            'fr' => 'Aucune demande d\'amis en attente'
        ]);
        self::generateTranslation('back_to_collection', [
            'fr' => 'Retour aux collections'
        ]);
        self::generateTranslation('public', [
            'fr' => 'Public'
        ]);
        self::generateTranslation('private', [
            'fr' => 'Privée'
        ]);
        self::generateTranslation('drag_drop', [
            'fr' => 'Glissez & déposez vos fichiers ici'
        ]);
        self::generateTranslation('popular_videos', [
            'fr' => 'Vidéos populaires'
        ]);
        self::generateTranslation('no_photos_found', [
            'fr' => 'Aucune photo trouvée !'
        ]);
        self::generateTranslation('search_keyword_feed', [
            'fr' => 'Rechercher'
        ]);
        self::generateTranslation('contacts_manager', [
            'fr' => 'Gestion des contacts'
        ]);
        self::generateTranslation('weak_pass', [
            'fr' => 'La sécurité du mot de passe est faible'
        ]);
        self::generateTranslation('create_account_msg', [
            'fr' => 'Inscrivez-vous pour accéder aux vidéos et photos. L\'inscription est gratuite et ne prends que quelques minutes.'
        ]);
        self::generateTranslation('get_your_account', [
            'fr' => 'Créez un compte'
        ]);
        self::generateTranslation('type_password_here', [
            'fr' => 'Mot de passe'
        ]);
        self::generateTranslation('type_username_here', [
            'fr' => 'Identifiant'
        ]);
        self::generateTranslation('watch', [
            'fr' => 'Visionner'
        ]);
        self::generateTranslation('successful', [
            'fr' => 'Converti'
        ]);
        self::generateTranslation('processing', [
            'fr' => 'En conversion'
        ]);
        self::generateTranslation('creating_collection_is_disabled', [
            'fr' => 'La création de collection est désactivé'
        ]);
        self::generateTranslation('creating_playlist_is_disabled', [
            'fr' => 'La création de playlist est désactivé'
        ]);
        self::generateTranslation('inactive', [
            'fr' => 'Inactif'
        ]);
        self::generateTranslation('title_ph', [
            'fr' => 'Titre'
        ]);
        self::generateTranslation('no_playlist_found', [
            'fr' => 'Aucune playlist trouvée'
        ]);
        self::generateTranslation('playlist_privacy', [
            'fr' => 'Accessibilité'
        ]);
        self::generateTranslation('add_to_collection', [
            'fr' => 'Ajouter à la collection'
        ]);
        self::generateTranslation('video_added_to_playlist', [
            'fr' => 'Cette vidéo a été ajouté à la playlist'
        ]);
        self::generateTranslation('report_usr', [
            'fr' => 'Signaler'
        ]);
        self::generateTranslation('my_playlists', [
            'fr' => 'Mes Playlists'
        ]);
        self::generateTranslation('no_vid_in_playlist', [
            'fr' => 'Aucune vidéo trouvée dans cette playlist !'
        ]);
        self::generateTranslation('website_offline', [
            'fr' => 'ATTENTION: LE SITE EST EN MODE HORS LIGNE'
        ]);
        self::generateTranslation('loading', [
            'fr' => 'Chargement'
        ]);
        self::generateTranslation('hour', [
            'fr' => 'heure'
        ]);
        self::generateTranslation('hours', [
            'fr' => 'heures'
        ]);
        self::generateTranslation('day', [
            'fr' => 'jour'
        ]);
        self::generateTranslation('days', [
            'fr' => 'jours'
        ]);
        self::generateTranslation('week', [
            'fr' => 'semaine'
        ]);
        self::generateTranslation('weeks', [
            'fr' => 'semaines'
        ]);
        self::generateTranslation('month', [
            'fr' => 'mois'
        ]);
        self::generateTranslation('months', [
            'fr' => 'mois'
        ]);
        self::generateTranslation('year', [
            'fr' => 'an'
        ]);
        self::generateTranslation('years', [
            'fr' => 'ans'
        ]);
        self::generateTranslation('decade', [
            'fr' => 'décénnie'
        ]);
        self::generateTranslation('decades', [
            'fr' => 'décénnies'
        ]);
        self::generateTranslation('your_name', [
            'fr' => 'Votre nom'
        ]);
        self::generateTranslation('your_email', [
            'fr' => 'Votre Email'
        ]);
        self::generateTranslation('type_comment_box', [
            'fr' => 'Veuiller saisir quelque chose dans le champ commentaire'
        ]);
        self::generateTranslation('guest', [
            'fr' => 'Invité'
        ]);
        self::generateTranslation('anonymous', [
            'fr' => 'Anonyme'
        ]);
        self::generateTranslation('no_comment_added', [
            'fr' => 'Aucun commentaire ajouté'
        ]);
        self::generateTranslation('register_min_age_request', [
            'fr' => 'Vous devez avoir au moins %s ans pour vous enregistrer'
        ]);
        self::generateTranslation('select_category', [
            'fr' => 'Veuillez sélectionner votre catégorie'
        ]);
        self::generateTranslation('custom', [
            'fr' => 'personnalisé'
        ]);
        self::generateTranslation('no_playlist_exists', [
            'fr' => 'Vous ne disposez d\'aucune playlist'
        ]);
        self::generateTranslation('edit', [
            'fr' => 'Editer'
        ]);
        self::generateTranslation('create_new_account', [
            'fr' => 'Créer un compte'
        ]);
        self::generateTranslation('search_too_short', [
            'fr' => 'La recherche %s est trop courte!'
        ]);
        self::generateTranslation('playlist_allow_comments', [
            'fr' => 'Autoriser les commentaires'
        ]);
        self::generateTranslation('playlist_allow_rating', [
            'fr' => 'Autoriser la notation'
        ]);
        self::generateTranslation('playlists_have_been_removed', [
            'fr' => 'Les playlists ont été supprimées'
        ]);
        self::generateTranslation('confirm_collection_delete', [
            'fr' => 'Voulez-vous vraiment supprimer cette collection ?'
        ]);
        self::generateTranslation('please_select_collection', [
            'fr' => 'Veuillez sélectionner une collection ci-dessous'
        ]);
        self::generateTranslation('please_enter_collection_name', [
            'fr' => 'Veuillez entrer un nom pour la collection'
        ]);
        self::generateTranslation('select_collection', [
            'fr' => 'Sélectionner une collection'
        ]);
        self::generateTranslation('resolution', [
            'fr' => 'Résolution'
        ]);
        self::generateTranslation('filesize', [
            'fr' => 'Poids du fichier'
        ]);
        self::generateTranslation('no_items', [
            'fr' => 'Aucun élément'
        ]);
        self::generateTranslation('user_recover_user', [
            'fr' => 'Identifiant oublié'
        ]);
        self::generateTranslation('edited_by', [
            'fr' => 'édité par'
        ]);
        self::generateTranslation('reply_to', [
            'fr' => 'Répondre à'
        ]);
        self::generateTranslation('mail_type', [
            'fr' => 'Type d\'email'
        ]);
        self::generateTranslation('user', [
            'fr' => 'Utilisateur'
        ]);
        self::generateTranslation('mail_not_send', [
            'fr' => 'Email non envoyé à <strong>%s</strong>'
        ]);
        self::generateTranslation('mail_send', [
            'fr' => 'Email envoyé à <strong>%s</strong>'
        ]);
        self::generateTranslation('title', [
            'fr' => 'Titre'
        ]);
        self::generateTranslation('show_comments', [
            'fr' => 'Afficher les commentaires'
        ]);
        self::generateTranslation('hide_comments', [
            'fr' => 'Masquer les commentaires'
        ]);
        self::generateTranslation('users_categories', [
            'fr' => 'Catégories d\'utilisateurs'
        ]);
        self::generateTranslation('popular_users', [
            'fr' => 'Utilisateurs populaires'
        ]);
        self::generateTranslation('channel', [
            'fr' => 'Chaîne'
        ]);
        self::generateTranslation('confirm_del_photo', [
            'fr' => 'Êtes-vous sûr de vouloir supprimer cette photo ?'
        ]);
        self::generateTranslation('vdo_inactive', [
            'fr' => 'Vidéo désactivée'
        ]);
        self::generateTranslation('photo_tags_error', [
            'fr' => 'Veuillez spécifier des mots-clés pour la photo'
        ]);
        self::generateTranslation('signups', [
            'fr' => 'Inscriptions'
        ]);
        self::generateTranslation('active_users', [
            'fr' => 'Utilisateurs actifs'
        ]);
        self::generateTranslation('uploaded', [
            'fr' => 'Téléversés'
        ]);
        self::generateTranslation('user_name_invalid_len', [
            'fr' => 'La taille de l\'identifiant est incorrecte'
        ]);
        self::generateTranslation('username_spaces', [
            'fr' => 'L\'identifiant ne peut contenir d\'espaces'
        ]);
        self::generateTranslation('photo_caption_err', [
            'fr' => 'Veuillez entrer une description pour la photo'
        ]);
        self::generateTranslation('photo_tags_err', [
            'fr' => 'Veuillez entrer au moins un mot clé pour la photo'
        ]);
        self::generateTranslation('photo_collection_err', [
            'fr' => 'Veuillez spécifier une collection pour la photo'
        ]);
        self::generateTranslation('details', [
            'fr' => 'Détails'
        ]);
        self::generateTranslation('technical_error', [
            'fr' => 'Une erreur technique est survenue !'
        ]);
        self::generateTranslation('castable_status_fixed', [
            'fr' => 'Le statut de cast de %s a été corrigé'
        ]);
        self::generateTranslation('castable_status_failed', [
            'fr' => '%s ne peut être casté correctement car il dispose de %s canaux audio, veuillez re-convertir la vidéo avec l\'option de correction Chromecast activée'
        ]);
        self::generateTranslation('castable_status_check', [
            'fr' => 'Vérifier le statut de cast'
        ]);
        self::generateTranslation('videos_manager', [
            'fr' => 'Gestionnaire de Vidéos'
        ]);
        self::generateTranslation('update_bits_color', [
            'fr' => 'Mettre à jour les bits couleurs'
        ]);
        self::generateTranslation('bits_color', [
            'fr' => 'bits couleurs'
        ]);
        self::generateTranslation('bits_color_compatibility', [
            'fr' => 'Le format de la vidéo la rend incompatible avec certains navigateurs tels que Firefox, Safari, ...'
        ]);
        self::generateTranslation('player_logo_reset', [
            'fr' => 'Le logo du lecteur a été réinitialisé'
        ]);
        self::generateTranslation('player_settings_updated', [
            'fr' => 'Les paramètres du lecteur ont été mis à jours'
        ]);
        self::generateTranslation('player_settings', [
            'fr' => 'Paramètres du lecteur'
        ]);
        self::generateTranslation('quality', [
            'fr' => 'Qualité'
        ]);
        self::generateTranslation('error_occured', [
            'fr' => 'Oops... Quelque chose s\'est mal passé...'
        ]);
        self::generateTranslation('error_file_download', [
            'fr' => 'Impossible de récupérer le fichier'
        ]);
        self::generateTranslation('dashboard_update_status', [
            'fr' => 'Statut de mise à jour'
        ]);
        self::generateTranslation('dashboard_changelogs', [
            'fr' => 'Nouveautés'
        ]);
        self::generateTranslation('dashboard_php_config_allow_url_fopen', [
            'fr' => 'Veuillez activer \'allow_url_fopen\' pour pouvoir profiter du statut de mise à jour'
        ]);
        self::generateTranslation('signup_error_email_unauthorized', [
            'fr' => 'Email non autorisé'
        ]);
        self::generateTranslation('video_detail_saved', [
            'fr' => 'Les détails de la vidéo ont été sauvegardés'
        ]);
        self::generateTranslation('video_subtitles_deleted', [
            'fr' => 'Les sous-titres de la vidéo ont été supprimés'
        ]);
        self::generateTranslation('collection_no_parent', [
            'fr' => 'Aucun parent'
        ]);
        self::generateTranslation('collection_parent', [
            'fr' => 'Collection parent'
        ]);
        self::generateTranslation('comments_disabled_for_photo', [
            'fr' => 'Les commentaires sont désactivés pour cette photo'
        ]);
        self::generateTranslation('plugin_editors_picks', [
            'fr' => 'Choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_added', [
            'fr' => 'La vidéo a été ajoutée au choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_removed', [
            'fr' => 'La vidéo a été retirée du choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_removed_plural', [
            'fr' => 'Les vidéos sélectionnées ont été retirées du choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_add_error', [
            'fr' => 'Cette vidéo est déjà dans les choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_add_to', [
            'fr' => 'Ajouter au choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_from', [
            'fr' => 'Retirer du choix de l\'éditeur'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_confirm', [
            'fr' => 'Êtes-vous sûr de vouloir retirer les vidéos sélectionnées du choix de l\'éditeur ?'
        ]);
        self::generateTranslation('plugin_global_announcement', [
            'fr' => 'Annonce Globale'
        ]);
        self::generateTranslation('plugin_global_announcement_subtitle', [
            'fr' => 'Gestionnaire d\'annonce'
        ]);
        self::generateTranslation('plugin_global_announcement_edit', [
            'fr' => 'Editer l\'annonce'
        ]);
        self::generateTranslation('plugin_global_announcement_updated', [
            'fr' => 'L\'annonce a été mise à jour'
        ]);
        self::generateTranslation('page_upload_video_limits', [
            'fr' => 'Chaque vidéo ne peut excéder un poids de %s Mo, ni une durée de %s minutes, et doit se présenter dans un format vidéo commun'
        ]);
        self::generateTranslation('page_upload_video_select', [
            'fr' => 'Selectionner une vidéo'
        ]);
        self::generateTranslation('page_upload_photo_limits', [
            'fr' => 'Chaque photo ne peut excéder un poids de %s Mo et doit se présenter dans un format image commun'
        ]);
        self::generateTranslation('video_resolution_auto', [
            'fr' => 'Auto'
        ]);
        self::generateTranslation('video_thumbs_regenerated', [
            'fr' => 'Les vignettes de la vidéo ont été re-générées'
        ]);
        self::generateTranslation('video_allow_comment_vote', [
            'fr' => 'Autoriser les votes sur les commentaires'
        ]);
        self::generateTranslation('language', [
            'fr' => 'Langue'
        ]);
        self::generateTranslation('progression', [
            'fr' => 'Progression'
        ]);
        self::generateTranslation('confirm', [
            'fr' => 'Confirmer'
        ]);


        self::generateTranslation('ad_name_error', [
            'de' => 'Bitte geben Sie einen Namen für die Anzeige ein'
        ]);
        self::generateTranslation('ad_code_error', [
            'de' => 'Fehler : Bitte geben Sie einen Code für die Anzeige ein'
        ]);
        self::generateTranslation('ad_exists_error1', [
            'de' => 'Die Anzeige existiert nicht'
        ]);
        self::generateTranslation('ad_exists_error2', [
            'de' => 'Fehler : Anzeige mit diesem Namen existiert bereits'
        ]);
        self::generateTranslation('ad_add_msg', [
            'de' => 'Anzeige wurde erfolgreich hinzugefügt'
        ]);
        self::generateTranslation('ad_msg', [
            'de' => 'Anzeige wurde '
        ]);
        self::generateTranslation('ad_update_msg', [
            'de' => 'Anzeige wurde aktualisiert'
        ]);
        self::generateTranslation('ad_del_msg', [
            'de' => 'Anzeige wurde gelöscht'
        ]);
        self::generateTranslation('ad_deactive', [
            'de' => 'Deaktiviert'
        ]);
        self::generateTranslation('ad_active', [
            'de' => 'Aktiviert'
        ]);
        self::generateTranslation('ad_placment_delete_msg', [
            'de' => 'Platzierung wurde entfernt'
        ]);
        self::generateTranslation('ad_placement_err1', [
            'de' => 'Platzierung existiert bereits'
        ]);
        self::generateTranslation('ad_placement_err2', [
            'de' => 'Bitte geben Sie einen Namen für das Inserat ein'
        ]);
        self::generateTranslation('ad_placement_err3', [
            'de' => 'Bitte geben Sie einen Code für die Platzierung ein'
        ]);
        self::generateTranslation('ad_placement_msg', [
            'de' => 'Platzierung wurde hinzugefügt'
        ]);
        self::generateTranslation('cat_img_error', [
            'de' => 'Bitte laden Sie nur JPEG, GIF oder PNG Bilder hoch'
        ]);
        self::generateTranslation('cat_exist_error', [
            'de' => 'Kategorie existiert nicht'
        ]);
        self::generateTranslation('cat_add_msg', [
            'de' => 'Kategorie wurde erfolgreich hinzugefügt'
        ]);
        self::generateTranslation('cat_update_msg', [
            'de' => 'Kategorie wurde aktualisiert'
        ]);
        self::generateTranslation('grp_err', [
            'de' => 'Gruppe existiert nicht'
        ]);
        self::generateTranslation('grp_fr_msg', [
            'de' => 'Die Gruppe wurde auf „empfohlen“ gesetzt'
        ]);
        self::generateTranslation('grp_fr_msg1', [
            'de' => 'Ausgewählte Gruppen wurden aus der Empfohlen-Liste entfernt'
        ]);
        self::generateTranslation('grp_ac_msg', [
            'de' => 'Ausgewählte Gruppen wurden aktiviert'
        ]);
        self::generateTranslation('grp_dac_msg', [
            'de' => 'Ausgewählte Gruppen wurden deaktiviert'
        ]);
        self::generateTranslation('grp_del_msg', [
            'de' => 'Die Gruppe wurde gelöscht'
        ]);
        self::generateTranslation('editor_pic_up', [
            'de' => 'Video wurde nach oben verschoben'
        ]);
        self::generateTranslation('editor_pic_down', [
            'de' => 'Video wurde nach unten verschoben'
        ]);
        self::generateTranslation('plugin_install_msg', [
            'de' => 'Plugin wurde installiert'
        ]);
        self::generateTranslation('plugin_no_file_err', [
            'de' => 'Es wurde keine Datei gefunden'
        ]);
        self::generateTranslation('plugin_file_detail_err', [
            'de' => 'Unbekannte Plugin-Details gefunden'
        ]);
        self::generateTranslation('plugin_installed_err', [
            'de' => 'Plugin bereits installiert'
        ]);
        self::generateTranslation('plugin_no_install_err', [
            'de' => 'Plugin ist nicht installiert'
        ]);
        self::generateTranslation('grp_name_error', [
            'de' => 'Bitte Gruppennamen eingeben'
        ]);
        self::generateTranslation('grp_name_error1', [
            'de' => 'Gruppenname existiert bereits'
        ]);
        self::generateTranslation('grp_des_error', [
            'de' => 'Bitte geben Sie eine kleine Beschreibung für die Gruppe ein'
        ]);
        self::generateTranslation('grp_tags_error', [
            'de' => 'Bitte geben Sie Tags für die Gruppe ein'
        ]);
        self::generateTranslation('grp_url_error', [
            'de' => 'Bitte geben Sie eine gültige URL für die Gruppe ein'
        ]);
        self::generateTranslation('grp_url_error1', [
            'de' => 'Bitte gültigen URL-Namen eingeben'
        ]);
        self::generateTranslation('grp_url_error2', [
            'de' => 'Gruppen-URL existiert bereits, bitte wählen Sie eine andere URL'
        ]);
        self::generateTranslation('grp_tpc_error', [
            'de' => 'Bitte geben Sie ein Thema zum Hinzufügen ein'
        ]);
        self::generateTranslation('grp_comment_error', [
            'de' => 'Sie müssen einen Kommentar eingeben'
        ]);
        self::generateTranslation('grp_join_error', [
            'de' => 'Sie sind bereits Mitglied dieser Gruppe'
        ]);
        self::generateTranslation('grp_prvt_error', [
            'de' => 'Diese Gruppe ist privat, bitte melden Sie sich an, um diese Gruppe zu sehen'
        ]);
        self::generateTranslation('grp_inact_error', [
            'de' => 'Diese Gruppe ist inaktiv, bitte kontaktieren Sie den Administrator für das Problem'
        ]);
        self::generateTranslation('grp_join_error1', [
            'de' => 'Sie sind dieser Gruppe noch nicht beigetreten'
        ]);
        self::generateTranslation('grp_exist_error', [
            'de' => 'Tut mir leid, die Gruppe gibt es nicht'
        ]);
        self::generateTranslation('grp_tpc_error1', [
            'de' => 'Dieses Thema ist nicht vom Eigentümer der Gruppe genehmigt'
        ]);
        self::generateTranslation('grp_cat_error', [
            'de' => 'Bitte wählen Sie eine Kategorie für Ihre Gruppe'
        ]);
        self::generateTranslation('grp_tpc_error2', [
            'de' => 'Bitte geben Sie ein Thema zum Hinzufügen ein'
        ]);
        self::generateTranslation('grp_tpc_error3', [
            'de' => 'Ihr Thema erfordert die Zustimmung des Eigentümers dieser Gruppe'
        ]);
        self::generateTranslation('grp_tpc_msg', [
            'de' => 'Thema wurde hinzugefügt'
        ]);
        self::generateTranslation('grp_comment_msg', [
            'de' => 'Kommentar wurde hinzugefügt'
        ]);
        self::generateTranslation('grp_vdo_msg', [
            'de' => 'Gelöschte Videos'
        ]);
        self::generateTranslation('grp_vdo_msg1', [
            'de' => 'Erfolgreich hinzugefügte Videos'
        ]);
        self::generateTranslation('grp_vdo_msg2', [
            'de' => 'Videos wurden genehmigt'
        ]);
        self::generateTranslation('grp_mem_msg', [
            'de' => 'Mitglied wurde gelöscht'
        ]);
        self::generateTranslation('grp_mem_msg1', [
            'de' => 'Mitglied wurde genehmigt'
        ]);
        self::generateTranslation('grp_inv_msg', [
            'de' => 'Ihre Einladung wurde verschickt'
        ]);
        self::generateTranslation('grp_tpc_msg1', [
            'de' => 'Thema wurde gelöscht'
        ]);
        self::generateTranslation('grp_tpc_msg2', [
            'de' => 'Thema wurde genehmigt'
        ]);
        self::generateTranslation('grp_fr_msg2', [
            'de' => 'Gruppe wurde aus der Liste der empfohlenen Gruppen entfernt'
        ]);
        self::generateTranslation('grp_inv_msg1', [
            'de' => 'Hat Sie zum Beitritt eingeladen '
        ]);
        self::generateTranslation('grp_av_msg', [
            'de' => 'Gruppe wurde aktiviert'
        ]);
        self::generateTranslation('grp_da_msg', [
            'de' => 'Gruppe wurde deaktiviert'
        ]);
        self::generateTranslation('grp_post_msg', [
            'de' => 'Beitrag wurde gelöscht'
        ]);
        self::generateTranslation('grp_update_msg', [
            'de' => 'Gruppe wurde aktualisiert'
        ]);
        self::generateTranslation('grp_owner_err', [
            'de' => 'Nur der Besitzer kann Videos zu dieser Gruppe hinzufügen'
        ]);
        self::generateTranslation('grp_owner_err1', [
            'de' => 'Sie sind nicht der Eigentümer dieser Gruppe'
        ]);
        self::generateTranslation('grp_owner_err2', [
            'de' => 'Sie sind der Eigentümer dieser Gruppe. Sie können Ihre Gruppe nicht verlassen.'
        ]);
        self::generateTranslation('grp_prvt_err1', [
            'de' => 'Diese Gruppe ist privat, Sie benötigen eine Einladung des Eigentümers, um ihr beizutreten.'
        ]);
        self::generateTranslation('grp_rmv_msg', [
            'de' => 'Ausgewählte Gruppen wurden aus Ihrem Konto entfernt'
        ]);
        self::generateTranslation('grp_tpc_err4', [
            'de' => 'Entschuldigung, das Thema existiert nicht'
        ]);
        self::generateTranslation('grp_title_topic', [
            'de' => 'Gruppen - Thema - '
        ]);
        self::generateTranslation('grp_add_title', [
            'de' => '- Video hinzufügen'
        ]);
        self::generateTranslation('usr_sadmin_err', [
            'de' => 'Sie dürfen den Benutzernamen des Administrators nicht leer lassen'
        ]);
        self::generateTranslation('usr_cpass_err', [
            'de' => 'Bestätigungskennwort stimmt nicht überein'
        ]);
        self::generateTranslation('usr_pass_err', [
            'de' => 'Altes Passwort ist falsch'
        ]);
        self::generateTranslation('usr_email_err', [
            'de' => 'Bitte geben Sie eine gültige E-Mail-Adresse an'
        ]);
        self::generateTranslation('usr_cpass_err1', [
            'de' => 'Bestätigung des Passworts ist falsch'
        ]);
        self::generateTranslation('usr_pass_err1', [
            'de' => 'Passwort ist falsch'
        ]);
        self::generateTranslation('usr_cmt_err', [
            'de' => 'Sie müssen sich zuerst anmelden, um zu kommentieren'
        ]);
        self::generateTranslation('usr_cmt_err1', [
            'de' => 'Bitte geben Sie etwas in das Kommentarfeld ein'
        ]);
        self::generateTranslation('usr_cmt_err2', [
            'de' => 'Sie können Ihr Video nicht kommentieren'
        ]);
        self::generateTranslation('usr_cmt_err3', [
            'de' => 'Sie haben bereits einen Kommentar zu diesem Kanal abgegeben.'
        ]);
        self::generateTranslation('usr_cmt_err4', [
            'de' => 'Kommentar wurde hinzugefügt'
        ]);
        self::generateTranslation('usr_cmt_del_msg', [
            'de' => 'Kommentar wurde gelöscht'
        ]);
        self::generateTranslation('usr_cmt_del_err', [
            'de' => 'Beim Löschen eines Kommentars ist ein Fehler aufgetreten'
        ]);
        self::generateTranslation('usr_cnt_err', [
            'de' => 'Sie können sich selbst nicht als Kontakt hinzufügen'
        ]);
        self::generateTranslation('usr_cnt_err1', [
            'de' => 'Sie haben diesen Benutzer bereits zu Ihrer Kontaktliste hinzugefügt'
        ]);
        self::generateTranslation('usr_sub_err', [
            'de' => 'Sie sind bereits bei %s angemeldet'
        ]);
        self::generateTranslation('usr_exist_err', [
            'de' => 'Der Benutzer existiert nicht'
        ]);
        self::generateTranslation('usr_ccode_err', [
            'de' => 'Der von Ihnen eingegebene Verifizierungscode war falsch'
        ]);
        self::generateTranslation('usr_exist_err1', [
            'de' => 'Tut mir leid, es existiert kein Benutzer mit dieser E-Mail-Adresse'
        ]);
        self::generateTranslation('usr_exist_err2', [
            'de' => 'Entschuldigung, Benutzer existiert nicht'
        ]);
        self::generateTranslation('usr_uname_err', [
            'de' => 'Benutzername ist leer'
        ]);
        self::generateTranslation('usr_uname_err2', [
            'de' => 'Benutzername existiert bereits'
        ]);
        self::generateTranslation('usr_pass_err2', [
            'de' => 'Passwort ist leer'
        ]);
        self::generateTranslation('usr_email_err1', [
            'de' => 'E-Mail-Adresse ist leer'
        ]);
        self::generateTranslation('usr_email_err2', [
            'de' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein'
        ]);
        self::generateTranslation('usr_email_err3', [
            'de' => 'E-Mail-Adresse ist bereits in Gebrauch'
        ]);
        self::generateTranslation('usr_pcode_err', [
            'de' => 'Postleitzahlen enthalten nur Ziffern'
        ]);
        self::generateTranslation('usr_fname_err', [
            'de' => 'Vorname ist leer'
        ]);
        self::generateTranslation('usr_lname_err', [
            'de' => 'Nachname ist leer'
        ]);
        self::generateTranslation('usr_uname_err3', [
            'de' => 'Benutzername enthält unzulässige Zeichen'
        ]);
        self::generateTranslation('usr_pass_err3', [
            'de' => 'Passwörter stimmen nicht überein'
        ]);
        self::generateTranslation('usr_dob_err', [
            'de' => 'Bitte wählen Sie Ihr Geburtsdatum'
        ]);
        self::generateTranslation('usr_ament_err', [
            'de' => 'Entschuldigung, Sie müssen den Nutzungsbedingungen und der Datenschutzerklärung zustimmen, um ein Konto zu erstellen'
        ]);
        self::generateTranslation('usr_reg_err', [
            'de' => 'Entschuldigung, Registrierungen sind vorübergehend nicht erlaubt, bitte versuchen Sie es später noch einmal'
        ]);
        self::generateTranslation('usr_ban_err', [
            'de' => 'Benutzerkonto ist gesperrt, bitte kontaktieren Sie den Administrator der Website'
        ]);
        self::generateTranslation('usr_login_err', [
            'de' => 'Benutzername und Passwort stimmten nicht überein'
        ]);
        self::generateTranslation('usr_sadmin_msg', [
            'de' => 'Administrator wurde aktualisiert'
        ]);
        self::generateTranslation('usr_pass_msg', [
            'de' => 'Ihr Passwort wurde geändert'
        ]);
        self::generateTranslation('usr_cnt_msg', [
            'de' => 'Dieser Benutzer wurde zu Ihrer Kontaktliste hinzugefügt'
        ]);
        self::generateTranslation('usr_sub_msg', [
            'de' => 'Sie sind jetzt Abonnent von %s'
        ]);
        self::generateTranslation('usr_uname_email_msg', [
            'de' => 'Wir haben Ihnen eine E-Mail mit Ihrem Benutzernamen geschickt, bitte überprüfen Sie diese'
        ]);
        self::generateTranslation('usr_rpass_email_msg', [
            'de' => 'Eine E-Mail wurde an Sie gesendet. Bitte folgen Sie den darin enthaltenen Anweisungen, um Ihr Passwort zurückzusetzen'
        ]);
        self::generateTranslation('usr_pass_email_msg', [
            'de' => 'Das Passwort wurde erfolgreich geändert'
        ]);
        self::generateTranslation('usr_email_msg', [
            'de' => 'E-Mail-Einstellungen wurden aktualisiert'
        ]);
        self::generateTranslation('usr_del_msg', [
            'de' => 'Benutzer wurde gelöscht'
        ]);
        self::generateTranslation('usr_dels_msg', [
            'de' => 'Ausgewählte Benutzer wurden gelöscht'
        ]);
        self::generateTranslation('usr_ac_msg', [
            'de' => 'Benutzer wurde aktiviert'
        ]);
        self::generateTranslation('usr_dac_msg', [
            'de' => 'Benutzer wurde deaktiviert'
        ]);
        self::generateTranslation('usr_mem_ac', [
            'de' => 'Ausgewählte Mitglieder wurden aktiviert'
        ]);
        self::generateTranslation('usr_mems_ac', [
            'de' => 'Ausgewählte Mitglieder wurden deaktiviert'
        ]);
        self::generateTranslation('usr_fr_msg', [
            'de' => 'Benutzer wurde zu einem empfohlenen Mitglied gemacht'
        ]);
        self::generateTranslation('usr_ufr_msg', [
            'de' => 'Benutzer wurde nicht empfohlen'
        ]);
        self::generateTranslation('usr_frs_msg', [
            'de' => 'Ausgewählte Benutzer wurden auf „empfohlen“ gesetzt'
        ]);
        self::generateTranslation('usr_ufrs_msg', [
            'de' => 'Ausgewählte Benutzer wurden aus der Empfohlen-Liste entfernt'
        ]);
        self::generateTranslation('usr_uban_msg', [
            'de' => 'Benutzer wurde gebannt'
        ]);
        self::generateTranslation('usr_uuban_msg', [
            'de' => 'Benutzer wurde entbannt'
        ]);
        self::generateTranslation('usr_ubans_msg', [
            'de' => 'Ausgewählte Mitglieder wurden verbannt'
        ]);
        self::generateTranslation('usr_uubans_msg', [
            'de' => 'Ausgewählte Mitglieder wurden freigelassen'
        ]);
        self::generateTranslation('usr_pass_reset_conf', [
            'de' => 'Passwort-Reset-Bestätigung'
        ]);
        self::generateTranslation('usr_dear_user', [
            'de' => 'Lieber Benutzer'
        ]);
        self::generateTranslation('usr_pass_reset_msg', [
            'de' => 'Sie haben ein neues Passwort angefordert. Folgen Sie dem Link, um Ihr Passwort zurückzusetzen.'
        ]);
        self::generateTranslation('usr_rpass_msg', [
            'de' => 'Das Passwort wurde zurückgesetzt'
        ]);
        self::generateTranslation('usr_rpass_req_msg', [
            'de' => 'Sie haben ein neues Passwort angefordert, hier ist Ihr neues Passwort: '
        ]);
        self::generateTranslation('usr_uname_req_msg', [
            'de' => 'Sie haben die Wiederherstellung Ihres Benutzernamens angefordert, hier ist Ihr Benutzername: '
        ]);
        self::generateTranslation('usr_uname_recovery', [
            'de' => 'E-Mail zur Wiederherstellung des Benutzernamens'
        ]);
        self::generateTranslation('usr_add_succ_msg', [
            'de' => 'Benutzer wurde hinzugefügt'
        ]);
        self::generateTranslation('usr_upd_succ_msg', [
            'de' => 'Benutzer wurde aktualisiert'
        ]);
        self::generateTranslation('usr_activation_msg', [
            'de' => 'Ihr Konto wurde aktiviert. Jetzt können Sie sich bei Ihrem Konto anmelden und Videos hochladen'
        ]);
        self::generateTranslation('usr_activation_err', [
            'de' => 'Dieser Benutzer ist bereits aktiviert'
        ]);
        self::generateTranslation('usr_activation_em_msg', [
            'de' => 'Wir haben Ihnen eine E-Mail mit Ihrem Aktivierungscode geschickt, bitte überprüfen Sie Ihr Postfach'
        ]);
        self::generateTranslation('usr_activation_em_err', [
            'de' => 'E-Mail existiert nicht oder ein Benutzer mit dieser E-Mail ist bereits aktiviert'
        ]);
        self::generateTranslation('usr_no_msg_del_err', [
            'de' => 'Es wurde keine Nachricht zum Löschen ausgewählt'
        ]);
        self::generateTranslation('usr_sel_msg_del_msg', [
            'de' => 'Ausgewählte Nachrichten wurden gelöscht'
        ]);
        self::generateTranslation('usr_pof_upd_msg', [
            'de' => 'Profil wurde aktualisiert'
        ]);
        self::generateTranslation('usr_arr_no_ans', [
            'de' => 'keine Antwort'
        ]);
        self::generateTranslation('usr_arr_elementary', [
            'de' => 'Grundschule'
        ]);
        self::generateTranslation('usr_arr_hi_school', [
            'de' => 'Hohe Schule'
        ]);
        self::generateTranslation('usr_arr_some_colg', [
            'de' => 'Einiges College'
        ]);
        self::generateTranslation('usr_arr_assoc_deg', [
            'de' => 'Associates-Abschluss'
        ]);
        self::generateTranslation('usr_arr_bach_deg', [
            'de' => 'Bachelor-Abschluss'
        ]);
        self::generateTranslation('usr_arr_mast_deg', [
            'de' => 'Master-Abschluss'
        ]);
        self::generateTranslation('usr_arr_phd', [
            'de' => 'Ph.D.'
        ]);
        self::generateTranslation('usr_arr_post_doc', [
            'de' => 'Postdoktorat'
        ]);
        self::generateTranslation('usr_arr_single', [
            'de' => 'Alleinstehend'
        ]);
        self::generateTranslation('usr_arr_married', [
            'de' => 'Verheiratet'
        ]);
        self::generateTranslation('usr_arr_comitted', [
            'de' => 'Verlobt'
        ]);
        self::generateTranslation('usr_arr_open_marriage', [
            'de' => 'Offene Ehe'
        ]);
        self::generateTranslation('usr_arr_open_relate', [
            'de' => 'Offene Beziehung'
        ]);
        self::generateTranslation('title_crt_new_msg', [
            'de' => 'Neue Nachricht verfassen'
        ]);
        self::generateTranslation('title_forgot', [
            'de' => 'Etwas vergessen? Finden Sie es jetzt!'
        ]);
        self::generateTranslation('title_inbox', [
            'de' => ' - Posteingang'
        ]);
        self::generateTranslation('title_sent', [
            'de' => ' - Gesendet-Ordner'
        ]);
        self::generateTranslation('title_usr_contact', [
            'de' => '\'s Kontaktliste'
        ]);
        self::generateTranslation('title_usr_fav_vids', [
            'de' => '%s\'s Lieblingsvideos'
        ]);
        self::generateTranslation('title_edit_video', [
            'de' => 'Video bearbeiten - '
        ]);
        self::generateTranslation('vdo_title_err', [
            'de' => 'Bitte Videotitel eingeben'
        ]);
        self::generateTranslation('vdo_des_err', [
            'de' => 'Bitte geben Sie eine Videobeschreibung ein'
        ]);
        self::generateTranslation('vdo_tags_err', [
            'de' => 'Bitte geben Sie Tags für das Video ein'
        ]);
        self::generateTranslation('vdo_cat_err', [
            'de' => 'Bitte wählen Sie mindestens 1 Kategorie'
        ]);
        self::generateTranslation('vdo_cat_err1', [
            'de' => 'Sie können nur bis zu 3 Kategorien auswählen'
        ]);
        self::generateTranslation('vdo_sub_email_msg', [
            'de' => ' und deshalb wird diese Nachricht automatisch an Sie gesendet, dass '
        ]);
        self::generateTranslation('vdo_has_upload_nv', [
            'de' => 'Neues Video hochgeladen hat'
        ]);
        self::generateTranslation('vdo_del_selected', [
            'de' => 'Ausgewählte Videos wurden gelöscht'
        ]);
        self::generateTranslation('vdo_cheat_msg', [
            'de' => 'Bitte versuchen Sie nicht zu schummeln'
        ]);
        self::generateTranslation('vdo_limits_warn_msg', [
            'de' => 'Bitte versuchen Sie nicht, Ihre Grenzen zu überschreiten'
        ]);
        self::generateTranslation('vdo_cmt_del_msg', [
            'de' => 'Kommentar wurde gelöscht'
        ]);
        self::generateTranslation('vdo_iac_msg', [
            'de' => 'Video ist inaktiv - bitte kontaktieren Sie den Administrator für weitere Details'
        ]);
        self::generateTranslation('vdo_is_in_process', [
            'de' => 'Video wird bearbeitet - bitte kontaktieren Sie den Administrator für weitere Details'
        ]);
        self::generateTranslation('vdo_upload_allow_err', [
            'de' => 'Hochladen ist vom Website-Besitzer nicht erlaubt'
        ]);
        self::generateTranslation('vdo_download_allow_err', [
            'de' => 'Herunterladen von Videos ist nicht erlaubt'
        ]);
        self::generateTranslation('vdo_edit_owner_err', [
            'de' => 'Sie sind nicht der Eigentümer des Videos'
        ]);
        self::generateTranslation('vdo_embed_code_wrong', [
            'de' => 'Einbettungscode war falsch'
        ]);
        self::generateTranslation('vdo_seconds_err', [
            'de' => 'Falscher Wert für das Feld Sekunden eingegeben'
        ]);
        self::generateTranslation('vdo_mins_err', [
            'de' => 'Falscher Wert für das Feld Minuten eingegeben'
        ]);
        self::generateTranslation('vdo_thumb_up_err', [
            'de' => 'Fehler beim Hochladen des Thumb'
        ]);
        self::generateTranslation('class_error_occured', [
            'de' => 'Entschuldigung, ein Fehler ist aufgetreten'
        ]);
        self::generateTranslation('class_cat_del_msg', [
            'de' => 'Kategorie wurde gelöscht'
        ]);
        self::generateTranslation('class_vdo_del_msg', [
            'de' => 'Video wurde gelöscht'
        ]);
        self::generateTranslation('class_vdo_fr_msg', [
            'de' => 'Video wurde als «Empfohlenes Video» markiert;'
        ]);
        self::generateTranslation('class_fr_msg1', [
            'de' => 'Video wurde aus «Empfohlene Videos» entfernt;'
        ]);
        self::generateTranslation('class_vdo_act_msg', [
            'de' => 'Video wurde aktiviert'
        ]);
        self::generateTranslation('class_vdo_act_msg1', [
            'de' => 'Video wurde deaktiviert'
        ]);
        self::generateTranslation('class_vdo_update_msg', [
            'de' => 'Videodetails wurden aktualisiert'
        ]);
        self::generateTranslation('class_comment_err', [
            'de' => 'Sie müssen sich einloggen, bevor Sie Kommentare abgeben können'
        ]);
        self::generateTranslation('class_comment_err1', [
            'de' => 'Bitte geben Sie etwas in das Kommentarfeld ein'
        ]);
        self::generateTranslation('class_comment_err2', [
            'de' => 'Sie können keinen Kommentar zu Ihrem eigenen Video abgeben'
        ]);
        self::generateTranslation('class_comment_err3', [
            'de' => 'Sie haben bereits einen Kommentar abgegeben, bitte warten Sie auf die anderen.'
        ]);
        self::generateTranslation('class_comment_err4', [
            'de' => 'Sie haben bereits auf diesen Kommentar geantwortet, bitte warten Sie auf die anderen.'
        ]);
        self::generateTranslation('class_comment_err5', [
            'de' => 'Sie können keine Antwort an sich selbst posten'
        ]);
        self::generateTranslation('class_comment_msg', [
            'de' => 'Kommentar wurde hinzugefügt'
        ]);
        self::generateTranslation('class_comment_err6', [
            'de' => 'Bitte loggen Sie sich ein, um den Kommentar zu bewerten'
        ]);
        self::generateTranslation('class_comment_err7', [
            'de' => 'Du hast diesen Kommentar bereits bewertet'
        ]);
        self::generateTranslation('class_vdo_fav_err', [
            'de' => 'Dieses Video wurde bereits zu Ihren Favoriten hinzugefügt'
        ]);
        self::generateTranslation('class_vdo_fav_msg', [
            'de' => 'Dieses Video wurde zu Ihren Favoriten hinzugefügt'
        ]);
        self::generateTranslation('class_vdo_flag_err', [
            'de' => 'Sie haben dieses Video bereits markiert'
        ]);
        self::generateTranslation('class_vdo_flag_msg', [
            'de' => 'Dieses Video wurde als unangemessen gekennzeichnet'
        ]);
        self::generateTranslation('class_vdo_flag_rm', [
            'de' => 'Markierung(en) wurde(n) entfernt'
        ]);
        self::generateTranslation('class_send_msg_err', [
            'de' => 'Bitte geben Sie einen Benutzernamen ein oder wählen Sie einen beliebigen Benutzer, um eine Nachricht zu senden'
        ]);
        self::generateTranslation('class_invalid_user', [
            'de' => 'Ungültiger Benutzername'
        ]);
        self::generateTranslation('class_subj_err', [
            'de' => 'Betreff der Nachricht war leer'
        ]);
        self::generateTranslation('class_msg_err', [
            'de' => 'Bitte geben Sie etwas in das Nachrichtenfeld ein'
        ]);
        self::generateTranslation('class_sent_you_msg', [
            'de' => 'Ich habe Ihnen eine Nachricht geschickt'
        ]);
        self::generateTranslation('class_sent_prvt_msg', [
            'de' => 'Ich habe Ihnen eine private Nachricht geschickt auf '
        ]);
        self::generateTranslation('class_click_inbox', [
            'de' => 'Bitte klicken Sie hier, um Ihren Posteingang zu sehen'
        ]);
        self::generateTranslation('class_click_login', [
            'de' => 'Klicken Sie hier zum Einloggen'
        ]);
        self::generateTranslation('class_email_notify', [
            'de' => 'E-Mail-Benachrichtigung'
        ]);
        self::generateTranslation('class_msg_has_sent_to', [
            'de' => 'Nachricht wurde gesendet an '
        ]);
        self::generateTranslation('class_inbox_del_msg', [
            'de' => 'Nachricht wurde aus dem Posteingang gelöscht '
        ]);
        self::generateTranslation('class_sent_del_msg', [
            'de' => 'Nachricht wurde aus dem Gesendet-Ordner gelöscht'
        ]);
        self::generateTranslation('class_msg_exist_err', [
            'de' => 'Nachricht existiert nicht'
        ]);
        self::generateTranslation('class_vdo_del_err', [
            'de' => 'Video existiert nicht'
        ]);
        self::generateTranslation('class_unsub_msg', [
            'de' => 'Sie wurden erfolgreich abgemeldet'
        ]);
        self::generateTranslation('class_sub_exist_err', [
            'de' => 'Abonnement existiert nicht'
        ]);
        self::generateTranslation('class_vdo_rm_fav_msg', [
            'de' => 'Das Video wurde aus den Favoriten entfernt'
        ]);
        self::generateTranslation('class_vdo_fav_err1', [
            'de' => 'Dieses Video befindet sich nicht in Ihrer Favoritenliste'
        ]);
        self::generateTranslation('class_cont_del_msg', [
            'de' => 'Kontakt wurde gelöscht'
        ]);
        self::generateTranslation('class_cot_err', [
            'de' => 'Sorry, dieser Kontakt ist nicht in Ihrer Kontaktliste'
        ]);
        self::generateTranslation('class_vdo_ep_err1', [
            'de' => 'Sie haben bereits 10 Videos ausgewählt Bitte löschen Sie mindestens ein Video, um weitere hinzuzufügen'
        ]);
        self::generateTranslation('class_vdo_exist_err', [
            'de' => 'Entschuldigung, Video existiert nicht'
        ]);
        self::generateTranslation('class_img_gif_err', [
            'de' => 'Bitte nur Gif-Bilder hochladen'
        ]);
        self::generateTranslation('class_img_png_err', [
            'de' => 'Bitte nur Png-Bilder hochladen'
        ]);
        self::generateTranslation('class_img_jpg_err', [
            'de' => 'Bitte nur Jpg-Bilder hochladen'
        ]);
        self::generateTranslation('class_logo_msg', [
            'de' => 'Das Logo wurde geändert. Bitte löschen Sie den Cache, wenn Sie das geänderte Logo nicht sehen können.'
        ]);
        self::generateTranslation('com_forgot_username', [
            'de' => 'Benutzername | Passwort vergessen'
        ]);
        self::generateTranslation('com_join_now', [
            'de' => 'Jetzt anmelden'
        ]);
        self::generateTranslation('com_my_account', [
            'de' => 'Mein Konto'
        ]);
        self::generateTranslation('com_manage_vids', [
            'de' => 'Videos verwalten'
        ]);
        self::generateTranslation('com_view_channel', [
            'de' => 'Meinen Kanal ansehen'
        ]);
        self::generateTranslation('com_my_inbox', [
            'de' => 'Mein Posteingang'
        ]);
        self::generateTranslation('com_welcome', [
            'de' => 'Willkommen'
        ]);
        self::generateTranslation('com_top_mem', [
            'de' => 'Top-Mitglieder '
        ]);
        self::generateTranslation('com_vidz', [
            'de' => 'Videos'
        ]);
        self::generateTranslation('com_sign_up_now', [
            'de' => 'Jetzt anmelden!'
        ]);
        self::generateTranslation('com_my_videos', [
            'de' => 'Meine Videos'
        ]);
        self::generateTranslation('com_my_channel', [
            'de' => 'Mein Kanal'
        ]);
        self::generateTranslation('com_my_subs', [
            'de' => 'Meine Abonnements'
        ]);
        self::generateTranslation('com_user_no_contacts', [
            'de' => 'Benutzer hat keinen Kontakt'
        ]);
        self::generateTranslation('com_user_no_vides', [
            'de' => 'Benutzer hat kein Lieblingsvideo'
        ]);
        self::generateTranslation('com_user_no_vid_com', [
            'de' => 'Benutzer hat keine Videokommentare'
        ]);
        self::generateTranslation('com_view_all_contacts', [
            'de' => 'Alle Kontakte von anzeigen'
        ]);
        self::generateTranslation('com_view_fav_all_videos', [
            'de' => 'Alle Lieblingsvideos von anzeigen'
        ]);
        self::generateTranslation('com_login_success_msg', [
            'de' => 'Sie wurden erfolgreich eingeloggt.'
        ]);
        self::generateTranslation('com_logout_success_msg', [
            'de' => 'Du wurdest erfolgreich abgemeldet.'
        ]);
        self::generateTranslation('com_not_redirecting', [
            'de' => 'Sie werden jetzt umgeleitet.'
        ]);
        self::generateTranslation('com_not_redirecting_msg', [
            'de' => 'wenn Sie nicht weitergeleitet werden'
        ]);
        self::generateTranslation('com_manage_contacts', [
            'de' => 'Kontakte verwalten '
        ]);
        self::generateTranslation('com_send_message', [
            'de' => 'Nachricht senden'
        ]);
        self::generateTranslation('com_manage_fav', [
            'de' => 'Favoriten verwalten '
        ]);
        self::generateTranslation('com_manage_subs', [
            'de' => 'Abonnements verwalten'
        ]);
        self::generateTranslation('com_subscribe_to', [
            'de' => 'Kanal von %s abonnieren'
        ]);
        self::generateTranslation('com_total_subs', [
            'de' => 'Abonnements insgesamt'
        ]);
        self::generateTranslation('com_total_vids', [
            'de' => 'Videos insgesamt'
        ]);
        self::generateTranslation('com_date_subscribed', [
            'de' => 'Datum abonniert'
        ]);
        self::generateTranslation('com_search_results', [
            'de' => 'Suchergebnisse'
        ]);
        self::generateTranslation('com_advance_results', [
            'de' => 'Erweiterte Suche'
        ]);
        self::generateTranslation('com_search_results_in', [
            'de' => 'Suchergebnisse in'
        ]);
        self::generateTranslation('videos_being_watched', [
            'de' => 'Kürzlich gesehen...'
        ]);
        self::generateTranslation('latest_added_videos', [
            'de' => 'Neueste Ergänzungen'
        ]);
        self::generateTranslation('most_viewed', [
            'de' => 'Meist gesehen'
        ]);
        self::generateTranslation('recently_added', [
            'de' => 'Kürzlich hinzugefügt'
        ]);
        self::generateTranslation('featured', [
            'de' => 'Empfohlen'
        ]);
        self::generateTranslation('highest_rated', [
            'de' => 'Höchste Bewertung'
        ]);
        self::generateTranslation('most_discussed', [
            'de' => 'Meistdiskutiert'
        ]);
        self::generateTranslation('style_change', [
            'de' => 'Stil ändern'
        ]);
        self::generateTranslation('rss_feed_latest_title', [
            'de' => 'RSS-Feed für die neuesten Videos'
        ]);
        self::generateTranslation('rss_feed_featured_title', [
            'de' => 'RSS-Feed für Empfohlene Videos'
        ]);
        self::generateTranslation('rss_feed_most_viewed_title', [
            'de' => 'RSS-Feed für die beliebtesten Videos'
        ]);
        self::generateTranslation('lang_folder', [
            'de' => 'de'
        ]);
        self::generateTranslation('reg_closed', [
            'de' => 'Registrierung geschlossen'
        ]);
        self::generateTranslation('reg_for', [
            'de' => 'Die Anmeldung für'
        ]);
        self::generateTranslation('is_currently_closed', [
            'de' => 'ist derzeit geschlossen'
        ]);
        self::generateTranslation('about_us', [
            'de' => 'Über uns'
        ]);
        self::generateTranslation('account', [
            'de' => 'Konto'
        ]);
        self::generateTranslation('added', [
            'de' => 'Hinzugefügt'
        ]);
        self::generateTranslation('advertisements', [
            'de' => 'Werbung'
        ]);
        self::generateTranslation('all', [
            'de' => 'Alle'
        ]);
        self::generateTranslation('active', [
            'de' => 'Aktiv'
        ]);
        self::generateTranslation('activate', [
            'de' => 'Aktivieren'
        ]);
        self::generateTranslation('deactivate', [
            'de' => 'Deaktivieren'
        ]);
        self::generateTranslation('age', [
            'de' => 'Alter'
        ]);
        self::generateTranslation('approve', [
            'de' => 'Genehmigen'
        ]);
        self::generateTranslation('approved', [
            'de' => 'Genehmigt'
        ]);
        self::generateTranslation('approval', [
            'de' => 'Genehmigen'
        ]);
        self::generateTranslation('books', [
            'de' => 'Bücher'
        ]);
        self::generateTranslation('browse', [
            'de' => 'durchsuchen'
        ]);
        self::generateTranslation('by', [
            'de' => 'nach'
        ]);
        self::generateTranslation('cancel', [
            'de' => 'Abbrechen'
        ]);
        self::generateTranslation('categories', [
            'de' => 'Kategorien'
        ]);
        self::generateTranslation('category', [
            'de' => 'Kategorie'
        ]);
        self::generateTranslation('channels', [
            'de' => 'Kanäle'
        ]);
        self::generateTranslation('check_all', [
            'de' => 'Alle prüfen'
        ]);
        self::generateTranslation('click_here', [
            'de' => 'Hier klicken'
        ]);
        self::generateTranslation('comments', [
            'de' => 'Kommentare'
        ]);
        self::generateTranslation('comment', [
            'de' => 'Kommentar'
        ]);
        self::generateTranslation('community', [
            'de' => 'Gemeinschaft'
        ]);
        self::generateTranslation('companies', [
            'de' => 'Unternehmen'
        ]);
        self::generateTranslation('contacts', [
            'de' => 'Kontakte'
        ]);
        self::generateTranslation('contact_us', [
            'de' => 'Kontakt'
        ]);
        self::generateTranslation('country', [
            'de' => 'Land'
        ]);
        self::generateTranslation('created', [
            'de' => 'Erstellt'
        ]);
        self::generateTranslation('date', [
            'de' => 'Datum'
        ]);
        self::generateTranslation('date_added', [
            'de' => 'Datum hinzugefügt'
        ]);
        self::generateTranslation('date_joined', [
            'de' => 'Datum des Beitritts'
        ]);
        self::generateTranslation('dear', [
            'de' => 'Liebe'
        ]);
        self::generateTranslation('delete', [
            'de' => 'Löschen'
        ]);
        self::generateTranslation('add', [
            'de' => 'Hinzufügen'
        ]);
        self::generateTranslation('delete_selected', [
            'de' => 'Ausgewählte löschen'
        ]);
        self::generateTranslation('des_title', [
            'de' => 'Beschreibung:'
        ]);
        self::generateTranslation('duration', [
            'de' => 'Dauer'
        ]);
        self::generateTranslation('education', [
            'de' => 'Bildung'
        ]);
        self::generateTranslation('email', [
            'de' => 'E-Mail'
        ]);
        self::generateTranslation('embed', [
            'de' => 'Einbetten'
        ]);
        self::generateTranslation('embed_code', [
            'de' => 'Code einbetten'
        ]);
        self::generateTranslation('favourite', [
            'de' => 'Bevorzugt'
        ]);
        self::generateTranslation('favourited', [
            'de' => 'Bevorzugte'
        ]);
        self::generateTranslation('favourites', [
            'de' => 'Favoriten'
        ]);
        self::generateTranslation('female', [
            'de' => 'Weiblich'
        ]);
        self::generateTranslation('filter', [
            'de' => 'Filtern'
        ]);
        self::generateTranslation('forgot', [
            'de' => 'Vergessen'
        ]);
        self::generateTranslation('friends', [
            'de' => 'Freunde'
        ]);
        self::generateTranslation('from', [
            'de' => 'Von'
        ]);
        self::generateTranslation('gender', [
            'de' => 'Geschlecht'
        ]);
        self::generateTranslation('groups', [
            'de' => 'Gruppen'
        ]);
        self::generateTranslation('hello', [
            'de' => 'Hallo'
        ]);
        self::generateTranslation('help', [
            'de' => 'Hilfe'
        ]);
        self::generateTranslation('hi', [
            'de' => 'Hallo'
        ]);
        self::generateTranslation('hobbies', [
            'de' => 'Hobbys'
        ]);
        self::generateTranslation('Home', [
            'de' => 'Startseite'
        ]);
        self::generateTranslation('inbox', [
            'de' => 'Posteingang'
        ]);
        self::generateTranslation('interests', [
            'de' => 'Interessen'
        ]);
        self::generateTranslation('join_now', [
            'de' => 'Jetzt beitreten'
        ]);
        self::generateTranslation('joined', [
            'de' => 'Registriert'
        ]);
        self::generateTranslation('join', [
            'de' => 'Beitreten'
        ]);
        self::generateTranslation('keywords', [
            'de' => 'Schlüsselwörter'
        ]);
        self::generateTranslation('latest', [
            'de' => 'Letzte'
        ]);
        self::generateTranslation('leave', [
            'de' => 'Verlassen'
        ]);
        self::generateTranslation('location', [
            'de' => 'Standort'
        ]);
        self::generateTranslation('login', [
            'de' => 'Anmeldung'
        ]);
        self::generateTranslation('logout', [
            'de' => 'Abmelden'
        ]);
        self::generateTranslation('male', [
            'de' => 'Männlich'
        ]);
        self::generateTranslation('members', [
            'de' => 'Mitglieder'
        ]);
        self::generateTranslation('messages', [
            'de' => 'Nachrichten'
        ]);
        self::generateTranslation('message', [
            'de' => 'Nachricht'
        ]);
        self::generateTranslation('minute', [
            'de' => 'Minute'
        ]);
        self::generateTranslation('minutes', [
            'de' => 'Minuten'
        ]);
        self::generateTranslation('most_members', [
            'de' => 'Meiste Mitglieder'
        ]);
        self::generateTranslation('most_recent', [
            'de' => 'Neueste'
        ]);
        self::generateTranslation('most_videos', [
            'de' => 'Meiste Videos'
        ]);
        self::generateTranslation('music', [
            'de' => 'Musik'
        ]);
        self::generateTranslation('my_account', [
            'de' => 'Mein Konto'
        ]);
        self::generateTranslation('next', [
            'de' => 'Nächste'
        ]);
        self::generateTranslation('no', [
            'de' => 'Nein'
        ]);
        self::generateTranslation('no_user_exists', [
            'de' => 'Es existiert kein Benutzer'
        ]);
        self::generateTranslation('no_video_exists', [
            'de' => 'Kein Video vorhanden'
        ]);
        self::generateTranslation('occupations', [
            'de' => 'Berufe'
        ]);
        self::generateTranslation('optional', [
            'de' => 'wahlweise'
        ]);
        self::generateTranslation('owner', [
            'de' => 'Besitzer'
        ]);
        self::generateTranslation('password', [
            'de' => 'Kennwort'
        ]);
        self::generateTranslation('please', [
            'de' => 'Bitte'
        ]);
        self::generateTranslation('privacy', [
            'de' => 'Datenschutz'
        ]);
        self::generateTranslation('privacy_policy', [
            'de' => 'Datenschutz'
        ]);
        self::generateTranslation('random', [
            'de' => 'Zufällig'
        ]);
        self::generateTranslation('rate', [
            'de' => 'Bewerten Sie'
        ]);
        self::generateTranslation('request', [
            'de' => 'Anfrage'
        ]);
        self::generateTranslation('related', [
            'de' => 'Zugehörige'
        ]);
        self::generateTranslation('reply', [
            'de' => 'Antwort'
        ]);
        self::generateTranslation('results', [
            'de' => 'Ergebnisse'
        ]);
        self::generateTranslation('relationship', [
            'de' => 'Beziehung'
        ]);
        self::generateTranslation('second', [
            'de' => 'Sekunde'
        ]);
        self::generateTranslation('seconds', [
            'de' => 'Sekunden'
        ]);
        self::generateTranslation('select', [
            'de' => 'Wählen Sie'
        ]);
        self::generateTranslation('send', [
            'de' => 'Senden'
        ]);
        self::generateTranslation('sent', [
            'de' => 'Gesendet'
        ]);
        self::generateTranslation('signup', [
            'de' => 'Anmeldung'
        ]);
        self::generateTranslation('subject', [
            'de' => 'Betreff'
        ]);
        self::generateTranslation('tags', [
            'de' => 'Stichworte'
        ]);
        self::generateTranslation('times', [
            'de' => 'Zeiten'
        ]);
        self::generateTranslation('to', [
            'de' => 'An'
        ]);
        self::generateTranslation('type', [
            'de' => 'Typ'
        ]);
        self::generateTranslation('update', [
            'de' => 'Aktualisieren'
        ]);
        self::generateTranslation('upload', [
            'de' => 'Hochladen'
        ]);
        self::generateTranslation('url', [
            'de' => 'URL'
        ]);
        self::generateTranslation('verification', [
            'de' => 'Überprüfung'
        ]);
        self::generateTranslation('videos', [
            'de' => 'Videos'
        ]);
        self::generateTranslation('viewing', [
            'de' => 'Anzeigen von'
        ]);
        self::generateTranslation('welcome', [
            'de' => 'Willkommen'
        ]);
        self::generateTranslation('website', [
            'de' => 'Website'
        ]);
        self::generateTranslation('yes', [
            'de' => 'Ja'
        ]);
        self::generateTranslation('of', [
            'de' => 'von'
        ]);
        self::generateTranslation('on', [
            'de' => 'auf'
        ]);
        self::generateTranslation('previous', [
            'de' => 'Vorherige'
        ]);
        self::generateTranslation('rating', [
            'de' => 'Bewertung'
        ]);
        self::generateTranslation('ratings', [
            'de' => 'Bewertungen'
        ]);
        self::generateTranslation('remote_upload', [
            'de' => 'Fern-Upload'
        ]);
        self::generateTranslation('remove', [
            'de' => 'entfernen'
        ]);
        self::generateTranslation('search', [
            'de' => 'Suche'
        ]);
        self::generateTranslation('services', [
            'de' => 'Dienstleistungen'
        ]);
        self::generateTranslation('show_all', [
            'de' => 'Alle anzeigen'
        ]);
        self::generateTranslation('signupup', [
            'de' => 'Anmelden'
        ]);
        self::generateTranslation('sort_by', [
            'de' => 'Sortieren'
        ]);
        self::generateTranslation('subscriptions', [
            'de' => 'Abonnements'
        ]);
        self::generateTranslation('subscribers', [
            'de' => 'Abonnenten'
        ]);
        self::generateTranslation('tag_title', [
            'de' => 'Stichworte'
        ]);
        self::generateTranslation('track_title', [
            'de' => 'Audiospur'
        ]);
        self::generateTranslation('time', [
            'de' => 'Zeit'
        ]);
        self::generateTranslation('top', [
            'de' => 'Top'
        ]);
        self::generateTranslation('tos_title', [
            'de' => 'Benutzungsbedingungen'
        ]);
        self::generateTranslation('username', [
            'de' => 'Benutzername'
        ]);
        self::generateTranslation('views', [
            'de' => 'Aufrufe'
        ]);
        self::generateTranslation('proccession_wait', [
            'de' => 'Bearbeitung, bitte warten'
        ]);
        self::generateTranslation('mostly_viewed', [
            'de' => 'Meist gesehen'
        ]);
        self::generateTranslation('most_comments', [
            'de' => 'Meiste Kommentare'
        ]);
        self::generateTranslation('group', [
            'de' => 'Gruppe'
        ]);
        self::generateTranslation('not_logged_in', [
            'de' => 'Sie sind nicht eingeloggt oder haben keine Berechtigung, auf diese Seite zuzugreifen. Dies könnte einen von mehreren Gründen haben:'
        ]);
        self::generateTranslation('fill_auth_form', [
            'de' => 'Sie sind nicht eingeloggt. Füllen Sie das untenstehende Formular aus und versuchen Sie es erneut.'
        ]);
        self::generateTranslation('insufficient_privileges', [
            'de' => 'Möglicherweise haben Sie keine ausreichenden Rechte, um auf diese Seite zuzugreifen.'
        ]);
        self::generateTranslation('admin_disabled_you', [
            'de' => 'Der Administrator der Website hat Ihr Konto möglicherweise deaktiviert oder es muss erst aktiviert werden.'
        ]);
        self::generateTranslation('Recover_Password', [
            'de' => 'Passwort wiederherstellen'
        ]);
        self::generateTranslation('Submit', [
            'de' => 'einreichen'
        ]);
        self::generateTranslation('Reset_Fields', [
            'de' => 'Felder zurücksetzen'
        ]);
        self::generateTranslation('admin_reg_req', [
            'de' => 'Der Administrator hat Sie möglicherweise aufgefordert, sich zu registrieren, bevor Sie diese Seite anzeigen können.'
        ]);
        self::generateTranslation('lang_change', [
            'de' => 'Sprache ändern'
        ]);
        self::generateTranslation('lang_changed', [
            'de' => 'Ihre Sprache wurde geändert'
        ]);
        self::generateTranslation('lang_choice', [
            'de' => 'Sprache'
        ]);
        self::generateTranslation('if_not_redir', [
            'de' => 'Klicken Sie hier, um fortzufahren, wenn Sie nicht automatisch weitergeleitet werden.'
        ]);
        self::generateTranslation('style_changed', [
            'de' => 'Ihr Stil wurde geändert'
        ]);
        self::generateTranslation('style_choice', [
            'de' => 'Stil'
        ]);
        self::generateTranslation('vdo_edit_vdo', [
            'de' => 'Video bearbeiten'
        ]);
        self::generateTranslation('vdo_stills', [
            'de' => 'Video Standbilder'
        ]);
        self::generateTranslation('vdo_watch_video', [
            'de' => 'Video ansehen'
        ]);
        self::generateTranslation('vdo_video_details', [
            'de' => 'Video-Details'
        ]);
        self::generateTranslation('vdo_title', [
            'de' => 'Titel'
        ]);
        self::generateTranslation('vdo_desc', [
            'de' => 'Beschreibung'
        ]);
        self::generateTranslation('vdo_cat', [
            'de' => 'Video-Kategorie'
        ]);
        self::generateTranslation('vdo_cat_msg', [
            'de' => 'Sie können bis zu %s Kategorien auswählen'
        ]);
        self::generateTranslation('vdo_tags_msg', [
            'de' => 'Tags werden durch Kommas getrennt d.h. Arslan Hassan, Awesome, ClipBucket'
        ]);
        self::generateTranslation('vdo_br_opt', [
            'de' => 'Optionen für die Übertragung'
        ]);
        self::generateTranslation('vdo_br_opt1', [
            'de' => 'Öffentlich - Teilen Sie Ihr Video mit allen! (Empfohlen)'
        ]);
        self::generateTranslation('vdo_br_opt2', [
            'de' => 'Privat - Nur für Sie und Ihre Freunde sichtbar.'
        ]);
        self::generateTranslation('vdo_date_loc', [
            'de' => 'Datum und Ort'
        ]);
        self::generateTranslation('vdo_date_rec', [
            'de' => 'Aufnahmedatum'
        ]);
        self::generateTranslation('vdo_for_date', [
            'de' => 'Format MM / TT / JJJJ '
        ]);
        self::generateTranslation('vdo_add_eg', [
            'de' => 'z. B. London Greenland, Sialkot Mubarak Pura'
        ]);
        self::generateTranslation('vdo_share_opt', [
            'de' => 'Optionen für Freigabe und Datenschutz'
        ]);
        self::generateTranslation('vdo_allow_comm', [
            'de' => 'Kommentare zulassen '
        ]);
        self::generateTranslation('vdo_dallow_comm', [
            'de' => 'Kommentare nicht zulassen'
        ]);
        self::generateTranslation('vdo_comm_vote', [
            'de' => 'Kommentare abstimmen'
        ]);
        self::generateTranslation('vdo_allow_com_vote', [
            'de' => 'Abstimmungen für Kommentare zulassen'
        ]);
        self::generateTranslation('vdo_dallow_com_vote', [
            'de' => 'Bei Kommentaren nicht zulassen'
        ]);
        self::generateTranslation('vdo_allow_rating', [
            'de' => 'Bewertung für dieses Video zulassen'
        ]);
        self::generateTranslation('vdo_embedding', [
            'de' => 'Einbetten'
        ]);
        self::generateTranslation('vdo_embed_opt1', [
            'de' => 'Menschen dürfen dieses Video auf anderen Websites abspielen'
        ]);
        self::generateTranslation('vdo_update_title', [
            'de' => 'Aktualisieren'
        ]);
        self::generateTranslation('vdo_inactive_msg', [
            'de' => 'Ihr Konto ist inaktiv. Bitte aktivieren Sie es, um Videos hochzuladen. Um Ihr Konto zu aktivieren, klicken Sie bitte'
        ]);
        self::generateTranslation('vdo_click_here', [
            'de' => 'Klicken Sie hier'
        ]);
        self::generateTranslation('vdo_continue_upload', [
            'de' => 'Weiter zum Hochladen'
        ]);
        self::generateTranslation('vdo_upload_step1', [
            'de' => 'Video hochladen'
        ]);
        self::generateTranslation('vdo_upload_step2', [
            'de' => 'Video Schritt %s/2'
        ]);
        self::generateTranslation('vdo_upload_step3', [
            'de' => '(Schritt 2/2)'
        ]);
        self::generateTranslation('vdo_select_vdo', [
            'de' => 'Wählen Sie ein Video zum Hochladen aus.'
        ]);
        self::generateTranslation('vdo_enter_remote_url', [
            'de' => 'Geben Sie die Url des Videos ein.'
        ]);
        self::generateTranslation('vdo_enter_embed_code_msg', [
            'de' => 'Geben Sie den Code zum Einbetten des Videos von anderen Websites ein, z. B. Youtube oder Metacafe.'
        ]);
        self::generateTranslation('vdo_enter_embed_code', [
            'de' => 'Einbettungscode eingeben'
        ]);
        self::generateTranslation('vdo_enter_druation', [
            'de' => 'Dauer eingeben'
        ]);
        self::generateTranslation('vdo_select_vdo_thumb', [
            'de' => 'Video Vorschaubild auswählen'
        ]);
        self::generateTranslation('vdo_having_trouble', [
            'de' => 'Haben Sie Probleme?'
        ]);
        self::generateTranslation('vdo_if_having_problem', [
            'de' => 'wenn Sie Probleme mit dem Uploader haben'
        ]);
        self::generateTranslation('vdo_clic_to_manage_all', [
            'de' => 'Hier klicken, um alle Videos zu verwalten'
        ]);
        self::generateTranslation('vdo_manage_vdeos', [
            'de' => 'Videos verwalten '
        ]);
        self::generateTranslation('vdo_status', [
            'de' => 'Status'
        ]);
        self::generateTranslation('vdo_rawfile', [
            'de' => 'Raw Datei'
        ]);
        self::generateTranslation('vdo_video_upload_complete', [
            'de' => 'Video-Upload – Hochladen abgeschlossen'
        ]);
        self::generateTranslation('vdo_thanks_you_upload_complete_1', [
            'de' => 'Dankeschön! Ihr Upload ist abgeschlossen'
        ]);
        self::generateTranslation('vdo_thanks_you_upload_complete_2', [
            'de' => 'Dieses Video ist verfügbar in'
        ]);
        self::generateTranslation('vdo_after_it_has_process', [
            'de' => 'verfügbar sein, sobald die Verarbeitung abgeschlossen ist.'
        ]);
        self::generateTranslation('vdo_embed_this_video_on_web', [
            'de' => 'Binden Sie dieses Video in Ihre Website ein.'
        ]);
        self::generateTranslation('vdo_copy_and_paste_the_code', [
            'de' => 'Kopieren Sie den unten stehenden Code und fügen Sie ihn ein, um dieses Video einzubetten.'
        ]);
        self::generateTranslation('vdo_upload_another_video', [
            'de' => 'Ein anderes Video hochladen'
        ]);
        self::generateTranslation('vdo_goto_my_videos', [
            'de' => 'Zu meinen Videos gehen'
        ]);
        self::generateTranslation('vdo_sperate_emails_by', [
            'de' => 'Emails durch Kommas trennen'
        ]);
        self::generateTranslation('vdo_personal_msg', [
            'de' => 'Persönliche Nachricht'
        ]);
        self::generateTranslation('vdo_related_tags', [
            'de' => 'Verwandte Tags'
        ]);
        self::generateTranslation('vdo_reply_to_this', [
            'de' => 'Hierauf antworten '
        ]);
        self::generateTranslation('vdo_add_reply', [
            'de' => 'Antwort hinzufügen'
        ]);
        self::generateTranslation('vdo_share_video', [
            'de' => 'Video teilen'
        ]);
        self::generateTranslation('vdo_about_this_video', [
            'de' => 'Über dieses Video'
        ]);
        self::generateTranslation('vdo_post_to_a_services', [
            'de' => 'An einen Aggregationsdienst senden'
        ]);
        self::generateTranslation('vdo_commentary', [
            'de' => 'Kommentar'
        ]);
        self::generateTranslation('vdo_post_a_comment', [
            'de' => 'Einen Kommentar posten'
        ]);
        self::generateTranslation('grp_add_vdo_msg', [
            'de' => 'Videos zur Gruppe hinzufügen '
        ]);
        self::generateTranslation('grp_no_vdo_msg', [
            'de' => 'Sie haben kein Video'
        ]);
        self::generateTranslation('grp_add_to', [
            'de' => 'Zur Gruppe hinzufügen'
        ]);
        self::generateTranslation('grp_add_vdos', [
            'de' => 'Videos hinzufügen'
        ]);
        self::generateTranslation('grp_name_title', [
            'de' => 'Gruppename'
        ]);
        self::generateTranslation('grp_tag_title', [
            'de' => 'Stichworte:'
        ]);
        self::generateTranslation('grp_des_title', [
            'de' => 'Beschreibung:'
        ]);
        self::generateTranslation('grp_tags_msg', [
            'de' => 'Geben Sie ein oder mehrere Tags ein, die durch Leerzeichen getrennt sind.'
        ]);
        self::generateTranslation('grp_tags_msg1', [
            'de' => 'Geben Sie ein oder mehrere Schlagwörter ein, die durch Leerzeichen getrennt sind. Tags sind Schlüsselwörter, mit denen Sie Ihre Gruppe beschreiben, damit sie von anderen Benutzern leicht gefunden werden kann. Wenn Sie z. B. eine Gruppe für Surfer haben, könnten Sie sie mit Tags versehen: Surfen, Strand, Wellen.'
        ]);
        self::generateTranslation('grp_url_title', [
            'de' => 'Wählen Sie eine eindeutige URL für den Gruppennamen:'
        ]);
        self::generateTranslation('grp_url_msg', [
            'de' => 'Geben Sie 3-18 Zeichen ohne Leerzeichen ein (z. B. «skateboarding skates»), die Teil der Webadresse Ihrer Gruppe werden sollen. Bitte beachten Sie, dass die von Ihnen gewählte Gruppennamen-URL dauerhaft ist und nicht geändert werden kann.'
        ]);
        self::generateTranslation('grp_cat_tile', [
            'de' => 'Gruppen-Kategorie:'
        ]);
        self::generateTranslation('grp_vdo_uploads', [
            'de' => 'Hochgeladene Videos:'
        ]);
        self::generateTranslation('grp_forum_posting', [
            'de' => 'Forum Beiträge:'
        ]);
        self::generateTranslation('grp_join_opt1', [
            'de' => 'Öffentlich, jeder kann beitreten.'
        ]);
        self::generateTranslation('grp_join_opt2', [
            'de' => 'Geschützt, Beitritt nur mit Genehmigung des Gründers möglich.'
        ]);
        self::generateTranslation('grp_join_opt3', [
            'de' => 'Privat, nur mit Einladung des Gründers, nur Mitglieder können die Gruppendetails sehen.'
        ]);
        self::generateTranslation('grp_vdo_opt1', [
            'de' => 'Videos sofort posten.'
        ]);
        self::generateTranslation('grp_vdo_opt2', [
            'de' => 'Genehmigung des Gründers erforderlich, bevor das Video verfügbar ist.'
        ]);
        self::generateTranslation('grp_vdo_opt3', [
            'de' => 'Nur Gründer können neue Videos hinzufügen.'
        ]);
        self::generateTranslation('grp_post_opt1', [
            'de' => 'Themen sofort posten.'
        ]);
        self::generateTranslation('grp_post_opt2', [
            'de' => 'Genehmigung des Gründers erforderlich, bevor das Thema verfügbar ist.'
        ]);
        self::generateTranslation('grp_post_opt3', [
            'de' => 'Nur der Gründer kann ein neues Thema erstellen.'
        ]);
        self::generateTranslation('grp_crt_grp', [
            'de' => 'Gruppe erstellen'
        ]);
        self::generateTranslation('grp_thumb_title', [
            'de' => 'Gruppen-Vorschaubild'
        ]);
        self::generateTranslation('grp_upl_thumb', [
            'de' => 'Gruppen-Vorschaubild hochladen'
        ]);
        self::generateTranslation('grp_must_be', [
            'de' => 'Muss sein'
        ]);
        self::generateTranslation('grp_90x90', [
            'de' => 'Verhältnis 90 x 90 ergibt die beste Qualität'
        ]);
        self::generateTranslation('grp_thumb_warn', [
            'de' => 'Laden Sie kein vulgäres oder urheberrechtlich geschütztes Material hoch'
        ]);
        self::generateTranslation('grp_del_confirm', [
            'de' => 'Sind Sie sicher, dass Sie diese Gruppe löschen möchten?'
        ]);
        self::generateTranslation('grp_del_success', [
            'de' => 'Sie haben erfolgreich gelöscht'
        ]);
        self::generateTranslation('grp_click_go_grps', [
            'de' => 'Klicken Sie hier, um zu Gruppen zu gehen'
        ]);
        self::generateTranslation('grp_edit_grp_title', [
            'de' => 'Gruppe bearbeiten'
        ]);
        self::generateTranslation('grp_manage_vdos', [
            'de' => 'Videos verwalten'
        ]);
        self::generateTranslation('grp_manage_mems', [
            'de' => 'Mitglieder verwalten'
        ]);
        self::generateTranslation('grp_del_group_title', [
            'de' => 'Gruppe löschen'
        ]);
        self::generateTranslation('grp_add_vdos_title', [
            'de' => 'Videos hinzufügen'
        ]);
        self::generateTranslation('grp_join_grp_title', [
            'de' => 'Gruppe beitreten'
        ]);
        self::generateTranslation('grp_leave_group_title', [
            'de' => 'Gruppe verlassen'
        ]);
        self::generateTranslation('grp_invite_grp_title', [
            'de' => 'Mitglieder einladen'
        ]);
        self::generateTranslation('grp_view_mems', [
            'de' => 'Mitglieder anzeigen'
        ]);
        self::generateTranslation('grp_view_vdos', [
            'de' => 'Videos ansehen'
        ]);
        self::generateTranslation('grp_create_grp_title', [
            'de' => 'Eine neue Gruppe erstellen'
        ]);
        self::generateTranslation('grp_most_members', [
            'de' => 'Meiste Mitglieder'
        ]);
        self::generateTranslation('grp_most_discussed', [
            'de' => 'Meistdiskutiert'
        ]);
        self::generateTranslation('grp_invite_msg', [
            'de' => 'Benutzer zu dieser Gruppe einladen'
        ]);
        self::generateTranslation('grp_invite_msg1', [
            'de' => 'Hat Sie zum Beitritt eingeladen'
        ]);
        self::generateTranslation('grp_invite_msg2', [
            'de' => 'Emails oder Benutzernamen eingeben (durch Kommas getrennt)'
        ]);
        self::generateTranslation('grp_url_title1', [
            'de' => 'Gruppe URL'
        ]);
        self::generateTranslation('grp_invite_msg3', [
            'de' => 'Einladung senden'
        ]);
        self::generateTranslation('grp_join_confirm_msg', [
            'de' => 'Sind Sie sicher, dass Sie dieser Gruppe beitreten möchten?'
        ]);
        self::generateTranslation('grp_join_msg_succ', [
            'de' => 'Sie sind der Gruppe erfolgreich beigetreten'
        ]);
        self::generateTranslation('grp_click_here_to_go', [
            'de' => 'Klicken Sie hier um zu gehen'
        ]);
        self::generateTranslation('grp_leave_confirm', [
            'de' => 'Sind Sie sicher, dass Sie diese Gruppe verlassen wollen?'
        ]);
        self::generateTranslation('grp_leave_succ_msg', [
            'de' => 'Sie haben die Gruppe verlassen'
        ]);
        self::generateTranslation('grp_manage_members_title', [
            'de' => 'Mitglieder verwalten '
        ]);
        self::generateTranslation('grp_for_approval', [
            'de' => 'Zur Freigabe'
        ]);
        self::generateTranslation('grp_rm_videos', [
            'de' => 'Videos entfernen'
        ]);
        self::generateTranslation('grp_rm_mems', [
            'de' => 'Mitglieder entfernen'
        ]);
        self::generateTranslation('grp_groups_title', [
            'de' => 'Gruppen verwalten'
        ]);
        self::generateTranslation('grp_joined_title', [
            'de' => 'Verbundene Gruppen verwalten'
        ]);
        self::generateTranslation('grp_remove_group', [
            'de' => 'Gruppe entfernen'
        ]);
        self::generateTranslation('grp_bo_grp_found', [
            'de' => 'Keine Gruppe gefunden'
        ]);
        self::generateTranslation('grp_joined_groups', [
            'de' => 'Verbundene Gruppen'
        ]);
        self::generateTranslation('grp_owned_groups', [
            'de' => 'Eigene Gruppen'
        ]);
        self::generateTranslation('grp_edit_this_grp', [
            'de' => 'Diese Gruppe bearbeiten'
        ]);
        self::generateTranslation('grp_topics_title', [
            'de' => 'Themen'
        ]);
        self::generateTranslation('grp_topic_title', [
            'de' => 'Thema'
        ]);
        self::generateTranslation('grp_posts_title', [
            'de' => 'Beiträge'
        ]);
        self::generateTranslation('grp_discus_title', [
            'de' => 'Diskussionen'
        ]);
        self::generateTranslation('grp_author_title', [
            'de' => 'Autor'
        ]);
        self::generateTranslation('grp_replies_title', [
            'de' => 'Antworten'
        ]);
        self::generateTranslation('grp_last_post_title', [
            'de' => 'Letzter Beitrag '
        ]);
        self::generateTranslation('grp_viewl_all_videos', [
            'de' => 'Alle Videos dieser Gruppe anzeigen'
        ]);
        self::generateTranslation('grp_add_new_topic', [
            'de' => 'Neues Thema hinzufügen'
        ]);
        self::generateTranslation('grp_attach_video', [
            'de' => 'Video anhängen '
        ]);
        self::generateTranslation('grp_add_topic', [
            'de' => 'Thema hinzufügen'
        ]);
        self::generateTranslation('grp_please_login', [
            'de' => 'Bitte anmelden, um Themen zu veröffentlichen'
        ]);
        self::generateTranslation('grp_please_join', [
            'de' => 'Bitte treten Sie dieser Gruppe bei, um Themen zu veröffentlichen'
        ]);
        self::generateTranslation('grp_inactive_account', [
            'de' => 'Ihr Konto ist inaktiv und muss vom Eigentümer der Gruppe aktiviert werden'
        ]);
        self::generateTranslation('grp_about_this_grp', [
            'de' => 'Über diese Gruppe '
        ]);
        self::generateTranslation('grp_no_vdo_err', [
            'de' => 'Diese Gruppe hat keine Vidoes'
        ]);
        self::generateTranslation('grp_posted_by', [
            'de' => 'Geschrieben von'
        ]);
        self::generateTranslation('grp_add_new_comment', [
            'de' => 'Neuen Kommentar hinzufügen'
        ]);
        self::generateTranslation('grp_add_comment', [
            'de' => 'Kommentar hinzufügen'
        ]);
        self::generateTranslation('grp_pls_login_comment', [
            'de' => 'Bitte einloggen, um Kommentare zu schreiben'
        ]);
        self::generateTranslation('grp_pls_join_comment', [
            'de' => 'Bitte treten Sie dieser Gruppe bei, um Kommentare zu posten'
        ]);
        self::generateTranslation('usr_activation_title', [
            'de' => 'Benutzer-Aktivierung'
        ]);
        self::generateTranslation('usr_actiavation_msg', [
            'de' => 'Geben Sie Ihren Benutzernamen und den Aktivierungscode ein, der Ihnen per E-Mail zugesandt wurde.'
        ]);
        self::generateTranslation('usr_actiavation_msg1', [
            'de' => 'Aktivierungscode anfordern'
        ]);
        self::generateTranslation('usr_activation_code_tl', [
            'de' => 'Aktivierungs-Code'
        ]);
        self::generateTranslation('usr_compose_msg', [
            'de' => 'Nachricht verfassen'
        ]);
        self::generateTranslation('usr_inbox_title', [
            'de' => 'Posteingang'
        ]);
        self::generateTranslation('usr_sent_title', [
            'de' => 'Gesendet'
        ]);
        self::generateTranslation('usr_to_title', [
            'de' => 'An: (Benutzername eingeben)'
        ]);
        self::generateTranslation('usr_or_select_frm_list', [
            'de' => 'oder aus der Kontaktliste auswählen'
        ]);
        self::generateTranslation('usr_attach_video', [
            'de' => 'Video anhängen'
        ]);
        self::generateTranslation('user_attached_video', [
            'de' => 'Angehängtes Video'
        ]);
        self::generateTranslation('usr_send_message', [
            'de' => 'Nachricht senden'
        ]);
        self::generateTranslation('user_no_message', [
            'de' => 'Keine Nachricht'
        ]);
        self::generateTranslation('user_delete_message_msg', [
            'de' => 'Diese Nachricht löschen'
        ]);
        self::generateTranslation('user_forgot_message', [
            'de' => 'Passwort vergessen'
        ]);
        self::generateTranslation('user_forgot_message_2', [
            'de' => 'Machen Sie sich keine Sorgen, stellen Sie es jetzt wieder her'
        ]);
        self::generateTranslation('user_pass_reset_msg', [
            'de' => 'Passwort zurücksetzen'
        ]);
        self::generateTranslation('user_pass_forgot_msg', [
            'de' => 'Wenn Sie Ihr Passwort vergessen haben, geben Sie bitte Ihren Benutzernamen und den Verifizierungscode in das Feld ein. Die Anweisungen zum Zurücksetzen des Passworts werden Ihnen dann per E-Mail zugesandt.'
        ]);
        self::generateTranslation('user_veri_code', [
            'de' => 'Verifizierungs-Code'
        ]);
        self::generateTranslation('user_reocover_user', [
            'de' => 'Benutzername wiederherstellen'
        ]);
        self::generateTranslation('user_user_forgot_msg', [
            'de' => 'Benutzernamen vergessen?'
        ]);
        self::generateTranslation('user_recover', [
            'de' => 'Wiederherstellen'
        ]);
        self::generateTranslation('user_reset', [
            'de' => 'Zurücksetzen'
        ]);
        self::generateTranslation('user_inactive_msg', [
            'de' => 'Ihr Konto ist inaktiv. Bitte aktivieren Sie Ihr Konto, indem Sie die <a href=\"./aktivierung.php\">Aktivierungsseite</a> aufrufen'
        ]);
        self::generateTranslation('user_dashboard', [
            'de' => 'Dashboard'
        ]);
        self::generateTranslation('user_manage_prof_chnnl', [
            'de' => 'Profil &amp; Kanal verwalten'
        ]);
        self::generateTranslation('user_manage_friends', [
            'de' => 'Freunde &amp; Kontakte verwalten'
        ]);
        self::generateTranslation('user_prof_channel', [
            'de' => 'Profil/Kanal'
        ]);
        self::generateTranslation('user_message_box', [
            'de' => 'Nachrichten-Box'
        ]);
        self::generateTranslation('user_new_messages', [
            'de' => 'Neue Nachrichten'
        ]);
        self::generateTranslation('user_goto_inbox', [
            'de' => 'Zum Posteingang gehen'
        ]);
        self::generateTranslation('user_goto_sentbox', [
            'de' => 'Zum Gesendet-Ordner gehen'
        ]);
        self::generateTranslation('user_compose_new', [
            'de' => 'Neue Nachrichten verfassen'
        ]);
        self::generateTranslation('user_total_subs_users', [
            'de' => 'Abonnierte Benutzer insgesamt'
        ]);
        self::generateTranslation('user_you_have', [
            'de' => 'Sie haben'
        ]);
        self::generateTranslation('user_fav_videos', [
            'de' => 'Bevorzugte Videos'
        ]);
        self::generateTranslation('user_your_vids_watched', [
            'de' => 'Ihre angesehenen Videos'
        ]);
        self::generateTranslation('user_times', [
            'de' => 'Mal'
        ]);
        self::generateTranslation('user_you_have_watched', [
            'de' => 'Sie haben angeschaut'
        ]);
        self::generateTranslation('user_channel_profiles', [
            'de' => 'Kanal und Profil'
        ]);
        self::generateTranslation('user_channel_views', [
            'de' => 'Aufrufe des Kanals'
        ]);
        self::generateTranslation('user_channel_comm', [
            'de' => 'Kommentare zum Kanal '
        ]);
        self::generateTranslation('user_manage_prof', [
            'de' => 'Profil/Kanal verwalten'
        ]);
        self::generateTranslation('user_you_created', [
            'de' => 'Sie haben erstellt'
        ]);
        self::generateTranslation('user_you_joined', [
            'de' => 'Sie sind beigetreten'
        ]);
        self::generateTranslation('user_create_group', [
            'de' => 'Neue Gruppe erstellen'
        ]);
        self::generateTranslation('user_manage_my_account', [
            'de' => 'Mein Konto verwalten '
        ]);
        self::generateTranslation('user_manage_my_videos', [
            'de' => 'Meine Videos verwalten'
        ]);
        self::generateTranslation('user_manage_my_channel', [
            'de' => 'Meinen Kanal verwalten'
        ]);
        self::generateTranslation('user_sent_box', [
            'de' => 'Meine gesendeten Artikel'
        ]);
        self::generateTranslation('user_manage_channel', [
            'de' => 'Kanal verwalten'
        ]);
        self::generateTranslation('user_manage_my_contacts', [
            'de' => 'Meine Kontakte verwalten'
        ]);
        self::generateTranslation('user_manage_contacts', [
            'de' => 'Kontakte verwalten'
        ]);
        self::generateTranslation('user_manage_favourites', [
            'de' => 'Lieblingsvideos verwalten'
        ]);
        self::generateTranslation('user_mem_login', [
            'de' => 'Mitglieder Login'
        ]);
        self::generateTranslation('user_already_have', [
            'de' => 'Bitte melden Sie sich hier an, wenn Sie bereits ein Konto bei'
        ]);
        self::generateTranslation('user_forgot_username', [
            'de' => 'Benutzername vergessen'
        ]);
        self::generateTranslation('user_forgot_password', [
            'de' => 'Passwort vergessen'
        ]);
        self::generateTranslation('user_create_your', [
            'de' => 'Erstellen Sie Ihr '
        ]);
        self::generateTranslation('all_fields_req', [
            'de' => 'Alle Felder sind erforderlich'
        ]);
        self::generateTranslation('user_valid_email_addr', [
            'de' => 'Gültige E-Mail Adresse'
        ]);
        self::generateTranslation('user_allowed_format', [
            'de' => 'Buchstaben A-Z oder a-z , Ziffern 0-9 und Unterstriche _'
        ]);
        self::generateTranslation('user_confirm_pass', [
            'de' => 'Bestätigen Sie Ihr Passwort'
        ]);
        self::generateTranslation('user_reg_msg_0', [
            'de' => 'Registrieren Sie sich als '
        ]);
        self::generateTranslation('user_reg_msg_1', [
            'de' => 'Mitglied, es ist kostenlos und einfach, füllen Sie einfach das folgende Formular aus'
        ]);
        self::generateTranslation('user_date_of_birth', [
            'de' => 'Geburtsdatum'
        ]);
        self::generateTranslation('user_enter_text_as_img', [
            'de' => 'Text wie auf dem Bild eingeben'
        ]);
        self::generateTranslation('user_refresh_img', [
            'de' => 'Bild aktualisieren'
        ]);
        self::generateTranslation('user_i_agree_to_the', [
            'de' => 'Ich stimme den <a href=\"%s\" target=\"_blank\">Nutzungsbedingungen</a> und <a href=\"%s\" target=\"_blank\" >der Datenschutzerklärung</a> zu'
        ]);
        self::generateTranslation('user_thanks_for_reg', [
            'de' => 'Vielen Dank für Ihre Registrierung auf '
        ]);
        self::generateTranslation('user_email_has_sent', [
            'de' => 'Sie haben eine E-Mail mit dem Inhalt Ihres Kontos erhalten'
        ]);
        self::generateTranslation('user_and_activation', [
            'de' => '&amp; Aktivierung'
        ]);
        self::generateTranslation('user_details_you_now', [
            'de' => 'Einzelheiten. Sie können nun die folgenden Dinge in unserem Netzwerk tun'
        ]);
        self::generateTranslation('user_upload_share_vds', [
            'de' => 'Videos hochladen, teilen'
        ]);
        self::generateTranslation('user_make_friends', [
            'de' => 'Freunde finden'
        ]);
        self::generateTranslation('user_send_messages', [
            'de' => 'Nachrichten senden'
        ]);
        self::generateTranslation('user_grow_your_network', [
            'de' => 'Ihr Netzwerk erweitern, indem Sie weitere Freunde einladen'
        ]);
        self::generateTranslation('user_rate_comment', [
            'de' => 'Videos bewerten und kommentieren'
        ]);
        self::generateTranslation('user_make_customize', [
            'de' => 'Erstellen und Anpassen Ihres Kanals'
        ]);
        self::generateTranslation('user_to_upload_vid', [
            'de' => 'Um ein Video hochzuladen, müssen Sie zuerst Ihr Konto aktivieren. Die Aktivierungsdetails wurden an Ihr E-Mail-Konto gesendet, es kann manchmal dauern, bis Sie Ihren Posteingang erreichen.'
        ]);
        self::generateTranslation('user_click_to_login', [
            'de' => 'Klicken Sie hier, um sich in Ihr Konto einzuloggen'
        ]);
        self::generateTranslation('user_view_my_channel', [
            'de' => 'Meinen Kanal anzeigen'
        ]);
        self::generateTranslation('user_change_pass', [
            'de' => 'Passwort ändern'
        ]);
        self::generateTranslation('user_email_settings', [
            'de' => 'E-Mail-Einstellungen'
        ]);
        self::generateTranslation('user_profile_settings', [
            'de' => 'Profil-Einstellungen'
        ]);
        self::generateTranslation('user_usr_prof_chnl_edit', [
            'de' => 'Benutzerprofil &amp; Kanal bearbeiten'
        ]);
        self::generateTranslation('user_personal_info', [
            'de' => 'Persönliche Informationen'
        ]);
        self::generateTranslation('user_fname', [
            'de' => 'Vorname'
        ]);
        self::generateTranslation('user_lname', [
            'de' => 'Nachname'
        ]);
        self::generateTranslation('user_gender', [
            'de' => 'Geschlecht'
        ]);
        self::generateTranslation('user_relat_status', [
            'de' => 'Beziehungsstatus'
        ]);
        self::generateTranslation('user_display_age', [
            'de' => 'Alter anzeigen'
        ]);
        self::generateTranslation('user_about_me', [
            'de' => 'Über mich'
        ]);
        self::generateTranslation('user_website_url', [
            'de' => 'Website URL'
        ]);
        self::generateTranslation('user_eg_website', [
            'de' => 'z.B. www.cafepixie.com'
        ]);
        self::generateTranslation('user_prof_info', [
            'de' => 'Berufliche Informationen'
        ]);
        self::generateTranslation('user_education', [
            'de' => 'Ausbildung'
        ]);
        self::generateTranslation('user_school_colleges', [
            'de' => 'Schulen/Hochschulen'
        ]);
        self::generateTranslation('user_occupations', [
            'de' => 'Beruf(e)'
        ]);
        self::generateTranslation('user_companies', [
            'de' => 'Unternehmen'
        ]);
        self::generateTranslation('user_sperate_by_commas', [
            'de' => 'mit Kommas trennen'
        ]);
        self::generateTranslation('user_interests_hobbies', [
            'de' => 'Interessen und Hobbys'
        ]);
        self::generateTranslation('user_fav_movs_shows', [
            'de' => 'Lieblingsfilme & -sendungen'
        ]);
        self::generateTranslation('user_fav_music', [
            'de' => 'Bevorzugte Musik'
        ]);
        self::generateTranslation('user_fav_books', [
            'de' => 'Bevorzugte Bücher'
        ]);
        self::generateTranslation('user_user_avatar', [
            'de' => 'Benutzer-Avatar'
        ]);
        self::generateTranslation('user_upload_avatar', [
            'de' => 'Avatar hochladen'
        ]);
        self::generateTranslation('user_channel_info', [
            'de' => 'Kanal-Infos'
        ]);
        self::generateTranslation('user_channel_title', [
            'de' => 'Titel des Kanals'
        ]);
        self::generateTranslation('user_channel_description', [
            'de' => 'Channel-Beschreibung'
        ]);
        self::generateTranslation('user_channel_permission', [
            'de' => 'Channel-Berechtigungen'
        ]);
        self::generateTranslation('user_allow_comments_msg', [
            'de' => 'Benutzer können kommentieren'
        ]);
        self::generateTranslation('user_dallow_comments_msg', [
            'de' => 'Benutzer können nicht kommentieren'
        ]);
        self::generateTranslation('user_allow_rating', [
            'de' => 'Bewertung zulassen'
        ]);
        self::generateTranslation('user_dallow_rating', [
            'de' => 'Bewertung nicht zulassen'
        ]);
        self::generateTranslation('user_allow_rating_msg1', [
            'de' => 'Benutzer können bewerten'
        ]);
        self::generateTranslation('user_dallow_rating_msg1', [
            'de' => 'Benutzer können nicht bewerten'
        ]);
        self::generateTranslation('user_channel_feature_vid', [
            'de' => 'Kanal Empfohlenes Video'
        ]);
        self::generateTranslation('user_select_vid_for_fr', [
            'de' => 'Wählen Sie das Video aus, das als „empfohlen“ gesetzt werden soll'
        ]);
        self::generateTranslation('user_chane_channel_bg', [
            'de' => 'Channel-Hintergrund ändern'
        ]);
        self::generateTranslation('user_remove_bg', [
            'de' => 'Hintergrund entfernen'
        ]);
        self::generateTranslation('user_currently_you_d_have_pic', [
            'de' => 'Sie haben derzeit kein Hintergrundbild'
        ]);
        self::generateTranslation('user_change_email', [
            'de' => 'E-Mail ändern'
        ]);
        self::generateTranslation('user_email_address', [
            'de' => 'E-Mail Adresse'
        ]);
        self::generateTranslation('user_new_email', [
            'de' => 'Neue E-Mail'
        ]);
        self::generateTranslation('user_notify_me', [
            'de' => 'Benachrichtigen, wenn ein Benutzer mir eine Nachricht sendet'
        ]);
        self::generateTranslation('user_old_pass', [
            'de' => 'Altes Passwort'
        ]);
        self::generateTranslation('user_new_pass', [
            'de' => 'Neues Passwort'
        ]);
        self::generateTranslation('user_c_new_pass', [
            'de' => 'Bestätigen Sie das neue Passwort'
        ]);
        self::generateTranslation('user_doesnt_exist', [
            'de' => 'Benutzer existiert nicht'
        ]);
        self::generateTranslation('user_do_not_have_contact', [
            'de' => 'Benutzer hat keine Kontakte'
        ]);
        self::generateTranslation('user_no_fav_video_exist', [
            'de' => 'Benutzer hat keine Lieblingsvideos ausgewählt'
        ]);
        self::generateTranslation('user_have_no_vide', [
            'de' => 'Benutzer hat keine Videos'
        ]);
        self::generateTranslation('user_s_channel', [
            'de' => '%s\'s Kanal'
        ]);
        self::generateTranslation('user_last_login', [
            'de' => 'Letzter Login'
        ]);
        self::generateTranslation('user_send_message', [
            'de' => 'Nachricht senden'
        ]);
        self::generateTranslation('user_add_contact', [
            'de' => 'Kontakt hinzufügen'
        ]);
        self::generateTranslation('user_dob', [
            'de' => 'DoB'
        ]);
        self::generateTranslation('user_movies_shows', [
            'de' => 'Filme &amp; Shows'
        ]);
        self::generateTranslation('user_add_comment', [
            'de' => 'Kommentar hinzufügen '
        ]);
        self::generateTranslation('user_no_fr_video', [
            'de' => 'Benutzer hat kein Video ausgewählt, um es als „empfohlen“ zu setzten'
        ]);
        self::generateTranslation('user_view_all_video_of', [
            'de' => 'Alle Videos anzeigen von '
        ]);
        self::generateTranslation('menu_home', [
            'de' => 'Zuhause'
        ]);
        self::generateTranslation('menu_inbox', [
            'de' => 'Posteingang'
        ]);
        self::generateTranslation('vdo_cat_err2', [
            'de' => 'Sie können nicht mehr als %d Kategorien auswählen'
        ]);
        self::generateTranslation('user_subscribe_message', [
            'de' => 'Hallo %subscriber%\nSie haben %user% abonniert und daher wird diese Nachricht automatisch an Sie gesendet, weil %user% ein neues Video hochgeladen hat\n\n%website_title%'
        ]);
        self::generateTranslation('user_subscribe_subject', [
            'de' => '%user% hat ein neues Video hochgeladen'
        ]);
        self::generateTranslation('you_already_logged', [
            'de' => 'Sie sind bereits eingeloggt'
        ]);
        self::generateTranslation('you_not_logged_in', [
            'de' => 'Sie sind nicht eingeloggt'
        ]);
        self::generateTranslation('invalid_user', [
            'de' => 'Ungültiger Benutzer'
        ]);
        self::generateTranslation('vdo_cat_err3', [
            'de' => 'Bitte wählen Sie mindestens 1 Kategorie'
        ]);
        self::generateTranslation('embed_code_invalid_err', [
            'de' => 'Ungültiger Video-Einbettungscode'
        ]);
        self::generateTranslation('invalid_duration', [
            'de' => 'Ungültige Dauer'
        ]);
        self::generateTranslation('vid_thumb_changed', [
            'de' => 'Der Standard-Thumbnail des Videos wurde geändert'
        ]);
        self::generateTranslation('vid_thumb_change_err', [
            'de' => 'Video-Thumbnail wurde nicht gefunden'
        ]);
        self::generateTranslation('upload_vid_thumbs_msg', [
            'de' => 'Alle Video-Thumbnails wurden hochgeladen'
        ]);
        self::generateTranslation('video_thumb_delete_msg', [
            'de' => 'Video-Thumbnail wurde gelöscht'
        ]);
        self::generateTranslation('video_thumb_delete_err', [
            'de' => 'Video-Thumbnail konnte nicht gelöscht werden'
        ]);
        self::generateTranslation('no_comment_del_perm', [
            'de' => 'Sie haben keine Berechtigung diesen Kommentar zu löschen'
        ]);
        self::generateTranslation('my_text_context', [
            'de' => 'Mein Testkontext'
        ]);
        self::generateTranslation('user_contains_disallow_err', [
            'de' => 'Benutzername enthält unzulässige Zeichen'
        ]);
        self::generateTranslation('add_cat_erro', [
            'de' => 'Kategorie existiert bereits'
        ]);
        self::generateTranslation('add_cat_no_name_err', [
            'de' => 'Bitte geben Sie einen Namen für die Kategorie ein'
        ]);
        self::generateTranslation('cat_default_err', [
            'de' => 'Standard kann nicht gelöscht werden, bitte wählen Sie eine andere Kategorie als «Standard» und löschen Sie dann diese Kategorie'
        ]);
        self::generateTranslation('pic_upload_vali_err', [
            'de' => 'Bitte laden Sie ein gültiges JPG, GIF oder PNG Bild hoch'
        ]);
        self::generateTranslation('cat_dir_make_err', [
            'de' => 'Das Thumb-Verzeichnis der Kategorie kann nicht erstellt werden'
        ]);
        self::generateTranslation('cat_set_default_ok', [
            'de' => 'Die Kategorie wurde als Standard festgelegt'
        ]);
        self::generateTranslation('vid_thumb_removed_msg', [
            'de' => 'Video Thumbs wurden entfernt'
        ]);
        self::generateTranslation('vid_files_removed_msg', [
            'de' => 'Videodateien wurden entfernt'
        ]);
        self::generateTranslation('vid_log_delete_msg', [
            'de' => 'Videoprotokoll wurde gelöscht'
        ]);
        self::generateTranslation('vdo_multi_del_erro', [
            'de' => 'Videos wurden gelöscht'
        ]);
        self::generateTranslation('add_fav_message', [
            'de' => 'Dieses %s wurde zu Ihren Favoriten hinzugefügt'
        ]);
        self::generateTranslation('obj_not_exists', [
            'de' => '%s existiert nicht'
        ]);
        self::generateTranslation('already_fav_message', [
            'de' => 'Dieses %s wurde bereits zu Ihren Favoriten hinzugefügt'
        ]);
        self::generateTranslation('obj_report_msg', [
            'de' => 'Dieses %s wurde gemeldet'
        ]);
        self::generateTranslation('obj_report_err', [
            'de' => 'Sie haben dieses %s bereits gemeldet'
        ]);
        self::generateTranslation('user_no_exist_wid_username', [
            'de' => '\'%s\' existiert nicht'
        ]);
        self::generateTranslation('share_video_no_user_err', [
            'de' => 'Bitte geben Sie Benutzernamen oder E-Mail ein, um diesen %s zu versenden'
        ]);
        self::generateTranslation('today', [
            'de' => 'Heute'
        ]);
        self::generateTranslation('yesterday', [
            'de' => 'Gestern'
        ]);
        self::generateTranslation('thisweek', [
            'de' => 'Diese Woche'
        ]);
        self::generateTranslation('lastweek', [
            'de' => 'Letzte Woche'
        ]);
        self::generateTranslation('thismonth', [
            'de' => 'Dieser Monat'
        ]);
        self::generateTranslation('lastmonth', [
            'de' => 'Letzter Monat'
        ]);
        self::generateTranslation('thisyear', [
            'de' => 'Dieses Jahr'
        ]);
        self::generateTranslation('lastyear', [
            'de' => 'Letztes Jahr'
        ]);
        self::generateTranslation('favorites', [
            'de' => 'Favoriten'
        ]);
        self::generateTranslation('alltime', [
            'de' => 'Alle Zeiten'
        ]);
        self::generateTranslation('insufficient_privileges_loggin', [
            'de' => 'Sie können nicht auf diese Seite zugreifen, bitte anmelden oder registrieren'
        ]);
        self::generateTranslation('profile_title', [
            'de' => 'Profil Titel'
        ]);
        self::generateTranslation('show_dob', [
            'de' => 'Geburtsdatum anzeigen'
        ]);
        self::generateTranslation('profile_tags', [
            'de' => 'Profil-Tags'
        ]);
        self::generateTranslation('profile_desc', [
            'de' => 'Profil-Beschreibung'
        ]);
        self::generateTranslation('online_status', [
            'de' => 'Benutzer-Status'
        ]);
        self::generateTranslation('show_profile', [
            'de' => 'Profil anzeigen'
        ]);
        self::generateTranslation('allow_ratings', [
            'de' => 'Profilbewertungen zulassen'
        ]);
        self::generateTranslation('postal_code', [
            'de' => 'Postleitzahl'
        ]);
        self::generateTranslation('temp_file_load_err', [
            'de' => 'Vorlagendatei \'%s\' im Verzeichnis \'%s\' kann nicht geladen werden'
        ]);
        self::generateTranslation('no_date_provided', [
            'de' => 'Kein Datum angegeben'
        ]);
        self::generateTranslation('bad_date', [
            'de' => 'Niemals'
        ]);
        self::generateTranslation('users_videos', [
            'de' => '%s\'s Videos'
        ]);
        self::generateTranslation('please_login_subscribe', [
            'de' => 'Bitte einloggen, um %s zu abonnieren'
        ]);
        self::generateTranslation('users_subscribers', [
            'de' => '%s\'s Abonnenten'
        ]);
        self::generateTranslation('user_no_subscribers', [
            'de' => '%s hat keine Abonnenten'
        ]);
        self::generateTranslation('user_subscriptions', [
            'de' => '%s\'s Abonnements'
        ]);
        self::generateTranslation('user_no_subscriptions', [
            'de' => '%s hat keine Abonnements'
        ]);
        self::generateTranslation('usr_avatar_bg_update', [
            'de' => 'Benutzeravatar und Hintergrund wurden aktualisiert'
        ]);
        self::generateTranslation('user_email_confirm_email_err', [
            'de' => 'Bestätigungs-E-Mail stimmt nicht überein'
        ]);
        self::generateTranslation('email_change_msg', [
            'de' => 'E-Mail wurde erfolgreich geändert'
        ]);
        self::generateTranslation('no_edit_video', [
            'de' => 'Sie können dieses Video nicht bearbeiten'
        ]);
        self::generateTranslation('confirm_del_video', [
            'de' => 'Sind Sie sicher, dass Sie dieses Video löschen möchten?'
        ]);
        self::generateTranslation('remove_fav_video_confirm', [
            'de' => 'Sind Sie sicher, dass Sie dieses Video aus Ihren Favoriten entfernen möchten?'
        ]);
        self::generateTranslation('remove_fav_collection_confirm', [
            'de' => 'Sind Sie sicher, dass Sie dieses Sammlung aus Ihren Favoriten entfernen möchten?'
        ]);
        self::generateTranslation('fav_remove_msg', [
            'de' => '%s wurde aus Ihren Favoriten entfernt'
        ]);
        self::generateTranslation('unknown_favorite', [
            'de' => 'Unbekannter Favorit %s'
        ]);
        self::generateTranslation('vdo_multi_del_fav_msg', [
            'de' => 'Videos wurden aus Ihren Favoriten entfernt'
        ]);
        self::generateTranslation('unknown_sender', [
            'de' => 'Unbekannter Absender'
        ]);
        self::generateTranslation('please_enter_message', [
            'de' => 'Bitte geben Sie etwas für die Nachricht ein'
        ]);
        self::generateTranslation('unknown_reciever', [
            'de' => 'Unbekannter Empfänger'
        ]);
        self::generateTranslation('no_pm_exist', [
            'de' => 'Private Nachricht existiert nicht'
        ]);
        self::generateTranslation('pm_sent_success', [
            'de' => 'Private Nachricht wurde erfolgreich versendet'
        ]);
        self::generateTranslation('msg_delete_inbox', [
            'de' => 'Nachricht wurde aus dem Posteingang gelöscht'
        ]);
        self::generateTranslation('msg_delete_outbox', [
            'de' => 'Nachricht wurde aus Ihrem Postausgang gelöscht'
        ]);
        self::generateTranslation('private_messags_deleted', [
            'de' => 'Private Nachrichten wurden gelöscht'
        ]);
        self::generateTranslation('ban_users', [
            'de' => 'Benutzer sperren'
        ]);
        self::generateTranslation('spe_users_by_comma', [
            'de' => 'Nutzernamen durch Komma trennen'
        ]);
        self::generateTranslation('user_ban_msg', [
            'de' => 'Benutzersperrliste wurde aktualisiert'
        ]);
        self::generateTranslation('no_user_ban_msg', [
            'de' => 'Kein Benutzer wurde von Ihrem Konto gesperrt!'
        ]);
        self::generateTranslation('thnx_sharing_msg', [
            'de' => 'Danke für das Teilen dieses %s'
        ]);
        self::generateTranslation('no_own_commen_rate', [
            'de' => 'Du kannst deinen eigenen Kommentar nicht bewerten'
        ]);
        self::generateTranslation('no_comment_exists', [
            'de' => 'Kommentar existiert nicht'
        ]);
        self::generateTranslation('thanks_rating_comment', [
            'de' => 'Danke für die Bewertung des Kommentars'
        ]);
        self::generateTranslation('please_login_create_playlist', [
            'de' => 'Bitte einloggen, um Wiedergabelisten zu erstellen'
        ]);
        self::generateTranslation('user_have_no_playlists', [
            'de' => 'Benutzer hat keine Wiedergabelisten'
        ]);
        self::generateTranslation('play_list_with_this_name_arlready_exists', [
            'de' => 'Wiedergabeliste mit dem Namen \'%s\' existiert bereits'
        ]);
        self::generateTranslation('please_enter_playlist_name', [
            'de' => 'Bitte Wiedergabelistennamen eingeben'
        ]);
        self::generateTranslation('new_playlist_created', [
            'de' => 'Neue Wiedergabeliste wurde erstellt'
        ]);
        self::generateTranslation('playlist_not_exist', [
            'de' => 'Wiedergabeliste existiert nicht'
        ]);
        self::generateTranslation('playlist_item_not_exist', [
            'de' => 'Element der Wiedergabeliste existiert nicht'
        ]);
        self::generateTranslation('playlist_item_delete', [
            'de' => 'Element der Wiedergabeliste wurde gelöscht'
        ]);
        self::generateTranslation('play_list_updated', [
            'de' => 'Wiedergabeliste wurde aktualisiert'
        ]);
        self::generateTranslation('you_dont_hv_permission_del_playlist', [
            'de' => 'Sie haben keine Berechtigung zum Löschen der Wiedergabeliste'
        ]);
        self::generateTranslation('playlist_delete_msg', [
            'de' => 'Wiedergabeliste wurde gelöscht'
        ]);
        self::generateTranslation('playlist_name', [
            'de' => 'Name der Wiedergabeliste'
        ]);
        self::generateTranslation('add_new_playlist', [
            'de' => 'Wiedergabeliste hinzufügen'
        ]);
        self::generateTranslation('this_thing_added_playlist', [
            'de' => 'Diese %s wurde zur Wiedergabeliste hinzugefügt'
        ]);
        self::generateTranslation('this_already_exist_in_pl', [
            'de' => 'Diese %s existiert bereits in Ihrer Wiedergabeliste'
        ]);
        self::generateTranslation('edit_playlist', [
            'de' => 'Wiedergabeliste bearbeiten'
        ]);
        self::generateTranslation('remove_playlist_item_confirm', [
            'de' => 'Sind Sie sicher, dass Sie dies aus Ihrer Wiedergabeliste entfernen möchten?'
        ]);
        self::generateTranslation('remove_playlist_confirm', [
            'de' => 'Sind Sie sicher, dass Sie diese Wiedergabeliste löschen möchten?'
        ]);
        self::generateTranslation('avcode_incorrect', [
            'de' => 'Der Aktivierungscode ist falsch'
        ]);
        self::generateTranslation('group_join_login_err', [
            'de' => 'Bitte melden Sie sich an, um dieser Gruppe beizutreten'
        ]);
        self::generateTranslation('manage_playlist', [
            'de' => 'Wiedergabeliste verwalten'
        ]);
        self::generateTranslation('my_notifications', [
            'de' => 'Meine Benachrichtigungen'
        ]);
        self::generateTranslation('users_contacts', [
            'de' => '%s\'s Kontakte'
        ]);
        self::generateTranslation('type_flags_removed', [
            'de' => '%s-Flaggen wurden entfernt'
        ]);
        self::generateTranslation('terms_of_serivce', [
            'de' => 'Nutzungsbedingungen'
        ]);
        self::generateTranslation('users', [
            'de' => 'Benutzer'
        ]);
        self::generateTranslation('login_to_mark_as_spam', [
            'de' => 'Bitte einloggen, um als Spam zu markieren'
        ]);
        self::generateTranslation('no_own_commen_spam', [
            'de' => 'Du kannst deinen eigenen Kommentar nicht als Spam markieren'
        ]);
        self::generateTranslation('already_spammed_comment', [
            'de' => 'Sie haben diesen Kommentar bereits als Spam markiert'
        ]);
        self::generateTranslation('spam_comment_ok', [
            'de' => 'Kommentar wurde als Spam markiert'
        ]);
        self::generateTranslation('arslan_hassan', [
            'de' => 'Arslan Hassan'
        ]);
        self::generateTranslation('you_not_allowed_add_grp_vids', [
            'de' => 'Sie sind nicht Mitglied dieser Gruppe und können keine Videos hinzufügen'
        ]);
        self::generateTranslation('sel_vids_updated', [
            'de' => 'Ausgewählte Videos wurden aktualisiert'
        ]);
        self::generateTranslation('unable_find_download_file', [
            'de' => 'Download-Datei kann nicht gefunden werden'
        ]);
        self::generateTranslation('you_cant_edit_group', [
            'de' => 'Sie können diese Gruppe nicht bearbeiten'
        ]);
        self::generateTranslation('you_cant_invite_mems', [
            'de' => 'Sie können keine Mitglieder einladen'
        ]);
        self::generateTranslation('you_cant_moderate_group', [
            'de' => 'Sie können diese Gruppe nicht moderieren'
        ]);
        self::generateTranslation('page_doesnt_exist', [
            'de' => 'Die Seite existiert nicht'
        ]);
        self::generateTranslation('pelase_select_img_file_for_vdo', [
            'de' => 'Bitte wählen Sie eine Bilddatei für den Video-Thumb'
        ]);
        self::generateTranslation('new_mem_added', [
            'de' => 'Ein neues Mitglied wurde hinzugefügt'
        ]);
        self::generateTranslation('this_vdo_not_working', [
            'de' => 'Dieses Video funktioniert möglicherweise nicht richtig'
        ]);
        self::generateTranslation('email_template_not_exist', [
            'de' => 'E-Mail-Vorlage existiert nicht'
        ]);
        self::generateTranslation('email_subj_empty', [
            'de' => 'Der Betreff der E-Mail war leer'
        ]);
        self::generateTranslation('email_msg_empty', [
            'de' => 'E-Mail-Nachricht war leer'
        ]);
        self::generateTranslation('email_tpl_has_updated', [
            'de' => 'E-Mail-Vorlage wurde aktualisiert'
        ]);
        self::generateTranslation('page_name_empty', [
            'de' => 'Seitenname war leer'
        ]);
        self::generateTranslation('page_title_empty', [
            'de' => 'Seitentitel war leer'
        ]);
        self::generateTranslation('page_content_empty', [
            'de' => 'Seiteninhalt war leer'
        ]);
        self::generateTranslation('new_page_added_successfully', [
            'de' => 'Neue Seite wurde erfolgreich hinzugefügt'
        ]);
        self::generateTranslation('page_updated', [
            'de' => 'Seite wurde aktualisiert'
        ]);
        self::generateTranslation('page_deleted', [
            'de' => 'Seite wurde erfolgreich gelöscht'
        ]);
        self::generateTranslation('page_activated', [
            'de' => 'Seite wurde aktiviert'
        ]);
        self::generateTranslation('page_deactivated', [
            'de' => 'Seite wurde deaktiviert'
        ]);
        self::generateTranslation('you_cant_delete_this_page', [
            'de' => 'Sie können diese Seite nicht löschen'
        ]);
        self::generateTranslation('ad_placement_err4', [
            'de' => 'Platzierung ist nicht vorhanden'
        ]);
        self::generateTranslation('grp_details_updated', [
            'de' => 'Gruppendetails wurden aktualisiert'
        ]);
        self::generateTranslation('you_cant_del_topic', [
            'de' => 'Sie können dieses Thema nicht löschen'
        ]);
        self::generateTranslation('you_cant_del_user_topics', [
            'de' => 'Sie können keine Benutzerthemen löschen'
        ]);
        self::generateTranslation('topics_deleted', [
            'de' => 'Themen wurden gelöscht'
        ]);
        self::generateTranslation('you_cant_delete_grp_topics', [
            'de' => 'Sie können keine Gruppenthemen löschen'
        ]);
        self::generateTranslation('you_not_allowed_post_topics', [
            'de' => 'Sie sind nicht berechtigt, Themen zu veröffentlichen'
        ]);
        self::generateTranslation('you_cant_add_this_vdo', [
            'de' => 'Sie können dieses Video nicht hinzufügen'
        ]);
        self::generateTranslation('video_added', [
            'de' => 'Video wurde hinzugefügt'
        ]);
        self::generateTranslation('you_cant_del_this_vdo', [
            'de' => 'Sie können dieses Video nicht entfernen'
        ]);
        self::generateTranslation('video_removed', [
            'de' => 'Das Video wurde entfernt'
        ]);
        self::generateTranslation('user_not_grp_mem', [
            'de' => 'Benutzer ist kein Gruppenmitglied'
        ]);
        self::generateTranslation('user_already_group_mem', [
            'de' => 'Der Benutzer ist bereits Mitglied dieser Gruppe'
        ]);
        self::generateTranslation('invitations_sent', [
            'de' => 'Einladungen wurden bereits verschickt'
        ]);
        self::generateTranslation('you_not_grp_mem', [
            'de' => 'Sie sind kein Mitglied dieser Gruppe'
        ]);
        self::generateTranslation('you_cant_delete_this_grp', [
            'de' => 'Sie können diese Gruppe nicht löschen'
        ]);
        self::generateTranslation('grp_deleted', [
            'de' => 'Die Gruppe wurde gelöscht'
        ]);
        self::generateTranslation('you_cant_del_grp_mems', [
            'de' => 'Sie können keine Gruppenmitglieder löschen'
        ]);
        self::generateTranslation('mems_deleted', [
            'de' => 'Die Mitglieder wurden gelöscht'
        ]);
        self::generateTranslation('you_cant_del_grp_vdos', [
            'de' => 'Sie können die Videos der Gruppe nicht löschen'
        ]);
        self::generateTranslation('thnx_for_voting', [
            'de' => 'Danke für die Bewertung'
        ]);
        self::generateTranslation('you_hv_already_rated_vdo', [
            'de' => 'Sie haben dieses Video bereits bewertet'
        ]);
        self::generateTranslation('please_login_to_rate', [
            'de' => 'Bitte einloggen um zu bewerten'
        ]);
        self::generateTranslation('you_not_subscribed', [
            'de' => 'Sie sind nicht angemeldet'
        ]);
        self::generateTranslation('you_cant_delete_this_user', [
            'de' => 'Sie können diesen Benutzer nicht löschen'
        ]);
        self::generateTranslation('you_dont_hv_perms', [
            'de' => 'Sie haben nicht genügend Berechtigungen'
        ]);
        self::generateTranslation('user_subs_hv_been_removed', [
            'de' => 'Benutzerabonnements wurden entfernt'
        ]);
        self::generateTranslation('user_subsers_hv_removed', [
            'de' => 'Benutzer-Abonnenten wurden entfernt'
        ]);
        self::generateTranslation('you_already_sent_frend_request', [
            'de' => 'Sie haben bereits eine Freundschaftsanfrage gesendet'
        ]);
        self::generateTranslation('friend_added', [
            'de' => 'Freund wurde hinzugefügt'
        ]);
        self::generateTranslation('friend_request_sent', [
            'de' => 'Freundschaftsanfrage wurde gesendet'
        ]);
        self::generateTranslation('friend_confirm_error', [
            'de' => 'Entweder hat der Benutzer Ihre Freundschaftsanfrage nicht angefordert oder Sie haben sie bereits bestätigt'
        ]);
        self::generateTranslation('friend_confirmed', [
            'de' => 'Freund wurde bestätigt'
        ]);
        self::generateTranslation('friend_request_not_found', [
            'de' => 'Keine Freundschaftsanfrage gefunden'
        ]);
        self::generateTranslation('you_cant_confirm_this_request', [
            'de' => 'Sie können diese Anfrage nicht bestätigen'
        ]);
        self::generateTranslation('friend_request_already_confirmed', [
            'de' => 'Die Freundschaftsanfrage wurde bereits bestätigt'
        ]);
        self::generateTranslation('user_no_in_contact_list', [
            'de' => 'Der Benutzer ist nicht in Ihrer Kontaktliste'
        ]);
        self::generateTranslation('user_removed_from_contact_list', [
            'de' => 'Der Benutzer wurde aus Ihrer Kontaktliste entfernt'
        ]);
        self::generateTranslation('cant_find_level', [
            'de' => 'Kann Level nicht finden'
        ]);
        self::generateTranslation('please_enter_level_name', [
            'de' => 'Bitte Levelname eingeben'
        ]);
        self::generateTranslation('level_updated', [
            'de' => 'Level wurde aktualisiert'
        ]);
        self::generateTranslation('level_del_sucess', [
            'de' => 'Benutzerebene wurde gelöscht, alle Benutzer dieser Ebene wurden auf %s übertragen'
        ]);
        self::generateTranslation('level_not_deleteable', [
            'de' => 'Diese Ebene ist nicht löschbar'
        ]);
        self::generateTranslation('pass_mismatched', [
            'de' => 'Passwörter stimmen nicht überein'
        ]);
        self::generateTranslation('user_blocked', [
            'de' => 'Benutzer wurde gesperrt'
        ]);
        self::generateTranslation('user_already_blocked', [
            'de' => 'Benutzer ist bereits gesperrt'
        ]);
        self::generateTranslation('you_cant_del_user', [
            'de' => 'Sie können diesen Benutzer nicht sperren'
        ]);
        self::generateTranslation('user_vids_hv_deleted', [
            'de' => 'Benutzervideos wurden gelöscht'
        ]);
        self::generateTranslation('user_contacts_hv_removed', [
            'de' => 'Benutzerkontakte wurden entfernt'
        ]);
        self::generateTranslation('all_user_inbox_deleted', [
            'de' => 'Alle Nachrichten im Posteingang des Benutzers wurden gelöscht'
        ]);
        self::generateTranslation('all_user_sent_messages_deleted', [
            'de' => 'Alle gesendeten Nachrichten des Benutzers wurden gelöscht'
        ]);
        self::generateTranslation('pelase_enter_something_for_comment', [
            'de' => 'Bitte geben Sie etwas in ein Kommentarfeld ein'
        ]);
        self::generateTranslation('please_enter_your_name', [
            'de' => 'Bitte geben Sie Ihren Namen ein'
        ]);
        self::generateTranslation('please_enter_your_email', [
            'de' => 'Bitte geben Sie Ihre E-Mail ein'
        ]);
        self::generateTranslation('template_activated', [
            'de' => 'Vorlage wurde aktiviert'
        ]);
        self::generateTranslation('error_occured_changing_template', [
            'de' => 'Beim Ändern der Vorlage ist ein Fehler aufgetreten'
        ]);
        self::generateTranslation('phrase_code_empty', [
            'de' => 'Der Phrasencode war leer'
        ]);
        self::generateTranslation('phrase_text_empty', [
            'de' => 'Phrasentext war leer'
        ]);
        self::generateTranslation('language_does_not_exist', [
            'de' => 'Sprache ist nicht vorhanden'
        ]);
        self::generateTranslation('name_has_been_added', [
            'de' => '%s wurde hinzugefügt'
        ]);
        self::generateTranslation('name_already_exists', [
            'de' => '\'%s\' existiert bereits'
        ]);
        self::generateTranslation('lang_doesnt_exist', [
            'de' => 'Sprache existiert nicht'
        ]);
        self::generateTranslation('no_file_was_selected', [
            'de' => 'Es wurde keine Datei ausgewählt'
        ]);
        self::generateTranslation('err_reading_file_content', [
            'de' => 'Fehler beim Lesen des Dateiinhalts'
        ]);
        self::generateTranslation('cant_find_lang_name', [
            'de' => 'Sprachenname nicht gefunden'
        ]);
        self::generateTranslation('cant_find_lang_code', [
            'de' => 'Sprachcode nicht gefunden'
        ]);
        self::generateTranslation('no_phrases_found', [
            'de' => 'Es wurden keine Phrasen gefunden'
        ]);
        self::generateTranslation('language_already_exists', [
            'de' => 'Sprache existiert bereits'
        ]);
        self::generateTranslation('lang_added', [
            'de' => 'Sprache wurde erfolgreich hinzugefügt'
        ]);
        self::generateTranslation('error_while_upload_file', [
            'de' => 'Beim Hochladen der Sprachdatei ist ein Fehler aufgetreten'
        ]);
        self::generateTranslation('default_lang_del_error', [
            'de' => 'Dies ist die Standardsprache, bitte wählen Sie eine andere Sprache als Standard und löschen Sie dann dieses Paket'
        ]);
        self::generateTranslation('lang_deleted', [
            'de' => 'Sprachpaket wurde gelöscht'
        ]);
        self::generateTranslation('lang_name_empty', [
            'de' => 'Sprachenname war leer'
        ]);
        self::generateTranslation('lang_code_empty', [
            'de' => 'Sprachcode war leer'
        ]);
        self::generateTranslation('lang_regex_empty', [
            'de' => 'Der reguläre Ausdruck der Sprache war leer'
        ]);
        self::generateTranslation('lang_code_already_exist', [
            'de' => 'Sprachcode existiert bereits'
        ]);
        self::generateTranslation('lang_updated', [
            'de' => 'Die Sprache wurde aktualisiert'
        ]);
        self::generateTranslation('player_activated', [
            'de' => 'Der Player wurde aktiviert'
        ]);
        self::generateTranslation('error_occured_while_activating_player', [
            'de' => 'Beim Aktivieren des Players ist ein Fehler aufgetreten'
        ]);
        self::generateTranslation('plugin_has_been_s', [
            'de' => 'Plugin wurde %s'
        ]);
        self::generateTranslation('plugin_uninstalled', [
            'de' => 'Plugin wurde deinstalliert'
        ]);
        self::generateTranslation('perm_code_empty', [
            'de' => 'Der Berechtigungscode ist leer'
        ]);
        self::generateTranslation('perm_name_empty', [
            'de' => 'Der Name der Berechtigung ist leer'
        ]);
        self::generateTranslation('perm_already_exist', [
            'de' => 'Berechtigung existiert bereits'
        ]);
        self::generateTranslation('perm_type_not_valid', [
            'de' => 'Berechtigungstyp ist ungültig'
        ]);
        self::generateTranslation('perm_added', [
            'de' => 'Es wurde eine neue Berechtigung hinzugefügt'
        ]);
        self::generateTranslation('perm_deleted', [
            'de' => 'Berechtigung wurde gelöscht'
        ]);
        self::generateTranslation('perm_doesnt_exist', [
            'de' => 'Berechtigung existiert nicht'
        ]);
        self::generateTranslation('acitvation_html_message', [
            'de' => 'Bitte geben Sie Ihren Benutzernamen und Ihren Aktivierungscode ein, um Ihr Konto zu aktivieren. Bitte überprüfen Sie Ihren Posteingang auf den Aktivierungscode, wenn Sie keinen erhalten haben, fordern Sie ihn bitte über das folgende Formular an'
        ]);
        self::generateTranslation('acitvation_html_message2', [
            'de' => 'Bitte geben Sie Ihre E-Mail-Adresse ein, um Ihren Aktivierungscode anzufordern'
        ]);
        self::generateTranslation('admin_panel', [
            'de' => 'Verwaltungsbereich'
        ]);
        self::generateTranslation('moderate_videos', [
            'de' => 'Gemäßigte Videos'
        ]);
        self::generateTranslation('moderate_users', [
            'de' => 'Gemäßigte Benutzer'
        ]);
        self::generateTranslation('revert_back_to_admin', [
            'de' => 'Zum Administrator zurückkehren'
        ]);
        self::generateTranslation('more_options', [
            'de' => 'Weitere Optionen'
        ]);
        self::generateTranslation('downloading_string', [
            'de' => 'Herunterladen von %s ...'
        ]);
        self::generateTranslation('download_redirect_msg', [
            'de' => '<a href=\"%s\">Klicken Sie hier, wenn Sie nicht automatisch weitergeleitet werden </a> - <a href=\"%s\"> Hier klicken, um zur Video-Seite zurückzukehren</a>'
        ]);
        self::generateTranslation('account_details', [
            'de' => 'Konto-Details'
        ]);
        self::generateTranslation('profile_details', [
            'de' => 'Profil-Details'
        ]);
        self::generateTranslation('update_profile', [
            'de' => 'Profil aktualisieren'
        ]);
        self::generateTranslation('please_select_img_file', [
            'de' => 'Bitte wählen Sie eine Bilddatei'
        ]);
        self::generateTranslation('or', [
            'de' => 'oder'
        ]);
        self::generateTranslation('pelase_enter_image_url', [
            'de' => 'Bitte Bild-URL eingeben'
        ]);
        self::generateTranslation('user_bg', [
            'de' => 'Kanal-Hintergrund'
        ]);
        self::generateTranslation('user_bg_img', [
            'de' => 'Channel-Hintergrundbild'
        ]);
        self::generateTranslation('please_enter_bg_color', [
            'de' => 'Bitte Hintergrundfarbe eingeben'
        ]);
        self::generateTranslation('bg_repeat_type', [
            'de' => 'Hintergrund-Wiederholungstyp (bei Verwendung eines Bildes als Hintergrund)'
        ]);
        self::generateTranslation('fix_bg', [
            'de' => 'Hintergrund fixieren'
        ]);
        self::generateTranslation('delete_this_img', [
            'de' => 'Dieses Bild löschen'
        ]);
        self::generateTranslation('current_email', [
            'de' => 'Aktuelle E-Mail'
        ]);
        self::generateTranslation('confirm_new_email', [
            'de' => 'Neue E-Mail bestätigen'
        ]);
        self::generateTranslation('no_subs_found', [
            'de' => 'Keine Abonnements gefunden'
        ]);
        self::generateTranslation('video_info_all_fields_req', [
            'de' => 'Videoinformationen - Alle Felder sind erforderlich'
        ]);
        self::generateTranslation('update_group', [
            'de' => 'Gruppe aktualisieren'
        ]);
        self::generateTranslation('default', [
            'de' => 'Standard'
        ]);
        self::generateTranslation('grp_info_all_fields_req', [
            'de' => 'Gruppeninformationen - Alle Felder sind erforderlich'
        ]);
        self::generateTranslation('date_recorded_location', [
            'de' => 'Aufnahmedatum &amp; Ort'
        ]);
        self::generateTranslation('update_video', [
            'de' => 'Video aktualisieren'
        ]);
        self::generateTranslation('click_here_to_recover_user', [
            'de' => 'Klicken Sie hier, um Ihren Benutzernamen wiederherzustellen'
        ]);
        self::generateTranslation('click_here_reset_pass', [
            'de' => 'Klicken Sie hier, um Ihr Passwort zurückzusetzen'
        ]);
        self::generateTranslation('remember_me', [
            'de' => 'Erinnern Sie sich an mich'
        ]);
        self::generateTranslation('howdy_user', [
            'de' => 'Hallo %s'
        ]);
        self::generateTranslation('notifications', [
            'de' => 'Benachrichtigungen'
        ]);
        self::generateTranslation('playlists', [
            'de' => 'Wiedergabelisten'
        ]);
        self::generateTranslation('friend_requests', [
            'de' => 'Freundschaftsanfragen'
        ]);
        self::generateTranslation('after_meny_guest_msg', [
            'de' => 'Willkommen Gast! Bitte <a href=\"%s\">anmelden</a> oder <a href=\"%s\">registrieren</a>'
        ]);
        self::generateTranslation('being_watched', [
            'de' => 'Überwacht werden'
        ]);
        self::generateTranslation('change_style_of_listing', [
            'de' => 'Stil der Auflistung ändern'
        ]);
        self::generateTranslation('website_members', [
            'de' => '%s Mitglieder'
        ]);
        self::generateTranslation('guest_homeright_msg', [
            'de' => 'Beobachten, Hochladen, Teilen und mehr'
        ]);
        self::generateTranslation('reg_for_free', [
            'de' => 'Kostenlos registrieren'
        ]);
        self::generateTranslation('rand_vids', [
            'de' => 'Zufällige Videos'
        ]);
        self::generateTranslation('t_10_users', [
            'de' => 'Top 10 Benutzer'
        ]);
        self::generateTranslation('pending', [
            'de' => 'Ausstehend'
        ]);
        self::generateTranslation('confirm', [
            'de' => 'Bestätigen Sie'
        ]);
        self::generateTranslation('no_contacts', [
            'de' => 'Keine Kontakte'
        ]);
        self::generateTranslation('you_dont_hv_any_grp', [
            'de' => 'Sie haben keine Gruppen'
        ]);
        self::generateTranslation('you_dont_joined_any_grp', [
            'de' => 'Sie sind keiner Gruppe beigetreten'
        ]);
        self::generateTranslation('leave_groups', [
            'de' => 'Gruppen verlassen'
        ]);
        self::generateTranslation('manage_grp_mems', [
            'de' => 'Gruppenmitglieder verwalten'
        ]);
        self::generateTranslation('pending_mems', [
            'de' => 'Ausstehende Mitglieder'
        ]);
        self::generateTranslation('active_mems', [
            'de' => 'Aktive Mitglieder'
        ]);
        self::generateTranslation('disapprove', [
            'de' => 'Ablehnen'
        ]);
        self::generateTranslation('manage_grp_vids', [
            'de' => 'Gruppenvideos verwalten'
        ]);
        self::generateTranslation('pending_vids', [
            'de' => 'Ausstehende Videos'
        ]);
        self::generateTranslation('no_pending_vids', [
            'de' => 'Keine ausstehenden Videos'
        ]);
        self::generateTranslation('no_active_videos', [
            'de' => 'Keine aktiven Videos'
        ]);
        self::generateTranslation('active_videos', [
            'de' => 'Aktive Videos'
        ]);
        self::generateTranslation('manage_playlists', [
            'de' => 'Wiedergabelisten verwalten'
        ]);
        self::generateTranslation('total_items', [
            'de' => 'Elemente insgesamt'
        ]);
        self::generateTranslation('play_now', [
            'de' => 'JETZT ABSPIELEN'
        ]);
        self::generateTranslation('no_video_in_playlist', [
            'de' => 'Diese Wiedergabeliste hat kein Video'
        ]);
        self::generateTranslation('view', [
            'de' => 'Aufruf'
        ]);
        self::generateTranslation('you_dont_hv_fav_vids', [
            'de' => 'Sie haben keine Lieblingsvideos'
        ]);
        self::generateTranslation('private_messages', [
            'de' => 'Private Nachrichten'
        ]);
        self::generateTranslation('new_private_msg', [
            'de' => 'Neue private Nachricht'
        ]);
        self::generateTranslation('search_for_s', [
            'de' => 'Suche nach %s'
        ]);
        self::generateTranslation('signup_success_usr_ok', [
            'de' => '<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">Nur noch ein Schritt</h2> \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 14px;\">Sie sind nur noch einen Schritt davon entfernt, ein offizielles Mitglied unserer Website zu werden.  Bitte überprüfen Sie Ihre E-Mail, wir haben Ihnen eine Bestätigungs-E-Mail geschickt, die einen Bestätigungslink von unserer Website enthält. Bitte klicken Sie darauf, um Ihre Registrierung abzuschließen.</p>'
        ]);
        self::generateTranslation('signup_success_usr_emailverify', [
            'de' => '<h2 style=\"font-family:Arial,Verdana,sans-serif; margin:5px 5px 8px;\">Willkommen in unserer Gemeinschaft</h2>\r\n    \t<p style=\"margin:0px 5px; line-height:18px; font-size:11px;\">Ihre E-Mail wurde bestätigt. Bitte <strong><a href=\"%s\">klicken Sie hier, um sich anzumelden</a></strong> und als registriertes Mitglied fortzufahren.</p>'
        ]);
        self::generateTranslation('if_you_already_hv_account', [
            'de' => 'wenn Sie bereits ein Konto haben, melden Sie sich bitte hier an '
        ]);
        self::generateTranslation('signup_message_under_login', [
            'de' => '<p>Unsere Website ist das Zuhause für Online-Videos: </p>\r\n\r\n<ul><li><strong>Sehen Sie</strong> sich Millionen von Videos an </li><li><strong>Teilen Sie</strong> sich Millionen von Videos an </li>\r\n<li><strong>Verbinden Sie sich mit anderen Nutzern,</strong> die Ihre Interessen teilen </li><li><strong>Laden Sie Ihre Videos</strong> für ein weltweites Publikum hoch \r\n\r\n</li></ul>'
        ]);
        self::generateTranslation('new_mems_signup_here', [
            'de' => 'Neue Mitglieder melden sich hier an'
        ]);
        self::generateTranslation('register_as_our_website_member', [
            'de' => 'Registrieren Sie sich als Mitglied, es ist kostenlos und einfach '
        ]);
        self::generateTranslation('video_complete_msg', [
            'de' => '<h2>Das Hochladen der Videos wurde abgeschlossen </h2>\r\n<span class=\"header1\">Dankeschön! Ihr Hochladen ist abgeschlossen. </span><br>\r\n<span class=\"tips\">Dieses Video wird unter <a href=\"%s\"><strong>Meine Videos</strong></a> nach Abschluss der Bearbeitung verfügbar sein. </span> \r\n<div class=\"upload_link_button\" align=\"center\"> \r\n<ul>\r\n<li><a href=\"%s\" >Ein weiteres Video hochladen</a></li>\r\n<li><a href=\"%s\" >Zu Meine Videos gehen </a></li>\r\n</ul>\r\n<div class=\'clearfix\'></div>\r\n</div>\r\n'
        ]);
        self::generateTranslation('upload_right_guide', [
            'de' => '<div>\r\n<div>\r\n <p>\r\n<strong>\r\n<strong>Wichtig:</strong>\r\nLaden Sie keine Fernsehsendungen, Musikvideos, Musikkonzerte oder Werbespots ohne Genehmigung hoch, es sei denn, sie bestehen vollständig aus selbst erstellten Inhalten.</strong> </p> \r\n<p>Die \r\n<a href=\"#\">Seite mit Copyright Tipps</a> und die \r\n<a href=\"#\">Leitlinien der Community</a> können Ihnen helfen festzustellen, ob Ihr Video das Urheberrecht eines anderen verletzt.</p> \r\n<p>Durch Anklicken \"Video hochladen\", versichern Sie, dass dieses Video nicht gegen die \r\n<a id=\"terms-of-use-link\" href=\"#\">Nutzungsbedingungen</a> unserer Website verstößt \r\n und dass Sie alle Urheberrechte an diesem Video besitzen, oder die Genehmigung haben es hochzuladen. </p>\r\n </div>\r\n </div>'
        ]);
        self::generateTranslation('report_this_user', [
            'de' => 'Diesen Benutzer melden'
        ]);
        self::generateTranslation('add_to_favs', [
            'de' => 'Mein Favorit!'
        ]);
        self::generateTranslation('report_this', [
            'de' => 'Bericht'
        ]);
        self::generateTranslation('share_this', [
            'de' => 'Teilen Sie dies'
        ]);
        self::generateTranslation('add_to_playlist', [
            'de' => 'Zur Wiedergabeliste hinzufügen'
        ]);
        self::generateTranslation('view_profile', [
            'de' => 'Profil ansehen'
        ]);
        self::generateTranslation('subscribe', [
            'de' => 'Abonnieren'
        ]);
        self::generateTranslation('uploaded_by_s', [
            'de' => 'Hochgeladen von %s'
        ]);
        self::generateTranslation('more', [
            'de' => 'Mehr'
        ]);
        self::generateTranslation('link_this_video', [
            'de' => 'Dieses Video verlinken'
        ]);
        self::generateTranslation('click_to_download_video', [
            'de' => 'Klicken Sie hier, um dieses Video herunterzuladen'
        ]);
        self::generateTranslation('name', [
            'de' => 'Name'
        ]);
        self::generateTranslation('email_wont_display', [
            'de' => 'E-Mail (wird nicht angezeigt)'
        ]);
        self::generateTranslation('please_login_to_comment', [
            'de' => 'Bitte einloggen, um zu kommentieren'
        ]);
        self::generateTranslation('marked_as_spam_comment_by_user', [
            'de' => 'Markiert als Spam, kommentiert von <em>%s</em>'
        ]);
        self::generateTranslation('spam', [
            'de' => 'Spam'
        ]);
        self::generateTranslation('user_commented_time', [
            'de' => '<a href=\"%s\">%s</a> kommentiert %s'
        ]);
        self::generateTranslation('no_comments', [
            'de' => 'Niemand hat bisher einen Kommentar zu diesem %s abgegeben'
        ]);
        self::generateTranslation('view_video', [
            'de' => 'Video ansehen'
        ]);
        self::generateTranslation('topic_icon', [
            'de' => 'Themen-Symbol'
        ]);
        self::generateTranslation('group_options', [
            'de' => 'Option Gruppe'
        ]);
        self::generateTranslation('info', [
            'de' => 'Infos'
        ]);
        self::generateTranslation('basic_info', [
            'de' => 'Grundlegende Informationen'
        ]);
        self::generateTranslation('group_owner', [
            'de' => 'Besitzer der Gruppe'
        ]);
        self::generateTranslation('total_mems', [
            'de' => 'Mitglieder gesamt'
        ]);
        self::generateTranslation('total_topics', [
            'de' => 'Themen insgesamt'
        ]);
        self::generateTranslation('grp_url', [
            'de' => 'Gruppen-URL'
        ]);
        self::generateTranslation('more_details', [
            'de' => 'Mehr Details'
        ]);
        self::generateTranslation('view_all_mems', [
            'de' => 'Alle Mitglieder anzeigen'
        ]);
        self::generateTranslation('view_all_vids', [
            'de' => 'Alle Videos anzeigen'
        ]);
        self::generateTranslation('topic_title', [
            'de' => 'Titel des Themas'
        ]);
        self::generateTranslation('last_reply', [
            'de' => 'Letzte Antwort'
        ]);
        self::generateTranslation('topic_by_user', [
            'de' => '<a href=\"%s\">%s</a></span> by <a href=\"%s\">%s</a>'
        ]);
        self::generateTranslation('no_topics', [
            'de' => 'Keine Themen'
        ]);
        self::generateTranslation('last_post_time_by_user', [
            'de' => '%s<br />\r\nby <a href=\"%s\">%s'
        ]);
        self::generateTranslation('profile_views', [
            'de' => 'Aufrufe des Profils'
        ]);
        self::generateTranslation('last_logged_in', [
            'de' => 'Zuletzt eingeloggt'
        ]);
        self::generateTranslation('last_active', [
            'de' => 'Zuletzt aktiv'
        ]);
        self::generateTranslation('total_logins', [
            'de' => 'Anmeldungen insgesamt'
        ]);
        self::generateTranslation('total_videos_watched', [
            'de' => 'Insgesamt angeschaute Videos'
        ]);
        self::generateTranslation('view_group', [
            'de' => 'Gruppe anzeigen'
        ]);
        self::generateTranslation('you_dont_hv_any_pm', [
            'de' => 'Keine Nachrichten anzeigen'
        ]);
        self::generateTranslation('date_sent', [
            'de' => 'Gesendetes Datum'
        ]);
        self::generateTranslation('show_hide', [
            'de' => 'anzeigen - ausblenden'
        ]);
        self::generateTranslation('quicklists', [
            'de' => 'Übersichtslisten'
        ]);
        self::generateTranslation('are_you_sure_rm_grp', [
            'de' => 'Sind Sie sicher, dass Sie diese Gruppe entfernen wollen?'
        ]);
        self::generateTranslation('are_you_sure_del_grp', [
            'de' => 'Sind Sie sicher, dass Sie diese Gruppe löschen wollen?'
        ]);
        self::generateTranslation('change_avatar', [
            'de' => 'Avatar ändern'
        ]);
        self::generateTranslation('change_bg', [
            'de' => 'Hintergrund ändern'
        ]);
        self::generateTranslation('uploaded_videos', [
            'de' => 'Hochgeladene Videos'
        ]);
        self::generateTranslation('video_playlists', [
            'de' => 'Video-Wiedergabelisten'
        ]);
        self::generateTranslation('add_contact_list', [
            'de' => 'Kontaktliste hinzufügen'
        ]);
        self::generateTranslation('topic_post', [
            'de' => 'Thema posten'
        ]);
        self::generateTranslation('invite', [
            'de' => 'Einladen'
        ]);
        self::generateTranslation('time_ago', [
            'de' => 'vor %s %s'
        ]);
        self::generateTranslation('from_now', [
            'de' => '%s %s ab jetzt'
        ]);
        self::generateTranslation('lang_has_been_activated', [
            'de' => 'Sprache wurde aktiviert'
        ]);
        self::generateTranslation('lang_has_been_deactivated', [
            'de' => 'Die Sprache wurde deaktiviert'
        ]);
        self::generateTranslation('lang_default_no_actions', [
            'de' => 'Die Sprache ist voreingestellt, so dass Sie keine Aktionen damit durchführen können'
        ]);
        self::generateTranslation('private_video_error', [
            'de' => 'Dieses Video ist privat, nur Freunde des Uploaders können dieses Video sehen'
        ]);
        self::generateTranslation('email_send_confirm', [
            'de' => 'Eine E-Mail wurde an unseren Webadministrator gesendet, wir werden Ihnen bald antworten'
        ]);
        self::generateTranslation('name_was_empty', [
            'de' => 'Name war leer'
        ]);
        self::generateTranslation('invalid_email', [
            'de' => 'Ungültige E-Mail'
        ]);
        self::generateTranslation('pelase_enter_reason', [
            'de' => 'Grund'
        ]);
        self::generateTranslation('please_enter_something_for_message', [
            'de' => 'Bitte geben Sie etwas in das Nachrichtenfeld ein'
        ]);
        self::generateTranslation('comm_disabled_for_vid', [
            'de' => 'Kommentare deaktiviert für dieses Video'
        ]);
        self::generateTranslation('coments_disabled_profile', [
            'de' => 'Kommentare deaktiviert für dieses Profil'
        ]);
        self::generateTranslation('file_size_exceeds', [
            'de' => 'Dateigröße überschreitet \'%s kbs\''
        ]);
        self::generateTranslation('vid_rate_disabled', [
            'de' => 'Videobewertung ist deaktiviert'
        ]);
        self::generateTranslation('chane_lang', [
            'de' => '- Sprache ändern -'
        ]);
        self::generateTranslation('recent', [
            'de' => 'Neueste'
        ]);
        self::generateTranslation('viewed', [
            'de' => 'Gesehen'
        ]);
        self::generateTranslation('top_rated', [
            'de' => 'Top bewertet'
        ]);
        self::generateTranslation('commented', [
            'de' => 'Kommentiert'
        ]);
        self::generateTranslation('searching_keyword_in_obj', [
            'de' => 'Suche nach \'%s\' in %s'
        ]);
        self::generateTranslation('no_results_found', [
            'de' => 'Keine Ergebnisse gefunden'
        ]);
        self::generateTranslation('please_enter_val_bw_min_max', [
            'de' => 'Bitte geben Sie den Wert \'%s\' zwischen \'%s\' und \'%s\' ein'
        ]);
        self::generateTranslation('no_new_subs_video', [
            'de' => 'Keine neuen Videos in Abonnements gefunden'
        ]);
        self::generateTranslation('inapp_content', [
            'de' => 'Ungeeigneter Inhalt'
        ]);
        self::generateTranslation('copyright_infring', [
            'de' => 'Verletzung des Urheberrechts'
        ]);
        self::generateTranslation('sexual_content', [
            'de' => 'Sexuelle Inhalte'
        ]);
        self::generateTranslation('violence_replusive_content', [
            'de' => 'Gewalttätige oder abstoßende Inhalte'
        ]);
        self::generateTranslation('disturbing', [
            'de' => 'Beunruhigend'
        ]);
        self::generateTranslation('other', [
            'de' => 'Andere'
        ]);
        self::generateTranslation('pending_requests', [
            'de' => 'Schwebende Anfragen'
        ]);
        self::generateTranslation('friend_add_himself_error', [
            'de' => 'Sie können sich nicht als Freund hinzufügen'
        ]);
        self::generateTranslation('contact_us_msg', [
            'de' => 'Ihre Anmerkungen sind uns wichtig und wir werden sie so schnell wie möglich bearbeiten. Die Angabe der in diesem Formular angeforderten Informationen ist freiwillig. Die Informationen werden gesammelt, um zusätzliche, von Ihnen angeforderte Informationen bereitzustellen und uns dabei zu helfen, unsere Dienstleistungen zu verbessern.'
        ]);
        self::generateTranslation('failed', [
            'de' => 'Fehlgeschlagen'
        ]);
        self::generateTranslation('required_fields', [
            'de' => 'Erforderliche Felder'
        ]);
        self::generateTranslation('more_fields', [
            'de' => 'Weitere Felder'
        ]);
        self::generateTranslation('remote_upload_file', [
            'de' => 'Hochladen der Datei <span id=\\\"remoteFileName\\\"></span>, bitte warten…'
        ]);
        self::generateTranslation('please_enter_remote_file_url', [
            'de' => 'Bitte geben Sie die URL der entfernten Datei ein'
        ]);
        self::generateTranslation('remoteDownloadStatusDiv', [
            'de' => '<div class=\"remoteDownloadStatus\" id=\"remoteDownloadStatus\" >Heruntergeladen \r\n <span id=\"status\">-- of --</span> @ \r\n <span id=\"dspeed\">-- Kpbs</span>, EST \r\n <span id=\"eta\">--:--</span>, Time took \r\n <span id=\"time_took\">--:--</span>\r\n            </div>'
        ]);
        self::generateTranslation('upload_data_now', [
            'de' => 'Daten jetzt hochladen!'
        ]);
        self::generateTranslation('save_data', [
            'de' => 'Daten speichern'
        ]);
        self::generateTranslation('saving', [
            'de' => 'Speichern...'
        ]);
        self::generateTranslation('upload_file', [
            'de' => 'Datei hochladen'
        ]);
        self::generateTranslation('grab_from_youtube', [
            'de' => 'Von Youtube holen'
        ]);
        self::generateTranslation('upload_video_button', [
            'de' => 'Videos durchsuchen'
        ]);
        self::generateTranslation('upload_videos_can_be', [
            'de' => '<span style=\\\"font-weight: bold; font-size: 13px;\\\">Videos können sein</span><ul><li>High Definition</li><li>Bis zur Größe von %s </li><li>Bis zur Dauer von %s</li><li>Eine große Vielfalt an Formaten</li></ul>'
        ]);
        self::generateTranslation('photo_not_exist', [
            'de' => 'Das Foto existiert nicht.'
        ]);
        self::generateTranslation('photo_success_deleted', [
            'de' => 'Das Foto wurde erfolgreich gelöscht.'
        ]);
        self::generateTranslation('cant_edit_photo', [
            'de' => 'Sie können dieses Foto nicht bearbeiten.'
        ]);
        self::generateTranslation('you_hv_already_rated_photo', [
            'de' => 'Sie haben dieses Foto bereits bewertet.'
        ]);
        self::generateTranslation('photo_rate_disabled', [
            'de' => 'Fotobewertung ist deaktiviert.'
        ]);
        self::generateTranslation('need_photo_details', [
            'de' => 'Sie benötigen Fotodetails.'
        ]);
        self::generateTranslation('embedding_is_disabled', [
            'de' => 'Das Einbetten ist vom Benutzer deaktiviert.'
        ]);
        self::generateTranslation('photo_activated', [
            'de' => 'Foto ist aktiviert.'
        ]);
        self::generateTranslation('photo_deactivated', [
            'de' => 'Foto ist deaktiviert.'
        ]);
        self::generateTranslation('photo_featured', [
            'de' => 'Foto ist als „empfohlen“ markiert.'
        ]);
        self::generateTranslation('photo_unfeatured', [
            'de' => 'Das Foto ist nicht als „empfohlen“ markiert.'
        ]);
        self::generateTranslation('photo_updated_successfully', [
            'de' => 'Foto wurde erfolgreich aktualisiert.'
        ]);
        self::generateTranslation('success_delete_file', [
            'de' => '%s Dateien wurden erfolgreich gelöscht.'
        ]);
        self::generateTranslation('no_watermark_found', [
            'de' => 'Wasserzeichendatei kann nicht gefunden werden.'
        ]);
        self::generateTranslation('watermark_updated', [
            'de' => 'Wasserzeichen wird aktualisiert'
        ]);
        self::generateTranslation('upload_png_watermark', [
            'de' => 'Bitte laden Sie eine 24-Bit PNG-Datei hoch.'
        ]);
        self::generateTranslation('photo_non_readable', [
            'de' => 'Das Foto ist nicht lesbar.'
        ]);
        self::generateTranslation('wrong_mime_type', [
            'de' => 'Falscher MIME-Typ angegeben.'
        ]);
        self::generateTranslation('you_dont_have_photos', [
            'de' => 'Sie haben keine Fotos'
        ]);
        self::generateTranslation('you_dont_have_fav_photos', [
            'de' => 'Sie haben keine Lieblingsfotos'
        ]);
        self::generateTranslation('manage_orphan_photos', [
            'de' => 'Verwaiste Fotos verwalten'
        ]);
        self::generateTranslation('manage_favorite_photos', [
            'de' => 'Verwalten von Favoritenfotos'
        ]);
        self::generateTranslation('manage_photos', [
            'de' => 'Verwalten Sie Fotos'
        ]);
        self::generateTranslation('you_dont_have_orphan_photos', [
            'de' => 'Sie haben keine verwaisten Fotos'
        ]);
        self::generateTranslation('item_not_exist', [
            'de' => 'Das Objekt existiert nicht.'
        ]);
        self::generateTranslation('collection_not_exist', [
            'de' => 'Sammlung existiert nicht'
        ]);
        self::generateTranslation('selected_collects_del', [
            'de' => 'Ausgewählte Sammlungen wurden gelöscht.'
        ]);
        self::generateTranslation('manage_collections', [
            'de' => 'Sammlungen verwalten'
        ]);
        self::generateTranslation('manage_categories', [
            'de' => 'Kategorien verwalten'
        ]);
        self::generateTranslation('flagged_collections', [
            'de' => 'Markierte Sammlungen'
        ]);
        self::generateTranslation('create_collection', [
            'de' => 'Sammlung erstellen'
        ]);
        self::generateTranslation('selected_items_removed', [
            'de' => 'Ausgewählte %s wurden entfernt.'
        ]);
        self::generateTranslation('edit_collection', [
            'de' => 'Sammlung bearbeiten'
        ]);
        self::generateTranslation('manage_collection_items', [
            'de' => 'Sammlungselemente verwalten'
        ]);
        self::generateTranslation('manage_favorite_collections', [
            'de' => 'Favorisierte Sammlungen verwalten'
        ]);
        self::generateTranslation('total_fav_collection_removed', [
            'de' => '%s Sammlungen wurden aus den Favoriten entfernt.'
        ]);
        self::generateTranslation('total_photos_deleted', [
            'de' => '%s Fotos wurden erfolgreich gelöscht.'
        ]);
        self::generateTranslation('total_fav_photos_removed', [
            'de' => '%s Fotos wurden aus den Favoriten entfernt.'
        ]);
        self::generateTranslation('photos_upload', [
            'de' => 'Foto Hochladen'
        ]);
        self::generateTranslation('no_items_found_in_collect', [
            'de' => 'Kein Element in dieser Sammlung gefunden'
        ]);
        self::generateTranslation('manage_items', [
            'de' => 'Verwalten von Objekten'
        ]);
        self::generateTranslation('add_new_collection', [
            'de' => 'Neue Sammlung hinzufügen'
        ]);
        self::generateTranslation('update_collection', [
            'de' => 'Sammlung aktualisieren'
        ]);
        self::generateTranslation('update_photo', [
            'de' => 'Foto aktualisieren'
        ]);
        self::generateTranslation('no_collection_found', [
            'de' => 'Sie haben noch keine Sammlung'
        ]);
        self::generateTranslation('photo_title', [
            'de' => 'Foto-Titel'
        ]);
        self::generateTranslation('photo_caption', [
            'de' => 'Bildunterschrift'
        ]);
        self::generateTranslation('photo_tags', [
            'de' => 'Foto-Tags'
        ]);
        self::generateTranslation('collection', [
            'de' => 'Sammlung'
        ]);
        self::generateTranslation('photo', [
            'de' => 'Foto'
        ]);
        self::generateTranslation('video', [
            'de' => 'Video'
        ]);
        self::generateTranslation('pic_allow_embed', [
            'de' => 'Fotoeinbettung aktivieren'
        ]);
        self::generateTranslation('pic_dallow_embed', [
            'de' => 'Einbettung von Fotos deaktivieren'
        ]);
        self::generateTranslation('pic_allow_rating', [
            'de' => 'Fotobewertung einschalten'
        ]);
        self::generateTranslation('pic_dallow_rating', [
            'de' => 'Fotobewertung deaktivieren'
        ]);
        self::generateTranslation('add_more', [
            'de' => 'Mehr hinzufügen'
        ]);
        self::generateTranslation('collect_name_er', [
            'de' => 'Sammlungsname ist leer'
        ]);
        self::generateTranslation('collect_descp_er', [
            'de' => 'Sammlungsbeschreibung ist leer'
        ]);
        self::generateTranslation('collect_tag_er', [
            'de' => 'Tags der Sammlung sind leer'
        ]);
        self::generateTranslation('collect_cat_er', [
            'de' => 'Sammlungskategorie auswählen'
        ]);
        self::generateTranslation('collect_borad_pub', [
            'de' => 'Sammlung öffentlich machen'
        ]);
        self::generateTranslation('collect_allow_public_up', [
            'de' => 'Öffentlicher Upload'
        ]);
        self::generateTranslation('collect_pub_up_dallow', [
            'de' => 'Anderen Benutzern das Hinzufügen von Objekten verweigern.'
        ]);
        self::generateTranslation('collect_pub_up_allow', [
            'de' => 'Anderen Benutzern das Hinzufügen von Objekten erlauben.'
        ]);
        self::generateTranslation('collection_name', [
            'de' => 'Name der Sammlung'
        ]);
        self::generateTranslation('collection_description', [
            'de' => 'Beschreibung der Sammlung'
        ]);
        self::generateTranslation('collection_tags', [
            'de' => 'Tags der Sammlung'
        ]);
        self::generateTranslation('collect_category', [
            'de' => 'Kategorie der Sammlung'
        ]);
        self::generateTranslation('collect_added_msg', [
            'de' => 'Sammlung wurde hinzugefügt'
        ]);
        self::generateTranslation('collect_not_exist', [
            'de' => 'Sammlung existiert nicht'
        ]);
        self::generateTranslation('no_upload_opt', [
            'de' => 'Keine Hochladeoption für {title} erlaubt, bitte kontaktieren Sie den Administrator der Website.'
        ]);
        self::generateTranslation('photos', [
            'de' => 'Fotos'
        ]);
        self::generateTranslation('cat_all', [
            'de' => 'Alle'
        ]);
        self::generateTranslation('upload_desktop_msg', [
            'de' => 'Laden Sie Videos direkt von Ihrem Desktop hoch und teilen Sie sie online mit unserer Community '
        ]);
        self::generateTranslation('upload_remote_video_msg', [
            'de' => 'Laden Sie Videos von anderen Websites oder Servern hoch. Geben Sie einfach die URL ein und klicken Sie auf Hochladen oder geben Sie die Youtube-Url ein und klicken Sie auf Von Youtube holen, um das Video direkt von Youtube hochzuladen, ohne die Details einzugeben.'
        ]);
        self::generateTranslation('embed_video_msg', [
            'de' => 'Videos von anderen Websites mit deren \"Videoeinbettungscode\" einbetten, einfach den Einbettungscode eingeben, die Videodauer eingeben und den Thumb auswählen, die erforderlichen Angaben machen und auf Hochladen klicken.'
        ]);
        self::generateTranslation('link_video_msg', [
            'de' => 'Wenn Sie ein Video hochladen möchten, ohne auf die Upload- und Verarbeitungsphase warten zu müssen, geben Sie einfach Ihre Video-URL zusammen mit einigen anderen Details hier ein und genießen Sie es.'
        ]);
        self::generateTranslation('browse_photos', [
            'de' => 'Fotos durchsuchen'
        ]);
        self::generateTranslation('photo_is_saved_now', [
            'de' => 'Fotosammlung wurde gespeichert'
        ]);
        self::generateTranslation('photo_success_heading', [
            'de' => 'Die Fotosammlung wurde erfolgreich aktualisiert'
        ]);
        self::generateTranslation('share_embed', [
            'de' => 'Freigegeben / Eingebettet'
        ]);
        self::generateTranslation('item_added_in_collection', [
            'de' => '%s erfolgreich in Sammlung aufgenommen.'
        ]);
        self::generateTranslation('object_exists_collection', [
            'de' => '%s existieren bereits in der Sammlung.'
        ]);
        self::generateTranslation('collect_tag_hint', [
            'de' => 'alpha bravo charlie, ptv klassiker, hasb-e-haal'
        ]);
        self::generateTranslation('collect_broad_pri', [
            'de' => 'Sammlung privat machen'
        ]);
        self::generateTranslation('collect_item_removed', [
            'de' => '%s wurde aus der Sammlung entfernt.'
        ]);
        self::generateTranslation('most_downloaded', [
            'de' => 'Meist heruntergeladen'
        ]);
        self::generateTranslation('total_videos', [
            'de' => 'Videos insgesamt'
        ]);
        self::generateTranslation('collection_featured', [
            'de' => 'Sammlung „Empfohlen“.'
        ]);
        self::generateTranslation('collection_unfeatured', [
            'de' => 'Sammlung „Nicht empfohlen“.'
        ]);
        self::generateTranslation('upload_right_guide_photo', [
            'de' => '<strong>Wichtig! Laden Sie keine Fotos hoch, die als Obszönität, urheberrechtlich geschütztes Material, Belästigung oder Spam aufgefasst werden können.</strong> \r\n<p>Indem Sie mit \"Dein Hochladen\" fortfahren, erklären Sie, dass diese Fotos nicht gegen die <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Nutzungsbedingungen</span></a> unserer Website verstoßen und dass Sie alle Urheberrechte an diesen Fotos besitzen oder die Erlaubnis haben, sie hochzuladen. </p>'
        ]);
        self::generateTranslation('upload_right_guide_vid', [
            'de' => '<strong>Wichtig! Laden Sie keine Videos hoch, die als Obszönität, urheberrechtlich geschütztes Material, Belästigung oder Spam aufgefasst werden können.</strong> \r\n<p>Indem Sie mit \"Dein Hochladen\" fortfahren, erklären Sie, dass diese Videos nicht gegen die <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Nutzungsbedingungen</span></a> unserer Website verstoßen und dass Sie alle Urheberrechte an diesen Videos besitzen oder die Erlaubnis haben, sie hochzuladen. </p>'
        ]);
        self::generateTranslation('collection_deactivated', [
            'de' => 'Sammlung deaktiviert.'
        ]);
        self::generateTranslation('collection_activated', [
            'de' => 'Sammlung aktiviert.'
        ]);
        self::generateTranslation('collection_updated', [
            'de' => 'Sammlung aktualisiert.'
        ]);
        self::generateTranslation('cant_edit_collection', [
            'de' => 'Sie können diese Sammlung nicht bearbeiten'
        ]);
        self::generateTranslation('object_not_in_collect', [
            'de' => '%s existiert nicht in dieser Sammlung'
        ]);
        self::generateTranslation('object_does_not_exists', [
            'de' => '%s existiert nicht.'
        ]);
        self::generateTranslation('cant_perform_action_collect', [
            'de' => 'Sie können solche Aktionen für diese Sammlung nicht durchführen.'
        ]);
        self::generateTranslation('collection_deleted', [
            'de' => 'Sammlung erfolgreich gelöscht.'
        ]);
        self::generateTranslation('collection_not_exists', [
            'de' => 'Die Sammlung existiert nicht.'
        ]);
        self::generateTranslation('collect_items_deleted', [
            'de' => 'Sammlungselemente erfolgreich gelöscht.'
        ]);
        self::generateTranslation('photo_title_err', [
            'de' => 'Bitte geben Sie einen gültigen Fototitel ein'
        ]);
        self::generateTranslation('rand_photos', [
            'de' => 'Zufällige Fotos'
        ]);
        self::generateTranslation('this_has_set_profile_item', [
            'de' => 'Dieses %s wurde als Ihr Profilelement festgelegt'
        ]);
        self::generateTranslation('profile_item_removed', [
            'de' => 'Profileintrag wurde entfernt'
        ]);
        self::generateTranslation('make_profile_item', [
            'de' => 'Profileintrag erstellen'
        ]);
        self::generateTranslation('remove_profile_item', [
            'de' => 'Profileintrag entfernen'
        ]);
        self::generateTranslation('content_type_empty', [
            'de' => 'Inhaltstyp ist leer. Bitte teilen Sie uns mit, welche Art von Inhalt Sie wünschen.'
        ]);
        self::generateTranslation('watch_video_page', [
            'de' => 'Auf Videoseite ansehen'
        ]);
        self::generateTranslation('watch_on_photo_page', [
            'de' => 'Dies auf der Fotoseite ansehen'
        ]);
        self::generateTranslation('found_no_videos', [
            'de' => 'Keine Videos gefunden'
        ]);
        self::generateTranslation('found_no_photos', [
            'de' => 'Keine Fotos gefunden'
        ]);
        self::generateTranslation('collections', [
            'de' => 'Sammlungen'
        ]);
        self::generateTranslation('related_videos', [
            'de' => 'Verwandte Videos'
        ]);
        self::generateTranslation('this_video_found_in_no_collection', [
            'de' => 'Dieses Video ist in folgenden Sammlungen zu finden'
        ]);
        self::generateTranslation('more_from', [
            'de' => 'Mehr von %s'
        ]);
        self::generateTranslation('this_collection', [
            'de' => 'Sammlung : %s'
        ]);
        self::generateTranslation('vdo_broadcast_unlisted', [
            'de' => 'Nicht aufgelistet (jeder mit dem Link und/oder Passwort kann es sehen)'
        ]);
        self::generateTranslation('video_link', [
            'de' => 'Video-Link'
        ]);
        self::generateTranslation('channel_settings', [
            'de' => 'Kanal-Einstellungen'
        ]);
        self::generateTranslation('channel_account_settings', [
            'de' => 'Kanal- und Kontoeinstellungen'
        ]);
        self::generateTranslation('account_settings', [
            'de' => 'Konto-Einstellungen'
        ]);
        self::generateTranslation('allow_subscription', [
            'de' => 'Abonnement zulassen'
        ]);
        self::generateTranslation('allow_subscription_hint', [
            'de' => 'Erlauben Sie Mitgliedern, Ihren Kanal zu abonnieren?'
        ]);
        self::generateTranslation('channel_title', [
            'de' => 'Titel des Kanals'
        ]);
        self::generateTranslation('channel_desc', [
            'de' => 'Beschreibung des Kanals'
        ]);
        self::generateTranslation('show_my_friends', [
            'de' => 'Meine Freunde anzeigen'
        ]);
        self::generateTranslation('show_my_videos', [
            'de' => 'Meine Videos anzeigen'
        ]);
        self::generateTranslation('show_my_photos', [
            'de' => 'Meine Fotos anzeigen'
        ]);
        self::generateTranslation('show_my_subscriptions', [
            'de' => 'Meine Abonnements anzeigen'
        ]);
        self::generateTranslation('show_my_subscribers', [
            'de' => 'Meine Abonnenten anzeigen'
        ]);
        self::generateTranslation('profile_basic_info', [
            'de' => 'Grundlegende Informationen'
        ]);
        self::generateTranslation('profile_education_interests', [
            'de' => 'Ausbildung, Hobbys, etc.'
        ]);
        self::generateTranslation('channel_profile_settings', [
            'de' => 'Kanal- und Profileinstellungen'
        ]);
        self::generateTranslation('show_my_collections', [
            'de' => 'Meine Sammlungen anzeigen'
        ]);
        self::generateTranslation('user_doesnt_any_collection', [
            'de' => 'Der Benutzer hat keine Sammlungen.'
        ]);
        self::generateTranslation('unsubscribe', [
            'de' => 'Abbestellen'
        ]);
        self::generateTranslation('you_have_already_voted_channel', [
            'de' => 'Du hast bereits für diesen Kanal gestimmt'
        ]);
        self::generateTranslation('channel_rating_disabled', [
            'de' => 'Channel-Voting ist deaktiviert'
        ]);
        self::generateTranslation('user_activity', [
            'de' => 'Benutzer-Aktivität'
        ]);
        self::generateTranslation('you_cant_view_profile', [
            'de' => 'Du hast keine Berechtigung, diesen Channel zu sehen :/'
        ]);
        self::generateTranslation('only_friends_view_channel', [
            'de' => 'Nur die Freunde von %s können diesen Kanal sehen'
        ]);
        self::generateTranslation('collect_type', [
            'de' => 'Typ der Sammlung'
        ]);
        self::generateTranslation('add_to_my_collection', [
            'de' => 'Zu meiner Sammlung hinzufügen'
        ]);
        self::generateTranslation('total_collections', [
            'de' => 'Sammlungen insgesamt'
        ]);
        self::generateTranslation('total_photos', [
            'de' => 'Fotos insgesamt'
        ]);
        self::generateTranslation('comments_made', [
            'de' => 'Erstellte Kommentare'
        ]);
        self::generateTranslation('block_users', [
            'de' => 'Benutzer sperren'
        ]);
        self::generateTranslation('tp_del_confirm', [
            'de' => 'Sind Sie sicher, dass Sie dieses Thema löschen möchten?'
        ]);
        self::generateTranslation('you_need_owners_approval_to_view_group', [
            'de' => 'Sie benötigen die Genehmigung des Eigentümers, um diese Gruppe zu sehen'
        ]);
        self::generateTranslation('you_cannot_rate_own_collection', [
            'de' => 'Sie können Ihre eigene Sammlung nicht bewerten'
        ]);
        self::generateTranslation('collection_rating_not_allowed', [
            'de' => 'Sammlungsbewertung ist jetzt erlaubt'
        ]);
        self::generateTranslation('you_cant_rate_own_video', [
            'de' => 'Sie können Ihr eigenes Video nicht bewerten'
        ]);
        self::generateTranslation('you_cant_rate_own_channel', [
            'de' => 'Sie können Ihren eigenen Kanal nicht bewerten'
        ]);
        self::generateTranslation('you_cannot_rate_own_photo', [
            'de' => 'Du kannst dein eigenes Foto nicht bewerten'
        ]);
        self::generateTranslation('cant_pm_banned_user', [
            'de' => 'Du kannst keine privaten Nachrichten an %s senden'
        ]);
        self::generateTranslation('you_are_not_allowed_to_view_user_channel', [
            'de' => 'Du darfst den Kanal von %s nicht sehen'
        ]);
        self::generateTranslation('you_cant_send_pm_yourself', [
            'de' => 'Du kannst keine privaten Nachrichten an dich selbst senden'
        ]);
        self::generateTranslation('please_enter_confimation_ode', [
            'de' => 'Bitte Verifizierungscode eingeben'
        ]);
        self::generateTranslation('vdo_brd_confidential', [
            'de' => 'Vertraulich (Nur für bestimmte Benutzer)'
        ]);
        self::generateTranslation('video_password', [
            'de' => 'Video-Kennwort'
        ]);
        self::generateTranslation('set_video_password', [
            'de' => 'Geben Sie das Passwort für das Video ein, um es \"passwortgeschützt\" zu machen.'
        ]);
        self::generateTranslation('video_pass_protected', [
            'de' => 'Dieses Video ist passwortgeschützt. Sie müssen ein gültiges Passwort eingeben, um das Video ansehen zu können.'
        ]);
        self::generateTranslation('please_enter_video_password', [
            'de' => 'Bitte geben Sie ein gültiges Passwort ein, um dieses Video anzusehen'
        ]);
        self::generateTranslation('video_is_password_protected', [
            'de' => '%s ist passwortgeschützt'
        ]);
        self::generateTranslation('invalid_video_password', [
            'de' => 'Ungültiges Video-Passwort'
        ]);
        self::generateTranslation('logged_users_only', [
            'de' => 'Nur eingeloggt (nur eingeloggte Benutzer können das Video ansehen)'
        ]);
        self::generateTranslation('specify_video_users', [
            'de' => 'Geben Sie den Benutzernamen ein, der dieses Video ansehen kann, getrennt durch ein Komma'
        ]);
        self::generateTranslation('video_users', [
            'de' => 'Video-Benutzer'
        ]);
        self::generateTranslation('not_logged_video_error', [
            'de' => 'Sie können dieses Video nicht sehen, weil Sie nicht angemeldet sind'
        ]);
        self::generateTranslation('no_user_subscribed_to_uploader', [
            'de' => 'Kein Benutzer hat %s abonniert'
        ]);
        self::generateTranslation('subs_email_sent_to_users', [
            'de' => 'Abonnement-E-Mail wurde an %s Benutzer%s gesendet'
        ]);
        self::generateTranslation('user_has_uploaded_new_photo', [
            'de' => '%s hat ein neues Foto hochgeladen'
        ]);
        self::generateTranslation('please_provide_valid_userid', [
            'de' => 'bitte gültige Benutzerkennung angeben'
        ]);
        self::generateTranslation('user_joined_us', [
            'de' => '%s ist %s beigetreten, sag\' Hallo zu %s'
        ]);
        self::generateTranslation('user_has_uploaded_new_video', [
            'de' => '%s hat ein neues Video hochgeladen'
        ]);
        self::generateTranslation('user_has_created_new_group', [
            'de' => '%s hat eine neue Gruppe erstellt'
        ]);
        self::generateTranslation('total_members', [
            'de' => 'Mitglieder insgesamt'
        ]);
        self::generateTranslation('watch_video', [
            'de' => 'Video ansehen'
        ]);
        self::generateTranslation('view_photo', [
            'de' => 'Foto ansehen'
        ]);
        self::generateTranslation('user_has_joined_group', [
            'de' => '%s ist einer neuen Gruppe beigetreten'
        ]);
        self::generateTranslation('user_is_now_friend_with_other', [
            'de' => '%s und %s sind jetzt Freunde'
        ]);
        self::generateTranslation('user_has_created_new_collection', [
            'de' => '%s hat eine neue Sammlung erstellt'
        ]);
        self::generateTranslation('view_collection', [
            'de' => 'Sammlung ansehen'
        ]);
        self::generateTranslation('user_has_favorited_video', [
            'de' => '%s hat ein Video zu den Favoriten hinzugefügt'
        ]);
        self::generateTranslation('activity', [
            'de' => 'Aktivität'
        ]);
        self::generateTranslation('no_activity', [
            'de' => '%s hat keine aktuelle Aktivität'
        ]);
        self::generateTranslation('feed_has_been_deleted', [
            'de' => 'Der Aktivitäts-Feed wurde gelöscht'
        ]);
        self::generateTranslation('you_cant_del_this_feed', [
            'de' => 'Sie können diesen Feed nicht löschen'
        ]);
        self::generateTranslation('you_cant_sub_yourself', [
            'de' => 'Sie können sich nicht selbst abonnieren'
        ]);
        self::generateTranslation('manage_my_album', [
            'de' => 'Mein Album verwalten'
        ]);
        self::generateTranslation('you_dont_have_permission_to_update_this_video', [
            'de' => 'Sie haben nicht die Erlaubnis, dieses Video zu aktualisieren'
        ]);
        self::generateTranslation('group_is_public', [
            'de' => 'Gruppe ist öffentlich'
        ]);
        self::generateTranslation('collection_thumb', [
            'de' => 'Sammlung thumb'
        ]);
        self::generateTranslation('collection_is_private', [
            'de' => 'Sammlung ist privat'
        ]);
        self::generateTranslation('edit_type_collection', [
            'de' => 'Bearbeitung von %s'
        ]);
        self::generateTranslation('comm_disabled_for_collection', [
            'de' => 'Kommentare deaktiviert für diese Sammlung'
        ]);
        self::generateTranslation('share_this_type', [
            'de' => 'Diese %s freigeben'
        ]);
        self::generateTranslation('seperate_usernames_with_comma', [
            'de' => 'Benutzernamen mit Komma trennen'
        ]);
        self::generateTranslation('view_all', [
            'de' => 'Alle anzeigen'
        ]);
        self::generateTranslation('album_privacy_updated', [
            'de' => 'Album Datenschutz wurde aktualisiert'
        ]);
        self::generateTranslation('you_dont_have_any_videos', [
            'de' => 'Sie haben keine Videos'
        ]);
        self::generateTranslation('update_blocked_use', [
            'de' => 'Die Liste der gesperrten Benutzer wurde aktualisiert'
        ]);
        self::generateTranslation('you_dont_have_fav_collections', [
            'de' => 'Sie haben keine Favoritensammlung'
        ]);
        self::generateTranslation('remote_play', [
            'de' => 'Entfernte Wiedergabe'
        ]);
        self::generateTranslation('remote_upload_example', [
            'de' => 'z.B. http://clipbucket.com/sample.flv https://www.youtube.com/watch?v=3Gi2xtnasoQ'
        ]);
        self::generateTranslation('update_blocked_user_list', [
            'de' => 'Liste der blockierten Benutzer aktualisieren'
        ]);
        self::generateTranslation('group_is_private', [
            'de' => 'Gruppe ist privat'
        ]);
        self::generateTranslation('no_user_associated_with_email', [
            'de' => 'Kein Benutzer ist mit dieser E-Mail-Adresse verbunden'
        ]);
        self::generateTranslation('pass_changed_success', [
            'de' => '<div class=\"simple_container\">\r\n    \t<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">Das Passwort wurde geändert, bitte prüfen Sie Ihre E-Mail</h2>   \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 11px;\">Ihr Passwort wurde erfolgreich geändert, bitte überprüfen Sie Ihren Posteingang auf das neu generierte Passwort. Sobald Sie sich einloggen, ändern Sie es bitte entsprechend, indem Sie zu Ihrem Konto gehen und auf Passwort ändern klicken.</p>\r\n </div>'
        ]);
        self::generateTranslation('add_as_friend', [
            'de' => 'Als Freund hinzufügen'
        ]);
        self::generateTranslation('block_user', [
            'de' => 'Benutzer blockieren'
        ]);
        self::generateTranslation('send_message', [
            'de' => 'Nachricht senden'
        ]);
        self::generateTranslation('no_item_was_selected_to_delete', [
            'de' => 'Kein Element zum Löschen ausgewählt'
        ]);
        self::generateTranslation('playlist_items_have_been_removed', [
            'de' => 'Elemente der Playlist entfernt'
        ]);
        self::generateTranslation('you_not_grp_mem_or_approved', [
            'de' => 'Sie sind dieser Gruppe nicht beigetreten oder ein zugelassenes Mitglied dieser Gruppe'
        ]);
        self::generateTranslation('no_playlist_was_selected_to_delete', [
            'de' => 'Wählen Sie zuerst eine Playlist aus.'
        ]);
        self::generateTranslation('featured_videos', [
            'de' => 'Empfohlene Videos'
        ]);
        self::generateTranslation('recent_videos', [
            'de' => 'Neueste Videos'
        ]);
        self::generateTranslation('featured_users', [
            'de' => 'Empfohlene Benutzer'
        ]);
        self::generateTranslation('top_collections', [
            'de' => 'Top-Sammlungen'
        ]);
        self::generateTranslation('top_playlists', [
            'de' => 'Top-Playlists'
        ]);
        self::generateTranslation('load_more', [
            'de' => 'Mehr laden'
        ]);
        self::generateTranslation('no_playlists', [
            'de' => 'Keine Wiedergabelisten gefunden'
        ]);
        self::generateTranslation('featured_photos', [
            'de' => 'Empfohlene Fotos'
        ]);
        self::generateTranslation('no_channel_found', [
            'de' => 'Kein Kanal gefunden'
        ]);
        self::generateTranslation('download', [
            'de' => 'Herunterladen'
        ]);
        self::generateTranslation('add_to', [
            'de' => 'Hinzufügen'
        ]);
        self::generateTranslation('player_size', [
            'de' => 'Player Größe'
        ]);
        self::generateTranslation('small', [
            'de' => 'Klein'
        ]);
        self::generateTranslation('medium', [
            'de' => 'Mittel'
        ]);
        self::generateTranslation('large', [
            'de' => 'Groß'
        ]);
        self::generateTranslation('iframe', [
            'de' => 'Iframe'
        ]);
        self::generateTranslation('embed_object', [
            'de' => 'Objekt einbetten'
        ]);
        self::generateTranslation('add_to_my_favorites', [
            'de' => 'Zu Favoriten hinzufügen'
        ]);
        self::generateTranslation('please_select_playlist', [
            'de' => 'Bitte wählen Sie den Namen der Wiedergabeliste aus'
        ]);
        self::generateTranslation('create_new_playlist', [
            'de' => 'Neue Wiedergabeliste erstellen'
        ]);
        self::generateTranslation('select_playlist', [
            'de' => 'Aus Wiedergabeliste auswählen'
        ]);
        self::generateTranslation('report_video', [
            'de' => 'Video melden'
        ]);
        self::generateTranslation('report_text', [
            'de' => 'Bitte wählen Sie die Kategorie aus, die am ehesten Ihre Bedenken bezüglich des Videos widerspiegelt, damit wir es überprüfen und feststellen können, ob es gegen unsere Community-Richtlinien verstößt oder nicht für alle Zuschauer geeignet ist. Der Missbrauch dieser Funktion ist ebenfalls ein Verstoß gegen die Community-Richtlinien, also tun Sie es nicht. '
        ]);
        self::generateTranslation('flag_video', [
            'de' => 'Dieses Video markieren'
        ]);
        self::generateTranslation('comment_as', [
            'de' => 'Kommentieren als'
        ]);
        self::generateTranslation('more_replies', [
            'de' => 'Mehr Antworten'
        ]);
        self::generateTranslation('photo_description', [
            'de' => 'Beschreibung des Fotos'
        ]);
        self::generateTranslation('flag', [
            'de' => 'Kennzeichnen'
        ]);
        self::generateTranslation('update_cover', [
            'de' => 'Cover aktualisieren'
        ]);
        self::generateTranslation('unfriend', [
            'de' => 'Entfreunden'
        ]);
        self::generateTranslation('accept_request', [
            'de' => 'Anfrage akzeptieren'
        ]);
        self::generateTranslation('online', [
            'de' => 'online'
        ]);
        self::generateTranslation('offline', [
            'de' => 'offline'
        ]);
        self::generateTranslation('upload_video', [
            'de' => 'Video hochladen'
        ]);
        self::generateTranslation('upload_photo', [
            'de' => 'Foto hochladen'
        ]);
        self::generateTranslation('upload_beats_guide', [
            'de' => '<strong>Wichtig! Laden Sie keine Audios hoch, die als Obszönität, urheberrechtlich geschütztes Material, Belästigung oder Spam ausgelegt werden können.</strong>\r\n<p>Indem Sie mit \"Ihr Upload\" fortfahren, erklären Sie, dass diese Audios nicht gegen die Nutzungsbedingungen unserer Website verstoßen und dass Sie alle Urheberrechte an diesen Audios besitzen oder berechtigt sind, sie hochzuladen.</p>'
        ]);
        self::generateTranslation('admin_area', [
            'de' => 'Verwaltungsbereich'
        ]);
        self::generateTranslation('view_channels', [
            'de' => 'Kanäle anzeigen'
        ]);
        self::generateTranslation('my_channel', [
            'de' => 'Mein Kanal'
        ]);
        self::generateTranslation('manage_videos', [
            'de' => 'Videos verwalten'
        ]);
        self::generateTranslation('cancel_request', [
            'de' => 'Anfrage abbrechen'
        ]);
        self::generateTranslation('contact', [
            'de' => 'Kontakt'
        ]);
        self::generateTranslation('no_featured_videos_found', [
            'de' => 'Keine empfohlenen Videos gefunden'
        ]);
        self::generateTranslation('no_recent_videos_found', [
            'de' => 'Keine neuen Videos gefunden'
        ]);
        self::generateTranslation('no_collection_found_alert', [
            'de' => 'Keine Sammlung gefunden! Sie müssen eine Sammlung erstellen, bevor Sie ein Foto hochladen können'
        ]);
        self::generateTranslation('select_collection_upload', [
            'de' => 'Sammlung auswählen'
        ]);
        self::generateTranslation('no_collection_upload', [
            'de' => 'Keine Sammlung gefunden'
        ]);
        self::generateTranslation('create_new_collection_btn', [
            'de' => 'Neue Sammlung erstellen'
        ]);
        self::generateTranslation('photo_upload_tab', [
            'de' => 'Foto hochladen'
        ]);
        self::generateTranslation('no_videos_found', [
            'de' => 'Keine Videos gefunden!'
        ]);
        self::generateTranslation('Latest_Videos', [
            'de' => 'Neueste Videos'
        ]);
        self::generateTranslation('videos_details', [
            'de' => 'Details zu den Videos'
        ]);
        self::generateTranslation('option', [
            'de' => 'Option'
        ]);
        self::generateTranslation('flagged_obj', [
            'de' => 'Markierte Objekte'
        ]);
        self::generateTranslation('watched', [
            'de' => 'Gesehen'
        ]);
        self::generateTranslation('since', [
            'de' => 'seit'
        ]);
        self::generateTranslation('last_Login', [
            'de' => 'Letzte Anmeldung'
        ]);
        self::generateTranslation('no_friends_in_list', [
            'de' => 'Sie haben keine Freunde in Ihrer Liste'
        ]);
        self::generateTranslation('no_pending_friend', [
            'de' => 'Keine ausstehenden Freundschaftsanfragen'
        ]);
        self::generateTranslation('hometown', [
            'de' => 'Heimatstadt'
        ]);
        self::generateTranslation('city', [
            'de' => 'Stadt'
        ]);
        self::generateTranslation('schools', [
            'de' => 'Schulen'
        ]);
        self::generateTranslation('occupation', [
            'de' => 'Beruf'
        ]);
        self::generateTranslation('you_dont_have_videos', [
            'de' => 'Sie haben keine Videos'
        ]);
        self::generateTranslation('write_msg', [
            'de' => 'Nachricht schreiben'
        ]);
        self::generateTranslation('content', [
            'de' => 'Inhalt'
        ]);
        self::generateTranslation('no_video', [
            'de' => 'Kein Video'
        ]);
        self::generateTranslation('back_to_collection', [
            'de' => 'Zurück zur Sammlung'
        ]);
        self::generateTranslation('long_txt', [
            'de' => 'Alle hochgeladenen Fotos sind von ihren Sammlungen/Alben abhängig. Wenn Sie ein Foto aus einer Sammlung/einem Album entfernen, wird das Foto nicht endgültig gelöscht. Das Foto wird hierher verschoben. Sie können dies auch nutzen, um Ihre Fotos privat zu machen. Ein direkter Link steht Ihnen zur Verfügung, um sie mit Ihren Freunden zu teilen.'
        ]);
        self::generateTranslation('make_my_album', [
            'de' => 'Mein Album veröffentlichen'
        ]);
        self::generateTranslation('public', [
            'de' => 'öffentlich'
        ]);
        self::generateTranslation('private', [
            'de' => 'Privat'
        ]);
        self::generateTranslation('for_friends', [
            'de' => 'Für Freunde'
        ]);
        self::generateTranslation('submit_now', [
            'de' => 'Jetzt einreichen'
        ]);
        self::generateTranslation('drag_drop', [
            'de' => 'Dateien hierher ziehen & ablegen'
        ]);
        self::generateTranslation('upload_more_videos', [
            'de' => 'Weitere Videos hochladen'
        ]);
        self::generateTranslation('selected_files', [
            'de' => 'Ausgewählte Dateien'
        ]);
        self::generateTranslation('upload_in_progress', [
            'de' => 'Hochladen im Gange'
        ]);
        self::generateTranslation('complete_of_video', [
            'de' => 'Video abschließen'
        ]);
        self::generateTranslation('playlist_videos', [
            'de' => 'Wiedergabeliste Videos'
        ]);
        self::generateTranslation('popular_videos', [
            'de' => 'Beliebte Videos'
        ]);
        self::generateTranslation('uploading', [
            'de' => 'Hochladen'
        ]);
        self::generateTranslation('select_photos', [
            'de' => 'Fotos auswählen'
        ]);
        self::generateTranslation('uploading_in_progress', [
            'de' => 'Hochladen im Gange '
        ]);
        self::generateTranslation('complete_of_photo', [
            'de' => 'Foto fertigstellen'
        ]);
        self::generateTranslation('upload_more_photos', [
            'de' => 'Weitere Fotos hochladen'
        ]);
        self::generateTranslation('save_details', [
            'de' => 'Details speichern'
        ]);
        self::generateTranslation('related_photos', [
            'de' => 'Verwandte Fotos'
        ]);
        self::generateTranslation('no_photos_found', [
            'de' => 'Keine Fotos gefunden!'
        ]);
        self::generateTranslation('search_keyword_feed', [
            'de' => 'Suchbegriff hier eingeben'
        ]);
        self::generateTranslation('contacts_manager', [
            'de' => 'Kontakte Manager'
        ]);
        self::generateTranslation('weak_pass', [
            'de' => 'Passwort ist schwach'
        ]);
        self::generateTranslation('create_account_msg', [
            'de' => 'Melden Sie sich an, um Videos und Fotos auszutauschen. Es dauert nur ein paar Minuten, um Ihr kostenloses Konto zu erstellen'
        ]);
        self::generateTranslation('get_your_account', [
            'de' => 'Konto erstellen'
        ]);
        self::generateTranslation('type_password_here', [
            'de' => 'Passwort eingeben'
        ]);
        self::generateTranslation('type_username_here', [
            'de' => 'Benutzernamen eingeben'
        ]);
        self::generateTranslation('terms_of_service', [
            'de' => 'Nutzungsbedingungen'
        ]);
        self::generateTranslation('upload_vid_thumb_msg', [
            'de' => 'Thumbs erfolgreich hochgeladen'
        ]);
        self::generateTranslation('agree', [
            'de' => 'Ich stimme zu'
        ]);
        self::generateTranslation('terms', [
            'de' => 'Nutzungsbedingungen'
        ]);
        self::generateTranslation('and', [
            'de' => 'und'
        ]);
        self::generateTranslation('policy', [
            'de' => 'Datenschutzbestimmungen'
        ]);
        self::generateTranslation('watch', [
            'de' => 'ansehen'
        ]);
        self::generateTranslation('edit_video', [
            'de' => 'Bearbeiten'
        ]);
        self::generateTranslation('del_video', [
            'de' => 'löschen'
        ]);
        self::generateTranslation('successful', [
            'de' => 'Erfolgreich'
        ]);
        self::generateTranslation('processing', [
            'de' => 'Bearbeitung'
        ]);
        self::generateTranslation('last_one', [
            'de' => 'aye'
        ]);
        self::generateTranslation('creating_collection_is_disabled', [
            'de' => 'Sammlung erstellen ist deaktiviert'
        ]);
        self::generateTranslation('creating_playlist_is_disabled', [
            'de' => 'Erstellen von Wiedergabelisten ist deaktiviert'
        ]);
        self::generateTranslation('inactive', [
            'de' => 'Inaktiv'
        ]);
        self::generateTranslation('vdo_actions', [
            'de' => 'Aktionen'
        ]);
        self::generateTranslation('view_ph', [
            'de' => 'Ansicht'
        ]);
        self::generateTranslation('edit_ph', [
            'de' => 'Bearbeiten'
        ]);
        self::generateTranslation('delete_ph', [
            'de' => 'Löschen'
        ]);
        self::generateTranslation('title_ph', [
            'de' => 'Titel'
        ]);
        self::generateTranslation('view_edit_playlist', [
            'de' => 'Betrachten/Bearbeiten'
        ]);
        self::generateTranslation('no_playlist_found', [
            'de' => 'Keine Wiedergabeliste gefunden'
        ]);
        self::generateTranslation('playlist_owner', [
            'de' => 'Eigentümer'
        ]);
        self::generateTranslation('playlist_privacy', [
            'de' => 'Datenschutz'
        ]);
        self::generateTranslation('add_to_collection', [
            'de' => 'Zur Sammlung hinzufügen'
        ]);
        self::generateTranslation('video_added_to_playlist', [
            'de' => 'Dieses Video wurde zur Wiedergabeliste hinzugefügt'
        ]);
        self::generateTranslation('subscribe_btn', [
            'de' => 'abonnieren'
        ]);
        self::generateTranslation('report_usr', [
            'de' => 'melden'
        ]);
        self::generateTranslation('un_reg_user', [
            'de' => 'Unregistrierter Benutzer'
        ]);
        self::generateTranslation('my_playlists', [
            'de' => 'Meine Wiedergabelisten'
        ]);
        self::generateTranslation('play', [
            'de' => 'Jetzt abspielen'
        ]);
        self::generateTranslation('no_vid_in_playlist', [
            'de' => 'Kein Video in dieser Wiedergabeliste gefunden!'
        ]);
        self::generateTranslation('website_offline', [
            'de' => 'ACHTUNG: DIESE WEBSITE IST IM OFFLINE-MODUS'
        ]);
        self::generateTranslation('loading', [
            'de' => 'Laden'
        ]);
        self::generateTranslation('hour', [
            'de' => 'Stunde'
        ]);
        self::generateTranslation('hours', [
            'de' => 'Stunden'
        ]);
        self::generateTranslation('day', [
            'de' => 'Tag'
        ]);
        self::generateTranslation('days', [
            'de' => 'Tage'
        ]);
        self::generateTranslation('week', [
            'de' => 'Woche'
        ]);
        self::generateTranslation('weeks', [
            'de' => 'Wochen'
        ]);
        self::generateTranslation('month', [
            'de' => 'Monat'
        ]);
        self::generateTranslation('months', [
            'de' => 'Monate'
        ]);
        self::generateTranslation('year', [
            'de' => 'Jahr'
        ]);
        self::generateTranslation('years', [
            'de' => 'Jahre'
        ]);
        self::generateTranslation('decade', [
            'de' => 'Jahrzehnt'
        ]);
        self::generateTranslation('decades', [
            'de' => 'Jahrzehnte'
        ]);
        self::generateTranslation('your_name', [
            'de' => 'Dein Name'
        ]);
        self::generateTranslation('your_email', [
            'de' => 'Deine E-Mail'
        ]);
        self::generateTranslation('type_comment_box', [
            'de' => 'Bitte geben Sie etwas in das Kommentarfeld ein'
        ]);
        self::generateTranslation('guest', [
            'de' => 'Gast'
        ]);
        self::generateTranslation('anonymous', [
            'de' => 'Anonym'
        ]);
        self::generateTranslation('no_comment_added', [
            'de' => 'Keine Kommentare hinzugefügt'
        ]);
        self::generateTranslation('register_min_age_request', [
            'de' => 'Du musst mindestens %s Jahre alt sein, um dich zu registrieren'
        ]);
        self::generateTranslation('select_category', [
            'de' => 'Bitte wähle deine Kategorie'
        ]);
        self::generateTranslation('custom', [
            'de' => 'benutzerdefiniert'
        ]);
        self::generateTranslation('no_playlist_exists', [
            'de' => 'Keine Wiedergabeliste vorhanden'
        ]);
        self::generateTranslation('edit', [
            'de' => 'Bearbeiten'
        ]);
        self::generateTranslation('create_new_account', [
            'de' => 'Neues Konto erstellen'
        ]);
        self::generateTranslation('search_too_short', [
            'de' => 'Die Suchanfrage %s ist zu kurz. Aufklappen!'
        ]);
        self::generateTranslation('playlist_allow_comments', [
            'de' => 'Kommentare zulassen'
        ]);
        self::generateTranslation('playlist_allow_rating', [
            'de' => 'Bewertung zulassen'
        ]);
        self::generateTranslation('playlist_description', [
            'de' => 'Beschreibung'
        ]);
        self::generateTranslation('playlists_have_been_removed', [
            'de' => 'Wiedergabelisten wurden entfernt'
        ]);
        self::generateTranslation('confirm_collection_delete', [
            'de' => 'Willst du diese Sammlung wirklich löschen?'
        ]);
        self::generateTranslation('please_select_collection', [
            'de' => 'Bitte wählen Sie einen der folgenden Sammlungsnamen'
        ]);
        self::generateTranslation('please_enter_collection_name', [
            'de' => 'Bitte Sammlungsname eingeben'
        ]);
        self::generateTranslation('select_collection', [
            'de' => 'Aus Sammlung auswählen'
        ]);
        self::generateTranslation('resolution', [
            'de' => 'Auflösung'
        ]);
        self::generateTranslation('filesize', [
            'de' => 'Dateigröße'
        ]);
        self::generateTranslation('empty_next', [
            'de' => 'Die Wiedergabeliste hat ihr Limit erreicht!'
        ]);
        self::generateTranslation('no_items', [
            'de' => 'Keine Artikel'
        ]);
        self::generateTranslation('user_recover_user', [
            'de' => 'Benutzername vergessen'
        ]);
        self::generateTranslation('edited_by', [
            'de' => 'bearbeitet von'
        ]);
        self::generateTranslation('reply_to', [
            'de' => 'Antwort an'
        ]);
        self::generateTranslation('mail_type', [
            'de' => 'Mail-Typ'
        ]);
        self::generateTranslation('host', [
            'de' => 'Rechner'
        ]);
        self::generateTranslation('port', [
            'de' => 'Anschluss'
        ]);
        self::generateTranslation('user', [
            'de' => 'Benutzer'
        ]);
        self::generateTranslation('auth', [
            'de' => 'Auth'
        ]);
        self::generateTranslation('mail_not_send', [
            'de' => 'E-Mail <strong>%s</strong> kann nicht gesendet werden '
        ]);
        self::generateTranslation('mail_send', [
            'de' => 'E-Mail <strong>%s</strong> erfolgreich gesendet an '
        ]);
        self::generateTranslation('title', [
            'de' => 'Titel'
        ]);
        self::generateTranslation('show_comments', [
            'de' => 'Kommentare anzeigen'
        ]);
        self::generateTranslation('hide_comments', [
            'de' => 'Kommentare ausblenden'
        ]);
        self::generateTranslation('description', [
            'de' => 'Beschreibung'
        ]);
        self::generateTranslation('users_categories', [
            'de' => 'Benutzer Kategorien'
        ]);
        self::generateTranslation('popular_users', [
            'de' => 'Beliebte Benutzer'
        ]);
        self::generateTranslation('channel', [
            'de' => 'Kanal'
        ]);
        self::generateTranslation('embed_type', [
            'de' => 'Typ einbetten'
        ]);
        self::generateTranslation('confirm_del_photo', [
            'de' => 'Sind Sie sicher, dass Sie dieses Foto löschen möchten?'
        ]);
        self::generateTranslation('vdo_inactive', [
            'de' => 'Video ist inaktiv'
        ]);
        self::generateTranslation('photo_tags_error', [
            'de' => 'Bitte geben Sie Tags für das Foto an'
        ]);
        self::generateTranslation('signups', [
            'de' => 'Anmeldungen'
        ]);
        self::generateTranslation('active_users', [
            'de' => 'Aktive Benutzer'
        ]);
        self::generateTranslation('uploaded', [
            'de' => 'Hochgeladen'
        ]);
        self::generateTranslation('user_name_invalid_len', [
            'de' => 'Länge des Benutzernamens ist ungültig'
        ]);
        self::generateTranslation('username_spaces', [
            'de' => 'Der Benutzername darf keine Leerzeichen enthalten'
        ]);
        self::generateTranslation('photo_caption_err', [
            'de' => 'Bitte Fotobeschreibung eingeben'
        ]);
        self::generateTranslation('photo_tags_err', [
            'de' => 'Bitte geben Sie Tags für das Foto ein'
        ]);
        self::generateTranslation('photo_collection_err', [
            'de' => 'Sie müssen eine Sammlung für dieses Foto angeben'
        ]);
        self::generateTranslation('details', [
            'de' => 'Einzelheiten'
        ]);
        self::generateTranslation('technical_error', [
            'de' => 'Ein technischer Fehler ist aufgetreten!'
        ]);
        self::generateTranslation('inserted', [
            'de' => 'Eingefügt'
        ]);
        self::generateTranslation('castable_status_fixed', [
            'de' => '%s castable Status wurde behoben'
        ]);
        self::generateTranslation('castable_status_failed', [
            'de' => '%s kann nicht korrekt übertragen werden, da es %s Audiokanäle hat. Bitte konvertieren Sie das Video erneut mit aktivierter Chromecast-Option.'
        ]);
        self::generateTranslation('castable_status_check', [
            'de' => 'Übertragbar-Status prüfen'
        ]);
        self::generateTranslation('castable', [
            'de' => 'Übertragbar'
        ]);
        self::generateTranslation('non_castable', [
            'de' => 'Nicht übertragbar'
        ]);
        self::generateTranslation('videos_manager', [
            'de' => 'Video-Manager'
        ]);
        self::generateTranslation('update_bits_color', [
            'de' => 'Bits Farben aktualisieren'
        ]);
        self::generateTranslation('bits_color', [
            'de' => 'Bits-Farben'
        ]);
        self::generateTranslation('bits_color_compatibility', [
            'de' => 'Das Videoformat macht es nicht abspielbar auf einigen Browsern wie Firefox, Safari, ...'
        ]);
        self::generateTranslation('player_logo_reset', [
            'de' => 'Das Player-Logo wurde zurückgesetzt'
        ]);
        self::generateTranslation('player_settings_updated', [
            'de' => 'Die Player-Einstellungen wurden aktualisiert'
        ]);
        self::generateTranslation('player_settings', [
            'de' => 'Player-Einstellungen'
        ]);
        self::generateTranslation('quality', [
            'de' => 'Qualität'
        ]);
        self::generateTranslation('error_occured', [
            'de' => 'Ups... Da ist etwas falsch gelaufen...'
        ]);
        self::generateTranslation('error_file_download', [
            'de' => 'Kann die Datei nicht abrufen'
        ]);
        self::generateTranslation('dashboard_update_status', [
            'de' => 'Status aktualisieren'
        ]);
        self::generateTranslation('dashboard_changelogs', [
            'de' => 'Änderungsprotokolle'
        ]);
        self::generateTranslation('dashboard_php_config_allow_url_fopen', [
            'de' => 'Bitte aktivieren Sie \'allow_url_fopen\' um von Changelogs zu profitieren'
        ]);
        self::generateTranslation('signup_error_email_unauthorized', [
            'de' => 'E-Mail nicht erlaubt'
        ]);
        self::generateTranslation('video_detail_saved', [
            'de' => 'Videodetails wurden gespeichert'
        ]);
        self::generateTranslation('video_subtitles_deleted', [
            'de' => 'Video Untertitel wurde gelöscht'
        ]);
        self::generateTranslation('collection_no_parent', [
            'de' => 'Kein Elternteil'
        ]);
        self::generateTranslation('collection_parent', [
            'de' => 'Übergeordnete Sammlung'
        ]);
        self::generateTranslation('comments_disabled_for_photo', [
            'de' => 'Kommentare deaktiviert für dieses Foto'
        ]);
        self::generateTranslation('plugin_editors_picks', [
            'de' => 'Redaktionelle Auswahl'
        ]);
        self::generateTranslation('plugin_editors_picks_added', [
            'de' => 'Video wurde zur redaktionellen Auswahl hinzugefügt'
        ]);
        self::generateTranslation('plugin_editors_picks_removed', [
            'de' => 'Video wurde aus der redaktionellen Auswahl entfernt'
        ]);
        self::generateTranslation('plugin_editors_picks_removed_plural', [
            'de' => 'Ausgewähltes Video wurde aus der redaktionellen Auswahl entfernt'
        ]);
        self::generateTranslation('plugin_editors_picks_add_error', [
            'de' => 'Video ist bereits in der redaktionellen Auswahl enthalten'
        ]);
        self::generateTranslation('plugin_editors_picks_add_to', [
            'de' => 'Zur redaktionellen Auswahl hinzufügen'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_from', [
            'de' => 'Von der redaktionellen Auswahl entfernen'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_confirm', [
            'de' => 'Wollen Sie das ausgewählte Videos wirklich aus der redaktionellen Auswahl entfernen?'
        ]);
        self::generateTranslation('plugin_global_announcement', [
            'de' => 'Globaler Ankündigung'
        ]);
        self::generateTranslation('plugin_global_announcement_subtitle', [
            'de' => 'Globaler Ankündigungs manager'
        ]);
        self::generateTranslation('plugin_global_announcement_edit', [
            'de' => 'Globale Ankündigung bearbeiten'
        ]);
        self::generateTranslation('plugin_global_announcement_updated', [
            'de' => 'Global announcement has been updated'
        ]);
        self::generateTranslation('page_upload_video_limits', [
            'de' => 'Jedes Video darf höchstens %s MB groß und %s Minuten lang sein und muss in einem gängigen Videoformat vorliegen.'
        ]);
        self::generateTranslation('page_upload_video_select', [
            'de' => ' Video auswählen'
        ]);
        self::generateTranslation('page_upload_photo_limits', [
            'de' => 'Jedes Foto darf höchstens %s MB groß sein und muss in einem gängigen Bildformat vorliegen'
        ]);
        self::generateTranslation('video_resolution_auto', [
            'de' => 'Auto'
        ]);
        self::generateTranslation('video_thumbs_regenerated', [
            'de' => 'Die Video-Thumbs wurden erfolgreich neu generiert'
        ]);
        self::generateTranslation('video_allow_comment_vote', [
            'de' => 'Stimmen Sie über Kommentare ab'
        ]);


        self::generateTranslation('ad_name_error', [
            'pt-BR' => 'Por favor, insira um nome para o anúncio'
        ]);
        self::generateTranslation('ad_code_error', [
            'pt-BR' => 'Erro : Por favor, digite o código para o anúncio'
        ]);
        self::generateTranslation('ad_exists_error1', [
            'pt-BR' => 'O anúncio não existe'
        ]);
        self::generateTranslation('ad_exists_error2', [
            'pt-BR' => 'Erro: Anúncio com este nome já existe'
        ]);
        self::generateTranslation('ad_add_msg', [
            'pt-BR' => 'Anúncio adicionado com sucesso'
        ]);
        self::generateTranslation('ad_msg', [
            'pt-BR' => 'O anúncio foi '
        ]);
        self::generateTranslation('ad_update_msg', [
            'pt-BR' => 'O anúncio foi atualizado'
        ]);
        self::generateTranslation('ad_del_msg', [
            'pt-BR' => 'Anúncio foi excluído'
        ]);
        self::generateTranslation('ad_deactive', [
            'pt-BR' => 'Desativado'
        ]);
        self::generateTranslation('ad_active', [
            'pt-BR' => 'Ativado'
        ]);
        self::generateTranslation('ad_placment_delete_msg', [
            'pt-BR' => 'O posicionamento foi removido'
        ]);
        self::generateTranslation('ad_placement_err1', [
            'pt-BR' => 'O posicionamento já existe'
        ]);
        self::generateTranslation('ad_placement_err2', [
            'pt-BR' => 'Por favor, digite um nome para o posicionamento'
        ]);
        self::generateTranslation('ad_placement_err3', [
            'pt-BR' => 'Por favor, digite um código para o posicionamento'
        ]);
        self::generateTranslation('ad_placement_msg', [
            'pt-BR' => 'O posicionamento foi adicionado'
        ]);
        self::generateTranslation('cat_img_error', [
            'pt-BR' => 'Por favor, carregue apenas imagens JPEG, GIF ou PNG'
        ]);
        self::generateTranslation('cat_exist_error', [
            'pt-BR' => 'A categoria não existe'
        ]);
        self::generateTranslation('cat_add_msg', [
            'pt-BR' => 'Categoria foi adicionada com sucesso'
        ]);
        self::generateTranslation('cat_update_msg', [
            'pt-BR' => 'A categoria foi atualizada'
        ]);
        self::generateTranslation('grp_err', [
            'pt-BR' => 'O Grupo Não Existe'
        ]);
        self::generateTranslation('grp_fr_msg', [
            'pt-BR' => 'O grupo foi definido como destaque'
        ]);
        self::generateTranslation('grp_fr_msg1', [
            'pt-BR' => 'Os Grupos Selecionados Foram Removidos da Lista de Destaque'
        ]);
        self::generateTranslation('grp_ac_msg', [
            'pt-BR' => 'Os Grupos Selecionados Foram Ativados'
        ]);
        self::generateTranslation('grp_dac_msg', [
            'pt-BR' => 'Os Grupos Selecionados Foram Desativados'
        ]);
        self::generateTranslation('grp_del_msg', [
            'pt-BR' => 'O grupo foi excluído'
        ]);
        self::generateTranslation('editor_pic_up', [
            'pt-BR' => 'O vídeo foi movido para cima'
        ]);
        self::generateTranslation('editor_pic_down', [
            'pt-BR' => 'Vídeo foi movido para baixo'
        ]);
        self::generateTranslation('plugin_install_msg', [
            'pt-BR' => 'O plugin foi instalado'
        ]);
        self::generateTranslation('plugin_no_file_err', [
            'pt-BR' => 'Nenhum arquivo encontrado'
        ]);
        self::generateTranslation('plugin_file_detail_err', [
            'pt-BR' => 'Detalhes do plugin desconhecido encontrados'
        ]);
        self::generateTranslation('plugin_installed_err', [
            'pt-BR' => 'Plugin já instalado'
        ]);
        self::generateTranslation('plugin_no_install_err', [
            'pt-BR' => 'O plugin não está instalado'
        ]);
        self::generateTranslation('grp_name_error', [
            'pt-BR' => 'Digite o nome do grupo'
        ]);
        self::generateTranslation('grp_name_error1', [
            'pt-BR' => 'Nome de grupo já existe'
        ]);
        self::generateTranslation('grp_des_error', [
            'pt-BR' => 'Por favor, insira uma Pequena Descrição para o Grupo'
        ]);
        self::generateTranslation('grp_tags_error', [
            'pt-BR' => 'Por favor, digite Tags para o Grupo'
        ]);
        self::generateTranslation('grp_url_error', [
            'pt-BR' => 'Por favor, insira um URL válido para o Grupo'
        ]);
        self::generateTranslation('grp_url_error1', [
            'pt-BR' => 'Por favor, insira um nome de URL válido'
        ]);
        self::generateTranslation('grp_url_error2', [
            'pt-BR' => 'URL de grupo já existe, por favor escolha uma URL diferente'
        ]);
        self::generateTranslation('grp_tpc_error', [
            'pt-BR' => 'Por favor, insira um tópico para adicionar'
        ]);
        self::generateTranslation('grp_comment_error', [
            'pt-BR' => 'Você deve digitar um comentário'
        ]);
        self::generateTranslation('grp_join_error', [
            'pt-BR' => 'Você já entrou neste grupo'
        ]);
        self::generateTranslation('grp_prvt_error', [
            'pt-BR' => 'Este grupo é privado, faça o login para visualizar este grupo'
        ]);
        self::generateTranslation('grp_inact_error', [
            'pt-BR' => 'Este grupo está inativo, por favor contate o administrador para este problema'
        ]);
        self::generateTranslation('grp_join_error1', [
            'pt-BR' => 'Você ainda não se juntou a este grupo'
        ]);
        self::generateTranslation('grp_exist_error', [
            'pt-BR' => 'Desculpe, o Grupo não Existe'
        ]);
        self::generateTranslation('grp_tpc_error1', [
            'pt-BR' => 'Este tópico não foi aprovado pelo proprietário do grupo'
        ]);
        self::generateTranslation('grp_cat_error', [
            'pt-BR' => 'Selecione uma categoria para o seu grupo'
        ]);
        self::generateTranslation('grp_tpc_error2', [
            'pt-BR' => 'Por favor, insira um tópico para adicionar'
        ]);
        self::generateTranslation('grp_tpc_error3', [
            'pt-BR' => 'Seu tópico requer aprovação do proprietário deste grupo'
        ]);
        self::generateTranslation('grp_tpc_msg', [
            'pt-BR' => 'O tópico foi adicionado'
        ]);
        self::generateTranslation('grp_comment_msg', [
            'pt-BR' => 'O comentário foi adicionado'
        ]);
        self::generateTranslation('grp_vdo_msg', [
            'pt-BR' => 'Vídeos excluídos'
        ]);
        self::generateTranslation('grp_vdo_msg1', [
            'pt-BR' => 'Vídeos adicionados com sucesso'
        ]);
        self::generateTranslation('grp_vdo_msg2', [
            'pt-BR' => 'Os vídeos foram aprovados'
        ]);
        self::generateTranslation('grp_mem_msg', [
            'pt-BR' => 'O membro foi excluído'
        ]);
        self::generateTranslation('grp_mem_msg1', [
            'pt-BR' => 'O membro foi aprovado'
        ]);
        self::generateTranslation('grp_inv_msg', [
            'pt-BR' => 'Seu convite foi enviado'
        ]);
        self::generateTranslation('grp_tpc_msg1', [
            'pt-BR' => 'O tópico foi excluído'
        ]);
        self::generateTranslation('grp_tpc_msg2', [
            'pt-BR' => 'Tópico foi aprovado'
        ]);
        self::generateTranslation('grp_fr_msg2', [
            'pt-BR' => 'O grupo foi removido da lista de destaques'
        ]);
        self::generateTranslation('grp_inv_msg1', [
            'pt-BR' => 'Convidou você para se juntar '
        ]);
        self::generateTranslation('grp_av_msg', [
            'pt-BR' => 'O grupo foi ativado'
        ]);
        self::generateTranslation('grp_da_msg', [
            'pt-BR' => 'O grupo foi desativado'
        ]);
        self::generateTranslation('grp_post_msg', [
            'pt-BR' => 'A Postagem foi excluída'
        ]);
        self::generateTranslation('grp_update_msg', [
            'pt-BR' => 'O grupo foi atualizado'
        ]);
        self::generateTranslation('grp_owner_err', [
            'pt-BR' => 'Apenas o proprietário pode adicionar vídeos a este grupo'
        ]);
        self::generateTranslation('grp_owner_err1', [
            'pt-BR' => 'Você não é dono deste grupo'
        ]);
        self::generateTranslation('grp_owner_err2', [
            'pt-BR' => 'Você é dono deste grupo. Você não pode sair do seu grupo.'
        ]);
        self::generateTranslation('grp_prvt_err1', [
            'pt-BR' => 'Este grupo é privado, você precisa de convite de seu proprietário para entrar'
        ]);
        self::generateTranslation('grp_rmv_msg', [
            'pt-BR' => 'Os Grupos Selecionados foram Removidos da Sua Conta'
        ]);
        self::generateTranslation('grp_tpc_err4', [
            'pt-BR' => 'Desculpe, Tópico não existe'
        ]);
        self::generateTranslation('grp_title_topic', [
            'pt-BR' => 'Grupos - Tópico - '
        ]);
        self::generateTranslation('grp_add_title', [
            'pt-BR' => '- Adicionar vídeo'
        ]);
        self::generateTranslation('usr_sadmin_err', [
            'pt-BR' => 'Você não pode deixar o nome de usuário do SuperAdmin em branco'
        ]);
        self::generateTranslation('usr_cpass_err', [
            'pt-BR' => 'A senha de confirmação não corresponde'
        ]);
        self::generateTranslation('usr_pass_err', [
            'pt-BR' => 'A senha antiga está incorreta'
        ]);
        self::generateTranslation('usr_email_err', [
            'pt-BR' => 'Por favor, forneça um endereço de e-mail válido'
        ]);
        self::generateTranslation('usr_cpass_err1', [
            'pt-BR' => 'Confirmação de senha incorreta'
        ]);
        self::generateTranslation('usr_pass_err1', [
            'pt-BR' => 'A senha está incorreta'
        ]);
        self::generateTranslation('usr_cmt_err', [
            'pt-BR' => 'Você precisa fazer login primeiro para comentar'
        ]);
        self::generateTranslation('usr_cmt_err1', [
            'pt-BR' => 'Por favor, digite algo na Caixa de Comentários'
        ]);
        self::generateTranslation('usr_cmt_err2', [
            'pt-BR' => 'Você não pode comentar em seu vídeo'
        ]);
        self::generateTranslation('usr_cmt_err3', [
            'pt-BR' => 'Você já postou um comentário neste canal.'
        ]);
        self::generateTranslation('usr_cmt_err4', [
            'pt-BR' => 'O comentário foi adicionado'
        ]);
        self::generateTranslation('usr_cmt_del_msg', [
            'pt-BR' => 'O comentário foi excluido'
        ]);
        self::generateTranslation('usr_cmt_del_err', [
            'pt-BR' => 'Ocorreu um erro ao remover o comentário'
        ]);
        self::generateTranslation('usr_cnt_err', [
            'pt-BR' => 'Você não pode se adicionar como um contato'
        ]);
        self::generateTranslation('usr_cnt_err1', [
            'pt-BR' => 'Você já adicionou este usuário à sua lista de contatos'
        ]);
        self::generateTranslation('usr_sub_err', [
            'pt-BR' => 'Você já está inscrito em %s'
        ]);
        self::generateTranslation('usr_exist_err', [
            'pt-BR' => 'O usuário não existe'
        ]);
        self::generateTranslation('usr_ccode_err', [
            'pt-BR' => 'O código de verificação inserido está errado'
        ]);
        self::generateTranslation('usr_exist_err1', [
            'pt-BR' => 'Desculpe, nenhum usuário existe com este e-mail'
        ]);
        self::generateTranslation('usr_exist_err2', [
            'pt-BR' => 'Desculpe, o usuário não existe'
        ]);
        self::generateTranslation('usr_uname_err', [
            'pt-BR' => 'Nome de usuário está vazio'
        ]);
        self::generateTranslation('usr_uname_err2', [
            'pt-BR' => 'Nome de usuário já existe'
        ]);
        self::generateTranslation('usr_pass_err2', [
            'pt-BR' => 'A senha está vazia'
        ]);
        self::generateTranslation('usr_email_err1', [
            'pt-BR' => 'E-mail está vazio'
        ]);
        self::generateTranslation('usr_email_err2', [
            'pt-BR' => 'Por favor, insira um endereço de e-mail válido'
        ]);
        self::generateTranslation('usr_email_err3', [
            'pt-BR' => 'O endereço de e-mail já está em uso'
        ]);
        self::generateTranslation('usr_pcode_err', [
            'pt-BR' => 'Códigos postais contêm apenas números'
        ]);
        self::generateTranslation('usr_fname_err', [
            'pt-BR' => 'O nome está vazio'
        ]);
        self::generateTranslation('usr_lname_err', [
            'pt-BR' => 'O último nome está vazio'
        ]);
        self::generateTranslation('usr_uname_err3', [
            'pt-BR' => 'Nome de usuário contém caracteres não permitidos'
        ]);
        self::generateTranslation('usr_pass_err3', [
            'pt-BR' => 'Senhas não Correspondentes'
        ]);
        self::generateTranslation('usr_dob_err', [
            'pt-BR' => 'Selecione a data de nascimento'
        ]);
        self::generateTranslation('usr_ament_err', [
            'pt-BR' => 'Desculpe, você precisa concordar com os termos de uso e política de privacidade para criar uma conta'
        ]);
        self::generateTranslation('usr_reg_err', [
            'pt-BR' => 'Desculpe, os registros não estão permitidos temporariamente. Por favor, tente novamente mais tarde'
        ]);
        self::generateTranslation('usr_ban_err', [
            'pt-BR' => 'Conta de usuário banida, entre em contato com o administrador do site'
        ]);
        self::generateTranslation('usr_login_err', [
            'pt-BR' => 'Nome de usuário e senha não correspondem'
        ]);
        self::generateTranslation('usr_sadmin_msg', [
            'pt-BR' => 'Super Administrador foi atualizado'
        ]);
        self::generateTranslation('usr_pass_msg', [
            'pt-BR' => 'Sua senha foi alterada'
        ]);
        self::generateTranslation('usr_cnt_msg', [
            'pt-BR' => 'Este usuário foi adicionado à sua lista de contatos'
        ]);
        self::generateTranslation('usr_sub_msg', [
            'pt-BR' => 'Você agora é um inscrito de %s'
        ]);
        self::generateTranslation('usr_uname_email_msg', [
            'pt-BR' => 'Enviamos um e-mail para você contendo seu nome de usuário, por favor verifique-o'
        ]);
        self::generateTranslation('usr_rpass_email_msg', [
            'pt-BR' => 'Um e-mail foi enviado para você. Siga as instruções lá para redefinir sua senha'
        ]);
        self::generateTranslation('usr_pass_email_msg', [
            'pt-BR' => 'A senha foi alterada com sucesso'
        ]);
        self::generateTranslation('usr_email_msg', [
            'pt-BR' => 'As configurações de e-mail foram atualizadas'
        ]);
        self::generateTranslation('usr_del_msg', [
            'pt-BR' => 'O usuário foi excluído'
        ]);
        self::generateTranslation('usr_dels_msg', [
            'pt-BR' => 'Os usuários selecionados foram excluídos'
        ]);
        self::generateTranslation('usr_ac_msg', [
            'pt-BR' => 'O usuário foi ativado'
        ]);
        self::generateTranslation('usr_dac_msg', [
            'pt-BR' => 'O usuário foi desativado'
        ]);
        self::generateTranslation('usr_mem_ac', [
            'pt-BR' => 'Os Membros Selecionados Foram Ativados'
        ]);
        self::generateTranslation('usr_mems_ac', [
            'pt-BR' => 'Os membros selecionados foram desativados'
        ]);
        self::generateTranslation('usr_fr_msg', [
            'pt-BR' => 'O usuário foi definido como um membro em destaque'
        ]);
        self::generateTranslation('usr_ufr_msg', [
            'pt-BR' => 'O Usuário foi removido dos usuários em destaque'
        ]);
        self::generateTranslation('usr_frs_msg', [
            'pt-BR' => 'Os usuários selecionados foram definidos como em destaque'
        ]);
        self::generateTranslation('usr_ufrs_msg', [
            'pt-BR' => 'Os usuários selecionados foram removidos da lista em destaque'
        ]);
        self::generateTranslation('usr_uban_msg', [
            'pt-BR' => 'O usuário foi banido'
        ]);
        self::generateTranslation('usr_uuban_msg', [
            'pt-BR' => 'O usuário foi desbanido'
        ]);
        self::generateTranslation('usr_ubans_msg', [
            'pt-BR' => 'Os membros selecionados foram banidos'
        ]);
        self::generateTranslation('usr_uubans_msg', [
            'pt-BR' => 'Os membros selecionados foram desbanidos'
        ]);
        self::generateTranslation('usr_pass_reset_conf', [
            'pt-BR' => 'Confirmação para Redefinição de Senha'
        ]);
        self::generateTranslation('usr_dear_user', [
            'pt-BR' => 'Caro Usuário'
        ]);
        self::generateTranslation('usr_pass_reset_msg', [
            'pt-BR' => 'Você solicitou uma redefinição de senha, siga o link para redefinir sua senha'
        ]);
        self::generateTranslation('usr_rpass_msg', [
            'pt-BR' => 'A senha foi redefinida'
        ]);
        self::generateTranslation('usr_rpass_req_msg', [
            'pt-BR' => 'Você solicitou uma redefinição de senha, aqui está a sua nova senha: '
        ]);
        self::generateTranslation('usr_uname_req_msg', [
            'pt-BR' => 'Você solicitou a Recuperação do Seu Nome de Usuário, Aqui está seu Nome de Usuário: '
        ]);
        self::generateTranslation('usr_uname_recovery', [
            'pt-BR' => 'E-mail de recuperação'
        ]);
        self::generateTranslation('usr_add_succ_msg', [
            'pt-BR' => 'O usuário foi adicionado'
        ]);
        self::generateTranslation('usr_upd_succ_msg', [
            'pt-BR' => 'O usuário foi atualizado'
        ]);
        self::generateTranslation('usr_activation_msg', [
            'pt-BR' => 'Sua conta foi ativada. Agora você pode fazer login em sua conta e enviar vídeos'
        ]);
        self::generateTranslation('usr_activation_err', [
            'pt-BR' => 'Este usuário já está ativado'
        ]);
        self::generateTranslation('usr_activation_em_msg', [
            'pt-BR' => 'Enviamos um e-mail contendo o seu código de ativação. Por favor, verifique sua caixa de correio'
        ]);
        self::generateTranslation('usr_activation_em_err', [
            'pt-BR' => 'O e-mail não existe ou o usuário com este e-mail já está ativado'
        ]);
        self::generateTranslation('usr_no_msg_del_err', [
            'pt-BR' => 'Nenhuma mensagem foi selecionada para exclusão'
        ]);
        self::generateTranslation('usr_sel_msg_del_msg', [
            'pt-BR' => 'As mensagens selecionadas foram excluídas'
        ]);
        self::generateTranslation('usr_pof_upd_msg', [
            'pt-BR' => 'O perfil foi atualizado'
        ]);
        self::generateTranslation('usr_arr_no_ans', [
            'pt-BR' => 'Sem resposta'
        ]);
        self::generateTranslation('usr_arr_elementary', [
            'pt-BR' => 'Fundamental'
        ]);
        self::generateTranslation('usr_arr_hi_school', [
            'pt-BR' => 'Ensino médio'
        ]);
        self::generateTranslation('usr_arr_some_colg', [
            'pt-BR' => 'Alguma Faculdade'
        ]);
        self::generateTranslation('usr_arr_assoc_deg', [
            'pt-BR' => 'Grau associado'
        ]);
        self::generateTranslation('usr_arr_bach_deg', [
            'pt-BR' => 'Bacharelado'
        ]);
        self::generateTranslation('usr_arr_mast_deg', [
            'pt-BR' => 'Mestrado'
        ]);
        self::generateTranslation('usr_arr_phd', [
            'pt-BR' => 'Ph.D.'
        ]);
        self::generateTranslation('usr_arr_post_doc', [
            'pt-BR' => 'Postdoutorado'
        ]);
        self::generateTranslation('usr_arr_single', [
            'pt-BR' => 'Solteiro(a)'
        ]);
        self::generateTranslation('usr_arr_married', [
            'pt-BR' => 'Casado(a)'
        ]);
        self::generateTranslation('usr_arr_comitted', [
            'pt-BR' => 'Comprometido(a)'
        ]);
        self::generateTranslation('usr_arr_open_marriage', [
            'pt-BR' => 'Casamento Aberto'
        ]);
        self::generateTranslation('usr_arr_open_relate', [
            'pt-BR' => 'Relacionamento Aberto'
        ]);
        self::generateTranslation('title_crt_new_msg', [
            'pt-BR' => 'Compor Nova Mensagem'
        ]);
        self::generateTranslation('title_forgot', [
            'pt-BR' => 'Esqueceu algo? Encontre-o agora!'
        ]);
        self::generateTranslation('title_inbox', [
            'pt-BR' => ' - Caixa de entrada'
        ]);
        self::generateTranslation('title_sent', [
            'pt-BR' => '- Pasta de Envios'
        ]);
        self::generateTranslation('title_usr_contact', [
            'pt-BR' => ' Lista de Contatos'
        ]);
        self::generateTranslation('title_usr_fav_vids', [
            'pt-BR' => 'Vídeos Favoritos de %s'
        ]);
        self::generateTranslation('title_edit_video', [
            'pt-BR' => 'Editar Vídeo - '
        ]);
        self::generateTranslation('vdo_title_err', [
            'pt-BR' => 'Digite o título do vídeo'
        ]);
        self::generateTranslation('vdo_des_err', [
            'pt-BR' => 'Digite a descrição do vídeo'
        ]);
        self::generateTranslation('vdo_tags_err', [
            'pt-BR' => 'Por favor, digite Tags para o Vídeo'
        ]);
        self::generateTranslation('vdo_cat_err', [
            'pt-BR' => 'Por favor, escolha pelo menos uma categoria'
        ]);
        self::generateTranslation('vdo_cat_err1', [
            'pt-BR' => 'Você só pode escolher até 3 categorias'
        ]);
        self::generateTranslation('vdo_sub_email_msg', [
            'pt-BR' => ' e, portanto, esta mensagem é enviada a você automaticamente por que '
        ]);
        self::generateTranslation('vdo_has_upload_nv', [
            'pt-BR' => 'Enviou um novo vídeo'
        ]);
        self::generateTranslation('vdo_del_selected', [
            'pt-BR' => 'Os vídeos selecionados foram excluídos'
        ]);
        self::generateTranslation('vdo_cheat_msg', [
            'pt-BR' => 'Por favor, não tente trapacear'
        ]);
        self::generateTranslation('vdo_limits_warn_msg', [
            'pt-BR' => 'Por favor, não tente cruzar seus limites'
        ]);
        self::generateTranslation('vdo_cmt_del_msg', [
            'pt-BR' => 'O comentário foi excluido'
        ]);
        self::generateTranslation('vdo_iac_msg', [
            'pt-BR' => 'Vídeo está Inativo - Por favor contate o Administrador para mais detalhes'
        ]);
        self::generateTranslation('vdo_is_in_process', [
            'pt-BR' => 'Vídeo está sendo processado - por favor contate o administrador para mais detalhes'
        ]);
        self::generateTranslation('vdo_upload_allow_err', [
            'pt-BR' => 'O envio não é permitido pelo proprietário do site'
        ]);
        self::generateTranslation('vdo_download_allow_err', [
            'pt-BR' => 'O download de vídeos não é permitido'
        ]);
        self::generateTranslation('vdo_edit_owner_err', [
            'pt-BR' => 'Você não é proprietário de vídeo'
        ]);
        self::generateTranslation('vdo_embed_code_wrong', [
            'pt-BR' => 'Código de incorporação esta errado'
        ]);
        self::generateTranslation('vdo_seconds_err', [
            'pt-BR' => 'Valor errado inserido no campo de segundos'
        ]);
        self::generateTranslation('vdo_mins_err', [
            'pt-BR' => 'Valor errado inserido no campo de minutos'
        ]);
        self::generateTranslation('vdo_thumb_up_err', [
            'pt-BR' => 'Erro ao enviar miniatura'
        ]);
        self::generateTranslation('class_error_occured', [
            'pt-BR' => 'Desculpe, Ocorreu um erro'
        ]);
        self::generateTranslation('class_cat_del_msg', [
            'pt-BR' => 'A categoria foi excluída'
        ]);
        self::generateTranslation('class_vdo_del_msg', [
            'pt-BR' => 'O vídeo foi excluído'
        ]);
        self::generateTranslation('class_vdo_fr_msg', [
            'pt-BR' => 'O vídeo foi marcado como «Vídeo em Destaque»'
        ]);
        self::generateTranslation('class_fr_msg1', [
            'pt-BR' => 'O vídeo foi removido de «Vídeos em destaque»'
        ]);
        self::generateTranslation('class_vdo_act_msg', [
            'pt-BR' => 'O vídeo foi ativado'
        ]);
        self::generateTranslation('class_vdo_act_msg1', [
            'pt-BR' => 'O vídeo foi desativado'
        ]);
        self::generateTranslation('class_vdo_update_msg', [
            'pt-BR' => 'Detalhes do vídeo atualizados'
        ]);
        self::generateTranslation('class_comment_err', [
            'pt-BR' => 'Você deve logar antes de postar comentários'
        ]);
        self::generateTranslation('class_comment_err1', [
            'pt-BR' => 'Por favor, digite algo na Caixa de Comentários'
        ]);
        self::generateTranslation('class_comment_err2', [
            'pt-BR' => 'Você não pode publicar um comentário no seu próprio vídeo'
        ]);
        self::generateTranslation('class_comment_err3', [
            'pt-BR' => 'Você já postou um comentário, por favor espere pelos outros.'
        ]);
        self::generateTranslation('class_comment_err4', [
            'pt-BR' => 'Você já respondeu a um comentário, por favor espere pelos outros.'
        ]);
        self::generateTranslation('class_comment_err5', [
            'pt-BR' => 'Você não pode postar uma resposta a si mesmo'
        ]);
        self::generateTranslation('class_comment_msg', [
            'pt-BR' => 'O comentário foi adicionado'
        ]);
        self::generateTranslation('class_comment_err6', [
            'pt-BR' => 'Por favor, inicie a sessão para avaliar o comentário'
        ]);
        self::generateTranslation('class_comment_err7', [
            'pt-BR' => 'Você já avaliou este comentário'
        ]);
        self::generateTranslation('class_vdo_fav_err', [
            'pt-BR' => 'Este vídeo já foi adicionado aos seus favoritos'
        ]);
        self::generateTranslation('class_vdo_fav_msg', [
            'pt-BR' => 'Este vídeo foi adicionado aos seus favoritos'
        ]);
        self::generateTranslation('class_vdo_flag_err', [
            'pt-BR' => 'Você já sinalizou este vídeo'
        ]);
        self::generateTranslation('class_vdo_flag_msg', [
            'pt-BR' => 'Este vídeo foi sinalizado como inapropriado'
        ]);
        self::generateTranslation('class_vdo_flag_rm', [
            'pt-BR' => 'Sinalizador(es) Foi/Foram removido(s)'
        ]);
        self::generateTranslation('class_send_msg_err', [
            'pt-BR' => 'Digite um nome de usuário ou selecione qualquer usuário para enviar mensagem'
        ]);
        self::generateTranslation('class_invalid_user', [
            'pt-BR' => 'Nome de usuário inválido'
        ]);
        self::generateTranslation('class_subj_err', [
            'pt-BR' => 'Assunto da mensagem está vazio'
        ]);
        self::generateTranslation('class_msg_err', [
            'pt-BR' => 'Por favor, digite algo na caixa de mensagens'
        ]);
        self::generateTranslation('class_sent_you_msg', [
            'pt-BR' => 'Enviou uma mensagem'
        ]);
        self::generateTranslation('class_sent_prvt_msg', [
            'pt-BR' => 'Enviou-lhe uma mensagem privada em '
        ]);
        self::generateTranslation('class_click_inbox', [
            'pt-BR' => 'Clique aqui para visualizar sua caixa de entrada'
        ]);
        self::generateTranslation('class_click_login', [
            'pt-BR' => 'Clique aqui para entrar'
        ]);
        self::generateTranslation('class_email_notify', [
            'pt-BR' => 'Notificação de Email'
        ]);
        self::generateTranslation('class_msg_has_sent_to', [
            'pt-BR' => 'A mensagem foi enviada para '
        ]);
        self::generateTranslation('class_inbox_del_msg', [
            'pt-BR' => 'A mensagem foi apagada da caixa de entrada '
        ]);
        self::generateTranslation('class_sent_del_msg', [
            'pt-BR' => 'A mensagem foi excluída da pasta Enviados'
        ]);
        self::generateTranslation('class_msg_exist_err', [
            'pt-BR' => 'A Mensagem Não Existe'
        ]);
        self::generateTranslation('class_vdo_del_err', [
            'pt-BR' => 'O vídeo não existe'
        ]);
        self::generateTranslation('class_unsub_msg', [
            'pt-BR' => 'Sua assinatura foi cancelada com sucesso'
        ]);
        self::generateTranslation('class_sub_exist_err', [
            'pt-BR' => 'A assinatura não existe'
        ]);
        self::generateTranslation('class_vdo_rm_fav_msg', [
            'pt-BR' => 'O vídeo foi removido dos favoritos'
        ]);
        self::generateTranslation('class_vdo_fav_err1', [
            'pt-BR' => 'Este vídeo não está na sua lista de favoritos'
        ]);
        self::generateTranslation('class_cont_del_msg', [
            'pt-BR' => 'O contato foi excluído'
        ]);
        self::generateTranslation('class_cot_err', [
            'pt-BR' => 'Desculpe, este contato não está na sua lista de contatos'
        ]);
        self::generateTranslation('class_vdo_ep_err1', [
            'pt-BR' => 'Você já escolheu 10 vídeos, por favor, exclua um para adicionar mais'
        ]);
        self::generateTranslation('class_vdo_exist_err', [
            'pt-BR' => 'Desculpe, o vídeo não existe'
        ]);
        self::generateTranslation('class_img_gif_err', [
            'pt-BR' => 'Por favor envie apenas imagem Gif'
        ]);
        self::generateTranslation('class_img_png_err', [
            'pt-BR' => 'Por favor envie apenas uma imagem Png'
        ]);
        self::generateTranslation('class_img_jpg_err', [
            'pt-BR' => 'Por favor, envie apenas imagem Jpg'
        ]);
        self::generateTranslation('class_logo_msg', [
            'pt-BR' => 'O logotipo foi alterado. Por favor, limpe o cache se você não é capaz de ver o logotipo mudado'
        ]);
        self::generateTranslation('com_forgot_username', [
            'pt-BR' => 'Esqueceu seu Usuário | Senha'
        ]);
        self::generateTranslation('com_join_now', [
            'pt-BR' => 'Cadastre-se agora'
        ]);
        self::generateTranslation('com_my_account', [
            'pt-BR' => 'Minha Conta'
        ]);
        self::generateTranslation('com_manage_vids', [
            'pt-BR' => 'Gerenciar Vídeos'
        ]);
        self::generateTranslation('com_view_channel', [
            'pt-BR' => 'Ver Meu Canal'
        ]);
        self::generateTranslation('com_my_inbox', [
            'pt-BR' => 'Minha Caixa de Entrada'
        ]);
        self::generateTranslation('com_welcome', [
            'pt-BR' => 'Bem-vindo'
        ]);
        self::generateTranslation('com_top_mem', [
            'pt-BR' => 'Membros populares '
        ]);
        self::generateTranslation('com_vidz', [
            'pt-BR' => 'Vídeos'
        ]);
        self::generateTranslation('com_sign_up_now', [
            'pt-BR' => 'Inscreva-se agora!'
        ]);
        self::generateTranslation('com_my_videos', [
            'pt-BR' => 'Meus Vídeos'
        ]);
        self::generateTranslation('com_my_channel', [
            'pt-BR' => 'Meu Canal'
        ]);
        self::generateTranslation('com_my_subs', [
            'pt-BR' => 'Minhas inscrições'
        ]);
        self::generateTranslation('com_user_no_contacts', [
            'pt-BR' => 'O Usuário não tem qualquer Contato'
        ]);
        self::generateTranslation('com_user_no_vides', [
            'pt-BR' => 'O usuário não possui nenhum vídeo favorito'
        ]);
        self::generateTranslation('com_user_no_vid_com', [
            'pt-BR' => 'O usuário não tem comentários de vídeo'
        ]);
        self::generateTranslation('com_view_all_contacts', [
            'pt-BR' => 'Ver todos os contatos de'
        ]);
        self::generateTranslation('com_view_fav_all_videos', [
            'pt-BR' => 'Ver todos os vídeos favoritos de'
        ]);
        self::generateTranslation('com_login_success_msg', [
            'pt-BR' => 'Você foi logado com sucesso.'
        ]);
        self::generateTranslation('com_logout_success_msg', [
            'pt-BR' => 'Você foi desconectado com sucesso.'
        ]);
        self::generateTranslation('com_not_redirecting', [
            'pt-BR' => 'Agora você está sendo redirecionando.'
        ]);
        self::generateTranslation('com_not_redirecting_msg', [
            'pt-BR' => 'Se você não estiver sendo redirecionando'
        ]);
        self::generateTranslation('com_manage_contacts', [
            'pt-BR' => 'Gerenciar Contatos '
        ]);
        self::generateTranslation('com_send_message', [
            'pt-BR' => 'Enviar mensagem'
        ]);
        self::generateTranslation('com_manage_fav', [
            'pt-BR' => 'Gerenciar Favoritos'
        ]);
        self::generateTranslation('com_manage_subs', [
            'pt-BR' => 'Gerenciar Inscrições'
        ]);
        self::generateTranslation('com_subscribe_to', [
            'pt-BR' => 'Inscrever-se no canal de %s'
        ]);
        self::generateTranslation('com_total_subs', [
            'pt-BR' => 'Total de Inscrições'
        ]);
        self::generateTranslation('com_total_vids', [
            'pt-BR' => 'Total de vídeos'
        ]);
        self::generateTranslation('com_date_subscribed', [
            'pt-BR' => 'Data da Inscrição'
        ]);
        self::generateTranslation('com_search_results', [
            'pt-BR' => 'Resultados da busca'
        ]);
        self::generateTranslation('com_advance_results', [
            'pt-BR' => 'Busca avançada'
        ]);
        self::generateTranslation('com_search_results_in', [
            'pt-BR' => 'Resultados da Pesquisa em'
        ]);
        self::generateTranslation('videos_being_watched', [
            'pt-BR' => 'Visualizados Recentemente...'
        ]);
        self::generateTranslation('latest_added_videos', [
            'pt-BR' => 'Adições Recentes'
        ]);
        self::generateTranslation('most_viewed', [
            'pt-BR' => 'Mais Vistos'
        ]);
        self::generateTranslation('recently_added', [
            'pt-BR' => 'Adicionado Recentemente'
        ]);
        self::generateTranslation('featured', [
            'pt-BR' => 'Em destaque'
        ]);
        self::generateTranslation('highest_rated', [
            'pt-BR' => 'Melhor avaliado'
        ]);
        self::generateTranslation('most_discussed', [
            'pt-BR' => 'Mais discutidos'
        ]);
        self::generateTranslation('style_change', [
            'pt-BR' => 'Alteração de Estilo'
        ]);
        self::generateTranslation('rss_feed_latest_title', [
            'pt-BR' => 'RSS feed para vídeos mais recentes'
        ]);
        self::generateTranslation('rss_feed_featured_title', [
            'pt-BR' => 'RSS feed para vídeos em destaque'
        ]);
        self::generateTranslation('rss_feed_most_viewed_title', [
            'pt-BR' => 'Feed RSS para vídeos mais populares'
        ]);
        self::generateTranslation('lang_folder', [
            'pt-BR' => 'pt-br'
        ]);
        self::generateTranslation('reg_closed', [
            'pt-BR' => 'Registro fechado'
        ]);
        self::generateTranslation('reg_for', [
            'pt-BR' => 'Cadastramento para'
        ]);
        self::generateTranslation('is_currently_closed', [
            'pt-BR' => 'está atualmente fechado'
        ]);
        self::generateTranslation('about_us', [
            'pt-BR' => 'Sobre nós'
        ]);
        self::generateTranslation('account', [
            'pt-BR' => 'Conta'
        ]);
        self::generateTranslation('added', [
            'pt-BR' => 'Adicionado'
        ]);
        self::generateTranslation('advertisements', [
            'pt-BR' => 'Anúncios'
        ]);
        self::generateTranslation('all', [
            'pt-BR' => 'Todos'
        ]);
        self::generateTranslation('active', [
            'pt-BR' => 'Ativo'
        ]);
        self::generateTranslation('activate', [
            'pt-BR' => 'Ativar'
        ]);
        self::generateTranslation('deactivate', [
            'pt-BR' => 'Desativar'
        ]);
        self::generateTranslation('age', [
            'pt-BR' => 'Idade'
        ]);
        self::generateTranslation('approve', [
            'pt-BR' => 'Aprovar'
        ]);
        self::generateTranslation('approved', [
            'pt-BR' => 'Aprovado'
        ]);
        self::generateTranslation('approval', [
            'pt-BR' => 'Aprovação'
        ]);
        self::generateTranslation('books', [
            'pt-BR' => 'Livros'
        ]);
        self::generateTranslation('browse', [
            'pt-BR' => 'Navegar'
        ]);
        self::generateTranslation('by', [
            'pt-BR' => 'por'
        ]);
        self::generateTranslation('cancel', [
            'pt-BR' => 'Cancelar'
        ]);
        self::generateTranslation('categories', [
            'pt-BR' => 'Categorias'
        ]);
        self::generateTranslation('category', [
            'pt-BR' => 'Categoria'
        ]);
        self::generateTranslation('channels', [
            'pt-BR' => 'Canais'
        ]);
        self::generateTranslation('check_all', [
            'pt-BR' => 'Marcar todos'
        ]);
        self::generateTranslation('click_here', [
            'pt-BR' => 'Clique Aqui'
        ]);
        self::generateTranslation('comments', [
            'pt-BR' => 'Comentários'
        ]);
        self::generateTranslation('comment', [
            'pt-BR' => 'Comentário'
        ]);
        self::generateTranslation('community', [
            'pt-BR' => 'Comunidade'
        ]);
        self::generateTranslation('companies', [
            'pt-BR' => 'Empresas'
        ]);
        self::generateTranslation('contacts', [
            'pt-BR' => 'Contatos'
        ]);
        self::generateTranslation('contact_us', [
            'pt-BR' => 'Contate-nos'
        ]);
        self::generateTranslation('country', [
            'pt-BR' => 'País'
        ]);
        self::generateTranslation('created', [
            'pt-BR' => 'Criado'
        ]);
        self::generateTranslation('date', [
            'pt-BR' => 'Data'
        ]);
        self::generateTranslation('date_added', [
            'pt-BR' => 'Data de Adição'
        ]);
        self::generateTranslation('date_joined', [
            'pt-BR' => 'Data de inscrição'
        ]);
        self::generateTranslation('dear', [
            'pt-BR' => 'Caro(a)'
        ]);
        self::generateTranslation('delete', [
            'pt-BR' => 'Excluir'
        ]);
        self::generateTranslation('add', [
            'pt-BR' => 'Adicionar'
        ]);
        self::generateTranslation('delete_selected', [
            'pt-BR' => 'Excluir Selecionados'
        ]);
        self::generateTranslation('des_title', [
            'pt-BR' => 'Descrição:'
        ]);
        self::generateTranslation('duration', [
            'pt-BR' => 'Duração'
        ]);
        self::generateTranslation('education', [
            'pt-BR' => 'Educação'
        ]);
        self::generateTranslation('email', [
            'pt-BR' => 'E-mail'
        ]);
        self::generateTranslation('embed', [
            'pt-BR' => 'Incorporar'
        ]);
        self::generateTranslation('embed_code', [
            'pt-BR' => 'Código de Incorporação'
        ]);
        self::generateTranslation('favourite', [
            'pt-BR' => 'Favorito'
        ]);
        self::generateTranslation('favourited', [
            'pt-BR' => 'Adicionado aos Favoritos'
        ]);
        self::generateTranslation('favourites', [
            'pt-BR' => 'Favoritos'
        ]);
        self::generateTranslation('female', [
            'pt-BR' => 'Mulher'
        ]);
        self::generateTranslation('filter', [
            'pt-BR' => 'Filtro'
        ]);
        self::generateTranslation('forgot', [
            'pt-BR' => 'Esqueci'
        ]);
        self::generateTranslation('friends', [
            'pt-BR' => 'Amigos'
        ]);
        self::generateTranslation('from', [
            'pt-BR' => 'De'
        ]);
        self::generateTranslation('gender', [
            'pt-BR' => 'Sexo'
        ]);
        self::generateTranslation('groups', [
            'pt-BR' => 'Grupos'
        ]);
        self::generateTranslation('hello', [
            'pt-BR' => 'Olá'
        ]);
        self::generateTranslation('help', [
            'pt-BR' => 'Ajuda'
        ]);
        self::generateTranslation('hi', [
            'pt-BR' => 'Olá'
        ]);
        self::generateTranslation('hobbies', [
            'pt-BR' => 'Passatempos'
        ]);
        self::generateTranslation('Home', [
            'pt-BR' => 'Início'
        ]);
        self::generateTranslation('inbox', [
            'pt-BR' => 'Caixa de entrada'
        ]);
        self::generateTranslation('interests', [
            'pt-BR' => 'Interesses'
        ]);
        self::generateTranslation('join_now', [
            'pt-BR' => 'Junte-se agora'
        ]);
        self::generateTranslation('joined', [
            'pt-BR' => 'Juntou-se'
        ]);
        self::generateTranslation('join', [
            'pt-BR' => 'Juntar-se'
        ]);
        self::generateTranslation('keywords', [
            'pt-BR' => 'Palavras-chave'
        ]);
        self::generateTranslation('latest', [
            'pt-BR' => 'Recentes'
        ]);
        self::generateTranslation('leave', [
            'pt-BR' => 'Sair'
        ]);
        self::generateTranslation('location', [
            'pt-BR' => 'Localização'
        ]);
        self::generateTranslation('login', [
            'pt-BR' => 'Entrar'
        ]);
        self::generateTranslation('logout', [
            'pt-BR' => 'Sair'
        ]);
        self::generateTranslation('male', [
            'pt-BR' => 'Homem'
        ]);
        self::generateTranslation('members', [
            'pt-BR' => 'Membros'
        ]);
        self::generateTranslation('messages', [
            'pt-BR' => 'Mensagens'
        ]);
        self::generateTranslation('message', [
            'pt-BR' => 'Mensagem'
        ]);
        self::generateTranslation('minute', [
            'pt-BR' => 'minuto'
        ]);
        self::generateTranslation('minutes', [
            'pt-BR' => 'minutos'
        ]);
        self::generateTranslation('most_members', [
            'pt-BR' => 'Mais Membros'
        ]);
        self::generateTranslation('most_recent', [
            'pt-BR' => 'Mais Recente'
        ]);
        self::generateTranslation('most_videos', [
            'pt-BR' => 'Mais vídeos'
        ]);
        self::generateTranslation('music', [
            'pt-BR' => 'Música'
        ]);
        self::generateTranslation('my_account', [
            'pt-BR' => 'Minha Conta'
        ]);
        self::generateTranslation('next', [
            'pt-BR' => 'Próxima'
        ]);
        self::generateTranslation('no', [
            'pt-BR' => 'Não'
        ]);
        self::generateTranslation('no_user_exists', [
            'pt-BR' => 'Nenhum Usuário Existe'
        ]);
        self::generateTranslation('no_video_exists', [
            'pt-BR' => 'Nenhum Vídeo Existe'
        ]);
        self::generateTranslation('occupations', [
            'pt-BR' => 'Ocupações'
        ]);
        self::generateTranslation('optional', [
            'pt-BR' => 'opcional'
        ]);
        self::generateTranslation('owner', [
            'pt-BR' => 'Dono'
        ]);
        self::generateTranslation('password', [
            'pt-BR' => 'senha'
        ]);
        self::generateTranslation('please', [
            'pt-BR' => 'Por favor'
        ]);
        self::generateTranslation('privacy', [
            'pt-BR' => 'Privacidade'
        ]);
        self::generateTranslation('privacy_policy', [
            'pt-BR' => 'Política de Privacidade'
        ]);
        self::generateTranslation('random', [
            'pt-BR' => 'Aleatório'
        ]);
        self::generateTranslation('rate', [
            'pt-BR' => 'Avalie'
        ]);
        self::generateTranslation('request', [
            'pt-BR' => 'Solicitar'
        ]);
        self::generateTranslation('related', [
            'pt-BR' => 'Relacionado'
        ]);
        self::generateTranslation('reply', [
            'pt-BR' => 'Responder'
        ]);
        self::generateTranslation('results', [
            'pt-BR' => 'Resultados'
        ]);
        self::generateTranslation('relationship', [
            'pt-BR' => 'Relacionamento'
        ]);
        self::generateTranslation('second', [
            'pt-BR' => 'segundo'
        ]);
        self::generateTranslation('seconds', [
            'pt-BR' => 'segundos'
        ]);
        self::generateTranslation('select', [
            'pt-BR' => 'Selecionar'
        ]);
        self::generateTranslation('send', [
            'pt-BR' => 'Enviar'
        ]);
        self::generateTranslation('sent', [
            'pt-BR' => 'Enviado'
        ]);
        self::generateTranslation('signup', [
            'pt-BR' => 'Criar conta'
        ]);
        self::generateTranslation('subject', [
            'pt-BR' => 'Assunto'
        ]);
        self::generateTranslation('tags', [
            'pt-BR' => 'Tags'
        ]);
        self::generateTranslation('times', [
            'pt-BR' => 'Tempos'
        ]);
        self::generateTranslation('to', [
            'pt-BR' => 'Para'
        ]);
        self::generateTranslation('type', [
            'pt-BR' => 'Tipo'
        ]);
        self::generateTranslation('update', [
            'pt-BR' => 'Atualizar'
        ]);
        self::generateTranslation('upload', [
            'pt-BR' => 'Enviar'
        ]);
        self::generateTranslation('url', [
            'pt-BR' => 'URL'
        ]);
        self::generateTranslation('verification', [
            'pt-BR' => 'Verificação'
        ]);
        self::generateTranslation('videos', [
            'pt-BR' => 'Vídeos'
        ]);
        self::generateTranslation('viewing', [
            'pt-BR' => 'Visualizando'
        ]);
        self::generateTranslation('welcome', [
            'pt-BR' => 'Bem-vindo'
        ]);
        self::generateTranslation('website', [
            'pt-BR' => 'Página Web'
        ]);
        self::generateTranslation('yes', [
            'pt-BR' => 'Sim'
        ]);
        self::generateTranslation('of', [
            'pt-BR' => 'de'
        ]);
        self::generateTranslation('on', [
            'pt-BR' => 'em'
        ]);
        self::generateTranslation('previous', [
            'pt-BR' => 'Anterior'
        ]);
        self::generateTranslation('rating', [
            'pt-BR' => 'Avaliação'
        ]);
        self::generateTranslation('ratings', [
            'pt-BR' => 'Avaliações'
        ]);
        self::generateTranslation('remote_upload', [
            'pt-BR' => 'Envio Remoto'
        ]);
        self::generateTranslation('remove', [
            'pt-BR' => 'Remover'
        ]);
        self::generateTranslation('search', [
            'pt-BR' => 'Pesquisar'
        ]);
        self::generateTranslation('services', [
            'pt-BR' => 'Serviços'
        ]);
        self::generateTranslation('show_all', [
            'pt-BR' => 'Mostrar tudo'
        ]);
        self::generateTranslation('signupup', [
            'pt-BR' => 'Cadastre-se'
        ]);
        self::generateTranslation('sort_by', [
            'pt-BR' => 'Ordenar'
        ]);
        self::generateTranslation('subscriptions', [
            'pt-BR' => 'Inscrições'
        ]);
        self::generateTranslation('subscribers', [
            'pt-BR' => 'Inscritos'
        ]);
        self::generateTranslation('tag_title', [
            'pt-BR' => 'Tags'
        ]);
        self::generateTranslation('track_title', [
            'pt-BR' => 'Faixa de áudio'
        ]);
        self::generateTranslation('time', [
            'pt-BR' => 'tempo'
        ]);
        self::generateTranslation('top', [
            'pt-BR' => 'Topo'
        ]);
        self::generateTranslation('tos_title', [
            'pt-BR' => 'Termos de Uso'
        ]);
        self::generateTranslation('username', [
            'pt-BR' => 'Nome de usuário'
        ]);
        self::generateTranslation('views', [
            'pt-BR' => 'Visualizações'
        ]);
        self::generateTranslation('proccession_wait', [
            'pt-BR' => 'Processando, Por favor, aguarde'
        ]);
        self::generateTranslation('mostly_viewed', [
            'pt-BR' => 'Mais Vistos'
        ]);
        self::generateTranslation('most_comments', [
            'pt-BR' => 'Mais comentários'
        ]);
        self::generateTranslation('group', [
            'pt-BR' => 'Grupo'
        ]);
        self::generateTranslation('not_logged_in', [
            'pt-BR' => 'Você não está logado ou não tem permissão para acessar esta página. Isto pode ocorrer devido a vários motivos:'
        ]);
        self::generateTranslation('fill_auth_form', [
            'pt-BR' => 'Você não está conectado. Preencha o formulário abaixo e tente novamente.'
        ]);
        self::generateTranslation('insufficient_privileges', [
            'pt-BR' => 'Você pode não ter privilégios suficientes para acessar esta página.'
        ]);
        self::generateTranslation('admin_disabled_you', [
            'pt-BR' => 'O administrador do site pode ter desabilitado sua conta ou pode estar aguardando ativação.'
        ]);
        self::generateTranslation('Recover_Password', [
            'pt-BR' => 'Recuperar Senha'
        ]);
        self::generateTranslation('Submit', [
            'pt-BR' => 'Enviar'
        ]);
        self::generateTranslation('Reset_Fields', [
            'pt-BR' => 'Limpar campos'
        ]);
        self::generateTranslation('admin_reg_req', [
            'pt-BR' => 'O administrador pode ter exigido que você se registre antes de poder ver esta página.'
        ]);
        self::generateTranslation('lang_change', [
            'pt-BR' => 'Alterar Idioma'
        ]);
        self::generateTranslation('lang_changed', [
            'pt-BR' => 'Seu idioma foi alterado'
        ]);
        self::generateTranslation('lang_choice', [
            'pt-BR' => 'Idioma'
        ]);
        self::generateTranslation('if_not_redir', [
            'pt-BR' => 'Clique aqui para continuar se você não é redirecionado automaticamente.'
        ]);
        self::generateTranslation('style_changed', [
            'pt-BR' => 'Seu estilo foi alterado'
        ]);
        self::generateTranslation('style_choice', [
            'pt-BR' => 'Estilo'
        ]);
        self::generateTranslation('vdo_edit_vdo', [
            'pt-BR' => 'Editar Vídeo'
        ]);
        self::generateTranslation('vdo_stills', [
            'pt-BR' => 'Travas de vídeo'
        ]);
        self::generateTranslation('vdo_watch_video', [
            'pt-BR' => 'Assistir Vídeo'
        ]);
        self::generateTranslation('vdo_video_details', [
            'pt-BR' => 'Detalhes do Vídeo'
        ]);
        self::generateTranslation('vdo_title', [
            'pt-BR' => 'Título'
        ]);
        self::generateTranslation('vdo_desc', [
            'pt-BR' => 'Descrição'
        ]);
        self::generateTranslation('vdo_cat', [
            'pt-BR' => 'Categoria do Vídeo'
        ]);
        self::generateTranslation('vdo_cat_msg', [
            'pt-BR' => 'Você pode selecionar até %s categorias'
        ]);
        self::generateTranslation('vdo_tags_msg', [
            'pt-BR' => 'As tags são separadas por vírgulas, como nesse exemplo: Teste, Engraçado, Divertido'
        ]);
        self::generateTranslation('vdo_br_opt', [
            'pt-BR' => 'Opções de Transmissão'
        ]);
        self::generateTranslation('vdo_br_opt1', [
            'pt-BR' => 'Público - Compartilhe seu vídeo com todos! (recomendado)'
        ]);
        self::generateTranslation('vdo_br_opt2', [
            'pt-BR' => 'Privado - Visível apenas para você e seus amigos.'
        ]);
        self::generateTranslation('vdo_date_loc', [
            'pt-BR' => 'Data e Localização'
        ]);
        self::generateTranslation('vdo_date_rec', [
            'pt-BR' => 'Data de gravação'
        ]);
        self::generateTranslation('vdo_for_date', [
            'pt-BR' => 'formato MM / DD / YYYY '
        ]);
        self::generateTranslation('vdo_add_eg', [
            'pt-BR' => 'Exemplo: Gronelândia de Londres, Sialkot Mubarak Pura'
        ]);
        self::generateTranslation('vdo_share_opt', [
            'pt-BR' => 'Opções de compartilhamento e privacidade'
        ]);
        self::generateTranslation('vdo_allow_comm', [
            'pt-BR' => 'Permitir comentários '
        ]);
        self::generateTranslation('vdo_dallow_comm', [
            'pt-BR' => 'Não permitir comentários'
        ]);
        self::generateTranslation('vdo_comm_vote', [
            'pt-BR' => 'Votação de Comentários'
        ]);
        self::generateTranslation('vdo_allow_com_vote', [
            'pt-BR' => 'Permitir votação nos comentários'
        ]);
        self::generateTranslation('vdo_dallow_com_vote', [
            'pt-BR' => 'Não permitir nos comentários'
        ]);
        self::generateTranslation('vdo_allow_rating', [
            'pt-BR' => 'permitir avaliação neste vídeo'
        ]);
        self::generateTranslation('vdo_embedding', [
            'pt-BR' => 'Incorporação'
        ]);
        self::generateTranslation('vdo_embed_opt1', [
            'pt-BR' => 'As pessoas podem reproduzir este vídeo em outros sites'
        ]);
        self::generateTranslation('vdo_update_title', [
            'pt-BR' => 'Atualizar'
        ]);
        self::generateTranslation('vdo_inactive_msg', [
            'pt-BR' => 'Sua conta está inativa. Por favor ative-a para fazer upload de vídeos. Para ativar sua conta, por favor'
        ]);
        self::generateTranslation('vdo_click_here', [
            'pt-BR' => 'Clique Aqui'
        ]);
        self::generateTranslation('vdo_continue_upload', [
            'pt-BR' => 'Continuar para o envio'
        ]);
        self::generateTranslation('vdo_upload_step1', [
            'pt-BR' => 'Envio do vídeo'
        ]);
        self::generateTranslation('vdo_upload_step2', [
            'pt-BR' => 'Etapa do Vídeo %s/2'
        ]);
        self::generateTranslation('vdo_upload_step3', [
            'pt-BR' => '(Passo 2/2)'
        ]);
        self::generateTranslation('vdo_select_vdo', [
            'pt-BR' => 'Selecione um vídeo para enviar.'
        ]);
        self::generateTranslation('vdo_enter_remote_url', [
            'pt-BR' => 'Digite a URL do vídeo.'
        ]);
        self::generateTranslation('vdo_enter_embed_code_msg', [
            'pt-BR' => 'Insira o Código de Incorporação do Vídeo de outros sites, ou seja, Youtube ou Metacafe.'
        ]);
        self::generateTranslation('vdo_enter_embed_code', [
            'pt-BR' => 'Inserir Código de Incorporação'
        ]);
        self::generateTranslation('vdo_enter_druation', [
            'pt-BR' => 'Digite a duração'
        ]);
        self::generateTranslation('vdo_select_vdo_thumb', [
            'pt-BR' => 'Selecionar miniatura do vídeo'
        ]);
        self::generateTranslation('vdo_having_trouble', [
            'pt-BR' => 'Está com problemas?'
        ]);
        self::generateTranslation('vdo_if_having_problem', [
            'pt-BR' => 'se você estiver tendo problemas com o carregador'
        ]);
        self::generateTranslation('vdo_clic_to_manage_all', [
            'pt-BR' => 'Clique Aqui para Gerenciar Todos os Vídeos'
        ]);
        self::generateTranslation('vdo_manage_vdeos', [
            'pt-BR' => 'Gerenciar Vídeos '
        ]);
        self::generateTranslation('vdo_status', [
            'pt-BR' => 'Situação'
        ]);
        self::generateTranslation('vdo_rawfile', [
            'pt-BR' => 'RawFile'
        ]);
        self::generateTranslation('vdo_video_upload_complete', [
            'pt-BR' => 'Envio do Vídeo - Envio Completo'
        ]);
        self::generateTranslation('vdo_thanks_you_upload_complete_1', [
            'pt-BR' => 'Obrigado! Seu envio foi concluído'
        ]);
        self::generateTranslation('vdo_thanks_you_upload_complete_2', [
            'pt-BR' => 'Este vídeo estará disponível em'
        ]);
        self::generateTranslation('vdo_after_it_has_process', [
            'pt-BR' => 'após o processamento ter terminado.'
        ]);
        self::generateTranslation('vdo_embed_this_video_on_web', [
            'pt-BR' => 'Incorpore este vídeo no seu site.'
        ]);
        self::generateTranslation('vdo_copy_and_paste_the_code', [
            'pt-BR' => 'Copie e cole o código abaixo para incorporar este vídeo.'
        ]);
        self::generateTranslation('vdo_upload_another_video', [
            'pt-BR' => 'Enviar outro Vídeo'
        ]);
        self::generateTranslation('vdo_goto_my_videos', [
            'pt-BR' => 'Ir para Meus Vídeos'
        ]);
        self::generateTranslation('vdo_sperate_emails_by', [
            'pt-BR' => 'separe e-mails por vírgulas'
        ]);
        self::generateTranslation('vdo_personal_msg', [
            'pt-BR' => 'Mensagem Pessoal'
        ]);
        self::generateTranslation('vdo_related_tags', [
            'pt-BR' => 'Tags Relacionadas'
        ]);
        self::generateTranslation('vdo_reply_to_this', [
            'pt-BR' => 'Responder a este '
        ]);
        self::generateTranslation('vdo_add_reply', [
            'pt-BR' => 'Adicionar resposta'
        ]);
        self::generateTranslation('vdo_share_video', [
            'pt-BR' => 'Compartilhar Vídeo'
        ]);
        self::generateTranslation('vdo_about_this_video', [
            'pt-BR' => 'Sobre este vídeo'
        ]);
        self::generateTranslation('vdo_post_to_a_services', [
            'pt-BR' => 'Postar em um Serviço Agregador'
        ]);
        self::generateTranslation('vdo_commentary', [
            'pt-BR' => 'Comentário'
        ]);
        self::generateTranslation('vdo_post_a_comment', [
            'pt-BR' => 'Publicar um comentário'
        ]);
        self::generateTranslation('grp_add_vdo_msg', [
            'pt-BR' => 'Adicionar vídeos ao grupo '
        ]);
        self::generateTranslation('grp_no_vdo_msg', [
            'pt-BR' => 'Você não possui nenhum vídeo'
        ]);
        self::generateTranslation('grp_add_to', [
            'pt-BR' => 'Adicionar ao grupo'
        ]);
        self::generateTranslation('grp_add_vdos', [
            'pt-BR' => 'Adicionar vídeos'
        ]);
        self::generateTranslation('grp_name_title', [
            'pt-BR' => 'Nome do grupo'
        ]);
        self::generateTranslation('grp_tag_title', [
            'pt-BR' => 'Tags:'
        ]);
        self::generateTranslation('grp_des_title', [
            'pt-BR' => 'Descrição:'
        ]);
        self::generateTranslation('grp_tags_msg', [
            'pt-BR' => 'Insira uma ou mais tags, separadas por espaços.'
        ]);
        self::generateTranslation('grp_tags_msg1', [
            'pt-BR' => 'Insira uma ou mais tags, separadas por espaços. Tags são palavras-chave usadas para descrever o seu grupo, para que possa ser facilmente encontrado por outros usuários. Por exemplo, se temos um grupo para surfistas, podemos designá-lo: navegar, praia, ondas.'
        ]);
        self::generateTranslation('grp_url_title', [
            'pt-BR' => 'Escolha uma URL única para o nome do grupo:'
        ]);
        self::generateTranslation('grp_url_msg', [
            'pt-BR' => 'Insira 3-18 caracteres sem espaços (como «skates de skates»), que se tornarão parte do endereço web do seu grupo. Por favor, note que o nome do grupo escolhido é permanente e não pode ser alterado.'
        ]);
        self::generateTranslation('grp_cat_tile', [
            'pt-BR' => 'Categoria do Grupo:'
        ]);
        self::generateTranslation('grp_vdo_uploads', [
            'pt-BR' => 'Upload de vídeo:'
        ]);
        self::generateTranslation('grp_forum_posting', [
            'pt-BR' => 'Publicação no Fórum:'
        ]);
        self::generateTranslation('grp_join_opt1', [
            'pt-BR' => 'Público, qualquer um pode entrar.'
        ]);
        self::generateTranslation('grp_join_opt2', [
            'pt-BR' => 'Protegido, requer aprovação do fundador para entrar.'
        ]);
        self::generateTranslation('grp_join_opt3', [
            'pt-BR' => 'Privado, apenas por convite do fundador, somente membros podem ver os detalhes do grupo.'
        ]);
        self::generateTranslation('grp_vdo_opt1', [
            'pt-BR' => 'Postar vídeos imediatamente.'
        ]);
        self::generateTranslation('grp_vdo_opt2', [
            'pt-BR' => 'Aprovação de fundador necessária antes do vídeo estar disponível.'
        ]);
        self::generateTranslation('grp_vdo_opt3', [
            'pt-BR' => 'Somente o Fundador pode adicionar novos vídeos.'
        ]);
        self::generateTranslation('grp_post_opt1', [
            'pt-BR' => 'Publicar tópicos imediatamente.'
        ]);
        self::generateTranslation('grp_post_opt2', [
            'pt-BR' => 'É necessária a aprovação de fundador antes que o tópico esteja disponível.'
        ]);
        self::generateTranslation('grp_post_opt3', [
            'pt-BR' => 'Somente o fundador pode criar um novo tópico.'
        ]);
        self::generateTranslation('grp_crt_grp', [
            'pt-BR' => 'Criar grupo'
        ]);
        self::generateTranslation('grp_thumb_title', [
            'pt-BR' => 'Miniatura do Grupo'
        ]);
        self::generateTranslation('grp_upl_thumb', [
            'pt-BR' => 'Enviar Miniatura do Grupo'
        ]);
        self::generateTranslation('grp_must_be', [
            'pt-BR' => 'Deve ser'
        ]);
        self::generateTranslation('grp_90x90', [
            'pt-BR' => '90  x 90 de tamanho dará a melhor qualidade'
        ]);
        self::generateTranslation('grp_thumb_warn', [
            'pt-BR' => 'Não Envie Material Vulgar/Pornografico ou Com Direitos Autorais'
        ]);
        self::generateTranslation('grp_del_confirm', [
            'pt-BR' => 'Você tem certeza que deseja excluir este grupo'
        ]);
        self::generateTranslation('grp_del_success', [
            'pt-BR' => 'Você excluiu com sucesso'
        ]);
        self::generateTranslation('grp_click_go_grps', [
            'pt-BR' => 'Clique Aqui Para Ir Para Os Grupos'
        ]);
        self::generateTranslation('grp_edit_grp_title', [
            'pt-BR' => 'Editar Grupo'
        ]);
        self::generateTranslation('grp_manage_vdos', [
            'pt-BR' => 'Gerenciar Vídeos'
        ]);
        self::generateTranslation('grp_manage_mems', [
            'pt-BR' => 'Gerenciar Membros'
        ]);
        self::generateTranslation('grp_del_group_title', [
            'pt-BR' => 'Excluir grupo'
        ]);
        self::generateTranslation('grp_add_vdos_title', [
            'pt-BR' => 'Adicionar vídeos'
        ]);
        self::generateTranslation('grp_join_grp_title', [
            'pt-BR' => 'Juntar-se ao grupo'
        ]);
        self::generateTranslation('grp_leave_group_title', [
            'pt-BR' => 'Deixar o Grupo'
        ]);
        self::generateTranslation('grp_invite_grp_title', [
            'pt-BR' => 'Convidar Membros'
        ]);
        self::generateTranslation('grp_view_mems', [
            'pt-BR' => 'Ver Membros'
        ]);
        self::generateTranslation('grp_view_vdos', [
            'pt-BR' => 'Ver vídeos'
        ]);
        self::generateTranslation('grp_create_grp_title', [
            'pt-BR' => 'Criar um novo grupo'
        ]);
        self::generateTranslation('grp_most_members', [
            'pt-BR' => 'Mais Membros'
        ]);
        self::generateTranslation('grp_most_discussed', [
            'pt-BR' => 'Mais discutidos'
        ]);
        self::generateTranslation('grp_invite_msg', [
            'pt-BR' => 'Convidar usuários para este grupo'
        ]);
        self::generateTranslation('grp_invite_msg1', [
            'pt-BR' => 'Convidou você para se juntar'
        ]);
        self::generateTranslation('grp_invite_msg2', [
            'pt-BR' => 'Digite os E-mails ou nomes de usuário (separados por vírgulas)'
        ]);
        self::generateTranslation('grp_url_title1', [
            'pt-BR' => 'URL do grupo'
        ]);
        self::generateTranslation('grp_invite_msg3', [
            'pt-BR' => 'Enviar convite'
        ]);
        self::generateTranslation('grp_join_confirm_msg', [
            'pt-BR' => 'Você tem certeza que quer se juntar a este grupo'
        ]);
        self::generateTranslation('grp_join_msg_succ', [
            'pt-BR' => 'Você entrou no grupo com sucesso'
        ]);
        self::generateTranslation('grp_click_here_to_go', [
            'pt-BR' => 'Clique Aqui para ir para'
        ]);
        self::generateTranslation('grp_leave_confirm', [
            'pt-BR' => 'Você tem certeza que quer sair deste grupo'
        ]);
        self::generateTranslation('grp_leave_succ_msg', [
            'pt-BR' => 'Você saiu do grupo'
        ]);
        self::generateTranslation('grp_manage_members_title', [
            'pt-BR' => 'Gerenciar Membros '
        ]);
        self::generateTranslation('grp_for_approval', [
            'pt-BR' => 'Para aprovação'
        ]);
        self::generateTranslation('grp_rm_videos', [
            'pt-BR' => 'Remover Vídeos'
        ]);
        self::generateTranslation('grp_rm_mems', [
            'pt-BR' => 'Remover Membros'
        ]);
        self::generateTranslation('grp_groups_title', [
            'pt-BR' => 'Gerenciar Grupos'
        ]);
        self::generateTranslation('grp_joined_title', [
            'pt-BR' => 'Gerenciar Grupos Cadastrados'
        ]);
        self::generateTranslation('grp_remove_group', [
            'pt-BR' => 'Remover Grupo'
        ]);
        self::generateTranslation('grp_bo_grp_found', [
            'pt-BR' => 'Nenhum grupo encontrado'
        ]);
        self::generateTranslation('grp_joined_groups', [
            'pt-BR' => 'Grupos que Juntou-se'
        ]);
        self::generateTranslation('grp_owned_groups', [
            'pt-BR' => 'Grupos que é Dono'
        ]);
        self::generateTranslation('grp_edit_this_grp', [
            'pt-BR' => 'Editar este grupo'
        ]);
        self::generateTranslation('grp_topics_title', [
            'pt-BR' => 'Tópicos'
        ]);
        self::generateTranslation('grp_topic_title', [
            'pt-BR' => 'Tópico'
        ]);
        self::generateTranslation('grp_posts_title', [
            'pt-BR' => 'Postagens'
        ]);
        self::generateTranslation('grp_discus_title', [
            'pt-BR' => 'Discussões'
        ]);
        self::generateTranslation('grp_author_title', [
            'pt-BR' => 'Autor'
        ]);
        self::generateTranslation('grp_replies_title', [
            'pt-BR' => 'Respostas'
        ]);
        self::generateTranslation('grp_last_post_title', [
            'pt-BR' => 'Última postagem '
        ]);
        self::generateTranslation('grp_viewl_all_videos', [
            'pt-BR' => 'Ver todos os vídeos deste grupo'
        ]);
        self::generateTranslation('grp_add_new_topic', [
            'pt-BR' => 'Adicionar Novo Tópico'
        ]);
        self::generateTranslation('grp_attach_video', [
            'pt-BR' => 'Anexar vídeo '
        ]);
        self::generateTranslation('grp_add_topic', [
            'pt-BR' => 'Adicionar Tópico'
        ]);
        self::generateTranslation('grp_please_login', [
            'pt-BR' => 'Por favor, entre para postar tópicos'
        ]);
        self::generateTranslation('grp_please_join', [
            'pt-BR' => 'Por favor, junte-se a este grupo para postar tópicos'
        ]);
        self::generateTranslation('grp_inactive_account', [
            'pt-BR' => 'Sua Conta Está Inativa e Requer Ativação do Proprietário do Grupo'
        ]);
        self::generateTranslation('grp_about_this_grp', [
            'pt-BR' => 'Sobre este grupo '
        ]);
        self::generateTranslation('grp_no_vdo_err', [
            'pt-BR' => 'Este Grupo Não Tem Videos'
        ]);
        self::generateTranslation('grp_posted_by', [
            'pt-BR' => 'Publicado por'
        ]);
        self::generateTranslation('grp_add_new_comment', [
            'pt-BR' => 'Adicionar Novo Comentário'
        ]);
        self::generateTranslation('grp_add_comment', [
            'pt-BR' => 'Adicionar Comentário'
        ]);
        self::generateTranslation('grp_pls_login_comment', [
            'pt-BR' => 'Por favor conecte-se para postar comentários'
        ]);
        self::generateTranslation('grp_pls_join_comment', [
            'pt-BR' => 'Por favor, junte-se a este grupo para enviar comentários'
        ]);
        self::generateTranslation('usr_activation_title', [
            'pt-BR' => 'Ativação do usuário'
        ]);
        self::generateTranslation('usr_actiavation_msg', [
            'pt-BR' => 'Digite seu nome de usuário e código de ativação que foram enviados para seu e-mail.'
        ]);
        self::generateTranslation('usr_actiavation_msg1', [
            'pt-BR' => 'Solicitar Código de Ativação'
        ]);
        self::generateTranslation('usr_activation_code_tl', [
            'pt-BR' => 'Código de Ativação'
        ]);
        self::generateTranslation('usr_compose_msg', [
            'pt-BR' => 'Compor Mensagem'
        ]);
        self::generateTranslation('usr_inbox_title', [
            'pt-BR' => 'Caixa de entrada'
        ]);
        self::generateTranslation('usr_sent_title', [
            'pt-BR' => 'Enviado'
        ]);
        self::generateTranslation('usr_to_title', [
            'pt-BR' => 'Para: (Digite o nome do usuário)'
        ]);
        self::generateTranslation('usr_or_select_frm_list', [
            'pt-BR' => 'ou selecione da lista de contatos'
        ]);
        self::generateTranslation('usr_attach_video', [
            'pt-BR' => 'Anexar vídeo'
        ]);
        self::generateTranslation('user_attached_video', [
            'pt-BR' => 'Vídeo anexado'
        ]);
        self::generateTranslation('usr_send_message', [
            'pt-BR' => 'Enviar mensagem'
        ]);
        self::generateTranslation('user_no_message', [
            'pt-BR' => 'Sem Mensagem'
        ]);
        self::generateTranslation('user_delete_message_msg', [
            'pt-BR' => 'Excluir esta mensagem'
        ]);
        self::generateTranslation('user_forgot_message', [
            'pt-BR' => 'Esqueci a senha'
        ]);
        self::generateTranslation('user_forgot_message_2', [
            'pt-BR' => 'Não se preocupe, recupere-o agora'
        ]);
        self::generateTranslation('user_pass_reset_msg', [
            'pt-BR' => 'Redefinir senha'
        ]);
        self::generateTranslation('user_pass_forgot_msg', [
            'pt-BR' => 'se você esqueceu sua senha, digite seu nome de usuário e código de verificação na caixa, e instruções para redefinir a senha serão enviadas para sua caixa de correio.'
        ]);
        self::generateTranslation('user_veri_code', [
            'pt-BR' => 'Código de Verificação'
        ]);
        self::generateTranslation('user_reocover_user', [
            'pt-BR' => 'Recuperar Usuário'
        ]);
        self::generateTranslation('user_user_forgot_msg', [
            'pt-BR' => 'Esqueceu o seu nome de usuário?'
        ]);
        self::generateTranslation('user_recover', [
            'pt-BR' => 'Recuperar'
        ]);
        self::generateTranslation('user_reset', [
            'pt-BR' => 'Redefinir'
        ]);
        self::generateTranslation('user_inactive_msg', [
            'pt-BR' => 'Sua conta está inativa, por favor ative sua conta indo para a <a href=\"./activation.php\">página de ativação</a>'
        ]);
        self::generateTranslation('user_dashboard', [
            'pt-BR' => 'Painel'
        ]);
        self::generateTranslation('user_manage_prof_chnnl', [
            'pt-BR' => 'Gerenciar Perfil &amp; Canal'
        ]);
        self::generateTranslation('user_manage_friends', [
            'pt-BR' => 'Gerenciar Amigos &amp; Contatos'
        ]);
        self::generateTranslation('user_prof_channel', [
            'pt-BR' => 'Perfil/Canal'
        ]);
        self::generateTranslation('user_message_box', [
            'pt-BR' => 'Caixa de Mensagem'
        ]);
        self::generateTranslation('user_new_messages', [
            'pt-BR' => 'Novas mensagens'
        ]);
        self::generateTranslation('user_goto_inbox', [
            'pt-BR' => 'Ir para Caixa de entrada'
        ]);
        self::generateTranslation('user_goto_sentbox', [
            'pt-BR' => 'Ir para Caixa de Envios'
        ]);
        self::generateTranslation('user_compose_new', [
            'pt-BR' => 'Compor novas mensagens'
        ]);
        self::generateTranslation('user_total_subs_users', [
            'pt-BR' => 'Total de usuários inscritos'
        ]);
        self::generateTranslation('user_you_have', [
            'pt-BR' => 'Você possui'
        ]);
        self::generateTranslation('user_fav_videos', [
            'pt-BR' => 'Vídeos Favoritos'
        ]);
        self::generateTranslation('user_your_vids_watched', [
            'pt-BR' => 'Seus vídeos assistidos'
        ]);
        self::generateTranslation('user_times', [
            'pt-BR' => 'Tempos'
        ]);
        self::generateTranslation('user_you_have_watched', [
            'pt-BR' => 'Você assistiu'
        ]);
        self::generateTranslation('user_channel_profiles', [
            'pt-BR' => 'Canal e Perfil'
        ]);
        self::generateTranslation('user_channel_views', [
            'pt-BR' => 'Visualizações do canal'
        ]);
        self::generateTranslation('user_channel_comm', [
            'pt-BR' => 'Comentários do Canal '
        ]);
        self::generateTranslation('user_manage_prof', [
            'pt-BR' => 'Gerenciar Perfil / Canal'
        ]);
        self::generateTranslation('user_you_created', [
            'pt-BR' => 'Você criou'
        ]);
        self::generateTranslation('user_you_joined', [
            'pt-BR' => 'Você se juntou'
        ]);
        self::generateTranslation('user_create_group', [
            'pt-BR' => 'Criar Novo Grupo'
        ]);
        self::generateTranslation('user_manage_my_account', [
            'pt-BR' => 'Gerenciar minha conta '
        ]);
        self::generateTranslation('user_manage_my_videos', [
            'pt-BR' => 'Gerenciar Meus Vídeos'
        ]);
        self::generateTranslation('user_manage_my_channel', [
            'pt-BR' => 'Gerenciar Meu Canal'
        ]);
        self::generateTranslation('user_sent_box', [
            'pt-BR' => 'Meus itens enviados'
        ]);
        self::generateTranslation('user_manage_channel', [
            'pt-BR' => 'Gerenciar Canal'
        ]);
        self::generateTranslation('user_manage_my_contacts', [
            'pt-BR' => 'Gerenciar Meus Contatos'
        ]);
        self::generateTranslation('user_manage_contacts', [
            'pt-BR' => 'Gerenciar Contatos'
        ]);
        self::generateTranslation('user_manage_favourites', [
            'pt-BR' => 'Gerenciar Vídeos Favoritos'
        ]);
        self::generateTranslation('user_mem_login', [
            'pt-BR' => 'Acesso de membros'
        ]);
        self::generateTranslation('user_already_have', [
            'pt-BR' => 'Por favor, entre aqui se você já tem uma conta de'
        ]);
        self::generateTranslation('user_forgot_username', [
            'pt-BR' => 'Esqueceu o seu nome de usuário'
        ]);
        self::generateTranslation('user_forgot_password', [
            'pt-BR' => 'Esqueci minha senha'
        ]);
        self::generateTranslation('user_create_your', [
            'pt-BR' => 'Crie o seu '
        ]);
        self::generateTranslation('all_fields_req', [
            'pt-BR' => 'Todos os campos são obrigatórios'
        ]);
        self::generateTranslation('user_valid_email_addr', [
            'pt-BR' => 'Endereço de e-mail válido'
        ]);
        self::generateTranslation('user_allowed_format', [
            'pt-BR' => 'Letras A-Z ou a-z, Números 0-9 e Sub-sublinhados _'
        ]);
        self::generateTranslation('user_confirm_pass', [
            'pt-BR' => 'Confirmar Senha'
        ]);
        self::generateTranslation('user_reg_msg_0', [
            'pt-BR' => 'Registrar como '
        ]);
        self::generateTranslation('user_reg_msg_1', [
            'pt-BR' => 'membro, sua versão gratuita e fácil apenas preencha o formulário abaixo'
        ]);
        self::generateTranslation('user_date_of_birth', [
            'pt-BR' => 'Data de nascimento'
        ]);
        self::generateTranslation('user_enter_text_as_img', [
            'pt-BR' => 'Digite o texto como visto na imagem'
        ]);
        self::generateTranslation('user_refresh_img', [
            'pt-BR' => 'Atualizar imagem'
        ]);
        self::generateTranslation('user_i_agree_to_the', [
            'pt-BR' => 'Concordo com os  <a href=\"%s\" target=\"_blank\">Termos de Serviço</a> e com a <a href=\"%s\" target=\"_blank\" >Política de Privacidade</a>'
        ]);
        self::generateTranslation('user_thanks_for_reg', [
            'pt-BR' => 'Obrigado por registrar-se no '
        ]);
        self::generateTranslation('user_email_has_sent', [
            'pt-BR' => 'Um e-mail foi enviado para sua caixa de entrada contendo sua conta'
        ]);
        self::generateTranslation('user_and_activation', [
            'pt-BR' => '&amp; Ativação'
        ]);
        self::generateTranslation('user_details_you_now', [
            'pt-BR' => 'Detalhes. Agora você pode fazer as seguintes coisas em nossa rede'
        ]);
        self::generateTranslation('user_upload_share_vds', [
            'pt-BR' => 'Enviar, Compartilhar Vídeos'
        ]);
        self::generateTranslation('user_make_friends', [
            'pt-BR' => 'Fazer Amigos'
        ]);
        self::generateTranslation('user_send_messages', [
            'pt-BR' => 'Enviar mensagens'
        ]);
        self::generateTranslation('user_grow_your_network', [
            'pt-BR' => 'Aumente suas redes convidando mais amigos'
        ]);
        self::generateTranslation('user_rate_comment', [
            'pt-BR' => 'Avaliar e comentar vídeos'
        ]);
        self::generateTranslation('user_make_customize', [
            'pt-BR' => 'Faça e Personalize seu Canal'
        ]);
        self::generateTranslation('user_to_upload_vid', [
            'pt-BR' => 'Para Fazer Upload de Vídeo, É necessário ativar a sua conta primeiro, Os detalhes de ativação foram enviados para sua conta de e-mail, pode levar algumas vezes para chegar à sua caixa de entrada'
        ]);
        self::generateTranslation('user_click_to_login', [
            'pt-BR' => 'Clique aqui para acessar sua conta'
        ]);
        self::generateTranslation('user_view_my_channel', [
            'pt-BR' => 'Ver Meu Canal'
        ]);
        self::generateTranslation('user_change_pass', [
            'pt-BR' => 'Alterar senha'
        ]);
        self::generateTranslation('user_email_settings', [
            'pt-BR' => 'Configurações de email'
        ]);
        self::generateTranslation('user_profile_settings', [
            'pt-BR' => 'Opções do perfil'
        ]);
        self::generateTranslation('user_usr_prof_chnl_edit', [
            'pt-BR' => 'Editar Perfil de Usuário &amp; Canal'
        ]);
        self::generateTranslation('user_personal_info', [
            'pt-BR' => 'Informações Pessoais'
        ]);
        self::generateTranslation('user_fname', [
            'pt-BR' => 'Nome'
        ]);
        self::generateTranslation('user_lname', [
            'pt-BR' => 'Sobrenome'
        ]);
        self::generateTranslation('user_gender', [
            'pt-BR' => 'Sexo'
        ]);
        self::generateTranslation('user_relat_status', [
            'pt-BR' => 'Estado de relacionamento'
        ]);
        self::generateTranslation('user_display_age', [
            'pt-BR' => 'Mostrar idade'
        ]);
        self::generateTranslation('user_about_me', [
            'pt-BR' => 'Sobre mim'
        ]);
        self::generateTranslation('user_website_url', [
            'pt-BR' => 'URL do website'
        ]);
        self::generateTranslation('user_eg_website', [
            'pt-BR' => 'e.g www.seusite.com'
        ]);
        self::generateTranslation('user_prof_info', [
            'pt-BR' => 'Informações Profissionais'
        ]);
        self::generateTranslation('user_education', [
            'pt-BR' => 'Educação'
        ]);
        self::generateTranslation('user_school_colleges', [
            'pt-BR' => 'Escolas / Faculdades'
        ]);
        self::generateTranslation('user_occupations', [
            'pt-BR' => 'Ocupação(ões)'
        ]);
        self::generateTranslation('user_companies', [
            'pt-BR' => 'Empresas'
        ]);
        self::generateTranslation('user_sperate_by_commas', [
            'pt-BR' => 'separados por vírgulas'
        ]);
        self::generateTranslation('user_interests_hobbies', [
            'pt-BR' => 'Interesses e Hobbies'
        ]);
        self::generateTranslation('user_fav_movs_shows', [
            'pt-BR' => 'Filmes favoritos &amp; Séries'
        ]);
        self::generateTranslation('user_fav_music', [
            'pt-BR' => 'Músicas Favoritas'
        ]);
        self::generateTranslation('user_fav_books', [
            'pt-BR' => 'Livros Favoritos'
        ]);
        self::generateTranslation('user_user_avatar', [
            'pt-BR' => 'Avatar de usuário'
        ]);
        self::generateTranslation('user_upload_avatar', [
            'pt-BR' => 'Enviar avatar'
        ]);
        self::generateTranslation('user_channel_info', [
            'pt-BR' => 'Informações do canal'
        ]);
        self::generateTranslation('user_channel_title', [
            'pt-BR' => 'Título do Canal'
        ]);
        self::generateTranslation('user_channel_description', [
            'pt-BR' => 'Descrição do canal'
        ]);
        self::generateTranslation('user_channel_permission', [
            'pt-BR' => 'Permissões do canal'
        ]);
        self::generateTranslation('user_allow_comments_msg', [
            'pt-BR' => 'Usuários podem comentar'
        ]);
        self::generateTranslation('user_dallow_comments_msg', [
            'pt-BR' => 'Usuários não podem comentar'
        ]);
        self::generateTranslation('user_allow_rating', [
            'pt-BR' => 'Permitir avaliação'
        ]);
        self::generateTranslation('user_dallow_rating', [
            'pt-BR' => 'Não permitir avaliação'
        ]);
        self::generateTranslation('user_allow_rating_msg1', [
            'pt-BR' => 'Usuários podem avaliar'
        ]);
        self::generateTranslation('user_dallow_rating_msg1', [
            'pt-BR' => 'Usuários não podem avaliar'
        ]);
        self::generateTranslation('user_channel_feature_vid', [
            'pt-BR' => 'Vídeo em destaque do canal'
        ]);
        self::generateTranslation('user_select_vid_for_fr', [
            'pt-BR' => 'Selecione o Vídeo para Definir como Destaque'
        ]);
        self::generateTranslation('user_chane_channel_bg', [
            'pt-BR' => 'Alterar fundo do canal'
        ]);
        self::generateTranslation('user_remove_bg', [
            'pt-BR' => 'Remover fundo'
        ]);
        self::generateTranslation('user_currently_you_d_have_pic', [
            'pt-BR' => 'Atualmente você não possui uma Imagem de Fundo'
        ]);
        self::generateTranslation('user_change_email', [
            'pt-BR' => 'Alterar Email'
        ]);
        self::generateTranslation('user_email_address', [
            'pt-BR' => 'Endereço de e-mail'
        ]);
        self::generateTranslation('user_new_email', [
            'pt-BR' => 'Novo e-mail'
        ]);
        self::generateTranslation('user_notify_me', [
            'pt-BR' => 'Notificar-me quando o usuário me enviar uma mensagem'
        ]);
        self::generateTranslation('user_old_pass', [
            'pt-BR' => 'Senha Antiga'
        ]);
        self::generateTranslation('user_new_pass', [
            'pt-BR' => 'Nova senha'
        ]);
        self::generateTranslation('user_c_new_pass', [
            'pt-BR' => 'Confirmar Nova Senha'
        ]);
        self::generateTranslation('user_doesnt_exist', [
            'pt-BR' => 'O usuário não existe'
        ]);
        self::generateTranslation('user_do_not_have_contact', [
            'pt-BR' => 'O usuário não possui nenhum contato'
        ]);
        self::generateTranslation('user_no_fav_video_exist', [
            'pt-BR' => 'Usuário não tem nenhum vídeo favorito selecionado'
        ]);
        self::generateTranslation('user_have_no_vide', [
            'pt-BR' => 'O usuário não possui vídeos'
        ]);
        self::generateTranslation('user_s_channel', [
            'pt-BR' => 'Canal de %s'
        ]);
        self::generateTranslation('user_last_login', [
            'pt-BR' => 'Última Conexão'
        ]);
        self::generateTranslation('user_send_message', [
            'pt-BR' => 'Enviar mensagem'
        ]);
        self::generateTranslation('user_add_contact', [
            'pt-BR' => 'Adicionar contato'
        ]);
        self::generateTranslation('user_dob', [
            'pt-BR' => 'DoB'
        ]);
        self::generateTranslation('user_movies_shows', [
            'pt-BR' => 'Filmes &amp; Séries'
        ]);
        self::generateTranslation('user_add_comment', [
            'pt-BR' => 'Adicionar Comentário '
        ]);
        self::generateTranslation('user_no_fr_video', [
            'pt-BR' => 'O usuário não selecionou nenhum vídeo para definir como destaque'
        ]);
        self::generateTranslation('user_view_all_video_of', [
            'pt-BR' => 'Ver Todos os Vídeos de '
        ]);
        self::generateTranslation('menu_home', [
            'pt-BR' => 'Início'
        ]);
        self::generateTranslation('menu_inbox', [
            'pt-BR' => 'Caixa de entrada'
        ]);
        self::generateTranslation('vdo_cat_err2', [
            'pt-BR' => 'Você não pode selecionar mais de %d categorias'
        ]);
        self::generateTranslation('user_subscribe_message', [
            'pt-BR' => 'Olá %subscriber%\nVocê se inscreveu no %user% e portanto esta mensagem é enviada para você automaticamente, porque %user% enviou um novo vídeo\n\n%website_title%'
        ]);
        self::generateTranslation('user_subscribe_subject', [
            'pt-BR' => '%user% enviou um novo vídeo'
        ]);
        self::generateTranslation('you_already_logged', [
            'pt-BR' => 'Você já está logado'
        ]);
        self::generateTranslation('you_not_logged_in', [
            'pt-BR' => 'Você não está logado'
        ]);
        self::generateTranslation('invalid_user', [
            'pt-BR' => 'Usuário Inválido'
        ]);
        self::generateTranslation('vdo_cat_err3', [
            'pt-BR' => 'Por favor, selecione pelo menos uma categoria'
        ]);
        self::generateTranslation('embed_code_invalid_err', [
            'pt-BR' => 'Código de incorporação de vídeo inválido'
        ]);
        self::generateTranslation('invalid_duration', [
            'pt-BR' => 'Duração inválida'
        ]);
        self::generateTranslation('vid_thumb_changed', [
            'pt-BR' => 'Miniatura padrão do vídeo foi alterada'
        ]);
        self::generateTranslation('vid_thumb_change_err', [
            'pt-BR' => 'Miniatura de vídeo não encontrada'
        ]);
        self::generateTranslation('upload_vid_thumbs_msg', [
            'pt-BR' => 'Todas as miniaturas de vídeo foram carregadas'
        ]);
        self::generateTranslation('video_thumb_delete_msg', [
            'pt-BR' => 'A miniatura do vídeo foi excluída'
        ]);
        self::generateTranslation('video_thumb_delete_err', [
            'pt-BR' => 'Não foi possível excluir a miniatura do vídeo'
        ]);
        self::generateTranslation('no_comment_del_perm', [
            'pt-BR' => 'Você não tem permissão para excluir este comentário'
        ]);
        self::generateTranslation('my_text_context', [
            'pt-BR' => 'Meu contexto de teste'
        ]);
        self::generateTranslation('user_contains_disallow_err', [
            'pt-BR' => 'Nome de usuário contém caracteres não permitidos'
        ]);
        self::generateTranslation('add_cat_erro', [
            'pt-BR' => 'A categoria já existe'
        ]);
        self::generateTranslation('add_cat_no_name_err', [
            'pt-BR' => 'Por favor, digite um nome para a categoria'
        ]);
        self::generateTranslation('cat_default_err', [
            'pt-BR' => 'O padrão não pode ser excluído, por favor, escolha outra categoria como «padrão» e apague esta'
        ]);
        self::generateTranslation('pic_upload_vali_err', [
            'pt-BR' => 'Por favor, carregue uma imagem válida de JPG, GIF ou PNG'
        ]);
        self::generateTranslation('cat_dir_make_err', [
            'pt-BR' => 'Não foi possível criar o diretório de miniaturas da categoria'
        ]);
        self::generateTranslation('cat_set_default_ok', [
            'pt-BR' => 'A categoria foi definida como padrão'
        ]);
        self::generateTranslation('vid_thumb_removed_msg', [
            'pt-BR' => 'Miniaturas de vídeo removidas'
        ]);
        self::generateTranslation('vid_files_removed_msg', [
            'pt-BR' => 'Os arquivos de vídeo foram removidos'
        ]);
        self::generateTranslation('vid_log_delete_msg', [
            'pt-BR' => 'O registro de vídeo foi excluído'
        ]);
        self::generateTranslation('vdo_multi_del_erro', [
            'pt-BR' => 'Os vídeos foram excluídos'
        ]);
        self::generateTranslation('add_fav_message', [
            'pt-BR' => 'Este %s foi adicionado aos seus favoritos'
        ]);
        self::generateTranslation('obj_not_exists', [
            'pt-BR' => '%s não existe'
        ]);
        self::generateTranslation('already_fav_message', [
            'pt-BR' => 'Este %s já foi adicionado aos seus favoritos'
        ]);
        self::generateTranslation('obj_report_msg', [
            'pt-BR' => 'Este %s foi reportado'
        ]);
        self::generateTranslation('obj_report_err', [
            'pt-BR' => 'Você já denunciou este %s'
        ]);
        self::generateTranslation('user_no_exist_wid_username', [
            'pt-BR' => '\'%s\' não existe'
        ]);
        self::generateTranslation('share_video_no_user_err', [
            'pt-BR' => 'Por favor insira nomes de usuário ou e-mails para enviar este %s'
        ]);
        self::generateTranslation('today', [
            'pt-BR' => 'Hoje'
        ]);
        self::generateTranslation('yesterday', [
            'pt-BR' => 'Ontem'
        ]);
        self::generateTranslation('thisweek', [
            'pt-BR' => 'Esta Semana'
        ]);
        self::generateTranslation('lastweek', [
            'pt-BR' => 'Última Semana'
        ]);
        self::generateTranslation('thismonth', [
            'pt-BR' => 'Este Mês'
        ]);
        self::generateTranslation('lastmonth', [
            'pt-BR' => 'Último Mês'
        ]);
        self::generateTranslation('thisyear', [
            'pt-BR' => 'Este Ano'
        ]);
        self::generateTranslation('lastyear', [
            'pt-BR' => 'Último Ano'
        ]);
        self::generateTranslation('favorites', [
            'pt-BR' => 'Favoritos'
        ]);
        self::generateTranslation('alltime', [
            'pt-BR' => 'Desde o Inicio'
        ]);
        self::generateTranslation('insufficient_privileges_loggin', [
            'pt-BR' => 'Você não pode acessar esta página, faça o login ou registre-se'
        ]);
        self::generateTranslation('profile_title', [
            'pt-BR' => 'Título de Perfil'
        ]);
        self::generateTranslation('show_dob', [
            'pt-BR' => 'Mostrar Data de Nascimento'
        ]);
        self::generateTranslation('profile_tags', [
            'pt-BR' => 'Tags do Perfil'
        ]);
        self::generateTranslation('profile_desc', [
            'pt-BR' => 'Descrição do perfil'
        ]);
        self::generateTranslation('online_status', [
            'pt-BR' => 'Situação do Usuário'
        ]);
        self::generateTranslation('show_profile', [
            'pt-BR' => 'Mostrar Perfil'
        ]);
        self::generateTranslation('allow_ratings', [
            'pt-BR' => 'Permitir avaliações de perfil'
        ]);
        self::generateTranslation('postal_code', [
            'pt-BR' => 'Código postal'
        ]);
        self::generateTranslation('temp_file_load_err', [
            'pt-BR' => 'Não foi possível carregar o arquivo de tempalte \'%s\' no diretório \'%s\''
        ]);
        self::generateTranslation('no_date_provided', [
            'pt-BR' => 'Nenhuma data fornecida'
        ]);
        self::generateTranslation('bad_date', [
            'pt-BR' => 'Nunca'
        ]);
        self::generateTranslation('users_videos', [
            'pt-BR' => 'Vídeos de %s'
        ]);
        self::generateTranslation('please_login_subscribe', [
            'pt-BR' => 'Por favor, faça o login para inscrever-se em %s'
        ]);
        self::generateTranslation('users_subscribers', [
            'pt-BR' => 'Inscritos de %s'
        ]);
        self::generateTranslation('user_no_subscribers', [
            'pt-BR' => '%s não tem inscritos'
        ]);
        self::generateTranslation('user_subscriptions', [
            'pt-BR' => 'Inscrições de %s'
        ]);
        self::generateTranslation('user_no_subscriptions', [
            'pt-BR' => '%s não possui inscrições'
        ]);
        self::generateTranslation('usr_avatar_bg_update', [
            'pt-BR' => 'O avatar do usuário e o plano de fundo foram atualizados'
        ]);
        self::generateTranslation('user_email_confirm_email_err', [
            'pt-BR' => 'Confirmar e-mail incorreto'
        ]);
        self::generateTranslation('email_change_msg', [
            'pt-BR' => 'E-mail foi alterado com sucesso'
        ]);
        self::generateTranslation('no_edit_video', [
            'pt-BR' => 'Você não pode editar este vídeo'
        ]);
        self::generateTranslation('confirm_del_video', [
            'pt-BR' => 'Tem certeza de que deseja excluir este vídeo?'
        ]);
        self::generateTranslation('remove_fav_video_confirm', [
            'pt-BR' => 'Tem certeza de que deseja remover este vídeo dos seus favoritos?'
        ]);
        self::generateTranslation('remove_fav_collection_confirm', [
            'pt-BR' => 'Tem certeza de que deseja remover esta coleção dos seus favoritos?'
        ]);
        self::generateTranslation('fav_remove_msg', [
            'pt-BR' => '%s foi removido dos seus favoritos'
        ]);
        self::generateTranslation('unknown_favorite', [
            'pt-BR' => 'Favoritos desconhecidos %s'
        ]);
        self::generateTranslation('vdo_multi_del_fav_msg', [
            'pt-BR' => 'Os vídeos foram removidos dos seus favoritos'
        ]);
        self::generateTranslation('unknown_sender', [
            'pt-BR' => 'Remetente desconhecido'
        ]);
        self::generateTranslation('please_enter_message', [
            'pt-BR' => 'Por favor, digite algo para a mensagem'
        ]);
        self::generateTranslation('unknown_reciever', [
            'pt-BR' => 'Destinatário desconhecido'
        ]);
        self::generateTranslation('no_pm_exist', [
            'pt-BR' => 'A mensagem privada não existe'
        ]);
        self::generateTranslation('pm_sent_success', [
            'pt-BR' => 'Mensagem privada enviada com sucesso'
        ]);
        self::generateTranslation('msg_delete_inbox', [
            'pt-BR' => 'A mensagem foi excluída da caixa de entrada'
        ]);
        self::generateTranslation('msg_delete_outbox', [
            'pt-BR' => 'A mensagem foi excluída da sua caixa de saída'
        ]);
        self::generateTranslation('private_messags_deleted', [
            'pt-BR' => 'As mensagens privadas foram excluídas'
        ]);
        self::generateTranslation('ban_users', [
            'pt-BR' => 'Banir Usuários'
        ]);
        self::generateTranslation('spe_users_by_comma', [
            'pt-BR' => 'separar nomes de usuários por vírgula'
        ]);
        self::generateTranslation('user_ban_msg', [
            'pt-BR' => 'Lista de bloqueio de usuários atualizada'
        ]);
        self::generateTranslation('no_user_ban_msg', [
            'pt-BR' => 'Nenhum usuário foi banido da sua conta!'
        ]);
        self::generateTranslation('thnx_sharing_msg', [
            'pt-BR' => 'Obrigado por compartilhar %s'
        ]);
        self::generateTranslation('no_own_commen_rate', [
            'pt-BR' => 'Você não pode avaliar seu próprio comentário'
        ]);
        self::generateTranslation('no_comment_exists', [
            'pt-BR' => 'O comentário não existe'
        ]);
        self::generateTranslation('thanks_rating_comment', [
            'pt-BR' => 'Obrigado por avaliar o comentário'
        ]);
        self::generateTranslation('please_login_create_playlist', [
            'pt-BR' => 'Por favor, faça login para criar listas de reprodução'
        ]);
        self::generateTranslation('user_have_no_playlists', [
            'pt-BR' => 'O usuário não possui listas de reprodução'
        ]);
        self::generateTranslation('play_list_with_this_name_arlready_exists', [
            'pt-BR' => 'Já existe uma lista de reprodução com o nome \'%s\''
        ]);
        self::generateTranslation('please_enter_playlist_name', [
            'pt-BR' => 'Digite o nome da lista de reprodução'
        ]);
        self::generateTranslation('new_playlist_created', [
            'pt-BR' => 'Nova playlist criada com sucesso'
        ]);
        self::generateTranslation('playlist_not_exist', [
            'pt-BR' => 'A lista de reprodução não existe'
        ]);
        self::generateTranslation('playlist_item_not_exist', [
            'pt-BR' => 'O item na lista de reprodução não existe'
        ]);
        self::generateTranslation('playlist_item_delete', [
            'pt-BR' => 'O item da lista de reprodução foi excluído'
        ]);
        self::generateTranslation('play_list_updated', [
            'pt-BR' => 'Lista de reprodução atualizada'
        ]);
        self::generateTranslation('you_dont_hv_permission_del_playlist', [
            'pt-BR' => 'Você não tem permissão para excluir a lista de reprodução'
        ]);
        self::generateTranslation('playlist_delete_msg', [
            'pt-BR' => 'Lista de reprodução excluída'
        ]);
        self::generateTranslation('playlist_name', [
            'pt-BR' => 'Nome da Lista de Reprodução'
        ]);
        self::generateTranslation('add_new_playlist', [
            'pt-BR' => 'Adicionar Lista de Reprodução'
        ]);
        self::generateTranslation('this_thing_added_playlist', [
            'pt-BR' => 'Este %s foi adicionado à lista de reprodução'
        ]);
        self::generateTranslation('this_already_exist_in_pl', [
            'pt-BR' => 'Este %s já existe na sua lista de reprodução'
        ]);
        self::generateTranslation('edit_playlist', [
            'pt-BR' => 'Editar lista de reprodução'
        ]);
        self::generateTranslation('remove_playlist_item_confirm', [
            'pt-BR' => 'Tem certeza de que deseja remover isto da sua lista de reprodução'
        ]);
        self::generateTranslation('remove_playlist_confirm', [
            'pt-BR' => 'Tem certeza que deseja excluir esta lista de reprodução?'
        ]);
        self::generateTranslation('avcode_incorrect', [
            'pt-BR' => 'Código de ativação incorreto'
        ]);
        self::generateTranslation('group_join_login_err', [
            'pt-BR' => 'Por favor, faça o login para participar deste grupo'
        ]);
        self::generateTranslation('manage_playlist', [
            'pt-BR' => 'Gerenciar listas de reprodução'
        ]);
        self::generateTranslation('my_notifications', [
            'pt-BR' => 'Minhas notificações'
        ]);
        self::generateTranslation('users_contacts', [
            'pt-BR' => 'Contatos de %s'
        ]);
        self::generateTranslation('type_flags_removed', [
            'pt-BR' => '%s sinalizações foram removidas'
        ]);
        self::generateTranslation('terms_of_serivce', [
            'pt-BR' => 'Termos de Serviço'
        ]);
        self::generateTranslation('users', [
            'pt-BR' => 'Usuários'
        ]);
        self::generateTranslation('login_to_mark_as_spam', [
            'pt-BR' => 'Por favor, faça login para marcar como spam'
        ]);
        self::generateTranslation('no_own_commen_spam', [
            'pt-BR' => 'Você não pode marcar seu próprio comentário como spam'
        ]);
        self::generateTranslation('already_spammed_comment', [
            'pt-BR' => 'Você já marcou este comentário como spam'
        ]);
        self::generateTranslation('spam_comment_ok', [
            'pt-BR' => 'O comentário foi marcado como spam'
        ]);
        self::generateTranslation('arslan_hassan', [
            'pt-BR' => 'Arslan Hassan'
        ]);
        self::generateTranslation('you_not_allowed_add_grp_vids', [
            'pt-BR' => 'Você não é membro deste grupo, então não pode adicionar vídeos'
        ]);
        self::generateTranslation('sel_vids_updated', [
            'pt-BR' => 'Os vídeos selecionados foram atualizados'
        ]);
        self::generateTranslation('unable_find_download_file', [
            'pt-BR' => 'Não foi possível encontrar o arquivo de download'
        ]);
        self::generateTranslation('you_cant_edit_group', [
            'pt-BR' => 'Você não pode editar esse grupo'
        ]);
        self::generateTranslation('you_cant_invite_mems', [
            'pt-BR' => 'Você não pode convidar membros'
        ]);
        self::generateTranslation('you_cant_moderate_group', [
            'pt-BR' => 'Você não pode moderar este grupo'
        ]);
        self::generateTranslation('page_doesnt_exist', [
            'pt-BR' => 'A página não existe'
        ]);
        self::generateTranslation('pelase_select_img_file_for_vdo', [
            'pt-BR' => 'Por favor, selecione o arquivo de imagem para miniatura do vídeo'
        ]);
        self::generateTranslation('new_mem_added', [
            'pt-BR' => 'Um novo membro foi adicionado'
        ]);
        self::generateTranslation('this_vdo_not_working', [
            'pt-BR' => 'Este vídeo pode não funcionar corretamente'
        ]);
        self::generateTranslation('email_template_not_exist', [
            'pt-BR' => 'Modelo de email não existe'
        ]);
        self::generateTranslation('email_subj_empty', [
            'pt-BR' => 'Assunto do email está vazio'
        ]);
        self::generateTranslation('email_msg_empty', [
            'pt-BR' => 'A mensagem de e-mail está vazia'
        ]);
        self::generateTranslation('email_tpl_has_updated', [
            'pt-BR' => 'Modelo de E-mail foi atualizado'
        ]);
        self::generateTranslation('page_name_empty', [
            'pt-BR' => 'O nome da página está vazio'
        ]);
        self::generateTranslation('page_title_empty', [
            'pt-BR' => 'O título da página está vazio'
        ]);
        self::generateTranslation('page_content_empty', [
            'pt-BR' => 'O conteúdo da página estava vazio'
        ]);
        self::generateTranslation('new_page_added_successfully', [
            'pt-BR' => 'Nova página foi adicionada com sucesso'
        ]);
        self::generateTranslation('page_updated', [
            'pt-BR' => 'A página foi atualizada'
        ]);
        self::generateTranslation('page_deleted', [
            'pt-BR' => 'Página excluída com sucesso'
        ]);
        self::generateTranslation('page_activated', [
            'pt-BR' => 'A página foi ativada'
        ]);
        self::generateTranslation('page_deactivated', [
            'pt-BR' => 'A página foi desativada'
        ]);
        self::generateTranslation('you_cant_delete_this_page', [
            'pt-BR' => 'Você não pode excluir esta página'
        ]);
        self::generateTranslation('ad_placement_err4', [
            'pt-BR' => 'O posicionamento não existe'
        ]);
        self::generateTranslation('grp_details_updated', [
            'pt-BR' => 'Os detalhes do grupo foram atualizados'
        ]);
        self::generateTranslation('you_cant_del_topic', [
            'pt-BR' => 'Você não pode apagar este tópico'
        ]);
        self::generateTranslation('you_cant_del_user_topics', [
            'pt-BR' => 'Você não pode excluir tópicos de usuários'
        ]);
        self::generateTranslation('topics_deleted', [
            'pt-BR' => 'Os tópicos foram excluídos'
        ]);
        self::generateTranslation('you_cant_delete_grp_topics', [
            'pt-BR' => 'Você não pode excluir tópicos do grupo'
        ]);
        self::generateTranslation('you_not_allowed_post_topics', [
            'pt-BR' => 'Você não tem permissão para postar tópicos'
        ]);
        self::generateTranslation('you_cant_add_this_vdo', [
            'pt-BR' => 'Você não pode adicionar este vídeo'
        ]);
        self::generateTranslation('video_added', [
            'pt-BR' => 'O vídeo foi adicionado'
        ]);
        self::generateTranslation('you_cant_del_this_vdo', [
            'pt-BR' => 'Você não pode remover este vídeo'
        ]);
        self::generateTranslation('video_removed', [
            'pt-BR' => 'O vídeo foi removido'
        ]);
        self::generateTranslation('user_not_grp_mem', [
            'pt-BR' => 'O usuário não é membro do grupo'
        ]);
        self::generateTranslation('user_already_group_mem', [
            'pt-BR' => 'O usuário já ingressou neste grupo'
        ]);
        self::generateTranslation('invitations_sent', [
            'pt-BR' => 'Os convites foram enviados'
        ]);
        self::generateTranslation('you_not_grp_mem', [
            'pt-BR' => 'Você não é membro deste grupo'
        ]);
        self::generateTranslation('you_cant_delete_this_grp', [
            'pt-BR' => 'Você não pode excluir este grupo'
        ]);
        self::generateTranslation('grp_deleted', [
            'pt-BR' => 'O grupo foi excluído'
        ]);
        self::generateTranslation('you_cant_del_grp_mems', [
            'pt-BR' => 'Você não pode excluir membros do grupo'
        ]);
        self::generateTranslation('mems_deleted', [
            'pt-BR' => 'Os membros foram excluídos'
        ]);
        self::generateTranslation('you_cant_del_grp_vdos', [
            'pt-BR' => 'Você não pode excluir vídeos de grupo'
        ]);
        self::generateTranslation('thnx_for_voting', [
            'pt-BR' => 'Obrigado por votar'
        ]);
        self::generateTranslation('you_hv_already_rated_vdo', [
            'pt-BR' => 'Você já avaliou este vídeo'
        ]);
        self::generateTranslation('please_login_to_rate', [
            'pt-BR' => 'Por favor, inicie a sessão para avaliar'
        ]);
        self::generateTranslation('you_not_subscribed', [
            'pt-BR' => 'Você não está inscrito'
        ]);
        self::generateTranslation('you_cant_delete_this_user', [
            'pt-BR' => 'Você não pode excluir este usuário'
        ]);
        self::generateTranslation('you_dont_hv_perms', [
            'pt-BR' => 'Você não tem permissões suficientes'
        ]);
        self::generateTranslation('user_subs_hv_been_removed', [
            'pt-BR' => 'As inscrições do usuário foram removidas'
        ]);
        self::generateTranslation('user_subsers_hv_removed', [
            'pt-BR' => 'Os inscritos do usuário foram removidos'
        ]);
        self::generateTranslation('you_already_sent_frend_request', [
            'pt-BR' => 'Você já enviou um pedido de amizade'
        ]);
        self::generateTranslation('friend_added', [
            'pt-BR' => 'O amigo foi adicionado'
        ]);
        self::generateTranslation('friend_request_sent', [
            'pt-BR' => 'Pedido de amizade enviado'
        ]);
        self::generateTranslation('friend_confirm_error', [
            'pt-BR' => 'Ou o usuário não solicitou seu pedido de amizade ou você já o confirmou'
        ]);
        self::generateTranslation('friend_confirmed', [
            'pt-BR' => 'O amigo foi confirmado'
        ]);
        self::generateTranslation('friend_request_not_found', [
            'pt-BR' => 'Nenhum pedido de amizade encontrado'
        ]);
        self::generateTranslation('you_cant_confirm_this_request', [
            'pt-BR' => 'Você não pode confirmar este pedido'
        ]);
        self::generateTranslation('friend_request_already_confirmed', [
            'pt-BR' => 'Pedido de amizade já confirmado'
        ]);
        self::generateTranslation('user_no_in_contact_list', [
            'pt-BR' => 'O usuário não está na sua lista de contatos'
        ]);
        self::generateTranslation('user_removed_from_contact_list', [
            'pt-BR' => 'O usuário foi removido da sua lista de contatos'
        ]);
        self::generateTranslation('cant_find_level', [
            'pt-BR' => 'Nível não encontrado'
        ]);
        self::generateTranslation('please_enter_level_name', [
            'pt-BR' => 'Digite o nome do nível'
        ]);
        self::generateTranslation('level_updated', [
            'pt-BR' => 'O nível foi atualizado'
        ]);
        self::generateTranslation('level_del_sucess', [
            'pt-BR' => 'O nível de usuário foi excluído, todos os usuários deste nível foram transferidos para %s'
        ]);
        self::generateTranslation('level_not_deleteable', [
            'pt-BR' => 'Este nível não é deletável'
        ]);
        self::generateTranslation('pass_mismatched', [
            'pt-BR' => 'Senhas não coincidem'
        ]);
        self::generateTranslation('user_blocked', [
            'pt-BR' => 'O usuário foi bloqueado'
        ]);
        self::generateTranslation('user_already_blocked', [
            'pt-BR' => 'O usuário já está bloqueado'
        ]);
        self::generateTranslation('you_cant_del_user', [
            'pt-BR' => 'Você não pode bloquear este usuário'
        ]);
        self::generateTranslation('user_vids_hv_deleted', [
            'pt-BR' => 'Os vídeos do usuário foram excluídos'
        ]);
        self::generateTranslation('user_contacts_hv_removed', [
            'pt-BR' => 'Os contatos do usuário foram removidos'
        ]);
        self::generateTranslation('all_user_inbox_deleted', [
            'pt-BR' => 'Todas as mensagens da Caixa de Entrada do Usuário foram excluidas'
        ]);
        self::generateTranslation('all_user_sent_messages_deleted', [
            'pt-BR' => 'Todas as mensagens enviadas pelo usuário foram excluídas'
        ]);
        self::generateTranslation('pelase_enter_something_for_comment', [
            'pt-BR' => 'Por favor, digite algo na caixa de comentários'
        ]);
        self::generateTranslation('please_enter_your_name', [
            'pt-BR' => 'O nome não pode ser deixado em branco'
        ]);
        self::generateTranslation('please_enter_your_email', [
            'pt-BR' => 'Por favor, insira o seu e-mail'
        ]);
        self::generateTranslation('template_activated', [
            'pt-BR' => 'O modelo foi ativado'
        ]);
        self::generateTranslation('error_occured_changing_template', [
            'pt-BR' => 'Ocorreu um erro ao alterar o modelo'
        ]);
        self::generateTranslation('phrase_code_empty', [
            'pt-BR' => 'O código da frase estava vazio'
        ]);
        self::generateTranslation('phrase_text_empty', [
            'pt-BR' => 'O texto da frase estava vazio'
        ]);
        self::generateTranslation('language_does_not_exist', [
            'pt-BR' => 'O idioma não existe'
        ]);
        self::generateTranslation('name_has_been_added', [
            'pt-BR' => '%s foi adicionado'
        ]);
        self::generateTranslation('name_already_exists', [
            'pt-BR' => '\'%s\' já existe'
        ]);
        self::generateTranslation('lang_doesnt_exist', [
            'pt-BR' => 'O idioma não existe'
        ]);
        self::generateTranslation('no_file_was_selected', [
            'pt-BR' => 'Nenhum arquivo foi selecionado'
        ]);
        self::generateTranslation('err_reading_file_content', [
            'pt-BR' => 'Erro ao ler conteúdo do arquivo'
        ]);
        self::generateTranslation('cant_find_lang_name', [
            'pt-BR' => 'Nome do idioma não encontrado'
        ]);
        self::generateTranslation('cant_find_lang_code', [
            'pt-BR' => 'Não conseguimos encontrar o código do idioma'
        ]);
        self::generateTranslation('no_phrases_found', [
            'pt-BR' => 'Nenhuma frase foi encontrada'
        ]);
        self::generateTranslation('language_already_exists', [
            'pt-BR' => 'O idioma já existe'
        ]);
        self::generateTranslation('lang_added', [
            'pt-BR' => 'Idioma adicionado com sucesso'
        ]);
        self::generateTranslation('error_while_upload_file', [
            'pt-BR' => 'Ocorreu um erro ao carregar o arquivo do idioma'
        ]);
        self::generateTranslation('default_lang_del_error', [
            'pt-BR' => 'Este é o idioma padrão, selecione outro idioma como «padrão» e então exclua este pacote'
        ]);
        self::generateTranslation('lang_deleted', [
            'pt-BR' => 'O pacote de idioma foi excluído'
        ]);
        self::generateTranslation('lang_name_empty', [
            'pt-BR' => 'O nome do idioma está vazio'
        ]);
        self::generateTranslation('lang_code_empty', [
            'pt-BR' => 'O código do idioma estava vazio'
        ]);
        self::generateTranslation('lang_regex_empty', [
            'pt-BR' => 'Expressão regular do idioma estava vazia'
        ]);
        self::generateTranslation('lang_code_already_exist', [
            'pt-BR' => 'O código de idioma já existe'
        ]);
        self::generateTranslation('lang_updated', [
            'pt-BR' => 'O idioma foi atualizado'
        ]);
        self::generateTranslation('player_activated', [
            'pt-BR' => 'O player foi ativado'
        ]);
        self::generateTranslation('error_occured_while_activating_player', [
            'pt-BR' => 'Ocorreu um erro ao ativar o player'
        ]);
        self::generateTranslation('plugin_has_been_s', [
            'pt-BR' => 'O plug-in foi %s'
        ]);
        self::generateTranslation('plugin_uninstalled', [
            'pt-BR' => 'O plug-in foi desinstalado'
        ]);
        self::generateTranslation('perm_code_empty', [
            'pt-BR' => 'O código de permissão está vazio'
        ]);
        self::generateTranslation('perm_name_empty', [
            'pt-BR' => 'O nome da permissão está vazio'
        ]);
        self::generateTranslation('perm_already_exist', [
            'pt-BR' => 'A permissão já existe'
        ]);
        self::generateTranslation('perm_type_not_valid', [
            'pt-BR' => 'Tipo de permissão inválido'
        ]);
        self::generateTranslation('perm_added', [
            'pt-BR' => 'Nova permissão foi adicionada'
        ]);
        self::generateTranslation('perm_deleted', [
            'pt-BR' => 'A permissão foi excluída'
        ]);
        self::generateTranslation('perm_doesnt_exist', [
            'pt-BR' => 'A permissão não existe'
        ]);
        self::generateTranslation('acitvation_html_message', [
            'pt-BR' => 'Digite seu nome de usuário e código de ativação para ativar sua conta. Não esqueça de checar a sua caixa de entrada para encontrar o código de ativação, caso não tenha recebido um, por favor solicite-o preenchendo o formulário a seguir'
        ]);
        self::generateTranslation('acitvation_html_message2', [
            'pt-BR' => 'Por favor, digite seu endereço de e-mail para solicitar o código de ativação'
        ]);
        self::generateTranslation('admin_panel', [
            'pt-BR' => 'Painel de Administração'
        ]);
        self::generateTranslation('moderate_videos', [
            'pt-BR' => 'Moderar Vídeos'
        ]);
        self::generateTranslation('moderate_users', [
            'pt-BR' => 'Moderar Usuários'
        ]);
        self::generateTranslation('revert_back_to_admin', [
            'pt-BR' => 'Reverter para o administrador'
        ]);
        self::generateTranslation('more_options', [
            'pt-BR' => 'Mais Opções'
        ]);
        self::generateTranslation('downloading_string', [
            'pt-BR' => 'Baixando %s...'
        ]);
        self::generateTranslation('download_redirect_msg', [
            'pt-BR' => '<a href=\"%s\">clique aqui se você não for redirecionado automaticamente</a> - <a href=\"%s\"> Clique Aqui para voltar à Página do Vídeo</a>'
        ]);
        self::generateTranslation('account_details', [
            'pt-BR' => 'Detalhes de conta'
        ]);
        self::generateTranslation('profile_details', [
            'pt-BR' => 'Detalhes do perfil'
        ]);
        self::generateTranslation('update_profile', [
            'pt-BR' => 'Atualizar o perfil'
        ]);
        self::generateTranslation('please_select_img_file', [
            'pt-BR' => 'Por favor, selecione arquivo de imagem'
        ]);
        self::generateTranslation('or', [
            'pt-BR' => 'ou'
        ]);
        self::generateTranslation('pelase_enter_image_url', [
            'pt-BR' => 'Digite a URL da imagem'
        ]);
        self::generateTranslation('user_bg', [
            'pt-BR' => 'Fundo do canal'
        ]);
        self::generateTranslation('user_bg_img', [
            'pt-BR' => 'Imagem de Fundo do Canal'
        ]);
        self::generateTranslation('please_enter_bg_color', [
            'pt-BR' => 'Digite a cor de fundo'
        ]);
        self::generateTranslation('bg_repeat_type', [
            'pt-BR' => 'Tipo de repetição de fundo (se estiver usando a imagem como plano de fundo)'
        ]);
        self::generateTranslation('fix_bg', [
            'pt-BR' => 'Corrigir fundo'
        ]);
        self::generateTranslation('delete_this_img', [
            'pt-BR' => 'Excluir esta imagem'
        ]);
        self::generateTranslation('current_email', [
            'pt-BR' => 'E-mail atual'
        ]);
        self::generateTranslation('confirm_new_email', [
            'pt-BR' => 'Confirme o novo email'
        ]);
        self::generateTranslation('no_subs_found', [
            'pt-BR' => 'Nenhum inscrição encontrada'
        ]);
        self::generateTranslation('video_info_all_fields_req', [
            'pt-BR' => 'Informações de Vídeo - Todos os campos são obrigatórios'
        ]);
        self::generateTranslation('update_group', [
            'pt-BR' => 'Atualizar Grupo'
        ]);
        self::generateTranslation('default', [
            'pt-BR' => 'Padrão'
        ]);
        self::generateTranslation('grp_info_all_fields_req', [
            'pt-BR' => 'Informações do Grupo - Todos os Campos são Obrigatórios'
        ]);
        self::generateTranslation('date_recorded_location', [
            'pt-BR' => 'Data de gravação &amp; localização'
        ]);
        self::generateTranslation('update_video', [
            'pt-BR' => 'Atualizar vídeo'
        ]);
        self::generateTranslation('click_here_to_recover_user', [
            'pt-BR' => 'Clique aqui para recuperar o nome de usuário'
        ]);
        self::generateTranslation('click_here_reset_pass', [
            'pt-BR' => 'Clique aqui para redefinir a senha'
        ]);
        self::generateTranslation('remember_me', [
            'pt-BR' => 'Lembrar de mim'
        ]);
        self::generateTranslation('howdy_user', [
            'pt-BR' => 'Olá %s'
        ]);
        self::generateTranslation('notifications', [
            'pt-BR' => 'Notificações'
        ]);
        self::generateTranslation('playlists', [
            'pt-BR' => 'Listas de reprodução'
        ]);
        self::generateTranslation('friend_requests', [
            'pt-BR' => 'Pedidos de Amizade'
        ]);
        self::generateTranslation('after_meny_guest_msg', [
            'pt-BR' => 'Bem-vindo, convidado! Por favor <a href=\"%s\">faça o login</a> ou <a href=\"%s\">registre-se</a>'
        ]);
        self::generateTranslation('being_watched', [
            'pt-BR' => 'Sendo assistido'
        ]);
        self::generateTranslation('change_style_of_listing', [
            'pt-BR' => 'Alterar estilo da listagem'
        ]);
        self::generateTranslation('website_members', [
            'pt-BR' => '%s Membros'
        ]);
        self::generateTranslation('guest_homeright_msg', [
            'pt-BR' => 'Assistir, enviar, compartilhar e muito mais'
        ]);
        self::generateTranslation('reg_for_free', [
            'pt-BR' => 'Registre-se gratuitamente'
        ]);
        self::generateTranslation('rand_vids', [
            'pt-BR' => 'Vídeos Aleatórios'
        ]);
        self::generateTranslation('t_10_users', [
            'pt-BR' => 'Top 10 Usuários'
        ]);
        self::generateTranslation('pending', [
            'pt-BR' => 'Pendente'
        ]);
        self::generateTranslation('confirm', [
            'pt-BR' => 'Confirmar'
        ]);
        self::generateTranslation('no_contacts', [
            'pt-BR' => 'Sem contatos'
        ]);
        self::generateTranslation('you_dont_hv_any_grp', [
            'pt-BR' => 'Você não tem nenhum grupo'
        ]);
        self::generateTranslation('you_dont_joined_any_grp', [
            'pt-BR' => 'Você não entrou em nenhum grupo'
        ]);
        self::generateTranslation('leave_groups', [
            'pt-BR' => 'Sair de grupos'
        ]);
        self::generateTranslation('manage_grp_mems', [
            'pt-BR' => 'Gerenciar membros do grupo'
        ]);
        self::generateTranslation('pending_mems', [
            'pt-BR' => 'Membros pendentes'
        ]);
        self::generateTranslation('active_mems', [
            'pt-BR' => 'Membros ativos'
        ]);
        self::generateTranslation('disapprove', [
            'pt-BR' => 'Reprovar'
        ]);
        self::generateTranslation('manage_grp_vids', [
            'pt-BR' => 'Gerenciar vídeos em grupo'
        ]);
        self::generateTranslation('pending_vids', [
            'pt-BR' => 'Vídeos pendentes'
        ]);
        self::generateTranslation('no_pending_vids', [
            'pt-BR' => 'Nenhum vídeo pendente'
        ]);
        self::generateTranslation('no_active_videos', [
            'pt-BR' => 'Não há vídeos ativos'
        ]);
        self::generateTranslation('active_videos', [
            'pt-BR' => 'Vídeos ativos'
        ]);
        self::generateTranslation('manage_playlists', [
            'pt-BR' => 'Gerenciar listas de reprodução'
        ]);
        self::generateTranslation('total_items', [
            'pt-BR' => 'Total de itens'
        ]);
        self::generateTranslation('play_now', [
            'pt-BR' => 'REPRODUZA AGORA'
        ]);
        self::generateTranslation('no_video_in_playlist', [
            'pt-BR' => 'Esta playlist não tem nenhum vídeo'
        ]);
        self::generateTranslation('view', [
            'pt-BR' => 'Ver'
        ]);
        self::generateTranslation('you_dont_hv_fav_vids', [
            'pt-BR' => 'Você não tem nenhum vídeo favorito'
        ]);
        self::generateTranslation('private_messages', [
            'pt-BR' => 'Mensagens Privadas'
        ]);
        self::generateTranslation('new_private_msg', [
            'pt-BR' => 'Nova mensagem particular'
        ]);
        self::generateTranslation('search_for_s', [
            'pt-BR' => 'Pesquisar por %s'
        ]);
        self::generateTranslation('signup_success_usr_ok', [
            'pt-BR' => '<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">Apenas mais um passo</h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 14px;\">Você é apenas um passo para trás de se tornar um meme oficial do nosso site. Por favor, verifique seu e-mail, enviamos um e-mail de confirmação que contém um link de confirmação do nosso site. Por favor, clique nele para completar o seu registro.</p>'
        ]);
        self::generateTranslation('signup_success_usr_emailverify', [
            'pt-BR' => '<h2 style=\"font-family:Arial,Verdana,sans-serif; margin:5px 5px 8px;\">Bem-vindo à nossa comunidade</h2>\n    \t<p style=\"margin:0px 5px; line-height:18px; font-size:11px;\">Seu e-mail foi confirmado, Por favor <strong><a href=\"%s\">clique aqui para fazer login</a></strong> e continuar como nosso membro registrado.</p>'
        ]);
        self::generateTranslation('if_you_already_hv_account', [
            'pt-BR' => 'se você já tem uma conta, faça login aqui '
        ]);
        self::generateTranslation('signup_message_under_login', [
            'pt-BR' => ' <p>Nosso site é o lar do vídeo online:</p>\n          \n            <ul><li><strong>Assista</strong> milhares de vídeos</li><li><strong>Compartilhe seus favoritos</strong> com amigos e familiares</li>\n            <li><strong>Conecte-se com outros usuários</strong> que compartilham seus interesses</li><li><strong>Envie seus vídeos</strong> para uma audiência mundial\n\n</li></ul>'
        ]);
        self::generateTranslation('new_mems_signup_here', [
            'pt-BR' => 'Novos membros se registram aqui'
        ]);
        self::generateTranslation('register_as_our_website_member', [
            'pt-BR' => 'Registre-se como membro, é gratuito e fácil apenas '
        ]);
        self::generateTranslation('video_complete_msg', [
            'pt-BR' => '<h2>O Upload de vídeo foi concluído</h2>\n<span class=\"header1\">Obrigado! Seu upload está completo.</span><br>\n<span class=\"tips\">Este vídeo estará disponível em <a href=\"%s\"><strong>Meus Vídeos</strong></a> depois de ter terminado de processar.</span>  \n<div class=\"upload_link_button\" align=\"center\">\n    </h2>    <ul>\n        <li><a href=\"%s\" >Enviar Outro Vídeo</a></li>\n        <li><a href=\"%s\" >Vá para Meus Vídeos</a></li>\n    </ul>\n<div class=\'clearfix\'></div>\n</div>\n'
        ]);
        self::generateTranslation('upload_right_guide', [
            'pt-BR' => ' <div>\n            <div>\n              <p>\n                <strong>\n                <strong>Importante:</strong>\n                Não envie nenhum programa de TV, vídeos de musicas, shows de música, ou comerciais sem permissão, a menos que consistam inteiramente de conteúdo que você mesmo criou.</strong></p>\n                <p>As paginas de \n                <a href=\"#\">Direitos Autorais</a> e as \n                <a href=\"#\">Diretrizes da Comunidade</a> podem ajudá-lo a determinar se seu vídeo viola os direitos autorais de outra pessoa.</p>\n                <p>clicando em \"Enviar Vídeo\", você está representando que este vídeo não viola os \n                <a id=\"terms-of-use-link\" href=\"#\">Termos de Uso</a> \n                do nosso site e que você possui todos os direitos autorais sobre este vídeo ou tem autorização para envia-lo.</p>\n            </div>\n        </div>'
        ]);
        self::generateTranslation('report_this_user', [
            'pt-BR' => 'Denunciar este Usuário'
        ]);
        self::generateTranslation('add_to_favs', [
            'pt-BR' => 'Meu Favorito!'
        ]);
        self::generateTranslation('report_this', [
            'pt-BR' => 'Denunciar'
        ]);
        self::generateTranslation('share_this', [
            'pt-BR' => 'Compatilhe isto'
        ]);
        self::generateTranslation('add_to_playlist', [
            'pt-BR' => 'Adicionar à lista de reprodução'
        ]);
        self::generateTranslation('view_profile', [
            'pt-BR' => 'Ver Perfil'
        ]);
        self::generateTranslation('subscribe', [
            'pt-BR' => 'Inscrever-se'
        ]);
        self::generateTranslation('uploaded_by_s', [
            'pt-BR' => 'Enviado por %s'
        ]);
        self::generateTranslation('more', [
            'pt-BR' => 'Mais'
        ]);
        self::generateTranslation('link_this_video', [
            'pt-BR' => 'Link para o vídeo'
        ]);
        self::generateTranslation('click_to_download_video', [
            'pt-BR' => 'Clique aqui para baixar este vídeo'
        ]);
        self::generateTranslation('name', [
            'pt-BR' => 'Nome'
        ]);
        self::generateTranslation('email_wont_display', [
            'pt-BR' => 'E-mail (não será exibido)'
        ]);
        self::generateTranslation('please_login_to_comment', [
            'pt-BR' => 'Por favor, inicie a sessão para comentar'
        ]);
        self::generateTranslation('marked_as_spam_comment_by_user', [
            'pt-BR' => 'Marcado como spam, comentado por <em>%s</em>'
        ]);
        self::generateTranslation('spam', [
            'pt-BR' => 'Spam'
        ]);
        self::generateTranslation('user_commented_time', [
            'pt-BR' => '<a href=\"%s\">%s</a> comentou %s'
        ]);
        self::generateTranslation('no_comments', [
            'pt-BR' => 'Ninguém comentou sobre este %s ainda'
        ]);
        self::generateTranslation('view_video', [
            'pt-BR' => 'Assistir ao vídeo'
        ]);
        self::generateTranslation('topic_icon', [
            'pt-BR' => 'Ícone do tópico'
        ]);
        self::generateTranslation('group_options', [
            'pt-BR' => 'Opção de grupo'
        ]);
        self::generateTranslation('info', [
            'pt-BR' => 'Informação'
        ]);
        self::generateTranslation('basic_info', [
            'pt-BR' => 'Informações básicas'
        ]);
        self::generateTranslation('group_owner', [
            'pt-BR' => 'Dono do Grupo'
        ]);
        self::generateTranslation('total_mems', [
            'pt-BR' => 'Total de membros'
        ]);
        self::generateTranslation('total_topics', [
            'pt-BR' => 'Total de tópicos'
        ]);
        self::generateTranslation('grp_url', [
            'pt-BR' => 'URL do Grupo'
        ]);
        self::generateTranslation('more_details', [
            'pt-BR' => 'Mais detalhes'
        ]);
        self::generateTranslation('view_all_mems', [
            'pt-BR' => 'Ver todos os membros'
        ]);
        self::generateTranslation('view_all_vids', [
            'pt-BR' => 'Ver Todos os Vídeos'
        ]);
        self::generateTranslation('topic_title', [
            'pt-BR' => 'Título do Tópico'
        ]);
        self::generateTranslation('last_reply', [
            'pt-BR' => 'Última resposta'
        ]);
        self::generateTranslation('topic_by_user', [
            'pt-BR' => '<a href=\"%s\">%s</a></span> por <a href=\"%s\">%s</a>'
        ]);
        self::generateTranslation('no_topics', [
            'pt-BR' => 'Não há tópicos'
        ]);
        self::generateTranslation('last_post_time_by_user', [
            'pt-BR' => '%s<br />\npor <a href=\"%s\">%s'
        ]);
        self::generateTranslation('profile_views', [
            'pt-BR' => 'Visualizações do perfil'
        ]);
        self::generateTranslation('last_logged_in', [
            'pt-BR' => 'Último acesso em'
        ]);
        self::generateTranslation('last_active', [
            'pt-BR' => 'Última vez ativo'
        ]);
        self::generateTranslation('total_logins', [
            'pt-BR' => 'Total de logins'
        ]);
        self::generateTranslation('total_videos_watched', [
            'pt-BR' => 'Total de vídeos assistidos'
        ]);
        self::generateTranslation('view_group', [
            'pt-BR' => 'Ver grupo'
        ]);
        self::generateTranslation('you_dont_hv_any_pm', [
            'pt-BR' => 'Não há mensagens para exibir'
        ]);
        self::generateTranslation('date_sent', [
            'pt-BR' => 'Data de envio'
        ]);
        self::generateTranslation('show_hide', [
            'pt-BR' => 'Mostrar - Ocultar'
        ]);
        self::generateTranslation('quicklists', [
            'pt-BR' => 'Listas rápidas'
        ]);
        self::generateTranslation('are_you_sure_rm_grp', [
            'pt-BR' => 'Tem certeza que deseja remover este grupo?'
        ]);
        self::generateTranslation('are_you_sure_del_grp', [
            'pt-BR' => 'Tem certeza que deseja excluir este grupo?'
        ]);
        self::generateTranslation('change_avatar', [
            'pt-BR' => 'Alterar Avatar'
        ]);
        self::generateTranslation('change_bg', [
            'pt-BR' => 'Alterar Fundo'
        ]);
        self::generateTranslation('uploaded_videos', [
            'pt-BR' => 'Vídeos enviados'
        ]);
        self::generateTranslation('video_playlists', [
            'pt-BR' => 'Listas de reprodução de vídeos'
        ]);
        self::generateTranslation('add_contact_list', [
            'pt-BR' => 'Adicionar lista de contatos'
        ]);
        self::generateTranslation('topic_post', [
            'pt-BR' => 'Postagem do tópico'
        ]);
        self::generateTranslation('invite', [
            'pt-BR' => 'Convidar'
        ]);
        self::generateTranslation('time_ago', [
            'pt-BR' => '%s %s atrás'
        ]);
        self::generateTranslation('from_now', [
            'pt-BR' => '%s %s a partir de agora'
        ]);
        self::generateTranslation('lang_has_been_activated', [
            'pt-BR' => 'O idioma foi ativado'
        ]);
        self::generateTranslation('lang_has_been_deactivated', [
            'pt-BR' => 'O idioma foi desativado'
        ]);
        self::generateTranslation('lang_default_no_actions', [
            'pt-BR' => 'Idioma é padrão então você não pode executar ações nele'
        ]);
        self::generateTranslation('private_video_error', [
            'pt-BR' => 'Este vídeo é privado, somente amigos que enviam podem ver este vídeo'
        ]);
        self::generateTranslation('email_send_confirm', [
            'pt-BR' => 'Um e-mail foi enviado para o nosso administrador da Web, responderemos em breve'
        ]);
        self::generateTranslation('name_was_empty', [
            'pt-BR' => 'Nome está vazio'
        ]);
        self::generateTranslation('invalid_email', [
            'pt-BR' => 'E-mail inválido'
        ]);
        self::generateTranslation('pelase_enter_reason', [
            'pt-BR' => 'Motivo'
        ]);
        self::generateTranslation('please_enter_something_for_message', [
            'pt-BR' => 'Por favor, digite algo na caixa de mensagem'
        ]);
        self::generateTranslation('comm_disabled_for_vid', [
            'pt-BR' => 'Comentários desativados para este vídeo'
        ]);
        self::generateTranslation('coments_disabled_profile', [
            'pt-BR' => 'Comentários desativados para este perfil'
        ]);
        self::generateTranslation('file_size_exceeds', [
            'pt-BR' => 'Tamanho do arquivo excede \'%s kbs\''
        ]);
        self::generateTranslation('vid_rate_disabled', [
            'pt-BR' => 'A avaliação do vídeo está desativada'
        ]);
        self::generateTranslation('chane_lang', [
            'pt-BR' => '- Alterar Idioma -'
        ]);
        self::generateTranslation('recent', [
            'pt-BR' => 'Recente'
        ]);
        self::generateTranslation('viewed', [
            'pt-BR' => 'Visualizado'
        ]);
        self::generateTranslation('top_rated', [
            'pt-BR' => 'Melhor avaliado'
        ]);
        self::generateTranslation('commented', [
            'pt-BR' => 'Comentado'
        ]);
        self::generateTranslation('searching_keyword_in_obj', [
            'pt-BR' => 'Pesquisando \'%s\' em %s'
        ]);
        self::generateTranslation('no_results_found', [
            'pt-BR' => 'Nenhum resultado encontrado'
        ]);
        self::generateTranslation('please_enter_val_bw_min_max', [
            'pt-BR' => 'Por favor, digite um valor para \'%s\' entre \'%s\' e \'%s\''
        ]);
        self::generateTranslation('no_new_subs_video', [
            'pt-BR' => 'Não foram encontrados novos vídeos nas assinaturas'
        ]);
        self::generateTranslation('inapp_content', [
            'pt-BR' => 'Conteúdo inadequado'
        ]);
        self::generateTranslation('copyright_infring', [
            'pt-BR' => 'Violação de Direitos Autorais'
        ]);
        self::generateTranslation('sexual_content', [
            'pt-BR' => 'Conteúdo Sexual'
        ]);
        self::generateTranslation('violence_replusive_content', [
            'pt-BR' => 'Violência ou conteúdo repugnante'
        ]);
        self::generateTranslation('disturbing', [
            'pt-BR' => 'Perturbador'
        ]);
        self::generateTranslation('other', [
            'pt-BR' => 'Outros'
        ]);
        self::generateTranslation('pending_requests', [
            'pt-BR' => 'Solicitações pendentes'
        ]);
        self::generateTranslation('friend_add_himself_error', [
            'pt-BR' => 'Você não pode se adicionar como amigo'
        ]);
        self::generateTranslation('contact_us_msg', [
            'pt-BR' => 'Os seus comentários são importantes para nós e vamos avaliar eles o mais rapidamente possível. A informação solicitada neste formulário é voluntária. As informações estão a ser recolhidas para fornecer informações adicionais solicitadas por si e ajuda-nos a melhorar os nossos serviços.'
        ]);
        self::generateTranslation('failed', [
            'pt-BR' => 'Falha'
        ]);
        self::generateTranslation('required_fields', [
            'pt-BR' => 'Campos obrigatórios'
        ]);
        self::generateTranslation('more_fields', [
            'pt-BR' => 'Mais campos'
        ]);
        self::generateTranslation('remote_upload_file', [
            'pt-BR' => 'enviando arquivo <span id=\\\"remoteFileName\\\"></span>, aguarde...'
        ]);
        self::generateTranslation('please_enter_remote_file_url', [
            'pt-BR' => 'Digite a URL do arquivo remoto'
        ]);
        self::generateTranslation('remoteDownloadStatusDiv', [
            'pt-BR' => '<div class=\"remoteDownloadStatus\" id=\"remoteDownloadStatus\" >Baixado \n                <span id=\"status\">-- de --</span> @ \n                <span id=\"dspeed\">-- Kpbs</span>, Estimativa \n                <span id=\"eta\">--:--</span>, Tempo Gasto \n                <span id=\"time_took\">--:--</span>\n            </div>'
        ]);
        self::generateTranslation('upload_data_now', [
            'pt-BR' => 'Enviar Dados Agora!'
        ]);
        self::generateTranslation('save_data', [
            'pt-BR' => 'Dados Salvos'
        ]);
        self::generateTranslation('saving', [
            'pt-BR' => 'Salvando...'
        ]);
        self::generateTranslation('upload_file', [
            'pt-BR' => 'Enviar arquivo'
        ]);
        self::generateTranslation('grab_from_youtube', [
            'pt-BR' => 'Resgatar do youtube'
        ]);
        self::generateTranslation('upload_video_button', [
            'pt-BR' => 'Explorar vídeos'
        ]);
        self::generateTranslation('upload_videos_can_be', [
            'pt-BR' => '<span style=\\\"font-weight: bold; font-size: 13px;\\\">Os vídeos podem ser</span>     <ul>         <li>de Alta Definição</li>         <li>Até %s de tamanho</li>         <li>Até %s de duração</li>         <li>Uma grande variedade de formatos</li>     </ul>'
        ]);
        self::generateTranslation('photo_not_exist', [
            'pt-BR' => 'A foto não existe.'
        ]);
        self::generateTranslation('photo_success_deleted', [
            'pt-BR' => 'A foto foi excluída com sucesso.'
        ]);
        self::generateTranslation('cant_edit_photo', [
            'pt-BR' => 'Você não pode editar esta foto.'
        ]);
        self::generateTranslation('you_hv_already_rated_photo', [
            'pt-BR' => 'Você já avaliou esta foto.'
        ]);
        self::generateTranslation('photo_rate_disabled', [
            'pt-BR' => 'Avaliação da foto está desativada.'
        ]);
        self::generateTranslation('need_photo_details', [
            'pt-BR' => 'Precisa-se de detalhes da foto.'
        ]);
        self::generateTranslation('embedding_is_disabled', [
            'pt-BR' => 'A incorporação foi desativada pelo usuário.'
        ]);
        self::generateTranslation('photo_activated', [
            'pt-BR' => 'A foto foi ativada.'
        ]);
        self::generateTranslation('photo_deactivated', [
            'pt-BR' => 'A foto foi desativada.'
        ]);
        self::generateTranslation('photo_featured', [
            'pt-BR' => 'A foto foi marcada como em destaque.'
        ]);
        self::generateTranslation('photo_unfeatured', [
            'pt-BR' => 'A foto não está mais em destaque.'
        ]);
        self::generateTranslation('photo_updated_successfully', [
            'pt-BR' => 'A foto foi atualizada com sucesso.'
        ]);
        self::generateTranslation('success_delete_file', [
            'pt-BR' => '%s arquivos foram excluídos com sucesso.'
        ]);
        self::generateTranslation('no_watermark_found', [
            'pt-BR' => 'Não foi possível encontrar arquivo de marca d\'água.'
        ]);
        self::generateTranslation('watermark_updated', [
            'pt-BR' => 'Marca d\'água atualizada'
        ]);
        self::generateTranslation('upload_png_watermark', [
            'pt-BR' => 'Por favor, envie arquivo PNG 24-bit.'
        ]);
        self::generateTranslation('photo_non_readable', [
            'pt-BR' => 'A foto não está legível.'
        ]);
        self::generateTranslation('wrong_mime_type', [
            'pt-BR' => 'Tipo MIME errado fornecido.'
        ]);
        self::generateTranslation('you_dont_have_photos', [
            'pt-BR' => 'Você não tem nenhuma foto'
        ]);
        self::generateTranslation('you_dont_have_fav_photos', [
            'pt-BR' => 'Você não tem nenhuma foto favorita'
        ]);
        self::generateTranslation('manage_orphan_photos', [
            'pt-BR' => 'Gerenciar fotos órfãs'
        ]);
        self::generateTranslation('manage_favorite_photos', [
            'pt-BR' => 'Gerenciar fotos favoritas'
        ]);
        self::generateTranslation('manage_photos', [
            'pt-BR' => 'Gerenciar fotos'
        ]);
        self::generateTranslation('you_dont_have_orphan_photos', [
            'pt-BR' => 'Você não tem nenhuma foto órfã'
        ]);
        self::generateTranslation('item_not_exist', [
            'pt-BR' => 'O item não existe.'
        ]);
        self::generateTranslation('collection_not_exist', [
            'pt-BR' => 'A coleção não existe'
        ]);
        self::generateTranslation('selected_collects_del', [
            'pt-BR' => 'As coleções selecionadas foram excluídas.'
        ]);
        self::generateTranslation('manage_collections', [
            'pt-BR' => 'Gerenciar coleções'
        ]);
        self::generateTranslation('manage_categories', [
            'pt-BR' => 'Gerenciar categorias'
        ]);
        self::generateTranslation('flagged_collections', [
            'pt-BR' => 'Coleções sinalizadas'
        ]);
        self::generateTranslation('create_collection', [
            'pt-BR' => 'Criar coleção'
        ]);
        self::generateTranslation('selected_items_removed', [
            'pt-BR' => '%s selecionados foram removidos.'
        ]);
        self::generateTranslation('edit_collection', [
            'pt-BR' => 'Editar coleção'
        ]);
        self::generateTranslation('manage_collection_items', [
            'pt-BR' => 'Gerenciar itens da coleção'
        ]);
        self::generateTranslation('manage_favorite_collections', [
            'pt-BR' => 'Gerenciar coleções favoritas'
        ]);
        self::generateTranslation('total_fav_collection_removed', [
            'pt-BR' => '%s coleções foram removidas dos favoritos.'
        ]);
        self::generateTranslation('total_photos_deleted', [
            'pt-BR' => '%s fotos foram excluídas com sucesso.'
        ]);
        self::generateTranslation('total_fav_photos_removed', [
            'pt-BR' => '%s fotos foram removidas dos favoritos.'
        ]);
        self::generateTranslation('photos_upload', [
            'pt-BR' => 'Enviar foto'
        ]);
        self::generateTranslation('no_items_found_in_collect', [
            'pt-BR' => 'Nenhum item encontrado nesta coleção'
        ]);
        self::generateTranslation('manage_items', [
            'pt-BR' => 'Gerenciar Itens'
        ]);
        self::generateTranslation('add_new_collection', [
            'pt-BR' => 'Adicionar nova coleção'
        ]);
        self::generateTranslation('update_collection', [
            'pt-BR' => 'Atualizar coleção'
        ]);
        self::generateTranslation('update_photo', [
            'pt-BR' => 'Atualizar foto'
        ]);
        self::generateTranslation('no_collection_found', [
            'pt-BR' => 'Você não tem nenhuma coleção'
        ]);
        self::generateTranslation('photo_title', [
            'pt-BR' => 'Título da foto'
        ]);
        self::generateTranslation('photo_caption', [
            'pt-BR' => 'Legenda da foto'
        ]);
        self::generateTranslation('photo_tags', [
            'pt-BR' => 'Tags de Fotos'
        ]);
        self::generateTranslation('collection', [
            'pt-BR' => 'Coleção'
        ]);
        self::generateTranslation('photo', [
            'pt-BR' => 'Foto'
        ]);
        self::generateTranslation('video', [
            'pt-BR' => 'vídeo'
        ]);
        self::generateTranslation('pic_allow_embed', [
            'pt-BR' => 'Ativar incorporação de fotos'
        ]);
        self::generateTranslation('pic_dallow_embed', [
            'pt-BR' => 'Desativar incorporação de fotos'
        ]);
        self::generateTranslation('pic_allow_rating', [
            'pt-BR' => 'Ativar avaliação de fotos'
        ]);
        self::generateTranslation('pic_dallow_rating', [
            'pt-BR' => 'Desativar avaliação de fotos'
        ]);
        self::generateTranslation('add_more', [
            'pt-BR' => 'Adicionar mais'
        ]);
        self::generateTranslation('collect_name_er', [
            'pt-BR' => 'O nome da coleção está vazio'
        ]);
        self::generateTranslation('collect_descp_er', [
            'pt-BR' => 'A descrição da coleção está vazia'
        ]);
        self::generateTranslation('collect_tag_er', [
            'pt-BR' => 'As tags da coleção estão vazias'
        ]);
        self::generateTranslation('collect_cat_er', [
            'pt-BR' => 'Selecione a categoria de coleção'
        ]);
        self::generateTranslation('collect_borad_pub', [
            'pt-BR' => 'Tornar a coleção pública'
        ]);
        self::generateTranslation('collect_allow_public_up', [
            'pt-BR' => 'Envio Público'
        ]);
        self::generateTranslation('collect_pub_up_dallow', [
            'pt-BR' => 'Proibir que outros usuários adicionem itens.'
        ]);
        self::generateTranslation('collect_pub_up_allow', [
            'pt-BR' => 'Permitir que outros usuários adicionem itens.'
        ]);
        self::generateTranslation('collection_name', [
            'pt-BR' => 'Nome da coleção'
        ]);
        self::generateTranslation('collection_description', [
            'pt-BR' => 'Descrição da coleção'
        ]);
        self::generateTranslation('collection_tags', [
            'pt-BR' => 'Tags da coleção'
        ]);
        self::generateTranslation('collect_category', [
            'pt-BR' => 'Categoria da coleção'
        ]);
        self::generateTranslation('collect_added_msg', [
            'pt-BR' => 'A coleção foi adicionada'
        ]);
        self::generateTranslation('collect_not_exist', [
            'pt-BR' => 'A coleção não existe'
        ]);
        self::generateTranslation('no_upload_opt', [
            'pt-BR' => 'Nenhuma opção de upload permitida por {title}, por favor, contate o administrador do site.'
        ]);
        self::generateTranslation('photos', [
            'pt-BR' => 'Fotos'
        ]);
        self::generateTranslation('cat_all', [
            'pt-BR' => 'Todos'
        ]);
        self::generateTranslation('upload_desktop_msg', [
            'pt-BR' => 'Envie vídeos diretamente da sua área de trabalho e compartilhe-os online com a nossa comunidade '
        ]);
        self::generateTranslation('upload_remote_video_msg', [
            'pt-BR' => 'Enviar vídeos de outros sites ou servidores, simplesmente insira sua URL e clique em Enviar ou você pode inserir a URL do Youtube e clique em Resgatar do YouTube para enviar o vídeo diretamente do youtube sem inserir seus detalhes'
        ]);
        self::generateTranslation('embed_video_msg', [
            'pt-BR' => 'Incorporar vídeos de diferentes sites usando seus \"codigo e imcorporação de vídeo\", basta inserir o código incorporado, insira a duração do vídeo e selecione uma miniatura, preencha os detalhes necessários e clique em enviar.'
        ]);
        self::generateTranslation('link_video_msg', [
            'pt-BR' => 'Se você gostaria de fazer o envio de um vídeo sem ter que esperar a conclusão da etapa de envio simplesmente coloque o URL do seu vídeo aqui juntamente com outros detalhes e aproveite.'
        ]);
        self::generateTranslation('browse_photos', [
            'pt-BR' => 'Explorar fotos'
        ]);
        self::generateTranslation('photo_is_saved_now', [
            'pt-BR' => 'A coleção de fotos foi salva'
        ]);
        self::generateTranslation('photo_success_heading', [
            'pt-BR' => 'A coleção de fotos foi atualizada com sucesso'
        ]);
        self::generateTranslation('share_embed', [
            'pt-BR' => 'Compartilhado / Incorporado'
        ]);
        self::generateTranslation('item_added_in_collection', [
            'pt-BR' => '%s foi adicionado com sucesso na coleção.'
        ]);
        self::generateTranslation('object_exists_collection', [
            'pt-BR' => '%s já existe na coleção.'
        ]);
        self::generateTranslation('collect_tag_hint', [
            'pt-BR' => 'foto horizontal, Ate classica, rico em detalhes'
        ]);
        self::generateTranslation('collect_broad_pri', [
            'pt-BR' => 'Tornar a coleção privada'
        ]);
        self::generateTranslation('collect_item_removed', [
            'pt-BR' => '%s foi removido da coleção.'
        ]);
        self::generateTranslation('most_downloaded', [
            'pt-BR' => 'Mais baixados'
        ]);
        self::generateTranslation('total_videos', [
            'pt-BR' => 'Total de vídeos'
        ]);
        self::generateTranslation('collection_featured', [
            'pt-BR' => 'Coleção destacada.'
        ]);
        self::generateTranslation('collection_unfeatured', [
            'pt-BR' => 'Coleção removida dos destaque.'
        ]);
        self::generateTranslation('upload_right_guide_photo', [
            'pt-BR' => '<strong>Importante: Não envie nenhuma foto que possa ser interpretada como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estas fotos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destas fotos ou tem autorização para fazer o seu envio.</p>'
        ]);
        self::generateTranslation('upload_right_guide_vid', [
            'pt-BR' => '<strong>Importante: Não carregue nenhum vídeo que possa ser interpretado como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estes vídeos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destes vídeos ou tem autorização para fazer o seu envio.</p>'
        ]);
        self::generateTranslation('collection_deactivated', [
            'pt-BR' => 'Coleção desativada.'
        ]);
        self::generateTranslation('collection_activated', [
            'pt-BR' => 'Coleção ativada.'
        ]);
        self::generateTranslation('collection_updated', [
            'pt-BR' => 'Coleção atualizada.'
        ]);
        self::generateTranslation('cant_edit_collection', [
            'pt-BR' => 'Você não pode editar esta coleção'
        ]);
        self::generateTranslation('object_not_in_collect', [
            'pt-BR' => '%s não existe nesta coleção'
        ]);
        self::generateTranslation('object_does_not_exists', [
            'pt-BR' => '%s não existe.'
        ]);
        self::generateTranslation('cant_perform_action_collect', [
            'pt-BR' => 'Você não pode executar tais ações nesta coleção.'
        ]);
        self::generateTranslation('collection_deleted', [
            'pt-BR' => 'Coleção excluída com sucesso.'
        ]);
        self::generateTranslation('collection_not_exists', [
            'pt-BR' => 'A coleção não existe.'
        ]);
        self::generateTranslation('collect_items_deleted', [
            'pt-BR' => 'Itens da coleção excluídos com sucesso.'
        ]);
        self::generateTranslation('photo_title_err', [
            'pt-BR' => 'Por favor, digite um título válido para a foto'
        ]);
        self::generateTranslation('rand_photos', [
            'pt-BR' => 'Fotos aleatórias'
        ]);
        self::generateTranslation('this_has_set_profile_item', [
            'pt-BR' => 'Este %s foi definido como seu item de perfil'
        ]);
        self::generateTranslation('profile_item_removed', [
            'pt-BR' => 'O item do perfil foi removido'
        ]);
        self::generateTranslation('make_profile_item', [
            'pt-BR' => 'Tornar item do perfil'
        ]);
        self::generateTranslation('remove_profile_item', [
            'pt-BR' => 'Remover item do perfil'
        ]);
        self::generateTranslation('content_type_empty', [
            'pt-BR' => 'O Tipo de Conteúdo está vazio. Por favor nos informe o tipo de conteúdo que você quer.'
        ]);
        self::generateTranslation('watch_video_page', [
            'pt-BR' => 'Assistir na página do vídeo'
        ]);
        self::generateTranslation('watch_on_photo_page', [
            'pt-BR' => 'Assistir na página da foto'
        ]);
        self::generateTranslation('found_no_videos', [
            'pt-BR' => 'Nenhum vídeo encontrado'
        ]);
        self::generateTranslation('found_no_photos', [
            'pt-BR' => 'Nenhuma foto encontrada'
        ]);
        self::generateTranslation('collections', [
            'pt-BR' => 'Coleções'
        ]);
        self::generateTranslation('related_videos', [
            'pt-BR' => 'Vídeos Relacionados'
        ]);
        self::generateTranslation('this_video_found_in_no_collection', [
            'pt-BR' => 'Este vídeo foi encontrado nas seguintes coleções'
        ]);
        self::generateTranslation('more_from', [
            'pt-BR' => 'Mais de %s'
        ]);
        self::generateTranslation('this_collection', [
            'pt-BR' => 'Coleção : %s'
        ]);
        self::generateTranslation('vdo_broadcast_unlisted', [
            'pt-BR' => 'Não listado (qualquer um com o link e/ou senha pode visualizar)'
        ]);
        self::generateTranslation('video_link', [
            'pt-BR' => 'Link do vídeo'
        ]);
        self::generateTranslation('channel_settings', [
            'pt-BR' => 'Configurações do canal'
        ]);
        self::generateTranslation('channel_account_settings', [
            'pt-BR' => 'Configurações do canal e conta'
        ]);
        self::generateTranslation('account_settings', [
            'pt-BR' => 'Configurações da conta'
        ]);
        self::generateTranslation('allow_subscription', [
            'pt-BR' => 'Permitir inscrições'
        ]);
        self::generateTranslation('allow_subscription_hint', [
            'pt-BR' => 'Permitir que membros se inscrevam no seu canal?'
        ]);
        self::generateTranslation('channel_title', [
            'pt-BR' => 'Título do Canal'
        ]);
        self::generateTranslation('channel_desc', [
            'pt-BR' => 'Descrição do canal'
        ]);
        self::generateTranslation('show_my_friends', [
            'pt-BR' => 'Mostrar meus amigos'
        ]);
        self::generateTranslation('show_my_videos', [
            'pt-BR' => 'Mostrar meus vídeos'
        ]);
        self::generateTranslation('show_my_photos', [
            'pt-BR' => 'Mostrar minhas fotos'
        ]);
        self::generateTranslation('show_my_subscriptions', [
            'pt-BR' => 'Mostrar minhas inscrições'
        ]);
        self::generateTranslation('show_my_subscribers', [
            'pt-BR' => 'Mostrar meus inscritos'
        ]);
        self::generateTranslation('profile_basic_info', [
            'pt-BR' => 'Informações básicas'
        ]);
        self::generateTranslation('profile_education_interests', [
            'pt-BR' => 'Educação, Hobbies, etc'
        ]);
        self::generateTranslation('channel_profile_settings', [
            'pt-BR' => 'Configurações de canal e perfil'
        ]);
        self::generateTranslation('show_my_collections', [
            'pt-BR' => 'Exibir as minhas coleções'
        ]);
        self::generateTranslation('user_doesnt_any_collection', [
            'pt-BR' => 'Usuário não tem nenhuma coleção.'
        ]);
        self::generateTranslation('unsubscribe', [
            'pt-BR' => 'Desinscrever-se'
        ]);
        self::generateTranslation('you_have_already_voted_channel', [
            'pt-BR' => 'Você já avaliou neste canal'
        ]);
        self::generateTranslation('channel_rating_disabled', [
            'pt-BR' => 'A votação do canal está desativada'
        ]);
        self::generateTranslation('user_activity', [
            'pt-BR' => 'Atividade do usuário'
        ]);
        self::generateTranslation('you_cant_view_profile', [
            'pt-BR' => 'Você não tem permissão para visualizar este canal :/'
        ]);
        self::generateTranslation('only_friends_view_channel', [
            'pt-BR' => 'Somente amigos de %s podem ver este canal'
        ]);
        self::generateTranslation('collect_type', [
            'pt-BR' => 'Tipo da coleção'
        ]);
        self::generateTranslation('add_to_my_collection', [
            'pt-BR' => 'Adicionar isto à minha coleção'
        ]);
        self::generateTranslation('total_collections', [
            'pt-BR' => 'Total de coleções'
        ]);
        self::generateTranslation('total_photos', [
            'pt-BR' => 'Total de fotos'
        ]);
        self::generateTranslation('comments_made', [
            'pt-BR' => 'Comentários feitos'
        ]);
        self::generateTranslation('block_users', [
            'pt-BR' => 'Bloquear usuários'
        ]);
        self::generateTranslation('tp_del_confirm', [
            'pt-BR' => 'Tem certeza que deseja excluir esse tópico?'
        ]);
        self::generateTranslation('you_need_owners_approval_to_view_group', [
            'pt-BR' => 'Você precisa de aprovação de proprietários para visualizar este grupo'
        ]);
        self::generateTranslation('you_cannot_rate_own_collection', [
            'pt-BR' => 'Você não pode avaliar sua própria coleção'
        ]);
        self::generateTranslation('collection_rating_not_allowed', [
            'pt-BR' => 'A classificação da coleção agora é permitida'
        ]);
        self::generateTranslation('you_cant_rate_own_video', [
            'pt-BR' => 'Você não pode avaliar seu próprio vídeo'
        ]);
        self::generateTranslation('you_cant_rate_own_channel', [
            'pt-BR' => 'Você não pode avaliar seu próprio canal'
        ]);
        self::generateTranslation('you_cannot_rate_own_photo', [
            'pt-BR' => 'Você não pode avaliar sua própria foto'
        ]);
        self::generateTranslation('cant_pm_banned_user', [
            'pt-BR' => 'Você não pode enviar mensagens privadas para %s'
        ]);
        self::generateTranslation('you_are_not_allowed_to_view_user_channel', [
            'pt-BR' => 'Você não tem permissão para ver o canal de %s'
        ]);
        self::generateTranslation('you_cant_send_pm_yourself', [
            'pt-BR' => 'Você não pode enviar mensagens privadas para si mesmo'
        ]);
        self::generateTranslation('please_enter_confimation_ode', [
            'pt-BR' => 'Por favor, digite o código de verificação'
        ]);
        self::generateTranslation('vdo_brd_confidential', [
            'pt-BR' => 'Confidencial (Apenas para usuários especificados)'
        ]);
        self::generateTranslation('video_password', [
            'pt-BR' => 'Senha do vídeo'
        ]);
        self::generateTranslation('set_video_password', [
            'pt-BR' => 'Digite a senha de vídeo para torná-lo \"protegido por senha\"'
        ]);
        self::generateTranslation('video_pass_protected', [
            'pt-BR' => 'Este vídeo é protegido por senha, você deve inserir uma senha válida para ver este vídeo'
        ]);
        self::generateTranslation('please_enter_video_password', [
            'pt-BR' => 'Por favor, insira uma senha válida para assistir a este vídeo'
        ]);
        self::generateTranslation('video_is_password_protected', [
            'pt-BR' => '%s está protegido por senha'
        ]);
        self::generateTranslation('invalid_video_password', [
            'pt-BR' => 'Senha do vídeo inválida'
        ]);
        self::generateTranslation('logged_users_only', [
            'pt-BR' => 'Logado apenas (somente usuários logados podem assistir)'
        ]);
        self::generateTranslation('specify_video_users', [
            'pt-BR' => 'Digite um nome de usuário que pode assistir a este vídeo, separado por vírgula'
        ]);
        self::generateTranslation('video_users', [
            'pt-BR' => 'Usuários do vídeo'
        ]);
        self::generateTranslation('not_logged_video_error', [
            'pt-BR' => 'Você não pode assistir a este vídeo porque não está logado'
        ]);
        self::generateTranslation('no_user_subscribed_to_uploader', [
            'pt-BR' => 'Nenhum usuário se inscreveu em %s'
        ]);
        self::generateTranslation('subs_email_sent_to_users', [
            'pt-BR' => 'E-mail de inscrição foi enviado para %s usuário%s'
        ]);
        self::generateTranslation('user_has_uploaded_new_photo', [
            'pt-BR' => '%s enviou uma nova foto'
        ]);
        self::generateTranslation('please_provide_valid_userid', [
            'pt-BR' => 'informe um ID de usuário válido'
        ]);
        self::generateTranslation('user_joined_us', [
            'pt-BR' => '%s juntou-se a %s , disse olá para %s'
        ]);
        self::generateTranslation('user_has_uploaded_new_video', [
            'pt-BR' => '%s enviou um novo vídeo'
        ]);
        self::generateTranslation('user_has_created_new_group', [
            'pt-BR' => '%s criou um novo grupo'
        ]);
        self::generateTranslation('total_members', [
            'pt-BR' => 'Total de membros'
        ]);
        self::generateTranslation('watch_video', [
            'pt-BR' => 'Assista ao vídeo'
        ]);
        self::generateTranslation('view_photo', [
            'pt-BR' => 'Ver foto'
        ]);
        self::generateTranslation('user_has_joined_group', [
            'pt-BR' => '%s juntou-se a um novo grupo'
        ]);
        self::generateTranslation('user_is_now_friend_with_other', [
            'pt-BR' => '%s e %s agora são amigos'
        ]);
        self::generateTranslation('user_has_created_new_collection', [
            'pt-BR' => '%s criou uma nova coleção'
        ]);
        self::generateTranslation('view_collection', [
            'pt-BR' => 'Ver a coleção'
        ]);
        self::generateTranslation('user_has_favorited_video', [
            'pt-BR' => '%s adicionou um vídeo aos favoritos'
        ]);
        self::generateTranslation('activity', [
            'pt-BR' => 'Atividade'
        ]);
        self::generateTranslation('no_activity', [
            'pt-BR' => '%s não possui atividades recentes'
        ]);
        self::generateTranslation('feed_has_been_deleted', [
            'pt-BR' => 'Feed de atividades foi excluído'
        ]);
        self::generateTranslation('you_cant_del_this_feed', [
            'pt-BR' => 'Você não pode excluir este feed'
        ]);
        self::generateTranslation('you_cant_sub_yourself', [
            'pt-BR' => 'Você não pode se inscrever em seu proprio canal'
        ]);
        self::generateTranslation('manage_my_album', [
            'pt-BR' => 'Gerenciar meu álbum'
        ]);
        self::generateTranslation('you_dont_have_permission_to_update_this_video', [
            'pt-BR' => 'Você não tem permissão para atualizar este vídeo'
        ]);
        self::generateTranslation('group_is_public', [
            'pt-BR' => 'O grupo é público'
        ]);
        self::generateTranslation('collection_thumb', [
            'pt-BR' => 'Miniatura da coleção'
        ]);
        self::generateTranslation('collection_is_private', [
            'pt-BR' => 'A Coleção é privada'
        ]);
        self::generateTranslation('edit_type_collection', [
            'pt-BR' => 'Editando %s'
        ]);
        self::generateTranslation('comm_disabled_for_collection', [
            'pt-BR' => 'Comentários desativados nesta coleção'
        ]);
        self::generateTranslation('share_this_type', [
            'pt-BR' => 'Compartilhar este %s'
        ]);
        self::generateTranslation('seperate_usernames_with_comma', [
            'pt-BR' => 'Separe nomes de usuário com vírgula'
        ]);
        self::generateTranslation('view_all', [
            'pt-BR' => 'Visualizar tudo'
        ]);
        self::generateTranslation('album_privacy_updated', [
            'pt-BR' => 'A privacidade do álbum foi atualizada'
        ]);
        self::generateTranslation('you_dont_have_any_videos', [
            'pt-BR' => 'Você não tem nenhum vídeo'
        ]);
        self::generateTranslation('update_blocked_use', [
            'pt-BR' => 'A lista de usuários bloqueada foi atualizada'
        ]);
        self::generateTranslation('you_dont_have_fav_collections', [
            'pt-BR' => 'Você não tem nenhuma coleção favorita'
        ]);
        self::generateTranslation('remote_play', [
            'pt-BR' => 'Reprodução remota'
        ]);
        self::generateTranslation('remote_upload_example', [
            'pt-BR' => 'ex. http://sitedeenvio.com/exemplo.flv http://www.youtube.com/watch?v=QfRHfquzM0'
        ]);
        self::generateTranslation('update_blocked_user_list', [
            'pt-BR' => 'Atualizar lista de usuários bloqueados'
        ]);
        self::generateTranslation('group_is_private', [
            'pt-BR' => 'O grupo é privado'
        ]);
        self::generateTranslation('no_user_associated_with_email', [
            'pt-BR' => 'Nenhum usuário está associado a este endereço de e-mail'
        ]);
        self::generateTranslation('pass_changed_success', [
            'pt-BR' => '<div class=\"simple_container\">\n    \t<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">A senha foi alterada, por favor, verifique seu e-mail</h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 11px;\">Sua senha foi alterada com sucesso, por favor, verifique sua caixa de entrada para converir a senha recém-gerada, assim que você acessar a sua conta, altere a sua senha clicando em Mudar a senha.</p>\n </div>'
        ]);
        self::generateTranslation('add_as_friend', [
            'pt-BR' => 'Adicionar como Amigo'
        ]);
        self::generateTranslation('block_user', [
            'pt-BR' => 'Bloquear usuário'
        ]);
        self::generateTranslation('send_message', [
            'pt-BR' => 'Enviar mensagem'
        ]);
        self::generateTranslation('no_item_was_selected_to_delete', [
            'pt-BR' => 'Nenhum item foi selecionado para excluir'
        ]);
        self::generateTranslation('playlist_items_have_been_removed', [
            'pt-BR' => 'Os itens da lista de reprodução foram removidos'
        ]);
        self::generateTranslation('you_not_grp_mem_or_approved', [
            'pt-BR' => 'Você não entrou ou não é um membro aprovado deste grupo'
        ]);
        self::generateTranslation('no_playlist_was_selected_to_delete', [
            'pt-BR' => 'Selecione uma lista de reprodução primeiro.'
        ]);
        self::generateTranslation('featured_videos', [
            'pt-BR' => 'Vídeos em destaque'
        ]);
        self::generateTranslation('recent_videos', [
            'pt-BR' => 'Vídeos recentes'
        ]);
        self::generateTranslation('featured_users', [
            'pt-BR' => 'Usuários em destaque'
        ]);
        self::generateTranslation('top_collections', [
            'pt-BR' => 'Top coleções'
        ]);
        self::generateTranslation('top_playlists', [
            'pt-BR' => 'Top Playlists'
        ]);
        self::generateTranslation('load_more', [
            'pt-BR' => 'Carregar mais'
        ]);
        self::generateTranslation('no_playlists', [
            'pt-BR' => 'Nenhuma lista de reprodução encontrada'
        ]);
        self::generateTranslation('featured_photos', [
            'pt-BR' => 'Fotos em destaque'
        ]);
        self::generateTranslation('no_channel_found', [
            'pt-BR' => 'Nenhum canal encontrado'
        ]);
        self::generateTranslation('download', [
            'pt-BR' => 'Baixar'
        ]);
        self::generateTranslation('add_to', [
            'pt-BR' => 'Adicionar a'
        ]);
        self::generateTranslation('player_size', [
            'pt-BR' => 'Tamanho do Player'
        ]);
        self::generateTranslation('small', [
            'pt-BR' => 'Pequeno'
        ]);
        self::generateTranslation('medium', [
            'pt-BR' => 'Médio'
        ]);
        self::generateTranslation('large', [
            'pt-BR' => 'Grande'
        ]);
        self::generateTranslation('iframe', [
            'pt-BR' => 'Iframe'
        ]);
        self::generateTranslation('embed_object', [
            'pt-BR' => 'Objeto Incorporado'
        ]);
        self::generateTranslation('add_to_my_favorites', [
            'pt-BR' => 'Adicionar aos favoritos'
        ]);
        self::generateTranslation('please_select_playlist', [
            'pt-BR' => 'Por favor, selecione o nome da lista de reprodução a seguir'
        ]);
        self::generateTranslation('create_new_playlist', [
            'pt-BR' => 'Criar uma nova lista de reprodução'
        ]);
        self::generateTranslation('select_playlist', [
            'pt-BR' => 'Selecionar da lista de reprodução'
        ]);
        self::generateTranslation('report_video', [
            'pt-BR' => 'Denunciar vídeo'
        ]);
        self::generateTranslation('report_text', [
            'pt-BR' => 'Por favor, selecione a categoria que reflete mais de perto sua preocupação com o vídeo, para que possamos revê-lo e determinar se ele viola as nossas Diretrizes Comunitárias ou se não é apropriado para todos os telespectadores. Abusar deste recurso é também uma violação das Diretrizes Comunitárias, por isso não o faça. '
        ]);
        self::generateTranslation('flag_video', [
            'pt-BR' => 'Sinalizar este vídeo'
        ]);
        self::generateTranslation('comment_as', [
            'pt-BR' => 'Comente como'
        ]);
        self::generateTranslation('more_replies', [
            'pt-BR' => 'Mais respostas'
        ]);
        self::generateTranslation('photo_description', [
            'pt-BR' => 'Descrição da foto'
        ]);
        self::generateTranslation('flag', [
            'pt-BR' => 'Sinalizar'
        ]);
        self::generateTranslation('update_cover', [
            'pt-BR' => 'Atualizar capa'
        ]);
        self::generateTranslation('unfriend', [
            'pt-BR' => 'Desfazer Amizade'
        ]);
        self::generateTranslation('accept_request', [
            'pt-BR' => 'Aceitar solicitação'
        ]);
        self::generateTranslation('online', [
            'pt-BR' => 'Online'
        ]);
        self::generateTranslation('offline', [
            'pt-BR' => 'Offline'
        ]);
        self::generateTranslation('upload_video', [
            'pt-BR' => 'Enviar vídeo'
        ]);
        self::generateTranslation('upload_photo', [
            'pt-BR' => 'Enviar foto'
        ]);
        self::generateTranslation('upload_beats_guide', [
            'pt-BR' => '<strong>Importante: Não carregue nenhum áudio que possa ser interpretado como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que esses áudios não violam os Termos de Uso de Nosso Site e que você possui todos os direitos autorais desses áudios ou tem autorização para fazer o seu envio.</p>'
        ]);
        self::generateTranslation('admin_area', [
            'pt-BR' => 'Área do Administrador'
        ]);
        self::generateTranslation('view_channels', [
            'pt-BR' => 'Ver canais'
        ]);
        self::generateTranslation('my_channel', [
            'pt-BR' => 'Meu Canal'
        ]);
        self::generateTranslation('manage_videos', [
            'pt-BR' => 'Gerenciar Vídeos'
        ]);
        self::generateTranslation('cancel_request', [
            'pt-BR' => 'Cancelar solicitação'
        ]);
        self::generateTranslation('contact', [
            'pt-BR' => 'Contato'
        ]);
        self::generateTranslation('no_featured_videos_found', [
            'pt-BR' => 'Nenhum vídeo em destaque encontrado'
        ]);
        self::generateTranslation('no_recent_videos_found', [
            'pt-BR' => 'Nenhum vídeo recente encontrado'
        ]);
        self::generateTranslation('no_collection_found_alert', [
            'pt-BR' => 'Nenhuma coleção encontrada! Você deve criar uma coleção antes de enviar qualquer foto'
        ]);
        self::generateTranslation('select_collection_upload', [
            'pt-BR' => 'Selecionar coleção'
        ]);
        self::generateTranslation('no_collection_upload', [
            'pt-BR' => 'Nenhuma coleção encontrada'
        ]);
        self::generateTranslation('create_new_collection_btn', [
            'pt-BR' => 'Criar uma nova coleção'
        ]);
        self::generateTranslation('photo_upload_tab', [
            'pt-BR' => 'Enviar foto'
        ]);
        self::generateTranslation('no_videos_found', [
            'pt-BR' => 'Nenhum vídeo encontrado!'
        ]);
        self::generateTranslation('Latest_Videos', [
            'pt-BR' => 'Vídeos mais recentes'
        ]);
        self::generateTranslation('videos_details', [
            'pt-BR' => 'Detalhes dos Vídeos'
        ]);
        self::generateTranslation('option', [
            'pt-BR' => 'Opção'
        ]);
        self::generateTranslation('flagged_obj', [
            'pt-BR' => 'Objetos Sinalizados'
        ]);
        self::generateTranslation('watched', [
            'pt-BR' => 'Assistido'
        ]);
        self::generateTranslation('since', [
            'pt-BR' => 'desde'
        ]);
        self::generateTranslation('last_Login', [
            'pt-BR' => 'Última Conexão'
        ]);
        self::generateTranslation('no_friends_in_list', [
            'pt-BR' => 'Você não tem amigos na sua lista'
        ]);
        self::generateTranslation('no_pending_friend', [
            'pt-BR' => 'Nenhum pedido de amizade pendente'
        ]);
        self::generateTranslation('hometown', [
            'pt-BR' => 'Cidade natal'
        ]);
        self::generateTranslation('city', [
            'pt-BR' => 'Cidade'
        ]);
        self::generateTranslation('schools', [
            'pt-BR' => 'Escolas'
        ]);
        self::generateTranslation('occupation', [
            'pt-BR' => 'Ocupação'
        ]);
        self::generateTranslation('you_dont_have_videos', [
            'pt-BR' => 'Você não tem vídeos'
        ]);
        self::generateTranslation('write_msg', [
            'pt-BR' => 'Escrever mensagem'
        ]);
        self::generateTranslation('content', [
            'pt-BR' => 'Conteúdo'
        ]);
        self::generateTranslation('no_video', [
            'pt-BR' => 'Nenhum vídeo'
        ]);
        self::generateTranslation('back_to_collection', [
            'pt-BR' => 'Voltar para Coleção'
        ]);
        self::generateTranslation('long_txt', [
            'pt-BR' => 'Todas as fotos enviadas são dependentes de suas coleções/álbuns. Ao remover alguma foto de coleção/álbum, isto não vai excluir a foto de forma permanente. Isto irá mover a foto daqui. Você também pode usar isto para tornar suas fotos privadas. O link direto está disponível para compartilhamento com seus amigos.'
        ]);
        self::generateTranslation('make_my_album', [
            'pt-BR' => 'Criar meu álbum'
        ]);
        self::generateTranslation('public', [
            'pt-BR' => 'Público'
        ]);
        self::generateTranslation('private', [
            'pt-BR' => 'Privado'
        ]);
        self::generateTranslation('for_friends', [
            'pt-BR' => 'Para Amigos'
        ]);
        self::generateTranslation('submit_now', [
            'pt-BR' => 'Enviar Agora'
        ]);
        self::generateTranslation('drag_drop', [
            'pt-BR' => 'Arraste &amp; solte arquivos aqui'
        ]);
        self::generateTranslation('upload_more_videos', [
            'pt-BR' => 'Envie mais vídeos'
        ]);
        self::generateTranslation('selected_files', [
            'pt-BR' => 'Arquivos Selecionados'
        ]);
        self::generateTranslation('upload_in_progress', [
            'pt-BR' => 'Envio em andamento'
        ]);
        self::generateTranslation('complete_of_video', [
            'pt-BR' => 'Conclusão do Vídeo'
        ]);
        self::generateTranslation('playlist_videos', [
            'pt-BR' => 'Vídeos da lista de reprodução'
        ]);
        self::generateTranslation('popular_videos', [
            'pt-BR' => 'Vídeos populares'
        ]);
        self::generateTranslation('uploading', [
            'pt-BR' => 'Enviando'
        ]);
        self::generateTranslation('select_photos', [
            'pt-BR' => 'Selecionar fotos'
        ]);
        self::generateTranslation('uploading_in_progress', [
            'pt-BR' => 'Envio em andamento '
        ]);
        self::generateTranslation('complete_of_photo', [
            'pt-BR' => 'Completo da Foto'
        ]);
        self::generateTranslation('upload_more_photos', [
            'pt-BR' => 'Envie mais fotos'
        ]);
        self::generateTranslation('save_details', [
            'pt-BR' => 'Salvar Detalhes'
        ]);
        self::generateTranslation('related_photos', [
            'pt-BR' => 'Fotos Relacionadas'
        ]);
        self::generateTranslation('no_photos_found', [
            'pt-BR' => 'Nenhuma foto encontrada !'
        ]);
        self::generateTranslation('search_keyword_feed', [
            'pt-BR' => 'Pesquisar palavra-chave aqui'
        ]);
        self::generateTranslation('contacts_manager', [
            'pt-BR' => 'Gerenciador de Contatos'
        ]);
        self::generateTranslation('weak_pass', [
            'pt-BR' => 'A senha é fraca'
        ]);
        self::generateTranslation('create_account_msg', [
            'pt-BR' => 'Junte-se para começar a compartilhar vídeos e fotos. Leva apenas alguns minutos para criar a sua conta gratuita'
        ]);
        self::generateTranslation('get_your_account', [
            'pt-BR' => 'Criar Conta'
        ]);
        self::generateTranslation('type_password_here', [
            'pt-BR' => 'Digite a senha'
        ]);
        self::generateTranslation('type_username_here', [
            'pt-BR' => 'Digite um nome de usuário'
        ]);
        self::generateTranslation('terms_of_service', [
            'pt-BR' => 'Termos de Serviço'
        ]);
        self::generateTranslation('upload_vid_thumb_msg', [
            'pt-BR' => 'Miniaturas carregadas com sucesso'
        ]);
        self::generateTranslation('agree', [
            'pt-BR' => 'Eu concordo com os'
        ]);
        self::generateTranslation('terms', [
            'pt-BR' => 'Termos de Serviço'
        ]);
        self::generateTranslation('and', [
            'pt-BR' => 'e'
        ]);
        self::generateTranslation('policy', [
            'pt-BR' => 'Política de Privacidade'
        ]);
        self::generateTranslation('watch', [
            'pt-BR' => 'Assistir'
        ]);
        self::generateTranslation('edit_video', [
            'pt-BR' => 'Editar'
        ]);
        self::generateTranslation('del_video', [
            'pt-BR' => 'Excluir'
        ]);
        self::generateTranslation('successful', [
            'pt-BR' => 'Sucesso'
        ]);
        self::generateTranslation('processing', [
            'pt-BR' => 'Processando'
        ]);
        self::generateTranslation('last_one', [
            'pt-BR' => 'Ultimo'
        ]);
        self::generateTranslation('creating_collection_is_disabled', [
            'pt-BR' => 'A criação de coleção foi desativada'
        ]);
        self::generateTranslation('creating_playlist_is_disabled', [
            'pt-BR' => 'A criação de lista de reprodução está desativada'
        ]);
        self::generateTranslation('inactive', [
            'pt-BR' => 'Inativo'
        ]);
        self::generateTranslation('vdo_actions', [
            'pt-BR' => 'Ações'
        ]);
        self::generateTranslation('view_ph', [
            'pt-BR' => 'Ver'
        ]);
        self::generateTranslation('edit_ph', [
            'pt-BR' => 'Editar'
        ]);
        self::generateTranslation('delete_ph', [
            'pt-BR' => 'Excluir'
        ]);
        self::generateTranslation('title_ph', [
            'pt-BR' => 'Título'
        ]);
        self::generateTranslation('view_edit_playlist', [
            'pt-BR' => 'Ver/Editar'
        ]);
        self::generateTranslation('no_playlist_found', [
            'pt-BR' => 'Nenhuma lista de reprodução encontrada'
        ]);
        self::generateTranslation('playlist_owner', [
            'pt-BR' => 'Dono'
        ]);
        self::generateTranslation('playlist_privacy', [
            'pt-BR' => 'Privacidade'
        ]);
        self::generateTranslation('add_to_collection', [
            'pt-BR' => 'Adicionar à coleção'
        ]);
        self::generateTranslation('video_added_to_playlist', [
            'pt-BR' => 'Este vídeo foi adicionado à lista de reprodução'
        ]);
        self::generateTranslation('subscribe_btn', [
            'pt-BR' => 'Inscrever-se'
        ]);
        self::generateTranslation('report_usr', [
            'pt-BR' => 'Denunciar'
        ]);
        self::generateTranslation('un_reg_user', [
            'pt-BR' => 'Usuário não registrado'
        ]);
        self::generateTranslation('my_playlists', [
            'pt-BR' => 'Minhas listas de reprodução'
        ]);
        self::generateTranslation('play', [
            'pt-BR' => 'Reproduzir agora'
        ]);
        self::generateTranslation('no_vid_in_playlist', [
            'pt-BR' => 'Nenhum vídeo encontrado nesta lista de reprodução!'
        ]);
        self::generateTranslation('website_offline', [
            'pt-BR' => 'ATENÇÃO: ESTE SITE ESTÁ NO MODO OFFLINE'
        ]);
        self::generateTranslation('loading', [
            'pt-BR' => 'Carregando'
        ]);
        self::generateTranslation('hour', [
            'pt-BR' => 'hora'
        ]);
        self::generateTranslation('hours', [
            'pt-BR' => 'horas'
        ]);
        self::generateTranslation('day', [
            'pt-BR' => 'dia'
        ]);
        self::generateTranslation('days', [
            'pt-BR' => 'dias'
        ]);
        self::generateTranslation('week', [
            'pt-BR' => 'semana'
        ]);
        self::generateTranslation('weeks', [
            'pt-BR' => 'semanas'
        ]);
        self::generateTranslation('month', [
            'pt-BR' => 'mês'
        ]);
        self::generateTranslation('months', [
            'pt-BR' => 'meses'
        ]);
        self::generateTranslation('year', [
            'pt-BR' => 'ano'
        ]);
        self::generateTranslation('years', [
            'pt-BR' => 'anos'
        ]);
        self::generateTranslation('decade', [
            'pt-BR' => 'década'
        ]);
        self::generateTranslation('decades', [
            'pt-BR' => 'décadas'
        ]);
        self::generateTranslation('your_name', [
            'pt-BR' => 'Seu nome'
        ]);
        self::generateTranslation('your_email', [
            'pt-BR' => 'Seu e-mail'
        ]);
        self::generateTranslation('type_comment_box', [
            'pt-BR' => 'Por favor, digite algo na caixa de comentários'
        ]);
        self::generateTranslation('guest', [
            'pt-BR' => 'Visitante'
        ]);
        self::generateTranslation('anonymous', [
            'pt-BR' => 'Anônimo'
        ]);
        self::generateTranslation('no_comment_added', [
            'pt-BR' => 'Nenhum comentário adicionado'
        ]);
        self::generateTranslation('register_min_age_request', [
            'pt-BR' => 'Você deve ter pelo menos %s anos de idade para registrar'
        ]);
        self::generateTranslation('select_category', [
            'pt-BR' => 'Por favor, selecione sua categoria'
        ]);
        self::generateTranslation('custom', [
            'pt-BR' => 'Personalizado'
        ]);
        self::generateTranslation('no_playlist_exists', [
            'pt-BR' => 'Não existe nenhuma lista de reprodução'
        ]);
        self::generateTranslation('edit', [
            'pt-BR' => 'Editar'
        ]);
        self::generateTranslation('create_new_account', [
            'pt-BR' => 'Criar uma nova conta'
        ]);
        self::generateTranslation('search_too_short', [
            'pt-BR' => 'Consulta de pesquisa %s é muito curta. Abra!'
        ]);
        self::generateTranslation('playlist_allow_comments', [
            'pt-BR' => 'Permitir comentários'
        ]);
        self::generateTranslation('playlist_allow_rating', [
            'pt-BR' => 'Permitir avaliação'
        ]);
        self::generateTranslation('playlist_description', [
            'pt-BR' => 'Descrição'
        ]);
        self::generateTranslation('playlists_have_been_removed', [
            'pt-BR' => 'As Listas de reprodução foram removidas'
        ]);
        self::generateTranslation('confirm_collection_delete', [
            'pt-BR' => 'Você realmente quer excluir esta coleção ?'
        ]);
        self::generateTranslation('please_select_collection', [
            'pt-BR' => 'Por favor, selecione o nome da coleção a seguir'
        ]);
        self::generateTranslation('please_enter_collection_name', [
            'pt-BR' => 'Por favor, insira o nome da coleção'
        ]);
        self::generateTranslation('select_collection', [
            'pt-BR' => 'Selecione da coleção'
        ]);
        self::generateTranslation('resolution', [
            'pt-BR' => 'Resolução'
        ]);
        self::generateTranslation('filesize', [
            'pt-BR' => 'Tamanho do arquivo'
        ]);
        self::generateTranslation('empty_next', [
            'pt-BR' => 'A lista de reprodução atingiu o seu limite!'
        ]);
        self::generateTranslation('no_items', [
            'pt-BR' => 'Não há itens'
        ]);
        self::generateTranslation('user_recover_user', [
            'pt-BR' => 'Esqueceu o Usuário'
        ]);
        self::generateTranslation('edited_by', [
            'pt-BR' => 'editado por'
        ]);
        self::generateTranslation('reply_to', [
            'pt-BR' => 'Responder a'
        ]);
        self::generateTranslation('mail_type', [
            'pt-BR' => 'Tipo de email'
        ]);
        self::generateTranslation('host', [
            'pt-BR' => 'Servidor'
        ]);
        self::generateTranslation('port', [
            'pt-BR' => 'Porta'
        ]);
        self::generateTranslation('user', [
            'pt-BR' => 'Usuário'
        ]);
        self::generateTranslation('auth', [
            'pt-BR' => 'Autenticação'
        ]);
        self::generateTranslation('mail_not_send', [
            'pt-BR' => 'Não foi possível enviar o e-mail <strong>%s</strong>'
        ]);
        self::generateTranslation('mail_send', [
            'pt-BR' => 'E-mail enviado com sucesso para <strong>%s</strong>'
        ]);
        self::generateTranslation('title', [
            'pt-BR' => 'Título'
        ]);
        self::generateTranslation('show_comments', [
            'pt-BR' => 'Mostrar comentários'
        ]);
        self::generateTranslation('hide_comments', [
            'pt-BR' => 'Ocultar comentários'
        ]);
        self::generateTranslation('description', [
            'pt-BR' => 'Descrição'
        ]);
        self::generateTranslation('users_categories', [
            'pt-BR' => 'Categorias de Usuários'
        ]);
        self::generateTranslation('popular_users', [
            'pt-BR' => 'Usuários Populares'
        ]);
        self::generateTranslation('channel', [
            'pt-BR' => 'Canal'
        ]);
        self::generateTranslation('embed_type', [
            'pt-BR' => 'Tipo de Incorporação'
        ]);
        self::generateTranslation('confirm_del_photo', [
            'pt-BR' => 'Você tem certeza que deseja excluir esta foto?'
        ]);
        self::generateTranslation('vdo_inactive', [
            'pt-BR' => 'O vídeo está inativo'
        ]);
        self::generateTranslation('photo_tags_error', [
            'pt-BR' => 'Por favor, especifique tags para a Foto'
        ]);
        self::generateTranslation('signups', [
            'pt-BR' => 'Cadastros'
        ]);
        self::generateTranslation('active_users', [
            'pt-BR' => 'Usuários Ativos'
        ]);
        self::generateTranslation('uploaded', [
            'pt-BR' => 'Enviado'
        ]);
        self::generateTranslation('user_name_invalid_len', [
            'pt-BR' => 'Comprimento do usuário é inválido'
        ]);
        self::generateTranslation('username_spaces', [
            'pt-BR' => 'O nome de usuário não pode conter espaços'
        ]);
        self::generateTranslation('photo_caption_err', [
            'pt-BR' => 'Digite a descrição da foto'
        ]);
        self::generateTranslation('photo_tags_err', [
            'pt-BR' => 'Por favor, digite Tags Para a Foto'
        ]);
        self::generateTranslation('photo_collection_err', [
            'pt-BR' => 'Você deve especificar uma coleção para esta foto'
        ]);
        self::generateTranslation('details', [
            'pt-BR' => 'Detalhes'
        ]);
        self::generateTranslation('technical_error', [
            'pt-BR' => 'Ocorreu um erro técnico!'
        ]);
        self::generateTranslation('inserted', [
            'pt-BR' => 'Inserido'
        ]);
        self::generateTranslation('castable_status_fixed', [
            'pt-BR' => 'O Estado de Transmitido de %s foi corrigido'
        ]);
        self::generateTranslation('castable_status_failed', [
            'pt-BR' => '%s não pode ser transmitido corretamente porque tem %s canais de áudio, por favor, reconverta o vídeo com opção chromecast ativada'
        ]);
        self::generateTranslation('castable_status_check', [
            'pt-BR' => 'Verificar Estado de Transmitivel'
        ]);
        self::generateTranslation('castable', [
            'pt-BR' => 'Transmitível'
        ]);
        self::generateTranslation('non_castable', [
            'pt-BR' => 'Não-Transmissível'
        ]);
        self::generateTranslation('videos_manager', [
            'pt-BR' => 'Gerenciador de vídeos'
        ]);
        self::generateTranslation('update_bits_color', [
            'pt-BR' => 'Atualizar cores de bits'
        ]);
        self::generateTranslation('bits_color', [
            'pt-BR' => 'cores dos bits'
        ]);
        self::generateTranslation('bits_color_compatibility', [
            'pt-BR' => 'O formato de vídeo torna isso impossível de reproduzir em alguns navegadores como Firefox, Safari, ...'
        ]);
        self::generateTranslation('player_logo_reset', [
            'pt-BR' => 'O logo do player foi redefinido'
        ]);
        self::generateTranslation('player_settings_updated', [
            'pt-BR' => 'As configurações do player foram atualizadas'
        ]);
        self::generateTranslation('player_settings', [
            'pt-BR' => 'Configurações do player'
        ]);
        self::generateTranslation('quality', [
            'pt-BR' => 'Qualidade'
        ]);
        self::generateTranslation('error_occured', [
            'pt-BR' => 'Ops... Algo de errado aconteceu...'
        ]);
        self::generateTranslation('error_file_download', [
            'pt-BR' => 'Falha ao obter o arquivo'
        ]);
        self::generateTranslation('dashboard_update_status', [
            'pt-BR' => 'Estado da Atualização'
        ]);
        self::generateTranslation('dashboard_changelogs', [
            'pt-BR' => 'Registro de alterações'
        ]);
        self::generateTranslation('dashboard_php_config_allow_url_fopen', [
            'pt-BR' => 'Por favor, habilite \'allow_url_fopen\' para beneficiar o relatório de alterações'
        ]);
        self::generateTranslation('signup_error_email_unauthorized', [
            'pt-BR' => 'E-mail não permitido'
        ]);
        self::generateTranslation('video_detail_saved', [
            'pt-BR' => 'Os detalhes do vídeo foram salvos'
        ]);
        self::generateTranslation('video_subtitles_deleted', [
            'pt-BR' => 'As legendas do vídeo foram excluídas'
        ]);
        self::generateTranslation('collection_no_parent', [
            'pt-BR' => 'Nenhum progenitor'
        ]);
        self::generateTranslation('collection_parent', [
            'pt-BR' => 'Coleção parental'
        ]);
        self::generateTranslation('comments_disabled_for_photo', [
            'pt-BR' => 'Comentários desativados para esta foto'
        ]);
        self::generateTranslation('plugin_editors_picks', [
            'pt-BR' => 'Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_added', [
            'pt-BR' => 'O vídeo foi adicionado à Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_removed', [
            'pt-BR' => 'O vídeo foi removido da Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_removed_plural', [
            'pt-BR' => 'O vídeo selecionado foi removido da Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_add_error', [
            'pt-BR' => 'O vídeo já está na Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_add_to', [
            'pt-BR' => 'Adicionar à Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_from', [
            'pt-BR' => 'Remover da Escolha do Editor'
        ]);
        self::generateTranslation('plugin_editors_picks_remove_confirm', [
            'pt-BR' => 'Tem certeza de que deseja remover os vídeos selecionados da Escolha do Editor?'
        ]);
        self::generateTranslation('plugin_global_announcement', [
            'pt-BR' => 'Anúncio Global'
        ]);
        self::generateTranslation('plugin_global_announcement_subtitle', [
            'pt-BR' => 'Gerenciador de Anúncios Globais'
        ]);
        self::generateTranslation('plugin_global_announcement_edit', [
            'pt-BR' => 'Editar anúncio global'
        ]);
        self::generateTranslation('plugin_global_announcement_updated', [
            'pt-BR' => 'O anúncio global foi atualizado'
        ]);
        self::generateTranslation('page_upload_video_limits', [
            'pt-BR' => 'Cada vídeo não pode exceder %s MB de tamanho ou %s minutos de duração e deve estar em um formato de vídeo comum'
        ]);
        self::generateTranslation('page_upload_video_select', [
            'pt-BR' => ' Selecionar vídeo'
        ]);
        self::generateTranslation('page_upload_photo_limits', [
            'pt-BR' => 'Cada foto não pode exceder %s MB de tamanho e deve estar em um formato de imagem comum'
        ]);
        self::generateTranslation('video_resolution_auto', [
            'pt-BR' => 'Automático'
        ]);
        self::generateTranslation('video_thumbs_regenerated', [
            'pt-BR' => 'As miniaturas do vídeo foram regeneradas com sucesso'
        ]);
        self::generateTranslation('video_allow_comment_vote', [
            'pt-BR' => 'Permitir votos nos comentários'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages` DROP COLUMN language_code', [
            'table'  => 'languages',
            'column' => 'language_code'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages` DROP COLUMN language_regex', [
            'table'  => 'languages',
            'column' => 'language_regex'
        ]);
    }
}