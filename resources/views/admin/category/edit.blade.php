@extends('admin.layouts.app')
@section('pageTitle', 'Edit category')
@section('body')
    <div class="container">
        <div class="row">
            <div class="mar-auto">
                @if (session('flash_message'))
                    <div class="alert alert-danger" role="alert">{{ session('flash_message') }}</div>
                @endif
                {!! Form::model($category, ['action' => ['Admin\CategoryController@update', $category->id], 'method' => 'put']) !!}
                     @include('admin.category.__form', ['submitButton' => 'Обновить'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection