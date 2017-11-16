@extends('public.layouts.app')
@section('pageTitle', 'title')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .material-icons {
            font-size: 19px;!important;
        }
    </style>

@endsection
@section('body')



    <div class="container">
        <div class="row">
            <div class="mar-auto">
                <h4>{{ $news->title }}</h4>
                <small>Категория: {{ $news->category->name }}</small>

                <div>
                    @if(isset($news->img_title))
                        <img src="{{ asset('storage/images/' . $news->img_title) }}">
                    @endif
                    {!!  $news->body !!}
                </div>

            </div>
        </div>
            <div class="row">
            <div class="col-12 mar-auto">
                <h3>Комментарии {{ $comment_count  }}</h3>
                <hr>
                <ul id="comment_area">
                @if($comment_count > 0)

                        @foreach($news->comment()->withTrashed()->where('parent_id', null)->get() as $comment)


                            @if($comment->trashed())
                                <li class="comment" id="comment_{{ $comment->id }}" data-owner="{{ $comment->user->name }}">
                                    <div class="comment_head_deleted">
                                        Пользователь <b>{{ $comment->user->name }}</b> удалил свой комментарий
                                        {{ \Carbon\Carbon::parse($comment->deleted_at)->diffForHumans() }}
                                    </div>

                                    <div class="comment_body">

                                    </div>


                                    <hr>
                                </li>


                                @if($comment->child()->withTrashed()->get()->isNotEmpty())
                                    @include('public.layouts.__nested_comment', ['nested_comment' => $comment->child()->withTrashed()->get(), 'parent_id' => $comment->id])
                                @endif
                            @else
                            <li class="comment" id="comment_{{ $comment->id }}" data-owner="{{ $comment->user->name }}">
                                <div class="comment_head">
                                    <b>{{ $comment->user->name }}</b>
                                    {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                    @if(Auth::check())
                                        @if($comment->user->name == Auth::user()->name)
                                        <button type="button" class="close" data-id="{{$comment->id}}" data-del-comment id="del_comment_{{$comment->id}}">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        @else
                                        <span class="reply{{ Auth::check() ? '': ' cursor-block' }}" data-id="{{ $comment->id }}" id="reply_{{ $comment->id }}">
                                            reply
                                        </span>
                                        @endif
                                    @endif
                                    <div class="comment_head_right">

                                        <span class="rate-up" id="rate_up_comment_id_{{$comment->id}}">{{ $comment->rate_up }}</span>
                                        <button type="button" class="btn btn-default btn-sm rate-btn{{ Auth::check() ? '': ' cursor-block' }}" id="rate_up_{{ $comment->id }}" data-rate-up data-id="{{ $comment->id }}">
                                            <i class="material-icons">thumb_up</i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm rate-btn{{ Auth::check() ? '': ' cursor-block' }}" id="rate_down_{{ $comment->id }}" data-rate-down data-id="{{ $comment->id }}">
                                            <i class="material-icons">thumb_down</i>                                        </button>
                                        <span class="rate-down" id="rate_down_comment_id_{{$comment->id}}">{{ $comment->rate_down }}</span>
                                    </div>

                                </div>
                                <div class="comment_body">
                                    {{ $comment->body }}
                                </div>

                                @if($comment->child->isNotEmpty())
                                    @include('public.layouts.__nested_comment', ['nested_comment' => $comment->child, 'parent_id' => $comment->id])
                                @endif


                                <hr>
                            </li>
                            @endif

                        @endforeach


                @endif
                </ul>
                @auth
                <div id="form_comment_area">
                    <form id="form_comment">
                        {{ csrf_field() }}
                        {{--{!! Form::hidden('news_id', $news->id) !!}--}}
                        {!! Form::hidden('news_id', $news->id) !!}
                        <div class="form-group">
                            {!! Form::label('comment', 'Оставить коментарий') !!}
                            {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Ваш комментарий...', 'size' => '30x3']) !!}
                            <div class="invalid-feedback" id="comment_error" style="display:none;"></div>
                        </div>
                        {!! Form::button('Отправить', ['class' => 'btn btn-primary', 'id' => 'send_comment']) !!}
                    </form>


                </div>
                    @else
                         <div class="dropdown">
                             Чтобы оставлять комментарии сначала авторизуйтесь.
                            <button class="btn btn-secondary" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Войти
                            </button>

                             <div class="dropdown-menu">
                                 <div class="container" style="max-width: 300px">
                                 <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                     {{ csrf_field() }}

                                     <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                         <label for="email" class="col-md-6 control-label">E-Mail Address</label>

                                         <div class="col-md-10">
                                             <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                             @if ($errors->has('email'))
                                                 <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                             @endif
                                         </div>
                                     </div>

                                     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                         <label for="password" class="col-md-3 control-label">Password</label>

                                         <div class="col-md-10">
                                             <input id="password" type="password" class="form-control" name="password" required>

                                             @if ($errors->has('password'))
                                                 <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                             @endif
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <div class="col-md-6 col-md-offset-1">
                                             <div class="checkbox">
                                                 <label>
                                                     <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                 </label>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <div class="col-md-8 col-md-offset-1">
                                             <button type="submit" class="btn btn-primary">
                                                 Login
                                             </button>
                                         </div>
                                     </div>
                                 </form>
                                 <div class="dropdown-divider"></div>
                                 <a class="btn btn-link" href="{{ url('register') }}">New around here? Sign up</a>
                                 <a class="btn btn-link" href="{{ route('password.request') }}">
                                     Forgot Your Password?
                                 </a>
                                 </div>
                            </div>
                         </div>
                @endauth
            </div>
            </div>

    </div>
@endsection

@section('end_of_body')
    @auth
<script src="{{ asset('js/public.js') }}"></script>
    @endauth
@endsection