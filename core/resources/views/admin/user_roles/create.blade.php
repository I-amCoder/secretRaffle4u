@extends('admin.layouts.app')

@section('panel')
<div class="row">


    <div class="col-lg-12">
        <form action="{{ route('admin.roles.permissions.update', $user->id) }}" method="POST">
            @csrf
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Role')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            @php
                            // $checkpermission=explode(',', $user->permissions);

                            @endphp
                            <tbody>
                                @if(!empty($user_links) && count($user_links) >0)
                                @foreach ($user_links as $key=>$row)

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->type }}</td>
                                    <td>
                                        <input type="checkbox" value="{{ $row->id }}" class="form-control" name="permissions[]" />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    <button type="submit" class="btn btn--primary btn-large">Update</button>
                </div>
        </form>
    </div><!-- card end -->
</div>
</div>
@endsection
