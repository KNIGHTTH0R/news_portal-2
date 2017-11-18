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

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_creation = Category::pluck('name', 'id');
        $category_creation->prepend('Все категории');

        $category = Category::with('news')->get();

        $tags = Tag::pluck('name');


        return view('public.news.CRUD.create', compact('category', 'category_creation', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($slug, News $news)
    {
        $news = $news->where('slug', $slug)->first();

        return view('public.news.CRUD.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, News $news)
    {
        $news = $news->where('slug', $slug)->first();

        $category_creation = Category::pluck('name', 'id');
        $category_creation->prepend('Все категории');

        $category = Category::with('news')->get();

        $tags = Tag::pluck('name', 'id');

        $tags_owned = $news->tag->pluck('name', 'id');

        return view('public.news.CRUD.edit', compact(
            'news',
            'category',
            'category_creation',
            'tags',
            'tags_owned'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, News $news)
    {
        $news->destroy($id);

        return redirect()->action('NewsController@index');
    }



    private function attachTags($request_tags)
    {
        foreach ($request_tags as $tag){
            $tags_ids[] = Tag::firstOrCreate($tag)->id;
        }

        return $tags_ids;
    }

    private function syncTags($request_tags)
    {
        foreach ($request_tags as $tag){
            $tags_ids[] = Tag::firstOrCreate($tag)->id;
        }

        return $tags_ids;
    }
}
