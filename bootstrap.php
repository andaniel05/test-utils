<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/thenlabs/pyramidal-tests/src/DSL/PHPUnit.php'; // DSL

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
