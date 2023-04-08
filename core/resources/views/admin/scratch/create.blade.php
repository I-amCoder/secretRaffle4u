@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.scratch.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image"
                                                       id="profilePicUpload1" accept=".png, .jpg, .jpeg" requierd>
                                                <label for="profilePicUpload1"
                                                       class="bg--primary">@lang('Post image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('png,
                                                        jpeg, jpg')</b>. @lang('Image will be resized into')
                                                    <b>{{ imagePath()['game']['size'] }}px</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Category')<span>*</span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="category_id" requierd>
                                            @if(isset($category) && count($category) > 0)
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                               
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>@lang('Name')<span>*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="title"
                                           value="{{ old('title') }}" requierd/>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Price')<span>*</span></label>
                                    <input type="number" name="unit_price" class="form-control" placeholder="Unit price" value="{{ old('unit_price') }}" requierd  >
                                </div>
                                <div class="form-group">
                                    <label>@lang('Availabe tickets')<span class="text-danger">*</span></label>
                                    <input type="number" name="total_tickets" class="form-control" placeholder="Total tickets" value="{{ old('total_tickets') }}" requierd >
                                </div>

                                
                                <div class="form-group">
                                    <label>@lang('Status')<span>*</span></label>
                                    <input type="checkbox" data-width="100%" data-toggle="toggle" data-onstyle="-success"
                                           data-offstyle="-danger" data-on="Active" data-off="Deactive" data-width="100%"
                                           name="status" checked>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
