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
    protected $data;

    /** @var string */
    protected $context;

    /** @var string */
    protected $userId;

    /**
     * Creates a twitter event.
     *
     * @param array $data The data.
     */
    public function __construct(array $data, $context, $userId = null)
    {
        $this->data = $data;
        $this->context = $context;
        $this->userId = $userId;
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

    /**
     * Gets the user id.
     *
     * @return string The user id.
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Gets the request context.
     *
     * @return string The request context.
     */
    public function getContext()
    {
        return $this->context;
    }
}
