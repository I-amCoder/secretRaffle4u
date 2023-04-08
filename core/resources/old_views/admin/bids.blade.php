@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card b-radius--10">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('User')</th>
                                    <th scope="col">@lang('Game Name')</th>
                                    <th scope="col">@lang('User Choose')</th>
                                    <th scope="col">@lang('Invest Amount')</th>
                                    <th scope="col">@lang('Draw Date')</th>
                                    <th scope="col">@lang('Draw Status')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($bids as $bid )
                                    <tr>
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">{{ $bid->user->fullname }}</span>
                                            <br>
                                            <span class="small"> <a
                                                    href="{{ route('admin.users.detail', $bid->user->id) }}"><span>@</span>{{ $bid->user->username }}</a> </span>
                                        </td>

                                        <td data-label="@lang('Game Name')">{{ $bid->game->name }}</td>
                                        <td data-label="@lang('User Choose')">
                                            @if($bid->game->id == 4 || $bid->game->id == 5)
                                                @foreach($bid->chooses as $choose)
                                                    {{ $choose->choose }}@if($loop->last) @else,@endif
                                                @endforeach
                                            @else
                                                {{ $bid->user_choose }}
                                            @endif
                                        </td>
                                        <td data-label="@lang('Invest Amount')">{{ $general->cur_sym }} {{ getAmount($bid->invest) }}</td>
                                        <td data-label="@lang('Draw Date')">{{ showDateTime($bid->phase->end_date,'Y-M-d') }}
                                            <br>{{ diffForHumans($bid->phase->end_date) }}</td>
                                        <td data-label="@lang('Draw Status')">
                                            @if($bid->phase->draw_status == 1)
                                                <span
                                                    class="badge badge--success font-weight-normal">@lang('Draw Complete')</span>
                                            @elseif($bid->phase->end_date < Carbon\Carbon::today())
                                                <span
                                                    class="badge badge--warning font-weight-normal">@lang('Waiting For Draw')</span>
                                            @elseif($bid->phase->draw_status == 0)
                                                <span
                                                    class="badge badge--danger font-weight-normal">@lang('Running')</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">@lang('Bid Not Found')</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $bids->links('admin.partials.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form
        action=""
        method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="search" type="text" class="datepicker-here form-control" placeholder="@lang('Username/Game Name')" autocomplete="off" value="{{ @$search }}" required>
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
