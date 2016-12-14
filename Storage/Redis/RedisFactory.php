<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Storage\Redis;

use AMF\Mutex\Storage\StorageFactoryInterface;
use Predis\Client;

/**
 * Factory for creating a redis instance.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class RedisFactory implements StorageFactoryInterface
{
    /**
     * @var array
     */
    private $parameters = [
        'host'   => ['localhost'],
        'port'   => 6379,
        'scheme' => 'tcp',
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
     * Creates an instance of redis.
     *
     * @return Client
     */
    public function create()
    {
        return new Client($this->parameters);
    }
}
