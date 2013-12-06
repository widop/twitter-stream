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
 * Site event resolver.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class SiteEventResolver
{
    private $userEventResolver;

    /**
     * Creates a site event resolver.
     *
     * @param \Widop\Twitter\Streaming\Resolver\UserEventResolver $userEventResolver The user event resolver.
     */
    public function __construct(UserEventResolver $userEventResolver = null)
    {
        $this->userEventResolver = $userEventResolver ?: new UserEventResolver();
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $response)
    {
        $events = array();
        $event = null;

        // Site event
        if (isset($response->control)) {
            $event = Event::SITE_NOTICE_CONTROL_MESSAGE;
        }

        if ($event !== null) {
            $events[Event::SITE_EVENT] = new TwitterEvent($response);

            if ($event === Event::SITE_NOTICE_CONTROL_MESSAGE) {
                $events[Event::NOTICE_EVENT] = new TwitterEvent($response);
            }

            $events[$event] = new TwitterEvent($response);
        }

        return $events;
    }
}
