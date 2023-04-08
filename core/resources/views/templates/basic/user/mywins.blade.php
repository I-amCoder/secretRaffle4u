@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $helpers = new \App\Lib\Helper();
@endphp
    <div class="container pt-100 pb-100">
        <div class="row justify-content-center">
            <div class="col-md-12">

                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th>@lang('Raffle Game')</th>
                                <th>@lang('Winning Position')</th>
                                <th>@lang('Amount')</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($logs) >0)
                                @foreach($logs as $k=>$data)
                                    <tr>
                                        
                                        <td data-label="#@lang('Raffle Game')">{{$data->raffle_game->title}}</td>
                                        <td data-label="@lang('Winning Position')">{{ $data->winning_position }}</td>
                                        <td data-label="@lang('Amount')">
                                            
                                             {{ Session::get('currency_symbol') }} {{ number_format($helpers->convert_to_currency(Session::get('currency'), @$data->winning_price),2) }} 
                                        </td>
                                        
                                    </tr>
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

    
@endsection


