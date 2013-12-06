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
 * Public event resolver.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class PublicEventResolver implements EventResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve(array $response)
    {
        $events = array();
        $event = null;

        // Public events
        if (isset($response->delete)) {
            $event = Event::PUBLIC_STATUS_DELETED;
        } elseif (isset($response->scrub_geo)) {
            $event = Event::PUBLIC_NOTICE_LOCATION_DELETED;
        } elseif (isset($response->limit)) {
            $event = Event::PUBLIC_NOTICE_LIMIT;
        } elseif (isset($response->status_withheld)) {
            $event = Event::PUBLIC_NOTICE_STATUS_WITHHELD;
        } elseif (isset($response->user_withheld)) {
            $event = Event::PUBLIC_NOTICE_USER_WITHHELD;
        } elseif (isset($response->disconnect)) {
            $event = Event::PUBLIC_NOTICE_DISCONNECT;
        } elseif (isset($response->created_at) && isset($response->text)) {
            $event = Event::PUBLIC_STATUS_NEW;
        }

        if ($event !== null) {
            $events[Event::PUBLIC_EVENT] = new TwitterEvent($response);
            $events[$event] = new TwitterEvent($response);
        }

        return $events;
    }
}