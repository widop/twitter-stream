<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter\Rest;

use Widop\Twitter\AbstractRequest;
use Widop\Twitter\Options\OptionBag;
use Widop\Twitter\Options\OptionInterface;

/**
 * Control stream info request.
 *
 * @link https://dev.twitter.com/docs/streaming-apis/streams/site/control
 *
 * @method string getStreamId()                 Gets the stream id.
 * @method null   setStreamId(string $streamId) Sets the stream id.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class ControlStreamInfoRequest extends AbstractRequest
{
    /**
     * Creates a control stream info request.
     *
     * @param string $streamId The stream id.
     */
    public function __construct($streamId)
    {
        parent::__construct();

        $this->setStreamId($streamId);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionBag(OptionBag $optionBag)
    {
        $optionBag->register('stream_id', OptionInterface::TYPE_PATH);
    }

    /**
     * {@inheritdoc}
     */
    protected function validateOptionBag(OptionBag $optionBag)
    {
        if (!isset($optionBag['stream_id'])) {
            throw new \RuntimeException('You must provide a stream id.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath()
    {
        return '/site/c/:stream_id/info.json';
    }
}
