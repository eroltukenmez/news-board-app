<?php

namespace App\Services\NewsParams;

use App\Contracts\NewsParamsInterface;
use App\Services\Models\NewsParams;

readonly class NewsAPIParams implements NewsParamsInterface
{

    public function __construct(
        public NewsParams $params
    ){}

    /**
     * @inheritDoc
     */
    public function applyParam(): array
    {
        $sort = [
            'newest'    => 'publishedAt',
            'relevancy' => 'relevancy'
        ];

        $params = [
            'apiKey' => config('services.news_api.key'),
            'pageSize' => $this->params->pageSize ?? 10,
            'page' => $this->params->page ?? 1,
            'q' => '',
            'sortBy' => $sort[$this->params->sortBy ?? 'newest'],
            'from' => $this->params->startDate,
            'to' => $this->params->endDate,
        ];

        if (!empty($this->params->search))
            $params['q'] = $this->params->search;

        if (!empty($this->params->category))
            $params['q'] .= (empty($params['q']) ? '' : ' AND ') . $this->params->category;

        if (empty($params['q']))
            $params['q'] = '*';

        return collect($params)
            ->filter()
            ->toArray();
    }
}
