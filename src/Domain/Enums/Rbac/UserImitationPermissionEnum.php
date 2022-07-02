<?php

namespace ZnUser\Authentication\Domain\Enums\Rbac;

use ZnCore\Base\Enum\Interfaces\GetLabelsInterface;

class UserImitationPermissionEnum implements GetLabelsInterface
{

    public const IMITATION = 'oUserImitationImitation';

    public static function getLabels()
    {
        return [
            self::IMITATION => 'Пользователь. Имитация аутентификации',
        ];
    }
}
