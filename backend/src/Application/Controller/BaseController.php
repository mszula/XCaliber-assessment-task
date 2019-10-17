<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Exception\ModelValidationException;
use App\Application\Validator\ModelValidator;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /** @var CommandBus */
    private $commandBus;

    /** @var ModelValidator */
    private $modelValidator;

    public function __construct(CommandBus $commandBus, ModelValidator $modelValidator)
    {
        $this->commandBus = $commandBus;
        $this->modelValidator = $modelValidator;
    }

    protected function handleCommand($command): void
    {
        $this->commandBus->handle($command);
    }

    /** @throws ModelValidationException */
    protected function validateModel($model, $groups = null): void
    {
        $validationErrors = $this->modelValidator->validate($model, $groups);

        if (count($validationErrors) > 0) {
            throw ModelValidationException::withErrors($validationErrors);
        }
    }
}
