<?php

namespace App\EventSubscriber;

use App\DTO\ProductRequest;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateRequestSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerArgumentsEvent::class => 'onControllerArguments',
        ];
    }

    public function onControllerArguments(ControllerArgumentsEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isJsonRequest($request)) {
            return;
        }

        // Detect the DTO class from attributes (you can modify this logic for different use cases)
        $dtoClass = $request->attributes->get('_dto');
        if (!$dtoClass) {
            return;
        }

        // Deserialize the request into the DTO
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            $dtoClass,
            'json'
        );

        // Validate the DTO
        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            throw new BadRequestHttpException((string) $violations);
        }

        // Replace the request attribute with the DTO
        $request->attributes->set('validatedDto', $dto);
    }

    private function isJsonRequest(Request $request): bool
    {
        return $request->getContentType() === 'json';
    }
}
