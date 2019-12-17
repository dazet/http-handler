<?php declare(strict_types=1);

namespace tests\Dazet\Http\Symfony;

use DataMap\Input\FilteredWrapper;
use DataMap\Mapper;
use DataMap\Output\ObjectConstructor;
use Dazet\Http\Symfony\Map\ParameterBagWrapper;
use Dazet\Http\Symfony\Map\RequestWrapper;
use Dazet\Http\Symfony\RequestHandler;
use Dazet\Http\Validation\ResultFormatter;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequestHandlerTest extends TestCase
{
    function test_handles_request()
    {
        $mapper = new Mapper(
            [],
            new ResultFormatter(),
            FilteredWrapper::default()->withWrappers(new RequestWrapper(), new ParameterBagWrapper())
        );

        $handler = new RequestHandler($mapper);
        $goodResponse = new Response();

        $request = new Request(['page' => '7', 'limit' => '100'], ['id' => 'xxx']);

        $actualResponse = $handler
            ->map([
                'page' => 'query.page | int',
                'limit' => 'query.limit | int',
                'id' => 'request.id | string',
            ])
            ->format(new ObjectConstructor(RequestParam::class))
            ->then(function (RequestParam $_) use ($goodResponse): Response {
                return $goodResponse;
            })
            ->else(function () {
                throw new LogicException('Should not call else');
            })
            ->handle($request);

        self::assertSame($goodResponse, $actualResponse);
    }
}

class RequestParam
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
