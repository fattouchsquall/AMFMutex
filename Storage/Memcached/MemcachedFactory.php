<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Storage\Memcached;

use AMF\Mutex\Storage\StorageFactoryInterface;

/**
 * Factory for creating a memcached instance.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class MemcachedFactory implements StorageFactoryInterface
{
    /**
     * @var array
     */
    private $parameters = [
        [
            'host' => 'localhost',
            'port'  => 11211,
        ],
    ];

    /**
     * Constructor class.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * Creates an instance of memcached.
     *
     * @return \Memcached
     */
    public function create()
    {
        if (extension_loaded('memcached')) {
            $memcached = new \Memcached();
            $memcached->addServers($this->parameters);

            return $memcached;
        }

        throw new \RuntimeException(sprintf('Extension memcached is not loaded.'));
    }
}
