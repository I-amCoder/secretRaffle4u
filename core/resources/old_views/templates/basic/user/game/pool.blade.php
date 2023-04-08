@extends($activeTemplate .'layouts.master')
@section('content')

    <!-- pool game section start -->
    <section class="pt-100 pb-100">.
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="game-countdown-wrapper text-center">
                        <h2>@lang('Game will be ended')</h2>
                        <span class="game-end-date">{{ showDateTime($phase->end_date) }}</span>
                        <div class="jackpot-countdown jc_1 mt-4" data-year="{{ showDateTime($phase->end_date,'Y') }}"
                             data-month="{{ showDateTime($phase->end_date,'m') }}"
                             data-day="{{ showDateTime($phase->end_date,'d') }}"
                             data-hour="{{ showDateTime($phase->end_date,'h') }}"
                             data-minute="{{ showDateTime($phase->end_date,'i') }}"></div>
                    </div>
                </div>
            </div><!-- row end -->
            <form action="{{ route('user.game.poolBid') }}" method="post">
                @csrf

                <input type="hidden" name="phase_id" value="{{ $phase->id }}">
                <input type="hidden" name="user_choose">

                <div class="row gy-4">
                    
                    <div class="col-lg-8">
                        <div class="all-number h-100">
                            <div class="row gy-3 justify-content-center">
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/01.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="1">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/02.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="2">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/03.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="3">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/04.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="4">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/05.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="5">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/06.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="6">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/07.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="7">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="pool-single">
                                        <img src="{{asset($activeTemplateTrue.'images/pool-ball/08.png')}}" alt="image">
                                        <input type="hidden" name="pool" value="8">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card custom--card">
                            <div class="card-header">
                                <h4>@lang('Game Bid')</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="mb-2">@lang('Invest Amount') (@lang('Invest Limit')
                                        : {{ $general->cur_sym }}{{ getAmount($phase->game->min_limit) }}
                                        - {{ $general->cur_sym }}{{ getAmount($phase->game->max_limit) }})</p>
                                    <div class="input-group">
                                        <input type="text" name="invest" autocomplete="off" class="form--control"
                                               placeholder="e.g. {{ $general->cur_sym }}{{ getAmount($phase->game->max_limit) }}">
                                        <span class="input-group-text">{{ $general->cur_sym }}</span>
                                    </div>
                                </div><!-- form-group end -->
                                <div class="form-group">
                                    <p class="mb-2">@lang('Win Bonus')</p>
                                    <div class="input-group">
                                        <input type="number" class="form--control bon"
                                               value="{{ $phase->game->win_bonus }}"
                                               readonly>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div><!-- form-group end -->
                                <div class="form-group">
                                    <p class="mb-2">@lang('Win Bonus Amount')</p>
                                    <div class="input-group">
                                        <input type="number" name="#0" class="form--control winAmo" value="0"
                                               readonly>
                                        <span class="input-group-text">{{ $general->cur_sym }}</span>
                                    </div>
                                </div><!-- form-group end -->
                                <button type="submit"
                                        class="btn btn--base btn--custom w-100 mt-2 mb-2">@lang('Bid Now')</button>
                                <div class="infoBtn text-center c-point" data-bs-toggle="tooltip"
                                     data-bs-placement="top"
                                     title="Game Instruction">
                                    <i class="las la-info-circle"></i>
                                    @lang('Game Instruction')
                                </div>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>

                    
                </div><!-- row end -->
            </form>
        </div>
    </section>
    <!-- pool game section end -->

    <!-- Modal -->
    <div class="modal fade custom--modal" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Game Instruction')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php echo $phase->game->instruction @endphp
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .c-point {
            cursor: pointer;
            border-radius: 30px;
        }

        .infoBtn {
            cursor: pointer;
        }

        .ball7 {
            max-height: 156px;
        }
    </style>
@endpush
@push('script')
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('.pool-single').click(function () {
                $('.pool-single').removeClass('active')
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active');
                    $('input[name=user_choose]').val($(this).find('input[name=pool]').val());
                } else {
                    $(this).removeClass('active');
                    $('input[name=user_choose]').val('');
                }
            });

            $('input[name=invest]').on('input', function () {
                var invest = $(this).val();
                var bon = {{ $phase->game->win_bonus }};
                var win_bonus = invest * (bon / 100);
                $('.winAmo').val(win_bonus)
            });

            $('.infoBtn').click(function () {
                $('#Modal').modal('show');
            });
            $('.close').click(function () {
                $('.infoBtn').removeClass('d-none');
            });
        })(jQuery);
    </script>
@endpush
