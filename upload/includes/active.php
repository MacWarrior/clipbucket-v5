<?php

global $Smarty;

function current_page($params)
{
    if (defined('PARENT_PAGE')) {
        $parent_page = PARENT_PAGE;
    } else {
        $parent_page = 'home';
    }

    $page = $params['page'];
    $class = getArrayValue($params, 'class');

    if ($class == '') {
        $class = 'selected';
    }

    if ($page == $parent_page) {
        return ' class="' . $class . '" ';
    }
    return false;
}

$Smarty->register_function('current_page', 'current_page');
