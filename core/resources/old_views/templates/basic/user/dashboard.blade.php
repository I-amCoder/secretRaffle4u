@extends($activeTemplate.'layouts.master')
@section('content')
    <!-- game section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row gy-4 justify-content-center">

                @forelse($phases as $phase)
                    @if($phase->game->status == 1)
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                            <div class="game-card text-center bg_img" style="background-image: url('{{asset($activeTemplateTrue.'images/bg/card-bg.png')}}');">
                                <h3 class="game-card__name mb-4">{{ __($phase->game->name) }}</h3>
                                <div class="game-card__thumb">
                                    <img src="{{ getImage('assets/images/game/'.$phase->game->image, imagePath()['game']['size']) }}" alt="image">
                                </div>
                                <p class="mt-2 text--base game-card__amount mt-4">
                                    @lang('Invest Limit:') <br>
                                    {{ $general->cur_sym }}{{ __(getAmount($phase->game->min_limit)) }} - {{ $general->cur_sym }}{{ __(getAmount($phase->game->max_limit)) }}
                                </p>
                                <a href="{{ route('user.game.play',$phase->id) }}" class="btn btn--base btn--custom mt-4">@lang('Play Now')</a>
                            </div><!-- game-card end -->
                        </div>
                    @endif
                @empty
                @endforelse

            </div>
        </div>
    </section>
    <!-- game section end -->
@endsection
