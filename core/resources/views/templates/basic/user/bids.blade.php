@extends($activeTemplate .'layouts.master')
@section('content')

    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Game Name')</th>
                                <th scope="col">@lang('Select')</th>
                                <th scope="col">@lang('Invest Amount')</th>
                                <th scope="col">@lang('Draw Date')</th>
                                <th scope="col">@lang('Draw Status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse( $bids as $bid )
                                <tr>
                                    <td data-label="@lang('Game')">{{ __($bid->game->name) }}</td>
                                    <td data-label="@lang('Select')">
                                        @if($bid->game->id == 4 || $bid->game->id == 5)
                                            @foreach($bid->chooses as $choose)
                                                {{ $choose->choose }}@if($loop->last) @else,@endif
                                            @endforeach
                                        @else
                                            {{ __($bid->user_choose) }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Invest Amount')">{{ $general->cur_sym }}{{ __(getAmount($bid->invest)) }}</td>
                                    <td data-label="@lang('Draw Date')">{{ __(showDateTime($bid->phase->end_date,'Y-m-d')) }}</td>
                                    <td data-label="@lang('Draw Status')">
                                        @if($bid->phase->draw_status == 1)
                                            <span class="badge badge--success">
                                                        @lang('Draw Complete')
                                                    </span>
                                        @elseif($bid->phase->draw_status == 0)
                                            <span class="badge badge--danger">
                                                        @lang('Running')
                                                    </span>
                                        @else
                                            <span class="badge badge--warning">
                                                      @lang('Waiting for result')
                                                    </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">@lang('Bid Not Found')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $bids->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
