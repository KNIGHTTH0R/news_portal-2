@extends('public.layouts.app')
@section('pageTitle', 'Статьи')

@section('body')
    @if(session()->has('flash_message'))
        <div class="alert alert-success" role="alert" id="alert">{{ session('flash_message') }}</div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Заголовок</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td><a href="{{ action('NewsController@show', ['slug' => $item->slug]) }}">{{ $item->title }}</a></td>
                <td><a href="{{ action('NewsController@edit', ['slug' => $item->slug]) }}">Редактировать</a></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{$item->id}}">
                        Удалить</button>
                </td>
            </tr>
        @endforeach
        <tr>
            <th scope="row">#</th>
            <td><a href="{{ url("news/create") }}">Создать новую статью + </a></td>
        </tr>
        </tbody>
    </table>

    @include('public.layouts.__modal_delete')

    <div class="container">
        {{ $news->links('vendor.pagination.default') }}
    </div>
@endsection

@section('end_of_body')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection