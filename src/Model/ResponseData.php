<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Model;

class ResponseData
{
    public function __construct(private array $headers, private string $body)
    {
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
