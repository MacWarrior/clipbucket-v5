<?php
//Insert Recaptcha field in configurations
Clipbucket_db::getInstance()->insert(tbl("config"), ["name", "value"], ["recaptcha_v2_site_key", ""]);
Clipbucket_db::getInstance()->insert(tbl("config"), ["name", "value"], ["recaptcha_v2_secret_key", ""]);
