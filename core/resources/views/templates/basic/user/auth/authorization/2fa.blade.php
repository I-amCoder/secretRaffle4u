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
                        <h4 class="fw-bold mt-5">@lang('2FA Verification')</h4>
                        <p>@lang('Current Time'): {{\Carbon\Carbon::now()}}</p>
                        <form class="account-from mt-4 text-start" method="POST" action="{{route('user.go2fa.verify')}}">
                            @csrf

                            <div class="form-group">
                                <label>@lang('Verification Code')</label>
                                <input type="text" name="code" id="code" class="form--control" placeholder="@lang('Enter Code')">
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base btn--custom w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
