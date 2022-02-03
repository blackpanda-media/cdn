<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Validator;

use BPM\OwnCdn\Exception\ClientException;
use BPM\OwnCdn\Model\RequestData;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class RequestValidator
{
    /**
     * @throws ClientException
     */
    public function validate(ServerRequestInterface $request): RequestData
    {
        $hash = RouteContext::fromRequest($request)->getRoute()?->getArgument('hash');
        if ($hash === null) {
            throw new ClientException('File to request is missing.', 404);
        }

        $uri = base64_decode($hash);
        if ($uri === false) {
            throw new ClientException('You can only send base64 encoded uris.', 404);
        }

        return new RequestData($hash, $uri);
    }
}
