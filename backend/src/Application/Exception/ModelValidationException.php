<?php

declare(strict_types=1);

namespace App\Application\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ModelValidationException extends Exception
{
    /**
     * @var array list of errors from validator
     */
    private $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation Error');
    }

    public static function withErrors(array $errors): self
    {
        return new self($errors);
    }

    public static function withViolations(ConstraintViolationListInterface $constraintViolationList): self
    {
        $errors = [];
        foreach ($constraintViolationList as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return self::withErrors($errors);
    }

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'errors' => $this->errors,
        ];
    }
}
