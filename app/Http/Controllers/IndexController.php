<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, News};
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    public function index()
    {
        $category = Category::with('news')->get();

        $slide = News::latest()->limit(3)->get(['title', 'img_title']);

        return view('public.index', compact('category', 'slide'));
    }

    public function show($category, $slug, News $news)
    {
        if (preg_match( '/[\p{Cyrillic}]/u', $slug)){
            $slug = str_slug($slug);
        }
        $news = $news->where('slug', $slug)->first();

        return view('public.show', compact('news'));
    }
}
