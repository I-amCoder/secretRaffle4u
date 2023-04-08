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
                                <th>@lang('Available tickets')</th>
                                <th>@lang('Tickets Sold')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($raffles) && count($raffles) >0)
                            @foreach ($raffles as $key=>$row)
								@php
								$paytables = $row->paytable;
								@endphp
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
                                <td>{{ $row->tickets_sold() }}</td>
                                <td>
								@if(count($paytables) > 0)
                                <a href="{{ route('admin.paytable.show', [$row->id]) }}"  class="icon-btn ml-1 editBtn" data-original-title="@lang('View')" data-toggle="tooltip"><i class="la la-eye"></i></a>
								@else
								<a href="{{ route('admin.paytable.create', [$row->id]) }}"  class="icon-btn ml-1 editBtn" data-original-title="@lang('Create')" data-toggle="tooltip"><i class="la la-plus"></i></a>
								@endif
                                    <a href="{{ route('admin.scratch.edit', [$row->id]) }}"  class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip"><i class="la la-edit"></i></a>
                                    
                                    
                                    <a 
                                        href="{{ route('admin.scratch.delete', [$row->id]) }}"  
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




