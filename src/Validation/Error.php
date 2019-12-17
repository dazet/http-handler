<?php declare(strict_types=1);

namespace Dazet\Http\Validation;

final class Error
{
    /** @var string */
    private $path;

    /** @var string */
    private $constraint;

    public function __construct(string $path, string $constraint)
    {
        $this->path = $path;
        $this->constraint = $constraint;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function constraint(): string
    {
        return $this->constraint;
    }
}
