@extends('admin.layouts.app')
@section('pageTitle', 'Статьи')

@section('body')

    @if(session()->has('flash_message'))
        <div class="alert alert-success" role="alert" id="alert">{{ session('flash_message') }}</div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Категория</th>
            <!--<th scope="col">Last Name</th>
            <th scope="col">Username</th>-->
        </tr>
        </thead>
        <tbody>

        @php $i = 0; @endphp
        @foreach($news as $item)
            <tr>
                <th scope="row">{{ ++$i }}</th>
                <td><a href="{{ action('Admin\NewsController@show', ['slug' => $item->slug]) }}">{{ $item->title }}</a></td>
                <td><a href="{{ action('Admin\NewsController@edit', ['slug' => $item->slug]) }}">Редактировать</a></td>
                {{--<td><a href="{{ url("admin/category/edit/$item->slug") }}">Редактировать</a></td>--}}
                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{$item->id}}">Удалить</button></td>


            </tr>

        @endforeach

        <tr>
            <th scope="row">#</th>
            <td><a href="{{ url("admin/news/create") }}">Создать новую статью + </a></td>
        </tr>

        </tbody>
    </table>


    @include('admin.layouts.__modal_delete')


@endsection

@section('end_of_body')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection