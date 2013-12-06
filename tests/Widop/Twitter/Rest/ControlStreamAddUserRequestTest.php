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

use Widop\Twitter\Rest\ControlStreamAddUserRequest;

/**
 * Control stream add user request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class ControlStreamAddUserRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Rest\ControlStreamAddUserRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new ControlStreamAddUserRequest('foo', '123456');
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
        $oauthRequest = $this->request->createOAuthRequest();
        $oauthRequest->setBaseUrl('https://stream.twitter.com/1.1');

        $this->assertSame('/site/c/:stream_id/add_user.json', $oauthRequest->getPath());
        $this->assertSame('POST', $oauthRequest->getMethod());
        $this->assertSame(
            'https://stream.twitter.com/1.1/site/c/foo/add_user.json',
            $oauthRequest->getSignatureUrl()
        );
        $this->assertSame(array('user_id' => '123456'), $oauthRequest->getPostParameters());
    }
}
