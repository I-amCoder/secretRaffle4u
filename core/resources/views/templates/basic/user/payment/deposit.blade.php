@extends($activeTemplate.'layouts.master')


@section('content')
    <div class="container pt-100 pb-100">
        <div class="row">
            @foreach($gatewayCurrency as $data)
                <div class="col-lg-3 col-md-3 mb-4">
                    <div class="card card-deposit section--bg">
                        <h5 class="card-header text-center">{{__($data->name)}}
                        </h5>
                        <div class="card-body card-body-deposit">
                            <img src="{{$data->methodImage()}}" class="card-img-top" alt="{{__($data->name)}}" class="w-100">
                        </div>
                        <div class="card-footer">
                            <a href="javascript:void(0)" data-id="{{$data->id}}"
                               data-name="{{$data->name}}"
                               data-currency="{{$data->currency}}"
                               data-method_code="{{$data->method_code}}"
                               data-min_amount="{{showAmount($data->min_amount)}}"
                               data-max_amount="{{showAmount($data->max_amount)}}"
                               data-base_symbol="{{$data->baseSymbol()}}"
                               data-fix_charge="{{showAmount($data->fixed_charge)}}"
                               data-percent_charge="{{showAmount($data->percent_charge)}}" class="btn btn-sm w-100 btn--base btn--custom custom-success deposit" data-bs-toggle="modal" data-bs-target="#depositModal">
                                @lang('Deposit Now')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <div class="modal fade custom--modal" id="depositModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="depositModalLabel"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency">
                            <input type="hidden" name="method_code" class="edit-method-code">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form--control" name="amount" placeholder="@lang('Amount')" required  value="{{old('amount')}}">
                                <span class="input-group-text">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <div class="prevent-double-click">
                            <button type="submit" class="btn btn--base btn--custom btn-sm confirm-btn">@lang('Confirm')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.deposit').on('click', function () {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            });
        })(jQuery);
    </script>
@endpush


@push('style')
<style type="text/css">

</style>
@endpush
