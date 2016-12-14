<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Adapter;

use AMF\Mutex\MutexInterface;

/**
 * Mutex for memcached.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class MemcachedMutex implements MutexInterface
{
    /**
     * @var \Memcached
     */
    protected $memcached;

    /**
     * Constructor class.
     *
     * @param \Memcached $memcached
     */
    public function __construct(\Memcached $memcached)
    {
        $this->memcached = $memcached;
    }

    /**
     * {@inheritdoc}
     */
    public function acquire($key, $ttl)
    {
        $acquired = $this->memcached->add($key, true, $ttl);

        return ($acquired === true) ? $key: null;
    }

    /**
     * {@inheritdoc}
     */
    public function release($key)
    {
        return $this->memcached->delete($key);
    }
}
