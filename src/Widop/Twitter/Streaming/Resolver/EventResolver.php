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

/**
 * Event resolver.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class EventResolver implements EventResolverInterface
{
    /** @var array */
    private $resolvers;

    /**
     * Creates an event resolver.
     *
     * @param array $resolvers The event resolvers.
     */
    public function __construct(array $resolvers = array())
    {
        $this->resolvers = $resolvers;

        if (empty($resolvers)) {
            $userEventResolver = new UserEventResolver();
            $this->resolvers[] = new SiteEventResolver($userEventResolver);
            $this->resolvers[] = $userEventResolver;
            $this->resolvers[] = new PublicEventResolver();
            $this->resolvers[] = new NoticeEventResolver();
        }
    }

    /**
     * Gets the resolvers.
     *
     * @return array The resolvers.
     */
    public function getResolvers()
    {
        return $this->resolvers;
    }

    /**
     * Sets the resolvers.
     *
     * @param array $resolvers The resolvers.
     */
    public function setResolvers(array $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    /**
     * Adds the resolver.
     *
     * @param \Widop\Twitter\Streaming\Event\Resolver\EventResolverInterface $resolver The resolver.
     */
    public function addResolver(EventResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array &$response)
    {
        $events = array();

        foreach ($this->resolvers as $resolver) {
            $events = array_merge($events, $resolver->resolve($response));
        }

        if (empty($events)) {
            // Log the data
        }

        return $events;
    }
}