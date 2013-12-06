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
 * Control stream remove users request.
 *
 * @link https://dev.twitter.com/docs/streaming-apis/streams/site/control
 *
 * @method string       getStreamId()                          Gets the stream id on which to request user friendlist.
 * @method null         setStreamId(string $streamId)          Sets the stream id on which to request user friendlist.
 * @method string       getUserId()                            Gets the comma-separated list of user IDs.
 * @method null         setUserId(string $userId)              Sets the comma-separated list of user IDs.
 * @method string|null  getCursor()                            Gets the cursor.
 * @method null         setCursor(string $cursor)              Sets the cursor.
 * @method boolean|null getStringifyIds()                      Gets if the user ids will be returned as strings.
 * @method null         setStringifyIds(boolean $stringifyIds) Sets if the user ids will be returned as strings.
 * @method integer|null getCount()                             Gets the number of ids.
 * @method null         setCount(integer $count)               Sets the number of ids (max: 5000).
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class ControlStreamFriendListRequest extends AbstractRequest
{
    /**
     * Creates a control stream remove users request.
     *
     * @param string $streamId The stream id.
     * @param string $userId   The comma-separated list of user IDs to add on the stream.
     */
    public function __construct($streamId, $userId)
    {
        parent::__construct();

        $this->setStreamId($streamId);
        $this->setUserId($userId);
    }


    /**
     * {@inheritdoc}
     */
    protected function configureOptionBag(OptionBag $optionBag)
    {
        $optionBag
            ->register('stream_id', OptionInterface::TYPE_PATH)
            ->register('user_id', OptionInterface::TYPE_POST)
            ->register('cursor', OptionInterface::TYPE_POST)
            ->register('stringify_ids', OptionInterface::TYPE_POST)
            ->register('count', OptionInterface::TYPE_POST);
    }

    /**
     * {@inheritdoc}
     */
    protected function validateOptionBag(OptionBag $optionBag)
    {
        if (!isset($optionBag['stream_id'])) {
            throw new \RuntimeException('You must provide a stream id.');
        }

        if (!isset($optionBag['user_id'])) {
            throw new \RuntimeException('You must provide a user id.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath()
    {
        return '/site/c/:stream_id/friends/ids.json';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMethod()
    {
        return 'POST';
    }
}
