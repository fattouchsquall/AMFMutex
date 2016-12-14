<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Adapter;

use AMF\Mutex\MutexInterface;
use Predis\ClientInterface;

/**
 * Mutex for redis.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class RedisMutex implements MutexInterface
{
    /**
     * @var Client
     */
    private $redis;

    /**
     * Constructor class.
     *
     * @param ClientInterface $redis Instance of redis client.
     */
    public function __construct(ClientInterface $redis)
    {
        $this->redis = $redis;
    }

    /**
     * {@inheritdoc}
     */
    public function acquire($key, $ttl)
    {
        $acquired = $this->redis->sadd($key, 1);

        if ($acquired === true) {
            $this->redis->expire($key, $ttl);

            return $key;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function release($key)
    {
        if ($this->redis->exists($key)) {
            $this->redis->srem($key);
        }
    }
}
