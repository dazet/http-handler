<?php declare(strict_types=1);

namespace Dazet\Http\Symfony;

use DataMap\Mapper;
use DataMap\Output\ArrayFormatter;
use DataMap\Output\Formatter;
use Dazet\Http\Validation\Result;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequestHandler
{
    /** @var Mapper */
    private $mapper;

    /** @var Formatter */
    private $formatter;

    /** @var callable */
    private $then;

    /** @var callable */
    private $else;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
        $this->formatter = new ArrayFormatter();
        $this->then = function (): Response {
            return new Response();
        };
        $this->else = function (): Response {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        };
    }

    public function map(iterable $map): self
    {
        $clone = clone $this;
        $clone->mapper = $this->mapper->withAddedMap($map);

        return $clone;
    }

    public function format(Formatter $formatter): self
    {
        $clone = clone $this;
        $clone->formatter = $formatter;

        return $clone;
    }

    public function then(callable $action): self
    {
        $clone = clone $this;
        $clone->then = $action;

        return $clone;
    }

    public function else(callable $errorHandler): self
    {
        $clone = clone $this;
        $clone->else = $errorHandler;

        return $clone;
    }

    public function handle(Request $request): Response
    {
        /** @var Result $result */
        $result = $this->mapper->map($request);

        if ($result->isValid()) {
            $data = $this->formatter->format($result->data());

            return ($this->then)($data, $request);
        }

        return ($this->else)($result->errors(), $request);
    }
}
