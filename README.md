# Http Request Handler

```php

use DataMap\Output\ObjectConstructor;
use Dazet\Http\Symfony\RequestHandler;
use Dazet\Http\Validation\Errors;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequestParam
{
    /** @var int */
    private $page;

    /** @var int */
    private $limit;

    /** @var string */
    private $id;

    public function __construct(int $page, int $limit, string $id)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->id = $id;
    }
}

final class ExampleAction
{
    /** @var RequestHandler */
    private $handler;

    public function __construct(RequestHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): Response
    {
        return $this->handler
            ->map([
                'page' => 'query.page | int',
                'limit' => 'query.limit | int',
                'id' => 'request.id | string',
            ])
            ->format(new ObjectConstructor(RequestParam::class))
            ->then(function (RequestParam $param): Response {
                return new Response('OK');
            })
            ->else(function (Errors $errors): Response {
                return new Response('FAIL', Response::HTTP_BAD_REQUEST);
            })
            ->handle($request);
    }
}

```
