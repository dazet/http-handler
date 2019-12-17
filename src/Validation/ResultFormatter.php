<?php declare(strict_types=1);

namespace Dazet\Http\Validation;

use DataMap\Output\Formatter;

final class ResultFormatter implements Formatter
{
    public function format(array $output): Result
    {
        return new Result($output, new Errors());
    }
}
