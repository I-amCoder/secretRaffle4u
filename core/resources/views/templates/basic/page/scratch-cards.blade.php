@extends($activeTemplate.'layouts.frontend')



@section('content')



    @php

        $banner = getContent('rafflebanner.content',true);
		$helpers = new \App\Lib\Helper();
    @endphp

<style>
    .img-fluid{
        height: 240px; 
        width: 100%;
    }
    
</style>


{{--
<img 

    src="{{ getImage('assets/images/frontend/rafflebanner/' . @$banner->data_values->image, '1920x961') }}"

    style="max-width: 100%;"

    class="d-md-none"

>


--}}
<!-- ===========================  Banner  =========================== -->
{{--
<div 

    class="banner d-none d-md-block"

    {{-- style="background-image: url({{ asset('assets/images/banner/raffle-draw.png') }}); padding: 70px 0px; height: 580px;" --}}

    style="

        background-image: url({{ getImage('assets/images/frontend/rafflebanner/' . @$banner->data_values->image, '1920x961') }}); 

        height: 500px;

        background-position: center;

    "

>

    <div class="container">

        <div class="row">

            <div class="banner_content text-center align-items-center pt-4">

                {{-- <h2>Raffle Draw</h2> --}}

                {{-- <img src="{{ asset('assets/images/banner/ticket2.png') }}" width="450" class="img-fluid" alt="image"> --}}

            </div>

        </div>

    </div>

</div>


--}}
<!-- ===========================  Raffle Drew  =========================== -->

<div class="raffile_drew_sec card_sec mb-5 p-0">



    <div class="container">



        @if(isset($raffle_cat) && count($raffle_cat) > 0 )

        @foreach ($raffle_cat as $cat)



        @php

        $games = [];

        @endphp



        <div class="mb-5">

            <div class="row d-flex justify-content-center">

                 <div class="bottom">

                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-10">

                            <h2>{{ $cat->title }}<img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>

                        </div>

                    </div>

                </div>

            </div>



            <div class="card_bg mb-5">

                <div class="d-flex justify-content-center">

                    <div class="col-lg-9">

                        <div class="row g-5">



                            @if(isset($raffles) && count($raffles) > 0)

                                @foreach ($raffles as $item)

                                    @if($item->category_id == $cat->id )

                                    <div class="col-md-6 text-center">

                                        <div class="raffle_draw_pro">

                                            

                                            <h2 style="margin-bottom: 10px;">{{ $item->title }}</h2>

                                            

                                           

                                            <a style="background: none;padding: 0;margin: 0; display:block" href="{{ route('scratch_cards_game',$item->id) }}">

                                            <?php
                                            $thumb_img = $_SERVER['DOCUMENT_ROOT'].'/assets/images/game/thumb_'.$item->photo;
                                            ?>
                                            @if(file_exists($thumb_img))
                                            <img src="{{ getRafflePhoto('thumb_'.$item->photo) }}" class="img-fluid" alt="image">
                                            @else
                                            <img src="{{ getRafflePhoto($item->photo) }}" class="img-fluid" alt="image">
                                            @endif

                                            </a>

                                        

										{{--<a href="{{ route('scratch_cards_game',$item->id) }}">{{ $general->cur_sym }}{{ number_format($item->unit_price,2) }}</a>--}}
										<a href="{{ route('scratch_cards_game',$item->id) }}">{{ Session::get('currency_symbol') }}{{ number_format($helpers->convert_to_currency(Session::get('currency'), $item->unit_price),2) }}</a>

                                        

                                        </div>

                                    </div>

                                    @php

                                    array_push($games,$item->id)

                                    @endphp

                                @endif

                                @endforeach

                            @endif



                            



                        </div>

                    </div>

                </div>

            </div>



        </div>



        @endforeach

        @endif



        {{-- <div class="mb-5">

            <div class="row d-flex justify-content-center">

                 <div class="bottom">

                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-10">

                            <h2>Daily Chilled draw <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card_bg mb-5">

                <div class="d-flex justify-content-center">

                    <div class="col-lg-9">

                        <div class="row g-5">

                             <div class="col-md-6 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Pg Tea Time</h2>

                                      <img src="{{ asset('assets/images/product/9.png') }}" class="img-fluid" alt="image">

                                      <a href="#">฿5,555 X 5</a>

                                  </div>

                             </div>

                             <div class="col-md-6 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Daily Freeroll</h2>

                                      <img src="{{ asset('assets/images/product/10.png') }}" class="img-fluid" alt="image">

                                      <a href="{{route('raffleDrawFree')}}">Free</a>

                                  </div>

                             </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>





        <div class="mb-5">

            <div class="row d-flex justify-content-center">

                 <div class="bottom">

                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-10">

                            <h2>Deekly Jolly draw <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card_bg mb-5">

                <div class="d-flex justify-content-center">

                    <div class="col-lg-9">

                         <div class="row g-3">

                             <div class="col-md-4 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Daily Salary</h2>

                                      <img src="{{ asset('assets/images/product/11.png') }}" class="img-fluid" alt="image">

                                     <div class="text-end">

                                          <a href="#">฿555</a>

                                     </div>

                                  </div>

                             </div>

                             <div class="col-md-4 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Weekly Expenses</h2>

                                      <img src="{{ asset('assets/images/product/12.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                           <a href="#">฿5,555</a>

                                     </div>

                                  </div>

                             </div>

                             <div class="col-md-4 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Monthly Family Support</h2>

                                      <img src="{{ asset('assets/images/product/13.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                          <a href="#">฿55,555</a>

                                      </div>

                                  </div>

                             </div>

                             <div class="col-md-4 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Make A Business</h2>

                                      <img src="{{ asset('assets/images/product/14.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                          <a href="#">฿555,555</a>

                                      </div>

                                  </div>

                             </div>

                             <div class="col-md-4 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Weekly Freeroll</h2>

                                      <img src="{{ asset('assets/images/product/15.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                          <a href="#">Free</a>

                                      </div>

                                  </div>

                             </div>

                         </div>

                    </div>

                </div>

            </div>

        </div>



         <div class="mb-5">

            <div class="row d-flex justify-content-center">

                 <div class="bottom">

                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-10">

                            <h2>Monthly Happy Draw <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card_bg mb-5">

                <div class="d-flex justify-content-center">

                    <div class="col-lg-9">

                        <div class="row g-5">

                             <div class="col-md-6 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Create Better Life</h2>

                                      <img src="{{ asset('assets/images/product/16.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                           <a href="#">฿5,555 X 5</a>

                                      </div>

                                  </div>

                             </div>

                             <div class="col-md-6 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Monthly Freeroll</h2>

                                      <img src="{{ asset('assets/images/product/17.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                          <a href="#">Free</a>

                                      </div>

                                  </div>

                             </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="mb-5">

            <div class="row d-flex justify-content-center">

                 <div class="bottom">

                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-10">

                            <h2>Yearly Rosy Draw <img src="{{ asset('assets/images/icon/horizontal-left.png') }}" class="heading_arrow" alt=""></h2>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card_bg mb-5">

                <div class="d-flex justify-content-center">

                    <div class="col-lg-9">

                        <div class="row g-5">

                             <div class="col-md-6 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Fluffy Snowy Christmas</h2>

                                      <img src="{{ asset('assets/images/product/18.png') }}" class="img-fluid" alt="image">

                                     <div class="text-end">

                                          <a href="#">฿55,555,555</a>

                                     </div>

                                  </div>

                             </div>

                             <div class="col-md-6 text-center">

                                  <div class="raffle_draw_pro">

                                      <h2>Yearly Freeroll</h2>

                                      <img src="{{ asset('assets/images/product/19.png') }}" class="img-fluid" alt="image">

                                      <div class="text-end">

                                          <a href="#">Free</a>

                                      </div>

                                  </div>

                             </div>

                        </div>

                    </div>

                </div>

            </div>

        </div> --}}



    </div>

</div>

@endsection

