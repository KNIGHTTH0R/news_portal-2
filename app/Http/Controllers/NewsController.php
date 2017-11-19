<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\UploadImageController;
use App\Models\{
    News, Category, Tag
};
use App\Rules\alpha_num_spaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\NewsRequest;

use \Auth;
use Illuminate\Support\Facades\Input;

/** articles CRUD
 * Class NewsController
 * @package App\Http\Controllers
 */
class NewsController extends Controller
{
    /**
     * Display a listing of articles which owned
     * for current authenticate user.
     *
     * If user is "Admin" - display listing of all articles.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if(Auth::user()->isAdmin()){

            $news = News::paginate(5);

        } else {

            $news = News::where('user_id', Auth::user()->id)->get();
        }

        return view('public.news.CRUD.index', compact('news'));
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $category_creation = Category::pluck('name', 'id');

        $tags = Tag::pluck('name', 'name');

        return view('public.news.CRUD.create', compact( 'category_creation', 'tags'));
    }

    /**
     * Store a newly created article in database.
     *
     * @param NewsRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(NewsRequest $request)
    {

        $img_title = UploadImageController::uploadImage($request->img_title, true);

        if ($img_title === false){

            session()->flash('flash_message_error', 'При загрузке изображения что-то пошло не такб попробуйте еще раз!');

            return redirect()->back()->withInput();
        }

        $news = News::firstOrNew(
            ['slug' => str_slug($request->title)],
                [
                    'title'       => $request->title,
                    'img_title'   => basename($img_title),
                    'slug'        => str_slug($request->title),
                    'category_id' => $request->category_id,
                    'user_id'     => Auth::user()->id,
                    'body'        => $request->body
                ]
            );

        if ($news->exists == false){
            if ($request->analytical){

                $news->analytical = $request->analytical;
            }
            try {

                $news->save();

                if (!is_null($request->tags)) {

                    $tags = $this->attachTags($request->tags);
                    $news->tag()->attach($tags);
                }
            } catch (\Exception $e){

                session()->flash('flash_message_error', 'Что-то пошло не так попробуйте еще раз!');

                return redirect()->back()->withInput();
            }

            session()->flash('flash_message', 'Успешно!');

            return redirect()->action('NewsController@index');
        } else {

            session()->flash('flash_message_error', 'Статья с таким заголовком уже существует!');

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified article, just article content
     * without everything's else, for example comments.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */

    public function show($slug, News $news)
    {
        $news = $news->where('slug', $slug)->first();

        if(is_null($news)){

            return abort(404);
        }

        return view('public.news.CRUD.show', compact('news'));
    }

    /**
     *
     * Show the form for editing the specified article.
     * @param $slug
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit($slug, News $news)
    {
        $news = $news->where('slug', $slug)->first();

        if(is_null($news)){

            return abort(404);
        }

        $category_creation = Category::pluck('name', 'id');
        $category_creation->put(0, 'Все категории');

        $category = Category::with('news')->get();

        $tags = Tag::pluck('name', 'name');
        $tags_owned = $news->tag->pluck('name');

        return view('public.news.CRUD.edit', compact(
            'news',
            'category',
            'category_creation',
            'tags',
            'tags_owned'
        ));
    }

    /**
     * Update the specified article in storage.
     *
     * @param $id
     * @param NewsRequest $request
     * @param News $news
     * @return $this|\Illuminate\Http\RedirectResponse
     */

    public function update($id, NewsRequest $request, News $news)
    {
        $check = $news
                      ->where('slug',str_slug($request->title))
                      ->where('id', '!=', $id)
                      ->first();

        if (is_null($check)){

            $news = $news->find($id);

            if($request->hasFile('img_title')){

                $img_title = UploadImageController::uploadImage($request->img_title, true);

                if ($img_title !== false){

                    $img_title = basename($img_title);

                } else {

                    session()->flash('flash_message_error', 'При загрузке изображения что-то пошло не такб попробуйте еще раз!');

                    return redirect()->back()->withInput();
                }

            } else {

                $img_title = $news->img_title;

            }

            $news->fill([
                'title' => $request->title,
                'img_title' => $img_title,
                'slug'  => str_slug($request->title),
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
                'body' => $request->body
            ]);

            if ($request->analytical){

                $news->analytical = $request->analytical;

            } else {

                $news->analytical = 0;
            }

            try {

                $news->save();

                if (!is_null($request->tags)) {

                    $tags = $this->syncTags($request->tags);
                    $news->tag()->sync($tags);
                }

            } catch (\Exception $e){

                session()->flash('flash_message_error', 'Что-то пошло не так попробуйте еще раз!');

                return redirect()->back()->withInput();
            }

            return redirect()->action('NewsController@index');

        } else {

            session()->flash('flash_message_error', 'Статья с таким заголовком уже существует, придумайте другой заголовок!');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified article from storage.
     *
     * @param $id
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id, News $news)
    {
        $news->destroy($id);

        return redirect()->action('NewsController@index');
    }

    /**
     * Attaching tags from request to article.
     *
     * @param $request_tags
     * @return array
     */

    private function attachTags($request_tags)
    {
        foreach ($request_tags as $tag){
            $tags_ids[] = Tag::firstOrCreate($tag)->id;
        }

        return $tags_ids;
    }

    /**
     * Syncs tags and specified article
     * @param $request_tags
     * @return array
     */

    private function syncTags($request_tags)
    {
        foreach ($request_tags as $tag){
            $tags_ids[] = Tag::firstOrCreate($tag)->id;
        }

        return $tags_ids;
    }
}
