@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-10">
        

        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">


            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('Level Par Edit') </h5>

                    <form action="{{route('admin.levelpar.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Level1 Par')<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="l1par" value="{{$user->l1par}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Level2 Par') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="l2par" value="{{$user->l2par}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Level3 Par') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="l3par" value="{{$user->l3par}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Level4 Par') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="l4par" value="{{$user->l4par}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Level5 Par') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="l5par" value="{{$user->l5par}}">
                                </div>
                            </div>
                        </div>


                      


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection
