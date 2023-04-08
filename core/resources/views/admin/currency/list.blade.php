@extends('admin.layouts.app')
@section('panel')
    


    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form 
                    
                        @if(isset($currency))
                            action="{{route('admin.currencies.edit', [ 'id'=> $currency->id ] )}}"
                        @else
                            action="{{route('admin.currencies.create')}}"
                        @endif

                        method="POST"
                    >
                        @csrf                

                        @if(isset($currency))
                            <input type="hidden" name="id" value="{{$currency->id}}" >
                        @endif

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">Name</label>
                                    <input 
                                        class="form-control form-control-lg" 
                                        type="text" 
                                        name="name" 
                                        required 
                                        value="@if(isset($currency)){{$currency->name}}@endif"
                                    >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">Code</label>
                                    <input 
                                        class="form-control form-control-lg" 
                                        type="text" 
                                        name="code" 
                                        required
                                        value="@if(isset($currency)){{$currency->code}}@endif"
                                    >
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">Rate (against USD)</label>
                                    <input 
                                        class="form-control form-control-lg" 
                                        type="number" 
                                        min="0" 
                                        step="0.01"
                                         name="rate" 
                                         required 
                                         value="@if(isset($currency)){{$currency->rate}}@endif"
                                    >
                                </div>
                            </div>

                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary  btn-lg">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    


    @if(!isset($currency))

    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">

            
                <div class="card-body p-0">


                    
                    <div class="table-responsive--md  table-responsive">
                        
                        

                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Rate</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($users as $user)

                                <tr>

                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{$user->name}}</span>
                                    </td>


                                    <td data-label="@lang('Email-Phone')">
                                        <span class="font-weight-bold">{{$user->code}}</span>
                                    </td>

                                    <td data-label="@lang('Country')">
                                        <span class="font-weight-bold">{{$user->rate}} {{$user->code}}</span>
                                    </td>

                                    <td data-label="@lang('Action')">
                                    
                                        <a href="{{ route('admin.currencies.edit.form', $user->id) }}" class="icon-btn mr-2" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a>

                                        <a href="{{ route('admin.currencies.delete', $user->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Delete')" style="background: red;">
                                            <i class="las la-trash text--shadow"></i>
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>

                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($users) }}
                </div>
            </div>
        </div>


    </div>
    
    @endif


@endsection



@push('breadcrumb-plugins')
{{--
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
--}}
@endpush
