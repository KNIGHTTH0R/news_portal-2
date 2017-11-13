@extends('admin.layouts.app')
@section('pageTitle', 'New category')
@section('body')
    <div class="container">
        <div class="row">
            <div class="mar-auto">
                @if (session('flash_status'))
                    <div class="alert alert-danger" role="alert" id="alert">{{ session('status') }}</div>
                @endif
                    {!! Form::open(['action' => 'Admin\CategoryController@store', 'method' => 'post']) !!}
                        @include('admin.category.__form', ['submitButton' => 'Создать'])
                    {!! Form::close() !!}

            </div>
        </div>
    </div>



@endsection