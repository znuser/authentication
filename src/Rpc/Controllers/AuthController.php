<?php

namespace ZnUser\Authentication\Rpc\Controllers;

use ZnCore\Code\Helpers\PropertyHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseRpcController;
use ZnUser\Authentication\Domain\Entities\TokenValueEntity;
use ZnUser\Authentication\Domain\Forms\AuthForm;
use ZnUser\Authentication\Domain\Interfaces\Services\AuthServiceInterface;

class AuthController extends BaseRpcController
{

    public function __construct(AuthServiceInterface $authService)
    {
        $this->service = $authService;
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

    public function getTokenByPassword(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new AuthForm();
        PropertyHelper::setAttributes($form, $requestEntity->getParams());
        /** @var TokenValueEntity $tokenEntity */
        $tokenEntity = $this->service->tokenByForm($form);
        $result = [
            'token' => $tokenEntity->getTokenString()
        ];
        return $this->serializeResult($result);
    }

    public function getToken(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new AuthForm();
        PropertyHelper::setAttributes($form, $requestEntity->getParams());
        /** @var TokenValueEntity $tokenEntity */
        $tokenEntity = $this->service->tokenByForm($form);
        $result = [];
        $result['token'] = $tokenEntity->getTokenString();
        $result['identity'] = $tokenEntity->getIdentity();
        return $this->serializeResult($result);
    }
}
