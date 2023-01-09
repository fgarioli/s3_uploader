<?php

namespace Fgarioli\S3Uploader;

use Aws\Credentials\Credentials;
use Aws\Handler\GuzzleV6\GuzzleHandler;
use Aws\S3\S3Client;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

class Uploader
{
    private S3Client $s3;

    public function __construct(string $accessKey, string $secretKey, string $bucketRegion, bool $debug = false, LoggerInterface $logger = null)
    {
        $options = [
            'credentials' => new Credentials($accessKey, $secretKey),
            'region' => $bucketRegion,
            'version' => 'latest',
            'http'    => [
                'connect_timeout' => 5
            ],
            'debug' => $debug
        ];

        if (null !== $logger) {
            $guzzle_stack = HandlerStack::create();
            $guzzle_stack->push(Middleware::log(
                $logger,
                new MessageFormatter(MessageFormatter::CLF)
            ));
            $handler = new GuzzleHandler(new Client(['handler' => $guzzle_stack]));
            $options['http_handler'] = $handler;
        }

        $this->s3 = new S3Client($options);
    }

    public function upload(string $directory, string $bucketName): void
    {
        foreach (scandir($directory) as $file) {
            if (in_array($file, ['.', '..', '.gitkeep'])) {
                continue;
            }

            $this->s3->putObject([
                'Bucket' => $bucketName,
                'Key' => $file,
                'SourceFile' => $directory . '/' . $file
            ]);
        }
    }

    public function exists(string $bucketName, string $key): bool
    {
        return $this->s3->doesObjectExist($bucketName, $key);
    }
}
