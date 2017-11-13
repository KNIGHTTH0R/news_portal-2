    <div class="form-group">
        {!! Form::label('title', 'Заголовок статьи:') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    @if ($errors->get('title'))
        @foreach($errors->get('title') as $item)
            <div class="alert alert-danger">
                {{$item}}
            </div>
        @endforeach
    @endif

    @if(isset($news->img_title))
        <img src="{{ asset('storage/images/' . $news->img_title) }}">
    @endif
    <div class="form-group">
        {!! Form::label('img_title', 'Изображение заголовок:') !!}
        {!! Form::file('img_title', null, ['class' => 'form-control']) !!}
    </div>
    @if ($errors->get('img_title'))
        @foreach($errors->get('img_title') as $item)
            <div class="alert alert-danger">
                {{$item}}
            </div>
        @endforeach
    @endif

    <div class="form-group">
        <h4 style="margin-top: 20px;">Выберите категорию</h4>
        {!! Form::select('category_id', $category->toArray(), null, ['class' => 'form-control', 'id' => 'category_id']) !!}
    </div>
    @if ($errors->get('category_id'))
        @foreach($errors->get('category_id') as $item)
            <div class="alert alert-danger">
                {{$item}}
            </div>
        @endforeach
    @endif

    <div class="form-group">
        {!! Form::label('body', 'Тело статьи:') !!}
        {!! Form::textarea('body', null, ['class' => 'form-control', 'id' => 'froala-editor', 'style' => 'min-height: 500px;']) !!}
    </div>
    @if ($errors->get('body'))
        @foreach($errors->get('body') as $item)
            <div class="alert alert-danger">
                {{$item}}
            </div>
        @endforeach
    @endif

{!! Form::submit($submitButton, ['class' => 'btn btn-primary']) !!}

