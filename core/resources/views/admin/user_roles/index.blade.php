@extends('admin.layouts.app')

@section('panel')
<div class="row ">
    <div class="col-lg-12 d-flex justify-content-end mb-1">
        <a href="{{ route('admin.roles.permissions.create') }}" class="btn btn-success">Create Role</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('SL')</th>
                                <th>@lang('Role')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($users) && count($users) >0)
                            @foreach ($users as $key=>$row)

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->title }}</td>

                                <td>



                                    <a href="{{ route('admin.roles.permissions.edit', [$row->id]) }}" class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip"><i class="la la-edit"></i></a>


                                    <a href="{{ route('admin.scratch.delete', [$row->id]) }}" class="icon-btn ml-1 editBtn" data-original-title="Delete" data-toggle="tooltip" style="background: red;" onclick="return confirm('Are you sure?');">
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
            <!-- <div class="card-footer py-4">
          
        </div> -->
        </div><!-- card end -->
    </div>
</div>
@endsection
