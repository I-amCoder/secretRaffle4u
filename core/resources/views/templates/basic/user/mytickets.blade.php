@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $helpers = new \App\Lib\Helper();
@endphp
<style>
    .t-h tr{
        background-color: #b4903a !important;
    }
    .hide{
        display: none;
    }
</style>
    <div class="container pt-100 pb-100">
        <div class="row justify-content-center">
            <div class="col-md-12">

                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th>@lang('Raffle Game')</th>
                                <th>@lang('Total Tickets')</th>
                                <th>@lang('Amount')</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($logs) >0)
                                @foreach($logs as $k=>$data)
                                    <tr onclick="details({{ $k }})" style="cursor: pointer">
                                        @php
                                            $tickets = $data->raffle_game->my_tickets_count();
                                            $tickets_details = $data->raffle_game->my_tickets();
                                            // echo "<pre>";print_r($tickets_details);
                                            // dd($tickets_details)
                                            // dd($tickets_details)
                                        @endphp
                                        <td data-label="#@lang('Raffle Game')">{{$data->raffle_game->title}}</td>
                                        <td data-label="@lang('Total Tickets')">{{ $tickets['ticket_count'] }}</td>
                                        <td data-label="@lang('Amount')">
                                            
                                            {{ Session::get('currency_symbol') }} {{ number_format($helpers->convert_to_currency(Session::get('currency'), $tickets['amount']),2) }} 
                                        </td>

                                        
                                    </tr>
                                    <tr  class="collapse" id="demo-{{ $k }}">
                                        <td colspan="100%">
                                            <table class="table  custom--table" >
                                                <thead class="t-h">
                                                    <th>
                                                        Ticket No
                                                    </th>
                                                    <th>Ticket Amount</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->raffle_game->my_tickets() as $t)
                                                    <tr>
                                                    <td>{{ $t->ticket_code }}</td>
                                                    <td><strong>
													{{-- showAmount($t->amount) }} {{__($general->cur_text)--}}
													{{ number_format($helpers->convert_to_currency(Session::get('currency'), $t->amount),2) }} {{ Session::get('currency_symbol') }}
													</strong></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <div  class="">

                                        
                                    </div>
                                    
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    

            </div>
        </div>
    </div>

    <script>
        function details(id) { 
            // alert(id);
            $('#demo-'+id).toggleClass('collapse');
         }
    </script>
@endsection


