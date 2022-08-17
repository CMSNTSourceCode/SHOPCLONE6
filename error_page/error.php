<?php
    $code = $_SERVER['REDIRECT_STATUS'];
    $codes = array(
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        503 => 'Service Unavailable',
        502 => 'Bad Gateway',
        504 => 'Gateway Timeout',
        400 => 'Bad Request',
        401 => 'Unauthorized'
    );
    
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error <?php $code; ?></title>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="The most powerful Errors template">
  <meta name="keywords" content="Enter, your, keywords">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">
  <link href="error_page/css/css?family=Poppins:400,700" rel="stylesheet">
  <link rel="stylesheet" href="error_page/css/style.css">
</head>
<body>
  <main class="main">
    <div class="error"><?php $code; ?></div>
    <img src="error_page/imgs/image.png">
    <h2><?php $codes[$code]; ?></h2>
    <h6>Somthing went wrong, please<br>Try again later</h6>
    <a href="/" class="button">Homepage</a>
  
</main></body>
</html>