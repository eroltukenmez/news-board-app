<?php

namespace App\Services\Factories;

use App\Services\NewsSources\GuardianSource;
use App\Services\NewsSources\NewsAPISource;
use App\Services\NewsSources\NewYorkTimesSource;
use Illuminate\Contracts\Container\Container;

class NewsSourceFactory
{
    /**
     * @throws \Exception
     */
    public static function getSourceByName(string $name)
    {
        $newsSources = \App::make('newsSources');
        if ( isset($newsSources[$name]) )
            return new $newsSources[$name];

        throw new \Exception('Source not found');
    }

    public static function getAllSource():array
    {
        return \App::make('newsSources');
    }

    public static function getAllSourceName():array
    {
        $keys = array_keys(\App::make('newsSources'));
        $sources = [];
        foreach ($keys as $key) {
            $sources[$key] = \Str::of($key)->replace('-', ' ')->title();
        }

        return $sources;
    }

}
