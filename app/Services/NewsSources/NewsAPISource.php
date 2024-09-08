<?php

namespace App\Services\NewsSources;

use App\Contracts\NewsSourceInterface;
use App\Services\Models\NewsItem;
use Illuminate\Support\Facades\Http;


class NewsAPISource implements NewsSourceInterface
{

    public function fetchNews(array $params): array
    {
        $response = Http::baseUrl(config('services.news_api.url'))
            ->get('everything', $params);

        $news = [];
        foreach ($response->json()['articles'] as $item) {
            $news[] = new NewsItem(
                title:$item['title'],
                content: $item['content'],
                image:$item['urlToImage'],
                date: $item['publishedAt'],
                categories: [],
                tags: []
            );
        }
        return $news;
    }
}
