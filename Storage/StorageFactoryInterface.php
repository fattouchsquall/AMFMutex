<?php

/*
 * This file is part of the Mutex Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\Mutex\Storage;

/**
 * Factory interface for storage servers.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
interface StorageFactoryInterface
{
    /**
     * Creates an instance of storage server.
     *
     * @return mixed
     */
    public function create();
}
