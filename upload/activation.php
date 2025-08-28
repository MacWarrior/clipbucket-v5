<?php
const THIS_PAGE = 'activation';
const PARENT_PAGE = 'signup';

require 'includes/config.inc.php';

if( User::getInstance()->isUserConnected() ){
    redirect_to(DirPath::getUrl('root'));
}

if( !empty($_GET['av_username']) && !empty($_GET['avcode']) ){
    User::confirmAccount($_GET['av_username'], $_GET['avcode']);
}

template_files('pages/user_activation.html');
display_it();
