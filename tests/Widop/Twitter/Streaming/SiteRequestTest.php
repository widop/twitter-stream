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

use Widop\Twitter\Streaming\SiteRequest;

/**
 * Site request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class SiteRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Streaming\SiteRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new SiteRequest('foo');
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

        $this->assertSame('foo', $this->request->getFollow());
        $this->assertNull($this->request->getDelimited());
        $this->assertNull($this->request->getStallWarnings());
        $this->assertNull($this->request->getWith());
        $this->assertNull($this->request->getReplies());
        $this->assertNull($this->request->getStringifyFriendIds());
    }

    public function testFollow()
    {
        $this->request->setFollow('foo');

        $this->assertSame('foo', $this->request->getFollow());
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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage You must provide the follow parameter.
     */
    public function testOAuthRequestWithoutFollow()
    {
        $this->request->setFollow(null);
        $this->request->createOAuthRequest();
    }

    public function testOAuthRequestWithParameters()
    {
        $this->request->setDelimited('baz');
        $this->request->setStallWarnings(true);
        $this->request->setWith('user');
        $this->request->setReplies('all');
        $this->request->setStringifyFriendIds(true);
        $expected = array(
            'follow'               => 'foo',
            'delimited'            => 'baz',
            'stall_warnings'       => '1',
            'with'                 => 'user',
            'replies'              => 'all',
            'stringify_friend_ids' => '1',
        );
        $oauthRequest = $this->request->createOAuthRequest();

        $this->assertSame('/site.json', $oauthRequest->getPath());
        $this->assertSame('POST', $oauthRequest->getMethod());
        $this->assertSame($expected, $oauthRequest->getPostParameters());
    }
}
