@extends($activeTemplate.'layouts.master')
@section('content')
@php
$helpers = new \App\Lib\Helper();
@endphp
<style>
    
    
    .game-card{
        padding: 0px;
        padding-top: 1.5625rem;
        padding-bottom: 1.5625rem;
    }
</style>
    <!-- game section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row gy-4 justify-content-center">


                @forelse($raffles as $phase)

                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                        <div class="game-card text-center bg_img" style="background-image: url('{{asset($activeTemplateTrue.'images/bg/card-bg.png')}}');">
                            <h3 class="game-card__name mb-4">{{ __($phase->title) }}</h3>
                            <div class="game-card__thumb">
                                <img src="{{ getRafflePhoto($phase->photo) }}" alt="image">
                            </div>
                            <p class="mt-2 text--base game-card__amount mt-4">

                                {{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $phase->unit_price),2) }}
                            </p>
                            <a href="{{ route('scratch_cards_game',$phase->id) }}" class="btn btn--base btn--custom mt-4">@lang('Details')</a>
                        </div>
                    </div>

            @empty
            @endforelse

            </div>
        </div>
    </section>
    <!-- game section end -->
@endsection
