<?php
/*
    Plugin Name: Comment BBCode
    Description: SAMPLE PLUGIN FOR COMMENT AND DESCRIPTION MODIFICATION
    Author: Arslan Hassan
    ClipBucket Version: 2
    Version: 1.0
    Website: https://github.com/arslancb/clipbucket
*/

if (!function_exists('bb_to_html')) {
    function bb_to_html($comment)
    {

        //Replaceing Image Code
        $img_patter = '/\[img\](.*)\[\/img\]/';
        $img_replace = '<img src="$1" />';
        $coded_comment = preg_replace($img_patter, $img_replace, $comment);

        $bbcodes = [
            '/\[b\]/', '/\[i\]/', '/\[u\]/', '/\[quote\]/', '/\[url\](.*)\[\/url\]/',
            '/\[\/b\]/', '/\[\/i\]/', '/\[\/u\]/', '/\[\/quote\]/', '/\[url=(.*)\](.*)\[\/url\]/'
        ];
        $HTMLcodes = [
            '<strong>', '<em>', '<u>', '<blockquote>', '<a href="$1">$1</a>',
            '</strong>', '</em>', '</u>', '</blockquote>', '<a href="$1">$2</a>',
        ];

        $coded_comment = preg_replace($bbcodes, $HTMLcodes, $coded_comment);

        return $coded_comment;
    }
}

//Registering Action that will be applied while displaying comment and or description
register_action(['bb_to_html' => ['comment', 'description', 'pm_compose_box', 'private_message']]);

$hints = "<div style='font-family:tahoma; margin:0px 0x 5px 0px'><strong>*Following bbcodes can be used</strong><br />
<div style='padding-left:5px'>[b]for bold letters[/b]<br />
[i]for italic letters[/i]<br />
[u]for underline[/u]<br />
[quote]for quotations[/quote]<br />
[url]for link[/url] or [url=link]title[/url]</div></div>";
//Registerin Anchors , that will be displayed before compose boxes
register_anchor($hints, 'after_compose_box');
register_anchor($hints, 'after_reply_compose_box');
register_anchor($hints, 'after_desc_compose_box');
register_anchor($hints, 'after_pm_compose_box');
