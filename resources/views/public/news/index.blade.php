@extends('public.layouts.app')
@section('pageTitle', $news->first()->category->name)
@section('body')
<div class="container">
    <div class="row">
        @foreach($news as $article)
            <div class="col-12" style="margin-top: 100px">
                <a href="{{ action('IndexController@show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}">
                    <h3>{{ $article->title }}</h3>
                </a>
                <small>Автор: <b>{{ $article->user->name }}</b> {{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</small>
                <img src="{{ asset('storage/images/' . $article->img_title) }}">
                <p>
                    {!! mb_substr($article->body, 0, 500) !!}
                </p>
                <a class="btn btn-primary" href="{{ action('IndexController@show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}">
                    Читать дальше
                </a>
                <p>
                    <i>Тэги: </i>
                    @if(empty($article->tag->pluck('name')->toArray()))
                        {{ ' Отсутствуют' }}
                    @else
                        @foreach($article->tag->pluck('name')->toArray() as $item)
                            <a href="{{ url('/tag/' . $item) }}">{{ $item }}</a>
                        @endforeach
                    @endif
                 </p>
            </div>
        @endforeach
        <div class="container">
            {{ $news->links('vendor.pagination.default') }}
        </div>
    </div>
</div>
@endsection