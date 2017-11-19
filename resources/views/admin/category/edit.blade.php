@extends('admin.layouts.app')
@section('pageTitle', 'Edit category')
@section('body')
    <div class="container">
        <div class="row">
            <div class="mar-auto">
                @if (session('status'))
                    <div class="alert alert-danger" role="alert">{{ session('status') }}</div>
                @endif
                {!! Form::model($category, ['action' => ['Admin\CategoryController@update', $category->id], 'method' => 'put']) !!}
                     @include('admin.category.__form', ['submitButton' => 'Обновить'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection