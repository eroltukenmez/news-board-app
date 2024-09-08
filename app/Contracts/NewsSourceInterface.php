<?php

namespace App\Contracts;

use App\Services\Models\NewsParams;

interface NewsSourceInterface
{
    public function fetchNews(array $params): array;
}
