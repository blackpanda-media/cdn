<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HandlerInterface
{
    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}
