<?php

declare(strict_types=1);

namespace Fgarioli\S3Uploader\Tests;

use DateTime;
use Fgarioli\S3Uploader\Uploader;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    public function testExists()
    {
        $name = strtolower(basename(str_replace('\\', '/', str_replace("Test", "", get_called_class()))));
        $date = (new DateTime())->format("Y-m-d");
        $logger = new Logger($name);
        $logger->pushHandler(new StreamHandler(dirname(__DIR__, 1) . "/logs/{$name}_{$date}.log"));

        $uploader = new Uploader($_ENV['ACCESS_KEY'], $_ENV['SECRET_KEY'], $_ENV['BUCKET_REGION'], false, $logger);
        $uploader->exists($_ENV['BUCKET_NAME'], 'test.txt');
        // $uploader->upload(dirname(__DIR__) . '/src/files', $_ENV['BUCKET_NAME']);

        $this->assertTrue(true);
    }
}
