@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>@lang('Win Bonuses')</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>

                                <th>@lang('Position')</th>
                                <th>@lang('Win Bonus')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i < count(json_decode($nintynine->win_bonus)->level); $i++)
                                <tr>
                                    <td>@lang('Position')# {{ json_decode($nintynine->win_bonus)->level[$i] }}</td>
                                    <td>{{ json_decode($nintynine->win_bonus)->percent[$i] }} %</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('CHANGE SETTING')</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" name="level" id="levelGenerate"
                                   placeholder="@lang('HOW MANY NUMBER WILL SELECT')" class="form-control input-lg">
                        </div>
                        <div class="col-md-6">

                            <button type="button" id="generate"
                                    class="btn btn--success btn-block btn-md">@lang('GENERATE')</button>
                        </div>
                    </div>

                    <br>

                    <form action="{{ route('admin.nintyninegame.update',$nintynine->id) }}" id="prantoForm"
                          style="display: none" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text-success"> @lang('Level & Bonus') :
                                <small>(@lang('Old Levels will Remove After Generate')</small> </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="description"
                                         style="width: 100%;border: 1px solid #ddd;padding: 10px;border-radius: 5px">
                                        <div class="row">
                                            <div class="col-md-12" id="planDescriptionContainer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.game.update',$nintynine->id) }}" method="POST"
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
                                                     style="background-image: url({{ getImage('assets/images/game/'.$nintynine->image) }})">
                                                    <button type="button" class="remove-image"><i
                                                            class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image"
                                                       id="profilePicUpload1" accept=".png, .jpg, .jpeg" requierd>
                                                <label for="profilePicUpload1" class="bg--primary">Post image</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>png,
                                                        jpeg, jpg</b>. @lang('Image will be resized into')
                                                    <b>{{ imagePath()['game']['size'] }}px</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Status')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success"
                                           data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Deactive" data-width="100%"
                                           name="status" @if($nintynine->status == 1) checked @endif>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Minimum Invest Limit')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Minimum Invest Limit"
                                               name="min_limit" value="{{ getAmount($nintynine->min_limit) }}"
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
                                               name="max_limit" value="{{ getAmount($nintynine->max_limit) }}"
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
                                           value="{{ $nintynine->name }}" requierd/>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Game Instruction')</label>
                                    <textarea rows="10" class="form-control nicEdit" name="instruction"
                                              requierd>@php echo $nintynine->instruction @endphp</textarea>
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
    <script>
        var max = 1;
        $(document).ready(function () {
            $("#generate").on('click', function () {

                var da = $('#levelGenerate').val();
                var a = 0;
                var val = 1;
                var guu = '';
                if (da !== '' && da > 0) {
                    $('#prantoForm').css('display', 'block');

                    for (a; a < parseInt(da); a++) {

                        console.log()

                        guu += '<div class="input-group" style="margin-top: 5px">\n' +
                            '<input name="level[]" class="form-control margin-top-10" type="number" readonly value="' + val++ + '" required placeholder="Level">\n' +
                            '<input name="percent[]" class="form-control margin-top-10" type="text" required placeholder="Percentage of Win Bonus">\n' +
                            '<span class="input-group-btn">\n' +
                            '<button class="btn btn-danger margin-top-10 delete_desc" type="button"><i class=\'fa fa-times\'></i></button></span>\n' +
                            '</div>'
                    }
                    $('#planDescriptionContainer').html(guu);

                } else {
                    alert('Level Field Is Required')
                }

            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').remove();
            });
        });

    </script>
@endpush
