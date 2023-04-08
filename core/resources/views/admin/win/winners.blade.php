@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Game Name')</th>
                                <th scope="col">@lang('Winning Content')</th>
                                <th scope="col">@lang('Draw Date')</th>
                                <th scope="col">@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse( $winners as $win )
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $win->user->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $win->user->id) }}"><span>@</span>{{ $win->user->username }}</a> </span>
                                </td>
                                <td data-label="Game Name">{{ __($win->phase->game->name) }}</td>
                                <td data-label="Win">
                                    {{ __($win->win) }}
                                </td>
                                <td data-label="Draw Date">
                                    {{ showDateTime($win->phase->end_date) }}<br>{{ diffForHumans($win->phase->end_date) }}
                                </td>
                                <td data-label="Amount">
                                    {{ __(getAmount($win->amo)) }} {{ $general->cur_text }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                {{ $winners->links('admin.partials.paginate') }}
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
            <input name="search" type="text" class="datepicker-here form-control" placeholder="@lang('Username')" autocomplete="off" value="{{ @$search }}" required>
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
