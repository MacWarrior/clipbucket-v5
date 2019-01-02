<?php 


$db->Execute("INSERT INTO ".tbl('config')." (`configid`, `name`, `value`) VALUES
(1, 'elastic_server_ip', 'localhost');");

?>