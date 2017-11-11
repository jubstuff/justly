<?php

require_once __DIR__ . '/../src/bootstrap.php';

$controller = new \Justly\UrlController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->postIndex();
} else {
    $controller->getIndex();
}

