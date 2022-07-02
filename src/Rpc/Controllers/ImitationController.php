<?php

namespace ZnUser\Authentication\Rpc\Controllers;

use App\User\Domain\Forms\AuthImitationForm;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseRpcController;
use ZnUser\Authentication\Domain\Entities\TokenValueEntity;
use ZnUser\Authentication\Domain\Interfaces\Services\ImitationAuthServiceInterface;

class ImitationController extends BaseRpcController
{

    protected $service = null;

    public function __construct(ImitationAuthServiceInterface $service)
    {
        $this->service = $service;
    }

    public function attributesOnly(): array
    {
        return [
            'token',
            'identity.id',
//            'identity.logo',
            'identity.statusId',
            'identity.username',
            'identity.roles',
//            'identity.assignments',
        ];
    }

    public function imitation(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new AuthImitationForm();
        EntityHelper::setAttributes($form, $requestEntity->getParams());
        /** @var TokenValueEntity $tokenEntity */
        $tokenEntity = $this->service->tokenByImitation($form);
        $result = [];
        $result['token'] = $tokenEntity->getTokenString();
        $result['identity'] = $tokenEntity->getIdentity();
        return $this->serializeResult($result);
    }
}
