<?php declare(strict_types=1);

namespace Dazet\Http\Symfony\Map;

use DataMap\Input\Input;
use Symfony\Component\HttpFoundation\ParameterBag;

final class ParameterBagInput implements Input
{
    /** @var ParameterBag */
    private $parameters;

    public function __construct(ParameterBag $parameters)
    {
        $this->parameters = $parameters;
    }

    public function get(string $key, $default = null)
    {
        return $this->parameters->get($key, $default);
    }

    public function has(string $key): bool
    {
        return $this->parameters->has($key);
    }
}
