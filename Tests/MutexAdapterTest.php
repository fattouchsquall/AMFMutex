<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AMF\Mutex;

use AMF\Mutex\MutexInterface;
use AMF\Mutex\MutexAdapter;

/**
 * Test suite for adapter of mutex.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class MutexAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phake_IMock
     */
    protected $mutex;

    /**
     * @var \Phake_IMock
     */
    protected $mutexAdapter;

    /**
     *
     */
    public function setUp()
    {
        $this->mutex        = \Phake::partialMock(MutexInterface::class);
        $this->mutexAdapter = \Phake::partialMock(MutexAdapter::class, $this->mutex, 10, 0);
    }

    /**
     * @test
     */
    public function shouldAcquireMutex()
    {
        \Phake::when($this->mutexAdapter)->generateKey($this->anything())->thenReturn('worker_test');
        \Phake::when($this->mutex)->acquire($this->anything(), $this->anything())->thenReturn('worker_test');

        $this->assertEquals('worker_test', $this->mutexAdapter->acquire('test'));
    }

    /**
     * @test
     */
    public function shouldThrowAnExceptionIfMutexIsAlreadyAcquired()
    {
        $this->setExpectedExceptionRegExp(\RuntimeException::class);

        \Phake::when($this->mutexAdapter)->generateKey($this->anything())->thenReturn('worker_test');
        \Phake::when($this->mutex)->acquire($this->anything(), $this->anything())->thenReturn(null);

        $this->mutexAdapter->acquire('test');
    }

    /**
     * @test
     */
    public function shouldReleaseMutex()
    {
        \Phake::when($this->mutexAdapter)->generateKey('test')->thenReturn('worker_test');
        \Phake::when($this->mutex)->release($this->anything(), $this->anything())->thenReturn(true);

        $this->assertNull($this->mutexAdapter->release('worker_test'));
    }

    /**
     * @test
     */
    public function shouldThrowAnExceptionIfCantReleaseTheMutex()
    {
        $this->setExpectedExceptionRegExp(\RuntimeException::class);

        \Phake::when($this->mutexAdapter)->generateKey($this->anything())->thenReturn('worker_test');
        \Phake::when($this->mutex)->release($this->anything())->thenReturn(false);

        $this->mutexAdapter->release('test');
    }
}
