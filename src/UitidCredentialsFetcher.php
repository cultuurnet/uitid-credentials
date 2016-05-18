<?php

namespace CultuurNet\UitidCredentials;

use \CultuurNet\Auth\Guzzle\OAuthProtectedService;
use CultuurNet\UitidCredentials\Entities\Consumer;
use CultuurNet\UitidCredentials\Entities\Token;

class UitidCredentialsFetcher extends OAuthProtectedService implements UitidCredentialsService
{
    /**
     * @inheritdoc
     */
    public function getConsumer($consumerKey)
    {
        $client = $this->getClient();
        $request = $client->get('/uitid/rest/authapi/consumer/' . $consumerKey);
        $consumer = null;

        $response = $request->send();
        $xmlElement = new \SimpleXMLElement($response->getBody(true));

        if (!empty($xmlElement->consumer)) {
            $consumer = Consumer::parseFromXml($xmlElement->consumer);
        }

        return $consumer;
    }

    /**
     * @inheritdoc
     */
    public function getAccessToken($tokenKey)
    {
        return $this->getAccessTokenFromPath('/uitid/rest/authapi/accesstoken/' . $tokenKey);
    }

    /**
     * @inheritdoc
     */
    public function getAccessTokenFromJwt($jwt)
    {
        $jwt = (string) $jwt;
        return $this->getAccessTokenFromPath('/uitid/rest/authapi/jwt2at?jwt=' . $jwt);
    }

    /**
     * @param string $path
     * @return Token|null
     */
    private function getAccessTokenFromPath($path)
    {
        $client = $this->getClient();
        $request = $client->get($path);
        $consumer = null;

        $response = $request->send();
        $xmlElement = new \SimpleXMLElement($response->getBody(true));

        if (!empty($xmlElement->token)) {
            $consumer =  Token::parseFromXml($xmlElement->token);
        }

        return $consumer;
    }
}
