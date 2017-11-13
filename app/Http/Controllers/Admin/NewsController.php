<?php

namespace App\Http\Controllers\Admin;


use App\Models\{News, Category};
use App\Rules\alpha_num_spaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\NewsRequest;

use \Auth;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::get();

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('name', 'id');
        $category->prepend('Все категории');

        return view('admin.news.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {

        $img_title = UploadImageController::uploadImage($request->img_title);


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
            try {

                $news->save();

            } catch (\Exception $e){

                session()->flash('flash_message_error', 'Что-то пошло не так попробуйте еще раз!');

                return redirect()->back()->withInput();
            }

            session()->flash('flash_message', 'Успешно!');

            return redirect()->action('Admin\NewsController@index');
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

        return view('admin.news.show', compact('news'));
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
        $category = Category::pluck('name', 'id');


        return view('admin.news.edit', compact('news', 'category'));
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
                $img_title = basename(UploadImageController::uploadImage($request->img_title));
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
            try {

                $news->save();

            } catch (\Exception $e){

                session()->flash('flash_message_error', 'Что-то пошло не так попробуйте еще раз!');

                return redirect()->back()->withInput();
            }

            return redirect()->action('Admin\NewsController@index');
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

        return redirect()->action('Admin\NewsController@index');
    }
}
