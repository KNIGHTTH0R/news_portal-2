@extends('public.layouts.app')
@section('pageTitle', 'News')
@section('body')
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
                            {{--<p>...</p>--}}
                        </div>
                    </div>
                    {{--<div class="carousel-item">--}}
                        {{--<img class="d-block w-100" src="..." alt="Second slide">--}}
                    {{--</div>--}}
                    {{--<div class="carousel-item">--}}
                        {{--<img class="d-block w-100" src="..." alt="Third slide">--}}
                    {{--</div>--}}

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
    </div>


@endsection