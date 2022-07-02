<?php

namespace ZnUser\Authentication;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    /*public function deps(): array
    {
        return [
            new \ZnBundle\User\Bundle(['all']),
        ];
    }

    public function symfonyRpc(): array
    {
        return [
            __DIR__ . '/Rpc/config/identity-routes.php',
        ];
    }*/

    public function migration(): array
    {
        return [
            '/vendor/znuser/authentication/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
            __DIR__ . '/Domain/config/container-script.php',
        ];
    }
}
