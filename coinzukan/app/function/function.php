<?php

/**
 *  Crawl
 * Returns a json
 *
 * @Param url
 */
function crawlUrl($url){
    static $ch = null;
    if (is_null($ch)) {
        $ch = curl_init();
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $res = curl_exec($ch);
    return json_decode($res, true);
}
