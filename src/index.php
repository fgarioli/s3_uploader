<?php

use Fgarioli\S3Uploader\Uploader;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$baseDir = dirname(__DIR__);

require_once $baseDir . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$dotenv->load();

$name = "prod";
$date = (new DateTime())->format("Y-m-d");
$logger = new Logger($name);
$logger->pushHandler(new StreamHandler(dirname(__DIR__, 1) . "/logs/{$name}_{$date}.log"));

(new Uploader($_ENV['ACCESS_KEY'], $_ENV['SECRET_KEY'], $_ENV['BUCKET_REGION'], true, $logger))->upload(__DIR__ . '/files', $_ENV['BUCKET_NAME']);
