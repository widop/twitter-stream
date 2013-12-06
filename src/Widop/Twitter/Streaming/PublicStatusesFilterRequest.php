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

use Widop\Twitter\AbstractRequest;
use Widop\Twitter\Options\OptionBag;
use Widop\Twitter\Options\OptionInterface;

/**
 * Public statuses filter request.
 *
 * @link https://dev.twitter.com/docs/api/1.1/post/statuses/filter
 * @link https://dev.twitter.com/docs/streaming-apis/parameters
 *
 * @method string|null  getFollow()                              Gets the comma-separated list of user IDs to follow on the stream.
 * @method null         setFollow(string $follow)                Sets the comma-separated list of user IDs to follow on the stream.
 * @method string|null  getTrack()                               Gets the list of phrases to use on the stream.
 * @method null         setTrack(string $track)                  Sets the list of phrases to use on the stream.
 * @method string|null  getLocations()                           Gets the comma-separated list of longitude,latitude pairs to use on the stream.
 * @method null         setLocations(string $locations)          Sets the comma-separated list of longitude,latitude pairs to use on the stream.
 * @method string|null  getDelimited()                           Checks if the messages should be delimited.
 * @method null         setDelimited(string $delimited)          Sets if the messages should be delimited.
 * @method boolean|null getStallWarnings()                       Checks if stall warnings should be delivered.
 * @method null         setStallWarnings(boolean $stallWarnings) Sets if stall warnings should be delivered.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class PublicStatusesFilterRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptionBag(OptionBag $optionBag)
    {
        $optionBag
            ->register('follow', OptionInterface::TYPE_POST)
            ->register('track', OptionInterface::TYPE_POST)
            ->register('locations', OptionInterface::TYPE_POST)
            ->register('delimited', OptionInterface::TYPE_POST)
            ->register('stall_warnings', OptionInterface::TYPE_POST);
    }

    /**
     * {@inheritdoc}
     */
    protected function validateOptionBag(OptionBag $optionBag)
    {
        if (!isset($optionBag['follow']) || !isset($optionBag['track']) || !isset($optionBag['locations'])) {
            throw new \RuntimeException('You must provide at least one parameter (follow, locations or track).');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath()
    {
        return '/statuses/filter.json';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMethod()
    {
        return 'POST';
    }
}
