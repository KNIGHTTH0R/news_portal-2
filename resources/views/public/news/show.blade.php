@extends('public.layouts.app')
@section('pageTitle', $news->title)
@section('head')
    <style>
        .material-icons {
            font-size: 19px;!important;
        }
    </style>
@endsection
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-12 mar-auto">
                <h4>{{ $news->title }}</h4>
                <small>Категория: <a href="{{ action('IndexController@newsFromCategory', ['slug' => $news->category->slug]) }}">{{ $news->category->name }}</a></small><br>
                <small>Автор: {{ $news->user->name }}</small><br>
                <small><i>Тэги: </i>
                    @if(empty($news->tag->pluck('name')->toArray()))
                        {{ ' Отсутствуют' }}
                    @else
                        @foreach($news->tag->pluck('name')->toArray() as $item)
                            <a href="{{ url('/tag/' . $item) }}">{{ $item }}</a>
                        @endforeach
                    @endif
                </small>
                <div class="">
                    @if(isset($news->img_title))
                        <img src="{{ asset('storage/images/' . $news->img_title) }}">
                    @endif
                    @if($news->analytical)
                        @auth
                            {!!  $news->body !!}
                        @else
                            {!!  mb_substr($news->body, 0, (strlen($news->body) / 4)) !!}
                                    <h3>Это аналитическая статья чтобы прочитать целиком сначала авторизуйтесь.</h3>
                        @endauth
                     @else
                          {!!  $news->body !!}
                     @endif
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-4 offset-md-9">
                    <h3>Сейчас читают<span class="badge badge-secondary" id="active_clients"></span></h3>
                    <h3>Всего просмотров<span class="badge badge-secondary" id="reads_count"></span></h3>
                </div>
            </div>
            <div class="row">
            <div class="col-12 mar-auto">
                <h3>Комментарии {{ $comment_count  }}</h3>
                <hr>
                <ul id="comment_area">
                @if($comment_count > 0)
                        @foreach($news->comment()->withTrashed()->where('parent_id', null)->orderBy('rate_up', 'DESC')->get() as $comment)
                            @if ($comment->allowed !== 0)
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
                                            @if(\Carbon\Carbon::parse($comment->created_at)->addMinute() > \Carbon\Carbon::now())
                                                <span class="edit{{ Auth::check() ? '': ' cursor-block' }}" data-id="{{ $comment->id }}" id="edit_{{ $comment->id }}">
                                                    редактировать
                                                </span>
                                            @endif
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
                                                <i class="material-icons">thumb_down</i>
                                            </button>
                                            <span class="rate-down" id="rate_down_comment_id_{{$comment->id}}">{{ $comment->rate_down }}</span>
                                        </div>
                                    </div>
                                    <div class="comment_body">{{ $comment->body }}</div>
                                    @if($comment->child->isNotEmpty())
                                        @include('public.layouts.__nested_comment', ['nested_comment' => $comment->child, 'parent_id' => $comment->id])
                                    @endif
                                    <hr>
                                </li>
                                @endif
                            @endif
                        @endforeach
                @endif
                </ul>
                @auth
                <div id="form_comment_area">
                    <form id="form_comment">
                        {{ csrf_field() }}
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
                                         <label for="email" class="col-md-7 control-label">E-Mail Address</label>
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
                                         <div class="col-md-7 col-md-offset-1">
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
    <script type="text/javascript">
        var is_news_page = true;

        function active() {
            var new_client;
            if (getCookie('active') == undefined){
                document.cookie = "active=1; path=/";
                new_client = 1;
            } else {
                new_client = 0;
            }

            var data = new FormData();

            data.set('_token', csrf_token);
            data.set('news_id', {{ $news->id }});
            data.set('new_client', new_client);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/ajax/active_check");
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {

                if (this.readyState != 4) return;

                if (this.status == 200) {
                    document.getElementById('active_clients');
                    document.getElementById('reads_count');

                    var response = JSON.parse(this.responseText);

                    if (document.getElementById('active_clients') != undefined){
                        document.getElementById('active_clients').innerHTML = response.active_clients;
                    }
                    if (document.getElementById('reads_count') != undefined){
                        document.getElementById('reads_count').innerHTML = response.reads_count;
                    }
                }

                if (this.status == 422) {
                }
            };

            xhr.send(data);
        }
    </script>
@endsection