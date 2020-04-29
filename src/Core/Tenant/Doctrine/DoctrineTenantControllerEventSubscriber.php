<?php


namespace App\Core\Tenant\Doctrine;


use App\Core\Tenant\TenantContextController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DoctrineTenantControllerEventSubscriber implements EventSubscriberInterface
{
    private TenantConnectionContextService $connectionContextService;

    public function __construct(TenantConnectionContextService $connectionContextService)
    {
        $this->connectionContextService = $connectionContextService;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TenantContextController) {
            $tenantId = $event->getRequest()->attributes->get(TenantContextController::TENANT_ID_ROUTE_PARAMETER);
            $this->connectionContextService->switchConnection($tenantId);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
