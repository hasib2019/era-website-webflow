{{--
    Renders one animated counter.

    Each digit is a column of 0-9 that Webflow's IX2 scrolls into place: columns
    at an even position park on their first entry (`align-top`), odd ones on
    their last (`align-bottom`). The value is therefore markup, not text, which
    is why it is generated here rather than printed.

    $stat        the Stat record
    $withBreak   the export carries a <br> on the very first digit of the band
--}}
<div class="counting-animation">
    @foreach (str_split((string) $stat->value) as $column => $digit)
        @if ($column % 2 === 0)
            <div class="couting-column align-top"
                style="transform: translate3d(0px, -91%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                <div>{{ $digit }}@if (($withBreak ?? false) && $column === 0)<br>@endif</div>
                @foreach (range(9, 0) as $wheel)
                    <div>{{ $wheel }}</div>
                @endforeach
            </div>
        @else
            <div class="couting-column align-bottom"
                style="transform: translate3d(0px, 91%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                @foreach (range(9, 0) as $wheel)
                    <div>{{ $wheel }}</div>
                @endforeach
                <div>{{ $digit }}</div>
            </div>
        @endif
    @endforeach

    @if (filled($stat->suffix_html) || filled($stat->suffix))
        <div class="couting-column">
            @if (filled($stat->suffix_html))
                {!! $stat->suffix_html !!}
            @else
                <div>{{ $stat->suffix }}</div>
            @endif
        </div>
    @endif
</div>
