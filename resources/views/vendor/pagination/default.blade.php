@if ($paginator->hasPages())
    <div class="row">
        <div class="mar-auto">
            @if ($paginator->lastPage() > 2)
                <div class="pag-dropup" data-drop-up id="drop-up">
                <ul class="pagination ul-custom">
                @foreach ($elements as $element)
                     @if (is_array($element))
                         @foreach ($element as $page => $url)
                             @if ($page != 1 && $page != $paginator->lastPage())
                                 @if ($page == $paginator->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                             @endif
                         @endforeach
                     @endif
                @endforeach
                </ul>
            </div>
            @else
                <div class="my-pop" data-drop-up id="drop-up">
                    <div class="arrow"></div>
                    <h3 class="popover-header">Oops...</h3>
                    <div class="popover-body">
                        <p>Промежуточные страницы отсутствуют.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
<div class="row">
    <div class="col-3 mar-auto">

    <ul class="pagination center-ul">

        {{-- First Page --}}
        @if($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">1</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}" rel="next">1</a></li>
        @endif

        <li class="page-item page-link under" data-pagination-dropup data-toggle>
            <span class="dots">. . .</span>
        </li>

        @if($paginator->lastPage() != $paginator->currentPage())
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">{{ $paginator->lastPage() }}</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">{{ $paginator->lastPage() }}</a></li>
        @endif
    </ul>
    </div>
</div>
@endif
