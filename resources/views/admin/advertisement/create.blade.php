@extends('admin.layouts.app')
@section('pageTitle', 'Добавление рекламного блока')
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-6 mar-auto">
                @if(session()->has('flash_message'))
                    <div class="alert alert-danger" role="alert" id="alert">{{ session('flash_message') }}</div>
                @endif

                {!! Form::open(['action' => 'Admin\AdvertisementController@store']) !!}
                    @include('admin.advertisement.__form', ['submitButton' => 'Добавить'])
                    {!! Form::hidden('block_side', $side) !!}
                    {!! Form::hidden('block_position', $position) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection