<?php

namespace App\Http\Controllers;

use App\Services\Factories\NewsSourceFactory;
use App\Services\Models\NewsParams;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        protected NewsService $service
    )
    {}

    public function all()
    {
        return $this->service->getAllNews();
    }

    public function sources(string $source)
    {
        try {
            $source = NewsSourceFactory::getSourceByName($source);
        }catch (\Exception $exception){
            abort(404,$exception->getMessage());
        }

        return $this->service->getNews([ $source ],new NewsParams());
    }

    public function category(string $category,Request $request)
    {
        $params = new NewsParams(
            sortBy: $request->input('sortBy'),
            category: $category
        );
        return $this->service->getAllNewsWithParams($params);
    }
}
