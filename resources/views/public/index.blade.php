@extends('public.layouts.app')
@section('pageTitle', 'News')
@section('body')

    {{--{{ dd(\App\Models\Category::with('news')->get()->map(function ($category) {--}}
    {{--return $category =$category->news->take(5);--}}

    {{--})) }}--}}
    <div class="container">
        <div class="row">
            <div class="col-12 w-100">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    @foreach($slide as $key => $item)
                    <div class="carousel-item {{ $key == 0?'active':'' }}">
                        <a href="{{ url($item->category->slug.'/'.$item->slug) }}">
                            <img class="d-block w-100" src="{{ asset('storage/images/'.$item->img_title) }}" alt="image of news title">
                        </a>
                        <div class="carousel-caption d-none d-md-block">
                            <a href="{{ url($item->category->slug.'/'.$item->slug) }}">
                                <h3 class="slide-link">{{ $item->title }}</h3>
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3 mar-auto">
                <h3>ТОП 3 новостей<h5>по комментариям</h5></h3>
                <ul class="list-group">
                @foreach($newsTop as $item)

                    <li class="list-group-item"><a href="{{ action('IndexController@show', ['category' => $item->category->slug, 'slug' => $item->slug]) }}">
                        {{ $item['title'] }}
                        <span class="badge badge-secondary">{{ $item->comment_count }}</span>
                        </a></li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection