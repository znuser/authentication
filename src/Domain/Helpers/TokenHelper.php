<?php

namespace ZnUser\Authentication\Domain\Helpers;

use ZnUser\Authentication\Domain\Entities\TokenValueEntity;

class TokenHelper
{

    public static function parseToken(string $token): TokenValueEntity
    {
        list($tokenType, $tokenValue) = explode(' ', $token);
        return new TokenValueEntity($tokenValue, $tokenType);
    }
}
