@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $helpers = new \App\Lib\Helper();
@endphp
    <!-- game section start -->
    <section class=" pb-100">
        <div class="container pb-100">
            <div class="row justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="card section--bg">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-sm-6"> 
                                     <h4 class="text-center">@lang('Total Amount') : 
                                        @php
                                            $dolr_rate = $helpers->get_currency_rates('USD');
                                            $total_bath = (auth()->user()->winnings + auth()->user()->balance + auth()->user()->commissions) / $dolr_rate;
                                        @endphp
                                        {{ Session::get('currency_symbol') }} {{ number_format($helpers->convert_to_currency(Session::get('currency'), $total_bath))}}</h4>
                                     <h4 class="text-center">@lang('Total Deposit') : 
                                        @php
                                            $dolr_rate = $helpers->get_currency_rates('USD');
                                            $total_deposit = auth()->user()->balance/ $dolr_rate;
                                        @endphp
                                        {{ Session::get('currency_symbol') }} {{ number_format($helpers->convert_to_currency(Session::get('currency'), $total_deposit))}} </h4>
                                     <h4 class="text-center">@lang('Total Winnings') : 
                                        @php
                                            $dolr_rate = $helpers->get_currency_rates('USD');
                                            $total_winings = auth()->user()->winnings/ $dolr_rate;
                                        @endphp
                                        {{ Session::get('currency_symbol') }} {{ number_format($helpers->convert_to_currency(Session::get('currency'), $total_winings))}} </h4>
                                     <h4 class="text-center">@lang('Total Commissions') : 
                                        @php
                                            $dolr_rate = $helpers->get_currency_rates('USD');
                                            $total_com = auth()->user()->commissions/ $dolr_rate;
                                        @endphp
                                        {{ Session::get('currency_symbol') }} {{ number_format($helpers->convert_to_currency(Session::get('currency'), $total_com))}} </h4>

                                </div>
                            </div>
                            <div class="row  mt-5 justify-content-center">
							{{--<a href="https://expatewallet.com/?type=raffle-game" target="_blank" class="btn  w-25 btn--base btn--custom">Deposit</a>--}}
                                <a href="https://expateshop.com/store/secret-gift-card-4u" target="_blank" class="btn  w-25 btn--base btn--custom">Deposit</a>
                            </div>
                            <form class="register prevent-double-click" action="{{ route('user.deposit.submit') }}" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                @csrf                                        
                                <div class="row mt-5 justify-content-center">
                                    <div class="form-group col-sm-6 text-center">
                                        <label for="deposit-code" class="col-form-label ">Deposit Code:</label>
                                        <input type="text" class="form--control valid" id="deposit-code" name="deposit_code" placeholder="Deposit Code" minlength="3" aria-invalid="false" required>
                                    </div>
                                </div>
                                <div class="row mt-5 justify-content-center">
                                    
                                    <div class="form-group col-sm-6 text-center">
                                        <button type="submit" class="btn w-50 btn--base btn--custom">Process</button>
                                    </div>
                                </div>

                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- game section end -->
@endsection
