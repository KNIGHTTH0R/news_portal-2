<div class="row">
    <div class="col-12">
        <div class="form-group">
            <h6>Тэги</h6>
            {!! Form::select('tags[]', $tags_filter->toArray(), null,
              ['class' => 'form-control filter-select',
               'id' => 'tags-search',
               'multiple'=>'multiple',
               'style' => 'width: 400px;max-height: 50px;wid']) !!}
        </div>

        @if ($errors->get('tags.*'))
            @foreach($errors->get('tags.*') as $item)
                <div class="alert alert-danger">
                    @foreach($item as $one)
                        {{ $one }}
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <h6>Дата</h6>
            {!! Form::select('date', ['Не выбрано'] + [     null,
                                                            'last-day' => 'За последний день',
                                                            'last-week' => 'За последнюю неделю',
                                                            'last-month' => 'За последнией месяц',
                                                            'last-year' => 'За последнией год'
                                                        ],
            null,
            ['class' => 'form-control filter-select',
             'id' => 'tags-search',
             'style' => 'width: 400px;max-height: 50px;wid']) !!}
        </div>

        @if ($errors->get('date'))
            @foreach($errors->get('date') as $item)
                <div class="alert alert-danger">
                    @foreach($item as $one)
                        {{ $one }}
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <h6>Категория</h6>
            {!! Form::select('category', ['Не выбрано'] + $category_filter->toArray(),
            null,
            ['class' => 'form-control filter-select',
             'id' => 'tags-search',
             'style' => 'width: 400px;max-height: 50px;wid']) !!}
        </div>

        @if ($errors->get('category'))
            @foreach($errors->get('category') as $item)
                <div class="alert alert-danger">
                    @foreach($item as $one)
                        {{ $one }}
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::submit('Искать', ['class' => 'btn btn-primary']) !!}
        </div>

    </div>
</div>