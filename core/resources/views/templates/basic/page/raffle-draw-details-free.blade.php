@extends($activeTemplate.'layouts.frontend')

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
@endpush


@section('content')

<!-- Search -->
<div class="offcanvas_search offcanvas offcanvas-top" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
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
                     <form action="#" method="post"
                     >
                         <div class="input-group">
                             <input type="text" name="search" id="search" class="form-control" placeholder="Search..." required>
                             <button type="submit" class="btn btn-primary input-text-group"><i class="fa fa-search"></i></button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
    </div>
</div>
<!-- ===========================  Banner  =========================== -->
<div class="banner" style="background-image: url({{ asset('assets/images/banner/banner-2.png') }}); padding: 70px 0px; height: 580px;">
    <div class="container">
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


@if(isset($raffle))
@if($raffle->status=0)
<h1 class="text-center draw-text pt-md-4 pt-sm-2">The raffle game in no more available</h1>
@elseif($start_time > $now_)
<h1 class="text-center draw-text pt-md-4 pt-sm-2">Raffle game not started yet</h1>
@elseif($end_time < $now_)
<h1 class="text-center draw-text pt-md-4 pt-sm-2">Raffle game is over</h1>
@elseif($end_time > $now_ && $raffle->status=1)
<!-- ===========================  coundown  =========================== -->
<div class="coundown">
    <div class="container">
        <div class="cd100"></div>
    </div>
</div>
@else
<h1 class="text-center draw-text pt-md-4 pt-sm-2">The raffle game in no more available</h1>
@endif
@endif

<!-- ===========================  Payout Structure  =========================== -->
<div class="payout_structure mt-5">
    <div class="container">
        <div class="row">
            <div class="section_heading mb-5 text-center">
                <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">

                <h3 style="vertical-align: middle;">
                    
                    @if(isset($raffle))
                        {{ $raffle->title }} <br /> 
                    @endif

                    Payout Structure
                </h3>

                <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9">
                <div class="structure_card">
                    <div class="row g-3 align-items-center">
                        <div class="col-xl-6">
                            <div class="total_price mb-3">
                                {{--OLD CODE--}}
                                {{--<h3>Jackpot Prize Total {{ $general->cur_sym }}{{ number_format($tital_gift_price,2) }}</h3>--}}
                                <h3>Jackpot Prize Total ฿ 4,685.00</h3>
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
                                        @if(isset($winning_seg) && count($winning_seg) > 0)
                                            @foreach($winning_seg as $k => $val)
                                                @if($val->type == 1)
                                                <tr>
                                                    <td>{{ $val->position }}<sup>{{ postionTxt($val->position) }}</sup></td>
                                                    <td>฿ {{ number_format($val->gift_price,0) }}</td>
                                                </tr>
                                                @elseif($val->type == 2)
                                                <tr>
                                                    <td>{{ $val->position }}<sup>{{ postionTxt($val->position) }}</sup> - {{ $val->position_end }}<sup>{{ postionTxt($val->position_end) }}</sup></td>
                                                    <td> {{ $general->cur_sym }} {{ number_format($val->gift_price,0) }}</td>
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
                                            <td>
                                                @if(isset($raffle))
                                                    {{ number_format($raffle->min_tickets,0) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Available Tickets</strong></td>
                                            <td>
                                                @if(isset($raffle))
                                                    {{ number_format($raffle->total_tickets,0) }}
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
                                            <th>Ticket</th>
                                            <th>Lucky Draw</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($free_lucky_draw) && count($free_lucky_draw) > 0 )
                                            @foreach($free_lucky_draw as $key => $free)
                                            <tr>
                                                <td>
                                                    <div class="ticket_item">
                                                        <h3>{{ $free->ticket_count }} <br /> TICKET</h3>
                                                        {{-- OLD CODE --}}
                                                        {{-- <h4>{{ number_format($free->purchased_ticket*$raffle->unit_price,0) }}{{ $general->cur_sym }}</h4> --}}
                                                        <h4>{{$free->ticket_amount}}</h4>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="lucky_draw">
                                                        {{-- OLD CODE --}}
                                                        {{--<h5>{{ $free->free_ticket }} {{ $free->free_ticket_name  }}</h5>--}}
                                                        <h5>{{$free->lucky_draw_text_line_one}}</h5>
                                                        <h5>{{$free->lucky_draw_text_line_two}}</h5>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===========================  Birthday gift  =========================== -->
<div class="birthday_gift">
    <div class="container">
        <div class="content text-center">
            <img 
                
                @if(isset($raffle))
                    src="{{ getRafflePhoto($raffle->photo) }}" 
                @endif

                alt=""
            >
            <h2>
                @if(isset($raffle))
                    {{ $raffle->title }}
                @endif
            </h2>
        </div>
    </div>
</div>
<!-- =========================== Raffle draw infomation  =========================== -->
<div class="raffle_draw_info">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="raffle_img text-center">
                    <img src="{{ asset('assets/images/raffile.png') }}" class="img-fluid" alt="image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="raffle_content">
                    <div class="site_title">
                        <h2>Raffle Game Information</h2>
                        <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt="icon">
                    </div>
                </div>

                @php

                    if(isset($raffle)){
                        $game_info = json_decode($raffle->game_info);
                    }
                    
                @endphp

                @if(isset($game_info) && count($game_info) > 0 )
                <div class="info_list">
                    <ul>
                        @foreach($game_info as $info )
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
            <div class="col-lg-6">
                <div class="site_title">
                    <h2>Raffle Game Rules</h2>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt="icon">
                </div>
                <div class="raffle_rules_list">
                    <ul>
                        <li>Only gamble what you can afford to in your means. Always Gamble Safely.</li>
                        <li>Game will start at 8pm (GMT+7) only if minimum tickets are sold.</li>
                        <li>If minimum tickets are not sold. All players will get full refund.</li>
                        <li>Your freeroll tickets will automatically enrolls you to the freeroll draw.</li>
                        <li> You can withdraw your winnings to “Expat eWallet” or any other method that is suitable for you in your country from our list.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="img text-center">
                    <img src="{{ asset('assets/images/rules.png') }}" class="img-fluid" alt="image">
                </div>
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
                <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                <h3 style="vertical-align: middle;">Christmas Island</h3>
                <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                <p>Time for Christmas Island time zone is the same as the following <br /> countries, Cambodia, Lao, Thailand, Vietnam and Western Indonesia</p>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
<script src="{{ asset('assets/vendor/flipclock.min.js') }}"></script>
<script src="{{ asset('assets/vendor/countdowntime.js') }}"></script>
{{--<script>
    $('.cd100').countdown100({
        endtimeYear: {{ $duration_year }},
        endtimeMonth: {{ $duration_month }},
        endtimeDate: {{ $duration_days }},
        endtimeHours: {{ $duration_hours }},
        endtimeMinutes: {{ $duration_minutes }},
        endtimeSeconds: {{ $duration_seconds }},
        timeZone: '',
    });
</script>
 <script>
    $('.cd100').countdown100({
        endtimeYear: 0,
        endtimeMonth: 0,
        endtimeDate: 35,
        endtimeHours: 18,
        endtimeMinutes: 0,
        endtimeSeconds: 0,
        timeZone: '',
    });
</script> --}}

@endpush
