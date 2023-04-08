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
                        <h2 class="fw-bold mt-5">@lang('Verification Code')</h2>
                        <form class="account-from mt-4 text-start" method="POST" action="{{ route('user.password.verify.code') }}">
                            @csrf

                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="form-group">
                                <input type="text" name="code" id="code" class="form--control" placeholder="@lang('Enter Code')">
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base btn--custom w-100">@lang('Verify Code') <i class="las la-sign-in-alt"></i></button>
                            </div>
                            <div class="text-center">
                                <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a></p>
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
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush
