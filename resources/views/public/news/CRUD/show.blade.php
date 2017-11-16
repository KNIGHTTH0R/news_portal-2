@extends('public.layouts.app')
@section('pageTitle', 'test')

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
</div>
@endsection