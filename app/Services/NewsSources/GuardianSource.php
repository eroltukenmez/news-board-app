<?php

namespace App\Services\NewsSources;

use App\Contracts\NewsSourceInterface;
use App\Services\Models\NewsItem;
use Illuminate\Support\Facades\Http;

class GuardianSource implements NewsSourceInterface
{
    public function fetchNews(array $params): array
    {
        $response = Http::baseUrl(config('services.guardian.url'))
            ->get('search', $params);

        $news = [];

        foreach ($response->json()['response']['results'] as $item) {
            $news[] = new NewsItem(
                title:$item['webTitle'],
                content: $item['fields']['bodyText'],
                image: $item['fields']['thumbnail'],
                date: $item['webPublicationDate'],
                categories: [ $item['sectionId'] ],
                tags: []
            );
        }
        return $news;
    }
}
