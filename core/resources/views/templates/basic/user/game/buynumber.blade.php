@extends($activeTemplate .'layouts.master')
@section('content')

    <!-- number game section start -->
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
            <form action="{{ route('user.game.buyNumberBid') }}" method="post">
                @csrf

                <input type="hidden" name="phase_id" value="{{ $phase->id }}">
                <input type="hidden" name="user_choose">

                <div class="row gy-4">
                    
                    @php
                        $data = \App\Models\Bid::where('phase_id', $phase->id)->distinct('user_choose')->get();
                        $taken = [];
                       foreach ($data as $t) {
                          $taken[] = $t->user_choose;
                       }
                    @endphp
                    <div class="col-lg-9">
                        <div class="all-number allNum">
                            @for($i = 1; $i <= 100; $i++)
                                <input type="button"
                                       class="buy-btn num srl{{ $i }} @if(in_array($i, $taken)) select @endif"
                                       value="{{ $i }}">

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
    <!-- number game section end -->

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
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('input[type=button]').click(function () {
                $('input[type=button]').removeClass('selectedNumber');
                if (!$(this).hasClass('selectedNumber')) {
                    $(this).addClass('selectedNumber');
                    $('input[name=user_choose]').val($('.selectedNumber').val());
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
