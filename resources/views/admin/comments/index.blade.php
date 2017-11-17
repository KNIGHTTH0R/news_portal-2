@extends('admin.layouts.app')
@section('pageTitle', 'Одобрение комментариев')
@section('body')
            @if(session()->has('flash_message'))
                <div class="alert alert-success" role="alert" id="alert">{{ session('flash_message') }}</div>
            @endif

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Статья</th>
                    <th scope="col">Категория статьи</th>
                    <th scope="col">Комментарий</th>
                    <th scope="col">Создан</th>
                    <th scope="col"><button class="btn btn-success" data-mass-allowed>Опубликовать выбранные</button></th>
                    <th colspan="2" scope="col"><button class="btn btn-danger" data-mass-delete>Удалить выбранные</button></th>
                    <th scope="col"><input id="select_all" type="checkbox"></th>

                </tr>
                </thead>
                <tbody>


                @foreach($comments as $comment)
                    <tr id="comment_row_id_{{$comment->id}}">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $comment->user->name }}</td>
                        <td><a href="{{ url($comment->news->category->slug.'/'.$comment->news->slug) }}">{{ $comment->news->title }}</a></td>
                        <td><a href="{{ url($comment->news->category->slug.'/') }}">{{ $comment->news->category->name }}</a></td>
                        <td style="word-break: break-all;"><textarea id="comment_textarea_id_{{ $comment->id }}" class="form-control" cols="100" rows="5">{{ $comment->body }}</textarea></td>
                        <td>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</td>
                        <td><button class="btn btn-success" data-comment-id="{{ $comment->id }}" data-allowed-button >Опубликовать</button></td>
                        <td><button class="btn btn-secondary" data-comment-id="{{ $comment->id }}" data-change-button >Изменить</button></td>
                        <td><button class="btn btn-danger" data-comment-id="{{ $comment->id }}" data-delete-button >Удалить</button></td>
                        <td><input type="checkbox" data-checkbox name="ids[]"value="{{ $comment->id }}"></td>
                    </tr>

                @endforeach
                </tbody>
            </table>
@include('admin.layouts.__modal_delete')

@endsection