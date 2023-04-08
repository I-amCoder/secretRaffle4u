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
                                            <th scope="col">@lang('Transaction ID')</th>
                                            <th scope="col">@lang('Amount')</th>
                                            <th scope="col">@lang('Post Balance')</th>
                                            <th scope="col">@lang('Details')</th>
                                            <th scope="col">@lang('Date')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                     @if(count($logs) >0)
                                        @foreach($logs as $k=>$data)
                                            <tr>
                                                <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                                <td data-label="@lang('Amount')">
                                                    <strong @if($data->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($data->trx_type == '+') ? '+':'-'}} {{__(getAmount($data->amount))}} {{__($general->cur_text)}}</strong>
                                                </td>
                                                <td data-label="@lang('Remaining Balance')">
                                                    <strong class="text-info">{{getAmount($data->post_balance)}} {{__($general->cur_text)}}</strong>
                                                </td>
                                                <td data-label="@lang('Details')">{{$data->details}}</td>
                                                <td data-label="@lang('Date')">{{date('d M, Y', strtotime($data->created_at))}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%"> @lang('No results found')!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                        </div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
