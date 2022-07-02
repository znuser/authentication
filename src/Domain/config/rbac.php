<?php

use ZnUser\Authentication\Domain\Enums\Rbac\AppUserPermissionEnum;
use ZnUser\Authentication\Domain\Enums\Rbac\UserImitationPermissionEnum;
use ZnUser\Rbac\Domain\Enums\Rbac\SystemRoleEnum;

return [
    'roleEnums' => [

    ],
    'permissionEnums' => [
        AppUserPermissionEnum::class,
        UserImitationPermissionEnum::class,
    ],
    'inheritance' => [
        SystemRoleEnum::GUEST => [
            AppUserPermissionEnum::AUTHENTICATION_WEB_LOGIN,
            AppUserPermissionEnum::AUTHENTICATION_GET_TOKEN_BY_PASSWORD,
        ],
        SystemRoleEnum::USER => [
            AppUserPermissionEnum::AUTHENTICATION_WEB_LOGOUT,
        ],
        SystemRoleEnum::ADMINISTRATOR => [
            UserImitationPermissionEnum::IMITATION,
        ],
    ],
];
