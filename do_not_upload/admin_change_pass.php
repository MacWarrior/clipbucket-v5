<?php
/**
 * File used to change admin password manually
 * Usage : change username and password in from their default values
 * to your account username and your password, upload this file on your
 * root directory of clipbucket where index.php is found so e.g http://clipbucket.com/admin_change_pass.php
 * you will see a confirmation message that your account password has been changed.
 *
 * for help and support pelase visti forums.clip-bucket.com or report issues on code.google.com/p/clipbucket/issues
 * Notice: File is not used anymore
 */

include("includes/config.inc.php");
global $userquery, $db;

//Username of account you want to change password
$username = 'admin';

//Set password
$password = 'mynewpassword';

// -- DO NOT GO INSIDE DEEP RED PHP -- //

$user = $userquery->get_user_details($username);

if (!$user) {
    e("User does not exist");
} else {
    $pass = pass_code($password, $user['userid']);
    $db->update(tbl('users'), ['password'], [$pass], "username='$username'");
    e("Password for your account has been changed, please delete this file", "m");
}

display_it();

