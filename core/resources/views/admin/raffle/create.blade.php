@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.raffle.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="">
                                                    <button type="button" class="remove-image"><i
                                                            class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image"
                                                    id="profilePicUpload1" accept=".png, .jpg, .jpeg" requierd>
                                                <label for="profilePicUpload1" class="bg--primary">@lang('Post image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'):
                                                    <b>@lang('png,
                                                                                                                                                                                                                                                                                                                                                                                                                                    jpeg, jpg')</b>. @lang('Image will be resized into')
                                                    <b>{{ imagePath()['game']['size'] }}px</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Category')<span>*</span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="category_id" requierd id="category_id">
                                            <option value="">@lang('Select Category')</option>
                                            @if (isset($category) && count($category) > 0)
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}" data-tickets="{{ $item->tickets }}"
                                                        data-tickets_show="{{ number_format($item->tickets) }}">
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="free_ticket" value="1" />
                                <input type="hidden" name="free_tickets[]" value="" />
                                {{--
                                <div class="form-group">
                                    <label>@lang('Has Free Ticket')<span>*</span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="free_ticket" requierd id="free_ticket">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group free_tickets_div">
                                    <label>@lang('Free Ticket')<span>*</span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2-multi-select" name="free_tickets[]" requierd multiple>
                                            @if (isset($free_ticket) && count($free_ticket) > 0)
                                            @foreach ($free_ticket as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
--}}
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>@lang('Name')<span>*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="title"
                                        value="{{ old('title') }}" requierd />
                                </div>

                                <div class="form-group">
                                    <label>@lang('Price')<span>*</span></label>
                                    <input type="number" name="unit_price" class="form-control" placeholder="Unit price"
                                        value="{{ old('unit_price') }}" requierd>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Total tickets')<span>*</span></label>
                                    <input type="text" class="form-control" placeholder="Total tickets" value="0"
                                        id="total_tickets_show" disabled />
                                    <input type="hidden" id="total_tickets" name="total_tickets"
                                        value="{{ old('total_tickets') }}" requierd />
                                </div>

                                <div class="form-group">
                                    <label>@lang('Min tickets')<span>*</span></label>
                                    <input type="number" name="min_tickets" class="form-control" placeholder="Min tickets"
                                        value="{{ old('min_tickets') }}" requierd>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Start time')<span>*</span></label>
                                    <input type="datetime-local" name="start_time" class="form-control"
                                        placeholder="Start time" value="{{ old('start_time') }}" requierd>
                                </div>

                                <div class="form-group">
                                    <label>@lang('End time')<span>*</span></label>
                                    <input type="datetime-local" name="end_time" class="form-control" placeholder="End time"
                                        value="{{ old('end_time') }}" requierd>
                                </div>



                                <div class="form-group">
                                    <label>@lang('Raffle Draw Info')<span class="text-danger">*</span>
                                        <button type="button" class="btn btn-sm btn-outline-info raffle_info_more">Add
                                            More</button>
                                    </label>
                                    <div class="table">
                                        <table class="table raffle_info">
                                            <thead>
                                                <tr>
                                                    <th>Raffle Draw Info</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="game_info[]" class="form-control"
                                                            requierd>
                                                    </td>
                                                    <th>
                                                        <button type="button"
                                                            class="btn btn-outline-danger info_close">X</button>
                                                    </th>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Raffle Draw Rules')<span class="text-danger">*</span>
                                    </label>
                                    <div class="table">
                                        <table class="table raffle_rule">
                                            <thead>
                                                <tr>
                                                    <th>Raffle Draw Rules</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>
                                                        <input type="text" name="game_rules[]" class="form-control">
                                                    </td>
                                                    <th>
                                                        <button type="button"
                                                            class="btn btn-outline-danger rule_close">X</button>
                                                    </th>
                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-info raffle_rule_more">Add
                                        More</button>

                                </div>
                                <div class="form-group">
                                    <label>@lang('Status')<span>*</span></label>
                                    <input type="checkbox" data-width="100%" data-toggle="toggle"
                                        data-onstyle="-success" data-offstyle="-danger" data-on="Active"
                                        data-off="Deactive" data-width="100%" name="status" checked>
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
    <script type="text/javascript">
        $(document).on('click', '.rule_close', function(e) {
            $(this).closest("tr").remove();
        })

        $(document).on('click', '.raffle_rule_more', function(e) {
            var html =
                '<tr><td><input type="text" name="game_rules[]" class="form-control" requierd ></td><th><button type="button" class="btn btn-outline-danger info_close">X</button></th></tr>';

            $('.raffle_rule tbody').append(html);
        })
        howHideFreeTicket(0);
        $(document).on('change', '#free_ticket', function(e) {
            var abc = $(this).val();
            howHideFreeTicket(abc);
        })

        function howHideFreeTicket(id) {
            if (id == '1') {
                $('.free_tickets_div').show();
            } else {
                $('.free_tickets_div').hide();
            }
        }
        (function($) {
            "use strict";
            $('input[type=number]').on('keydown', function(e) {
                var keys = [189, 109];
                var keyCode = e.keyCode;
                return stopInput(keyCode, keys);
            });
        })(jQuery);


        $(document).on('click', '.info_close', function(e) {
            $(this).closest("tr").remove();
        })

        $(document).on('click', '.raffle_info_more', function(e) {
            var html =
                '<tr><td><input type="text" name="game_info[]" class="form-control" requierd ></td><th><button type="button" class="btn btn-outline-danger info_close">X</button></th></tr>';

            $('.raffle_info tbody').append(html);
        });
        $(document).on('change', '#category_id', function() {
            var $this = $(this);
            var total_tickets = $this.find(':selected').data('tickets')
            var total_tickets_show = $this.find(':selected').data('tickets_show')
            $('#total_tickets_show').val(total_tickets_show);
            $('#total_tickets').val(total_tickets);
            // console.log(total_tickets_show);
        });
    </script>
@endpush
