@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.game.update',$numberbuy->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview"
                                                     style="background-image: url({{ getImage('assets/images/game/'.$numberbuy->image) }})">
                                                    <button type="button" class="remove-image"><i
                                                            class="fa fa-times"></i></button>
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
                                    <label>@lang('Status')</label>
                                    <input type="checkbox" data-width="100%" data--onstyle="success"
                                           data--offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Dactive" data-width="100%"
                                           name="status" @if($numberbuy->status == 1) checked @endif>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Win Bonus')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="Win Bonus"
                                               name="win_bonus" value="{{ $numberbuy->win_bonus }}" requierd/>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Minimum Invest Limit')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Minimum Invest Limit"
                                               name="min_limit" value="{{ getAmount($numberbuy->min_limit) }}"
                                               requierd/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"
                                                  id="basic-addon2">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Maximum Invest Limit')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Maximum Invest Limit"
                                               name="max_limit" value="{{ getAmount($numberbuy->max_limit) }}"
                                               requierd/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"
                                                  id="basic-addon2">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>@lang('Game Name')</label>
                                    <input type="text" class="form-control" placeholder="Game Name" name="title"
                                           value="{{ $numberbuy->name }}" requierd/>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Game Instruction')</label>
                                    <textarea rows="10" class="form-control nicEdit" name="instruction"
                                              requierd>@php echo $numberbuy->instruction @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Post')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('input[type=number]').on('keydown', function (e) {
                var keys = [189, 109];
                var keyCode = e.keyCode;
                return stopInput(keyCode, keys);
            });
        })(jQuery);
    </script>
@endpush
