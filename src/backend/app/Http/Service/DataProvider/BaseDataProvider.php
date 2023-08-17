<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider;

use Illuminate\Support\Collection;

abstract class BaseDataProvider
{
    /**
     * @return Collection of Transaction objects
     */
    abstract public function getData(): Collection;
}
