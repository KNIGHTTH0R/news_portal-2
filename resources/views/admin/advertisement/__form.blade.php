<div class="form-group">
    {!! Form::label('seller', 'Название компании \ сайта и т.д :') !!}
    {!! Form::text('seller', null, ['class' => 'form-control']) !!}
</div>
@if ($errors->get('seller'))
    @foreach($errors->get('seller') as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('text', 'Рекламный текст :') !!}
    {!! Form::textarea('text', null, ['class' => 'form-control']) !!}
</div>
@if ($errors->get('text'))
    @foreach($errors->get('text') as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('sale_title', 'Заголовок всплывающего рекламного текста :') !!}
    {!! Form::text('sale_title', null, ['class' => 'form-control']) !!}
</div>
@if ($errors->get('sale_title'))
    @foreach($errors->get('sale_title') as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('sale_text', 'Всплывающий рекламный текст :') !!}
    {!! Form::text('sale_text', null, ['class' => 'form-control']) !!}
</div>
@if ($errors->get('sale_text'))
    @foreach($errors->get('sale_text') as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('price', 'Цена товара \ услуги :') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>
@if ($errors->get('price'))
    @foreach($errors->get('price') as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('sale_price', 'Скидочная цена:') !!}
    {!! Form::text('sale_price', null, ['class' => 'form-control']) !!}
</div>
@if ($errors->get('sale_price'))
    @foreach($errors->get('sale_price') as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

@if ($errors->any())
    @foreach($errors->all() as $item)
        <div class="alert alert-danger">
            {{$item}}
        </div>
    @endforeach
@endif

{!! Form::submit($submitButton, ['class' => 'btn btn-primary']) !!}
