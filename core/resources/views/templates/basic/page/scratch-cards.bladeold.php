@extends($activeTemplate.'layouts.frontend')
@section('content')
    <!-- ===========================  Banner  =========================== -->
    <div class="banner" style="background-image: url({{ asset('assets/images/banner/scratch-cards.png')}}); padding: 70px 0px; height: 580px;">
        <div class="container">
            <div class="row">
                <div class="banner_content text-center">
                    <div class="row align-items-center">
                        <div class="col-lg-7 heade_left">
                            <h4> Online <br> Search Cards</h4>
                            <img src="{{ asset('assets/images/icon/horizontal-left.png')}}" class="heading_arrow" alt="">
                        </div>
                        <div class="col-lg-5">
                            <img src="{{ asset('assets/images/cards.png')}}" width="500" class="img-fluid" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===========================  scratch Card  =========================== -->
    <div class="scratch_card mt-5 mb-5">
        <div class="container">
            <div class="bottom mb-5" style="padding: 50px 0px;">
                <h2>Scratch Card <img src="{{ asset('assets/images/icon/horizontal-left.png')}}" class="heading_arrow" alt=""></h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                     <div class="scratch_card scratch_list">
                          <ul>
                              <li>
                                  <div class="d-flex position-relative align-items-center">
                                      <img src="{{ asset('assets/images/icon/game.png')}}" class="flex-shrink-0 me-3" alt="image">
                                      <div>
                                         <h5>Srinivasa won ₹400.00 on <br/> <strong>Golden Ace</strong></h5>
                                      </div>
                                </div>
                              </li>
                              <li>
                                  <div class="d-flex position-relative align-items-center">
                                      <img src="{{ asset('assets/images/icon/game.png')}}" class="flex-shrink-0 me-3" alt="image">
                                      <div>
                                         <h5>Srinivasa won ₹400.00 on <br/> <strong>Golden Ace</strong></h5>
                                      </div>
                                </div>
                              </li>
                              <li>
                                  <div class="d-flex position-relative align-items-center">
                                      <img src="{{ asset('assets/images/icon/game.png')}}" class="flex-shrink-0 me-3" alt="image">
                                      <div>
                                         <h5>Srinivasa won ₹400.00 on <br/> <strong>Golden Ace</strong></h5>
                                      </div>
                                </div>
                              </li>
                              <li>
                                  <div class="d-flex position-relative align-items-center">
                                      <img src="{{ asset('assets/images/icon/game.png')}}" class="flex-shrink-0 me-3" alt="image">
                                      <div>
                                         <h5>Srinivasa won ₹400.00 on <br/> <strong>Golden Ace</strong></h5>
                                      </div>
                                </div>
                              </li>
                              <li>
                                  <div class="d-flex position-relative align-items-center">
                                      <img src="{{ asset('assets/images/icon/game.png')}}" class="flex-shrink-0 me-3" alt="image">
                                      <div>
                                         <h5>Srinivasa won ₹400.00 on <br/> <strong>Golden Ace</strong></h5>
                                      </div>
                                </div>
                              </li>

                          </ul>
                     </div>
                </div>
                <div class="col-md-6 col-xl-4 text-center">
                    <div class="scratch_card">
                        <div class="raffle_draw_pro">
                            <h2>Win ฿10,000</h2>
                            <img src="{{ asset('assets/images/product/20.png')}}" class="img-fluid" alt="image">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="pagination">
                                        <ul>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">20...</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <a href="#">฿500.00</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 text-center">
                    <div class="scratch_card">
                        <div class="raffle_draw_pro">
                            <h2>Win ฿10,000</h2>
                            <img src="{{ asset('assets/images/product/21.png')}}" class="img-fluid" alt="image">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="pagination">
                                        <ul>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">20...</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <a href="#">฿500.00</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 text-center">
                    <div class="scratch_card">
                        <div class="raffle_draw_pro">
                            <h2>Win ฿10,000</h2>
                            <img src="{{ asset('assets/images/product/22.png')}}" class="img-fluid" alt="image">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="pagination">
                                        <ul>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">20...</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <a href="#">฿500.00</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 text-center">
                    <div class="scratch_card">
                        <div class="raffle_draw_pro">
                            <h2>Win ฿10,000</h2>
                            <img src="{{ asset('assets/images/product/23.png')}}" class="img-fluid" alt="image">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="pagination">
                                        <ul>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">20...</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <a href="#">฿500.00</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 text-center">
                    <div class="scratch_card">
                        <div class="raffle_draw_pro">
                            <h2>Win ฿10,000</h2>
                            <img src="{{ asset('assets/images/product/24.png')}}" class="img-fluid" alt="image">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="pagination">
                                        <ul>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">20...</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <a href="#">฿500.00</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
