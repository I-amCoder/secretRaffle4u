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
						<strong>@lang('Win Number'): </strong><strong class="winBall"></strong>
        			</li>
        			<li class="list-group-item">
						<strong>@lang('Total Win Bonus Amount'): </strong><strong class="winBonAmo"></strong>
        			</li>
        		</ul>
        	</div>
        	<div class="card-footer">
        		<form action="{{ route('admin.win.winnerRoul') }}" method="post">
        			@csrf
        			<input type="hidden" name="phase_id" value="{{ $phase->id }}">
        			<input type="hidden" name="win">
        			<button type="submit" class="btn btn--primary w-100">@lang('Draw Now')</button>
        		</form>
        	</div>
        </div>
    </div>
    <div class="col-lg-8">
    	<div class="card border--success neom-card">
          <div class="card-header bg--success">
            <h4 class="text-white">@lang('Select Win Item')</h4>
          </div>
    		<div class="card-body">
    			<div class="allNumbers">
            <div class="numberPosRot text-center">
              @for($i = 1; $i < 37; $i++)
              <button class="btn btn-lg mt-2 ml-2 numbers srl{{ $i }}">{{ $i }}</button>
              @endfor
            </div>
          </div>
    		</div>
    	</div>
    </div>
</div>
@endsection
@push('style')
<style type="text/css">
	.list-group{
		font-size:25px;
		text-align: center;
	}
  .neom-card{
    background: #e0e5ec;
  }
  .numberPosRot button {
      background: transparent;
      border: none;
      color: #000;
      box-shadow: -4px -4px 4px #fff, 4px 4px 4px #a3b1c6;
      font-size: 20px;
      font-weight: bolder;
  }
  .numberPosRot button:focus {
      box-shadow: -4px -4px 4px #fff, 4px 4px 4px #a3b1c6 !important;
  }
  .numberPosRot button:active{
     box-shadow: inset -4px -4px 4px #fff, inset 4px 4px 4px #a3b1c6 !important;
  }
</style>
@endpush
@push('script')
<script type="text/javascript">
	$('.numbers').click(function(){
		var winBall = $(this).text();
		$('.winBall').html(winBall);
		$('input[name=win]').val(winBall);
		var url = '{{ route('admin.win.amoCalRoul') }}';
	    var type = 'post';
	    var data = {id:{{ $phase->id }},number:winBall };
	    var response = ajaxPost(data,url,type);
	    $.when(response).done(function(res){
        $('.winBonAmo').html(`${res} {{ $general->cur_text }}`);
	    });
	});

</script>
@endpush
