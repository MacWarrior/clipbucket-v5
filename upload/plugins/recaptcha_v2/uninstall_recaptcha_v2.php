<?php
//Insert Recaptcha field in configurations
Clipbucket_db::getInstance()->delete(tbl("config"), ["name"], ["recaptcha_v2_site_key"]);
Clipbucket_db::getInstance()->delete(tbl("config"), ["name"], ["recaptcha_v2_secret_key"]);
