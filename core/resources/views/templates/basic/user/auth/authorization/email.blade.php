@extends($activeTemplate .'layouts.auth')
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
                        <h4 class="fw-bold mt-5">@lang('Please Verify Your Email to Get Access')</h4>
                        <p>@lang('Your Email'): <strong>{{auth()->user()->email}}</strong></p>
                        <form class="account-from mt-4 text-start" method="POST" action="{{route('user.verify.email')}}">
                            @csrf

                            <div class="form-group">
                                <label>@lang('Verification Code')</label>
                                <input type="text" name="email_verified_code" class="form--control" maxlength="7"
                                       id="code" placeholder="@lang('Enter Code')">
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base btn--custom w-100">@lang('Submit')</button>
                            </div>
                            <div class="text-center col-lg-12">
                                <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a
                                        href="{{route('user.send.verify.code')}}?type=email"
                                        class="forget-pass text--base"> @lang('Resend code')</a></p>
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
        (function ($) {
            "use strict";
            $('#code').on('input change', function () {
                var xx = document.getElementById('code').value;

                $(this).val(function (index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });

            });
        })(jQuery)
    </script>
@endpush
