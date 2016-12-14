<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Tests\Adapter;

use AMF\Mutex\Adapter\MemcachedMutex;

/**
 * Test suite for memcached mutex.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class MemcachedMutexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phake_IMock
     */
    private $memcached;

    /**
     * @var \Phake_IMock
     */
    private $memcachedMutex;

    /**
     *
     */
    public function setUp()
    {
        $this->memcached      = \Phake::partialMock(\Memcached::class);
        $this->memcachedMutex = \Phake::partialMock(MemcachedMutex::class, $this->memcached);
    }

    /**
     * @test
     */
    public function shouldReturnKeyIfMutexIsAcquired()
    {
        \Phake::when($this->memcached)->add($this->anything(), $this->anything(), $this->anything())->thenReturn(true);

        $this->assertEquals('test', $this->memcachedMutex->acquire('test', 60));
    }

    /**
     * @test
     */
    public function shouldRetunNullIFMutexIsNotAcquired()
    {
        \Phake::when($this->memcached)->add('test', $this->anything(), $this->anything())->thenReturn(false);

        $this->assertNull($this->memcachedMutex->acquire('test', 60));
    }

    /**
     * @test
     */
    public function shouldReleaseMutex()
    {
        \Phake::when($this->memcached)->get($this->anything())->thenReturn(true);

        $this->memcachedMutex->release('test');

        \Phake::verify($this->memcached)->delete($this->anything());
    }
}
