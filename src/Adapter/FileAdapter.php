<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Adapter;

use BPM\OwnCdn\Configuration\CacheConfiguration;
use BPM\OwnCdn\Model\ResponseData;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;

class FileAdapter
{
    public function saveResponse(
        string $hash,
        ResponseInterface $response,
        CacheConfiguration $cacheConfiguration
    ): void {
        $collectedHeaders = [];
        foreach ($response->getHeaders() as $name => $headers) {
            $collectedHeaders[$name] = reset($headers);
        }

        file_put_contents(
            CACHE_DIR . '/' . $hash . '.' . (new DateTimeImmutable())->add($cacheConfiguration->ttl())->format('U'),
            serialize(new ResponseData($collectedHeaders, $response->getBody()->getContents())),
        );
    }

    public function checkCachedFile(string $hash): ?ResponseData
    {
        $files = glob(CACHE_DIR . '/' . $hash . '.*');
        if ($files === false || $files === []) {
            return null;
        }

        $fileName = reset($files);

        $fileParts = explode('.', $fileName);
        if (DateTimeImmutable::createFromFormat('U', end($fileParts)) <= new DateTimeImmutable()) {
            unlink($fileName);
            return null;
        }

        $fileData = file_get_contents($fileName);
        if ($fileData === false) {
            return null;
        }

        $responseData = unserialize($fileData, ['allowed_classes' => [ResponseData::class]]);

        return $responseData instanceof ResponseData ? $responseData : null;
    }
}
