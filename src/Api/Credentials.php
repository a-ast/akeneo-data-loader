<?php

namespace Aa\AkeneoDataLoader\Api;

class Credentials
{
    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    public function __construct(string $baseUri, string $clientId, string $secret, string $username, string $password)
    {
        $this->baseUri = $baseUri;
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->username = $username;
        $this->password = $password;
    }

    public static function create(string $baseUri, string $clientId, string $secret, string $username, string $password)
    {
        return new static($baseUri, $clientId, $secret, $username, $password);
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
