@extends('public.layouts.app')
@section('pageTitle', 'Статьи')

@section('body')



<div class="container">
    <div class="row">

        @foreach($news as $article)
            <div class="col-12" style="margin-top: 100px">
                <a href="{{ action('IndexController@show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}"><h3>{{ $article->title }}</h3></a>

                <small>Автор: <b>{{ $article->user->name }}</b> {{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</small>
                <img src="{{ asset('storage/images/' . $article->img_title) }}">
                <p>
                    {!! mb_substr($article->body, 0, 500) !!}
                </p>

                <a class="btn btn-primary" href="{{ action('IndexController@show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}">Читать дальше</a>

                <p><i>Тэги:</i></p>
                {{ implode(', ',$article->tag->pluck('name')->toArray()) }}

            </div>
        @endforeach

    </div>
</div>

@endsection

@section('end_of_body')
@endsection