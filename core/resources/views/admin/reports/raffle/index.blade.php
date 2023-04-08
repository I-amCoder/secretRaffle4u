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
                                <th>@lang('SL')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Photo')</th>
                                <th>@lang('Unit price')</th>
                                <th>@lang('Total tickets')</th>
                                <th>@lang('Min tickets')</th>
                                <th>@lang('Start time')</th>
                                <th>@lang('End time')</th>
                                <th>@lang('Has Free')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($raffles) && count($raffles) >0)
                            @foreach ($raffles as $key=>$row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->category->name }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->status==1 ? 'Active':'Inactive' }}</td>
                                <td>
                                    <img src="{{ getImage('assets/images/game/'. $row->photo) }}" alt="" width="50">
                                </td>
                                <td>{{ $row->unit_price }}</td>
                                <td>{{ $row->total_tickets }}</td>
                                <td>{{ $row->min_tickets }}</td>
                                <td>{{date('d M Y h:i A', strtotime($row->start_time)) }}</td>
                                <td>{{date('d M Y h:i A', strtotime($row->end_time))}}</td>
                                <td>{{ $row->free_ticket == 1 ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.raffle.edit', [$row->id]) }}"  class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip"><i class="la la-edit"></i></a>
                                    @if($row->free_ticket == 1)
                                    <a href="{{ route('admin.raffle.free_offer', [$row->id]) }}"  class="icon-btn  ml-1" data-original-title="@lang('add_free_offer')" data-toggle="tooltip"><i class="la la-ad"></i></a>
                                    <a href="{{ route('admin.winning_segments', [$row->id]) }}"  class="icon-btn  ml-1" data-original-title="@lang('winning_segments')" data-toggle="tooltip"><i class="la la-fan"></i></a>
                                    @endif
                                    
                                    <a 
                                        href="{{ route('admin.raffle.delete', [$row->id]) }}"  
                                        class="icon-btn ml-1 editBtn" 
                                        data-original-title="Delete" 
                                        data-toggle="tooltip"
                                        style="background: red;"
                                        onclick="return confirm('Are you sure?');"
                                    >
                                        <i class="la la-remove"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                </table><!-- table end -->
            </div>
        </div>
        <div class="card-footer py-4">
            {{ paginateLinks($raffles) }}
        </div>
    </div><!-- card end -->
</div>
</div>
@endsection

@push('breadcrumb-plugins')
@if(request()->routeIs('admin.users.transactions'))
<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@else
<form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endif
@endpush


