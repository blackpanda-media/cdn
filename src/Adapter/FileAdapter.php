<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Adapter;

use Psr\Http\Message\ResponseInterface;

class FileAdapter
{
    public function openResponse(string $hash): ?ResponseInterface
    {
        $fullPath = CACHE_DIR . '/' . $hash;
        if (file_exists($fullPath) === false) {
            return null;
        }

        $fileContent = file_get_contents($fullPath);

        if ($fileContent === false) {
            return null;
        }

        return unserialize($fileContent, [ResponseInterface::class]);
    }

    public function saveResponse(string $hash, ResponseInterface $response): bool
    {
        return file_put_contents(CACHE_DIR . '/' . $hash, serialize($response)) !== false;
    }
}
