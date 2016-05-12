<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/08/15
 * Time: 15:01
 */

namespace CultuurNet\UitidCredentials;

use CultuurNet\Auth\ConsumerCredentials;
use CultuurNet\UitidCredentials\Entities\Consumer;
use CultuurNet\UitidCredentials\Entities\Token;
use CultuurNet\UitidCredentials\Entities\User;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;

class UitidCredentialsFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockPlugin
     */
    protected $apiMock;

    /**
     * @var UitidCredentialsFetcher
     */
    protected $fetcher;

    public function setUp()
    {
        $this->apiMock = new MockPlugin();
        $baseUrl = '';
        $consumerCredentials = new ConsumerCredentials(
            'key',
            'secret'
        );
        $tokenCredentials = null;

        $this->fetcher = new UitidCredentialsFetcher($baseUrl, $consumerCredentials, $tokenCredentials);
        $this->fetcher->addSubscriber($this->apiMock);
    }

    public function testGetConsumer()
    {
        $xml = file_get_contents(__DIR__ . '/samples/consumer.xml');

        $response = new Response('200', null, $xml);

        $this->apiMock->addResponse($response);

        $consumer =  $this->fetcher->getConsumer('f4e3c8b7f1c0b57a2313bd92dbeff7c2');

        $correctConsumer = new Consumer(
            'f4e3c8b7f1c0b57a2313bd92dbeff7c2',
            '94238234899842389743298897247892',
            'testchannel'
        );

        $this->assertEquals(
            $correctConsumer,
            $consumer
        );
    }

    public function testGetToken()
    {
        $xml = file_get_contents(__DIR__ . '/samples/token.xml');

        $response = new Response('200', null, $xml);

        $this->apiMock->addResponse($response);

        $token =  $this->fetcher->getAccessToken('0005548e3bfe0a47938fd5b1c8369ff1');

        $correctToken = new Token(
            '0005548e3bfe0a47938fd5b1c8369ff1',
            '0943093409903409023092439023',
            new User(
                '11a9e9b8-c71c-4850-ab93-f14a10ca9e47',
                'Test user',
                'example@cultuurnet.be'
            ),
            new Consumer(
                'd454b97f34c14dac0430ea1bd3f16d45',
                '0943093409903409023092439023',
                'UiTDatabank'
            )
        );

        $this->assertEquals(
            $correctToken,
            $token
        );
    }

    public function testGetTokenFromJwt()
    {
        $xml = file_get_contents(__DIR__ . '/samples/token-without-consumer.xml');

        $response = new Response('200', null, $xml);

        $this->apiMock->addResponse($response);

        $token =  $this->fetcher->getAccessToken('0005548e3bfe0a47938fd5b1c8369ff1');

        $correctToken = new Token(
            '2143f7db7642b3687e90d718b79a42ce',
            '4c06eb61aa814a057578640ee61ea420',
            new User(
                '12346093-0e7e-4803-be0b-69b24c145f89',
                'testtesttest',
                'testtestest@cultuurnet.be'
            )
        );

        $this->assertEquals(
            $correctToken,
            $token
        );
    }
}
