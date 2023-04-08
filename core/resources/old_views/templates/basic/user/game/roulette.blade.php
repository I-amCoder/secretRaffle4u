@extends($activeTemplate .'layouts.master')
@section('content')

    <!-- roulette game section start -->
    <section class="pt-100 pb-100">
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
            <form action="{{ route('user.game.rouletteBid') }}" method="post">
                @csrf

                <input type="hidden" name="phase_id" value="{{ $phase->id }}">
                <input type="hidden" name="choose">
                <input type="hidden" name="numbers">

                <div class="row gy-4">
                    <div class="col-xxl-8 col-lg-9">
                        <div class="all-number d-block roulette-wrapper">
                            <table class="d-flex justify-content-center">
                                <tbody>
                                <tr class="numbers">
                                    <td rowspan="3" class="bg-success zero"> 0</td>
                                    <td class="bg-danger redEl oneToTwEl oneToEtEl oddEl"> 3</td>
                                    <td class="bg-dark blackEl oneToTwEl oneToEtEl evenEl"> 6</td>
                                    <td class="bg-danger redEl oneToTwEl oneToEtEl oddEl"> 9</td>
                                    <td class="bg-danger redEl oneToTwEl oneToEtEl evenEl"> 12</td>
                                    <td class="bg-dark blackEl thrtToTfEl oneToEtEl oddEl"> 15</td>
                                    <td class="bg-danger redEl thrtToTfEl oneToEtEl evenEl"> 18</td>
                                    <td class="bg-danger redEl thrtToTfEl nineteenTtsixEl oddEl"> 21</td>
                                    <td class="bg-dark blackEl thrtToTfEl nineteenTtsixEl evenEl"> 24</td>
                                    <td class="bg-danger redEl twfToTsEl nineteenTtsixEl oddEl"> 27</td>
                                    <td class="bg-danger redEl twfToTsEl nineteenTtsixEl evenEl"> 30</td>
                                    <td class="bg-dark blackEl twfToTsEl nineteenTtsixEl oddEl"> 33</td>
                                    <td class="bg-danger redEl twfToTsEl nineteenTtsixEl evenEl"> 36</td>
                                    <td class="twByOne1 p-0">
                                        <button type="button" class="text-white">2:1</button>
                                        <input type="hidden" value="0">
                                    </td>
                                </tr>
                                <tr class="numbers">
                                    <td class="bg-dark blackEl oneToTwEl oneToEtEl evenEl"> 2</td>
                                    <td class="bg-danger redEl oneToTwEl oneToEtEl oddEl"> 5</td>
                                    <td class="bg-dark blackEl oneToTwEl oneToEtEl evenEl"> 8</td>
                                    <td class="bg-dark blackEl oneToTwEl oneToEtEl oddEl"> 11</td>
                                    <td class="bg-danger redEl thrtToTfEl oneToEtEl evenEl"> 14</td>
                                    <td class="bg-dark blackEl thrtToTfEl oneToEtEl oddEl"> 17</td>
                                    <td class="bg-dark blackEl thrtToTfEl nineteenTtsixEl evenEl">20</td>
                                    <td class="bg-danger redEl thrtToTfEl nineteenTtsixEl oddEl"> 23</td>
                                    <td class="bg-dark blackEl twfToTsEl nineteenTtsixEl evenEl"> 26</td>
                                    <td class="bg-dark blackEl twfToTsEl nineteenTtsixEl oddEl"> 29</td>
                                    <td class="bg-danger redEl twfToTsEl nineteenTtsixEl evenEl"> 32</td>
                                    <td class="bg-dark blackEl twfToTsEl nineteenTtsixEl oddEl"> 35</td>
                                    <td class="twByOne2 p-0">
                                        <button type="button" class="text-white">2:1</button>
                                        <input type="hidden" value="0">
                                    </td>
                                </tr>
                                <tr class="numbers">
                                    <td class="bg-danger redEl oneToTwEl oneToEtEl oddEl"> 1</td>
                                    <td class="bg-dark blackEl oneToTwEl oneToEtEl evenEl"> 4</td>
                                    <td class="bg-danger redEl oneToTwEl oneToEtEl oddEl"> 7</td>
                                    <td class="bg-dark blackEl oneToTwEl oneToEtEl evenEl"> 10</td>
                                    <td class="bg-dark blackEl thrtToTfEl oneToEtEl oddEl"> 13</td>
                                    <td class="bg-danger redEl thrtToTfEl oneToEtEl evenEl"> 16</td>
                                    <td class="bg-danger redEl thrtToTfEl nineteenTtsixEl oddEl"> 19</td>
                                    <td class="bg-dark blackEl thrtToTfEl nineteenTtsixEl evenEl"> 22</td>
                                    <td class="bg-danger redEl twfToTsEl nineteenTtsixEl oddEl"> 25</td>
                                    <td class="bg-dark blackEl twfToTsEl nineteenTtsixEl evenEl"> 28</td>
                                    <td class="bg-dark blackEl twfToTsEl nineteenTtsixEl oddEl"> 31</td>
                                    <td class="bg-danger redEl twfToTsEl nineteenTtsixEl evenEl"> 34</td>
                                    <td class="twByOne3 p-0">
                                        <button type="button" class="text-white">2:1</button>
                                        <input type="hidden" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    {{--                                    <td rowspan="2"></td>--}}
                                    <td colspan="5" class="text-center oneToTw p-0">
                                        <button class="w-100 text-white" type="button"><strong>@lang('1 to 12')</strong>
                                        </button>
                                        <input type="hidden" value="0">
                                    </td>
                                    <td colspan="5" class="text-center thrtToTf p-0">
                                        <button class="w-100 text-white" type="button">
                                            <strong>@lang('13 to 24')</strong></button>
                                        <input type="hidden" value="0">
                                    </td>
                                    <td colspan="5" class="text-center twfToTs p-0">
                                        <button class="w-100 text-white" type="button">
                                            <strong>@lang('25 to 36')</strong></button>
                                        <input type="hidden" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center oneToEt p-0">
                                        <button class="w-100 text-white" type="button"><strong>@lang('1 to 18')</strong>
                                        </button>
                                        <input type="hidden" value="0">
                                    </td>
                                    <td colspan="2" class="text-center even p-0">
                                        <button class="w-100 text-white" type="button"><strong>@lang('Even')</strong>
                                        </button>
                                        <input type="hidden" value="0">
                                    </td>
                                    <td colspan="3" class="bg-danger red p-0">
                                        <span class="d-none">sdfgsdfg</span><input type="hidden" value="0">
                                    </td>
                                    <td colspan="3" class="bg-dark black p-0">
                                        <span class="d-none">sfgsdfg</span>
                                        <input type="hidden" value="0">
                                    </td>
                                    <td colspan="2" class="text-center odd p-0">
                                        <button class="w-100 text-white" type="button"><strong>@lang('Odd')</strong>
                                        </button>
                                        <input type="hidden" value="0">
                                    </td>
                                    <td colspan="2" class="text-center nineteenTtsix p-0">
                                        <button class="w-100 text-white" type="button">
                                            <strong>@lang('19 to 36')</strong></button>
                                        <input type="hidden" value="0">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-lg-3">
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
                                        <input type="number" class="form--control bon" value="0" readonly>
                                        <span class="input-group-text">x</span>
                                    </div>
                                </div><!-- form-group end -->
                                <div class="form-group">
                                    <p class="mb-2">@lang('Win Bonus Amount')</p>
                                    <div class="input-group">
                                        <input type="number" class="form--control winAmo" value="0" readonly>
                                        <span class="input-group-text">{{ $general->cur_sym }}</span>
                                    </div>
                                </div><!-- form-group end -->
                                <button type="submit"
                                        class="btn btn--base btn--custom w-100 mt-2 mb-2">@lang('Bid Now')</button>
                                <div class="infoBtn text-center c-point" data-bs-toggle="tooltip" data-bs-placement="top"
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
    <!-- roulette game section end -->

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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/user/css/roulette.css') }}">
    <style type="text/css">
        .select {
            box-shadow: unset !important;
        }

        .p-0 {
            padding: 0px !important;
        }

         .c-point {
             cursor: pointer;
         }
</style>
@endpush
@push('script')
    <script type="text/javascript" src="{{ asset('assets/user/js/roulette.js') }}"></script>
    <script type="text/javascript">
        function bonus(item) {
            var amo = 36 / item;
            $('.bon').val(amo);
        }

        $('.infoBtn').click(function () {
            $('#Modal').modal('show');
        });
        $('.close').click(function () {
            $('.infoBtn').removeClass('d-none');
        });
    </script>
@endpush
