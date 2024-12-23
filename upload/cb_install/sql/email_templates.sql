INSERT INTO `{tbl_prefix}email_variable` (code, type, language_key) VALUES ('email_content','template', 'email_variable_content'),
('website_title','global', 'email_variable_website_title'),
('user_username','global', 'email_variable_user_username'),
('user_email','global', 'email_variable_user_email'),
('user_avatar','global', 'email_variable_user_avatar'),
('date_year','global', 'email_variable_date_year'),
('baseurl','global', 'email_variable_baseurl'),
('date_time','global', 'email_variable_date_time'),
('login_link','global', 'email_variable_login_link'),
('video_link','email', 'email_variable_video_link'),
('video_title','email', 'email_variable_video_title'),
('video_thumb','email', 'email_variable_video_thumb'),
('video_description','email', 'email_variable_video_description'),
('user_message','email', 'email_variable_user_message'),
('avcode','email', 'email_variable_avcode'),
('subject','email', 'email_variable_subject'),
('sender_username','email', 'email_variable_sender_username'),
('sender_email','email', 'email_variable_sender_email'),
('profile_link','email', 'email_variable_profile_link'),
('request_link','email', 'email_variable_request_link'),
('photo_link','email', 'email_variable_photo_link'),
('photo_thumb','email', 'email_variable_photo_thumb'),
('photo_description','email', 'email_variable_photo_description'),
('photo_title','email', 'email_variable_photo_title'),
('collection_link','email', 'email_variable_collection_link'),
('collection_thumb','email', 'email_variable_collection_thumb'),
('collection_description','email', 'email_variable_collection_description'),
('collection_title','email', 'email_variable_collection_title'),
('total_items','email', 'email_variable_total_items'),
('collection_type','email', 'email_variable_collection_type'),
('private_message_link','email', 'email_variable_private_message_link'),
('password','email', 'email_variable_password'),
('reset_password_link','email', 'email_variable_reset_password_link'),
('comment_link','email', 'email_variable_comment_link'),
('object','email', 'email_variable_object');

INSERT INTO `{tbl_prefix}email_template` (`code`, `is_default`, `is_deletable`, `content`, `disabled`) VALUES ('main', TRUE, FALSE, '<html><body>{{email_content}}</body></html>', FALSE);

INSERT INTO `{tbl_prefix}email` (`code`, `id_email_template`, `is_deletable`, `title`, `content`, `disabled`) VALUES
    ('share_video_template', 1, 0, '[{{website_title}}] - {{sender_username}} wants to share a video with you', '<table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td bgcolor="#53baff" ><span class="title">{{website_title}}</span>share video</td>
        </tr>
        <tr>
            <td height="20" class="messege">{{sender_username}} wants to share Video With You
                <div id="videoThumb"><a href="{{video_link}}"><img src="{{video_thumb}}"><br>
                    watch video</a></div></td>
        </tr>
        <tr>
            <td class="text" ><span class="title2">Video Description</span><br>
                <span class="text">{{video_description}}</span></td>
        </tr>
        <tr>
            <td><span class="title2">Personal Message</span><br>
                <span class="text">{{user_message}}
                      </span><br>
                <br>
                <span class="text">Thanks,</span><br>
                <span class="text">{{website_title}}</span></td>
        </tr>
        <tr>
            <td bgcolor="#53baff">copyrights {{date_year}} {{website_title}}</td>
        </tr>
    </table>', 0),
    ('photo_share_template', 1, 0, '[{{website_title}}] - {{sender_username}} wants to share a photo with you'
    , '<table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td bgcolor="#0099cc" ><span class="title">{{website_title}}</span></td>
        </tr>

        <tr>
            <td height="20" class="messege">{{sender_username}} wants to share this photo with you<br>
                <div id="videoThumb"><a class="text" href="{{photo_link}}" title="{{photo_title}}"><img src="{{photo_thumb}}"><br>
                    View Photo</a></div></td>
        </tr>
        <tr>
            <td class="text" ><span class="title2">Photo Description</span><br>
                <span class="text">{{photo_description}}</span></td>
        </tr>
        <tr>
            <td><span class="title2">Personal Message</span><br>
                <span class="text">{{user_message}}
                           </span><br>
                <br>
                <span class="text">Thanks,</span><br>
                <span class="text">{{website_title}}</span></td>
        </tr>
        <tr>
            <td bgcolor="#0099cc">copyrights {{date_year}} {{website_title}}</td>
        </tr>
    </table>', 0),
    ('collection_share_template', 1, 0, '[{{website_title}}] - {{sender_username}} wants to share a collection with you', '<table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td bgcolor="#0099cc" ><span class="title">{{website_title}}</span></td>
        </tr>

        <tr>
            <td height="20" class="messege">{{sender_username}} wants to share this collection with you.<br>
                <div id="videoThumb"><a class="text" href="{{collection_link}}" title="{{collection_title}}"><img src="{{collection_thumb}}"><br>
                    View Collection <small class="text2">({{total_items}} {{collection_type}})</small></a></div></td>
        </tr>
        <tr>
            <td class="text" ><span class="title2">Collection Description</span><br>
                <span class="text">{{collection_description}}</span></td>
        </tr>
        <tr>
            <td><span class="title2">Personal Message</span><br>
                <span class="text">{{user_message}}
                       </span><br>
                <br>
                <span class="text">Thanks,</span><br>
                <span class="text">{{website_title}}</span></td>
        </tr>
        <tr>
            <td bgcolor="#0099cc">copyrights {{date_year}} {{website_title}}</td>
        </tr>
    </table>', 0),
    ('email_verify_template', 1, 0, '[{{website_title}}]- Account activation email', 'Hello {{user_username}},
    Thank you for joining {{website_title}}, one last step is required in order to activate your account

    <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">Click Here</a>

    Email           : {{user_email}}
    Username        : {{user_username}}
    Activation code : {{avcode}}

    if above given is not working , please go here and activate it
    <a href="{{baseurl}}activation.php">Activate</a>', 0),
    ('pm_email_message', 1, 0, '[{{website_title}}] - {{sender_username}} has sent you a private message', '{{sender_username}} has sent you a private message,

    {{subject}}
    "{{user_message}}"

    click here to view your inbox <a href="{{message_link}}">Inbox</a>

    {{website_title}}', 0),
    ('welcome_message_template', 1, 0, 'Welcome {{user_username}} to {{website_title}}', 'Hello {{user_username}},
     Thanks for joining at {{website_title}}!, you are now part of our community and we hope you will enjoy your stay

            All the best,
        {{website_title}}', 0),
    ('password_reset_request', 1, 0, '[{{website_title}}] - Password reset confirmation', 'Dear {{user_username}}
    you have requested a password reset, please follow the link in order to reset your password
    <a href="{{reset_password_link}}">Reset my password</a>

    -----------------------------------------
    IF YOU HAVE NOT REQUESTED A PASSWORD RESET - PLEASE IGNORE THIS MESSAGE
    -----------------------------------------
    Regards
    {{website_title}}', 0),
    ('password_reset_details', 1, 0, '[{{website_title}}] - Password reset details', 'Dear {{user_username}}
    your password has been reset
    your new password is : {{password}}

    <a href="{{login_link}}">click here to login to website</a>

    ---------------
    Regards
    {{website_title}}', 0),
    ('forgot_username_request', 1, 0, '[{{website_title}}] - your {{website_title}} username', 'Hello,
    your {{website_title}} username is : {{user_username}}

    --------------
    Regards
    {{website_title}}', 0),
    ('friend_request_email', 1, 0, '[{{website_title}}] {{user_username}} add you as friend', 'Hi {{user_username}},
    {{sender_username}} added you as a friend on {{website_title}}. We need to confirm that you know {{sender_username}} in order for you to be friends on {{website_title}}.

    <a href="{{profile_link}}">View profile of {{sender_username}}</a>
    <a href="{{request_link}}">click here to respond to friendship request</a>

    Thanks,
    {{website_title}} Team', 0),
    ('friend_confirmation_email', 1, 0, '[{{website_title}}] - {{sender_username}} has confirmed you as a friend', 'Hi {{user_username}},
    {{sender_username}} confirmed you as a friend on {{website_title}}.

    <a href="{{profile_link}}">View {{sender_username}} profile</a>

    Thanks,
    The {{website_title}} Team', 0),
    ('contact_form', 1, 0, '[{{website_title}} - Contact] {{subject}} from {{user_username}}', 'Name : {{user_username}}
    Email : {{user_email}}
    Reason : {{subject}}

    Message:
    {{user_message}}

    <hr>
    date : {{date_time}}', 0),
    ('video_activation_email', 1, 0, '[{{website_title}}] - Your video has been activated', 'Hello {{user_username}},
    Your video has been reviewed and activated by one of our staff, thanks for uploading this video. You can view this video here.
    {{video_link}}

    Thanks
    {{website_title}} Team', 0),
    ('user_comment_email', 1, 0, '[{{website_title}}] {{sender_username}} made comment on your {{subject}}', '{{sender_username}} has commented on your {{object}}
    "{{user_message}}"

    <a href="{{comment_link}}">Read comment</a>

    {{website_title}} team', 0),
    ('user_reply_email', 1, 0, '[{{website_title}}] {{sender_username}} made reply on your comment', '{{sender_username}} has replied on your comment
    "{{user_message}}"

    <a href="{{comment_link}}">Read comment</a>

    {{website_title}} team', 0),
    ('video_subscription_email', 1, 0, '{{sender_username}} has uploaded new video on {{website_title}}', 'Hello {{user_username}}

    You have been notified by {{website_title}} that {{sender_username}} has uploaded new video

    Video Title : {{video_title}}
    Video Description : {{video_description}}


    <a href="{{video_link}}">
        <img src="{{video_thumb}}" border="0" height="90" width="120"><br>
        click here to watch this video</a>


    You are notified because you are subscribed to {{sender_username}}, you can manage your subscriptions by going to your account and click on manage subscriptions.
    {{website_title}}', 0),
    ('avcode_request_template', 1, 0, '[{website_title}] - Account activation code request', 'Hello {{user_username}},

    Your Activation Code is : {{avcode}}
    <a   href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">Click Here</a> To goto Activation Page

    Direct Activation
    ==========================================
    Click Here or Copy & Paste the following link in your browser
    {{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}

    if above given links are not working, please go here and activate it

    Email           : {{user_email}}
    Username        : {{user_username}}
    Activation code : {{avcode}}

    if above given is not working , please go here and activate it
    <a  href="{{baseurl}}activation.php">{{baseurl}}activation.php</a>

    ----------------
    Regards
    {{website_title}}', 0);


INSERT IGNORE INTO `{tbl_prefix}email_variable_link` (`id_email`, `id_email_variable`)
VALUES ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_thumb' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'photo_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'photo_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'photo_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'photo_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'photo_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_title' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'photo_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_thumb' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_title' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_thumb' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'total_items' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_type' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'collection_share_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'email_verify_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'avcode' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'pm_email_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'pm_email_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'subject' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'pm_email_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'pm_email_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'message_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'avcode_request_template' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'avcode' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'password_reset_request' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'reset_password_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'password_reset_details' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'password' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'password_reset_details' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'login_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_request_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_request_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'profile_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_request_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'request_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_confirmation_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_confirmation_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'profile_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'contact_form' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'subject' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'contact_form' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_activation_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'object' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_reply_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_reply_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'user_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_reply_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'comment_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_title' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_thumb' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1))