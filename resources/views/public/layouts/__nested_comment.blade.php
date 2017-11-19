<ul class="nested_comment" id="nested_comment_{{$parent_id}}">
    @foreach($nested_comment as $comment)
        @if ($comment->allowed !== 0)
            @if($comment->trashed())
                <li class="comment" id="comment_{{ $comment->id }}" data-owner="{{ $comment->user->name }}">
                    <div class="comment_head_deleted">
                        Пользователь <b>{{ $comment->user->name }}</b> удалил свой комментарий
                        {{ \Carbon\Carbon::parse($comment->deleted_at)->diffForHumans() }}
                    </div>
                    <div class="comment_body">
                    </div>
                    <hr>
                </li>
                @if($comment->child()->withTrashed()->get()->isNotEmpty())
                    @include('public.layouts.__nested_comment', ['nested_comment' => $comment->child, 'parent_id' => $comment->id])
                @endif
            @else
                <li class="comment" id="comment_{{ $comment->id }}" data-owner="{{ $comment->user->name }}">
                    <div class="comment_head">
                        <b>{{ $comment->user->name }}</b> ответил: <i>{{$comment->parent()->withTrashed()->get()[0]->user->name }}</i>
                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                        @if(Auth::check())
                            @if($comment->user->name == Auth::user()->name)
                        <button type="button" class="close" data-id="{{$comment->id}}" data-del-comment id="del_comment_{{$comment->id}}">
                            <span aria-hidden="true">×</span>
                        </button>
                                @if(\Carbon\Carbon::parse($comment->created_at)->addMinute() > \Carbon\Carbon::now())
                                    <span class="edit{{ Auth::check() ? '': ' cursor-block' }}" data-id="{{ $comment->id }}" id="edit_{{ $comment->id }}">
                                        редактировать
                                    </span>
                                @endif
                            @else
                        <span class="reply{{ Auth::check() ? '': ' cursor-block' }}" data-id="{{ $comment->id }}" id="reply_{{ $comment->id }}">
                            reply
                        </span>
                            @endif
                        @endif
                        <div class="comment_head_right">
                            <span class="rate-up" id="rate_up_comment_id_{{$comment->id}}">{{ $comment->rate_up }}</span>
                            <button type="button" class="btn btn-default btn-sm rate-btn{{ Auth::check() ? '': ' cursor-block' }}" id="rate_up_{{ $comment->id }}" data-rate-up data-id="{{ $comment->id }}">
                                <i class="material-icons">thumb_up</i>                                        </button>
                            </button>
                            <button type="button" class="btn btn-default btn-sm rate-btn{{ Auth::check() ? '': ' cursor-block' }}" id="rate_down_{{ $comment->id }}" data-rate-down data-id="{{ $comment->id }}">
                                <i class="material-icons">thumb_down</i>                                        </button>
                            </button>
                            <span class="rate-down" id="rate_down_comment_id_{{$comment->id}}">{{ $comment->rate_down }}</span>
                        </div>
                    </div>
                    <div class="comment_body">
                        {{ $comment->body }}
                    </div>
                    @if($comment->child->isNotEmpty())
                        @include('public.layouts.__nested_comment', ['nested_comment' => $comment->child])
                    @endif
                </li>
            @endif
        @else
            @include('public.layouts.__modal_comment_validation')
        @endif
    @endforeach
</ul>