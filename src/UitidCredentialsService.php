<?php

namespace CultuurNet\UitidCredentials;

use CultuurNet\UitidCredentials\Entities\Consumer;
use CultuurNet\UitidCredentials\Entities\Token;

interface UitidCredentialsService
{
    /**
     * @param string $consumerKey
     * @return Consumer|null
     */
    public function getConsumer($consumerKey);

    /**
     * @param string $tokenKey
     * @return Token|null
     */
    public function getAccessToken($tokenKey);

    /**
     * @param string $jwt
     * @return Token|null
     */
    public function getAccessTokenFromJwt($jwt);
}
