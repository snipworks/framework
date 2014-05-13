<?php

/**
 * If haystack ends with needle
 * @param $needle
 * @param $haystack
 * @return bool
 */
function endsWith($needle, $haystack)
{
    $needle = strrev($needle);
    $haystack = strrev($haystack);
    return (strpos($haystack, $needle) === 0);
}

/**
 * Link CSS Stylesheet
 * @param $filename
 */
function use_css($filename)
{
    if (strpos($filename, '/') !== 0) {
        $filename = '/css/' . $filename;
    }
    echo "<link rel='stylesheet' href='{$filename}'/>" . PHP_EOL;
}

/**
 * Use Javascript file
 * @param $filename
 */
function use_js($filename)
{
    if (strpos($filename, '/') !== 0) {
        $filename = '/js/' . $filename;
    }
    echo "<script rel='text/javascript' src='{$filename}'></script>" . PHP_EOL;
}

/**
 * Include helper file
 * @param $filename
 */
function use_helper($filename)
{
    $path = ROOT_DIR . '/lib/helpers/' . $filename;
    if (file_exists($path)) {
        require_once($path);
    }
}

/**
 * Convert string to camel case
 * @param $str
 * @param bool $capital_first_char
 * @return string
 */
function str_camelcase($str, $capital_first_char = false)
{
    $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    return $capital_first_char ? $str : lcfirst($str);
}

/**
 * Convert string to snake case
 * @param $str
 * @return string
 */
function str_underscore($str)
{
    return strtolower(preg_replace('/(?<=\\w)([A-Z]+)/', '_\\1', $str));
}

/**
 * Create url link
 * @param $url
 * @param array $params
 * @return string
 */
function url($url, $params = array()) {
    $url = (strpos($url, '/') === 0) ? $url : Request::getFrontController() . '/' . $url;
    if (!$params) {
        return $url;
    }

    $query = http_build_query($params);
    return $url . ((strpos($url, '?') !== false) ? '&' : '?') . $query;
}