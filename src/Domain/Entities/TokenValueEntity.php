<?php

namespace ZnUser\Authentication\Domain\Entities;

use ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface;

class TokenValueEntity
{

    private $id;
    private $token;
    private $type;
    private $identityId;
    private $tokenString;
    private $identity;

    public function __construct(string $token = null, string $type = null, int $identityId = null)
    {
        $this->token = $token;
        $this->type = $type;
        $this->identityId = $identityId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getIdentityId()
    {
        return $this->identityId;
    }

    public function setIdentityId($identityId): void
    {
        $this->identityId = $identityId;
    }

    public function getIdentity(): IdentityEntityInterface
    {
        return $this->identity;
    }

    public function setIdentity($identity): void
    {
        $this->identity = $identity;
    }

    public function getTokenString()
    {
        if (empty($this->token)) {
            return null;
        }
        if (empty($this->type)) {
            return $this->token;
        }
        return $this->type . " " . $this->token;
    }

}
