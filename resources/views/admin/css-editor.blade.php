@extends('admin.layouts.app')
@section('pageTitle', 'Admin panel')
@section('body')
    <div class="container">
   <div class="row">
        <div class="col-2 offset-md-3">
            {!! Form::open(['url' => action('Admin\DynamicCssController@post')]) !!}
            <div class="form-group">
                {!! Form::label('body[background-color]', 'Выберите цвет фона:') !!}
                {!! Form::select('body[background-color]', $active['body'] + $colors, null, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
            </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => action('Admin\DynamicCssController@post')]) !!}
            <div class="form-group">
                {!! Form::label('nav[background-color]', 'Выберите цвет шапки сайта:') !!}
                {!! Form::select('nav[background-color]', $active['nav'] + $colors, null, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
            </div>
            {!! Form::close() !!}

        </div>
            <div class="col-3">
            {!! Form::open(['url' => action('Admin\DynamicCssController@post')]) !!}
            {!! Form::hidden('native', true) !!}
            <div class="form-group">
                {!! Form::label('selector', 'Селектор:') !!}
                {!! Form::text('selector', null, ['class' => 'form-control']) !!}
            </div>
            @if ($errors->get('selector'))
                @foreach($errors->get('selector') as $item)
                    <div class="alert alert-danger">
                        {{$item}}
                    </div>
                @endforeach
            @endif

            <div class="form-group">
                {!! Form::label('css', 'ccs:') !!}
                {!! Form::textarea('css', null, ['class' => 'form-control', 'size' => '5x5']) !!}
            </div>
            @if ($errors->get('css'))
                @foreach($errors->get('css') as $item)
                    <div class="alert alert-danger">
                        {{$item}}
                    </div>
                @endforeach
            @endif
            {!! Form::submit('Изменить css', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>



       <div class="col-2 offset-md-5">
           {!! Form::open(['url' => action('Admin\DynamicCssController@destroy'), 'method' => 'delete']) !!}
           <div class="form-group">
               {!! Form::hidden('reset', true, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
           </div>
           {!! Form::submit('Сбросить весь пользовательский css', ['class' => 'btn btn-primary']) !!}

           {!! Form::close() !!}
       </div>
    </div>
    </div>
@endsection