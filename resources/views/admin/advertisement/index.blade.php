@extends('admin.layouts.app')
@section('pageTitle', 'Реклама')
@section('body')
    @if(session()->has('flash_message'))
        <div class="alert alert-success" role="alert" id="alert">{{ session('flash_message') }}</div>
    @endif

    <div class="container">
        <div class="row">
            @if($left->isEmpty())
                <div class="col-4 offset-md-2">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="adv-admin">
                            <a class="btn btn-secondary" href="{{ action('Admin\AdvertisementController@create', ['side' => 'left', 'position' => $i]) }}">Добавить</a>
                        </div>
                    @endfor
                </div>
            @else
                <div class="col-4 offset-md-2">
                    @foreach($left as $block)
                        <div class="adv-admin">
                            <div class="adv-head">{{ $block->seller }}</div>
                            <hr>
                            <div class="adv-body">{{ $block->text }}</div>
                            <hr>
                            <div class="adv-price"
                                 data-sale-price="{{ $block->sale_price }}"
                                 data-price="{{ $block->price }}"
                                 data-popover-id="{{ $block->id }}">
                                {{ $block->price }}</div>
                            <div class="popover" id="popover_id_{{$block->id}}">
                                <div class="popover-header">{{ $block->sale_title }}</div>
                                <div class="popover-body">{{ $block->sale_text }}</div>
                            </div>
                            <a href="{{ action('Admin\AdvertisementController@edit', ['id' => $block->id]) }}" class="btn btn-primary">Изменить</a>
                            <button class="btn btn-danger adv-btn-del" data-id="{{ $block->id }}">Удалить</button>

                        </div>
                        @if($loop->last)
                            @for($i = $loop->iteration; $i <= 4 - $loop->iteration; $i++)
                                <div class="adv-admin">
                                    <a class="btn btn-secondary" href="{{ action('Admin\AdvertisementController@create', ['side' => 'left', 'position' => $i]) }}">Добавить</a>
                                </div>
                            @endfor
                        @endif
                    @endforeach
                </div>
            @endif
            @if($right->isEmpty())
                <div class="col-4">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="adv-admin">
                            <a class="btn btn-secondary" href="{{ action('Admin\AdvertisementController@create', ['side' => 'right', 'position' => $i]) }}">Добавить</a>
                        </div>
                    @endfor
                </div>
                @else
                    <div class="col-4 offset-md-2">
                        @foreach($right as $block)
                            <div class="adv-admin">
                                <div class="adv-head">{{ $block->seller }}</div>
                                <hr>
                                <div class="adv-body">{{ $block->text }}</div>
                                <div class="adv-price"
                                     data-sale-price="{{ $block->sale_price }}"
                                     data-price="{{ $block->price }}"
                                     data-popover-id="{{ $block->id }}">
                                    {{ $block->price }}</div>
                                <div class="popover" id="popover_id_{{$block->id}}">
                                    <div class="popover-header">{{ $block->sale_title }}</div>
                                    <div class="popover-body">{{ $block->sale_text }}</div>
                                </div>
                                <a href="{{ action('Admin\AdvertisementController@edit', ['id' => $block->id]) }}" class="btn btn-primary">Изменить</a>
                                <button class="btn btn-danger adv-btn-del" data-id="{{ $block->id }}">Удалить</button>                            </div>
                            @if($loop->last)
                                @for($i = $loop->iteration; $i <= 4 - $loop->iteration; $i++)
                                    <div class="adv-admin">
                                        <a class="btn btn-secondary" href="{{ action('Admin\AdvertisementController@create', ['side' => 'left', 'position' => $i]) }}">Добавить</a>
                                    </div>
                                @endfor
                            @endif
                        @endforeach
                    </div>
            @endif
        </div>
    </div>

@endsection