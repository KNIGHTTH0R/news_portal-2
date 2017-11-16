<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Category, Comment, News
};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    public function index()
    {
        $category = Category::with('news')->get();

        $slide = News::with('category')->latest()->limit(3)->get(['title', 'img_title', 'slug', 'category_id']);

        return view('public.index', compact('category', 'slide'));
    }

    public function show($category, $slug, News $news)
    {
        if (preg_match( '/[\p{Cyrillic}]/u', $slug)){

            $slug = str_slug($slug);
        }

        $news = $news->where('slug', $slug)->first();

        if(is_null($news)){

            return abort('404');
        }

        $category = Category::with('news')->get();

        $comment_count = count($news->comment);

        foreach($news->comment()->withTrashed()->where('parent_id', null)->get() as $comment){

            if ($comment->trashed()){

                if ($comment->child->isEmpty()){

                    $comment->child()->forceDelete();
                    $comment->forceDelete();
                }
            }
        }

        return view('public.show', compact('news', 'category', 'comment_count'));
    }

    public function newsFromCategory($slug, Category $category)
    {
        $news = $category->where('slug', $slug)->get()->first()->news;


        return view('public.news.index', compact('news'));
    }
}
