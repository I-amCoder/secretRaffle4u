@extends('admin.layouts.app')

@section('panel')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<style>
.paginate_button {
    padding: 5px 10px;
    margin: 0 2px;
    border: 1px solid #544ea5;
    min-width: 50px !important;
    cursor: pointer;
    background: #544fa5a3;
    color: #fff !important;
    border-radius: 4px;
}
</style>
@php
$helpers = new \App\Lib\Helper();
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
				<div style="width: 350px; margin: 15px auto 0;">
					<form action="" method="GET" id="form-raffle-winners">
						<div class="form-group">
							<select class="form-control" name="game_id" onchange="this.form.submit()">
								<option value="">Select Raffle Game</option>
								@foreach($raffles as $key => $item)
								<option value="{{ $item->id }}">{{ $item->title }}</option>
								@endforeach
							</select>
						</div>
					</form>
				</div>
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two" id="winners-table">
                        <thead>
                            <tr>
                                <th>@lang('No.')</th>
                                <th>@lang('Winning Position')</th>
                                <th>@lang('Full Name')</th>
                                <th>@lang('Ticket Code')</th>
                                <th>@lang('Prize')</th>
                            </tr>
                        </thead>
                        <tbody>
							@if(!empty($raffle_winners))
								@foreach($raffle_winners as $rkey => $ritem)
                            <tr>
								<td>{{ $rkey+1 }}</td>
								<td>{{ $ritem->winning_position }}</td>
								<td>{{ $ritem->firstname.' '.$ritem->lastname }}</td>
								<td>{{ $ritem->ticket_code }}</td>
								<td>฿{{ number_format($ritem->winning_price,2) }}</td>
                            </tr>
							@endforeach
							@endif
                        </tbody>
                </table><!-- table end -->
            </div>
        </div>
        <div class="card-footer py-4">
        </div>
    </div><!-- card end -->
</div>
</div>
<script>
$(document).ready(function () {
    $('#winners-table').DataTable();
});
</script>
@endsection

@push('breadcrumb-plugins')
@if(request()->routeIs('admin.users.transactions'))
<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@else
<form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endif
@endpush


