<?php
//Insert Recaptcha field in configurations
Clipbucket_db::getInstance()->delete(tbl("config"), ["name"], ["reCaptcha_public_key"]);
Clipbucket_db::getInstance()->delete(tbl("config"), ["name"], ["reCaptcha_private_key"]);
