<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Factory;

use AMF\Mutex\MutexInterface;
use AMF\Mutex\Adapter\MemcachedMutex;
use AMF\Mutex\Adapter\RedisMutex;
use AMF\Mutex\Storage\Memcached\MemcachedFactory;
use AMF\Mutex\Storage\Redis\RedisFactory;
use AMF\Mutex\Storage\StorageFactoryInterface;

/**
 * Factory for retrieving a mutex instance.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class MutexFactory
{
    /**
     * @var StorageFactory
     */
    private $storageFactory;

    /**
     * Constructor class.
     *
     * @param StorageFactory $storageFactory
     */
    public function __construct(StorageFactoryInterface $storageFactory)
    {
        $this->storageFactory = $storageFactory;
    }

    /**
     * Returns a mutex.
     *
     * @return MutexInterface
     */
    public function getMutex()
    {
        if ($this->storageFactory instanceof MemcachedFactory) {
            return new MemcachedMutex($this->storageFactory->create());
        } elseif ($this->storageFactory instanceof RedisFactory) {
            return new RedisMutex($this->storageFactory->create());
        }

        throw new \RuntimeException(sprintf('Mutex storage of type "%s" is not supported.', gettype($this->storageFactory)));
    }
}
