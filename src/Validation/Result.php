<?php declare(strict_types=1);

namespace Dazet\Http\Validation;

final class Result
{
    /** @var array */
    private $data;

    /** @var Errors */
    private $errors;

    public function __construct(array $data, Errors $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function errors(): Errors
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return $this->errors->count() === 0;
    }
}
