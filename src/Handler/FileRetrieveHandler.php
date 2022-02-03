<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Handler;

use BPM\OwnCdn\Adapter\FileAdapter;
use BPM\OwnCdn\Configuration\SystemConfiguration;
use BPM\OwnCdn\Exception\ClientException;
use BPM\OwnCdn\Exception\DatabaseException;
use BPM\OwnCdn\Repository\FileRepository;
use BPM\OwnCdn\Validator\RequestValidator;
use Exception;
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
        private FileRepository $fileRepository,
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

        if ($this->systemConfiguration->isClose()) {
            try {
                if ($this->fileRepository->checkFileAllowed($hash) === false) {
                    return $response->withStatus(404);
                }
            } catch (DatabaseException $exception) {
                return $response->withStatus(500, $exception->getMessage());
            }
        }

        $response = $this->fileAdapter->openResponse($hash);

        if ($response instanceof ResponseInterface && $this->systemConfiguration->cacheConfig()->enabled()) {
            try {
                $this->fileRepository->updateTimestamp($uri);
            } catch (DatabaseException|Exception $exception) {
                return $response->withStatus(500, $exception->getMessage());
            }
            return $response;
        }

        try {
            $connectorResponse = $this->client->get($uri);
        } catch (GuzzleException $exception) {
            return $response->withStatus(500, $exception->getMessage());
        }

        if ($this->systemConfiguration->cacheConfig()->enabled()) {
            try {
                $this->fileRepository->createNew($uri);
            } catch (DatabaseException|Exception $exception) {
                return $response->withStatus(500, $exception->getMessage());
            }

            if ($this->fileAdapter->saveResponse($hash, $connectorResponse) === false) {
                return $response->withStatus(500, 'Cannot save response.');
            }
        }

        return $connectorResponse;
    }
}
