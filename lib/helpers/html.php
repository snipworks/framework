<?php

/**
 * Create html link
 * @param $url
 * @param null $name
 * @return string
 */
function href($url, $name = null)
{
    return '<a href=\'' . $url . '\'>' . ((!$name) ? $url : $name) . '</a>';
}