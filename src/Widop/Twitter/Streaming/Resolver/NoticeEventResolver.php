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
 * Notice event resolver.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class NoticeEventResolver implements EventResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve(array $response)
    {
        $events = array();
        $event = null;

        // Notice event
        if (isset($response->warning) && isset($this->warning->percent_full)) {
            $events[] = Event::NOTICE_STALL_WARNING;
        } elseif (isset($response->warning)) {
            $events[] = Event::NOTICE_FOLLOW_LIMIT;
        }

        if ($event !== null) {
            $events[Event::NOTICE_EVENT] = new TwitterEvent($response);
            $events[$event] = new TwitterEvent($response);
        }

        return $events;
    }
}
