<?php

declare(strict_types=1);

namespace App\Application\Validator;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ModelValidator
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validates given model and return errors as array if any.
     */
    public function validate($model, $groups = null): array
    {
        $validation = $this->validator->validate($model, null, $groups);
        if ($validation->count() > 0) {
            $errors = [];
            /** @var ConstraintViolation $error */
            foreach ($validation as $error) {
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }

            return $errors;
        }

        return [];
    }
}
