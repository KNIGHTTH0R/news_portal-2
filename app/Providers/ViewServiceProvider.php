<?php

namespace App\Providers;

use App\Models\{
    Advertisement, Category, News, Tag
};
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('public.*', function($view)
        {
            $view
                ->with('category', Category::with('news')->latest()->get()->map(function ($category) {
                    return $category = $category->news->take(5);
                }))
                ->with('analytical', News::where('analytical', 1)->latest()->limit(5)->get())
                ->with('adv_left', Advertisement::where('block_side', 'left')->get())
                ->with('adv_right', Advertisement::where('block_side', 'right')->get())
                ->with('tags_filter', Tag::pluck('name', 'id'))
                ->with('category_filter', Category::pluck('name', 'id'));

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
