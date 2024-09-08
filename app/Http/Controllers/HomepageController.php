<?php

namespace App\Http\Controllers;

use App\Services\Factories\NewsSourceFactory;
use Inertia\Inertia;

class HomepageController extends Controller
{
    public function __invoke()
    {
        $categories = [
            'business' => 'Business',
            'sport' => 'Sport',
            'books' => 'Books',
            'education' => 'Education',
            'fashion' => 'Fashion',
            'science' => 'Science'
        ];

        return Inertia::render('Homepage',[
            'categories' => $categories
        ]);
    }
}
