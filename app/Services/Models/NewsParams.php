<?php

namespace App\Services\Models;

class NewsParams
{
    public function __construct(
        public ?string $search = null,
        public ?string $sortBy = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $category = null
    ) {}
}
