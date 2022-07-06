<?php

namespace ZnUser\Authentication\Domain\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ZnUser\Authentication\Domain\Enums\AuthEventEnum;
use ZnUser\Authentication\Domain\Events\AuthEvent;
use ZnUser\Identity\Domain\Events\IdentityEvent;
use ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface;
use ZnCore\Entity\Helpers\EntityHelper;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\EntityManager\Traits\EntityManagerAwareTrait;

class SymfonyAuthenticationIdentitySubscriber implements EventSubscriberInterface
{

    use EntityManagerAwareTrait;

    private $session;

    public function __construct(
        EntityManagerInterface $em,
        SessionInterface $session
    )
    {
        $this->session = $session;
        $this->setEntityManager($em);
    }

    public static function getSubscribedEvents()
    {
        return [
            AuthEventEnum::BEFORE_GET_IDENTITY => 'onBeforeGetIdentity',
            AuthEventEnum::BEFORE_IS_GUEST => 'onBeforeGuest',
            AuthEventEnum::AFTER_LOGOUT => 'onAfterLogout',
            AuthEventEnum::AFTER_AUTH_SUCCESS => 'onAfterAuthSuccess',
        ];
    }

    public function onAfterAuthSuccess(AuthEvent $event)
    {
        $this->session->set('user.identity', EntityHelper::toArray($event->getIdentityEntity()));
    }

    public function onBeforeGetIdentity(IdentityEvent $event)
    {
        $identity = $this->session->get('user.identity');
        if ($identity) {
            /** @var IdentityEntityInterface $identityEntity */
            $identityEntity = $this->getEntityManager()->createEntity(IdentityEntityInterface::class, $identity);
            $event->setIdentityEntity($identityEntity);
        }
    }

    public function onBeforeGuest(IdentityEvent $event)
    {
        $identity = $this->session->get('user.identity');
        $event->setIsGuest(empty($identity));
    }

    public function onAfterLogout(IdentityEvent $event)
    {
        $this->session->remove('user.identity');
    }
}
