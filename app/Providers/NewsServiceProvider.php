<?php

namespace App\Providers;

use App\Services\NewsSources\GuardianSource;
use App\Services\NewsSources\NewsAPISource;
use App\Services\NewsSources\NewYorkTimesSource;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('newsSources', function ($app) {
            return [
                'news-api' => $app->make(NewsAPISource::class),
                'guardian' => $app->make(GuardianSource::class),
                'new-york-times' => $app->make(NewYorkTimesSource::class),
            ];
        });

        $this->app->singleton(NewsService::class, function ($app) {
            return new NewsService($app->make('newsSources'));
        });
    }

    public function boot()
    {
        //
    }
}
