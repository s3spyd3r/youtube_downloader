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

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <title>Simple Youtube Video Downloader</title>
</head>
<body>
	<div class="container">
		<h1>Simple Youtube Video Downloader</h1>
	</div>
</body>
<script src="jquery/jquery-3.2.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</html>