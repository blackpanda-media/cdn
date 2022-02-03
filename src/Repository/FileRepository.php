<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Repository;

use BPM\OwnCdn\Adapter\SQLiteAdapter;
use BPM\OwnCdn\Configuration\SystemConfiguration;
use BPM\OwnCdn\Exception\DatabaseException;
use DateInterval;
use DateTimeImmutable;
use Exception;

class FileRepository
{
    private const TABLE_NAME = 'file';

    public function __construct(private SQLiteAdapter $adapter, private SystemConfiguration $systemConfiguration)
    {
    }

    /**
     * @throws DatabaseException
     */
    public function checkFileAllowed(string $uri): bool
    {
        return $this->adapter->fetchOne(self::TABLE_NAME, 'uri', $uri) !== [];
    }

    /**
     * @throws DatabaseException
     * @throws Exception
     */
    public function updateTimestamp(string $uri): void
    {
        $this->adapter->update(
            self::TABLE_NAME,
            'uri',
            $uri,
            [
                'cache-expire' => (new DateTimeImmutable())
                    ->add(new DateInterval('P' . $this->systemConfiguration->cacheConfig()->ttl()))
                    ->format('Y-m-d H:i:s')
            ],
        );
    }

    /**
     * @throws DatabaseException
     * @throws Exception
     */
    public function createNew(string $uri): void
    {
        $this->adapter->insert(
            self::TABLE_NAME,
            [
                'uri' => $uri,
                'cache-expire' => (new DateTimeImmutable())
                    ->add(new DateInterval('P' . $this->systemConfiguration->cacheConfig()->ttl()))
                    ->format('Y-m-d H:i:s')
            ],
        );
    }
}
