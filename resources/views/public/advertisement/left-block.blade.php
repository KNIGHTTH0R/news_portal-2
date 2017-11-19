<div class="adv-left">
    @foreach($adv_left as $block)
        <div class="adv-admin">
            <div class="adv-head">{{ $block->seller }}</div>
            <hr>
            <div class="adv-body">{{ $block->text }}</div>
            <hr>
            <div class="adv-div-price">
                <span class="adv-price"
                      data-sale-price="{{ $block->sale_price }}"
                      data-price="{{ $block->price }}"
                      data-popover-id="{{ $block->id }}">{{ $block->price }}</span>
            </div>
            <div class="popover" id="popover_id_{{$block->id}}">
                <div class="popover-header">{{ $block->sale_title }}</div>
                <div class="popover-body">{{ $block->sale_text }}</div>
            </div>
        </div>
    @endforeach
</div>