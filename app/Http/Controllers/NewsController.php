<?php

namespace App\Http\Controllers;

use App\Services\Factories\NewsSourceFactory;
use App\Services\Models\NewsParams;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        $title = \Str::of($source)->replace('-', ' ')->title();

        return Inertia::render('Sources',compact('source','title'));
    }

    public function sourceNewsData(string $source, Request $request)
    {
        try {
            $source = NewsSourceFactory::getSourceByName($source);
        }catch (\Exception $exception){
            abort(404,$exception->getMessage());
        }

        $params = new NewsParams(
            page: $request->input('page'),
            pageSize: $request->input('pageSize')
        );

        return $this->service->getNews([ $source ],$params);
    }

    public function categoryNewsData(string $category,Request $request)
    {
        $params = new NewsParams(
            sortBy: $request->input('sortBy'),
            category: $category
        );
        return $this->service->getAllNewsWithParams($params);
    }
}
