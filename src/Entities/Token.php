<?php

namespace CultuurNet\UitidCredentials\Entities;

class Token
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $tokenSecret;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @param null $token
     * @param null $tokenSecret
     * @param null $user
     * @param null $consumer
     */
    public function __construct($token = null, $tokenSecret = null, $user = null, $consumer = null)
    {
        if (!empty($token)) {
            $this->token = $token;
        }

        if (!empty($tokenSecret)) {
            $this->tokenSecret = $tokenSecret;
        }

        if (!empty($user)) {
            $this->user = $user;
        }

        if (!empty($consumer)) {
            $this->consumer = $consumer;
        }
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getTokenSecret()
    {
        return $this->tokenSecret;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param string $tokenSecret
     */
    public function setTokenSecret($tokenSecret)
    {
        $this->tokenSecret = $tokenSecret;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param Consumer $consumer
     */
    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * @param \SimpleXMLElement $xmlElement
     * @return Token
     */
    public static function parseFromXml(\SimpleXMLElement $xmlElement)
    {
        $token = new self();

        if (!empty($xmlElement->token)) {
            $token->setToken((string)$xmlElement->token);
        }

        if (!empty($xmlElement->tokenSecret)) {
            $token->setTokenSecret((string)$xmlElement->tokenSecret);
        }

        if (!empty($xmlElement->user)) {
            $userObject = User::parseFromXml($xmlElement->user);
            $token->setUser($userObject);
        }

        if (!empty($xmlElement->consumer)) {
            $consumerObject = Consumer::parseFromXml($xmlElement->consumer);
            $token->setConsumer($consumerObject);
        }

        return $token;
    }
}
