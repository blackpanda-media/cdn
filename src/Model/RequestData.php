<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Model;

class RequestData
{
    public function __construct(private string $hash, private string $uri)
    {
    }
}
