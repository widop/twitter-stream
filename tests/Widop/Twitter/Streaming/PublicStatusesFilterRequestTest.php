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

use Widop\Twitter\Streaming\PublicStatusesFilterRequest;

/**
 * Public statuses filter request test.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
class PublicStatusesFilterRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\Twitter\Streaming\PublicStatusesFilterRequest */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new PublicStatusesFilterRequest();
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

        $this->assertNull($this->request->getFollow());
        $this->assertNull($this->request->getTrack());
        $this->assertNull($this->request->getLocations());
        $this->assertNull($this->request->getDelimited());
        $this->assertNull($this->request->getStallWarnings());
    }

    public function testFollow()
    {
        $this->request->setFollow('foo');

        $this->assertSame('foo', $this->request->getFollow());
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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage You must provide at least one parameter (follow, locations or track).
     */
    public function testOAuthRequestWithoutParameters()
    {
        $this->request->createOAuthRequest();
    }

    public function testOAuthRequestWithParameters()
    {
        $this->request->setFollow('123465789,456789,456123');
        $this->request->setTrack('foo');
        $this->request->setLocations('bar');
        $this->request->setDelimited('baz');
        $this->request->setStallWarnings(true);
        $expected = array(
            'follow'         => '123465789%2C456789%2C456123',
            'track'          => 'foo',
            'locations'      => 'bar',
            'delimited'      => 'baz',
            'stall_warnings' => '1'
        );
        $oauthRequest = $this->request->createOAuthRequest();

        $this->assertSame('/statuses/filter.json', $oauthRequest->getPath());
        $this->assertSame('POST', $oauthRequest->getMethod());
        $this->assertSame($expected, $oauthRequest->getPostParameters());
    }
}
