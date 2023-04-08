@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$helpers = new \App\Lib\Helper();
@endphp
<style>
    .img-fluid-r{
        height: 240px; 
        width: 100%;
    }
    
</style>
       <!-- ===========================  Banner  =========================== -->
        @php
            $banner = getContent('banner.content',true);
            $bannerMobile = getContent('bannerMobile.content',true);
        @endphp

        <img 
            src="{{ getImage('assets/images/frontend/bannerMobile/' . @$bannerMobile->data_values->image, '1920x961') }}"
            style="max-width: 100%;"
            class="d-md-none"
        >

        <img 
            src="{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->image, '1920x961') }}"
            style="width: 100%;"
            class="d-none d-md-block"
        >



        <div 
            class="banner d-none" 
            {{-- style="background-image: url({{ asset('assets/images/banner/banner.jpg') }});" --}}
            style="
                background-image: url('{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->image, '1920x961') }}');
                height: 500px;
                background-position: center;
            "
        >
            <div class="container">
                <div class="row">
                    <div class="banner_text">
                        {{-- <h2>Online Jackpot</h2> --}}
                    </div>
                </div>
            </div>
        </div>




            <!-- ===========================  How it work  =========================== -->
{{--
    <div class="how_work" style="padding: 16px 0px;">
        <div class="container">
            <div class="row g-3 text-center">
                <div class="col-3 col-md-3">
                    <div class="setp_wrap">
                        <div class="icon" style="margin-bottom: 10px;">
                            <img src="{{ asset('assets/images/icon/user.png') }}" class="img-fluid" alt="image"  style="width: 40px;height: 40px;">
                        </div>
                        <div class="content">
                            <h2>Sign Up</h2>
                        </div>
                        <div class="arrow_icon d-none d-md-block">
                            <img src="{{ asset('assets/images/icon/arrow.png') }}" class="img-fluid" alt="image"  style="max-width: 50%;">
                        </div>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="setp_wrap">
                        <div class="icon" style="margin-bottom: 10px;">
                            <img src="{{ asset('assets/images/icon/dollar.png') }}" class="img-fluid" alt="image"  style="width: 40px;height: 40px;">
                        </div>
                        <div class="content">
                            <h2>Deposit Funds</h2>
                        </div>
                        <div class="arrow_icon d-none d-md-block">
                            <img src="{{ asset('assets/images/icon/arrow.png') }}" class="img-fluid" alt="image"  style="max-width: 50%;">
                        </div>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="setp_wrap">
                        <div class="icon" style="margin-bottom: 10px;">
                            <img src="{{ asset('assets/images/icon/card.png') }}" class="img-fluid" alt="image" style="width: 40px;height: 40px;">
                        </div>
                        <div class="content">
                            <h2>Enjoy Playing</h2>
                        </div>
                        <div class="arrow_icon d-none d-md-block">
                            <img src="{{ asset('assets/images/icon/arrow.png') }}" class="img-fluid" alt="image" style="max-width: 50%;">
                        </div>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="setp_wrap">
                        <div class="icon" style="margin-bottom: 10px;">
                            <img src="{{ asset('assets/images/icon/win.png') }}" class="img-fluid" alt="image" style="width: 40px;height: 40px;">
                        </div>
                        <div class="content">
                            <h2>Win</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
--}}
        <!-- ===========================  Categories  =========================== -->
        <div class="category_slider pt-5 pb-5" style="background-image: url(assets/images/category/bg.png);">
            <div class="container">
                <div class="row">
                    <div class="section_heading mb-5 text-center">
                        <h1>Raffle Draw</h1>
                        <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                        <h3>Winning</h3>
                        <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                        <span>Categories</span>
                    </div>
                    <div class="category_carousel owl-carousel text-center">

                        @if(isset($raffle_cat) && count($raffle_cat) > 0 )
                        @foreach ($raffle_cat as $k => $item)
                        <div class="item">
                            <div class="category_box">
                                <h3>{{ $item->home_title }}</h3>
                                <div class="text-center">
                                    <img src="{{ getCategoryPhoto($item->photo) }}" class="w-100" alt="image">
                                </div>
                                <div class="category_btn">
                                    {{-- OLD LINK --}}
                                    {{-- <a href="{{ route('raffle-draw',['type' => $item->id]) }}">Play</a> --}}
                                    <a href="{{ route('raffle-draw') }}">Play</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @endif


                        {{-- <div class="item">
                            <div class="category_box">
                                <h3>Monthly Business <br /> <span>Support</span></h3>
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/category/2.png') }}" class="w-100" alt="image">
                                </div>
                                <div class="category_btn">
                                    <a href="#">Play</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="category_box">
                                <h3>Create Better <br /> <span>Future</span></h3>
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/category/3.png') }}" class="w-100" alt="image">
                                </div>
                                <div class="category_btn">
                                    <a href="#">Play</a>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
           <!-- ===========================  Benefit  =========================== -->
    <div class="benefit_section" style="padding-bottom:25px !important;">
        <div class="container">
            <div class="row">
                <div class="section_heading mb-5 text-center">
                    <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                    <h3 style="vertical-align: middle;">Download the App</h3>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                </div>
                <div class="col-md-12 text-center">
                    <div class="benefit_item">
                        <div class="icon">
                            <a href="{{ route('download-app') }}">
							<img src="{{ asset('assets/images/google-download-play-icon.png') }}" style="width:300px; height: auto; margin: 0px auto 30px; text-align: center;" />
							</a>
                        </div>
                        <div class="benefit_name" style="width: 700px; margin: 0 auto;">
                            <h2>Download our Android Apps and play your favorite Raffle & Scratch Card Games on the go</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- ===========================  Card  =========================== -->
    <div class="card_sec">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-11">
                    <div class="card_bg">
                        <div class="top_left">
                            <img src="{{ asset('assets/images/icon/coin-top.png') }}" alt="">
                        </div>
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-6">
                                <div class="card-img text-center text-lg-start">
                                    <img src="{{ asset('assets/images/scratch.png') }}" width="350" class="img-fluid" alt="image">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-content text-center">
                                    <img src="{{ asset('assets/images/icon/coin1.png') }}" class="img-fluid mb-3" alt="image">
                                    <h3>Online</h3>
                                    <h1>Scratch Card</h1>
                                    <a href="#">Read More</a>
                                    <img src="{{ asset('assets/images/icon/coin2.png') }}" class="coin_icon img-fluid mt-4" alt="image">
                                </div>
                            </div>
                        </div>
                        <div class="bottom_left">
                            <img src="{{ asset('assets/images/icon/coin-bottom.png') }}" alt="">
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="row">
                            <div class="col-sm-9">
                                <h2>Scratch Card <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-sm-end">
                                    <a href="{{route('scratch-cards')}}">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- ===========================  Product  =========================== -->
        <div class="product_section">
            <div class="container">
                <div class="row g-4">
                @foreach ($Scratch as $item)
                    <div class="col-lg-4">
                        <div class="product_wrapper text-center">
                            <div class="product_content">
                                <?php
                                $thumb_img = $_SERVER['DOCUMENT_ROOT'].'/assets/images/game/thumb_'.$item->photo;
                                ?>
                                @if(file_exists($thumb_img))
                                <img src="{{ getRafflePhoto('thumb_'.$item->photo) }}" class="img-fluid img-fluid-r" alt="image">    
                                @else
                                <img src="{{ getRafflePhoto($item->photo) }}" class="img-fluid img-fluid-r" alt="image">
                                @endif
                                {{--<h2 style="margin-top: 15px">{{ $general->cur_sym }}{{ number_format($item->unit_price,2) }}</h2>--}}
                                <h2 style="margin-top: 15px">{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $item->unit_price),2) }}</h2>
                            </div>
                            <div class="play_btn">
                                <a href="{{ route('scratch_cards_game',$item->id) }}">Play</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- <div class="col-lg-4">
                        <div class="product_wrapper text-center">
                            <div class="product_content">
                                <h2>Win ฿555,555</h2>
                                <img src="{{ asset('assets/images/product/2.jpg') }}" class="img-fluid" alt="image">
                            </div>
                            <div class="play_btn">
                                <a href="{{route('scratch-cards')}}">Play</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product_wrapper text-center">
                            <div class="product_content">
                                <h2>Win ฿555,555</h2>
                                <img src="{{ asset('assets/images/product/3.jpg') }}" class="img-fluid" alt="image">
                            </div>
                            <div class="play_btn">
                                <a href="{{route('scratch-cards')}}">Play</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
            <!-- ===========================  Card  =========================== -->
    <div class="card_sec" style="display: none;">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-11">
                    <div class="card_bg">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-6">
                                <div class="card-img text-center">
                                    <img src="{{ asset('assets/images/scratch2.png') }}" width="350" class="img-fluid" alt="image">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-content text-center">
                                    <!-- <img src="{{ asset('assets/images/icon/ball-1.png') }}" class="top_ball img-fluid mb-3" alt="image"> -->
                                    <h3>International</h3>
                                    <h1>Lottery</h1>
                                    <a href="#">Read More</a>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset('assets/images/icon/ball.png') }}" class="img-fluid ball_icon" alt="image">
                    </div>
                    <div class="bottom">
                        <div class="row">
                            <div class="col-sm-9">
                                <h2>International Lottery <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-sm-end">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- ===========================  Product  =========================== -->
        <div class="product_section" style="display: none;">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="product_wrapper text-center">
                            <div class="product_content">
                                <img src="{{ asset('assets/images/product/4.png') }}" class="img-fluid" alt="image" style="height: 200px;">
                            </div>
                            <div class="play_btn d-flex justify-content-center align-items-center">
                                <div class="title mt-3">
                                    <h2>Mega Millions</h2>
                                </div>
                                <div class="btn">
                                    <a href="#">Play</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product_wrapper text-center">
                            <div class="product_content">
                                <img src="{{ asset('assets/images/product/5.jpg') }}" class="img-fluid" alt="image" style="height: 200px;">
                            </div>
                            <div class="play_btn d-flex justify-content-center align-items-center">
                                <div class="title mt-3">
                                    <h2>Robbin Hood Daily Gift</h2>
                                </div>
                                <div class="btn">
                                    <a href="#">Play</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product_wrapper text-center">
                            <div class="product_content">
                                <img src="{{ asset('assets/images/product/6.jpg') }}" class="img-fluid" alt="image" style="height: 200px;">
                            </div>
                            <div class="play_btn d-flex justify-content-center align-items-center">
                                <div class="title mt-3">
                                    <h2>Euromilions</h2>
                                </div>
                                <div class="btn">
                                    <a href="#">Play</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           <!-- ===========================  Benefit  =========================== -->
    <div class="benefit_section">
        <div class="container">
            <div class="row">
                <div class="section_heading mb-5 text-center">
                    <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                    <h3 style="vertical-align: middle;">More Benefits</h3>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                </div>
                <div class="col-md-4 text-center">
                    <div class="benefit_item">
                        <div class="icon">
                            <img class="img-fluid" src="{{ asset('assets/images/icon/lock.png') }}" alt="">
                        </div>
                        <div class="benefit_name">
                            <h2>Secure Casino <br /> Games</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="benefit_item">
                        <div class="icon">
                            <img class="img-fluid" src="{{ asset('assets/images/icon/bonus.png') }}" alt="">
                        </div>
                        <div class="benefit_name">
                            <h2>Great Bonus</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="benefit_item">
                        <div class="icon">
                            <img class="img-fluid" src="{{ asset('assets/images/icon/cup.png') }}" alt="">
                        </div>
                        <div class="benefit_name">
                            <h2>Higher Win <br /> Change</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@php
    $faq_content = getContent('faq.content',true);
    if (request()->route()->getName() == 'home'){
        $faq_elements = getContent('faq.element', false, 50, true);
    } else {
        $faq_elements = getContent('faq.element', false, null, true);
    }
    
    
@endphp





        <!-- ===========================  Benefit  =========================== -->
        <div class="faq_section">
            <div class="container">
                <div class="faq_wrapper" style="background-image:none !important;">
                    <div class="row">
                        <div class="section_heading mb-5 text-center">
                            <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                            <h3 style="vertical-align: middle;">{{ __(@$faq_content->data_values->heading) }}</h3>
                            <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                        </div>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">

                        @forelse($faq_elements as $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne-{{ $loop->iteration }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{ $loop->iteration }}" aria-expanded="false" aria-controls="flush-collapseOne">
                                        {{ __(@$item->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="flush-collapseOne-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne-{{ $loop->iteration }}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>{{ __(@$item->data_values->answer) }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
@endsection
