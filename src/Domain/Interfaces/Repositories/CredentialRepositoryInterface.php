<?php

namespace ZnUser\Authentication\Domain\Interfaces\Repositories;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnUser\Authentication\Domain\Entities\CredentialEntity;
use ZnUser\Authentication\Domain\Enums\CredentialTypeEnum;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;

interface CredentialRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param int $identityId
     * @param array|null $types
     * @return \ZnCore\Domain\Collection\Interfaces\Enumerable | CredentialEntity[]
     */
    public function allByIdentityId(int $identityId, array $types = null): Collection;

    /**
     * @param string $credential
     * @param string $type
     * @return CredentialEntity
     * @throws NotFoundException
     */
    public function findOneByCredential(string $credential, string $type = CredentialTypeEnum::LOGIN): CredentialEntity;

    public function findOneByCredentialValue(string $credential): CredentialEntity;
    
    /**
     * @param string $validation
     * @param string $type
     * @return CredentialEntity
     * @throws NotFoundException
     */
    public function findOneByValidation(string $validation, string $type): CredentialEntity;
}

