@extends('admin.layouts.app')
@section('panel')
@php
$roman = ['I','II','III','IV','V','VI','VII','VIII','IX','X'];
@endphp
<style>
.red-border{
	border:1px solid red !important;
}
</style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.paytable.update',['id'=> $paytables[0]->scratch_id]) }}" method="POST" enctype="multipart/form-data" id="paytable-form">
                    @csrf
					<input type="hidden" name="scratch_id" value="{{ $paytables[0]->scratch_id }}" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Category')<span>*</span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="scratch_id" requierd disabled>
											<option value="">Select Game</option>
                                            @if(isset($category) && count($category) > 0)
                                            @foreach ($category as $item)
                                                <option {{ (isset($paytables) && $paytables[0]->scratch_id == $item->id)?'selected':'' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="col-md-1">
                                <div class="form-group">
                                    <label><b>@lang('Tiers')</b></label>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label><b>@lang('Prize Available')<span>*</span></b></label>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label><b>@lang('Amount')<span>*</span></b></label>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label><b>@lang('Box Image')<span>*</span></b></label>
                                </div>
                            </div>
							{{--<div class="col-md-2">
                                <div class="form-group">
                                    <label><b>@lang('First Count')<span>*</span></b></label>
                                </div>
                            </div>--}}
							<div class="col-md-2">
                                <div class="form-group">
                                    <label><b>@lang('Every * Game')<span>*</span></b></label>
                                </div>
                            </div>
						</div>
						@for($i=0; $i<=9; $i++)
						<input type="hidden" name="paytable[{{$i}}][tier]" value="{{$i+1}}" />
						<div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>@lang('Tier') {{ $roman[$i] }}</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
									@if($i==9)
									<input type="text" class="form-control" value="Free Play" disabled />
									<input type="hidden" name="paytable[{{$i}}][prize]" value="0" />
									@else
                                    <input type="number" min="0" step="1" name="paytable[{{$i}}][prize]" class="form-control paytable-prize-input" placeholder="Prize Available" value="{{ $paytables[$i]->prize }}" requierd  >
									@endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
									@if($i==9)
									<input type="text" class="form-control" value="Free Play" disabled />
									<input type="hidden" name="paytable[{{$i}}][amount]" value="0" />
									@else
                                    <input type="number" min="0" step="1" name="paytable[{{$i}}][amount]" class="form-control paytable-amount-input" placeholder="amount" value="{{ $paytables[$i]->amount }}" requierd  />
									@endif
                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="file" name="paytable[{{$i}}][image]" class="form-control" placeholder="Prize Available" value="{{ old('image') }}" requierd  >
                                </div>
                            </div>
                            {{--<div class="col-md-2">
                                <div class="form-group">
									@if($i==9)
									<input type="text" class="form-control" value="Free Play" disabled />
									<input type="hidden" name="paytable[{{$i}}][first_count]" value="0" />
									@else
                                    <input type="number" min="0" step="1" name="paytable[{{$i}}][first_count]" class="form-control paytable-prize-input" placeholder="First Count" value="{{ $paytables[$i]->first_count }}" requierd  >
									@endif
                                </div>
                            </div>--}}
                            <div class="col-md-2">
                                <div class="form-group">
									@if($i==9)
									<input type="text" class="form-control" value="Free Play" disabled />
									<input type="hidden" name="paytable[{{$i}}][reset_count]" value="0" />
									@else
                                    <input type="number" min="0" step="1" name="paytable[{{$i}}][reset_count]" class="form-control paytable-prize-input" placeholder="Reset Count" value="{{ $paytables[$i]->reset_count }}" requierd  >
									@endif
                                </div>
                            </div>
							<div class="clearfix"></div>
						</div>
						@endfor
                    </div>
                    <div class="card-footer">
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-12">
                                <button id="paytable-btn" type="button" class="btn btn-block btn--primary mr-2">@lang('Save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
$(document).on('click','#paytable-btn',function(){
	$('.form-control').removeClass('red-border');
	var previous_value = -1;
	var validate = 0;
	$('.paytable-prize-input').each(function(){
		var $prize = $(this);
		var current_prize = $prize.val();
		if(current_prize == ''){
			$prize.addClass('red-border');
			validate = 1;
			return false;
		}
	});
	$('.paytable-amount-input').each(function(){
		var $this = $(this);
		var current_value = $this.val();
		// alert(current_value);
        console.log(previous_value);
		if(parseFloat(previous_value) > 0 && parseFloat(current_value) >= parseFloat(previous_value)){
			$this.addClass('red-border');
			validate = 1;
			return false;
		}
		previous_value = current_value;
        
	});
	if(validate == 0){
		$('#paytable-form')[0].submit();
	}
});
</script>
@endsection