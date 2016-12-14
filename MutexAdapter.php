<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex;

use AMF\Mutex\MutexInterface;

/**
 * Adapter to adapt mutex to current context.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class MutexAdapter
{
    /**
     * @var MutexInterface
     */
    protected $mutex;

    /**
     * @var integer
     */
    protected $attemptTotal;

    /**
     * @var integer
     */
    protected $wait;

    /**
     * @var string
     */
    protected $prefix;

    /**
     *
     * @param MutexInterface $mutex
     * @param integer        $attemptTotal
     * @param integer        $wait
     * @param string         $prefix
     */
    public function __construct(MutexInterface $mutex, $attemptTotal = 10, $wait = 1, $prefix = 'worker_mutex')
    {
        $this->mutex        = $mutex;
        $this->attemptTotal = $attemptTotal;
        $this->wait         = $wait;
        $this->prefix       = $prefix;
    }

    /**
     * Acquires access to Semaphore.
     *
     * @param string  $key
     * @param integer $ttl
     *
     * @return string
     */
    public function acquire($key, $ttl = 60)
    {
        $generatedKey = $this->generateKey($key);
        $attemptTotal = $this->attemptTotal;
        $mutex        = $this->mutex;

        while ($attemptTotal > 0 && !$acquired = $mutex->acquire($generatedKey, $ttl)) {
            $attemptTotal --;
            sleep($this->wait);
        }

        if (isset($acquired) === false) {
            throw new \RuntimeException('Can\'t acquire the mutex. it\'s already taken by another process.');
        }

        return $generatedKey;
    }

    /**
     * Releases access to Semaphore.
     *
     * @param string $key
     */
    public function release($key)
    {
        $generatedKey = $this->generateKey($key);

        if ($this->mutex->release($generatedKey) === false) {
            throw new \RuntimeException('Can\'t relase the mutex. you must acquire it first.');
        }
    }

    /**
     * Generates a key with prefix.
     *
     * @param string $key
     *
     * @return string
     */
    protected function generateKey($key)
    {
        return $this->prefix.$key;
    }
}
