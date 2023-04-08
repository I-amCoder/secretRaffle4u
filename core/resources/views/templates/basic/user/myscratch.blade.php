@extends($activeTemplate . 'layouts.master')
@section('content')
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    @php
        $helpers = new \App\Lib\Helper();
        $sliver_raffle_games = DB::table('scratch_game_tickets')
            ->select('scratch_game_tickets.*', 'raffle_games.title', 'raffle_games.total_tickets', 'raffle_games.min_tickets', 'raffle_games.min_tickets_status')
            ->join('raffle_games', 'raffle_games.id', '=', 'scratch_game_tickets.raffle_game_id')
            ->where('scratch_game_tickets.is_booked', 0)
            ->where('scratch_game_tickets.status', '>', 0)
            ->where('scratch_game_tickets.scratch_game_id', 3)
            ->groupBy('scratch_game_tickets.raffle_game_id')
            ->get();
        $gold_raffle_games = DB::table('scratch_game_tickets')
            ->select('scratch_game_tickets.*', 'raffle_games.title', 'raffle_games.total_tickets', 'raffle_games.min_tickets', 'raffle_games.min_tickets_status')
            ->join('raffle_games', 'raffle_games.id', '=', 'scratch_game_tickets.raffle_game_id')
            ->where('scratch_game_tickets.is_booked', 0)
            ->where('scratch_game_tickets.status', '>', 0)
            ->where('scratch_game_tickets.scratch_game_id', 4)
            ->groupBy('scratch_game_tickets.raffle_game_id')
            ->get();
        // echo "<pre>";print_r($raffle_games);echo "</pre>";
    @endphp
    <style>
        .t-h tr {
            background-color: #b4903a !important;
        }

        .inner-table tbody tr {
            background-color: #000 !important;
        }
    </style>
    <div class="container pt-100 pb-100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="alert alert-primary"><b>*Note:</b> Your FREE! scratch cards are available once you have purchased
                    raffle tickets. </div>
                <div class="table-responsive--md">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Scratch Game')</th>
                                <th>@lang('Total Scratch Cards')</th>
                                <th>@lang('Available')</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Free Silver Scratch</td>
                                <td>{{ $free_silver }}</td>
                                <td>{{ $free_silver_actv }}</td>

                            </tr>
                            <tr class="" id="demo-">
                                <td colspan="100%">
                                    <table class="table custom--table inner-table">
                                        <thead class="t-h">
                                            <tr>
                                                <th>Free Silver Scratch With Raffle Games</th>

                                                <th>Free Scratch Cards</th>
                                                <th>Action</th>
                                                <th>Minimum Tickets</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($sliver_raffle_games->count() > 0)
                                                @foreach ($sliver_raffle_games as $key => $item)
                                                    @php
                                                        
                                                        $this_game_ticket_count = DB::table('scratch_game_tickets')
                                                            ->where('raffle_game_id', $item->raffle_game_id)
                                                            ->where('status', '>', 0)
                                                            ->where('is_booked', 0)
                                                            ->count();
                                                        // $bar_width = 0;
                                                        // if ($item->min_tickets_status == 1) {
                                                        //     $bar_width = 100;
                                                        // } else {
                                                        //     $bought_tickets = DB::table('raffle_tickets')
                                                        //         ->where('raffle_game_id', $item->raffle_game_id)
                                                        //         ->count();
                                                        //     $bar_width = round(($bought_tickets / $item->min_tickets) * 100);
                                                        // }
                                                        $bar_width = round((($free_silver - $free_silver_actv) / $free_silver) * 100);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ number_format($this_game_ticket_count) }}</td>
                                                        <td><a href="{{ route('scratch_cards_game', $item->scratch_game_id) }}"
                                                                style="padding: 2px 2px; width: 70px;"
                                                                class="btn  btn--base btn--custom ">Play</a>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <div
                                                                style="border:1px solid #b4903a; border-radius:8px; overflow:hidden;">
                                                                <div
                                                                    style="background-color:#b4903a; height:10px; width:{{ $bar_width }}%;">
                                                                </div>
                                                            </div>
                                                            {{ $bar_width }}%
                                                            <br>
                                                            <div class="badge badge-success bg-primary">
                                                                Used: {{ $free_silver - $free_silver_actv }}
                                                            </div>
                                                            <div class="badge bg-success badge-success">
                                                                Available: {{ $free_silver }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" style="text-align:center;">No Tickets</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Free Gold Scratch</td>
                                <td>{{ $free_gold }}</td>
                                <td>{{ $free_gold_actv }}</td>
                            </tr>
                            <tr class="" id="demo-">
                                <td colspan="100%">
                                    <table class="table custom--table inner-table">
                                        <thead class="t-h">
                                            <tr>
                                                <th>Free Gold Scratch With Raffle Games</th>
                                                <th>Free Scratch Cards</th>
                                                <th>Action</th>
                                                <th>Minimum Tickets</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($gold_raffle_games->count() > 0)
                                                @foreach ($gold_raffle_games as $key => $item)
                                                    @php
                                                        $this_game_ticket_count = DB::table('scratch_game_tickets')
                                                            ->where('raffle_game_id', $item->raffle_game_id)
                                                            ->where('status', '>', 0)
                                                            ->where('is_booked', 0)
                                                            ->count();
                                                        // $bar_width = 0;
                                                        // if ($item->min_tickets_status == 1) {
                                                        //     $bar_width = 100;
                                                        // } else {
                                                        //     $bought_tickets = DB::table('raffle_tickets')
                                                        //         ->where('raffle_game_id', $item->raffle_game_id)
                                                        //         ->count();
                                                        //     $bar_width = round(($bought_tickets / $item->min_tickets) * 100);
                                                        // }
                                                        $bar_width = round((($free_gold - $free_gold_actv) / $free_gold) * 100);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ number_format($this_game_ticket_count) }}</td>
                                                        <td><a href="{{ route('scratch_cards_game', $item->scratch_game_id) }}"
                                                                style="padding: 2px 2px; width: 70px;"
                                                                class="btn  btn--base btn--custom ">Play</a>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <div
                                                                style="border:1px solid #b4903a; border-radius:8px; overflow:hidden;">
                                                                <div
                                                                    style="background-color:#b4903a; height:10px; width:{{ $bar_width }}%;">
                                                                </div>
                                                            </div>
                                                            {{ $bar_width }}%
                                                            <br>
                                                            <div class="badge badge-success bg-primary">
                                                                Used: {{ $free_gold - $free_gold_actv }}
                                                            </div>
                                                            <div class="badge badge-success bg-success">
                                                                Available: {{ $free_gold }}
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" style="text-align:center;">No Tickets</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @if (count($logs) > 0)
                                @foreach ($logs as $k => $data)
                                    <tr>

                                        @php
                                            $my_scratch_count = $data->scratch_game->my_scratch_count();
                                            // echo "<pre>";print_r($tickets_details);
                                            // dd($tickets_details)
                                            // dd($tickets_details)
                                        @endphp
                                        <td data-label="#@lang('Scratch Game')">{{ $data->scratch_game->title }}</td>
                                        <td data-label="@lang('Total Scratch Cards')">{{ $my_scratch_count['scratch_count'] }}</td>
                                        <td data-label="@lang('Available')">

                                            {{ Session::get('currency_symbol') }}
                                            {{ number_format($helpers->convert_to_currency(Session::get('currency'), $my_scratch_count['amount'])) }}
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


@endsection
