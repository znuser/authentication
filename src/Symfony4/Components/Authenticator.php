<?php

namespace ZnUser\Authentication\Symfony4\Components;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use ZnBundle\User\Domain\Entities\User;
use ZnBundle\User\Domain\Services\AuthService;
use ZnCore\Base\Develop\Helpers\DeprecateHelper;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnLib\Components\Http\Enums\HttpHeaderEnum;

DeprecateHelper::hardThrow();

class Authenticator
{

    private $security;
    private $authService;

    public function __construct(Security $security, AuthService $authService)
    {
        $this->security = $security;
        $this->authService = $authService;
    }

    public function getUser(Request $request = null)
    {
        if ($this->isAuthenticated()) {
            $userEntity = $this->security->getToken()->getUser();
        } else {
            $request = $request ?: Request::createFromGlobals();
            $token = $request->query->get(HttpHeaderEnum::AUTHORIZATION) OR $request->request->get(HttpHeaderEnum::AUTHORIZATION);
            if (empty($token)) {
                throw new UnauthorizedHttpException('Empty token!');
            }
            try {
                $userEntity = $this->authService->authenticationByToken($token);
                $this->security->getToken()->setUser($userEntity);
            } catch (NotFoundException $e) {
                throw new UnauthorizedHttpException('User not found!');
            }
        }
        return $userEntity;
    }

    public function isAuthenticated()
    {
        return $this->security->getToken()->getUser() instanceof UserInterface;
    }
}