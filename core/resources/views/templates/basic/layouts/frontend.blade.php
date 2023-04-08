<!doctype html>
<html lang="en" itemscope itemtype="https://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
@include('partials.seo')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://secretraffle4u.com/assets/css/jquery.translator.css">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('style-lib')

    @stack('style')
</head>
@php
$uri_segment = Request::segment(1);
$helpers = new \App\Lib\Helper();
// $currency_rates = $helpers->get_currency_rates();
$currencies = $helpers->get_all_currencies();
// echo "<pre>";print_r($currencies);echo "</pre>";exit;
@endphp
<body style="background-image:url({{ ($uri_segment != 'rewards')?asset('assets/images/site-bg.png'):asset('assets/images/rewards_page/goddsvip-bg-2.png') }});">

@stack('fbComment')

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
    <!-- ===========================  Header Top =========================== -->
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo" width="100">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('raffle-draw') }}">Raffle Games</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('scratch-cards') }}">Scratch Cards</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('lottery') }}">International Lottery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rewards') }}">Rewards</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                            </li> --}}

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rewards') }}">Rewards</a>
                            </li>
                            @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.login') }}">@lang('Login')</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.register') }}">@lang('Registration')</a>
                            </li> --}}
                            @endauth
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <select class="language-select langSel">
                                        @foreach($language as $item)
                                            <option value="{{$item->code}}"
                                                    @if(session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </a>
                            </li> --}}

                            <li class="nav-item">
                            
                            <!--
                            <div 
                                class="nav-link"  
                            style="padding-bottom: 0 !important;    padding-top: 20px !important;"    
                            >
                                <div style="background: #fff; padding: 0 10px;">
                                    <div id="google-translate-element"></div>
                                    <script type="text/javascript">  
                                            function googleTranslateElementInit() {  
                                                    new google.translate.TranslateElement(
                                                    {pageLanguage: 'en'},  
                                                    'google-translate-element'
                                                    );  
                                            }  
                                    </script>  
                                    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                                </div>
                            </div>  -->

                            
                            </li>
							<li class="nav-item" style="padding:30px 36px;" id="nottranslate">
								<select id="currency-symbol">
									<option value="">Currency</option>
									@foreach($currencies as $key => $item)
										<option value="{{ $item->code }}">{{ $item->code }} - {{ $item->symbol }}</option>
									@endforeach
								</select>
                            </li>
                            <li class="translator">
                            <style>
                            div#translator-language {
                                max-height: 400px;
                                overflow-y: auto;
                                background: white;
                                padding: 10px;
                                position: absolute;
                                z-index:99;
                                width:100%;
                                max-width:200px;
                            }
                            .translator-flags-and-names a {
                                display: block;
                                color: black;
                                line-height: 26px;
                            }
                            .select_language_main {
                                background: #e9e9ed;
                                margin-top: 30px;
                                cursor: pointer;
                                width: 200px;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                border-radius: 5px;
                            }
                            .select_language_main p{
                                padding: 5px;
                                margin-bottom:0px;
                            }
                            .hideLang{
                                display:none;
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
                            @media screen and (max-width:990px){
                                .nav-item:nth-child(7) {
                                    padding: 15px 0px 0px 0px !important;
                                }
                            }
                            
                            @media screen and (min-width:991px) and (max-width:1199px){
                                .select_language_main {
                                    width: max-content;
                                }
                                .nav-item:nth-child(7) {
                                    padding: 30px 10px !important;
                                }
                                .header .navbar-nav .nav-link {
                                    padding: 30px 15px !important;
                                }
                            }
                            @media screen and (min-width:1200px) and  (max-width:1366px){
                                .header .navbar-nav .nav-link {
                                    padding: 30px 20px !important;
                                }
                                .nav-item:nth-child(7) {
                                    padding: 30px 15px !important;
                                }
                            }
                            </style>
                            <script>
                                function toggleLanguageSelector(event){
                                    let a = document.getElementById('translator-language');
                                    if(a.classList.contains("hideLang")){
                                        a.classList.remove("hideLang");
                                    }else{
                                         a.classList.add("hideLang");
                                    }
                                }
                                document.addEventListener('click', function(event){
                                    if(!event.target.classList.contains('custom-translator')){
                                        let a = document.getElementById('translator-language');
                                        a.classList.add("hideLang");
                                    }
                                    
                                });
                            </script>
                            <div onClick="toggleLanguageSelector(event)" class="select_language_main custom-translator" id="nottranslate">
                                <p class="custom-translator">Select Language...</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 custom-translator">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
               <div id="translator-language" class="hideLang custom-translator">
                <a href="javascript:;" title="SelectLanguage">Select Language</a>
               <a href="javascript:;" title="Afrikaans" class="translator-language-af">Afrikaans</a>
               <a href="javascript:;" title="Albanian" class="translator-language-sq">Albanian</a>
               <a href="javascript:;" title="Amharic" class="translator-language-am">Amharic</a>
               <a href="javascript:;" title="Arabic" class="translator-language-ar">Arabic</a>
               <a href="javascript:;" title="Armenian" class="translator-language-hy">Armenian</a>
               <a href="javascript:;" title="Azerbaijani" class="translator-language-az">Azerbaijani</a>
               <a href="javascript:;" title="Basque" class="translator-language-eu">Basque</a>
               <a href="javascript:;" title="Belarusian" class="translator-language-be">Belarusian</a>
               <a href="javascript:;" title="Bengali" class="translator-language-bn">Bengali</a>
               <a href="javascript:;" title="Bosnian" class="translator-language-bs">Bosnian</a>
               <a href="javascript:;" title="Bulgarian" class="translator-language-bg">Bulgarian</a>
               <a href="javascript:;" title="Catalan" class="translator-language-ca">Catalan</a>
               <a href="javascript:;" title="Cebuano" class="translator-language-ceb">Cebuano</a>
               <a href="javascript:;" title="Chichewa" class="translator-language-ny">Chichewa</a>
               <a href="javascript:;" title="Chinese Simplified" class="translator-language-zh-CN">Chinese Simplified</a>
               <a href="javascript:;" title="Chinese Traditional" class="translator-language-zh-TW">Chinese Traditional</a>
               <a href="javascript:;" title="Corsican" class="translator-language-co">Corsican</a>
               <a href="javascript:;" title="Croatian" class="translator-language-hr">Croatian</a>
               <a href="javascript:;" title="Czech" class="translator-language-cs">Czech</a>
               <a href="javascript:;" title="Danish" class="translator-language-da">Danish</a>
               <a href="javascript:;" title="Dutch" class="translator-language-nl">Dutch</a>
               <a href="javascript:;" title="English" class="translator-language-en">English</a>
               <a href="javascript:;" title="Esperanto" class="translator-language-eo">Esperanto</a>
               <a href="javascript:;" title="Estonian" class="translator-language-et">Estonian</a>
               <a href="javascript:;" title="Filipino" class="translator-language-tl">Filipino</a>
              <a href="javascript:;" title="Finnish" class="translator-language-fi">Finnish</a>
              <a href="javascript:;" title="French" class="translator-language-fr">French</a>
              <a href="javascript:;" title="Frisian" class="translator-language-fy">Frisian</a>
              <a href="javascript:;" title="Galician" class="translator-language-gl">Galician</a>
              <a href="javascript:;" title="Georgian" class="translator-language-ka">Georgian</a>
              <a href="javascript:;" title="German" class="translator-language-de">German</a>
              <a href="javascript:;" title="Greek" class="translator-language-el">Greek</a>
              <a href="javascript:;" title="Gujarati" class="translator-language-gu">Gujarati</a>
              <a href="javascript:;" title="Haitian Creole" class="translator-language-ht">Haitian Creole</a>
              <a href="javascript:;" title="Hausa" class="translator-language-ha">Hausa</a>
              <a href="javascript:;" title="Hawaiian" class="translator-language-haw">Hawaiian</a>
              <a href="javascript:;" title="Hebrew" class="translator-language-iw">Hebrew</a>
              <a href="javascript:;" title="Hindi" class="translator-language-hi">Hindi</a>
              <a href="javascript:;" title="Hmong" class="translator-language-hmn">Hmong</a>
              <a href="javascript:;" title="Hungarian" class="translator-language-hu">Hungarian</a>
              <a href="javascript:;" title="Icelandic" class="translator-language-is">Icelandic</a>
              <a href="javascript:;" title="Igbo" class="translator-language-ig">Igbo</a>
              <a href="javascript:;" title="Indonesian" class="translator-language-id">Indonesian</a>
              <a href="javascript:;" title="Irish" class="translator-language-ga">Irish</a>
              <a href="javascript:;" title="Italian" class="translator-language-it">Italian</a>
              <a href="javascript:;" title="Japanese" class="translator-language-ja">Japanese</a>
              <a href="javascript:;" title="Javanese" class="translator-language-jw">Javanese</a>
              <a href="javascript:;" title="Kannada" class="translator-language-kn">Kannada</a>
              <a href="javascript:;" title="Kazakh" class="translator-language-kk">Kazakh</a>
              <a href="javascript:;" title="Khmer" class="translator-language-km">Khmer</a>
              <a href="javascript:;" title="Korean" class="translator-language-ko">Korean</a>
              <a href="javascript:;" title="Kurdish" class="translator-language-ku">Kurdish</a>
              <a href="javascript:;" title="Kyrgyz" class="translator-language-ky">Kyrgyz</a>
              <a href="javascript:;" title="Lao" class="translator-language-lo">Lao</a>
              <a href="javascript:;" title="Latin" class="translator-language-la">Latin</a>
              <a href="javascript:;" title="Latvian" class="translator-language-lv">Latvian</a>
              <a href="javascript:;" title="Lithuanian" class="translator-language-lt">Lithuanian</a>
              <a href="javascript:;" title="Luxembourgish" class="translator-language-lb">Luxembourgish</a>
              <a href="javascript:;" title="Macedonian" class="translator-language-mk">Macedonian</a>
              <a href="javascript:;" title="Malagasy" class="translator-language-mg">Malagasy</a>
              <a href="javascript:;" title="Malay" class="translator-language-ms">Malay</a>
              <a href="javascript:;" title="Malayalam" class="translator-language-ml">Malayalam</a>
              <a href="javascript:;" title="Maltese" class="translator-language-mt">Maltese</a>
              <a href="javascript:;" title="Maori" class="translator-language-mi">Maori</a>
              <a href="javascript:;" title="Marathi" class="translator-language-mr">Marathi</a>
              <a href="javascript:;" title="Mongolian" class="translator-language-mn">Mongolian</a>
              <a href="javascript:;" title="Burmese" class="translator-language-my">Burmese</a>
              <a href="javascript:;" title="Nepali" class="translator-language-ne">Nepali</a>
              <a href="javascript:;" title="Norwegian" class="translator-language-no">Norwegian</a>
              <a href="javascript:;" title="Pashto" class="translator-language-ps">Pashto</a>
              <a href="javascript:;" title="Persian" class="translator-language-fa">Persian</a>
              <a href="javascript:;" title="Polish" class="translator-language-pl">Polish</a>
              <a href="javascript:;" title="Portuguese" class="translator-language-pt">Portuguese</a>
              <a href="javascript:;" title="Punjabi" class="translator-language-pa">Punjabi</a>
              <a href="javascript:;" title="Romanian" class="translator-language-ro">Romanian</a>
              <a href="javascript:;" title="Russian" class="translator-language-ru">Russian</a>
              <a href="javascript:;" title="Serbian" class="translator-language-sr">Serbian</a>
              <a href="javascript:;" title="Sesotho" class="translator-language-st">Sesotho</a>
              <a href="javascript:;" title="Sinhala" class="translator-language-si">Sinhala</a>
              <a href="javascript:;" title="Slovak" class="translator-language-sk">Slovak</a>
              <a href="javascript:;" title="Slovenian" class="translator-language-sl">Slovenian</a>
              <a href="javascript:;" title="Somali" class="translator-language-so">Somali</a>
              <a href="javascript:;" title="Samoan" class="translator-language-sm">Samoan</a>
              <a href="javascript:;" title="Scots Gaelic" class="translator-language-gd">Scots Gaelic</a>
              <a href="javascript:;" title="Shona" class="translator-language-sn">Shona</a>
              <a href="javascript:;" title="Sindhi" class="translator-language-sd">Sindhi</a>
              <a href="javascript:;" title="Spanish" class="translator-language-es">Spanish</a>
              <a href="javascript:;" title="Sundanese" class="translator-language-su">Sundanese</a>
              <a href="javascript:;" title="Swahili" class="translator-language-sw">Swahili</a>
              <a href="javascript:;" title="Swedish" class="translator-language-sv">Swedish</a>
              <a href="javascript:;" title="Tajik" class="translator-language-tg">Tajik</a>
              <a href="javascript:;" title="Tamil" class="translator-language-ta">Tamil</a>
              <a href="javascript:;" title="Telugu" class="translator-language-te">Telugu</a>
              <a href="javascript:;" title="Thai" class="translator-language-th">Thai</a>
              <a href="javascript:;" title="Turkish" class="translator-language-tr">Turkish</a>
              <a href="javascript:;" title="Ukrainian" class="translator-language-uk">Ukrainian</a>
              <a href="javascript:;" title="Urdu" class="translator-language-ur">Urdu</a>
              <a href="javascript:;" title="Uzbek" class="translator-language-uz">Uzbek</a>
              <a href="javascript:;" title="Vietnamese" class="translator-language-vi">Vietnamese</a>
              <a href="javascript:;" title="Welsh" class="translator-language-cy">Welsh</a>
              <a href="javascript:;" title="Xhosa" class="translator-language-xh">Xhosa</a>
              <a href="javascript:;" title="Yiddish" class="translator-language-yi">Yiddish</a>
              <a href="javascript:;" title="Yoruba" class="translator-language-yo">Yoruba</a>
              <a href="javascript:;" title="Zulu" class="translator-language-zu">Zulu</a>

               </div>
               </li>

                        </ul>
                    </div>
                </div>
               
            </nav>
        </div>
    </div>
    </div>
<div class="main-wrapper">
    {{-- @if(request()->route()->getName() != 'home')
        @include($activeTemplate.'partials.breadcrumb')
    @endif --}}
    @yield('content')
</div><!-- main-wrapper end -->

@php
    $footer_content = getContent('footer.content', true);
    $footer_elements = getContent('footer.element');
    $extra_pages = getContent('extra.element');
@endphp


    <!-- ===========================  Footer  =========================== -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <div class="footer_title">
                            <h3 style="margin-bottom: 6px;">
                                <a class="navbar-brand" href="{{route('home')}}">
                                    <img src="{{asset('assets/images/logoIcon/logo.png')}}" alt="logo" width="100">
                                </a>
                            </h3>
                        </div>
                        <div class="footer_article">
                            <p>
                                {{ __(@$footer_content->data_values->logoAreaText) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <div class="footer_title">
                            <h3>Games</h3>
                        </div>
                        <div class="footer_link">
                            <ul>
                                @auth
                                <li>
                                    <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                                </li>
                                @else
                                <li>
                                    <a href="{{ route('user.login') }}">@lang('Login')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.register') }}">@lang('Registration')</a>
                                </li>
                                @endauth
                                <li><a href="{{ route('raffle-draw') }}">Raffle Games</a></li>
                                <li><a href="{{ route('scratch-cards') }}">Scratch Card</a></li>
                                {{--  <li><a href="#">International Lattery</a></li>
                                <li><a href="#">Casino</a></li>
                                <li><a href="#">Poker</a></li>  --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <div class="footer_title">
                            <h3>Links</h3>
                        </div>
                        <div class="footer_link">
                            <ul>
                                <li><a href="{{route('links', ['id' => '193', 'slug'=> 'about-us' ])}}">About Us</a></li>
                                <li><a href="{{route('links', ['id' => '194', 'slug'=> 'contact-us' ])}}">Contact Us</a></li>
                                <li><a href="{{route('links', ['id' => '196', 'slug'=> 'guaranteed-payout' ])}}">Guaranteed Payout</a></li>
                                {{--  <li><a href="{{route('links', ['id' => '197', 'slug'=> 'support-communities' ])}}">Support Communities</a></li>  --}}
                                <li><a href="{{route('links', ['id' => '189', 'slug'=> 'privacy-and-policy' ])}}">Privacy Policy</a></li>
                                <li><a href="{{route('links', ['id' => '188', 'slug'=> 'terms-and-condition' ])}}">Terms & Conditions</a></li>
                                <li><a href="{{route('links', ['id' => '195', 'slug'=> 'faqs' ])}}">FAQ’s</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <div class="footer_title">
                            <h3>Gamble Safely</h3>
                        </div>
                        <div class="footer_link">
                            <ul>
                                <li><a href="{{route('links', ['id' => '198', 'slug'=> 'healthy-play' ])}}">Healthy Play</a></li>
                                <li><a href="{{route('links', ['id' => '199', 'slug'=> 'gamble-safely' ])}}">Gamble Safely</a></li>
                                <li><a href="{{ route('download-app') }}"><img src="{{ asset('assets/images/google-download-play-icon.png') }}" style="width:100px;" /></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container mt-5 mb-5">
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
                        <div class="col-5" style="text-align: right;">
                            <div class="footer_icon">
                                <img src="{{ asset('assets/images/icon/footer-1.png') }}" class="img-fluid" alt="image" style="height:auto !important;" />
                            </div>
                        </div>
{{--
                        <div class="col">
                            <div class="footer_icon">
                                <img src="{{ asset('assets/images/icon/footer-2.png') }}" class="img-fluid" alt="image">
                            </div>
                        </div>
--}}
                        <div class="col-2">&nbsp;</div>
                        <div class="col-5" style="text-align: left;">
                            <div class="footer_icon">
                                <img src="{{ asset('assets/images/icon/footer-3.png') }}" class="img-fluid" style="height:auto !important; max-width:65px;" />
                            </div>
                        </div>
{{--
                        <div class="col">
                            <div class="footer_icon">
                                <img src="{{ asset('assets/images/icon/footer-4.png') }}" class="img-fluid" alt="image">
                            </div>
                        </div>
                        <div class="col">
                            <div class="footer_icon">
                                <img src="{{ asset('assets/images/icon/footer-5.png') }}" class="img-fluid" alt="image">
                            </div>
                        </div>
--}}
                    </div>
                </div>
                <div class="footer_bottom">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-10">
                            <p>{{ __(@$footer_content->data_values->copyright) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script>
$('.category_carousel').owlCarousel({
    loop: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    dots: false,
    nav: true,
    navText: ['<img src="assets/images/icon/left-arrow.png" class="img-fluid" alt="icon">', '<img src="assets/images/icon/right-arrow.png" class="img-fluid" alt="icon">'],
    responsive: {
        0: {
            items: 1,
        },
        700: {
            items: 2,
        },
        992: {
            items: 3,
        },
    },
});
</script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('partials.notify')


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function () {
            window.location.href = "{{route('home')}}/change/" + $(this).val();
        });

        //Cookie
        $(document).on('click', '.acceptPolicy', function () {
            $.ajax({
                url: "{{ route('cookie.accept') }}",
                method:'GET',
                success:function(data){
                    if (data.success){
                        $('.cookie__wrapper').addClass('d-none');
                        notify('success', data.success)
                    }
                },
            });
        });
    })(jQuery);
</script>
<script>
$(document).on('change','#currency-symbol', function(){
	var currency = $('#currency-symbol').val();
	if(currency == ''){
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
    excludeSelector: "#nottranslate,#translator-language",
    });
});
</script>



</div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/63908447daff0e1306db5a6a/1gjm89ema';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
