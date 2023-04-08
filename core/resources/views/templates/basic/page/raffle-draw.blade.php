@extends($activeTemplate . 'layouts.frontend')

@section('content')

    <style>
        .img-fluid {
            height: 240px;
            width: 100%;
        }
    </style>

    @php
        $banner = getContent('rafflebanner.content', true);
        $rafflebannerMobile = getContent('rafflebannerMobile.content', true);
        $helpers = new \App\Lib\Helper();
    @endphp

    {{--
<img
    src="{{ getImage('assets/images/frontend/rafflebannerMobile/' . @$rafflebannerMobile->data_values->image, '1920x961') }}"
    style="max-width: 100%;"
    class="d-md-none"
>

<img
    src="{{ getImage('assets/images/frontend/rafflebanner/' . @$banner->data_values->image, '1920x961') }}"
    style="max-width: 100%;"
    class="d-none d-md-block"
>
--}}
    <!-- ===========================  Banner  =========================== -->
    <?php /** / ?> ?>
    <div class="banner d-none" {{-- style="background-image: url({{ asset('assets/images/banner/raffle-draw.png') }}); padding: 70px 0px; height: 580px;" --}}
        style="
        background-image: url({{ getImage('assets/images/frontend/rafflebanner/' . @$banner->data_values->image, '1920x961') }});
        height: 500px;
        background-position: center;
    ">
        <div class="container">
            <div class="row">
                <div class="banner_content text-center align-items-center pt-4">
                    {{-- <h2>Raffle Draw</h2> --}}
                    {{-- <img src="{{ asset('assets/images/banner/ticket2.png') }}" width="450" class="img-fluid" alt="image"> --}}
                </div>
            </div>
        </div>
    </div>
    <?php /**/ ?>
    <!-- ===========================  Raffle Drew  =========================== -->
    <div class="raffile_drew_sec card_sec mb-5 p-0">

        <div class="container">

            @if (isset($raffle_cat) && count($raffle_cat) > 0)
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
                                </div>
                            </div>
                        </div>

                        <div class="card_bg mb-5">
                            <div class="d-flex justify-content-center">
                                <div class="col-lg-9">
                                    <div class="row g-5">

                                        @if (isset($raffles) && count($raffles) > 0)
                                            @foreach ($raffles as $key => $item)
                                                @if ($item->category_id == $cat->id)
                                                    <div class="col-md-6 text-center">
                                                        <div class="raffle_draw_pro">

                                                            <h2 style="margin-bottom: 10px; font-size: 24px;">
                                                                {{ $item->title }}</h2>

                                                            {{-- <h2 style="margin-bottom: 10px;">Jackpot Prize ฿ {{ $item->jackpot_prize_total }} </h2> --}}
                                                            <h2 style="margin-bottom: 10px;">Jackpot Prize
                                                                {{ Session::get('currency_symbol') }}
                                                                {{ number_format($helpers->convert_to_currency(Session::get('currency'), $item->jackpot_prize_total)) }}
                                                            </h2>

                                                            <h2 style="margin-bottom: 10px;  font-size: 16px;">
                                                                {{ $item->sub_title }}</h2>

                                                            <a style="background: none;padding: 0;margin: 0; width:100%"
                                                                href="{{ route('raffle-draw-details', $item->id) }}">
                                                                <?php
                                                                $thumb_img = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/game/thumb_' . $item->photo;
                                                                ?>
                                                                @if (file_exists($thumb_img))
                                                                    <img src="{{ getRafflePhoto('thumb_' . $item->photo) }}"
                                                                        class="img-fluid" alt="image">
                                                                @else
                                                                    <img src="{{ getRafflePhoto($item->photo) }}"
                                                                        class="img-fluid" alt="image">
                                                                @endif

                                                            </a>

                                                            {{-- <a href="{{ route('raffle-draw-details',$item->id) }}">{{ $general->cur_sym }}{{ number_format($item->unit_price,2) }}</a> --}}
                                                            <a
                                                                href="{{ route('raffle-draw-details', $item->id) }}">{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $item->unit_price), 2) }}</a>

                                                            <div class="mt-3">
                                                                <div class="row">
                                                                    <h2
                                                                        style="margin-bottom: 10px; font-size: 16px; text-center;">
                                                                        {{ $cat->name }} Game</h2>

                                                                </div>
                                                            </div>

                                                            @php
                                                                $endtimeHours = 10;
                                                                $endtimeMinutes = 12;
                                                                $endtimeSeconds = 10;
                                                                $duration_year = date('Y', strtotime($item->end_time));
                                                                $duration_month = date('m', strtotime($item->end_time));
                                                                $duration_days = date('d', strtotime($item->end_time));
                                                                $duration_hours = date('H', strtotime($item->end_time));
                                                                $duration_minutes = date('i', strtotime($item->end_time));
                                                                $duration_seconds = date('s', strtotime($item->end_time));
                                                                $now_ = date('Y-m-d H:i:s');
                                                                // "2022-10-16 20:10:50"
                                                                $start_time = date('Y-m-d H:i:s', strtotime($item->start_time));
                                                                // "2022-10-17 08:11:00"
                                                                $end_time = date('Y-m-d H:i:s', strtotime($item->end_time));
                                                                // "2022-10-14 23:59:00"
                                                                // dd($end_time);
                                                            @endphp


                                                            @if ($item->status = 0)
                                                                <h2 class="text-center draw-text pt-md-4 pt-sm-2">The raffle
                                                                    game in no more available</h2>
                                                            @elseif($start_time > $now_)
                                                                <!-- ===========================  coundown  =========================== -->
                                                                <div style="color:#fff;">Buy Tickets in</div>
                                                                <div style="font-size: 26px; color: #D4C07E;"
                                                                    id="cd100<?= $key ?>"></div>
                                                                @php
                                                                    $new_time = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($item->start_time)));
                                                                @endphp
                                                                @push('script')
                                                                    <script>
                                                                        counter("cd100" + {{ $key }}, "{{ $new_time }}")
                                                                    </script>
                                                                @endpush
                                                            @elseif($end_time < $now_)
                                                                <h2 class="text-center draw-text pt-md-4 pt-sm-2">Raffle
                                                                    game is over</h2>
                                                            @elseif($end_time > $now_ && ($item->status = 1))
                                                                <!-- ===========================  coundown  =========================== -->
                                                                <div style="color:#fff;">Game ends in</div>
                                                                <div style="font-size: 26px; color: #D4C07E;"
                                                                    id="cd100<?= $key ?>"></div>
                                                                @php
                                                                    $new_time = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($item->end_time)));
                                                                @endphp
                                                                @push('script')
                                                                    <script>
                                                                        counter("cd100" + {{ $key }}, "{{ $new_time }}")
                                                                    </script>
                                                                @endpush
                                                            @else
                                                                <h2 class="text-center draw-text pt-md-4 pt-sm-2">The raffle
                                                                    game in no more available</h2>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @php
                                                        array_push($games, $item->id);
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        {{--
                            @php
                            $free_tickets = freetickets($games);
                            @endphp

                            @if (isset($free_tickets) && count($free_tickets) > 0)
                                @foreach ($free_tickets as $k => $free)
                                    <div class="col-md-6 text-center">
                                        <div class="raffle_draw_pro">
                                            <h2>{{ $free->name }}</h2>
                                            <img src="{{ getFreeTicketPhoto($free->photo) }}" class="img-fluid" alt="image">
                                            <a href="{{route('raffleDrawFree')}}">Free</a>
                                        </div>
                                    </div>

                                @endforeach
                            @endif --}}

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            @endif

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

        </div>
    </div>
@endsection
