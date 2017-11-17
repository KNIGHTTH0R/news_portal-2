{{--<!-- Button trigger modal -->--}}
{{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">--}}
    {{--Launch demo modal--}}
{{--</button>--}}

<!-- Modal -->
<div class="modal fade" id="subscribe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Подпишитесь на рассылку новостей</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' => 'IndexController@subscribe', 'id' => 'subscribe_form', 'name' => 'subscribe']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Имя Фамилия ') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'subscribe_name']) !!}
                    <div class="invalid-feedback" id="subscribe_name_error" style="display:none;"></div>

                </div>
                <div class="form-group">
                    {!! Form::label('email') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'subscribe_email']) !!}
                    <div class="invalid-feedback" id="subscribe_email_error" style="display:none;"></div>
                </div>
                <button type="button" class="btn btn-primary" id="subscribe_submit">Подписаться</button>
                {{--                {!! Form::submit('Подписаться', ['class' => 'btn btn-primary']) !!}--}}
                {!! Form::close() !!}               </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>