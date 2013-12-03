<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Widop\Twitter\OAuth\OAuth;
use Widop\Twitter\OAuth\OAuthRequest;
use Widop\Twitter\OAuth\Token\TokenInterface;
use Widop\Twitter\Streaming\Event\EventResolver;
use Widop\Twitter\Streaming\Event\TwitterEvent;

/**
 * Twitter.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Twitter
{
    /** @var string */
    private $url;

    /** @var \Widop\Twitter\OAuth\OAuth */
    private $oauth;

    /** @var \Widop\Twitter\OAuth\Token\TokenInterface */
    private $token;

    /*** @var \Symfony\Component\EventDispatcher\EventDispatcher */
    private $eventDispatcher;

    /*** @var \Widop\Twitter\Streaming\Event\EventResolver */
    private $eventResolver;

    /**
     * Creates a twitter client.
     *
     * @param \Widop\Twitter\OAuth\OAuth                              $oauth           The OAuth.
     * @param \Widop\Twitter\Token\TokenInterface|null                $token           The token.
     * @param null|\Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher The event dispatcher.
     * @param null|\Widop\Twitter\Streaming\Event\EventResolver       $eventResolver   The event resolver.
     * @param string                                                  $url             The base url.
     */
    public function __construct(
        OAuth $oauth,
        TokenInterface $token,
        EventDispatcher $eventDispatcher = null,
        EventResolver $eventResolver = null,
        $url = 'https://stream.twitter.com/1.1'
    ) {
        $this->setUrl($url);
        $this->setOAuth($oauth);
        $this->setToken($token);
        $this->setEventDispatcher($eventDispatcher ?: new EventDispatcher());
        $this->setEventResolver($eventResolver ?: new EventResolver());
    }

    /**
     * Gets the twitter API url.
     *
     * @return string The twitter API url.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the twitter API url.
     *
     * @param string $url The twitter API url.
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Gets OAuth.
     *
     * @return \Widop\Twitter\OAuth\OAuth OAuth.
     */
    public function getOAuth()
    {
        return $this->oauth;
    }

    /**
     * Sets OAuth.
    *
     * @param \Widop\Twitter\OAuth\OAuth $oauth OAuth.
     */
    public function setOAuth(OAuth $oauth)
    {
        $this->oauth = $oauth;
    }

    /**
     * Gets the token.
     *
     * @return \Widop\Twitter\Token\TokenInterface|null The token.
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the token.
     *
     * @param \Widop\Twitter\Token\TokenInterface $token The token.
     */
    public function setToken(TokenInterface $token)
    {
        $this->token = $token;
    }

    /**
     * Gets the event dispatcher.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher The event dispatcher.
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * Sets the event dispatcher.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher The event dispatcher.
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Gets the event resolver.
     *
     * @return \Widop\Twitter\Streaming\Event\EventResolver The event resolver.
     */
    public function getEventResolver()
    {
        return $this->eventResolver;
    }

    /**
     * Sets the event resolver.
     *
     * @param \Widop\Twitter\Streaming\Event\EventResolver $eventResolver The event resolver.
     */
    public function setEventResolver(EventResolver $eventResolver)
    {
        $this->eventResolver = $eventResolver;
    }

    /**
     * Streams a Twitter request.
     *
     * @param \Widop\Twitter\AbstractStreamingRequest $request The Twitter request.
     */
    public function stream(AbstractStreamingRequest $request)
    {
        $request = $request->createOAuthRequest();
        $request->setBaseUrl($this->getUrl());

        $this->getOAuth()->signRequest($request, $this->getToken());
        $this->streamRequest($request);
    }

    /**
     * Streams the request over http.
     *
     * @param \Widop\Twitter\OAuth\OAuthRequest $request The OAuth request.
     *
     * @throws \RuntimException If the http method is not supported.
     */
    private function streamRequest(OAuthRequest $request)
    {
        switch ($request->getMethod()) {
            case 'GET':
                $this->getOAuth()->getHttpAdapter()->getContent(
                    $request->getUrl(),
                    $request->getHeaders(),
                    $this->createPersistentCallback()
                );
                break;

            case 'POST':
                // The http adapter encodes POST datas itself.
                $postParameters = array();
                foreach ($request->getPostParameters() as $name => $value) {
                    $postParameters[rawurldecode($name)] = rawurldecode($value);
                }

                $this->getOAuth()->getHttpAdapter()->postContent(
                    $request->getUrl(),
                    $request->getHeaders(),
                    $postParameters,
                    $request->getFileParameters(),
                    $this->createPersistentCallback()
                );
                break;

            default:
                throw new \RuntimeException(sprintf('The request method "%s" is not supported.', $request->getMethod()));
        }
    }

    private function createPersistentCallback()
    {
        $eventDispatcher = $this->eventDispatcher;
        $eventResolver = $this->eventResolver;

        return function ($data) use ($eventDispatcher, $eventResolver) {
            $json = json_decode($data);

            if ($json === false) {
                throw new \RuntimeException(sprintf('Invalid JSON received (%s).', $data));
            }

            $event = new TwitterEvent($json);

            foreach($eventResolver->resolve($json) as $eventName) {
                $eventDispatcher->dispatch($eventName, $event);
            }
        };
    }
}
