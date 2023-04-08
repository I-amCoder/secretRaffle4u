@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-4">
        <div class="card outline-warning border--primary">
            <div class="card-header bg--primary">
                <h4 class="text-white">@lang('Calculation')</h4>
            </div>
        	<div class="card-body">
        		<ul class="list-group">
        			<li class="list-group-item">
	        			<strong>@lang('Total Bid'): {{ @$phase->bids->count() }}</strong>
	        		</li>
        			<li class="list-group-item">
						<strong>@lang('Total Invest'): {{ @$phase->bids->sum('invest') }} {{ $general->cur_text }}</strong>
        			</li>
        			<li class="list-group-item">
						<strong>@lang('Win Bonus'): {{ @$phase->game->win_bonus }} %</strong>
        			</li>
        			<li class="list-group-item">
						<strong>@lang('Win Ball'): </strong><strong class="winBall"></strong>
        			</li>
        			<li class="list-group-item">
						<strong>@lang('Total Win Bonus Amount'): </strong><strong class="winBonAmo"></strong>
        			</li>
        		</ul>
        	</div>
        	<div class="card-footer">
        		<form action="{{ route('admin.win.makeDraw') }}" method="post">
        			@csrf
        			<input type="hidden" name="phase_id" value="{{ $phase->id }}">
        			<input type="hidden" name="win">
        			<button type="submit" class="btn btn--primary w-100">@lang('Draw Now')</button>
        		</form>
        	</div>
        </div>
    </div>
    <div class="col-lg-8">
    	<div class="card outline-success border--success">
            <div class="card-header bg--success">
                <h4 class="text-white">@lang('Select Win Item')</h4>
            </div>
    		<div class="card-body">
    			<div class="allpool">
    				<div class="row">
    					<div class="col-md-3 col-sm-3 col-6 iden1 mb-2" id="pool1">
    						<img src="{{ asset('assets/user/images/poolBall/01.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="1">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6 iden2 mb-2" id="pool2">
    						<img src="{{ asset('assets/user/images/poolBall/02.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="2">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6 iden3 mb-2" id="pool3">
    						<img src="{{ asset('assets/user/images/poolBall/03.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="3">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6 iden4 mb-2" id="pool4">
    						<img src="{{ asset('assets/user/images/poolBall/04.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="4">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6 iden5 mb-2" id="pool5">
    						<img src="{{ asset('assets/user/images/poolBall/05.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="5">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6 iden6 mb-2" id="pool6">
    						<img src="{{ asset('assets/user/images/poolBall/06.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="6">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6iden7 mb-2" id="pool7">
    						<img src="{{ asset('assets/user/images/poolBall/07.png') }}" class="w-100 ball7">
    						<input type="hidden" name="pool" value="7">
    					</div>
    					<div class="col-md-3 col-sm-3 col-6 iden8 mb-2" id="pool8">
    						<img src="{{ asset('assets/user/images/poolBall/08.png') }}" class="w-100">
    						<input type="hidden" name="pool" value="8">
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection
@push('style')
<style type="text/css">
	img{
		cursor: pointer;
	}
	.list-group{
		font-size:25px;
		text-align: center;
	}
    .op{
        opacity: 0.5;
    }
</style>
@endpush
@push('script')
<script type="text/javascript">
	$('img').click(function(){
        $('img').removeClass('op');
        $(this).addClass('op');
		var winBall = $(this).parent().find('input').val();
		$('.winBall').html(winBall);
		$('input[name=win]').val(winBall);
		var url = '{{ route('admin.win.amoCalPool') }}';
	    var type = 'post';
	    var data = {number:winBall,phase_id:{{ $phase->id }} };
	    var response = ajaxPost(data,url,type);
	    $.when(response).done(function(res){
	    	$('.winBonAmo').html(`${ res * {{ $phase->game->win_bonus / 100 }} } {{ $general->cur_text }}`)
	    });
	});

</script>
@endpush
