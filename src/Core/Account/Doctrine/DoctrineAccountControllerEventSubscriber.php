<?php


namespace App\Core\Account\Doctrine;


use App\Core\Account\AccountContextController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DoctrineAccountControllerEventSubscriber implements EventSubscriberInterface
{
    private AccountConnectionContextService $connectionContextService;

    public function __construct(AccountConnectionContextService $connectionContextService)
    {
        $this->connectionContextService = $connectionContextService;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof AccountContextController) {
            $accountId = $event->getRequest()->attributes->get(AccountContextController::ACCOUNT_ID_ROUTE_PARAMETER);
            $this->connectionContextService->switchConnection($accountId);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
