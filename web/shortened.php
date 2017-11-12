<?php

use Justly\UrlController;

require __DIR__ . '/../src/bootstrap.php';

$controller = UrlController::create();

$controller->getShortenedUrl();