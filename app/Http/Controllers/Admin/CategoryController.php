<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\alpha_num_spaces;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::get();

        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', new alpha_num_spaces, 'unique:category']
        ]);

        $data = $request->except(['_token']);
        $data['slug'] = str_slug($data['name']);

        try {
            Category::firstOrCreate($data);
        } catch (\Exception $e){
            session()->flash('flash_message', 'Что-то пошло не так, попробуйте еще раз!');
            return back();
        }

        session()->flash('flash_message', 'Успешно!');

        return redirect()->action('Admin\CategoryController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, Category $category)
    {
        try {
            $category = $category->where('slug', $slug)->first();
        } catch (\Exception $e){
            session()->flash('flash_message', 'Что-то пошло не так, попробуйте еще раз!');
            return back();
        }

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Category $category)
    {

        $request->validate([
            'name' => [
                'required',
                new alpha_num_spaces,
                Rule::unique('category')->ignore($request->name, 'name')
            ]
        ]);

        $data = $request->except(['_token']);
        $data['slug'] = str_slug($data['name']);

        try {
            $category->find($id)->update($data);
        } catch (\Exception $e){
            session()->flash('flash_message', 'Что-то пошло не так, попробуйте еще раз!');
            return back();
        }
        session()->flash('flash_message', 'Успешно!');

        return redirect()->action('Admin\CategoryController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Category $category)
    {
        try {
            $category->destroy($id);
        } catch (\Exception $e){
            session()->flash('flash_message', 'Что-то пошло не так, попробуйте еще раз!');
            return back();
        }
        session()->flash('flash_message', 'Успешно!');

        return redirect()->action('Admin\CategoryController@index');

    }
}
