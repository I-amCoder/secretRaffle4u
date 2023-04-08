@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10">
              <div class="card-body p-0">
                  <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Commission From')</th>
                                <th>@lang('Commission To')</th>
                                <th>@lang('Transaction - Type')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Title')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commissionLog as $log)
                            <tr>
                                <td data-label="@lang('Commission From')">
                                    <span class="font-weight-bold">{{ $log->userFrom->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $log->userFrom->id) }}"><span>@</span>{{ $log->userFrom->username }}</a> </span>
                                </td>
                                <td data-label="@lang('Commission To')">
                                    <span class="font-weight-bold">{{ $log->userTo->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $log->userTo->id) }}"><span>@</span>{{ $log->userTo->username }}</a> </span>
                                </td>
                                <td data-label="@lang('Transaction - Type')">
                                    <strong>{{ $log->trx }}</strong>
                                    <br>
                                    @if($log->type == 'deposit')
                                        <span class="badge badge--success">@lang('Deposit')</span>
                                    @elseif($log->type == 'interest')
                                        <span class="badge badge--info">@lang('Interest')</span>
                                    @elseif($log->type == 'win')
                                        <span class="badge badge--primary">@lang('Win')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Amount')">{{ $general->cur_sym }}{{ getAmount($log->amount) }}</td>
                                <td data-label="@lang('Title')">{{ __($log->title) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center">@lang('Log Not found')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="card-footer">
                    <nav aria-label="...">
                        {{ $commissionLog->links('admin.partials.paginate') }}
                    </nav>

                </div>
            </div>
        </div>
    </div>
@endsection
