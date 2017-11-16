@extends('public.layouts.app')
@section('pageTitle', 'Редактировать статью')
@section('head')
    @include('public.news.CRUD.__text_editor_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
@endsection

@section('body')

    <div class="container">
        <div class="row">
            <div class="mar-auto">
                @if(session()->has('flash_message_error'))
                    <div class="alert alert-danger" role="alert" id="alert">{{ session('flash_message_error') }}</div>
                @endif
                {!! Form::model($news, ['action' => ['NewsController@update', $news->id], 'method' => 'put', 'files' => true]) !!}
                     @include('public.news.CRUD.__form', ['submitButton' => 'Обновить', 'tags_owned' => $tags_owned])
                {!! Form::close() !!}

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#tags').val({!! json_encode(array_keys($tags_owned->toArray())) !!}).select2({
                tags: true,
                tokenSeparators: [',', ' '],
                multiple: true,
            });
        });
    </script>
    @include('public.news.CRUD.__text_editor_js')
@endsection