@extends('public.layouts.app')
@section('pageTitle', $news->title)

@section('body')
<div class="container">
    <div class="row">
        <div class="mar-auto">
            <h4>{{ $news->title }}</h4>
            <small>Категория: {{ $news->category->name }}</small><br>
            <small><i>Тэги: </i>
                @if(empty($news->tag->pluck('name')->toArray()))
                    {{ ' Отсутствуют' }}
                @else
                    @foreach($news->tag->pluck('name')->toArray() as $item)
                        <a href="{{ url('/tag/' . $item) }}">{{ $item }}</a>
                    @endforeach
                @endif
            </small>
            <div>
                @if(isset($news->img_title))
                    <img src="{{ asset('storage/images/' . $news->img_title) }}">
                @endif
                {!!  $news->body !!}
            </div>
        </div>
    </div>
</div>
@endsection