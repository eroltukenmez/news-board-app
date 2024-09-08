<?php

namespace App\Services\Models;

class NewsItem
{
    public function __construct(
        public string $title,
        public string $content,
        public ?string $image,
        public string $date,
        public array $categories,
        public array $tags
    ){}

}
