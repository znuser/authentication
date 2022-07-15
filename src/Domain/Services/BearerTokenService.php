<?php

namespace ZnUser\Authentication\Domain\Services;

use ZnUser\Authentication\Domain\Entities\TokenEntity;
use ZnUser\Authentication\Domain\Entities\TokenValueEntity;
use ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface;
use ZnUser\Authentication\Domain\Interfaces\Repositories\TokenRepositoryInterface;
use ZnUser\Authentication\Domain\Interfaces\Services\TokenServiceInterface;
use ZnCore\Contract\Common\Exceptions\NotFoundException;
use ZnCore\Text\Libs\RandomString;

class BearerTokenService implements TokenServiceInterface
{

    private $tokenRepository;
    private $tokenLength = 64;

    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function getTokenLength(): int
    {
        return $this->tokenLength;
    }

    public function setTokenLength(int $tokenLength): void
    {
        $this->tokenLength = $tokenLength;
    }

    public function getTokenByIdentity(IdentityEntityInterface $identityEntity): TokenValueEntity
    {
        $token = $this->generateToken();

        try {
            $tokenEntity = $this->tokenRepository->findOneByValue($token, 'bearer');
        } catch (NotFoundException $exception) {
            $tokenEntity = new TokenEntity();
            $tokenEntity->setIdentityId($identityEntity->getId());
            $tokenEntity->setType('bearer');
            $tokenEntity->setValue($token);
            $this->tokenRepository->create($tokenEntity);
        }
        $resultTokenEntity = new TokenValueEntity($token, 'bearer', $identityEntity->getId());
        $resultTokenEntity->setId($tokenEntity->getId());
//        $resultTokenEntity->setIdentity($identityEntity);
        return $resultTokenEntity;
    }

    public function getIdentityIdByToken(string $token): int
    {
        list($tokenType, $tokenValue) = explode(' ', $token);
        $tokenEntity = $this->tokenRepository->findOneByValue($tokenValue, 'bearer');
        return $tokenEntity->getIdentityId();
    }

    private function generateToken(): string
    {
        $random = new RandomString();
        $random->setLength($this->tokenLength);
        $random->addCharactersAll();
        return $random->generateString();
    }
}
