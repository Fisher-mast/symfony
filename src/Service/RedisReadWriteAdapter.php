<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

class RedisReadWriteAdapter extends RedisAdapter
{
    private ?RedisAdapter $redisReadAdapter;

    public function __construct(
        \Predis\ClientInterface|\RedisCluster|\Redis|\RedisArray $redis,
        string                                                   $namespace = '',
        int                                                      $defaultLifetime = 0,
        ?MarshallerInterface                                     $marshaller = null,
        \Predis\ClientInterface|\RedisCluster|\Redis|\RedisArray $redisRead,
    ) {
        parent::__construct($redis, $namespace, $defaultLifetime, $marshaller);
        $this->redisReadAdapter = new RedisAdapter($redisRead, $namespace, $defaultLifetime, $marshaller);
    }

    public function getItem(mixed $key): CacheItem
    {
        return $this->redisReadAdapter->getItem($key);
    }

    public function getItems(array $keys = []): iterable
    {
        return $this->redisReadAdapter->getItems($keys);
    }

    public function hasItem(mixed $key): bool
    {
        return $this->redisReadAdapter->hasItem($key);
    }
}
