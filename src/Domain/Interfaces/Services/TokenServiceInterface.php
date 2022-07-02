<?php

namespace ZnUser\Authentication\Domain\Interfaces\Services;

use ZnUser\Authentication\Domain\Entities\TokenValueEntity;
use ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface;

interface TokenServiceInterface
{

    public function getTokenByIdentity(IdentityEntityInterface $identityEntity): TokenValueEntity;
    public function getIdentityIdByToken(string $token): int;
}
