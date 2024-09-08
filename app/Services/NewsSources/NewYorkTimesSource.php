<?php

namespace App\Services\NewsSources;

use App\Contracts\NewsSourceInterface;

class NewYorkTimesSource implements NewsSourceInterface
{
    public function fetchNews(array $params): array
    {
        return [];
    }
}
