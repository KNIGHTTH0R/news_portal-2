<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\SubscribeRequest;
use Illuminate\Http\Request;
use App\Models\{
    ActiveClient, Category, Comment, News, Subscribe, Tag
};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    /**
     * Render site root page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $category = Category::with('news')->get();

        $slide = News::with('category')->latest()->limit(3)->get(['title', 'img_title', 'slug', 'category_id']);

        $newsTop = News::select(['title', 'slug', 'category_id'])->with(['category'])->withCount('comment')->orderBy('comment_count', 'DESC')->limit(3)->get();

        return view('public.index', compact('category', 'slide', 'newsTop'));
    }

    /**
     * Render page with specified article
     *
     * @param $category | just for pretty url
     * @param $slug
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function show($category_slug = null, $slug, News $news)
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

    /**
     * Render page with news, which related to specific category
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function newsFromCategory($slug)
    {
        $news = Category::where('slug', $slug)->first();

        if (is_null($news)){

            return abort(404);
        }

        $news = $news->news()->paginate(5);

        if ($news->isEmpty()){

            return abort(404);
        }

        return view('public.news.index', compact('news'));
    }

    /**
     * Render page with news, which related to specific tags
     * @param $tag
     * @param Tag $tags
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function newsFromTag($tag, Tag $tags)
    {

        $news = $tags->where('name', $tag)->first();

        if (is_null($news)){

            return abort(404);
        }

        $news = $news->news()->paginate(5);

        return view('public.news.index', compact('news'));

    }

    /**
     * Adding a person to the list of newsletter recipients.
     *
     * @param SubscribeRequest $request
     * @param Subscribe $subscribe
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function subscribe(SubscribeRequest $request, Subscribe $subscribe)
    {
        try {

            $subscribe->create($request->except(['_token']));

        } catch (\Exception $e){

            return response(json_encode(['status' => 'error']), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }

    /**
     * Getting ajax request and searching given tag
     *
     * @param Request $request
     * @return string
     */

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

    /**
     * Return list of all analytical articles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function analyticalNews()
    {
        $news = News::where('analytical', '1')->paginate(5);

        if ($news->isEmpty()){

            return abort(404);
        }

        return view('public.news.index', compact('news'));
    }

    /**
     * Render page, which adapting for display "Analytical" articles.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function analyticalNew($slug)
    {
        $news = News::where('analytical', '1')->where('slug', $slug)->get();

        return view('public.news.index', compact('news'));
    }

    /**
     * Setting for current article number of users who currently reading
     * and number of total reads.
     *
     * @param Request $request
     * @param News $news
     * @return string
     */

    public function activeCheck(Request $request, News $news)
    {
        if($request->new_client == 1){

            ActiveClient::where('last_seen_at', '<', Carbon::now()->subSeconds(10))->delete();
            $news = $news->find($request->news_id);

            if (is_null($news->reads_count)){

                $news->reads_count = 1;
                $news->save();
            } else {

                $news->reads_count++;
                $news->save();
            }
        }

        try {
                ActiveClient::create([
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'token' => $request->_token,
                    'news_id' => $request->news_id,
                    'last_seen_at' => Carbon::now()
            ]);
        } catch (\Exception $e){

            try {

                ActiveClient::where('token', $request->_token)->update(['last_seen_at' => Carbon::now()]);

            } catch (\Exception $e){

                return json_encode([
                    'reads_count' => News::where('id', $request->news_id)->get(['reads_count'])->first()->reads_count,
                    'active_clients' => ActiveClient::where('last_seen_at', '>', Carbon::now()->subSeconds(10))->distinct(['token'])->count()
                ]);
            }

            return json_encode([
                'reads_count' => News::where('id', $request->news_id)->get(['reads_count'])->first()->reads_count,
                'active_clients' => ActiveClient::where('last_seen_at', '>', Carbon::now()->subSeconds(10))->distinct(['token'])->count()
            ]);

        }

        return json_encode([
            'reads_count' => News::where('id', $request->news_id)->get(['reads_count'])->first()->reads_count,
            'active_clients' => ActiveClient::where('last_seen_at', '>', Carbon::now()->subSeconds(10))->distinct(['token'])->count()
        ]);
    }

    public function newsFilterSearch(SearchRequest $request, News $news)
    {
        if ($request->date != 0){
            switch ($request->date) {
                case 1:
                    $news = $news->where('created_at', '>=', Carbon::now()->subDay());
                    break;
                case 2:
                    $news = $news->where('created_at', '>=', Carbon::now()->subWeek());
                    break;
                case 3:
                    $news = $news->where('created_at', '>=', Carbon::now()->subMonth());
                    break;
                case 4:
                    $news = $news->where('created_at', '>=', Carbon::now()->subYear());
                    break;
            }
        }

        if ($request->category != 0){
            $news = $news->whereHas('category', function ($q) use ($request){
                $q->where('id','=', $request->category);
            });
        }

        if ($request->exists('tags')){
            $news = $news->whereHas('tag', function ($q) use ($request){
                $q->whereIn('id', $request->tags);
            });
        }

         $news = $news->paginate(5);

        return view('public.news.index', compact('news'));
    }
}
