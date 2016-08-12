<?php
/*
HomeWork: 3
Task: 4
Author: Korsic
 */

/*С помощью CURL запросить данные по адресу: https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json

Вывести title и page_id

*/

function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$wiki = file_get_contents_curl("https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json");
preg_match('#("title":".*?)\"#i', $wiki, $result);
echo $result[0] . "<br />";

preg_match('#("pageid":)[\d]+#i', $wiki, $result);
echo $result[0];