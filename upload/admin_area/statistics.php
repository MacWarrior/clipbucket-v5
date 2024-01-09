<?php
/* 
 *******************************************************************
 | Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.	
 | @ Author : ArslanHassan											
 | @ Software : ClipBucket , © PHPBucket.com						
 *******************************************************************
*/

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
$userquery->admin_login_check();
$userquery->login_check('web_config_access');


template_files('under_development.html');
display_it();
