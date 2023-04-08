@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.scratch.category.update', $category->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label form-control-label">@lang('Name') <span class="text-danger">*</span></label>
                            <div class="">
                                <input class="form-control" type="text" placeholder="@lang('name')" name="name" value="{{ $category->name }}" requierd >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label form-control-label">@lang('Title') <span class="text-danger">*</span></label>
                            <div class="">
                                <input class="form-control" type="text" placeholder="@lang('title')" name="title" value="{{ $category->title }}" requierd >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label form-control-label">@lang('Home Title') <span class="text-danger">*</span></label>
                            <div class="">
                                <input class="form-control" type="text" placeholder="@lang('Home Title')" name="home_title" value="{{ $category->home_title }}" requierd >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label form-control-label">@lang('Status') <span class="text-danger">*</span></label>
                            <div class="">
                                <select class="form-control" name="status" requierd >
                                    <option value="1" @if($category->status==1) selected @endif>Active</option>
                                    <option value="0" @if($category->status==0) selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label form-control-label">@lang('Is show on home page') <span class="text-danger">*</span></label>
                            <div class="">
                                <select class="form-control" name="is_show_on_home_page" requierd >
                                    <option value="1" @if($category->is_show_on_home_page==1) selected @endif>Yes</option>
                                    <option value="0" @if($category->is_show_on_home_page==0) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="photo" class="col-form-label form-control-label">@lang('Photo') <span class="text-danger">*</span></label>
                            <div class="">
                                @if($category->photo)
                                <img src="{{ getImage('assets/images/category/'. $category->photo) }}" class="img-fluid img-responsive" width="80">
                                @endif
                                <input type="file" placeholder="@lang('Photo')" name="photo" requierd >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label form-control-label"></label>
                            <div class="">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
