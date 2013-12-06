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

use Widop\Twitter\Streaming\PublicStatusesSampleRequest;

/**
 * Public statuses sample request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class PublicStatusesSampleRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Streaming\PublicStatusesSampleRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new PublicStatusesSampleRequest();
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

    public function testOAuthRequestWithParameters()
    {
        $this->request->setDelimited('baz');
        $this->request->setStallWarnings(true);
        $expected = array(
            'delimited'      => 'baz',
            'stall_warnings' => '1'
        );
        $oauthRequest = $this->request->createOAuthRequest();

        $this->assertSame('/statuses/sample.json', $oauthRequest->getPath());
        $this->assertSame('POST', $oauthRequest->getMethod());
        $this->assertSame($expected, $oauthRequest->getPostParameters());
    }
}
