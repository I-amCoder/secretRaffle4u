@php
    $helpers = new \App\Lib\Helper();
    $currencies = $helpers->get_all_currencies();
@endphp
<!doctype html>
<html lang="en" itemscope itemtype="https://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')

    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lib/bootstrap.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/all.min.css') }}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/font-awesome.min.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lib/slick.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="https://secretraffle4u.com/assets/css/jquery.translator.css">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/bootstrap-fileinput.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue . 'css/color.php?color=' . $general->base_color . '&secondColor=' . $general->secondary_color) }}">

    @stack('style-lib')

    @stack('style')
    <style>
        .raffle-cat {
            margin: 21px;
        }
    </style>
</head>

<body>
    <div class="translator">
        <!-- preloader start -->
        {{-- <div class="preloader">
    <div class="preloader__container">
        <div class="preloader__box">
            <img src="{{asset($activeTemplateTrue.'images/elements/casino-board.png')}}" alt="image">
        </div>
        <div class="preloader__roller">
            <img src="{{asset($activeTemplateTrue.'images/elements/round-roller.png')}}" alt="image">
        </div>
    </div>
</div> --}}
        <!-- preloader end -->

        <!-- header-section start  -->
        <header class="header">
            <div class="header__bottom">
                <div class="container-fluid px-lg-5">
                    <nav class="navbar navbar-expand-xl p-0 align-items-center">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img
                                src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu-toggle"></span>
                        </button>
                        <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu me-auto">
                                @auth
                                    <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                    {{-- <li class="menu_has_children">
                                <a href="#">@lang('Deposit')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.deposit') }}">@lang('Deposit Now')</a></li>
                                    <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a></li>
                                </ul>
                            </li> --}}
                                    <li class="menu_has_children">
                                        <a href="#">@lang('Scratch Card')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ url('user/scratch-card') }}">@lang('All Scratch Card')</a></li>
                                            <li><a href="{{ route('user.my_scratch_cards') }}">@lang('My Scratch Card')</a></li>
                                            <li><a href="{{ route('user.my_scratch_wins') }}">@lang('Scratch Card Wins')</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu_has_children">
                                        <a href="#">@lang('Raffle Games')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.raffle_games') }}">@lang('Raffle Games')</a></li>
                                            <li><a href="{{ route('user.raffle_tickets') }}">@lang('My Raffle Tickets')</a></li>
                                            <li><a href="{{ route('user.rafflewins') }}">@lang('My Raffle Wins')</a></li>
                                        </ul>
                                    </li>
                                    {{-- <li class="menu_has_children">
                                <a href="#">@lang('Withdraw')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                                    <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a>
                                    </li>
                                </ul>
                            </li> --}}
                                    <!-- <li class="menu_has_children">
                                        <a href="#">@lang('Reports')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.bids') }}">@lang('bids')</a></li>
                                        </ul>
                                    </li> -->
                                    {{-- <li class="menu_has_children">
                                <a href="#">@lang('Ticket')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('ticket.open') }}">@lang('Create New')</a></li>
                                    <li><a href="{{ route('ticket') }}">@lang('My Ticket')</a></li>
                                </ul>
                            </li> --}}
                                    <li class="menu_has_children">
                                        <a href="#">@lang('Account')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
                                            <li><a href="{{ route('user.referral') }}">@lang('Referrals')</a></li>
                                            <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                            <li><a href="{{ route('user.twofactor') }}">@lang('Two Factor')</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu_has_children">
                                        <a href="#">@lang('Wallet')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.wallet') }}">@lang('My Wallet')</a></li>
                                            <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a>
                                            <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a></li>
                                            <li><a href="{{ route('user.wins') }}">@lang('wins')</a></li>
                                            <li><a href="{{ route('user.commissions') }}">@lang('Commissions')</a></li>
                                            <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                                        </ul>
                                    </li>
                                    {{-- <li><a href="{{ route('user.wallet') }}">@lang('Wallet')</a></li> --}}

                                @endauth
                            </ul>
                            <div class="nav-right">

                                @auth
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn--base btn--custom me-3 px-3">@lang('Balance'):
                                        @php
                                            $dolr_rate = $helpers->get_currency_rates('USD');
                                            $balance = auth()->user()->balance / $dolr_rate;
                                        @endphp
                                        {{ Session::get('currency_symbol') }}
                                        {{ number_format($helpers->convert_to_currency(Session::get('currency'), $balance)) }}
                                    </a>
                                    <a href="{{ route('user.logout') }}"
                                        class="btn btn-sm btn--base btn--custom me-3 px-3">@lang('Logout')</a>
                                @else
                                    <a href="{{ route('user.login') }}"
                                        class="btn btn-sm btn--base btn--custom me-3 px-3">@lang('Login')</a>
                                    <a href="{{ route('user.register') }}"
                                        class="text-white fs--14px me-3">@lang('Registration')</a>
                                @endauth

                                {{-- <select class="language-select langSel">
                            @foreach ($language as $item)
                                <option value="{{$item->code}}"
                                        @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select> --}}
                                <a style="margin-right: 15px;">
                                    <select id="currency-symbol">
                                        <option value="" id="currency-symbol">Currency</option>
                                        @foreach ($currencies as $key => $item)
                                            <option
                                                {{ Session::get('currency') && Session::get('currency') == $item->code ? 'selected' : '' }}
                                                value="{{ $item->code }}">{{ $item->code }} - {{ $item->symbol }}
                                            </option>
                                        @endforeach
                                    </select>
                                </a>
                                <div class="translator">
                                    <style>
                                        div#translator-language {
                                            max-height: 400px;
                                            overflow-y: auto;
                                            background: white;
                                            padding: 10px;
                                            position: absolute;
                                            z-index: 99;
                                            width: 100%;
                                            max-width: 200px;
                                        }

                                        .translator-flags-and-names a {
                                            display: block;
                                            color: black;
                                            line-height: 26px;
                                        }

                                        .select_language_main {
                                            background: #e9e9ed;
                                            margin-top: 0px;
                                            cursor: pointer;
                                            width: 200px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            border-radius: 5px;
                                        }

                                        .select_language_main p {
                                            padding: 2px 4px;
                                            margin-bottom: 0px;
                                            color: black;
                                        }

                                        .hideLang {
                                            display: none;
                                        }

                                        .select_language_main svg {
                                            width: 10px;
                                            stroke: black;
                                            stroke-width: 4px;
                                            margin-right: 5px;
                                        }

                                        select#currency-symbol {
                                            border-radius: 5px;
                                            background: #e9e9ed;
                                            padding: 5px;
                                        }

                                        @media screen and (max-width:990px) {
                                            .nav-item:nth-child(7) {
                                                padding: 15px 0px 0px 0px !important;
                                            }

                                            .nav-right {
                                                gap: 15px;
                                            }
                                        }

                                        @media screen and (min-width:991px) and (max-width:1199px) {
                                            .select_language_main {
                                                width: max-content;
                                            }

                                            .nav-item:nth-child(7) {
                                                padding: 30px 36px !important;
                                            }
                                        }

                                        @media screen and (min-width:1200px) and (max-width:1515px) {
                                            .nav-right {
                                                row-gap: 10px;
                                            }
                                        }
                                    </style>
                                    <script>
                                        function toggleLanguageSelector(event) {
                                            let a = document.getElementById('translator-language');
                                            if (a.classList.contains("hideLang")) {
                                                a.classList.remove("hideLang");
                                            } else {
                                                a.classList.add("hideLang");
                                            }
                                        }
                                        document.addEventListener('click', function(event) {
                                            if (!event.target.classList.contains('custom-translator')) {
                                                let a = document.getElementById('translator-language');
                                                a.classList.add("hideLang");
                                            }

                                        });
                                    </script>
                                    <div onClick="toggleLanguageSelector(event)"
                                        class="select_language_main custom-translator" id="nottranslate">
                                        <p class="custom-translator">Select Language...</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 custom-translator">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </div>
                                    <div id="translator-language" class="hideLang custom-translator">
                                        <a href="javascript:;" title="Language">Language</a>
                                        <a href="javascript:;" title="Afrikaans"
                                            class="translator-language-af">Afrikaans</a>
                                        <a href="javascript:;" title="Albanian"
                                            class="translator-language-sq">Albanian</a>
                                        <a href="javascript:;" title="Amharic"
                                            class="translator-language-am">Amharic</a>
                                        <a href="javascript:;" title="Arabic"
                                            class="translator-language-ar">Arabic</a>
                                        <a href="javascript:;" title="Armenian"
                                            class="translator-language-hy">Armenian</a>
                                        <a href="javascript:;" title="Azerbaijani"
                                            class="translator-language-az">Azerbaijani</a>
                                        <a href="javascript:;" title="Basque"
                                            class="translator-language-eu">Basque</a>
                                        <a href="javascript:;" title="Belarusian"
                                            class="translator-language-be">Belarusian</a>
                                        <a href="javascript:;" title="Bengali"
                                            class="translator-language-bn">Bengali</a>
                                        <a href="javascript:;" title="Bosnian"
                                            class="translator-language-bs">Bosnian</a>
                                        <a href="javascript:;" title="Bulgarian"
                                            class="translator-language-bg">Bulgarian</a>
                                        <a href="javascript:;" title="Catalan"
                                            class="translator-language-ca">Catalan</a>
                                        <a href="javascript:;" title="Cebuano"
                                            class="translator-language-ceb">Cebuano</a>
                                        <a href="javascript:;" title="Chichewa"
                                            class="translator-language-ny">Chichewa</a>
                                        <a href="javascript:;" title="Chinese Simplified"
                                            class="translator-language-zh-CN">Chinese Simplified</a>
                                        <a href="javascript:;" title="Chinese Traditional"
                                            class="translator-language-zh-TW">Chinese Traditional</a>
                                        <a href="javascript:;" title="Corsican"
                                            class="translator-language-co">Corsican</a>
                                        <a href="javascript:;" title="Croatian"
                                            class="translator-language-hr">Croatian</a>
                                        <a href="javascript:;" title="Czech"
                                            class="translator-language-cs">Czech</a>
                                        <a href="javascript:;" title="Danish"
                                            class="translator-language-da">Danish</a>
                                        <a href="javascript:;" title="Dutch"
                                            class="translator-language-nl">Dutch</a>
                                        <a href="javascript:;" title="English"
                                            class="translator-language-en">English</a>
                                        <a href="javascript:;" title="Esperanto"
                                            class="translator-language-eo">Esperanto</a>
                                        <a href="javascript:;" title="Estonian"
                                            class="translator-language-et">Estonian</a>
                                        <a href="javascript:;" title="Filipino"
                                            class="translator-language-tl">Filipino</a>
                                        <a href="javascript:;" title="Finnish"
                                            class="translator-language-fi">Finnish</a>
                                        <a href="javascript:;" title="French"
                                            class="translator-language-fr">French</a>
                                        <a href="javascript:;" title="Frisian"
                                            class="translator-language-fy">Frisian</a>
                                        <a href="javascript:;" title="Galician"
                                            class="translator-language-gl">Galician</a>
                                        <a href="javascript:;" title="Georgian"
                                            class="translator-language-ka">Georgian</a>
                                        <a href="javascript:;" title="German"
                                            class="translator-language-de">German</a>
                                        <a href="javascript:;" title="Greek"
                                            class="translator-language-el">Greek</a>
                                        <a href="javascript:;" title="Gujarati"
                                            class="translator-language-gu">Gujarati</a>
                                        <a href="javascript:;" title="Haitian Creole"
                                            class="translator-language-ht">Haitian Creole</a>
                                        <a href="javascript:;" title="Hausa"
                                            class="translator-language-ha">Hausa</a>
                                        <a href="javascript:;" title="Hawaiian"
                                            class="translator-language-haw">Hawaiian</a>
                                        <a href="javascript:;" title="Hebrew"
                                            class="translator-language-iw">Hebrew</a>
                                        <a href="javascript:;" title="Hindi"
                                            class="translator-language-hi">Hindi</a>
                                        <a href="javascript:;" title="Hmong"
                                            class="translator-language-hmn">Hmong</a>
                                        <a href="javascript:;" title="Hungarian"
                                            class="translator-language-hu">Hungarian</a>
                                        <a href="javascript:;" title="Icelandic"
                                            class="translator-language-is">Icelandic</a>
                                        <a href="javascript:;" title="Igbo" class="translator-language-ig">Igbo</a>
                                        <a href="javascript:;" title="Indonesian"
                                            class="translator-language-id">Indonesian</a>
                                        <a href="javascript:;" title="Irish"
                                            class="translator-language-ga">Irish</a>
                                        <a href="javascript:;" title="Italian"
                                            class="translator-language-it">Italian</a>
                                        <a href="javascript:;" title="Japanese"
                                            class="translator-language-ja">Japanese</a>
                                        <a href="javascript:;" title="Javanese"
                                            class="translator-language-jw">Javanese</a>
                                        <a href="javascript:;" title="Kannada"
                                            class="translator-language-kn">Kannada</a>
                                        <a href="javascript:;" title="Kazakh"
                                            class="translator-language-kk">Kazakh</a>
                                        <a href="javascript:;" title="Khmer"
                                            class="translator-language-km">Khmer</a>
                                        <a href="javascript:;" title="Korean"
                                            class="translator-language-ko">Korean</a>
                                        <a href="javascript:;" title="Kurdish"
                                            class="translator-language-ku">Kurdish</a>
                                        <a href="javascript:;" title="Kyrgyz"
                                            class="translator-language-ky">Kyrgyz</a>
                                        <a href="javascript:;" title="Lao" class="translator-language-lo">Lao</a>
                                        <a href="javascript:;" title="Latin"
                                            class="translator-language-la">Latin</a>
                                        <a href="javascript:;" title="Latvian"
                                            class="translator-language-lv">Latvian</a>
                                        <a href="javascript:;" title="Lithuanian"
                                            class="translator-language-lt">Lithuanian</a>
                                        <a href="javascript:;" title="Luxembourgish"
                                            class="translator-language-lb">Luxembourgish</a>
                                        <a href="javascript:;" title="Macedonian"
                                            class="translator-language-mk">Macedonian</a>
                                        <a href="javascript:;" title="Malagasy"
                                            class="translator-language-mg">Malagasy</a>
                                        <a href="javascript:;" title="Malay"
                                            class="translator-language-ms">Malay</a>
                                        <a href="javascript:;" title="Malayalam"
                                            class="translator-language-ml">Malayalam</a>
                                        <a href="javascript:;" title="Maltese"
                                            class="translator-language-mt">Maltese</a>
                                        <a href="javascript:;" title="Maori"
                                            class="translator-language-mi">Maori</a>
                                        <a href="javascript:;" title="Marathi"
                                            class="translator-language-mr">Marathi</a>
                                        <a href="javascript:;" title="Mongolian"
                                            class="translator-language-mn">Mongolian</a>
                                        <a href="javascript:;" title="Burmese"
                                            class="translator-language-my">Burmese</a>
                                        <a href="javascript:;" title="Nepali"
                                            class="translator-language-ne">Nepali</a>
                                        <a href="javascript:;" title="Norwegian"
                                            class="translator-language-no">Norwegian</a>
                                        <a href="javascript:;" title="Pashto"
                                            class="translator-language-ps">Pashto</a>
                                        <a href="javascript:;" title="Persian"
                                            class="translator-language-fa">Persian</a>
                                        <a href="javascript:;" title="Polish"
                                            class="translator-language-pl">Polish</a>
                                        <a href="javascript:;" title="Portuguese"
                                            class="translator-language-pt">Portuguese</a>
                                        <a href="javascript:;" title="Punjabi"
                                            class="translator-language-pa">Punjabi</a>
                                        <a href="javascript:;" title="Romanian"
                                            class="translator-language-ro">Romanian</a>
                                        <a href="javascript:;" title="Russian"
                                            class="translator-language-ru">Russian</a>
                                        <a href="javascript:;" title="Serbian"
                                            class="translator-language-sr">Serbian</a>
                                        <a href="javascript:;" title="Sesotho"
                                            class="translator-language-st">Sesotho</a>
                                        <a href="javascript:;" title="Sinhala"
                                            class="translator-language-si">Sinhala</a>
                                        <a href="javascript:;" title="Slovak"
                                            class="translator-language-sk">Slovak</a>
                                        <a href="javascript:;" title="Slovenian"
                                            class="translator-language-sl">Slovenian</a>
                                        <a href="javascript:;" title="Somali"
                                            class="translator-language-so">Somali</a>
                                        <a href="javascript:;" title="Samoan"
                                            class="translator-language-sm">Samoan</a>
                                        <a href="javascript:;" title="Scots Gaelic"
                                            class="translator-language-gd">Scots Gaelic</a>
                                        <a href="javascript:;" title="Shona"
                                            class="translator-language-sn">Shona</a>
                                        <a href="javascript:;" title="Sindhi"
                                            class="translator-language-sd">Sindhi</a>
                                        <a href="javascript:;" title="Spanish"
                                            class="translator-language-es">Spanish</a>
                                        <a href="javascript:;" title="Sundanese"
                                            class="translator-language-su">Sundanese</a>
                                        <a href="javascript:;" title="Swahili"
                                            class="translator-language-sw">Swahili</a>
                                        <a href="javascript:;" title="Swedish"
                                            class="translator-language-sv">Swedish</a>
                                        <a href="javascript:;" title="Tajik"
                                            class="translator-language-tg">Tajik</a>
                                        <a href="javascript:;" title="Tamil"
                                            class="translator-language-ta">Tamil</a>
                                        <a href="javascript:;" title="Telugu"
                                            class="translator-language-te">Telugu</a>
                                        <a href="javascript:;" title="Thai" class="translator-language-th">Thai</a>
                                        <a href="javascript:;" title="Turkish"
                                            class="translator-language-tr">Turkish</a>
                                        <a href="javascript:;" title="Ukrainian"
                                            class="translator-language-uk">Ukrainian</a>
                                        <a href="javascript:;" title="Urdu" class="translator-language-ur">Urdu</a>
                                        <a href="javascript:;" title="Uzbek"
                                            class="translator-language-uz">Uzbek</a>
                                        <a href="javascript:;" title="Vietnamese"
                                            class="translator-language-vi">Vietnamese</a>
                                        <a href="javascript:;" title="Welsh"
                                            class="translator-language-cy">Welsh</a>
                                        <a href="javascript:;" title="Xhosa"
                                            class="translator-language-xh">Xhosa</a>
                                        <a href="javascript:;" title="Yiddish"
                                            class="translator-language-yi">Yiddish</a>
                                        <a href="javascript:;" title="Yoruba"
                                            class="translator-language-yo">Yoruba</a>
                                        <a href="javascript:;" title="Zulu" class="translator-language-zu">Zulu</a>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </nav>
                </div>
            </div><!-- header__bottom end -->
        </header>
        <!-- header-section end  -->

        <div class="main-wrapper">

            @include($activeTemplate . 'partials.breadcrumb')

            @yield('content')

        </div><!-- main-wrapper end -->

        @php
            $footer_content = getContent('footer.content', true);
            $footer_elements = getContent('footer.element');
            $extra_pages = getContent('extra.element');
        @endphp
        <!-- footer start -->
        <footer class="footer bg_img image_f"
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
                        <a href="{{ route('home') }}" class="footer-logo"><img
                                src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}"
                                alt="image"></a>
                    </div>
                    <div class="col-lg-10 col-md-9 mt-md-0 mt-3">
                        {{--
                <ul class="inline-menu d-flex flex-wrap justify-content-md-end justify-content-center align-items-center">

                    @foreach ($pages as $k => $data)
                        <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                    @endforeach

                    @forelse($extra_pages as $item)
                        <li>
                            <a href="{{ route('links', [$item->id, slug($item->data_values->title ?? '')]) }}">{{ @$item->data_values->title ?? '' }}</a>
                        </li>
                    @empty
                    @endforelse

                </ul>
				--}}
                    </div>
                </div><!-- row end -->
                <hr class="mt-3">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start text-center">
                        <p>{{ __(@$footer_content->data_values->copyright) }}</p>
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <ul
                            class="inline-social-links d-flex align-items-center justify-content-md-end justify-content-center">
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
        <script src="{{ asset($activeTemplateTrue . 'js/lib/jquery-3.5.1.min.js') }}"></script>
        <!-- bootstrap js -->
        <script src="{{ asset($activeTemplateTrue . 'js/lib/bootstrap.bundle.min.js') }}"></script>
        <!-- slick slider js -->
        <script src="{{ asset($activeTemplateTrue . 'js/lib/slick.min.js') }}"></script>
        <!-- scroll animation -->
        <script src="{{ asset($activeTemplateTrue . 'js/lib/wow.min.js') }}"></script>
        <!-- apex chart js -->
        <script src="{{ asset($activeTemplateTrue . 'js/lib/jquery.countdown.js') }}"></script>
        <script src="{{ asset($activeTemplateTrue . 'js/lib/syotimer.js') }}"></script>
        <script src="{{ asset($activeTemplateTrue . 'js/lib/syotimer.lang.js') }}"></script>

        <!-- main js -->
        <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>

        <script src="{{ asset($activeTemplateTrue . 'js/bootstrap-fileinput.js') }}"></script>

        <script src="{{ asset($activeTemplateTrue . 'js/jquery.validate.js') }}"></script>

        <script>
            (function($) {
                "use strict";
                $('input[type=button]').click(function() {
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
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "{{ route('home') }}/change/" + $(this).val();
                });

            })(jQuery);
        </script>


        <script>
            (function($) {
                "use strict";

                $("form").validate();
                $('form').on('submit', function() {
                    if ($(this).valid()) {
                        $(':submit', this).attr('disabled', 'disabled');
                    }
                });

            })(jQuery);
        </script>
        <script>
            $(document).on('change', '#currency-symbol', function() {
                var currency = $('#currency-symbol').val();
                if (currency == '') {
                    currency = 'THB';
                }
                var url = "{{ route('currency.change', ['currency' => ':currency']) }}";
                url = url.replace(':currency', currency);
                location.assign(url);
            });
        </script>
        <script src="https://secretraffle4u.com/assets/js/jquery.translator.min.js"></script>
        <script type="text/javascript">
            $.translator.ready(function() {
                $(".translator").translator({
                    excludeSelector: "#nottranslate,#translator-language,#urrency-symbol",
                });
            });
        </script>
    </div>
</body>

</html>
