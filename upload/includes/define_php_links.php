<?php
function SEO($text, $slash = false)
{
    $text = preg_replace('/ \&\#?[(0-9a-zA-Z){4}]+\;/', '', $text);
    $text = remove_accents($text);

    $text = rus2translit($text);

    $entities_match = ['&quot;', '!', '@', '#', '%', '^', '&', '*', '_', '(', ')', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', '"', ',', '.', '/', '*', '+', '~', '`', '=', "'"];
    $entities_replace = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
    $clean_text = str_replace($entities_match, $entities_replace, $text);
    $clean_text = trim($clean_text);
    $clean_text = preg_replace('/ /', '-', $clean_text);
    if ($clean_text != '') {
        $slash = ($slash) ? '/' : null;
    }

    $clean_text = preg_replace('/\-{2,10}/', '-', $clean_text);

    return $slash . $clean_text;
}	
