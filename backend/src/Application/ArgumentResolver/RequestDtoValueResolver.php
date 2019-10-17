<?php

declare(strict_types=1);

namespace App\Application\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class RequestDtoValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() && (0 === \mb_strpos($argument->getType(), 'App\\Application\\Request\\'));
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $requestDtoClass = $argument->getType();
        $format = (string)$request->getContentType();

        $requestDto = $this->serializer->deserialize(
            $request->getContent(),
            $requestDtoClass,
            $format,
        );

        yield $requestDto;
    }
}
