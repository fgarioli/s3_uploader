<?php

$baseDir = dirname(__DIR__);

require_once $baseDir . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$dotenv->load();

$s3 = new Aws\S3\S3Client([
    'credentials' => new Aws\Credentials\Credentials($_ENV['ACCESS_KEY'], $_ENV['SECRET_KEY']),
    'region' => $_ENV['BUCKET_REGION'],
    'version' => 'latest',
    'http'    => [
        'connect_timeout' => 5
    ],
]);

foreach (scandir(__DIR__ . '/files') as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $response = $s3->putObject([
        'Bucket' => $_ENV['BUCKET_NAME'],
        'Key' => $file,
        'SourceFile' => __DIR__ . '/files/' . $file
    ]);
}
