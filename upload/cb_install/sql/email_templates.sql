INSERT INTO `{tbl_prefix}email_variable` (code, type, language_key) VALUES
    ('email_content','template', 'email_variable_content'),
    ('website_title','global', 'email_variable_website_title'),
    ('user_username','global', 'email_variable_user_username'),
    ('user_email','global', 'email_variable_user_email'),
    ('user_avatar','global', 'email_variable_user_avatar'),
    ('date_year','global', 'email_variable_date_year'),
    ('baseurl','global', 'email_variable_baseurl'),
    ('date_time','global', 'email_variable_date_time'),
    ('login_link','global', 'email_variable_login_link'),
    ('logo_url','global', 'email_variable_logo_url'),
    ('favicon_url','global', 'email_variable_favicon_url'),
    ('video_link','email', 'email_variable_video_link'),
    ('video_title','email', 'email_variable_video_title'),
    ('video_thumb','email', 'email_variable_video_thumb'),
    ('video_description','email', 'email_variable_video_description'),
    ('sender_message','email', 'email_variable_sender_message'),
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
    ('object','email', 'email_variable_object'),
    ('mfa_code','email', 'email_variable_mfa_code');

INSERT INTO `{tbl_prefix}email_template` (`code`, `is_default`, `is_deletable`, `content`, `disabled`) VALUES
    ('main', TRUE, FALSE, '<!DOCTYPE html>\\r\\n<html>\\r\\n<body style=\\\"margin:0; padding:0; background-color:#EEEEEE; font-family:\\\'Open Sans\\\', sans-serif;\\\">\\r\\n  <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"border-collapse:collapse; min-width:320px; font-family:\\\'Open Sans\\\', sans-serif;\\\">\\r\\n    <tr>\\r\\n      <td style=\\\"padding:0; margin:0;\\\">\\r\\n\\r\\n        <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"#0080B4\\\" style=\\\"background-color:#0080B4;\\\">\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\" style=\\\"padding-top:20px; padding-bottom:10px;\\\">\\r\\n              <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"background-color:#FFFFFF; border-radius:10px;\\\">\\r\\n                <tr>\\r\\n                  <td align=\\\"center\\\" style=\\\"padding:5px;\\\">\\r\\n                    <a href=\\\"{{baseurl}}\\\">\\r\\n                      <img src=\\\"{{logo_url}}\\\" alt=\\\"{{website_title}}\\\" title=\\\"{{website_title}}\\\" style=\\\"border-radius:10px; display:block; max-width:100%; height:auto;\\\">\\r\\n                    </a>\\r\\n                  </td>\\r\\n                </tr>\\r\\n              </table>\\r\\n            </td>\\r\\n          </tr>\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\" style=\\\"color:white; font-size:22px; font-family:\\\'Open Sans\\\', sans-serif; padding-bottom:40px;\\\">\\r\\n              {{website_title}}\\r\\n            </td>\\r\\n          </tr>\\r\\n        </table>\\r\\n\\r\\n        <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"#EEEEEE\\\" style=\\\"background-color:#EEEEEE;\\\">\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\">\\r\\n              <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:90%; max-width:90%; background-color:#FFFFFF; border-radius:10px; min-width:320px;min-height:100px;margin-top:-20px;\\\">\\r\\n                <tr>\\r\\n                  <td style=\\\"padding:20px; font-family:\\\'Open Sans\\\', sans-serif; font-size:13px; color:#000000; min-height:100px;\\\">\\r\\n                    {{email_content}}\\r\\n                  </td>\\r\\n                </tr>\\r\\n              </table>\\r\\n            </td>\\r\\n          </tr>\\r\\n\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\" style=\\\"padding-bottom:20px;\\\">\\r\\n              <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:90%; max-width:90%; background-color:#0080B4; border-radius:10px; margin-top:20px; min-width:320px;\\\">\\r\\n                <tr>\\r\\n                  <td style=\\\"padding:10px;\\\">\\r\\n                    <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">\\r\\n                      <tr>\\r\\n                        <td width=\\\"60\\\" align=\\\"left\\\" valign=\\\"middle\\\">\\r\\n                          <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"background-color:#FFFFFF; border-radius:10px;\\\">\\r\\n                            <tr>\\r\\n                              <td align=\\\"center\\\" style=\\\"padding:0;\\\">\\r\\n                                <a href=\\\"{{baseurl}}\\\">\\r\\n                                  <img\\r\\n                                    src=\\\"{{favicon_url}}\\\"\\r\\n                                    alt=\\\"{{website_title}}\\\"\\r\\n                                    title=\\\"{{website_title}}\\\"\\r\\n                                    width=\\\"50\\\"\\r\\n                                    height=\\\"50\\\"\\r\\n                                    style=\\\"width:50px; height:50px; border-radius:10px; display:block;\\\">\\r\\n                                </a>\\r\\n                              </td>\\r\\n                            </tr>\\r\\n                          </table>\\r\\n                        </td>\\r\\n                        <td align=\\\"center\\\" valign=\\\"middle\\\" style=\\\"font-family:\\\'Open Sans\\\', sans-serif; font-size:14px; color:#FFFFFF;\\\">\\r\\n                          &copy;ClipBucketV5, maintained by <a href=\\\"https://oxygenz.fr\\\" style=\\\"color:#FFFFFF; text-decoration:none;\\\">Oxygenz</a>\\r\\n                        </td>\\r\\n                      </tr>\\r\\n                    </table>\\r\\n                  </td>\\r\\n                </tr>\\r\\n              </table>\\r\\n            </td>\\r\\n          </tr>\\r\\n\\r\\n        </table>\\r\\n\\r\\n      </td>\\r\\n    </tr>\\r\\n  </table>\\r\\n</body>\\r\\n</html>\\r\\n', FALSE);

INSERT INTO `{tbl_prefix}email` (`code`, `id_email_template`, `is_deletable`, `title`, `content`, `disabled`) VALUES
    ('share_video', 1, 0, '[{{website_title}}] {{sender_username}} wants to share a video with you', '<b>{{sender_username}}</b> wants to share a video with you :

    <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
        <a href="{{video_link}}">
            <img src="{{video_thumb}}" title="{{video_title}}" alt="Video thumb"><br/>
            {{video_title}}
        </a>
    </div>

    <div style="margin-bottom:10px;">
        <b>Video Description</b> : <br/>
        {{video_description}}
    </div>

    <div style="margin-bottom:10px;">
        <b>Personal Message</b> : <br/>
        {{sender_message}}
    </div>', 0),
    ('share_photo', 1, 0, '[{{website_title}}] {{sender_username}} wants to share a photo with you'
    , '<b>{{sender_username}}</b> wants to share a photo with you :

    <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
        <a href="{{photo_link}}">
            <img src="{{photo_thumb}}" title="{{photo_title}}" alt="Photo thumb"><br/>
            {{photo_title}}
        </a>
    </div>

    <div style="margin-bottom:10px;">
        <b>Photo Description</b> : <br/>
        {{photo_description}}
    </div>

    <div style="margin-bottom:10px;">
        <b>Personal Message</b> : <br/>
        {{sender_message}}
    </div>', 0),
    ('share_collection', 1, 0, '[{{website_title}}] {{sender_username}} wants to share a collection with you', '<b>{{sender_username}}</b> wants to share a {{collection_type}} collection with you :

    <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
        <a href="{{collection_link}}">
            <img src="{{collection_thumb}}" title="{{collection_title}}" alt="Collection thumb"><br/>
            {{collection_title}}
        </a>
    </div>

    <div style="margin-bottom:10px;">
        <b>Collection Description</b> : <br/>
        {{collection_description}}
    </div>

    <div style="margin-bottom:10px;">
        <b>Personal Message</b> : <br/>
        {{sender_message}}
    </div>', 0),
    ('verify_account', 1, 0, '[{{website_title}}] Email address verification', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    Thanks for registering on <a href="{{baseurl}}">{{website_title}}</a> !<br/>
    In order to verify your email address, please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
    <br/><br/>
    If somehow above link isn\'t working, please go to : <a href="{{baseurl}}activation.php">{{baseurl}}activation.php</a><br/>
    And use your activation code : <b>{{avcode}}</b>
    <br/><br/>
    Welcome aboard !', 0),
    ('private_message', 1, 0, '[{{website_title}}] {{sender_username}} has sent you a private message', 'Hello {{user_username}},
    <br/><br/>
    <b>{{sender_username}}</b> has sent you a private message :
    <hr/>
    Title : <i>{{subject}}</i><br/>
    "{{sender_message}}"
    <hr/>
    Click here to view your inbox <a href="{{message_link}}">Inbox</a>', 0),
    ('welcome_message', 1, 0, '[{{website_title}}] Welcome onboard !', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    Welcome to <a href="{{baseurl}}">{{website_title}}</a> !', 0),
    ('password_reset_request', 1, 0, '[{{website_title}}] Password reset', 'Dear <b>{{user_username}}</b>,
    <br/><br/>
    You have requested a password reset, please follow the link in order to reset your password : <br/>
    <a href="{{reset_password_link}}">Reset my password</a>
    <hr/>
    <br/><br/>
    If somehow above link isn''t working, please go to : <a href="{{baseurl}}forgot.php?mode=reset_pass">{{baseurl}}forgot.php</a><br/>
    And use your activation code : <b>{{avcode}}</b>
    <br/><br/>
    <div style="text-align:center;font-weight:bold;">
    If you have not requested a password reset, please ignore this message
    </div>
    <hr/>', 0),
    ('forgot_username_request', 1, 0, '[{{website_title}}] Your username', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    It seems you forgot your username ; here it is : <b>{{user_username}}</b>.', 0),
    ('friend_request', 1, 0, '[{{website_title}}] Friend request from {{sender_username}}', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    <a href="{{profile_link}}"><b>{{sender_username}}</b></a> sent you a friend request.<br/>
    <hr/>
    <div style="text-align:center;">
    <a href="{{profile_link}}">Click here to view his profile</a><br/><br/>
    <a href="{{request_link}}"> Click here to respond to friend request</a>
    </div>
    <hr/>', 0),
    ('friend_confirmation', 1, 0, '[{{website_title}}] Friend request confirmation', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    <a href="{{profile_link}}" title="{{sender_username}}">{{sender_username}}</a> confirmed your friend invitation !<br/>
    <hr/>
    <div style="text-align:center;">
    <a href="{{profile_link}}">View {{sender_username}} profile</a>
    </div>
    <hr/>', 0),
    ('contact_form', 1, 0, '[{{website_title}}] Contact form', '<b>Name</b> : {{sender_username}}<br/>
    <b>Email</b> : {{sender_email}}<br/>
    <b>Reason</b> : {{subject}}
    <hr/>
    <b>Message</b> :<br/>
    {{sender_message}}
    <hr/>', 0),
    ('video_activation', 1, 0, '[{{website_title}}] Your video has been activated', 'Hello <b>{{user_username}}</b>,
    <br/><br/>

    Your video <a href="{{video_link}}" title={{video_title}}>{{video_title}}</a> has been reviewed and activated by one of our staff, thanks for uploading this video.<br/>
    Watch it <a href="{{video_link}}"><b>here</b></a>.', 0),
    ('user_comment', 1, 0, '[{{website_title}}] {{sender_username}} made comment on your {{subject}}', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    {{sender_username}} has commented on your {{object}} : <br/>
    "{{sender_message}}"
    <hr/>
    <div style="text-align:center;">
    <a href="{{comment_link}}">View comment</a>
    </div>
    <hr/>', 0),
    ('user_reply', 1, 0, '[{{website_title}}] {{sender_username}} replied on your comment', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    {{sender_username}} has replied on your comment : <br/>
    "{{sender_message}}"
    <hr/>
    <div style="text-align:center;">
    <a href="{{comment_link}}">View comment</a>
    </div>
    <hr/>', 0),
    ('video_subscription', 1, 0, '[{{website_title}}] {{sender_username}} just uploaded a new video', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    {{sender_username}} just uploaded new video !
    <br/><br/>
    <div style="text-align:center;">
    <a href="{{video_link}}" title="{{video_title}}">
            <img src="{{video_thumb}}" border="0" height="90" width="120"><br/>
             {{video_title}}
    </a>
    </div>
    <br/>
    Video Description : {{video_description}}

    <hr/>
    <i>You are notified because you subscribed to {{sender_username}}, you can manage your subscriptions by going to your account and click on manage subscriptions.</i>
    <hr/>', 0),
    ('avcode_request', 1, 0, '[{{website_title}}] Account activation', 'Hello <b>{{user_username}}</b>,
    <br/><br/>
    Please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
    <br/><br/>
    If somehow above link isn''t working, please go to : <a href="{{baseurl}}activation.php">{{baseurl}}activation.php</a><br/>
    And use your activation code : <b>{{avcode}}</b>
    <br/><br/>
    Welcome aboard !', 0),
    ('verify_email',1,0,'[{{website_title}}] Email address verification','Hello <b>{{user_username}}</b>,
    <br/><br/>
    In order to verify your email address, please validate your account by <a href="{{baseurl}}email_confirm.php?mode=email_confirm&av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
    <br/><br/>
    If somehow above link isn\'t working, please go to : <a href="{{baseurl}}email_confirm.php">{{baseurl}}email_confirm.php</a><br/>
And use your activation code : <b>{{avcode}}</b>
<br/><br/>
Have a nice day !', 0),
    ('mfa_code',1,0,'[{{website_title}}] Authentification','Hello <b>{{user_username}}</b>,
    <br/><br/>
    Here is your authentification code : <b>{{mfa_code}}</b>

    <br/><br/>
    Have a nice day !', 0);


INSERT IGNORE INTO `{tbl_prefix}email_variable_link` (`id_email`, `id_email_variable`)
VALUES ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_thumb' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_video' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_photo' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_photo' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_photo' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_photo' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_photo' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_title' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_photo' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'photo_thumb' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_title' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_thumb' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'total_items' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_type' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'collection_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'share_collection' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'verify_account' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'avcode' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'private_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'private_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'subject' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'private_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'private_message' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'message_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'avcode_request' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'avcode' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'password_reset_request' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'reset_password_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'password_reset_details' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'password' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'password_reset_details' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'login_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_request' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_request' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'profile_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_request' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'request_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_confirmation' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'friend_confirmation' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'profile_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'contact_form' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'subject' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'contact_form' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'contact_form' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'contact_form' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_email' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_activation' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_activation' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_title' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'object' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_comment' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_reply' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_reply' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_message' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'user_reply' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'comment_link' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_title' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_description' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_link' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'video_thumb' LIMIT 1)),
       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'video_subscription' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'sender_username' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'verify_email' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'avcode' LIMIT 1)),

       ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = 'mfa_code' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = 'mfa_code' LIMIT 1));
