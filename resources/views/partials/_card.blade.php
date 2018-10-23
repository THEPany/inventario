<div class="card {{ $card_style ?? '' }} shadow-sm">
    <h5 class="card-header bg-white border-0 {{ $header_style ?? '' }}">{{ $header ?? '' }}</h5>
    <div class="card-body {{ $body_style ?? '' }}">
        @include('partials._alert')
        {{ $slot }}
    </div>
</div>