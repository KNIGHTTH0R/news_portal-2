@extends('public.layouts.app')
@section('pageTitle', 'Новая статья')

@section('head')
    @include('public.news.CRUD.__text_editor_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>

@endsection

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-8 mar-auto">
                @if (session('flash_message_error'))
                    <div class="alert alert-danger" role="alert" id="alert">{{ session('flash_message_error') }}</div>
                @endif
                    {!! Form::open(['action' => 'NewsController@store', 'method' => 'post', 'files' => true]) !!}
                        @include('public.news.CRUD.__form', ['submitButton' => 'Создать', 'tags_owned' => null])
                    {!! Form::close() !!}

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>
    @include('public.news.CRUD.__text_editor_js')
@endsection
