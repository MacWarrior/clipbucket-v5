<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    public function __construct()
    {
        // WIP migrations run without a numbered revision or version update.
    }

    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD COLUMN `password_reset_expires_at` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `avcode`', [], [
            'table'  => 'users',
            'column' => 'password_reset_expires_at'
        ]);

        self::query('UPDATE `{tbl_prefix}email` SET `content` = \'Hello <b>{{user_username}}</b>,
    <br/><br/>
    Thanks for registering on <a href="{{baseurl}}">{{website_title}}</a> !<br/>
    In order to verify your email address, please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
    <br/><br/>
    If somehow above link isn\'\'t working, please go to : <a href = "{{baseurl}}activation.php" >{{baseurl}}activation . php </a ><br />
    and use your activation code : <b >{{avcode}}</b >
    <br />Your activation code will expire in 15 minutes <br/><br/>
    Welcome aboard !\'
                           WHERE `code` =\'verify_account\'');
        self::query('UPDATE `{tbl_prefix}email` SET `content` =  \'Dear <b>{{user_username}}</b>,
    <br/><br/>
    You have requested a password reset, please follow the link in order to reset your password : <br/>
    <a href="{{reset_password_link}}">Reset my password</a>
    <hr/>
    <br/>
    If somehow above link isn\'\'t working, please go to : <a href="{{baseurl}}forgot.php?mode=reset_pass">{{baseurl}}forgot.php</a><br/>
    And use your activation code : <b>{{avcode}}</b>
    <br/>
    Your activation code will expire in 15 minutes
    <br/><br/>
    <div style="text-align:center;font-weight:bold;">
    If you have not requested a password reset, please ignore this message
    </div>
    <hr/>\'
                           WHERE `code` =\'password_reset_request\'');
        self::query('UPDATE `{tbl_prefix}email` SET `content` =  \'Hello <b>{{user_username}}</b>,
    <br/><br/>
    Please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
    <br/><br/>
    If somehow above link isn\'\'t working, please go to : <a href="{{baseurl}}activation.php">{{baseurl}}activation.php</a><br/>
    And use your activation code : <b>{{avcode}}</b>
    <br/>
    Your activation code will expire in 15 minutes
    <br/><br/>
    Welcome aboard !\'
                           WHERE `code` =\'avcode_request\'');

        self::query('UPDATE `{tbl_prefix}email` SET `content` = \'Hello <b>{{user_username}}</b>,
    <br/><br/>
    In order to verify your email address, please validate your account by <a href="{{baseurl}}email_confirm.php?mode=email_confirm&av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
    <br/><br/>
    If somehow above link isn\'\'t working, please go to : <a href = "{{baseurl}}email_confirm.php" >{{baseurl}}email_confirm.php </a ><br />
and use your activation code : <b >{{avcode}}</b >
<br />Your activation code will expire in 15 minutes <br/><br/>
Have a nice day !\'
                           WHERE `code` =\'verify_email\'');

    }
}
