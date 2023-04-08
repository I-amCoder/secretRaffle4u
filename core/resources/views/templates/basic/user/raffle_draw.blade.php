@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $helpers = new \App\Lib\Helper();
    @endphp
    <style>
        .game-card {
            padding: 0px;
            padding-top: 1.5625rem;
            padding-bottom: 1.5625rem;
        }
    </style>
    <!-- game section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                {{--
                @forelse($phases as $phase)
                    @if ($phase->game->status == 1)
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
                @endforelse --}}


                @foreach ($raffle_cat as $cat)
                    @php
                        $games = [];
                    @endphp

                    <div class="mb-5">
                        <div class="row d-flex justify-content-center">
                            <div class="bottom">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-10">
                                        <h2 class="raffle-cat">{{ $cat->title }}<img
                                                src="{{ asset('assets/images/icon/horizontal-left.png') }}"
                                                class="heading_arrow" alt=""></h2>
                                    </div>
                                    @forelse($raffles as $key=>$phase)
                                        @if ($phase->category_id == $cat->id)
                                            <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                                                <div class="game-card text-center bg_img"
                                                    style="background-image: url('{{ asset($activeTemplateTrue . 'images/bg/card-bg.png') }}');">
                                                    <h3 class="game-card__name mb-4">{{ __($phase->title) }}</h3>
                                                    <div class="game-card__thumb">
                                                        <img src="{{ getRafflePhoto($phase->photo) }}" alt="image">
                                                    </div>
                                                    {{-- <p class="mt-2 text--base game-card__amount mt-4">{{ $general->cur_sym }}{{ __(getAmount($phase->unit_price)) }}</p> --}}
                                                    <p class="mt-2 text--base game-card__amount mt-4">
                                                        {{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $phase->unit_price), 2) }}
                                                    </p>
                                                    @php
                                                        $endtimeHours = 10;
                                                        $endtimeMinutes = 12;
                                                        $endtimeSeconds = 10;
                                                        $duration_year = date('Y', strtotime($phase->end_time));
                                                        $duration_month = date('m', strtotime($phase->end_time));
                                                        $duration_days = date('d', strtotime($phase->end_time));
                                                        $duration_hours = date('H', strtotime($phase->end_time));
                                                        $duration_minutes = date('i', strtotime($phase->end_time));
                                                        $duration_seconds = date('s', strtotime($phase->end_time));
                                                        $now_ = date('Y-m-d H:i:s');
                                                        // "2022-10-16 20:10:50"
                                                        $start_time = date('Y-m-d H:i:s', strtotime($phase->start_time));
                                                        // "2022-10-17 08:11:00"
                                                        $end_time = date('Y-m-d H:i:s', strtotime($phase->end_time));
                                                        // "2022-10-14 23:59:00"
                                                        // dd($end_time);
                                                    @endphp

                                                    @if ($phase->status = 0)
                                                        <h2 class="text-center draw-text pt-md-4 pt-sm-2">The raffle game in
                                                            no more available</h2>
                                                    @elseif($start_time > $now_)
                                                        <!-- ===========================  coundown  =========================== -->
                                                        <div style="color:#fff;">Buy Tickets in</div>
                                                        <div style="font-size: 26px; color: #D4C07E;" id="cd100<?= $key ?>">
                                                        </div>
                                                        @php
                                                            $new_time = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($phase->start_time)));
                                                        @endphp
                                                        @push('script')
                                                            <script>
                                                                counter("cd100" + {{ $key }}, "{{ $new_time }}")
                                                            </script>
                                                        @endpush
                                                    @elseif($end_time < $now_)
                                                        <h2 class="text-center draw-text pt-md-4 pt-sm-2">Raffle game is
                                                            over</h2>
                                                    @elseif($end_time > $now_ && ($phase->status = 1))
                                                        <!-- ===========================  coundown  =========================== -->
                                                        <div style="color:#fff;">Game ends in</div>
                                                        <div style="font-size: 26px; color: #D4C07E;" id="cd100<?= $key ?>">
                                                        </div>
                                                        @php
                                                            $new_time = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($phase->end_time)));
                                                        @endphp
                                                        @push('script')
                                                            <script>
                                                                counter("cd100" + {{ $key }}, "{{ $new_time }}")
                                                            </script>
                                                        @endpush
                                                    @else
                                                        <h2 class="text-center draw-text pt-md-4 pt-sm-2">The raffle game in
                                                            no more available</h2>
                                                    @endif
                                                    <a href="{{ route('raffle-draw-details', $phase->id) }}"
                                                        class="btn btn--base btn--custom mt-4">@lang('Details')</a>
                                                </div>
                                            </div>
                                        @endif

                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>



                    </div>
                @endforeach





            </div>
        </div>
    </section>
    <!-- game section end -->
@endsection
<script>
    function counter(obj, date) {



        // Set the date we're counting down to
        var countDownDate = new Date(date).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById(obj).innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(obj).style.display === "none";
            }
        }, 1000);

    }
</script>
