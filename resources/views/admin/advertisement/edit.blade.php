@extends('admin.layouts.app')
@section('pageTitle', 'Редактирование рекламного блока')
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-6 mar-auto">
                @if(session()->has('flash_message'))
                    <div class="alert alert-danger" role="alert" id="alert">{{ session('flash_message') }}</div>
                @endif

                {!! Form::model($advertisement, ['action' => ['Admin\AdvertisementController@update', $advertisement->id], 'method' => 'PUT']) !!}
                    @include('admin.advertisement.__form', ['submitButton' => 'Изменить'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection