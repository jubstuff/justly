<?php

use Justly\DatabaseService;

require_once __DIR__.'/../vendor/autoload.php';

const CONFIG_VIEWS_DIR = __DIR__.'/../views';

DatabaseService::setDefaultPdoParameters([
    'sqlite:'.__DIR__.'/../data/justly.sqlite',
]);