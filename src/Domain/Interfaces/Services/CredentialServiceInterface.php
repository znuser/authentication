<?php

namespace ZnUser\Authentication\Domain\Interfaces\Services;

use ZnUser\Authentication\Domain\Entities\CredentialEntity;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;

interface CredentialServiceInterface
{
    /**
     * @param int $identityId
     * @param string $type
     * @return CredentialEntity
     * @throws NotFoundException
     */
    public function findOneByIdentityIdAndType(int $identityId, string $type): CredentialEntity;

    /**
     * @param string $credential
     * @return CredentialEntity
     * @throws NotFoundException
     */
    public function findOneByCredentialValue(string $credential): CredentialEntity;

    public function hasByCredentialValue(string $credential): bool;
}

