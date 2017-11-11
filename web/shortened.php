<?php

use Justly\UrlController;

require __DIR__ . '/../src/bootstrap.php';

$controller = new UrlController();

$controller->getShortenedUrl();