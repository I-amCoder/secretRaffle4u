@extends($activeTemplate.'layouts.auth')

@section('content')

    @php
        $account_content = getContent('account.content', true);
    @endphp
    <!-- account section start -->
    <link rel="stylesheet" href=
"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href=
"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity=
"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
    <div class="account-section bg_img" style="background-image: url('{{ getImage('assets/images/frontend/account/' . @$account_content->data_values->background_image, '1920x1080') }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="account-wrapper text-center">
                        <a href="{{ route('home') }}" class="account-logo">
                          <img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="image">
                        </a>
                        <h2 class="fw-bold mt-5">@lang('Sign In')</h2>
                        <form class="account-from mt-4 text-start" method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
                            @csrf

                            <div class="form-group">
                                <label for="username">@lang('Username or Email')</label>
                                <input type="text" id="username" name="username" autocomplete="off" class="form--control" placeholder="@lang('Username or Email')" required>
                            </div>
                            <div class="form-group">
                                <label for="Password">@lang('Password')</label>
                                <input type="password" name="password" id="Password" autocomplete="off" class="form--control" placeholder="@lang('Password')">
                                <i class="bi bi-eye-slash" style="margin-left: -30px; cursor: pointer; color: white;" id="togglePassword"></i>
                            </div>
                            <div class="form-group">
                                @php echo loadReCaptcha() @endphp
                            </div>
                            <div class="form-group">
                                @include($activeTemplate.'partials.custom_captcha')
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input type="checkbox"  name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember Me')</label>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit"  id="recaptcha" class="btn btn--base btn--custom w-100">@lang('Sign In')</button>
                            </div>
                            <div class="text-center">
                                <p>@lang('Haven\'t an account?') <a href="{{ route('user.register') }}" class="text--base">@lang('Create an account')</a></p>
                                <p></p>
                                <p><a href="{{route('user.password.request')}}" class="text--base">@lang('Forgot password?')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document
            .querySelector('#togglePassword');
  
        const password = document.querySelector('#Password');
  
        togglePassword.addEventListener('click', () => {
  
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'Password' ?
                'text' : 'Password';
                  
            password.setAttribute('type', type);
  
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye');
        });
    </script>
    <!-- account section end -->
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
