<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Configuration;

use DateInterval;

class CacheConfiguration
{
    public function __construct(private bool $enabled, private DateInterval $ttl)
    {
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function ttl(): DateInterval
    {
        return $this->ttl;
    }
}
