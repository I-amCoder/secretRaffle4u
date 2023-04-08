@extends($activeTemplate .'layouts.master')
@section('content')
@php
    $helpers = new \App\Lib\Helper();
@endphp

    <section class="pb-100 pt-100">
        <div class="container">
			<h3>Raffle Games</h3>
            <div class="row">
                <div class="col-lg-12">
@php
//echo "<pre>";print_r($raffle_wins);echo "</pre>";
@endphp
                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Game Name')</th>
                                <th scope="col">@lang('Draw Date')</th>
                                <th scope="col">@lang('Win Bonus')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $raffle_wins as $key => $item )
                                <tr>
                                    <td data-label="@lang('Game')">{{ $item->title }}</td>
                                    <td data-label="@lang('Draw Date')">
                                        {{ date('m/d/Y',strtotime($item->updated_at)) }}
                                    </td>
                                    <td data-label="@lang('Win Bonus')">
                                        {{-- $general->cur_sym }}{{ __(getAmount($win->amo)) --}}
										{{ number_format($helpers->convert_to_currency(Session::get('currency'), $item->amount),2) }} {{ Session::get('currency_symbol') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $raffle_wins->links() }}

                </div>
            </div>
			<h3>Scratch Card Games</h3>
            <div class="row">
                <div class="col-lg-12">
@php
// echo "<pre>";print_r($scratch_wins);echo "</pre>";
@endphp
                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Game Name')</th>
                                <th scope="col">@lang('Draw Date')</th>
                                <th scope="col">@lang('Win Bonus')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $scratch_wins as $key => $item )
                                <tr>
                                    <td data-label="@lang('Game')">{{ $item->title }}</td>
                                    <td data-label="@lang('Draw Date')">
                                        {{ date('m/d/Y',strtotime($item->updated_at)) }}
                                    </td>
                                    <td data-label="@lang('Win Bonus')">
                                        {{-- $general->cur_sym }}{{ __(getAmount($win->amo)) --}}
										{{ number_format($helpers->convert_to_currency(Session::get('currency'), $item->winning_price),2) }} {{ Session::get('currency_symbol') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $scratch_wins->links() }}

                </div>
            </div>
        </div>
    </section>
@endsection
