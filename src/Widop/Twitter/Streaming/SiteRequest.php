<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter\Streaming;

use Widop\Twitter\AbstractStreamingRequest;
use Widop\Twitter\Options\OptionBag;
use Widop\Twitter\Options\OptionInterface;

/**
 * Site request.
 *
 * @link https://dev.twitter.com/docs/api/1.1/get/site
 * @link https://dev.twitter.com/docs/streaming-apis/parameters
 *
 * @method string|null  getFollow()                               Gets the comma-separated list of user IDs to follow on the stream.
 * @method null         setFollow(string $follow)                 Sets the comma-separated list of user IDs to follow on the stream.
 * @method string|null  getDelimited()                            Checks if the messages should be delimited.
 * @method null         setDelimited(string $delimited)           Sets if the messages should be delimited.
 * @method boolean|null getStallWarnings()                        Checks if stall warnings should be delivered.
 * @method null         setStallWarnings(boolean $stallWarnings)  Sets if stall warnings should be delivered.
 * @method string|null  getWith()                                 Gets the type of messages delivered (user, followings).
 * @method null         setWith(string $with)                     Sets the type of messages delivered (user, followings).
 * @method string|null  getReplies()                              Gets if additional replies will be returned.
 * @method null         setReplies(string $replies)               Sets if additional replies will be returned.
 * @method boolean|null getStringifyFriendIds()                   Checks if stall warnings should be delivered.
 * @method null         setStringifyFriendIds(boolean $stringify) Sets if stall warnings should be delivered.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class SiteRequest extends AbstractStreamingRequest
{
    /**
     * Creates a site request.
     *
     * @param callable $persistentCallback The persistent callback.
     * @param string   $follow             The comma-separated list of user IDs to follow on the stream.
     */
    public function __construct($persistentCallback, $follow)
    {
        parent::__construct($persistentCallback);

        $this->setFollow($follow);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionBag(OptionBag $optionBag)
    {
        $optionBag
            ->register('follow', OptionInterface::TYPE_POST)
            ->register('delimited', OptionInterface::TYPE_POST)
            ->register('stall_warnings', OptionInterface::TYPE_POST)
            ->register('with', OptionInterface::TYPE_POST)
            ->register('replies', OptionInterface::TYPE_POST)
            ->register('stringify_friend_ids', OptionInterface::TYPE_POST);
    }

    /**
     * {@inheritdoc}
     */
    protected function validateOptionBag(OptionBag $optionBag)
    {
        if (!isset($optionBag['follow'])) {
            throw new \RuntimeException('You must provide the follow parameter.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath()
    {
        return '/site.json';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMethod()
    {
        return 'POST';
    }
}
