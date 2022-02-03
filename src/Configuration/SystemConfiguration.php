<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Configuration;

use BPM\OwnCdn\Constants\SystemMode;

class SystemConfiguration
{
    /**
     * @param string[] $whiteList
     * @param string[] $blackList
     */
    public function __construct(
        private string $mode,
        private CacheConfiguration $cacheConfiguration,
        private array $whiteList,
        private array $blackList,
    ) {
    }

    public function isOpen(): bool
    {
        return $this->mode === SystemMode::OPEN;
    }

    public function isClose(): bool
    {
        return $this->mode === SystemMode::CLOSE;
    }

    public function isInWhitelist(string $uri): bool
    {
        return array_filter(
            $this->whiteList,
            static fn (string $whiteListUri) => str_starts_with($whiteListUri, $uri),
        ) !== [];
    }

    public function isInBlacklist(string $uri): bool
    {
        return array_filter(
                $this->blackList,
                static fn (string $blackListUri) => str_starts_with($blackListUri, $uri),
            ) !== [];
    }

    public function cacheConfig(): CacheConfiguration
    {
        return $this->cacheConfiguration;
    }
}
