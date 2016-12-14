<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex;

/**
 * Interface for Mutex.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
interface MutexInterface
{
    /**
     * Acquires mutex.
     *
     * @param string  $key The key of mutex to lock.
     * @param integer $ttl The time of locking.
     */
    public function acquire($key, $ttl);

    /**
     * Releases mutex.
     *
     * @param string $key The key of mutex to unlock.
     *
     * @return boolean
     */
    public function release($key);
}
