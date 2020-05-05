<?php


namespace App\Core\Rest\EventSubscriber;


use App\Core\Domain\Exception\NotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class KernelExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        $response->setStatusCode($this->getStatusCode($exception));
        $response->setData($this->getErrorMessage($exception, $response));
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        $event->setResponse($response);
    }

    private function getStatusCode(Throwable $exception): int
    {
        return $this->determineStatusCode($exception);
    }

    private function getErrorMessage(Throwable $exception, Response $response): array
    {
        $error = [
            'errors' => [
                'title' => \str_replace('\\', '.', \get_class($exception)),
                'detail' => $this->getExceptionMessage($exception),
                'code' => $exception->getCode(),
                'status' => $response->getStatusCode(),
            ],
        ];

        if ('dev' === $this->environment) {
            $error = \array_merge(
                $error,
                [
                    'meta' => [
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'message' => $exception->getMessage(),
                        'trace' => $exception->getTrace(),
                        'traceString' => $exception->getTraceAsString(),
                    ],
                ]
            );
        }

        return $error;
    }

    private function getExceptionMessage(Throwable $exception): string
    {
        return $exception->getMessage();
    }

    private function determineStatusCode(Throwable $exception): int
    {
        // Default status code is always 500
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        switch (true) {
            case $exception instanceof HttpExceptionInterface:
                $statusCode = $exception->getStatusCode();
                break;
            case $exception instanceof NotFoundException:
                $statusCode = Response::HTTP_NOT_FOUND;
                break;
            case $exception instanceof \InvalidArgumentException:
                $statusCode = Response::HTTP_BAD_REQUEST;
                break;
        }

        return $statusCode;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function __construct()
    {
        $this->environment = (string) \getenv('APP_ENV') ?? 'dev';
    }

    private string $environment;
}
