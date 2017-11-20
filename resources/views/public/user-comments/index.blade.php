@extends('public.layouts.app')
@section('pageTitle', Auth::user()->name)
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-12">
            @if($user->count() > 0)
                <ul id="comment_area">
                @foreach($user as $comment)
                    {{ $comment->allowed }}


                                @if ($comment->allowed !== 0)

                                        <li class="comment" id="comment_{{ $comment->id }}" data-owner="{{ $comment->user->name }}">
                                            <div class="comment_head">
                                                <b>{{ $comment->user->name }}</b>
                                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}

                                            </div>
                                            <div class="comment_body">{{ $comment->body }}</div>
                                            <hr>
                                        </li>
                                    @endif


                @endforeach
                </ul>

            <div class="container">
                {{ $user->links('vendor.pagination.default') }}
            </div>
                @else
                <h4 class="text-center">У пользователя <b>{{ $user->name }}</b> нет комментариев</h4>
            @endif
            </div>
        </div>
    </div>
@endsection