<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter\Options;

use Widop\Twitter\Options\OptionInterface;

/**
 * Option factory.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class OptionFactory
{
    /** @var array */
    private $mapping;

    /**
     * Creates an option factory.
     */
    public function __construct()
    {
        $this->mapping = array(
            'count'                => 'Widop\Twitter\Options\CountOption',
            'cursor'               => 'Widop\Twitter\Options\CursorOption',
            'delimited'            => 'Widop\Twitter\Options\DelimitedOption',
            'follow'               => 'Widop\Twitter\Options\FollowOption',
            'locations'            => 'Widop\Twitter\Options\LocationsOption',
            'replies'              => 'Widop\Twitter\Options\RepliesOption',
            'stall_warnings'       => 'Widop\Twitter\Options\StallWarningsOption',
            'stream_id'            => 'Widop\Twitter\Options\StreamIdOption',
            'stringify_friend_ids' => 'Widop\Twitter\Options\StringifyFriendIdsOption',
            'stringify_ids'        => 'Widop\Twitter\Options\StringifyIdsOption',
            'track'                => 'Widop\Twitter\Options\TrackOption',
            'user_id'              => 'Widop\Twitter\Options\UserIdOption',
            'with'                 => 'Widop\Twitter\Options\WithOption',
        );
    }

    /**
     * Creates an option.
     *
     * @param string $option The option name.
     * @param string $type   The option type.
     *
     * @throws \InvalidArgumentException If the option does not exist.
     *
     * @return \Widop\Twitter\Options\OptionInterface The option.
     */
    public function create($option, $type = OptionInterface::TYPE_GET)
    {
        if (!isset($this->mapping[$option])) {
            throw new \InvalidArgumentException(sprintf('The option "%s" does not exist.', $option));
        }

        return new $this->mapping[$option]($type);
    }
}
