<?php
class CBLogs
{
    /**
     * Function used to insert log
     * @param string $type , type of action
     * @param array $details_array , action details array
     * @throws Exception
     */
    function insert($type, $details_array)
    {
        $ip = Network::get_remote_ip();
        $ipv6 = $ipv4 = null;
        if(strlen($ip) > 15){
            $ipv6 = $ip;
        } else {
            $ipv4 = $ip;
        }

        $userid = getArrayValue($details_array, 'userid');
        if (!$userid) {
            $userid = userquery::getInstance()->udetails['userid'];
        }
        if (!is_numeric($userid)) {
            $userid = 0;
        }

        $username = getArrayValue($details_array, 'username');
        if (!$username) {
            $username = userquery::getInstance()->udetails['username'];
        }

        $useremail = getArrayValue($details_array, 'useremail');
        if (!$useremail) {
            $useremail = userquery::getInstance()->udetails['email'];
        }

        $userlevel = getArrayValue($details_array, 'userlevel');
        if (!$userlevel) {
            $userlevel = getArrayValue(userquery::getInstance()->udetails, 'level');
        }
        if (!is_numeric($userlevel)) {
            $userlevel = 0;
        }

        $action_obj_id = getArrayValue($details_array, 'action_obj_id');
        if (!is_numeric($action_obj_id)) {
            $action_obj_id = 0;
        }

        $action_done_id = getArrayValue($details_array, 'action_done_id');
        if (!is_numeric($action_done_id)) {
            $action_done_id = 0;
        }

        $success = getArrayValue($details_array, 'success');
        $details = getArrayValue($details_array, 'details');

        $fields = [
            'action_type',
            'action_username',
            'action_userid',
            'action_useremail',
            'date_added',
            'action_success',
            'action_details',
            'action_userlevel',
            'action_obj_id',
            'action_done_id'
        ];

        $values = [
            $type,
            $username,
            $userid,
            $useremail,
            NOW(),
            $success,
            $details,
            $userlevel,
            $action_obj_id,
            $action_done_id
        ];

        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.1' || ($version['version'] == '5.5.1' && $version['revision'] >= 153)) {
            $fields[] = 'action_ipv4';
            $values[] = $ipv4;
            $fields[] = 'action_ipv6';
            $values[] = $ipv6;
        } else {
            $fields[] = 'action_ip';
            $values[] = $ip;
        }

        Clipbucket_db::getInstance()->insert(tbl('action_log'), $fields, $values);
    }
}
