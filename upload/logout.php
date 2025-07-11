<?php
const THIS_PAGE = 'logout';
require_once 'includes/config.inc.php';

userquery::getInstance()->logout();
redirect_to(DirPath::getUrl('root'));
