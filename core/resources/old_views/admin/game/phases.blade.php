@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card b-radius--10">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                <tr>
                                    <th>@lang('Game Name')</th>
                                    <th>@lang('Start - Draw Date')</th>
                                    <th>@lang('Draw Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @forelse($phases as $phase)
                                    @if($phase->game->status == 1)
                                        <tr>
                                            <td data-label="@lang('Game Name')">{{ $phase->game->name }}</td>
                                            <td data-label="@lang('Start - Draw Date')">{{ $phase->start_date }} <br> {{ $phase->end_date }}</td>
                                            <td data-label="@lang('Draw Status')">
                                                @if($phase->draw_status == 1)
                                                    <span
                                                        class="badge badge--success font-weight-normal">@lang('Draw Complete')</span>
                                                @elseif($phase->end_date < Carbon\Carbon::today())
                                                    <span
                                                        class="badge badge--warning font-weight-normal">@lang('Waiting For Draw')</span>
                                                @elseif($phase->draw_status == 0)
                                                    <span
                                                        class="badge badge--danger font-weight-normal">@lang('Running')</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Action')">
                                                <button type="button"
                                                        class="icon-btn btn--primary @if($phase->draw_status == 0) editBtn @endif"
                                                        @if($phase->draw_status == 0) data-game="{{ $phase->game->id }}"
                                                        data-end="{{ $phase->end_date }}"
                                                        data-start="{{ $phase->start_date }}"
                                                        data-action="{{ route('admin.phase.update',$phase->id) }}"
                                                        @endif @if($phase->draw_status == 1) disabled @endif><i
                                                        class="la la-pencil"></i></button>
                                                @if($phase->status == 1)
                                                    <button type="button" class="icon-btn btn--danger statusBtn" data-action="{{ route('admin.phase.status',$phase->id) }}"><i class="la la-eye-slash"></i></button>
                                                @else
                                                    <button type="button" class="icon-btn btn--success statusBtn" data-action="{{ route('admin.phase.status',$phase->id) }}"><i class="la la-eye"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">@lang('Phase Not Found')</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            {{ $phases->links('admin.partials.paginate') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.phase.create') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Game Phase')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('Select Phase')</label>
                                <select class="form-control" name="game_id" required>
                                    <option value=""> -- @lang('Select One') --</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Start Date')</label>
                                <input type="text" class="form-control timepicker" autocomplete="off"
                                       placeholder="Start Date" name="start" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Draw Date')</label>
                                <input type="text" class="form-control timepicker" autocomplete="off"
                                       placeholder="Draw Date" name="end" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary">@lang('Create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Phase')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('Start Date')</label>
                                <input type="text" class="form-control timepicker" autocomplete="off"
                                       placeholder="Start Date" name="start" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Draw Date')</label>
                                <input type="text" class="form-control timepicker" autocomplete="off"
                                       placeholder="Draw Date" name="end" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="statusModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Status')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3>@lang('Are you sure to change status?')</h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@push('breadcrumb-plugins')
    <button class="icon-btn btn--primary" data-toggle="modal" data-target="#exampleModal"><i
            class="fa fa-plus"></i> @lang('Create Game Phase')</button>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/datepicker.min.css') }}">
@endpush
@push('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/datepicker.en.js') }}"></script>
    <script>
        // Create start date
        var start = new Date(),
            prevDay,
            startHours = 12;
        // 012:00 AM
        start.setHours(12);
        start.setMinutes(0);
        // If today is Saturday or Sunday set 10:00 AM
        if ([6, 0].indexOf(start.getDay()) != -1) {
            start.setHours(12);
            startHours = 12
        }
        $('.timepicker').datepicker({
            timepicker: true,
            language: 'en',
            startDate: start,
            minHours: startHours,
            maxHours: 24,
            dateFormat: 'yyyy-mm-dd',
            onSelect: function (fd, d, picker) {
                // Do nothing if selection was cleared
                if (!d) return;
                var day = d.getDay();
                // Trigger only if date is changed
                if (prevDay != undefined && prevDay == day) return;
                prevDay = day;
                // If chosen day is Saturday or Sunday when set
                // hour value for weekends, else restore defaults
                if (day == 6 || day == 0) {
                    picker.update({
                        minHours: 24,
                        maxHours: 24
                    })
                } else {
                    picker.update({
                        minHours: 24,
                        maxHours: 24
                    })
                }
            }
        })
    </script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('.retryBtn').on('click', function () {
                var modal = $('#retyModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });
            $('input[type=number]').on('keydown', function (e) {
                var keys = [189, 109];
                var keyCode = e.keyCode;
                return stopInput(keyCode, keys);
            });

            $('.editBtn').click(function () {
                var modal = $('#editModal');
                modal.find('input[name=end]').val($(this).data('end'));
                modal.find('input[name=start]').val($(this).data('start'));
                modal.find('input[name=quantity]').val($(this).data('quantity'));
                modal.find('select[name=draw_type]').val($(this).data('draw_type'));
                modal.find('form').attr('action', $(this).data('action'));
                modal.modal('show');
            });

            $('.statusBtn').click(function () {
                var modal = $('#statusModal');
                modal.find('form').attr('action', $(this).data('action'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
