@extends('admin.layouts.app')
@section('panel')
@php
$roman = ['I','II','III','IV','V','VI','VII','VIII','IX','X'];
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
				@isset($scratch_games)
				<div class="form-group" style="width: 250px; margin: 15px auto; text-align: center;">
					<label for="scratch_games">Select Scratch Game</label>
					<select class="form-control" id="scratch_games" onchange="scratch_games_dropdown();">
						<option value="">Select Game</option>
						@foreach($scratch_games as $key => $item)
						<option {{ (isset($id) && $id == $item->id)?'selected':'' }} value="{{ $item->id }}">{{ $item->title }}</option>
						@endforeach
					</select>
				</div>
				@endisset
				@isset($id)
                <div class="table-responsive--sm table-responsive">
					<a href="{{ route('admin.paytable.edit', ['id' => $id]) }}"  class="icon-btn mb-2 mr-2 editBtn float-right"><i class="la la-edit"></i> Edit Paytable</a>
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('SL')</th>
                                <th>@lang('Game')</th>
                                <th>@lang('Tier')</th>
                                <th>@lang('Prize')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('First Count')</th>
                                <th>@lang('Reset Count')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($raffles) && count($raffles) >0)
                            @foreach ($raffles as $key=>$row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->scratch->title }}</td>
                                <td>{{ ($roman[$row->tier-1]) }}</td>
                                <td>{{ $row->prize }}x</td>
                                <td>{{ ($row->amount > 0)?'$'.number_format($row->amount,2):'Free Play' }}</td>
								<td>{{ $row->first_count }}</td>
								<td>{{ $row->reset_count }}</td>
                                <td>
                                    {{--  <a href="{{ route('admin.scratch.edit', [$row->id]) }}"  class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip"><i class="la la-edit"></i></a>  --}}
                                    
                                    
                                    <a 
                                        href="{{ route('admin.paytable.delete', [$row->id]) }}"  
                                        class="icon-btn ml-1 editBtn" 
                                        data-original-title="Delete" 
                                        data-toggle="tooltip"
                                        style="background: red;"
                                        onclick="return confirm('Are you sure?');"
                                    >
                                        <i class="la la-remove"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                </table><!-- table end -->
            </div>
			@endisset
        </div>
		@isset($id)
        <div class="card-footer py-4">
            {{ paginateLinks($raffles) }}
        </div>
		@endisset
    </div><!-- card end -->
</div>
</div>
<script>
function scratch_games_dropdown(){
	var scratch_games = $('#scratch_games').val();
	var url = "{{route('admin.paytable.index',['id' => ':scratch_games'])}}";
	url = url.replace(':scratch_games', scratch_games);
	location.assign(url);
}
</script>
@endsection