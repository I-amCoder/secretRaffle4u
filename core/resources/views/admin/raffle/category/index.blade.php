@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>@lang('Raffle Draw Category')</h4>
                </div> --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('is show on home')</th>
                                <th>@lang('Photo')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($category) && count($category) > 0)
                                @foreach ($category as $key=> $row)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>@if($row->is_show_on_home_page==1) Yes @else No @endif</td>
                                    <td>
                                        <img src="{{ getImage('assets/images/category/'. $row->photo) }}" alt="" width="50">
                                    </td>
                                    <td>@if($row->status==1) Active @else Inactive @endif</td>
                                    <td>
                                        <a href="{{ route('admin.raffle.category.edit', [$row->id]) }}"  class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip"><i class="la la-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
