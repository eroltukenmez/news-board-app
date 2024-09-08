<?php

namespace App\Services\NewsParams;

use App\Contracts\NewsParamsInterface;
use App\Services\Models\NewsParams;

readonly class GuardianParams implements NewsParamsInterface
{
    public function __construct(
        public NewsParams $params
    ){}

    public function applyParam(): array
    {
        $params = [
            'api-key' => config('services.guardian.key'),
            'show-fields' => 'bodyText,thumbnail',
            'q'       => $this->params->search,
            'orderBy' => $this->params->sortBy,
            'section' => $this->params->category
        ];

        return collect($params)
            ->filter()
            ->toArray();
    }
}
