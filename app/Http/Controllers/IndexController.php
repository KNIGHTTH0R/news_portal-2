<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use Illuminate\Http\Request;
use App\Models\{
    Category, Comment, News, Subscribe, Tag
};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    public function index()
    {
        $category = Category::with('news')->get();

        $slide = News::with('category')->latest()->limit(3)->get(['title', 'img_title', 'slug', 'category_id']);

        $newsTop = News::select(['title', 'slug', 'category_id'])->with(['category'])->withCount('comment')->orderBy('comment_count', 'DESC')->limit(3)->get();

        return view('public.index', compact('category', 'slide', 'newsTop'));
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

        $comment_count = $news->comment->where('allowed','!=', '0')->count();

        foreach($news->comment()->withTrashed()->where('parent_id', null)->get() as $comment){

            if ($comment->trashed()){

                if ($comment->child->isEmpty()){

                    $comment->child()->forceDelete();
                    $comment->forceDelete();
                }
            }
        }

        return view('public.news.show', compact('news', 'category', 'comment_count'));
    }

    public function newsFromCategory($slug)
    {

        $news = Category::where('slug', $slug)->first()->news()->paginate(5);

        return view('public.news.index', compact('news'));
    }

    public function newsFromTag($tag, Tag $tags)
    {
        $news = $tags->where('name', $tag)->first()->news()->paginate(5);

        return view('public.news.index', compact('news'));

    }

    public function subscribe(SubscribeRequest $request, Subscribe $subscribe)
    {
        try {

            $subscribe->create($request->except(['_token']));
        } catch (\Exception $e){

            return response(json_encode(['status' => 'error']), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }


    public function searchTag(Request $request)
    {
        $request->validate([
           'tag' => 'required|max:255'
        ]);

        $tags = Tag::where('name', 'LIKE', $request->tag.'%')->get(['name'])->toArray();

        foreach ($tags as &$tag){
            $tag['link'] = action('IndexController@newsFromTag', ['tag' => $tag['name']]);
        }


        return json_encode($tags);
    }

    public function analyticalNews()
    {
        $news = News::where('analytical', '1')->paginate(5);

        return view('public.news.index', compact('news'));
    }

    public function analyticalNew($slug)
    {
        $news = News::where('analytical', '1')->where('slug', $slug)->get();

        return view('public.news.index', compact('news'));
    }

}
