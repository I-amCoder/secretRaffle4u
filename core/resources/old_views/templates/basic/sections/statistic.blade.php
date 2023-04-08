@php
    $statistic = getContent('statistic.content',true);

    $investors = \App\Models\Bid::latest()->take(20)->with(['user', 'game'])->get();
    $winners = \App\Models\Winner::latest()->take(20)->with(['user', 'phase'])->get();
@endphp

<!-- statistics section start -->
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-8">
                <h3 class="mb-4">{{ __(@$statistic->data_values->heading_1) }}</h3>
                <ul class="table-list table-slider">

                    @forelse($winners as $winner)
                        <div class="single-slide">
                            <li class="person-single">
                                <div class="person-single__left">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$winner->user->image,imagePath()['profile']['user']['size'])}}" alt="image">
                                    </div>
                                    <div class="content">
                                        <h6 class="name fs--18px">{{ $winner->user->fullname }}</h6>
                                    </div>
                                </div>
                                <div class="person-single__game">
                                    <p class="text-muted fs--12px">@lang('Game Name')</p>
                                    <p class="text-white fs--14px">@lang($winner->phase->game->name)</p>
                                </div>
                                <div class="person-single__win-amount">
                                    <p class="text-muted fs--12px">@lang('Win Amount')</p>
                                    <p class="text-white fs--14px">{{ getAmount($winner->amo) }} {{ $general->cur_text }}</p>
                                </div>
                            </li><!-- person-single end -->
                        </div>
                    @empty
                    @endforelse

                </ul><!-- table-list end -->
            </div>
            <div class="col-lg-4">
                <h3 class="mb-4">{{ __(@$statistic->data_values->heading_2) }}</h3>
                <ul class="table-list investor--list table-slider">

                    @forelse($investors as $investor)
                        <div class="single-slide">
                            <li class="person-single">
                                <div class="person-single__left">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$investor->user->image,imagePath()['profile']['user']['size'])}}" alt="image">
                                    </div>
                                    <div class="content">
                                        <h6 class="name fs--18px">{{ @$investor->user->fullname }}</h6>
                                    </div>
                                </div>
                                <div class="person-single__amount">
                                    <p class="text-muted fs--12px">@lang('Bid Amount')</p>
                                    <p class="text-white fs--14px">{{ getAmount($investor->invest) }} {{ $general->cur_text }}</p>
                                </div>
                            </li><!-- person-single end -->
                        </div>
                    @empty
                    @endforelse

                </ul><!-- table-list end -->
            </div>
        </div>
    </div>
</section>
<!-- statistics section end -->
