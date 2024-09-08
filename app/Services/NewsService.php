<?php

namespace App\Services;

use App\Contracts\NewsSourceInterface;
use App\Services\Factories\ParamsBuilderFactory;
use App\Services\Models\NewsParams;

class NewsService
{
    public function __construct(
        protected array $allNewsSources = []
    ){}

    public function getNews(array $sources,NewsParams $params):array
    {
        $news = [];
        foreach ($sources as $source) {
            if ($source instanceof NewsSourceInterface){
                $queryParams = ParamsBuilderFactory::create($source,$params);
                /*$news = \Cache::remember(
                    $source::class . '-' . md5(json_encode($queryParams)),
                    now()->addMinutes(2),
                    fn() => [...$news, ...$source->fetchNews($queryParams)]
                );*/
                $news = [...$news, ...$source->fetchNews($queryParams)];
            }
        }

        return $news;
    }

    public function getAllNews():array
    {
        return $this->getNews($this->allNewsSources,new NewsParams());
    }

    public function getAllNewsWithParams(NewsParams $params):array
    {
        return $this->getNews($this->allNewsSources,$params);
    }
}
