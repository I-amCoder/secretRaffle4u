@extends($activeTemplate.'layouts.frontend')
@section('content')
<style>
body{
	background-image: url('{{ asset("assets/images/rewards_page/goddsvip-bg-2.png") }}') no-repeat !important;
}
.banner:after{
	background: url('{{ asset("assets/images/rewards_page/banner-bg.jpg") }}') center center no-repeat !important;
	background-size:  cover !important;
}
.about .about-text .part-bottom .part-descr ul li:before{
	background: url('{{ asset("assets/images/rewards_page/about/icon-1.png") }}') center center no-repeat !important;
    background-size: 30px 30px !important;
}
.text-two-sercet:before{
	background: url('{{ asset("assets/images/rewards_page/about/icon-1.png") }}') center center no-repeat !important;
    background-size: 30px 30px !important;
}
.row-three-sercet li{
    display: flex;flex-direction: row;align-items: center; margin-top: 15px; font-size: 16px; line-height: 150%;
}
.text-vip-two-list:before{
	background: url('{{ asset("assets/images/rewards_page/about/icon-1.png") }}') center center no-repeat !important;
    background-size: contain !important;
}
.gates_img{
	background: url('{{ asset("assets/images/rewards_page/membership/nottigham-castle-gates.png") }}') center center no-repeat !important;
    background-size: cover !important;
    
}
.secret-bg{
	background: url('{{ asset('assets/images/rewards_page/secret/imgbin-gold-horse.png') }}') right 14% no-repeat,
    url('{{ asset('assets/images/rewards_page/secret/left-raffle-ticket.png') }}') left 20% no-repeat,
    url('{{ asset('assets/images/rewards_page/secret/imgbin-gold-horse-iron.png') }}') left 46% no-repeat,
    url('{{ asset('assets/images/rewards_page/secret/right-raffle-ticket.png') }}') right 70% no-repeat,
    url('{{ asset('assets/images/rewards_page/secret/right-55.png') }}') right 37% no-repeat,
    url('{{ asset('assets/images/rewards_page/secret/left-55.png') }}') left 85% no-repeat;
}
.com-rule{
	background: url('{{ asset('assets/images/rewards_page/secret/right-raffle-ticket.png') }}') right top no-repeat,
    url('{{ asset('assets/images/rewards_page/secret/left-55.png') }}') left center no-repeat;
}
</style>

    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- preloader begin -->
    <!-- <div class="preloader">
            <div class="loader"><div></div><div></div><div></div><div></div></div>
        </div> -->
    <!-- preloader end -->
    <!-- banner begin -->
    <div class="banner">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-9 d-xl-flex d-lg-flex d-block align-items-end">
            <div class="part-img">
                <img class="main-img" src="{{ asset('assets/images/rewards_page/banner-img.png') }}" alt="">
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- lottery begin -->
    <div class="lotteries">
        <div class="bg-shape-2">
            <img src="{{ asset('assets/images/rewards_page/bg-shape/bg-shape-2.jpg') }}" alt="lottery">
        </div>
        
        <div class="container">
            <div class="part-picking-number">
                <div class="lotteries-selection-menu">
                    <table class="table1 table-bordered">
                        <thead>
                            <tr>
                                <th class="table1th">Level Upgrade Requirements:</th>
                                <th class="tableth">
                                    <span>
                                        <img src="{{ asset('assets/images/rewards_page/lottery/Recruit.png') }}" alt="">
                                    </span>
                                </th>
                                <th class="tableth">
                                    <span>
                                        <img src="{{ asset('assets/images/rewards_page/lottery/Rookie.png') }}" alt="">
                                    </span>
                                </th>
                                <th class="tableth">
                                    <span>
                                        <img src="{{ asset('assets/images/rewards_page/lottery/Pro.png') }}" alt="">
                                    </span>
                                </th>
                                <th class="tableth">
                                    <span>
                                        <img src="{{ asset('assets/images/rewards_page/lottery/Hall-of-fame.png') }}" alt="">
                                    </span>
                                </th>
                                <th class="tableth">
                                    <span>
                                        <img src="{{ asset('assets/images/rewards_page/lottery/Champion.png') }}" alt="">
                                    </span>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="animation-body animated">
                    <div class="part-text">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Level Upgrade Requirements:</th>
                                    <th class="tableth">Level 1</th>
                                    <th class="tableth">Level 2</th>
                                    <th class="tableth">Level 3</th>
                                    <th class="tableth">Level 4</th>
                                    <th class="tableth">Level 5</th>
                                </tr>
                            </thead>
                            <tbody style="border: #CCB575 2px solid;">
                                @foreach ($level_req as $item)
                                <tr style="border: #CCB575 2px solid;">
                                    <th class="light" scope="row"  style="border: #CCB575 2px solid;">{{ $item->level_req }}</th>
                                    <td  style="border: #CCB575 2px solid;">{{ $item->level_1 }}</td>
                                    <td  style="border: #CCB575 2px solid;">{{ $item->level_2 }}</td>
                                    <td  style="border: #CCB575 2px solid;">{{ $item->level_3 }}</td>
                                    <td  style="border: #CCB575 2px solid;">{{ $item->level_4 }}</td>
                                    <td  style="border: #CCB575 2px solid;">{{ $item->level_5 }}</td>
                                    
                                </tr>
                                @endforeach
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- lottery end -->

    <!-- about begin -->
    <div class="about com-rule">
        <img src="{{ asset('assets/images/rewards_page/bg-shape/bg-shape-3.png') }}" alt="" class="bg-shape-3">
        <img src="{{ asset('assets/images/rewards_page/bg-shape/bg-shape-4.png') }}" alt="" class="bg-shape-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="about-text">
                        <div class="section-title for-about-section">
                            <h2 class="title"> <img src="{{ asset('assets/images/icon/Rectangle 34.png') }}" class="heading_arrow" alt=""> Commision <span class="text-one-sercet mt-5"  style="font-size: 54px;">Rules</span> <img src="{{ asset('assets/images/icon/Rectangle 35.png') }}" class="heading_arrow" alt=""></h2>
                        </div>
                        <div class="part-bottom">
                            <div class="part-descr">
                                
                                <ul>
                                    @foreach ($c_rules as $item)
                                    <li> {{ $item->c_rule }}
                                    </li> 
                                    @endforeach
                                    
                                    {{-- <li>If you have 1,000 players under you. Minimum 10% of players must deposit $50
                                        before the 7th of each month to be eligible for commission. 900+ players minimum
                                        to receive commission.
                                    </li>
                                    <li>For example: If 899 make deposit, commission will be canceled.</li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about end -->

    <!-- Section 4 | Secret Raffle  -->
    <section class="secret secret-bg">
        <!-- <img src="{{ asset('assets/images/rewards_page/bg-shape/bg-shape-4.png') }}" alt="" class="bg-shape-4"> -->
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="sercet-text">
                        <div class="section-title for-secret-section">
                            <h2 class="title"> <img src="{{ asset('assets/images/icon/Rectangle 34.png') }}" class="heading_arrow" alt=""> Secret Raffle 4U <img src="{{ asset('assets/images/icon/2.png') }}" style="position: absolute; bottom: 85px;"  alt=""><span class="text-one-sercet" style="font-size: 54px;">VIP</span> <img src="{{ asset('assets/images/icon/Rectangle 35.png') }}" class="heading_arrow" alt=""> </h2>
                        </div>
                        <!--Level 1 -->
                        <div class="sercet-columns mt-5">
                            <div>
                                <span class="row-one-sercet mt-5" style="display: flex;flex-direction: row;align-items: center;">Level<span class="text-row-one-sercet mx-3">1</span></span>
                            </div>
                            <div class="row-two-sercet_img">
                                <img src="{{ asset('assets/images/rewards_page/secret/recruit.png') }}" alt="">
                            </div>
                            <div class="row-three-sercet">
                                <span class="text-one-sercet">RECRUIT</span>
                                <ul>
                                    <li class="text-two-sercet"><span>All new players begin as a recruit.</span></li>
                                    <li class="text-two-sercet"><span>You will receive 1% commission for every sign up under referral link.</span></li>
                                </ul>
                            </div>
                        </div>
                        <!--Level 2 -->
                        <div class="sercet-columns mt-5 ">
                            <div>
                                <span class="row-one-sercet  mt-5" style="display: flex;flex-direction: row;align-items: center;">Level<span
                                        class="text-row-one-sercet mx-3">2</span></span>
                            </div>
                            <div class="row-two-sercet_img">
                                <img src="{{ asset('assets/images/rewards_page/secret/rookie.png') }}" alt="">
                            </div>
                            <div class="row-three-sercet">
                                <span class="text-one-sercet mt-5">ROOKIE</span>

                                <ul>
                                    <li class="text-two-sercet"><span>To become Rookie, you have to have 2,000 players.</span></li>
                                    <li class="text-two-sercet"><span>All 2,000 players must deposit $50 minimum/month to get 1.5% commission.</span></li>
                                    <li class="text-two-sercet"><span>Deposit $60,000 to move to level - 2</span></li>

                                </ul>

                            </div>
                        </div>
                        
                        <!--Level 3 -->
                        <div class="sercet-columns mt-5 ">
                            <div>
                                <span class="row-one-sercet mt-5" style="display: flex;flex-direction: row;align-items: center;">Level<span class="text-row-one-sercet mx-3">3</span></span>
                            </div>
                            <div class="row-two-sercet_img">
                                <img src="{{ asset('assets/images/rewards_page/secret/pro.png') }}" alt="">
                            </div>
                            <div class="row-three-sercet">
                                <span class="text-one-sercet mt-5">PRO</span>

                                <ul>
                                    <li class="text-two-sercet"><span>To become Pro, you have to have 3,000 players.</span></li>
                                    <li class="text-two-sercet"><span>All 3,000 players must deposit $50 minimum/month to get 2% commission.</span></li>
                                    <li class="text-two-sercet"><span>Deposit $90,000 to move to level - 3</span></li>
                                </ul>

                            </div>
                        </div>
                        <!--Level 4 -->
                        <div class="sercet-columns mt-5">
                            <div>
                                <span class="row-one-sercet  mt-5" style="display: flex;flex-direction: row;align-items: center;">Level<span
                                        class="text-row-one-sercet mx-3">4</span></span>
                            </div>
                            <div class="row-two-sercet_img">
                                <img src="{{ asset('assets/images/rewards_page/secret/champion.png') }}" alt="">
                            </div>
                            <div class="row-three-sercet">
                                <span class="text-one-sercet mt-5">CHAMPION</span>

                                <ul>
                                    <li class="text-two-sercet"><span>To become Champion, you have to have 4,000 players.</span></li>
                                    <li class="text-two-sercet"><span>All 4,000 players must deposit $50 minimum/month to get 2.5% commission.</span></li>
                                    <li class="text-two-sercet"><span>Deposit $120,000 to move to level - 4</span></li>
                                </ul>

                            </div>
                        </div>
                        <!--Level 5 -->
                        <div class="sercet-columns mt-5 ">
                            <div>
                                <span class="row-one-sercet mt-5" style="display: flex;flex-direction: row;align-items: center;">Level<span
                                        class="text-row-one-sercet mx-3">5</span></span>
                            </div>
                            <div class="row-two-sercet_img">
                                <img src="{{ asset('assets/images/rewards_page/secret/hall_of_famer.png') }}" alt="">
                            </div>
                            <div class="row-three-sercet">
                                <span class="text-one-sercet mt-5">HALL OF FAMER</span>

                                <ul>
                                    <li class="text-two-sercet "><span>To become Hall of Famer, you have to have 5,555 players.</span></li>
                                    <li class="text-two-sercet "><span>All 5,555 players must deposit $50 minimum/month to get 3% commission.</span></li>
                                    <li class="text-two-sercet "><span>Deposit $155,000 to move to level - 5</span></li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- End Section 4 | End Secret Raffle  -->

    <!-- Section 5 | Reward  -->
    <section class="reward">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="reward-text">
                        <div class="section-title for-reward-section">
                            <h2 class="title">
							{{--<img src="{{ asset('assets/images/icon/Rectangle 46.png') }}" class="heading_arrow" alt="">--}}
							<small> Enjoy The Rewards of The Commission From Your Referrals</small>
							{{--<img src="{{ asset('assets/images/icon/Rectangle 47.png') }}" class="heading_arrow" alt="">--}}
							</h2>
                        </div>
                        <div class="for-vip-section mt-0">
                            <h1 class="text-one-sercet"><img src="{{ asset('assets/images/icon/Rectangle 48.png') }}" class="heading_arrow" alt=""> Secret Raffle 4U VIP Members Club <img src="{{ asset('assets/images/icon/Rectangle 49.png') }}" class="heading_arrow" alt=""></h1>
                        </div>
                        <div class="text-vip-one mb-3">
                            <ul>
                                <li> Sign Up Bonus</li>
                                <li> Your first sign up after registration is 100% cash bonus
                                    .Deposit $100 and receive free $100.</li>
                            </ul>
                        </div>

                        <div class=" for-vip-section mb-0">
                            <h2 class="text-one-sercet"><img src="{{ asset('assets/images/icon/Rectangle 50.png') }}" class="heading_arrow" alt=""> Monthly Bonus <img src="{{ asset('assets/images/icon/Rectangle 51.png') }}" class="heading_arrow" alt=""></h2>
                        </div>
                        <div class="text-vip-two mt-3 mb-3">
                            <ul>
                                <li> Deposit $50 and receive $25 cash bonus</li>
                                <li> Free $25 cash bonus every month on your first deposit.</li>
                                <li> Your first deposit of $50 each month will give to 50% cash bonus.</li>
                                <li> $75 will be added to your balance in your players account.</li>
                            </ul>
                        </div>

                        <div class="for-vip-section ">
                            <h2 class="text-one-sercet"><img src="{{ asset('assets/images/icon/Rectangle 34.png') }}" class="heading_arrow" alt=""> VIP Membership Bonus <img src="{{ asset('assets/images/icon/Rectangle 35.png') }}" class="heading_arrow" alt=""></h2>
                        </div>
                        <div class="text-vip-two mt-3 ">
                            <ul>
                                <li>Deposit same amount every month for 12 months to receive free cash bonus</li>
                                <li class="text-vip-two-list"><span>$1,000 receive 10%</span></li>
                                <li class="text-vip-two-list"><span>$2,000 receive 20%</span></li>
                                <li class="text-vip-two-list"><span>$3,000 receive 30%</span></li>
                                <li class="text-vip-two-list"><span>$4,000 receive 40%</span></li>
                                <li class="text-vip-two-list"><span>$5,000 receive 55.5%</span></li>
                                <li>For more information on the VIP bonus, please contact support to activate your VIP Membership</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Section 5 | End Reward -->

    <!-- Section 6 | Membership  -->
    <section class="member">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="member-text">
                        <div class="section-title for-member-section">
                            <h2 class="title"><img src="{{ asset('assets/images/icon/Rectangle 54.png') }}" class="heading_arrow" alt=""><small> How Do I Become A </small><img src="{{ asset('assets/images/icon/Rectangle 57.png') }}" class="heading_arrow" alt=""></h2>
                        </div>
                        <div class="for-vip-section mt-0">
                            <h1 class="text-one-sercet"><img src="{{ asset('assets/images/icon/Rectangle 48.png') }}" class="heading_arrow" alt=""> Secret Raffle 4U VIP Members Club <img src="{{ asset('assets/images/icon/Rectangle 49.png') }}" class="heading_arrow" alt=""></h1>
                        </div>
                        <div class="text-vip-two mt-3 mb-3 ">
                            <ul>
                                <li> To become a VIP Member, please contact support who will create you a Gold Account.</li>
                                <li> Increase your VIP Level and experience rich rewards and taste of the VIP high life.</li>
                            </ul>
                        </div>
                        <div class="text-center mb-5">
                        <button class="btn btn btn-warning btn_reg">Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid gates_img">
			<!--<div class="row">
				<div class="col-12">
					<img src="{{ asset('assets/images/rewards_page/nottigham-castle.png') }}" alt="">
				</div>
			</div>-->
			<div class="row">
				<div class="col-6 left-div-gates">
					<img src="{{ asset('assets/images/rewards_page/imgbin-gold-horse-iron-knight-bottom.png') }}" alt="">
				</div>
				<div class="col-1"></div>
				<div class="col-5 right-div-gates">
					<img src="{{ asset('assets/images/rewards_page/golden_bull_pulling_treasure_carriage-bottom.png') }}" alt="">
				</div>
			</div>
            
        </div>
    </section>
    <!-- End Section 6 | End Membership -->
@endsection
