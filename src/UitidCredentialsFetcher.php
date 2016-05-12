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

        $response = $request->send();
        $xmlElement = new \SimpleXMLElement($response->getBody(true));

        if (!empty($xmlElement->consumer)) {
            return Consumer::parseFromXml($xmlElement->consumer);
        }
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
     * @return Token
     */
    private function getAccessTokenFromPath($path)
    {
        $client = $this->getClient();
        $request = $client->get($path);

        $response = $request->send();
        $xmlElement = new \SimpleXMLElement($response->getBody(true));

        if (!empty($xmlElement->token)) {
            return Token::parseFromXml($xmlElement->token);
        }
    }
}
