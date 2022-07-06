<?php

namespace ZnUser\Authentication\Domain\Services;

use ZnUser\Authentication\Domain\Entities\CredentialEntity;
use ZnUser\Authentication\Domain\Interfaces\Repositories\CredentialRepositoryInterface;
use ZnUser\Authentication\Domain\Interfaces\Services\CredentialServiceInterface;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnCore\Domain\Service\Base\BaseService;

class CredentialService extends BaseService implements CredentialServiceInterface
{

    public function __construct(CredentialRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function findOneByIdentityIdAndType(int $identityId, string $type): CredentialEntity
    {
        $all = $this->getRepository()->allByIdentityId($identityId, [$type]);
        if ($all->count() == 0) {
            throw new NotFoundException();
        }
        return $all->first();
    }

    public function findOneByCredentialValue(string $credential): CredentialEntity
    {
        return $this->getRepository()->findOneByCredentialValue($credential);
    }

    public function hasByCredentialValue(string $credential): bool
    {
        try {
            $this->findOneByCredentialValue($credential);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }
}
