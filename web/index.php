<?php

use Justly\UrlController;

require_once __DIR__.'/../src/bootstrap.php';

$controller = UrlController::create();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->postIndex();
} else {
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    if (preg_match('#^/([^/]+)$#', $urlParts['path'], $matches)) {
        $controller->redirectUrl($matches[1]);
    } else {
        $controller->getIndex();

    }
}

