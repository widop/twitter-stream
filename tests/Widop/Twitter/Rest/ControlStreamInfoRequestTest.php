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

use Widop\Twitter\Rest\ControlStreamInfoRequest;

/**
 * Control stream remove user request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class ControlStreamInfoRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Rest\ControlStreamInfoRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new ControlStreamInfoRequest('foo');
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
    }

    public function testStreamId()
    {
        $this->request->setStreamId('bar');

        $this->assertSame('bar', $this->request->getStreamId());
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

    public function testOAuthRequestWithParameters()
    {
        $oauthRequest = $this->request->createOAuthRequest();
        $oauthRequest->setBaseUrl('https://stream.twitter.com/1.1');

        $this->assertSame('/site/c/:stream_id/info.json', $oauthRequest->getPath());
        $this->assertSame('GET', $oauthRequest->getMethod());
        $this->assertSame( 'https://stream.twitter.com/1.1/site/c/foo/info.json', $oauthRequest->getSignatureUrl());
        $this->assertEmpty($oauthRequest->getGetParameters());
    }
}
