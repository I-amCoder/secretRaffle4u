@extends($activeTemplate .'layouts.master')
@section('content')

    <section class="pb-100 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Game Name')</th>
                                <th scope="col">@lang('Win')</th>
                                <th scope="col">@lang('Draw Date')</th>
                                <th scope="col">@lang('Win Bonus')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse( $wins as $win )
                                <tr>
                                    <td data-label="@lang('Game')">{{ __($win->phase->game->name) }}</td>
                                    <td data-label="@lang('Win')">
                                        {{ __($win->win) }}
                                    </td>
                                    <td data-label="@lang('Draw Date')">
                                        {{ __($win->phase->end_date) }}
                                    </td>
                                    <td data-label="@lang('Win Bonus')">
                                        {{ $general->cur_sym }}{{ __(getAmount($win->amo)) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $wins->links() }}

                </div>
            </div>
        </div>
    </section>
@endsection
