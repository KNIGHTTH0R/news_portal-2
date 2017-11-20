    <div class="form-group">
        {!! Form::label('name', 'Название категории:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    @if ($errors->get('name'))
        @foreach($errors->get('name') as $item)
            <div class="alert alert-danger">
                {{$item}}
            </div>
        @endforeach
    @endif
<div class="form-group">
    {!! Form::checkbox('protected', '1') !!} Комментарии в этой категории будут публиковаться после проверки модератором
</div>
{!! Form::submit($submitButton, ['class' => 'btn btn-primary']) !!}
