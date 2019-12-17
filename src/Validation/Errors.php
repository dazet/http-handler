<?php declare(strict_types=1);

namespace Dazet\Http\Validation;

use GW\Value\AssocValue;
use GW\Value\Wrap;

final class Errors
{
    /** @var AssocValue<string, Error> */
    private $errorsMap;

    public function __construct(Error ...$errors)
    {
        $this->errorsMap = Wrap::assocArray($errors)
            ->mapKeys(
                static function ($_, Error $e): string {
                    return $e->path();
                }
            );
    }

    public function count()
    {
        return $this->errorsMap->count();
    }
}
