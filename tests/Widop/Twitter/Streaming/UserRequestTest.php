<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Tests\Twitter\Streaming;

use Widop\Twitter\Streaming\UserRequest;

/**
 * User request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class UserRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Streaming\UserRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new UserRequest();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->request);
    }

    public function testDefaultState()
    {
        $this->assertInstanceOf('Widop\Twitter\AbstractRequest', $this->request);

        $this->assertNull($this->request->getDelimited());
        $this->assertNull($this->request->getStallWarnings());
        $this->assertNull($this->request->getWith());
        $this->assertNull($this->request->getReplies());
        $this->assertNull($this->request->getTrack());
        $this->assertNull($this->request->getLocations());
        $this->assertNull($this->request->getStringifyFriendIds());
    }

    public function testDelimited()
    {
        $this->request->setDelimited('foo');

        $this->assertSame('foo', $this->request->getDelimited());
    }

    public function testStallWarnings()
    {
        $this->request->setStallWarnings(true);

        $this->assertTrue($this->request->getStallWarnings());
    }

    public function testWith()
    {
        $this->request->setWith('foo');

        $this->assertSame('foo', $this->request->getWith());
    }

    public function testReplies()
    {
        $this->request->setReplies('foo');

        $this->assertSame('foo', $this->request->getReplies());
    }

    public function testTrack()
    {
        $this->request->setTrack('foo');

        $this->assertSame('foo', $this->request->getTrack());
    }

    public function testLocations()
    {
        $this->request->setLocations('foo');

        $this->assertSame('foo', $this->request->getLocations());
    }

    public function testStringifyFriendIds()
    {
        $this->request->setStringifyFriendIds(true);

        $this->assertTrue($this->request->getStringifyFriendIds());
    }

    public function testOAuthRequestWithParameters()
    {
        $this->request->setDelimited('baz');
        $this->request->setStallWarnings(true);
        $this->request->setWith('user');
        $this->request->setReplies('all');
        $this->request->setTrack('foo');
        $this->request->setLocations('bar');
        $this->request->setStringifyFriendIds(true);
        $expected = array(
            'delimited'            => 'baz',
            'stall_warnings'       => '1',
            'with'                 => 'user',
            'replies'              => 'all',
            'track'                => 'foo',
            'locations'            => 'bar',
            'stringify_friend_ids' => '1',
        );
        $oauthRequest = $this->request->createOAuthRequest();

        $this->assertSame('/user.json', $oauthRequest->getPath());
        $this->assertSame('POST', $oauthRequest->getMethod());
        $this->assertSame($expected, $oauthRequest->getPostParameters());
    }
}
