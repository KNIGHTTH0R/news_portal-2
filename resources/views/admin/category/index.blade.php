@extends('admin.layouts.app')
@section('pageTitle', 'Катогории')
@section('body')
    @if(session()->has('flash_message'))
        <div class="alert alert-success" role="alert" id="alert">{{ session('flash_message') }}</div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Категория</th>
        </tr>
        </thead>
        <tbody>
        @foreach($category as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->name }}</td>
                <td><a href="{{ action('Admin\CategoryController@edit', ['slug' => $item->slug]) }}">Редактировать</a></td>
                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{$item->id}}">Удалить</button></td>
            </tr>
        @endforeach
        <tr>
            <th scope="row">#</th>
            <td><a href="{{ url("admin/category/create") }}">Добавить новую категорию + </a></td>
        </tr>
        </tbody>
    </table>
    @include('admin.layouts.__modal_delete')
@endsection