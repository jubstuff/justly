<?php
/**
 * @var $url \Justly\UrlEntity
 * @var $errorMsg string
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
<h1>Justly - A really simple URL shortener</h1>
<form action="/index.php" method="post">

    <?php if ($errorMsg ?? false): ?>
        <div class="errors"><?= htmlentities($errorMsg) ?></div>
    <?php endif; ?>

    <label for="url">URL</label>
    <input type="text" name="url" id="url" value="<?= isset($url) ? htmlentities($url->getTargetUrl()) : '' ?>">
    <input type="submit" name="shorten" id="shorten" value="shorten">
</form>

<?php if (isset($mostRecentUrls) && is_array($mostRecentUrls) && count($mostRecentUrls)): ?>
    <h2>Most Recent URLs</h2>
    <ul>
        <?php foreach ($mostRecentUrls as $url):
            $shortenedUrl = $url->getShortenedUrl();
            $host = $_SERVER['HTTP_HOST'];
            ?>
            <li>
                <a href="/<?= htmlentities($shortenedUrl) ?>">
                    http://<?= htmlentities($host) ?>/<?= htmlentities($shortenedUrl) ?>
                </a>
                - <a href="shortened.php?url=<?= htmlentities($shortenedUrl) ?>">stats</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>