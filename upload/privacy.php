<?php
require 'includes/config.inc.php';
$pages->page_redir();
subtitle('privacy');
Template('header.html');
Template('message.html');
Template('privacy.html');
Template('footer.html');
