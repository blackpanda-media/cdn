<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Configuration;

class CacheConfiguration
{
    public function __construct(private bool $enabled, private string $ttl)
    {
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function ttl(): string
    {
        return $this->ttl;
    }
}
