<?php

use ZnUser\Authentication\Domain\Enums\Rbac\AuthenticationPermissionEnum;
use ZnUser\Authentication\Rpc\Controllers\AuthController;

return [
    [
        'method_name' => 'authentication.getTokenByPassword',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => AuthenticationPermissionEnum::AUTHENTICATION_GET_TOKEN_BY_PASSWORD,
        'handler_class' => AuthController::class,
        'handler_method' => 'getTokenByPassword',
        'status_id' => 100,
        'title' => null,
        'description' => null,
    ],
    [
        'method_name' => 'authentication.getToken',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => AuthenticationPermissionEnum::AUTHENTICATION_GET_TOKEN_BY_PASSWORD,
        'handler_class' => AuthController::class,
        'handler_method' => 'getToken',
        'status_id' => 100,
        'title' => null,
        'description' => null,
    ],
];