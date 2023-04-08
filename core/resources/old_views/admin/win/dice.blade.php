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
						<strong>@lang('Win Dice'): </strong><strong class="winBall"></strong>
        			</li>
        			<li class="list-group-item">
						<strong>@lang('Total Win Bonus Amount'): </strong><strong class="winBonAmo"></strong>
        			</li>
        		</ul>
        	</div>
        	<div class="card-footer">
        		<form action="{{ route('admin.win.winnerDice') }}" method="post">
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
    			<div class="allDice">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-6 dices iden1" id="dc1">
                            <div class="p-t-25 p-b-25 c-point">
                                <img src="{{ asset('assets/user/images/dices/dice1.png') }}" class="w-100">
                                <input type="hidden" name="dice" value="1">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-6 dices iden2" id="dc2">
                            <div class="p-t-25 p-b-25 c-point">
                                <img src="{{ asset('assets/user/images/dices/dice2.png') }}" class="w-100">
                                <input type="hidden" name="dice" value="2">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-6 dices iden3" id="dc3">
                            <div class="p-t-25 p-b-25 c-point">
                                <img src="{{ asset('assets/user/images/dices/dice3.png') }}" class="w-100">
                                <input type="hidden" name="dice" value="3">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-6 dices iden4" id="dc4">
                            <div class="p-t-25 p-b-25 c-point">
                                <img src="{{ asset('assets/user/images/dices/dice4.png') }}" class="w-100">
                                <input type="hidden" name="dice" value="4">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-6 dices iden5" id="dc5">
                            <div class="p-t-25 p-b-25 c-point">
                                <img src="{{ asset('assets/user/images/dices/dice5.png') }}" class="w-100">
                                <input type="hidden" name="dice" value="5">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-6 dices iden6" id="dc6">
                            <div class="p-t-25 p-b-25 c-point">
                                <img src="{{ asset('assets/user/images/dices/dice6.png') }}" class="w-100">
                                <input type="hidden" name="dice" value="6">
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
		var url = '{{ route('admin.win.amoCalDice') }}';
	    var type = 'post';
	    var data = {number:winBall,phase_id:{{$phase->id}} };
	    var response = ajaxPost(data,url,type);
	    $.when(response).done(function(res){
	    	$('.winBonAmo').html(`${ res * {{ $phase->game->win_bonus / 100 }} } {{ $general->cur_text }}`)
	    });
	});

</script>
@endpush
