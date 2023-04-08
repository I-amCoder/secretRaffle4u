@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-4">
        <div class="card border--primary">
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
						<strong>@lang('Win Card'): </strong><strong class="winBall"></strong>
        			</li>
        			<li class="list-group-item">
						<strong>@lang('Total Win Bonus Amount'): </strong><strong class="winBonAmo"></strong>
        			</li>
        		</ul>
        	</div>
        	<div class="card-footer">
        		<form action="{{ route('admin.win.winnerCard') }}" method="post">
        			@csrf
        			<input type="hidden" name="phase_id" value="{{ $phase->id }}">
        			<input type="hidden" name="win">
        			<button type="submit" class="btn btn--primary w-100">@lang('Draw Now')</button>
        		</form>
        	</div>
        </div>
    </div>
    <div class="col-lg-8">
    	<div class="card border--success">
            <div class="card-header bg--success">
                <h4 class="text-white">@lang('Select Win Item')</h4>
            </div>
    		<div class="card-body">
    			<div class="allcard">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-6 col-6">
                            <div class="card neom-card p-4 img1" id="notify1">
                                <img src="{{ asset('assets/user/images/cards/27.png') }}" class="w-100">
                                <input type="hidden" name="card" value="Red">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-6">
                            <div class="card neom-card p-4 img2" id="notify2">
                                <img src="{{ asset('assets/user/images/cards/40.png') }}" class="w-100">
                                <input type="hidden" name="card" value="Black">
                            </div>
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
		var winBall = $(this).parent().find('input').val();
        $('img').removeClass('op');
        $(this).addClass('op');
		$('.winBall').html(winBall);
		$('input[name=win]').val(winBall);
		var url = '{{ route('admin.win.calCard') }}';
	    var type = 'post';
	    var data = {number:winBall,phase_id:{{$phase->id}} };
	    var response = ajaxPost(data,url,type);
	    $.when(response).done(function(res){
	    	$('.winBonAmo').html(`${ res * {{ $phase->game->win_bonus / 100 }} } {{ $general->cur_text }}`)
	    });
	});

</script>
@endpush
