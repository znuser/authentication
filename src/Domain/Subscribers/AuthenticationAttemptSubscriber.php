<?php

namespace ZnUser\Authentication\Domain\Subscribers;

use ZnUser\Authentication\Domain\Enums\UserNotifyTypeEnum;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnBundle\Summary\Domain\Exceptions\AttemptsBlockedException;
use ZnBundle\Summary\Domain\Interfaces\Services\AttemptServiceInterface;
use ZnUser\Authentication\Domain\Enums\AuthEventEnum;
use ZnUser\Authentication\Domain\Events\AuthEvent;
use ZnUser\Authentication\Domain\Interfaces\Services\CredentialServiceInterface;
use ZnCore\Domain\EntityManager\Traits\EntityManagerAwareTrait;
use ZnUser\Notify\Domain\Interfaces\Services\NotifyServiceInterface;

class AuthenticationAttemptSubscriber implements EventSubscriberInterface
{

    use EntityManagerAwareTrait;

    public $action = 'authorization';
    public $attemptCount = 3;
    public $lifeTime = 30;

    private $attemptService;
    private $credentialService;
    private $notifyService;

    public function __construct(
        AttemptServiceInterface $attemptService,
        NotifyServiceInterface $notifyService,
        CredentialServiceInterface $credentialService
    )
    {
        $this->attemptService = $attemptService;
        $this->credentialService = $credentialService;
        $this->notifyService = $notifyService;
    }

    public static function getSubscribedEvents()
    {
        return [
            AuthEventEnum::BEFORE_AUTH => 'onBeforeAuth',
            //AuthEventEnum::AFTER_AUTH_SUCCESS => 'onAfterAuthSuccess',
            AuthEventEnum::AFTER_AUTH_ERROR => 'onAfterAuthError',
        ];
    }

    public function onBeforeAuth(AuthEvent $event)
    {

    }

    /*public function onAfterAuthSuccess(AuthEvent $event)
    {

    }*/

    public function onAfterAuthError(AuthEvent $event)
    {
        $login = $event->getLoginForm()->getLogin();
        $credentialEntity = $this->credentialService->findOneByCredentialValue($login);
        try {
            $this->attemptService->check($credentialEntity->getIdentityId(), $this->action, $this->lifeTime, $this->attemptCount);
            //} catch (NotFoundException $e) {
        } catch (AttemptsBlockedException $e) {
            $this->notifyService->sendNotifyByTypeName(UserNotifyTypeEnum::AUTHENTICATION_ATTEMPT_BLOCK, $credentialEntity->getIdentityId());
            throw $e;
        }
    }
}
