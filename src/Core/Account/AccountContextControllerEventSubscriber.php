<?php


namespace App\Core\Account;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AccountContextControllerEventSubscriber implements EventSubscriberInterface
{
    private AccountContextService $service;

    public function __construct(AccountContextService $service)
    {
        $this->service = $service;
    }

    public function onKernelController(ControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $controller = $event->getController();
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof AccountContextController) {
            $accountId = $event->getRequest()->attributes->get(AccountContextController::ACCOUNT_ID_ROUTE_PARAMETER);
            $this->service->switchAccount($accountId);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
