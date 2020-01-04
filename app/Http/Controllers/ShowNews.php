<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use function view;

class ShowNews extends Controller
{
    public function __invoke(News $news)
    {
        return view('news.show', [
            'news' => tap($news->load('comments', 'comments.commentator'))->loadMedia('images')
        ]);
    }
}
