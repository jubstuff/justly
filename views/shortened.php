<?php
/**
 * @var $url \Justly\UrlEntity
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Justly: a really simple URL shortener</title>
</head>
<body>
<h1>Justly - <?=htmlentities($url->getShortenedUrl()) ?></h1>
<p>This url redirects to <?=htmlentities($url->getTargetUrl())?></p>
<h2>Create another URL:</h2>
<form action="/index.php" method="post">
    <label for="url">URL</label>
    <input type="text" name="url" id="url">
    <input type="submit" name="shorten" id="shorten" value="Shorten">
</form>
</body>
</html>