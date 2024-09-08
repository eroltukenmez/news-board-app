<?php

namespace App\Contracts;

use App\Services\Models\NewsParams;

interface NewsParamsInterface
{
    /**
     * @return array
     */
    public function applyParam(): array;
}
