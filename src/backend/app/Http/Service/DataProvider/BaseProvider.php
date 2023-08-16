<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider;

use Illuminate\Support\Collection;

abstract class BaseProvider
{
    abstract public function getData(): Collection;
}
