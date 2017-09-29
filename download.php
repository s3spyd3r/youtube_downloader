<?php

set_time_limit(0);
require './YTDownloader.php';

if (!isset($_GET['id'])) 
{
    header('Bad request', true, 400);
    echo "id paramameter is required";
    die();
}

$yd = new YoutubeDownloader('https://www.youtube.com/watch?v=' . $_GET['id']);

if (!isset($_GET['itag'])) 
{
    $info = $yd->getFullInfo();
    $itag = $info['url_encoded_fmt_stream_map'][0]['itag'];
} 
else 
{
    $itag = $_GET['itag'];
}

$yd->downloadForItag($itag);
