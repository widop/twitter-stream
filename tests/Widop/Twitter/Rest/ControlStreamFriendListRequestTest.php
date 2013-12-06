<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Tests\Twitter\Rest;

use Widop\Twitter\Rest\ControlStreamFriendListRequest;

/**
 * Control stream friend list request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class ControlStreamFriendListRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Rest\ControlStreamFriendListRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new ControlStreamFriendListRequest('foo', '123456');
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

        $this->assertSame('foo', $this->request->getStreamId());
        $this->assertSame('123456', $this->request->getUserId());
        $this->assertNull($this->request->getCursor());
        $this->assertNull($this->request->getStringifyIds());
        $this->assertNull($this->request->getCount());
    }

    public function testStreamId()
    {
        $this->request->setStreamId('bar');

        $this->assertSame('bar', $this->request->getStreamId());
    }

    public function testUserId()
    {
        $this->request->setUserId('123456789');

        $this->assertSame('123456789', $this->request->getUserId());
    }

    public function testCursor()
    {
        $this->request->setCursor('123456789');

        $this->assertSame('123456789', $this->request->getCursor());
    }

    public function testCount()
    {
        $this->request->setCount(20);

        $this->assertSame(20, $this->request->getCount());
    }

    public function testStringifyIds()
    {
        $this->request->setStringifyIds(true);

        $this->assertTrue($this->request->getStringifyIds());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage You must provide a stream id.
     */
    public function testOAuthRequestWithoutStreamId()
    {
        $this->request->setStreamId(null);
        $this->request->createOAuthRequest();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage You must provide a user id.
     */
    public function testOAuthRequestWithoutUserId()
    {
        $this->request->setUserId(null);
        $this->request->createOAuthRequest();
    }

    public function testOAuthRequestWithParameters()
    {
        $this->request->setCursor('9876543210');
        $this->request->setStringifyIds(true);
        $this->request->setCount(50);
        $oauthRequest = $this->request->createOAuthRequest();
        $oauthRequest->setBaseUrl('https://stream.twitter.com/1.1');
        $expected = array(
            'user_id'       => '123456',
            'cursor'        => '9876543210',
            'stringify_ids' => '1',
            'count'         => '50',
        );

        $this->assertSame('/site/c/:stream_id/friends/ids.json', $oauthRequest->getPath());
        $this->assertSame('POST', $oauthRequest->getMethod());
        $this->assertSame(
            'https://stream.twitter.com/1.1/site/c/foo/friends/ids.json',
            $oauthRequest->getSignatureUrl()
        );
        $this->assertSame($expected, $oauthRequest->getPostParameters());
    }
}
