@extends($activeTemplate.'layouts.auth')

@section('content')
    @php
        $account_content = getContent('account.content', true);
    @endphp

    <!-- account section start -->
    <div class="account-section bg_img" style="background-image: url('{{ getImage('assets/images/frontend/account/' . @$account_content->data_values->background_image, '1920x1080') }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="account-wrapper text-center">
                        <a href="{{ route('home') }}" class="account-logo">
                          <img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="image">
                        </a>
                        <h2 class="fw-bold mt-5">@lang('Reset Password')</h2>
                        <form class="account-from mt-4 text-start" method="POST" action="{{ route('user.password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label>@lang('Select One')</label>
                                <select class="form--control" name="type">
                                    <option value="email" class="text-dark">@lang('E-Mail Address')</option>
                                    <option value="username" class="text-dark">@lang('Username')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="my_value"></label>
                                <input type="text" class="form--control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base btn--custom w-100">@lang('Send Password Code')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- account section end -->
@endsection
@push('script')
<script>

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush
