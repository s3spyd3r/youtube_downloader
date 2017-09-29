<?php

$response = array(
    'data' => null,
    'error' => null,
);

$isResponse = false;
$isError = false;
$isSuccessResponse = false;
$providerName = null;
$url = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $isResponse = true;
    require_once __DIR__ . '/YTDownloader.php';
	
    try 
	{
        if (!isset($_POST['url']) || !trim($_POST['url']))
            throw new Exception("Youtube url not set");
		
        $url = trim($_POST['url']);
        $yd = new YoutubeDownloader($url);
		
        $fullInfo = $yd->getFullInfo();
        $videoId = $fullInfo['video_id'];
		
        $response['data'] = array(
            'baseInfo' => $yd->getBaseInfo(),
            'downloadInfo' => $yd->getDownloadsInfo(),
        );
		
        $isSuccessResponse = true;
    } 
	catch (Exception $e) 
	{
        $isError = true;
        header('Bad request', true, 400);
        $response['error'] = $e->getMessage();
    }
}

?>