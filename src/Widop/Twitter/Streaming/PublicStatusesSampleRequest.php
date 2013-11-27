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
 * Public statuses sample request.
 *
 * @link https://dev.twitter.com/docs/api/1.1/post/statuses/sample
 * @link https://dev.twitter.com/docs/streaming-apis/parameters
 *
 * @method string|null  getDelimited()                           Checks if the messages should be delimited.
 * @method null         setDelimited(string $delimited)          Sets if the messages should be delimited.
 * @method boolean|null getStallWarnings()                       Checks if stall warnings should be delivered.
 * @method null         setStallWarnings(boolean $stallWarnings) Sets if stall warnings should be delivered.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class PublicStatusesSampleRequest extends AbstractStreamingRequest
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptionBag(OptionBag $optionBag)
    {
        $optionBag
            ->register('delimited', OptionInterface::TYPE_POST)
            ->register('stall_warnings', OptionInterface::TYPE_POST);
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath()
    {
        return '/statuses/sample.json';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMethod()
    {
        return 'POST';
    }
}
