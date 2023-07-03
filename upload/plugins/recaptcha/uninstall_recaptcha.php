<?php
//Insert Recaptcha field in configurations
$db->delete(tbl("config"), ["name"], ["reCaptcha_public_key"]);
$db->delete(tbl("config"), ["name"], ["reCaptcha_private_key"]);
