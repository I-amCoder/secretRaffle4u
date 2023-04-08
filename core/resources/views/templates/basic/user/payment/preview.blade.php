@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container pt-100 pb-100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-deposit text-center section--bg">
                    <div class="card-body card-body-deposit">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('Image')" class="w-auto" />
                            </div>
                            <div class="col-md-6 align-self-center">
                                <ul class="list-group text-center">
                                    <p class="list-group-item section--bg">
                                        @lang('Amount'):
                                        <strong>{{showAmount($data->amount)}} </strong> {{__($general->cur_text)}}
                                    </p>
                                    <p class="list-group-item section--bg">
                                        @lang('Charge'):
                                        <strong>{{showAmount($data->charge)}}</strong> {{__($general->cur_text)}}
                                    </p>
                                    <p class="list-group-item section--bg">
                                        @lang('Payable'): <strong> {{showAmount($data->amount + $data->charge)}}</strong> {{__($general->cur_text)}}
                                    </p>
                                    <p class="list-group-item section--bg">
                                        @lang('Conversion Rate'): <strong>1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}</strong>
                                    </p>
                                    <p class="list-group-item section--bg">
                                        @lang('In') {{$data->baseCurrency()}}:
                                        <strong>{{showAmount($data->final_amo)}}</strong>
                                    </p>


                                    @if($data->gateway->crypto==1)
                                        <p class="list-group-item section--bg">
                                            @lang('Conversion with')
                                            <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                        </p>
                                    @endif
                                </ul>
                                <hr>
                                @if( 1000 >$data->method_code)
                                    <a href="{{route('user.deposit.confirm')}}" class="btn btn--base btn--custom w-100 font-weight-bold">@lang('Pay Now')</a>
                                @else
                                    <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn--base btn--custom w-100 font-weight-bold">@lang('Pay Now')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


