<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter\Streaming\Resolver;

use Widop\Twitter\Streaming\Event\TwitterEvents as Event;
use Widop\Twitter\Streaming\Event\TwitterEvent;

/**
 * User event resolver.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class UserEventResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolve(array $response)
    {
        $events = array();
        $event = null;

        // User event
        if (isset($response->friends)) {
            $event = Event::USER_FRIEND_LIST;
        }

        if (isset($response->recipient)) {
            $event = Event::USER_DIRECT_MESSAGE;
        }

        if (isset($response->event)) {
            $event = Event::USER_EVENT_EVENT;
        }

        if ($event !== null) {
            $events[Event::USER_EVENT] = new TwitterEvent($response);
            $events[$event] = new TwitterEvent($response);
        }

        return $events;
    }
}
