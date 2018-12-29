<div class="card {{ $card_style ?? '' }} shadow-sm" @isset($card_style_raw) style="{{$card_style_raw}}" @endisset>
    <div class="card-header bg-white border-0 {{ $header_style ?? '' }}">
        @include('partials._alert')
        @isset($header) <h5>{{ $header }}</h5> @endisset
    </div>
    <div class="card-body bg-secondary {{ $body_style ?? '' }}">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer border-0 bg-secondary {{ $footer_style ?? '' }}">
            {{ $footer }}
        </div>
    @endisset
</div>