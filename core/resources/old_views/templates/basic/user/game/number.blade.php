@extends($activeTemplate .'layouts.master')
@section('content')

    <!-- ninty game section start -->
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
            <form action="{{ route('user.game.numberBid') }}" method="post">
                @csrf

                <input type="hidden" name="phase_id" value="{{ $phase->id }}">

                <div class="row gy-4">
                    
                    <div class="col-lg-9">
                        <div class="ninty-result mb-3">

                            @for($i = 0; $i < count(json_decode($phase->game->win_bonus)->level); $i++)
                                <div class="ninty-single">
                                    <div class="singleHole hole{{ $i + 1 }}" data-holeno="{{ $i + 1 }}"></div>
                                    <input type="hidden" class="select{{ $i + 1 }}" name="numbers[]">
                                </div><!-- ninty-single end -->
                            @endfor

                        </div>
                        <div class="all-number d-flex flex-wrap justify-content-center">

                            @for($i = 0; $i < 100; $i++)
                                <button type="button"
                                        class="ninty-btn custom-btn neom-ball bttn srl{{ $i }}">{{ __($i) }}</button>
                            @endfor

                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card custom--card">
                            <div class="card-header">
                                <h4>@lang('Game Bid')</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="invest" autocomplete="off" class="form--control"
                                               placeholder="e.g. {{ $general->cur_sym }}{{ getAmount($phase->game->max_limit) }}">
                                        <span class="input-group-text">{{ $general->cur_sym }}</span>
                                    </div>
                                </div><!-- form-group end -->
                                <div class="form-group">
                                    <p class="mb-2">@lang('Minimum Invest Limit:') {{ $general->cur_sym }}{{ getAmount($phase->game->min_limit) }}</p>
                                </div><!-- form-group end -->
                                <div class="form-group">
                                    <p class="mb-2">@lang('Maximum Invest Limit:') {{ $general->cur_sym }}{{ getAmount($phase->game->max_limit) }}</p>
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
    <!-- ninty game section end -->

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
        .op-0 {
            opacity: 0;
        }

        .clicked {
            cursor: auto !important;
        }

        .icon h1 {
            margin-bottom: -54px;
        }

        .icon h4 {
            margin-top: -54px;
        }

        .singleHole {
            font-family: "ds-digitalbold";
            text-shadow: -1px -1px 1px #fff, 3px 3px 3px #000;
        }

        .c-point {
            cursor: pointer;
        }
    </style>
@endpush
@push('script')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            $('.ninty-btn').click(function () {
                if ($(this).hasClass('clicked') || $(this).hasClass('comp')) {
                    return false;
                }
                selectCom({{ count(json_decode($phase->game->win_bonus)->level) }} -1)
                @for($i = 0; $i < count(json_decode($phase->game->win_bonus)->level); $i++)
                if (!$('.hole{{ $i + 1 }}').hasClass('data-fill')) {
                    $('.hole{{ $i + 1 }}').addClass('data-fill');
                    $('.hole{{ $i + 1 }}').text($(this).text());
                    $('.select{{ $i + 1 }}').val($(this).text());
                    $(this).addClass('op-0 clicked');
                    return;
                }
                @endfor
            });
            $('.singleHole').click(function () {
                var element = $(`.srl${$(this).text()}`);
                element.removeClass('op-0 clicked');
                $(this).removeClass('data-fill');
                $(this).text('');
                $(`.select${$(this).data('holeno')}`).val('');
                selectCom({{ count(json_decode($phase->game->win_bonus)->level) }})
            });

            function selectCom(num) {
                var lenth = $('.data-fill').length;
                if (num == lenth) {
                    $('.ninty-btn').addClass('comp');
                } else {
                    $('.ninty-btn').removeClass('comp');
                }
            }

            $('.infoBtn').click(function () {
                $('#Modal').modal('show');
            });
            $('.close').click(function () {
                $('.infoBtn').removeClass('d-none');
            });
        })(jQuery);
    </script>
@endpush
