@extends('admin.layouts.app')
@push('style')
{{-- <link rel="stylesheet" href="{{asset('assets/admin/Date-Time-Picker-Bootstrap-4/css/bootstrap-datetimepicker.min.css')}}"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/css/bootstrap-datetimepicker.css">
@endpush
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('admin.scratch.update', $raffle->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">


                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('assets/images/game/'. $raffle->photo) }})">
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

                                

                                {{--  <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('assets/images/game/'. $raffle->banner) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload33" name="banner"
                                                       id="profilePicUpload133" accept=".png, .jpg, .jpeg" requierd style="opacity: 0;">
                                                <label for="profilePicUpload133"
                                                       class="bg--primary">@lang('Banner image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('png,
                                                        jpeg, jpg')</b>. 

                                                        {{-- 
                                                            @lang('Image will be resized into')
                                                            <b>{{ imagePath()['game']['size'] }}px</b>
                                                        --}}
                                                {{--  </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>   --}}



                                <div class="form-group">
                                    <label>@lang('Category')<span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="category_id" requierd>
                                            @if(isset($category) && count($category) > 0)
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}" @if($raffle->category_id== $item->id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-8">
                                
                                <div class="form-group">
                                    <label>Main Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="title"
                                           value="{{ $raffle->title }}" requierd/>
                                </div>


                                <div class="form-group">
                                    <label>@lang('Price')<span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="unit_price" class="form-control" placeholder="Unit price" value="{{ $raffle->unit_price }}" requierd >
                                </div>

                                <div class="form-group">
                                    <label>@lang('Availabe tickets')<span class="text-danger">*</span></label>
                                    <input type="number" name="total_tickets" class="form-control" placeholder="Total tickets" value="{{ $raffle->total_tickets }}" requierd >
                                </div>

                                {{--  <div class="form-group">
                                    <label>@lang('Min tickets')<span class="text-danger">*</span></label>
                                    <input type="number" name="min_tickets" class="form-control" placeholder="Min tickets" value="{{ $raffle->min_tickets }}" requierd >
                                </div>

                                <div class="form-group">
                                    <label>@lang('Start time')<span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="start_time" class="form-control" id="start_time" placeholder="DD/MM/YYYY" value="{{ $raffle->start_time }}" requierd >
                                </div>




                                <div class="form-group">
                                    <label>@lang('End time')<span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="end_time" class="form-control" id="end_time" placeholder="DD/MM/YYYY" value="{{ $raffle->end_time }}" requierd >
                                </div>  --}}




                               




                                

                                



                                <div class="form-group">
                                    <label>@lang('Status')<span class="text-danger">*</span></label>
                                    <input type="checkbox" data-width="100%" data-toggle="toggle" data-onstyle="-success"
                                           data-offstyle="-danger" data-on="Active" data-off="Deactive" data-width="100%"
                                           name="status" @if($raffle->status == 1) checked @endif>
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
@push('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}
{{-- <script src="{{asset('assets/admin/js/moment.js')}}"></script> --}}
{{-- <script src="{{asset('assets/admin/Date-Time-Picker-Bootstrap-4/js/bootstrap-datetimepicker.min.js')}}"></script> --}}
<script>
    // $(function(){
    //     $('#datetimepicker1').datetimepicker();
    //     $('#start_time').datetimepicker({
    //  });
    //     $('#end_time').datetimepicker({
    //  });
    // });

</script>
<script type="text/javascript">

    howHideFreeTicket({{ $raffle->free_ticket==1 ?? 0}});
    $(document).on('change','#free_ticket',function(e){
        var abc = $(this).val();
        howHideFreeTicket(abc);
    })

    function howHideFreeTicket(id) {
        if(id == '1'){
            $('.free_tickets_div').show();
        }else{
            $('.free_tickets_div').hide();
        }

    }

    (function ($) {
        "use strict";
        $('input[type=number]').on('keydown', function (e) {
            var keys = [189, 109];
            var keyCode = e.keyCode;
            return stopInput(keyCode, keys);
        });
    })(jQuery);






    $(document).on('click','.info_close', function(e){
        $(this).closest("tr").remove();
    })

    $(document).on('click','.raffle_info_more', function(e){
        var html = '<tr><td><input type="text" name="game_info[]" class="form-control" requierd ></td><th><button type="button" class="btn btn-outline-danger info_close">X</button></th></tr>';

        $('.raffle_info tbody').append(html);
    })







    $(document).on('click','.rule_close', function(e){
        $(this).closest("tr").remove();
    })

    $(document).on('click','.raffle_rule_more', function(e){
        var html = '<tr><td><input type="text" name="game_rule[]" class="form-control" requierd ></td><th><button type="button" class="btn btn-outline-danger info_close">X</button></th></tr>';

        $('.raffle_rule tbody').append(html);
    })


</script>
@endpush
