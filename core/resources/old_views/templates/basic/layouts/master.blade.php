<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
@include('partials.seo')

<!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/bootstrap.min.css')}}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/font-awesome.min.css')}}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/slick.css')}}">
    <!-- main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    <link rel="stylesheet"
          href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color)}}">

    @stack('style-lib')

    @stack('style')
</head>
<body>

<!-- preloader start -->
<div class="preloader">
    <div class="preloader__container">
        <div class="preloader__box">
            <img src="{{asset($activeTemplateTrue.'images/elements/casino-board.png')}}" alt="image">
        </div>
        <div class="preloader__roller">
            <img src="{{asset($activeTemplateTrue.'images/elements/round-roller.png')}}" alt="image">
        </div>
    </div>
</div>
<!-- preloader end -->

<!-- header-section start  -->
<header class="header">
    <div class="header__bottom">
        <div class="container-fluid px-lg-5">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}"><img
                        src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu me-auto">
                        @auth
                            <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="menu_has_children">
                                <a href="#">@lang('Deposit')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.deposit') }}">@lang('Deposit Now')</a></li>
                                    <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a href="#">@lang('Withdraw')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                                    <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a href="#">@lang('Reports')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.wins') }}">@lang('wins')</a></li>
                                    <li><a href="{{ route('user.bids') }}">@lang('bids')</a></li>
                                    <li><a href="{{ route('user.commissions') }}">@lang('Commissions')</a></li>
                                    <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a href="#">@lang('Ticket')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('ticket.open') }}">@lang('Create New')</a></li>
                                    <li><a href="{{ route('ticket') }}">@lang('My Ticket')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a href="#">@lang('Account')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
                                    <li><a href="{{ route('user.referral') }}">@lang('Referrals')</a></li>
                                    <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                    <li><a href="{{ route('user.twofactor') }}">@lang('Two Factor')</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                    <div class="nav-right">
                        @auth
                            <a href="javascript:void(0)" class="btn btn-sm btn--base btn--custom me-3 px-3">@lang('Balance'): {{ $general->cur_sym }}{{ getAmount(auth()->user()->balance) }}</a>
                            <a href="{{ route('user.logout') }}" class="btn btn-sm btn--base btn--custom me-3 px-3">@lang('Logout')</a>
                        @else
                            <a href="{{ route('user.login') }}"
                               class="btn btn-sm btn--base btn--custom me-3 px-3">@lang('Login')</a>
                            <a href="{{ route('user.register') }}"
                               class="text-white fs--14px me-3">@lang('Registration')</a>
                        @endauth

                        <select class="language-select langSel">
                            @foreach($language as $item)
                                <option value="{{$item->code}}"
                                        @if(session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </nav>
        </div>
    </div><!-- header__bottom end -->
</header>
<!-- header-section end  -->

<div class="main-wrapper">

    @include($activeTemplate.'partials.breadcrumb')

    @yield('content')

</div><!-- main-wrapper end -->

@php
    $footer_content = getContent('footer.content', true);
    $footer_elements = getContent('footer.element');
    $extra_pages = getContent('extra.element');
@endphp
<!-- footer start -->
<footer class="footer bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->background_image, '1920x1024') }}');">
    <div class="el-left"><img
            src="{{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->left_image, '768x526') }}"
            alt="image"></div>
    <div class="el-right"><img
            src="{{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->right_image, '768x830') }}"
            alt="image"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-3 text-md-start text-center">
                <a href="{{ route('home')  }}" class="footer-logo"><img
                        src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="image"></a>
            </div>
            <div class="col-lg-10 col-md-9 mt-md-0 mt-3">
                <ul class="inline-menu d-flex flex-wrap justify-content-md-end justify-content-center align-items-center">

                    @foreach($pages as $k => $data)
                        <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                    @endforeach

                    @forelse($extra_pages as $item)
                        <li>
                            <a href="{{ route('links', [$item->id, slug($item->data_values->title)]) }}">{{ @$item->data_values->title }}</a>
                        </li>
                    @empty
                    @endforelse

                </ul>
            </div>
        </div><!-- row end -->
        <hr class="mt-3">
        <div class="row align-items-center">
            <div class="col-md-6 text-md-start text-center">
                <p>{{ __(@$footer_content->data_values->copyright) }}</p>
            </div>
            <div class="col-md-6 mt-md-0 mt-3">
                <ul class="inline-social-links d-flex align-items-center justify-content-md-end justify-content-center">
                    @forelse($footer_elements as $item)
                        <li>
                            <a href="{{ @$item->data_values->social_link }}">@php echo @$item->data_values->social_icon @endphp</a>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- footer end -->


<!-- jQuery library -->
<script src="{{asset($activeTemplateTrue.'js/lib/jquery-3.5.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/lib/bootstrap.bundle.min.js')}}"></script>
<!-- slick slider js -->
<script src="{{asset($activeTemplateTrue.'js/lib/slick.min.js')}}"></script>
<!-- scroll animation -->
<script src="{{asset($activeTemplateTrue.'js/lib/wow.min.js')}}"></script>
<!-- apex chart js -->
<script src="{{asset($activeTemplateTrue.'js/lib/jquery.countdown.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/lib/syotimer.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/lib/syotimer.lang.js')}}"></script>

<!-- main js -->
<script src="{{asset($activeTemplateTrue.'js/app.js')}}"></script>

<script src="{{asset($activeTemplateTrue.'js/bootstrap-fileinput.js')}}"></script>

<script src="{{ asset($activeTemplateTrue.'js/jquery.validate.js') }}"></script>

<script>
    (function ($) {
        "use strict";
        $('input[type=button]').click(function () {
            $('input[type=button]').removeClass('selectedNumber');
            if (!$(this).hasClass('selectedNumber')) {
                $(this).addClass('selectedNumber');
                $('input[name=user_choose]').val($('.selectedNumber').val());
            }
        });
    })(jQuery);
</script>

@stack('script-lib')

@include('partials.notify')

@include('partials.plugins')


@stack('script')


<script>

    (function ($) {
        "use strict";
        $(".langSel").on("change", function () {
            window.location.href = "{{route('home')}}/change/" + $(this).val();
        });

    })(jQuery);

</script>


<script>
    (function ($) {
        "use strict";

        $("form").validate();
        $('form').on('submit', function () {
            if ($(this).valid()) {
                $(':submit', this).attr('disabled', 'disabled');
            }
        });

    })(jQuery);

</script>

</body>
</html>
