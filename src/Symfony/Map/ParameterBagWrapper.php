<?php declare(strict_types=1);

namespace Dazet\Http\Symfony\Map;

use DataMap\Input\Input;
use DataMap\Input\Wrapper;
use Symfony\Component\HttpFoundation\ParameterBag;

final class ParameterBagWrapper implements Wrapper
{
    public function supportedTypes(): array
    {
        return [ParameterBag::class];
    }

    /**
     * @param ParameterBag $data
     */
    public function wrap($data): Input
    {
        return new ParameterBagInput($data);
    }
}
