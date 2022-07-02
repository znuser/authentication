<?php

use ZnUser\Authentication\Rpc\Controllers\ImitationController;
use ZnUser\Authentication\Domain\Enums\Rbac\UserImitationPermissionEnum;

return [
    [
        'method_name' => 'authentication.getTokenByImitation',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => UserImitationPermissionEnum::IMITATION,
        'handler_class' => ImitationController::class,
        'handler_method' => 'imitation',
        'status_id' => 100,
        'title' => null,
        'description' => null,
    ],
];