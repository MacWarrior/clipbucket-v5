<?php
Clipbucket_db::getInstance()->execute("INSERT INTO " . tbl('config') . " (`configid`, `name`, `value`) VALUES
(NULL, 'elastic_server_ip', 'localhost');");
