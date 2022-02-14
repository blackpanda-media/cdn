<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Handler;

use BPM\OwnCdn\Adapter\FileAdapter;
use BPM\OwnCdn\Configuration\SystemConfiguration;
use BPM\OwnCdn\Exception\ClientException;
use BPM\OwnCdn\Model\ResponseData;
use BPM\OwnCdn\Validator\RequestValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FileRetrieveHandler implements HandlerInterface
{
    public function __construct(
        private SystemConfiguration $systemConfiguration,
        private Client $client,
        private FileAdapter $fileAdapter,
        private RequestValidator $requestValidator,
    ) {
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $requestData = $this->requestValidator->validate($request);
        } catch (ClientException $exception) {
            return $response->withStatus($exception->getCode(), $exception->getMessage());
        }

        // check data is cached
        if ($this->systemConfiguration->cacheConfig()->enabled()) {
            $cachedFile = $this->fileAdapter->checkCachedFile($requestData->getHash());
            if ($cachedFile instanceof ResponseData) {
                foreach ($cachedFile->getHeaders() as $header => $value) {
                    $response->withHeader($header, $value);
                }
                $response->getBody()->write($cachedFile->getBody());

                return $response;
            }
        }

        // closed system and not white listed
        if (
            $this->systemConfiguration->isClose()
            && $this->systemConfiguration->isInWhitelist($requestData->getUri()) === false
        ) {
            return $response->withStatus(403, 'Its not allowed to load this file.');
        }

        try {
            $originalResponse = $this->client->get($requestData->getUri());
        } catch (GuzzleException $exception) {
            return $response->withStatus(504, $this->systemConfiguration->isDebug() ? $exception->getMessage() : '');
        }

        if ($this->systemConfiguration->cacheConfig()->enabled()) {
            $this->fileAdapter->saveResponse(
                $requestData->getHash(),
                $originalResponse,
                $this->systemConfiguration->cacheConfig()
            );
        }

        return $originalResponse;
    }
}
