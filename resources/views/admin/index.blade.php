@extends('admin.layouts.app')
@section('pageTitle', 'Admin panel')
@section('body')
    <div class="container">

    <div class="row">
        <div class=" offset-md-5">
            <div class="list-group mar-auto">
                <p href="#" class="list-group-item list-group-item-action active">
                    Выберите раздел
                </p>
                <a href="{{ url(Route::current()->uri . '/category') }}" class="list-group-item list-group-item-action">Категории</a>
                <a href="{{ url(Route::current()->uri . '/news') }}" class="list-group-item list-group-item-action">Статьи</a>
                <a href="{{ url(Route::current()->uri . '/css-editor') }}" class="list-group-item list-group-item-action">Редактор CSS</a>
            </div>
        </div>
    </div>
    </div>


@endsection