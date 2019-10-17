<?php

declare(strict_types=1);

namespace spec\App\Application\ArgumentResolver;

use App\Application\Request\MakeDepositRequest;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RequestDtoValueResolverSpec extends ObjectBehavior
{
    public const TEST_JSON = '{
          "amount": 10
        }';

    public function let(): void
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonDecode()]);
        $this->beConstructedWith($serializer);
    }

    public function it_should_resolve_request()
    {
        $request = new Request([], [], [], [], [], ['CONTENT_TYPE' => 'application/json'], self::TEST_JSON);
        $argumentMetadata = new ArgumentMetadata('address', MakeDepositRequest::class, false, false, null);
        $object = $this->resolve($request, $argumentMetadata);

        $object->current()->shouldBeAnInstanceOf(MakeDepositRequest::class);
        $object->current()->amount->shouldBe(10);
    }

}