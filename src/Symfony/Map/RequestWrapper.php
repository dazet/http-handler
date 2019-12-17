<?php declare(strict_types=1);

namespace Dazet\Http\Symfony\Map;

use DataMap\Input\Input;
use DataMap\Input\Wrapper;
use Symfony\Component\HttpFoundation\Request;

final class RequestWrapper implements Wrapper
{
    public function supportedTypes(): array
    {
        return [Request::class];
    }

    /**
     * @param Request $data
     * @return Input
     */
    public function wrap($data): Input
    {
        return new RequestInput($data);
    }
}
