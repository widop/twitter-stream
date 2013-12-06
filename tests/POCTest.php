<?php

use Widop\HttpAdapter\CurlHttpAdapter;
use Widop\Twitter\OAuth\OAuth;
use Widop\Twitter\OAuth\OAuthConsumer;
use Widop\Twitter\OAuth\Token\OAuthToken;
use Widop\Twitter\OAuth\Signature\OAuthHmacSha1Signature;
use Widop\Twitter\Twitter;

use Widop\Twitter\Streaming\PublicStatusesSampleRequest;

/**
 * POC.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class POCTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        return ;
        $oauth = new OAuth(
            new CurlHttpAdapter(),
            new OAuthConsumer('g35F3Cy5oE0mUIV5csGq6Q', 'Epue5l3jXxWtGvpmqHN001tynXUihGdNBNsZ085Guk'),
            new OAuthHmacSha1Signature()
        );

        $oauthToken = new OAuthToken(
            '181876142-0crHnsewXfWX7MfcuL8gzLOvNULV5Lo4QhLmTKVf',
            'EXnBhgqGEKXZXz1aiIF1d1e37cOuL0hLBBhSsU2H9U'
        );

        $twitter = new Twitter($oauth, $oauthToken);

        $request = new PublicStatusesSampleRequest();
        $twitter->stream($request);
    }
}
