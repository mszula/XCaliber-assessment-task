<?php

declare(strict_types=1);

namespace App\Application\EventSubscriber;

use App\Application\Exception\ModelValidationException;
use App\Domain\Exception\DomainException;
use App\ReadModel\Exception\ResourceNotFound;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof ModelValidationException) {
            $event->setResponse($this->onValidationException($exception));
        } elseif ($exception instanceof ResourceNotFound) {
            $event->setResponse($this->onResourceNotFound($exception));
        } elseif ($exception instanceof DomainException) {
            $event->setResponse($this->onDomainException($exception));
        }elseif ($exception instanceof HttpException) {
            $event->setResponse($this->onHttpException($exception));
        } else {
            $event->setResponse(
                new JsonResponse(
                    ['message' => $exception->getMessage()],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }

    private function onValidationException(ModelValidationException $exception): JsonResponse
    {
        $errors = $exception->toArray();
        $normalizedErrors = [];
        foreach ($errors['errors'] as $key => $value) {
            $normalizedErrors[Inflector::tableize((string)$key)] = $value;
        }
        $errors['errors'] = $normalizedErrors;
        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }

    private function onResourceNotFound(ResourceNotFound $exception): JsonResponse
    {
        return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
    }

    private function onHttpException(HttpException $exception): JsonResponse
    {
        return new JsonResponse(['message' => $exception->getMessage()], $exception->getStatusCode());
    }

    private function onDomainException(DomainException $exception): JsonResponse
    {
        return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
    }
}
