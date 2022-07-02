<?php

use ZnUser\Authentication\Domain\Enums\Rbac\AuthenticationPermissionEnum;
use ZnUser\Authentication\Domain\Enums\Rbac\ImitationAuthenticationPermissionEnum;
use ZnUser\Rbac\Domain\Enums\Rbac\SystemRoleEnum;

return [
    'roleEnums' => [

    ],
    'permissionEnums' => [
        AuthenticationPermissionEnum::class,
        ImitationAuthenticationPermissionEnum::class,
    ],
    'inheritance' => [
        SystemRoleEnum::GUEST => [
            AuthenticationPermissionEnum::AUTHENTICATION_WEB_LOGIN,
            AuthenticationPermissionEnum::AUTHENTICATION_GET_TOKEN_BY_PASSWORD,
        ],
        SystemRoleEnum::USER => [
            AuthenticationPermissionEnum::AUTHENTICATION_WEB_LOGOUT,
        ],
        SystemRoleEnum::ADMINISTRATOR => [
            ImitationAuthenticationPermissionEnum::IMITATION,
        ],
    ],
];
