<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$s3 = new Aws\S3\S3Client([
    'key'    => $_ENV['ACCESS_KEY'],
    'secret' => $_ENV['SECRET_KEY']
]);

foreach (scandir(__DIR__ . '/files') as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $response = $s3->putObject([
        'Bucket' => $_ENV['BUCKET'],
        'Key' => $file,
        'SourceFile' => __DIR__ . '/files/' . $file
    ]);
}
