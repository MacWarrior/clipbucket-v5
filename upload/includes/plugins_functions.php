<?php

/**
 * Function used to modify description, if there is any plugin installed
 *
 * @param : description
 *
 * @return string
 */
function description($description): string
{
    //Getting List of comment functions
    $func_list = ClipBucket::getInstance()->getFunctionList('description');
    //Applying Function
    if (is_array($func_list) && count($func_list) > 0) {
        foreach ($func_list as $func) {
            $description = $func($description);
        }
    }
    return nl2br($description);
}

/**
 * Function used to modify title of video , channel or any object except website,
 * if there is any plugin installed
 *
 * @param : title
 *
 * @return string
 */
function title($title): string
{
    //Getting List of comment functions
    $func_list = ClipBucket::getInstance()->getFunctionList('title');
    //Applying Function
    if (is_array($func_list) && count($func_list) > 0) {
        foreach ($func_list as $func) {
            $title = $func($title);
        }
    }
    return $title ?? '';
}

/**
 * Function used to display Private Message
 *
 * @param $array
 */
function private_message($array)
{
    global $cbpm;
    $array = $array['pm'];
    $message = $array['message_content'];
    $func_list = ClipBucket::getInstance()->getFunctionList('private_message');

    //Applying Function
    if (is_array($func_list) && count($func_list) > 0) {
        foreach ($func_list as $func) {
            if (function_exists($func)) {
                $message = $func($message);
            }
        }
    }
    echo display_clean($message);
    $cbpm->parse_attachments($array['message_attachments']);
}

/**
 * Function used to turn tags into links
 *
 * @param        $input
 * @param        $type
 * @param string $sep
 * @param string $class
 *
 * @return string
 */
function tags($input, $type, $sep = ', ', $class = ''): string
{
    //Exploding using comma
    $tags = explode(',', $input);
    $count = 1;
    $total = count($tags);
    $new_tags = '';
    foreach ($tags as $tag) {
        $params = ['name' => 'tag', 'tag' => trim($tag), 'type' => $type];
        $new_tags .= '<a href="' . cblink($params) . '" class="' . $class . '">' . $tag . '</a>';
        if ($count < $total) {
            $new_tags .= $sep;
        }
        $count++;
    }

    return $new_tags;
}

/**
 * Function used to turn db category into links
 *
 * @param        $input
 * @param        $type
 * @param string $sep
 * @param null $object_name
 *
 * @return string
 * @throws Exception
 */
function categories($input, $type, $sep = ', ', $object_name = null): string
{
    preg_match_all('/#([0-9]+)#/', $input, $m);
    $cat_array = [$m[1]];
    $cat_array = $cat_array[0];

    $count = 1;
    $total = count($cat_array);
    $cats = '';
    foreach ($cat_array as $cat) {
        $cat_details = Category::getInstance()->getById($cat);

        $cats .= '<a href="' . category_link($cat_details, $type) . '">' . display_clean($cat_details['category_name']) . '</a>';
        if ($count < $total) {
            $cats .= $sep;
        }
        $count++;
    }
    return $cats;
}

/**
 * Function used to display page
 *
 * @param $content
 *
 * @return string
 */
function page($content): string
{
    //Getting List of comment functions
    $func_list = ClipBucket::getInstance()->getFunctionList('page');
    //Applying Function
    if (is_array($func_list) && count($func_list) > 0) {
        foreach ($func_list as $func) {
            $content = $func($content);
        }
    }
    return $content;
}
