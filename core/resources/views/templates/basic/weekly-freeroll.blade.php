@extends($activeTemplate.'layouts.frontend')
@section('content')
    <!-- ===========================  Banner  =========================== -->
    <div class="banner" style="background-image: url({{ asset('assets/images/banner/banner-2.png') }}); padding: 70px 0px; height: 580px;">
        <div class="container">
            <div class="row">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="banner_img">
                            <img src="{{ asset('assets/images/banner/jackpot.png') }}" class="img-fluid" alt="image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="banner_img">
                            <img src="{{ asset('assets/images/banner/ticket.png') }}" class="img-fluid" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===========================  coundown  =========================== -->
    <div class="coundown">
        <div class="container">
            <div class="cd100"></div>
        </div>
    </div>
    <!-- ===========================  Payout Structure  =========================== -->
    <div class="payout_structure mt-5">
        <div class="container">
            <div class="row">
                <div class="section_heading mb-5 text-center">
                    <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                    <h3 style="vertical-align: middle;">Weekly Freeroll <br /> Payout Structure</h3>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="structure_card">
                        <div class="row g-3 align-items-center">
                            <div class="col-xl-6">
                                <div class="total_price mb-5">
                                    <h3>Jackpot Prize Total ฿130,880</h3>
                                </div>
                                <div class="structure_table_left">
                                    <table class="table text-center">
                                        <thead>
                                            <tr style="background:#161616 !important;">
                                                <th>Position</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>1<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>1<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>1<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>1<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>1<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td>10<sup>St</sup> - 5,555<sup>St</sup></td>
                                                <td>฿ 10,000</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Minimum Tickets</strong></td>
                                                <td>50,000</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Available Tickets</strong></td>
                                                <td>1,000,000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="total_price mb-3">
                                    <h3>Register Player</h3>
                                    <p>All players will automatically be registered to this game soon as you buy tickets from the “Daily” Raffle Draw”. Total Registere Tickets: ……………………</p>
                                </div>
                                <div class="structure_table_left">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Username</th>
                                                <th>Ticket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>01</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>02</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>03</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>04</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>05</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>06</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>07</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>08</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>09</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>10</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="structure_bottom text-center">
                                <p>This freeroll draw is complementary for players who buy <br> tickets for any of the “Daily” raffle draw.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===========================  Birthday gift  =========================== -->
    <div class="birthday_gift">
        <div class="container">
            <div class="content text-center">
                <img src="{{ asset('assets/images/freeroll-2.png') }}" class="mb-2" alt="">
                <h2>Weekly Freeroll</h2>
            </div>
        </div>
    </div>
    <!-- =========================== Raffle draw infomation  =========================== -->
    <div class="raffle_draw_info">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="raffle_img text-center">
                        <img src="{{ asset('assets/images/raffile.png') }}" class="img-fluid" alt="image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="raffle_content">
                        <div class="site_title">
                            <h2>Raffle Draw Information</h2>
                            <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt="icon">
                        </div>
                    </div>
                    <div class="info_list">
                        <ul>
                            <li>With our amazing birthday gift draw, you have a chance to win when it’s our friend’s birthdays.</li>
                            <li>You can win multiple prizes when you buy multiple tickets.</li>
                            <li>555฿ BONUS for the following payout positions: 5th – 55th – 555th – 5,555th</li>
                            <li>555฿ BONUS for the following ticket numbers: 5 – 55 – 555 – 5,555 – 55,555 – 555,555</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =========================== Raffle draw rules  =========================== -->
    <div class="draw_rules_sec">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="site_title">
                        <h2>Raffle Draw Rules</h2>
                        <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt="icon">
                    </div>
                    <div class="raffle_rules_list">
                        <ul>
                            <li>Only gamble what you can afford to in your means. Always Gamble Safely.</li>
                            <li>Draw will start at 8pm (GMT+7) only if minimum tickets are sold.</li>
                            <li>If minimum tickets are not sold. All players will get full refund.</li>
                            <li>Your freeroll tickets will automatically enrolls you to the freeroll draw.</li>
                            <li> You can withdraw your winnings to “Expat eWallet” or any other method that is suitable for you in your country from our list.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="img text-center">
                        <img src="{{ asset('assets/images/rules.png') }}" class="img-fluid" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===========================  Time Clock  =========================== -->
    <div class="time_clock_sec mb-5">
        <div class="container">
            <div class="clock_wrapper text-center">
                <div class="mb-5">
                    <img src="{{ asset('assets/images/clock.png') }}" class="img-fluid" alt="image">
                </div>
                <div class="section_heading">
                    <img src="{{ asset('assets/images/icon/horizontal-right.png') }}" class="img-fluid heading_arrow" alt="icon">
                    <h3 style="vertical-align: middle;">Christmas Island</h3>
                    <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="img-fluid heading_arrow" alt="icon">
                    <p>Time for Christmas Island time zone is the same as the following <br /> countries, Cambodia, Lao, Thailand, Vietnam and Western Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="assets/vendor/flipclock.min.js"></script>
    <script src="assets/vendor/moment.min.js"></script>
    <script src="assets/vendor/moment-timezone.min.js"></script>
    <script src="assets/vendor/moment-timezone-with-data.min.js"></script>
    <script src="assets/vendor/countdowntime.js"></script>
    <script>
    $('.cd100').countdown100({
        endtimeHours: 15,
        endtimeMinutes: 0,
        endtimeSeconds: 0,
        timeZone: ""
    });
    </script>
    @endpush
@endsection
