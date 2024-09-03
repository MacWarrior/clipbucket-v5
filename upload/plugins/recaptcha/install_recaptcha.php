<?php
//Insert Recaptcha field in configurations
Clipbucket_db::getInstance()->insert(tbl("config"), ["name", "value"], ["reCaptcha_public_key", "6LcQI8ESAAAAALN1vYQovst9c6nlU52iHdqWExp8"]);
Clipbucket_db::getInstance()->insert(tbl("config"), ["name", "value"], ["reCaptcha_private_key", "6LcQI8ESAAAAALc_oz1xuNsBVRNx554CaJHjcoXt"]);
