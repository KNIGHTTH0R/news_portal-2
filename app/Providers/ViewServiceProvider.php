<?php

namespace App\Providers;

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
//            $view
//                ->with('category', \App\Models\Category::with('news')->latest()->get())
//                ->with('analytical', \App\Models\News::where('analytical', 1)->latest()->get());


            $view
                ->with('category', \App\Models\Category::with('news')->latest()->get()->map(function ($category) {
                    return $category = $category->news->take(5);
                }))
                ->with('analytical', \App\Models\News::where('analytical', 1)->latest()->limit(5)->get());
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
