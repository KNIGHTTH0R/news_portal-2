
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
    {!! Form::checkbox('access', '1') !!} Только для авторизованных
</div>
{!! Form::submit($submitButton, ['class' => 'btn btn-primary']) !!}

