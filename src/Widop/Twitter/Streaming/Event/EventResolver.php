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

/**
 * Event resolver.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class EventResolver
{
    /**
     * Resolves the twitter events.
     *
     * @param array $response The reponse.
     *
     * @return array The events matched.
     */
    public function resolve(array $response)
    {
        $events = array();

        return $events;
    }
}