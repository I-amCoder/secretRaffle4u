@extends($activeTemplate .'layouts.master')
@section('content')

    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th>@lang('Commission From')</th>
                                <th>@lang('Commission Level')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Details')</th>
                                <th>@lang('Transaction')</th>
                                <th>@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse( $commissions as $commission )
                                <tr>
                                    <td data-label="@lang('Commission From')">{{ __($commission->userFrom->username) }}</td>
                                    <td data-label="@lang('Commission Level')">{{ __($commission->level) }}</td>
                                    <td data-label="@lang('Amount')">{{ __($general->cur_sym) }}{{ __(getAmount($commission->amount)) }} </td>
                                    <td data-label="@lang('Details')">{{ __($commission->title) }}</td>
                                    <td data-label="@lang('Transaction')">{{ __($commission->trx) }}</td>
                                    <td data-label="@lang('Date')">{{ __(showDateTime($commission->create_at,'y-m-d')) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $commissions->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
