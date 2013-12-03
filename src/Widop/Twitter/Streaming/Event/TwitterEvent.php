<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter\Streaming\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Twitter event.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class TwitterEvent extends Event
{
    /** @var array */
    private $data;

    /**
     * Creates a twitter event.
     *
     * @param array $data The data.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Gets the data.
     *
     * @return array The data.
     */
    public function getData()
    {
        return $this->data;
    }
}
