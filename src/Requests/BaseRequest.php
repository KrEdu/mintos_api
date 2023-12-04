<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack
    ) {
        $this->populate();
        $this->validate();
    }

    protected function validate()
    {
        $errors = $this->validator->validate($this);
        if (isset($errors[0])) {
            $message = $errors[0]->getPropertyPath() . ' - ' . $errors[0]->getMessage();
            $response = new JsonResponse([
                'error' => $message
            ]);
            $response->send();
            exit;
        }
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->query->all() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
        return $default;
    }

    public function toArray(): array
    {
        $properties = get_class_vars(get_class($this));
        $data = [];
        foreach ($properties as $name => $value)
        {
            $data[$name] = $value;
        }
        return $data;
    }
}
