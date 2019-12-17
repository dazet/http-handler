<?php declare(strict_types=1);

namespace Dazet\Http\Symfony\Map;

use DataMap\Input\Input;
use Symfony\Component\HttpFoundation\Request;
use function in_array;

final class RequestInput implements Input
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $key, $default = null)
    {
        switch ($key) {
            case 'query':
                return $this->request->query;

            case 'request':
            case 'post':
                return $this->request->request;

            case 'headers':
                return $this->request->headers;

            case 'server':
                return $this->request->server;
        }

        return $this->request->get($key, $default);
    }

    public function has(string $key): bool
    {
        return in_array($key, ['query', 'request', 'header', 'server']) || $this->request->get($key, null) !== null;
    }
}
