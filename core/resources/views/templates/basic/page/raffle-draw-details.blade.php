@extends($activeTemplate . 'layouts.frontend')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/flipclock.css') }}">

    <style>
        .draw-text {
            font-size: 33px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            color: #D4C07E;
            background-image: -webkit-linear-gradient(270deg, #ead17f 25%, #AC8A4D 76%);
            background-clip: text;
            -webkit-background-clip: text;
            text-fill-color: transparent;
            -webkit-text-fill-color: transparent;
            margin: 0;
            padding-top: 9px;
        }
    </style>
    <style>
        #timer-wrapper {
            width: 530px;
            margin: 0 auto;
            text-align: center;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 20px;
        }

        #timer-wrapper p {
            padding: 10px 0 0 0;
            margin: 0 0 0 0;
            color: #fff;
            font-size: 20px;
        }

        #timer-wrapper div {
            display: inline-block;
            line-height: 1;
            padding: 10px 20px 20px 20px;
            font-size: 60px;
        }

        #timer span {
            display: block;
            font-size: 20px;
            color: white;
        }

        #days {
            font-size: 100px;
            color: #db4844;
        }

        #hours {
            font-size: 100px;
            color: #f07c22;
        }

        #minutes {
            font-size: 100px;
            color: #f6da74;
        }

        #seconds {
            font-size: 50px;
            color: #abcd58;
        }
    </style>
@endpush

@php
    $helpers = new \App\Lib\Helper();
    $endtimeHours = 10;
    $endtimeMinutes = 12;
    $endtimeSeconds = 10;
    
    $now_ = date('Y-m-d H:i:s');
    // "2022-10-16 20:10:50"
    $start_time = date('Y-m-d H:i:s', strtotime($raffle->start_time));
    // "2022-10-17 08:11:00"
    $end_time = date('Y-m-d H:i:s', strtotime($raffle->end_time));
    // "2022-10-14 23:59:00"
    
    $date1 = new DateTime($now_);
    $date2 = new DateTime($end_time);
    $interval = $date1->diff($date2);
    // echo "<pre>";print_r($interval);echo "</pre>";
    // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
    
    $duration_year = date('Y', strtotime($raffle->end_time));
    $duration_month = date('m', strtotime($raffle->end_time));
    $duration_days = date('d', strtotime($raffle->end_time));
    $duration_hours = date('H', strtotime($raffle->end_time));
    $duration_minutes = date('i', strtotime($raffle->end_time));
    $duration_seconds = date('s', strtotime($raffle->end_time));
    // echo $duration_year."<br>";
    // echo $duration_month."<br>";
    // echo $duration_days."<br>";
    // echo $duration_hours."<br>";
    // echo $duration_minutes."<br>";
    // echo $duration_seconds."<br>";
    
    // dd($end_time);
    $helpers = new \App\Lib\Helper();
@endphp

@section('content')

    <div class="BuyTicketLoading"
        style="width:100%; height:100%; position:fixed; top:0; left:0; z-index:999; background:rgba(0,0,0,0.5);display:none;">
        <div
            style="width: 500px;
    background: #fff;
    margin: 15% auto 0;
    padding: 25px;
    border-radius: 14px;
    text-align: center;
    font-size: 15px;
    font-weight: 600;">
            <img src="{{ asset('assets/images/small-loading.gif') }}" class="img-fluid" alt="image"
                style="width: 50px !important;" />
            <br>
            Please wait as we create your tickets. This will 10-20 seconds depending on your internet connection speed and
            number of tickets bought.
        </div>
    </div>
    <!-- Search -->
    <div class="offcanvas_search offcanvas offcanvas-top" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="Search..." required>
                                <button type="submit" class="btn btn-primary input-text-group"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <img src="{{ getRafflePhoto($raffle->bannerMobile) }}" style="max-width: 100%;" class="d-md-none">

    <img src="{{ getRafflePhoto($raffle->banner) }}" style="max-width: 100%;" class=" d-none d-md-block">


    <!-- ===========================  Banner  =========================== -->
    <div class="banner d-none "
        style="background-image: url({{ getRafflePhoto($raffle->banner) }}); padding: 70px 0px; height: 500px;">
        <div class="container d-none">
            <div class="row">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="banner_img">
                            <img src="{{ asset('assets/images/banner/jackpot.png') }}" class="img-fluid" alt="image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="banner_img">
                            <img src="{{ asset('assets/images/banner/ticket.png') }}" class="img-fluid" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($raffle->status = 0)
        <h1 class="text-center draw-text pt-md-4 pt-sm-2">The raffle game in no more available</h1>
    @elseif($start_time > $now_)
        <!-- ===========================  coundown  =========================== -->
        <div id="timer-wrapper">
            <p>Buy tickets in</p>
            <div id="timer">
                <div id="days"></div>
                <div id="hours"></div>
                <div id="minutes"></div>
                <div id="seconds"></div>
            </div>
        </div>
    @elseif($end_time < $now_)
        <h1 class="text-center draw-text pt-md-4 pt-sm-2">Raffle game is over</h1>
    @elseif($end_time > $now_ && ($raffle->status = 1))
        <!-- ===========================  coundown  =========================== -->
        <div id="timer-wrapper">
            <p>Game ends in</p>
            <div id="timer">
                <div id="days"></div>
                <div id="hours"></div>
                <div id="minutes"></div>
                <div id="seconds"></div>
            </div>
        </div>
    @else
        <h1 class="text-center draw-text pt-md-4 pt-sm-2">The raffle game in no more available</h1>
    @endif
    <!-- ===========================  Payout Structure  =========================== -->
    <div class="payout_structure mt-5">
        <div class="container">
            <div class="row">
                <div class="section_heading mb-5 text-center">
                    <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow"
                        alt="icon">
                    <h3 style="vertical-align: middle;">
                        {{ $raffle->title }} <br />
                        {{ $raffle->sub_title }} <br />
                        <!-- Payout Structure -->
                    </h3>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow"
                        alt="icon">
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="structure_card" style="background: #161616;border: solid 2px #AC8A4D;">
                        <div class="row g-3 align-items-center">
                            <div class="col-xl-6">
                                <div class="total_price mb-3">
                                    {{-- OLD CODE --}}
                                    {{-- <h3>Jackpot Prize Total {{ $general->cur_sym }}{{ number_format($tital_gift_price,2) }}</h3> --}}
                                    <h3 style="font-size: 22px;">Payout Structure</h3>
                                    {{-- <h3>Jackpot Prize ฿ {{ $raffle->jackpot_prize_total }} </h3> --}}
                                    <h3>Jackpot Prize {{ Session::get('currency_symbol') }}
                                        {{ number_format($helpers->convert_to_currency(Session::get('currency'), $raffle->jackpot_prize_total)) }}
                                    </h3>
                                </div>
                                <div class="structure_table_left">
                                    <table class="table text-center">
                                        <thead>
                                            <tr style="background:#161616 !important;">
                                                <th>Position</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($winning_seg) && count($winning_seg) > 0)
                                                @foreach ($winning_seg as $k => $val)
                                                    @if ($val->type == 1)
                                                        <tr>
                                                            <td>{{ number_format($val->position) }}<sup>{{ postionTxt($val->position) }}</sup>
                                                            </td>
                                                            {{-- <td>฿ {{ number_format($val->gift_price,0) }}</td> --}}
                                                            <td>{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $val->gift_price), 2) }}
                                                            </td>
                                                        </tr>
                                                    @elseif($val->type == 2)
                                                        <tr>
                                                            <td>{{ number_format($val->position) }}<sup>{{ postionTxt($val->position) }}</sup>
                                                                -
                                                                {{ number_format($val->position_end) }}<sup>{{ postionTxt($val->position_end) }}</sup>
                                                            </td>
                                                            {{-- <td> {{ $general->cur_sym }} {{ number_format($val->gift_price,0) }}</td> --}}
                                                            <td>{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $val->gift_price), 2) }}
                                                            </td>

                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif


                                            {{-- <tr>
                                            <td>10<sup>St</sup> - 5,555<sup>St</sup></td>
                                            <td>฿ 10,000</td>
                                        </tr> --}}

                                            <tr>
                                                <td><strong>Minimum Tickets</strong></td>
                                                <td>{{ number_format($raffle->min_tickets, 0) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Available Tickets</strong></td>
                                                <td>{{ number_format($raffle->total_tickets, 0) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tickets Sold</strong></td>
                                                <td>
                                                    @if (number_format($total_tickets_sold, 0) >= 1000000)
                                                        {{ intval(number_format($total_tickets_sold, 0) / 1000000, 1) . 'M+' }}
                                                    @elseif (number_format($total_tickets_sold, 0) >= 1000)
                                                        {{ round(number_format($total_tickets_sold, 0) / 1000, 1) . 'K' }}
                                                    @else
                                                        {{ number_format($total_tickets_sold, 0) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="structure_table_right">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>{{ $raffle->ticket_price_heading }}</th>
                                                <th>{{ $raffle->lucky_draw_heading }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (isset($free_lucky_draw) && count($free_lucky_draw) > 0)
                                                @foreach ($free_lucky_draw as $key => $free)
                                                    @php
                                                        //echo "<pre>";print_r($free);echo "</pre>";
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="ticket_item" style="cursor: pointer"
                                                                @if ($start_time < $now_ && $end_time > $now_ && ($raffle->status = 1)) onclick="buytickets({{ $free->ticket_count }}, '{{ $free->ticket_amount }}','{{ number_format($helpers->convert_to_currency(Session::get('currency'), $free->ticket_amount), 2) }}','{{ number_format($helpers->convert_to_currency('USD', $free->ticket_amount), 2) }}')" @else onclick="nobuytickets();" @endif>
                                                                <h3>{{ $free->ticket_count }} <br /> TICKET</h3>
                                                                {{-- OLD CODE --}}
                                                                {{-- <h4>{{ number_format($free->purchased_ticket*$raffle->unit_price,0) }}{{ $general->cur_sym }}</h4> --}}
                                                                {{-- <h4>{{$free->ticket_amount}}</h4> --}}
                                                                <h4>{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), str_replace(['฿', ' '], '', $free->ticket_amount)), 2) }}
                                                                </h4>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="lucky_draw">
                                                                {{-- OLD CODE --}}
                                                                {{-- <h5>{{ $free->free_ticket }} {{ $free->free_ticket_name  }}</h5> --}}
                                                                <h5>{{ $free->lucky_draw_text_line_one }}</h5>
                                                                <h5>{{ $free->lucky_draw_text_line_two }}</h5>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('user.buyticket', ['id' => $raffle->id]) }}" method="POST"
                            id="buytickets">
                            @csrf
                            <input type="hidden" name="tickets" id="tickets">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="session-currency-symbol" value="{{ Session::get('currency_symbol') }}" />
    <script>
        function nobuytickets() {
            Swal.fire({
                icon: "warning",
                // title: "test",
                <?php if($end_time < $now_){ ?>
                html: "This raffle game has ended. You can not buy any more tickets for this game. Please buy tickets for ongoing games.",
                <?php }else{ ?>
                html: "Please wait till the game starts. You can buy tickets once the game starts and the countdown timer reaches 0.0.0.0",
                <?php } ?>
                showCancelButton: false,
                confirmButtonText: 'Okay',
            });
        }

        function buytickets(tickets, price, price_currency, price_usd) {

            if (tickets) {
                // price = parseInt(price);
                var currency_symbol = $('#session-currency-symbol').val();
                // var total_currency = (parseFloat(price_currency)*parseInt(tickets).toFixed(2));
                var total_currency = price_currency;
                // var total_usd = (parseFloat(price_usd)*parseInt(tickets)).toFixed(2);
                var total_usd = price_usd;
                price_txt =
                    "{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), 'price'), 2) }}";
                Swal.fire({
                    icon: "warning",
                    // title: "By "+tickets+" tickets for "+price,
                    title: "Buy " + tickets + " tickets for " + currency_symbol + total_currency + " ($" +
                        total_usd + ")",
                    html: "Choose your payment method <br><input type='radio' checked /> <b>Deposit (default)</b><br><input type='radio' disabled /> Winnings<br><input type='radio' disabled /> Commissions",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    denyButtonText: `No, cancel it!`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#tickets').val(tickets);
                        $('#buytickets').submit();
                        $('.BuyTicketLoading').show();
                    }
                })
                //     swal.fire({
                //   title: "By "+tickets+" tickets for "+price,
                //   html: "Choose your payment method <br> Deoposit<br>",
                //   icon: "warning",
                //   buttons: [
                //     'No, cancel it!',
                //     'Yes, I am sure!'
                //   ],
                //   dangerMode: true,
                // }).then(function(isConfirm) {
                //   if (isConfirm) {
                //     $('#tickets').val(tickets);
                //     $('#buytickets').submit();
                //   }
                // });
                // var a = confirm('Are you Sure you want to buy '+tickets+ " Tickets");
                // if (a) {

                // }
            }
        }
    </script>
    <!-- ===========================  Birthday gift  =========================== -->
    <div class="birthday_gift">
        <div class="container">
            <div class=" row content text-center">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <img src="{{ getRafflePhoto($raffle->photo) }}" class="w-100">
                    <h2>{{ $raffle->title }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- =========================== Raffle draw infomation  =========================== -->
    <div class="raffle_draw_info">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="raffle_img text-center">
                        <img src="{{ asset('assets/images/raffile.png') }}" class="img-fluid w-50" alt="image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="raffle_content">
                        <div class="site_title">
                            <h2>Raffle Game Information</h2>
                            <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow"
                                alt="icon">
                        </div>
                    </div>

                    @php
                        $game_info = json_decode($raffle->game_info);
                        
                    @endphp

                    @if (isset($game_info) && count($game_info) > 0)
                        <div class="info_list">
                            <ul>
                                @foreach ($game_info as $info)
                                    <li>{{ $info }}</li>
                                @endforeach


                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- =========================== Raffle draw rules  =========================== -->
    <div class="draw_rules_sec">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <div class="img text-center">
                        <img src="{{ asset('assets/images/rules.png') }}" class="img-fluid w-50" alt="image">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="site_title">
                        <h2>Raffle Game Rules</h2>
                        <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow w-50"
                            alt="icon">
                    </div>


                    @php
                        $game_rules = json_decode($raffle->game_rules);
                        
                    @endphp

                    @if (isset($game_rules) && count($game_rules) > 0)
                        <div class="raffle_rules_list">
                            <ul>
                                @foreach ($game_rules as $rule)
                                    <li>{{ $rule }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- ===========================  Time Clock  =========================== -->
    <div class="time_clock_sec mb-5">
        <div class="container">
            <div class="clock_wrapper text-center">
                <div class="mb-5">
                    <img src="{{ asset('assets/images/clock.png') }}" class="img-fluid" alt="image">
                </div>
                <div class="section_heading">
                    <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow"
                        alt="icon">
                    <h3 style="vertical-align: middle;">{{ $raffle->bottom_box_input }}</h3>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow"
                        alt="icon">
                    <p>{{ $raffle->bottom_box_input_2 }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        function makeTimer(to_time = null) {
            // console.log('abc');

            // console.log(to_time);
            //		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");
            var endTime = new Date(to_time);
            // console.log(endTime);
            endTime = (Date.parse(endTime) / 1000);

            var now = new Date();
            // console.log(now);
            now = (Date.parse(now) / 1000);

            var timeLeft = endTime - now;
            if (timeLeft <= 0) {
                location.reload();
            }
            // console.log(timeLeft);
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

            if (hours < "10") {
                hours = "0" + hours;
            }
            if (minutes < "10") {
                minutes = "0" + minutes;
            }
            if (seconds < "10") {
                seconds = "0" + seconds;
            }

            $("#days").html(days + "<span>Days</span>");
            $("#hours").html(hours + "<span>Hours</span>");
            $("#minutes").html(minutes + "<span>Minutes</span>");
            $("#seconds").html(seconds + "<span>Seconds</span>");

        }
    </script>
    <script>
        var start_time = '{{ date('d F Y H:i:s', strtotime($start_time)) . ' GMT+07:00' }}';
        var end_time = '{{ date('d F Y H:i:s', strtotime($end_time)) . ' GMT+07:00' }}';
    </script>

    @if ($start_time > $now_)
        <script>
            setInterval(function() {
                makeTimer(start_time);
            }, 1000);
        </script>
    @elseif($end_time > $now_ && ($raffle->status = 1))
        <script>
            setInterval(function() {
                makeTimer(end_time);
            }, 1000);
        </script>
    @endif
@endpush
