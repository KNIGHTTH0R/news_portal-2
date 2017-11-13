@foreach($css as $key => $item){{ $key }} {

    @if(is_array($item))@foreach($item as $key => $value){{ $key }}:{{ $value }};@endforeach @else {{ $item }}

    @endif

}

@endforeach