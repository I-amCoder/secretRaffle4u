@extends($activeTemplate.'layouts.master')
@section('content')
@php
$helpers = new \App\Lib\Helper();
$paytablerecords = $data->paytable()->get();
$game_session = Session::get('scratch-game-'.$data->id);
$roman = ['','I','II','III','IV','V','VI','VII','VIII','IX','X'];
$winner = 0;
$boxDataId = [];
$boxData = [];
$drawData = [];
$remainingData = [];
$heightest_value = 0;
$draw_values = [];
$iscount3 = false;
$winnerValue = 0;
$winnerValueIndex = 0;

foreach($paytablerecords as $key => $val){
	if($key == 0){
		$heightest_value = number_format($val->amount);
	}
	if($val->amount > 0){
		$boxData[] = intval($val->amount);
		$boxDataId[] = $val->id;
		$drawData[] = $val->draw;
		$remainingData[] = $val->prize_remaining;
		//echo "<pre>";print_r($remainingData);echo "</pre>";exit;
	}else{
		// $boxData[] = 'Free Play';
		$boxData[] = -1;
		$boxDataId[] = $val->id;
		$drawData[] = 0;
		$remainingData[] = 1000000;
	}
	if($val->draw > 0){
		$newDraw = $val->draw-1;
		DB::table('paytables')->where('id', $val->id)->update(['draw' => $newDraw]);
	}
}

/**/
for($i=0; $i<9; $i++){
	$random_number = rand(0,9);
	$box_number = $boxData[$random_number];
	
	$draw_number = $drawData[$random_number];
	$remaining_number = $remainingData[$random_number];
	$array_values_count = array_count_values($draw_values);
		if(isset($array_values_count[$box_number])){
			if(!$iscount3 && $array_values_count[$box_number] < 3 && $draw_number == 0){
				$draw_values[] = $box_number;
				$array_values_count = array_count_values($draw_values);
				if($array_values_count[$box_number] == 3){
					$winnerValue = $box_number;
					$iscount3 = true;
					// echo "<pre>";print_r($box_number.' is 3');echo "</pre>";
					
				}
			}else{
				$drawDone = true;
				while($drawDone){
					$random_number2 = rand(0,9);
					$box_number2 = $boxData[$random_number2];
					$draw_number2 = $drawData[$random_number2];
					if(isset($array_values_count[$box_number2])){
						if($array_values_count[$box_number2] < 3 && $draw_number2 == 0 && $remaining_number > 0){
							$drawDone = false;
							$draw_values[] = $box_number2;
						}
					}else{
						$drawDone = false;
						$draw_values[] = $box_number2;
					}
				}
			}
		}else{
			$draw_values[] = $box_number;
			
		}
		
		
}
/**/
/**/
if($winnerValue > 0){
	$winnerValueIndex = array_search($winnerValue, $boxData);
	Session::put('scratch-game-'.$data->id.'['.$winnerValue.']',1);
	// echo "<pre>WinnerValue: ";print_r($winnerValue);echo "</pre>";
	$remainingPrizeData = DB::table('paytables')->where('amount', $winnerValue)->first();
	//echo "<pre>";print_r($remainingPrizeData);echo "</pre>";exit;
	if($remainingPrizeData->prize_remaining > 0 ){
		$remainingPrize = $remainingPrizeData->prize_remaining-1;
		DB::table('paytables')->where('amount', $winnerValue)->update(['prize_remaining'=>$remainingPrize]);
	}
}
/**/
if($play == 'yes'){
	if($winnerValue >= 0){
		$upd = array();
		if ($winnerValue > 0) {
			$upd['winning_price'] = $winnerValue;
			//need to add wining position 
		}
		$upd['status'] = 0;
		DB::table('scratch_game_tickets')->where('id',$tickets[0]->id)->update($upd);
	}
}
/**/
$counts = array_count_values($draw_values);
// echo "<div style='color:#000;'>";
// echo "<pre>WinnerValue: ";print_r($winnerValue);echo "</pre>";
// echo "<pre>WinnerValueIndex: ";print_r($winnerValueIndex);echo "</pre>";
// echo "<pre>game_session: ";print_r($game_session);echo "</pre>";
// echo "<pre>Session::all(): ";print_r(Session::all());echo "</pre>";
// echo "<pre>counts: ";print_r($counts);echo "</pre>";//exit;
// echo "<pre>remainingData: ";print_r($remainingData);echo "</pre>";//exit;
// echo "<pre>boxData: ";print_r($boxData);echo "</pre>";//exit;
// echo "<pre>boxDataId: ";print_r($boxDataId);echo "</pre>";//exit;
// echo "<pre>drawData: ";print_r($drawData);echo "</pre>";//exit;
// echo "<pre>drawData: ";print_r($tickets);echo "</pre>";//exit;
// echo "<pre>drawData: ";print_r($play);echo "</pre>";//exit;
// echo "</div>";
@endphp
<link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
<style>

	.scratchpad{
		width: 200px;
		height: 200px;
		border: 1px solid #fff;
		display: inline-block;
		margin: 0;
		padding: 0;
	}
	.playbox{
		width: 628px;
		background: #333;
		padding-top: 10px;
		padding-left: 10px;
		padding-right: 10px;
		position: relative;
	}
	.playbox-amount{
		position: absolute;
		text-align: center;
		z-index: 0;
		color: #E6E6E6;
		right: 0;
		left: 0;
		top: 50%;
		margin-top: -21px;
		font-size: 40px;
		font-weight: bold;
		/*text-shadow: 0px 0px 10px #fff;*/
		display: none;
	}
	.playbox-amount.intro{
		display: block;
		color: #000;
		text-shadow: 0px 0px 10px #fff;
	}
	/*.playbox-amount img{
		z-index: -1 !important;
	}*/
	@media (max-width: 500px) {
	  .scratchpad {
		width: 65%;
	  }

	}
	body{
		background-color:#E6E6E6;
	}
/*-------------------------------- RADIO ------------------------------------*/
.btn_choose_sent input {
  -webkit-appearance: none;
  display: block;
  margin: 10px;
  width: 18px;
  height: 18px;
  border-radius: 12px;
  cursor: pointer;
  vertical-align: middle;
  box-shadow: hsla(0,0%,100%,.15) 0 1px 1px, inset hsla(0,0%,0%,.5) 0 0 0 1px;
  background-color: hsla(0,0%,0%,.2);
      background-image: -webkit-radial-gradient( #fff 0%, #fff 15%, #fff 28%, #fff 70% );
  background-repeat: no-repeat;
  -webkit-transition: background-position .15s cubic-bezier(.8, 0, 1, 1),
    -webkit-transform .25s cubic-bezier(.8, 0, 1, 1);
  outline: none;
}
.btn_choose_sent input:checked {
  -webkit-transition: background-position .2s .15s cubic-bezier(0, 0, .2, 1),
    -webkit-transform .25s cubic-bezier(0, 0, .2, 1);
}
.btn_choose_sent input:active {
  -webkit-transform: scale(1.5);
  -webkit-transition: -webkit-transform .1s cubic-bezier(0, 0, .2, 1);
}



/* The up/down direction logic */

.btn_choose_sent input,
.btn_choose_sent input:active {
  background-position: 0 24px;
}
.btn_choose_sent input:checked {
  background-position: 0 0;
}
.btn_choose_sent input:checked ~ input,
 .btn_choose_sent input:checked ~ input:active {
  background-position: 0 -24px;
}

.btn_choose_sent{
	    background: #EF2D56;
    color: #fff;
    box-shadow: 0 10px 20px rgba(125, 147, 178, .3);
    border: none; 
     border-radius: 3px;
    font-size: 16px;
    line-height: 10px;
    padding:  16px 20px 16px 38px;
    text-align: center;
    display: inline-block;
    text-decoration: none;
    margin-right: 30px;
    transition: all .3s;
    height: auto;
    cursor: pointer;
    position: relative;
    outline: none;
}

.btn_choose_sent input{
    position: absolute;
    left: 0;
    right: 0;
    z-index: 99;
    top: 2px;
}

.btn_choose_sent input:after{
	 position: absolute;
    content: '';
    width: 15rem;
    left: 0;
    right: 0;
    /* background: red; */
    /* z-index: -1; */
    height: 40px;
    top: -10px;
}

.bg_btn_chose_1{
	background-color: #f78968 !important;
}


.bg_btn_chose_2{
	background-color: #4e336fdb !important;
}


.bg_btn_chose_3{
	background-color: #359dcc !important;
}


/*-=p=--=*/




.btn_choose_sent_check_b{
	  background: #EF2D56;
    color: #fff;
    box-shadow: 0 10px 20px rgba(125, 147, 178, .3);
    border: none; 
     border-radius: 3px;
    font-size: 16px;
    line-height: 10px;
    padding:  16px 20px 16px 46px;
    text-align: center;
    display: inline-block;
    text-decoration: none;
    margin-right: 30px;
    transition: all .3s;
    height: auto;
    cursor: pointer;
    position: relative;
    outline: none;
}
/*-------------------------------- RADIO ------------------------------------*/
.playbox-overlay-wrapper{
	position: relative;
	margin: -15px;
}
.playbox-overlay-div{
	position: absolute;
    top: 0;
    left: 0;
    background: rgba(255,255,255,0.6);
    width: 100%;
    height: 100%;
    font-size: 50px;
    padding: 120px 150px;
    text-align: center;
    font-weight: bold;
    color: #b4903a;
    text-shadow: 0px 0px 10px #000;
}
.scratch-game-start-description-box{
	width: 600px;
}
.scratch-game-start-description-box p, .scratch-game-start-description-box label{
	color: #333;
}
.scratch-game-start-description-box a{
	margin: 0 0 20px;
}
.play-btn {
    position: relative;
    margin: 30px 0;
	
    width: 628px;
}
.play-btn a{
	width: 200px;
	margin-bottom: 20px;
	margin-right: 0 !important;
}

.custom-playbox{
	display: grid;
grid-template-columns: 1fr 1fr 1fr;
gap: 5px;
padding:5px;
}
.custom-playbox-image{
	margin:0;
}
.custom-playbox-image img {
	height: 200px;
	width: 200px !important;
}
.swal2-title {
      font-size: 2.875em !important;
}
</style>
    <!-- game section start -->
    <section class="pt-100 main-sec">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-4 pay-tab-col mt-5">
				<h2 style="text-align:center">Paytable</h2>
				<table class="table table-bordered table-hover table-striped">
					<tr>
						<th>Tier</th>
						<th>Prize</th>
						<th>Amount</th>
					</tr>
					@foreach($paytablerecords as $key => $val)
						<tr>
							<td>{{ $roman[$val->tier] }}</td>
							<td>{{ number_format($val->prize) }}x</td>
							{{--<td>{{ ($val->amount > 0)?'$'.number_format($val->amount,2):'Free Play' }}</td>--}}
							<td>{{ ($val->amount > 0)?Session::get('currency_symbol').''.number_format($helpers->convert_to_currency(Session::get('currency'), $val->amount)) :'Free Play' }}</td>
						</tr>
					@endforeach
				</table>
			</div>
			<div class="col-8 pay-tab-col mt-5">
				@if(count($tickets) == 0)
				@if ($data->id == 3 || $data->id == 4)
					<p>You Dont Have Free Scratch Card</p>
				@else
				<div class="scratch-game-start-description-box">
					<p>Scratch and win exciting prize money. This scratch card game features the top prize of ฿{{ $heightest_value }}. Match 3 numbers to win one of the prizes listed in the paytable.</p>
					<div class="form-group">
						<label>Purchase the number of games you want to play:</label>
						<div class="clearfix"></div>
						<button type="button" class="btn_choose_sent bg_btn_chose_1">
							<input type="radio" name="name" checked class="scratch-game-ticket" value="1" onclick="set_ticket_value()" /> 1 Game
						</button>
						<button type="button" class="btn_choose_sent bg_btn_chose_2">
							<input type="radio" name="name" class="scratch-game-ticket" value="5" onclick="set_ticket_value()" /> 5 Games
						</button>
						<button type="button" class="btn_choose_sent bg_btn_chose_3">
							<input type="radio" name="name" class="scratch-game-ticket" value="10" onclick="set_ticket_value()" /> 10 Games
						</button>
						<input type="hidden" id="scratch-game-ticket-unit-price" value="{{ $data->unit_price }}" />
						<input type="hidden" id="scratch-game-ticket-unit-price-currency" value="{{ number_format($helpers->convert_to_currency(Session::get('currency'), $data->unit_price),2) }}" />
						<input type="hidden" id="scratch-game-ticket-unit-price-usd" value="{{ number_format($helpers->convert_to_currency('USD', $data->unit_price),2) }}" />
					</div>
					<p><b>Total:</b> ฿<span class="total-amount-of-tickets">{{ number_format($data->unit_price*1,2) }}</span></p>
					<a class="btn btn-sm btn--base btn--custom me-5 px-4" id="buy-ticket-button">Buy Now</a>
				</div>
				@endif
				
				@endif
				<div class="playbox" style="background:none;">
					@if(count($tickets) == 0)
						<div class="playbox-overlay-wrapper">
							<img src="{{ asset('assets/images/game/'.$data->photo) }}" style="width: 50%; height: 230px;" />
							{{--  <div class="playbox-overlay-div">Scratch and win the jackpot worth ฿{{ $heightest_value }}</div>  --}}
						</div>
					@elseif(count($tickets) > 0 && $play == 'no')
						<div class="playbox custom-playbox">
						@foreach($paytablerecords as $index => $val)
							@if(isset($val->photo[0]) && $index <= (count($paytablerecords) -2))
								<div class="playbox-overlay-wrapper custom-playbox-image">
									<img src="{{ asset('assets/images/game/'.$val->photo) }}" style="width:100%;" />
									{{--  <div class="playbox-overlay-div">Scratch and win the jackpot worth ฿{{ $heightest_value }}</div>  --}}
								</div>
							@endif
						@endforeach
						</div>
					@else
						@foreach ($draw_values as $key => $val)
						@if($val < 0)
							<div id="playbox-{{ $key }}" class="scratchpad"><div class="playbox-amount">{{ 'Free Play' }}</div></div>
						@else
							{{--<div id="playbox-{{ $key }}" class="scratchpad"><div class="playbox-amount">${{ number_format($val)}}</div></div>--}}
							<div id="playbox-{{ $key }}" class="scratchpad"><div class="playbox-amount">{{ number_format($helpers->convert_to_currency(Session::get('currency'), $val)) }}</div></div>
						@endif
						@endforeach
					@endif
				</div>
				<div class="play-btn">
					@if(count($tickets) > 0 && $play == 'no')
						<a class="btn btn-sm btn--base btn--custom me-5 px-4" id="something" href="{{ route('scratch_cards_game',['id' => $data->id]) }}?play=on">Play Game</a>
					@elseif(count($tickets) == 1 && $play == 'yes')
						<a class="btn btn-sm btn--base btn--custom me-5 px-4 pull-left" id="clear-all" href="javascript:;">Clear All</a>
						<a class="btn btn-sm btn--base btn--custom me-5 px-4 pull-right" id="something">Better Luck Next Time</a>
					@elseif(count($tickets) > 1 && $play == 'yes')
						<a class="btn btn-sm btn--base btn--custom me-5 px-4 pull-left" id="clear-all" href="javascript:;">Clear All</a>
						<a class="btn btn-sm btn--base btn--custom me-5 px-4 pull-right" id="something" href="{{ route('scratch_cards_game',['id' => $data->id]) }}?play=on">Play Again ({{ count($tickets)-1 }})</a>
					@endif
				</div>
			</div>
		</div>
	 
	</div>
	</section>
    <!-- game section end -->

<input type="hidden" id="session-currency-symbol" value="{{ Session::get('currency_symbol') }}" />
<?php for($b=0; $b<=8; $b++){ ?>
<input type="hidden" class="playbox-cleared" id="playbox-cleared<?= $b?>" value="0" />
<?php } ?>
<form action="{{ route('user.buyscratchticket', ['id' => $data->id]) }}" method="POST" id="buytickets">
	@csrf
	<input type="hidden" name="tickets" id="scratch-tickets">
	<input type="hidden" name="unit_price" id="scratch-price">
</form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript" src="{{ asset('assets/plugin/wScratchPad.js?v='.time()) }}"></script>
<script>
var clear_all = true;
var playbox_cleared = false;
var WinnerValue = '{{ $winnerValue }}';
var WinnerCurrency = '{{ Session::get('currency_symbol') }}';
$(document).ready(function(){
	$('.scratchpad img').css('z-index', '-1');
	// console.log(WinnerValue);
});
function if_playbox_cleared(){
	var validate = true;
	$('.playbox-cleared').each(function(){
		if($(this).val() == 0){
			validate = false;
		}
	});
	if(validate){
		playbox_cleared = true;
	}
	if(playbox_cleared){
		if(WinnerValue < 0){
			Swal.fire({
				title: "You have won a Free Play!",
				imageUrl: '{{ asset("assets/images/winning-gif.gif") }}',        
				// imageHeight: 80, 
				imageWidth: 150,
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-sm btn--base btn--custom',
				}
			});
		}else if(WinnerValue != 0){
			
			WinnerValue1 = '{{ number_format($helpers->convert_to_currency(Session::get('currency'), $winnerValue),2) }}';
			Swal.fire({
				title: "You have won "+(WinnerCurrency+WinnerValue1)+"!",
				imageUrl: '{{ asset("assets/images/winning-gif.gif") }}',        
				// imageHeight: 80, 
				imageWidth: 150,
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-sm btn--base btn--custom',
				}
			});
			if(clear_all){
				$.ajax({
					type : 'POST',
					url : "{{ route('user.addWinningPoints') }}",
					data : {'_token' : '{{ csrf_token() }}', 'WinnerValue' : WinnerValue},
					cache : false,
					success : function(response){
						// $(#resultarea).text(data);
						clear_all = false;
					}
				});
			}
		}else{
			Swal.fire({
				// icon: "warning",
				imageUrl: '{{ asset("assets/images/better-luck-next-time.png") }}',        
				// imageHeight: 80, 
				imageWidth: 150,
				title: "Better Luck Next Time",
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-sm btn--base btn--custom',
				}
			});
		}
	}
}
</script>
	@foreach($paytablerecords as $index => $val)
		@if(isset($val->photo[0]) && $index <= (count($paytablerecords) -2))
			<script type="text/javascript">
			$('#playbox-<?= $index;?>').wScratchPad({
				bg: '{{ asset('assets/images/game/'.$val->photo) }}',
				fg: '{{ asset("assets/plugin/images/mask-coins-image.jpg") }}',
				'cursor': 'url("<?= asset('assets/plugin/cursors/coin-80x80.png') ?>") 5 5, default',
				scratchMove: function (e, percent) {
					if (percent > 60) {
						this.clear();
						$('#playbox-cleared<?= $index;?>').val(1);
						$('#playbox-<?= $index;?> .playbox-amount').addClass('intro');
						if_playbox_cleared();
					}
				}
			});
			</script>
		@endif
	@endforeach()
	<script>
	<?php for($b=0; $b<=8; $b++){ ?>
	var sp<?= $b?> = $("#playbox-<?= $b?>").wScratchPad();
	<?php } ?>
	$(document).on('click','#clear-all',function(){
		<?php for($b=0; $b<=8; $b++){ ?>
			sp<?= $b?>.wScratchPad('clear');
			$('#playbox-cleared<?= $b;?>').val(1);
			$('#playbox-<?= $b;?> .playbox-amount').addClass('intro');
		<?php } ?>
		if_playbox_cleared();
	});
	</script>
<script>
function set_ticket_value(){
	var price = $('#scratch-game-ticket-unit-price').val();
	var tickets = $('.scratch-game-ticket:checked').val();
	var total = (parseFloat(price)*parseInt(tickets));
	$('.total-amount-of-tickets').html(total.toFixed(2));
}
$(document).on('click','#buy-ticket-button',function(){
	var currency_symbol = $('#session-currency-symbol').val();
	var tickets = $('.scratch-game-ticket:checked').val();
	var price = $('#scratch-game-ticket-unit-price').val();
	var total = (parseFloat(price)*parseInt(tickets));
	var price_currency = $('#scratch-game-ticket-unit-price-currency').val();
	var total_currency = (parseFloat(price_currency)*parseInt(tickets).toFixed(2));
	var price_usd = $('#scratch-game-ticket-unit-price-usd').val();
	var total_usd = (parseFloat(price_usd)*parseInt(tickets)).toFixed(2);
	console.log(price_usd);
	console.log(total_usd);
	Swal.fire({
		icon: "warning",
		title: "Buy "+tickets+" tickets for "+currency_symbol+total_currency+" ($"+total_usd+")",
		html: "Choose your payment method <br><input type='radio' checked /> <b>Deposit (default)</b><br><input type='radio' disabled /> Winnings<br><input type='radio' disabled /> Commissions",
		showCancelButton: true,
		confirmButtonText: 'Yes, I am sure!',
		denyButtonText: `No, cancel it!`,
	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
			$('#scratch-tickets').val(tickets);
			$('#scratch-price').val(price);
			$('#buytickets')[0].submit();
		}
	});
});

</script>
@endsection
