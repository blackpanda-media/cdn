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

    public function __serialize(): array
    {
        return ['headers' => $this->headers, 'body' => $this->body];
    }

    public function __unserialize(array $data): void
    {
        $this->headers = $data['headers'];
        $this->body = $data['body'];
    }
}
