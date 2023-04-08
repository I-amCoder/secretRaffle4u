<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Game;
use App\Models\GeneralSetting;
use App\Models\Phase;
use App\Models\Transaction;
use App\Models\UserChoose;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function playGame($id){
    	$phase = Phase::find($id);
    	if (!$phase) {
    		$notify[] = ['error','Phase Not Found'];
    		return back()->withNotify($notify);
    	}
        if ($phase->end_date < Carbon::now()->toDateTimeString()) {
            $notify[] = ['error','Oops! Time Out'];
            return back()->withNotify($notify);
        }

    	$pageTitle = $phase->game->name;
    	return view(activeTemplate().'user.game.'.$phase->game->alias,compact('phase','pageTitle'));
    }

    public function cardBid(Request $request){
        $request->validate([
            'phase_id'=>'required',
            'invest'=>'required|numeric',
            'user_choose'=>'required',
        ]);
        $game = Game::find(2);
        if (!$game) {
            $notify[] = ['error','Game Not Found'];
            return back()->withNotify($notify);
        }
        if($game->max_limit < $request->invest || $game->min_limit > $request->invest){
            $notify[] = ['error','Please Follow The Invest Limit'];
            return back()->withNotify($notify);
        }
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        if ($request->user_choose != 'Red' && $request->user_choose != 'Black') {
            $notify[] = ['error','Invalide selection'];
            return back()->withNotify($notify);
        }
        $user = auth()->user();
        if($user->balance < $request->invest){
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        $user->balance -= $request->invest;
        $user->save();

        $general = GeneralSetting::first(['cur_sym','ic']);
        if ($general->ic == 1) {
            $commissionType = 'invest';
            levelCommision($user->id, $request->invest, $commissionType);
        }

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'post_balance' => getAmount($user->balance),
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to  ' . $game->name,
            'trx' => getTrx()
        ]);
        Bid::create([
            'game_id'=>$game->id,
            'phase_id'=>$request->phase_id,
            'invest'=>$request->invest,
            'user_choose'=>$request->user_choose,
            'user_id'=>$user->id,
        ]);
        $notify[] = ['success','You Bidded Successfully'];
        return back()->withNotify($notify);
    }

    public function diceBid(Request $request){
        $request->validate([
            'phase_id'=>'required',
            'invest'=>'required|numeric',
            'user_choose'=>'required',
        ]);
        $game = Game::find(3);
        if (!$game) {
            $notify[] = ['error','Game Not Found'];
            return back()->withNotify($notify);
        }
        if($game->max_limit < $request->invest || $game->min_limit > $request->invest){
            $notify[] = ['error','Please Follow The Invest Limit'];
            return back()->withNotify($notify);
        }
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        if ($request->user_choose < 1 || $request->user_choose > 6) {
            $notify[] = ['error','Invalide selection'];
            return back()->withNotify($notify);
        }
        $user = auth()->user();
        if($user->balance < $request->invest){
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        $user->balance -= $request->invest;
        $user->save();

        $general = GeneralSetting::first(['cur_sym','ic']);
        if ($general->ic == 1) {
            $commissionType = 'invest';
            levelCommision($user->id, $request->invest, $commissionType);
        }
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'post_balance' => getAmount($user->balance),
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest To  ' . $game->name,
            'trx' => getTrx()
        ]);
        Bid::create([
            'game_id'=>$game->id,
            'phase_id'=>$request->phase_id,
            'invest'=>$request->invest,
            'user_choose'=>$request->user_choose,
            'user_id'=>$user->id,
        ]);
        $notify[] = ['success','You Bidded Successfully'];
        return back()->withNotify($notify);
    }

    public function poolBid(Request $request){
        $request->validate([
            'phase_id'=>'required',
            'invest'=>'required|numeric',
            'user_choose'=>'required',
        ]);
        $game = Game::find(1);
        if (!$game) {
            $notify[] = ['error','Game Not Found'];
            return back()->withNotify($notify);
        }
        if($game->max_limit < $request->invest || $game->min_limit > $request->invest){
            $notify[] = ['error','Please Follow The Invest Limit'];
            return back()->withNotify($notify);
        }
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        if ($request->user_choose < 1 || $request->user_choose > 8) {
            $notify[] = ['error','Invalide selection'];
            return back()->withNotify($notify);
        }
        $user = auth()->user();
        if($user->balance < $request->invest){
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        $user->balance -= $request->invest;
        $user->save();

        $general = GeneralSetting::first(['cur_sym','ic']);
        if ($general->ic == 1) {
            $commissionType = 'invest';
            levelCommision($user->id, $request->invest, $commissionType);
        }


        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'post_balance' => getAmount($user->balance),
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest To  ' . $game->name,
            'trx' => getTrx()
        ]);
        Bid::create([
            'game_id'=>$game->id,
            'phase_id'=>$request->phase_id,
            'invest'=>$request->invest,
            'user_choose'=>$request->user_choose,
            'user_id'=>$user->id,
        ]);
        $notify[] = ['success','You Bidded Successfully'];
        return back()->withNotify($notify);
    }

    public function numberBid(Request $request){
        $request->validate([
            'phase_id'=>'required',
            'invest'=>'required|numeric',
            'numbers'=>'array|required',
            'numbers.*'=>'required',
        ],[
            'numbers.*.required'=>'Every Number Field is Required'
        ]);
        $game = Game::find(4);
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }

        if($game->max_limit < $request->invest || $game->min_limit > $request->invest){
            $notify[] = ['error','Please Follow The Invest Limit'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        if($user->balance < $request->invest){
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        foreach ($request->numbers as $key => $num) {
            if ($num < 0 || $num > 99) {
                $notify[] = ['error','Invalide selection'];
                return back()->withNotify($notify);
            }
        }
        $user->balance -= $request->invest;
        $user->save();

        $general = GeneralSetting::first(['cur_sym','ic']);
        if ($general->ic == 1) {
            $commissionType = 'invest';
            levelCommision($user->id, $request->invest, $commissionType);
        }


        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'post_balance' => getAmount($user->balance),
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest To  ' . $game->name,
            'trx' => getTrx()
        ]);
        $bid_id = Bid::insertGetId([
            'game_id'=>$game->id,
            'phase_id'=>$request->phase_id,
            'invest'=>$request->invest,
            'user_id'=>$user->id,

        ]);
        foreach ($request->numbers as $key => $num) {
            UserChoose::create([
                'bid_id'=>$bid_id,
                'phase_id'=>$request->phase_id,
                'ind'=>$key,
                'choose'=>$num,
            ]);
        }
        $notify[] = ['success','You Bidded Successfully'];
        return back()->withNotify($notify);
    }

    public function rouletteBid(Request $request){
        $request->validate([
            'phase_id'=>'required',
            'invest'=>'required|numeric',
            'choose'=>'required_without:numbers',
        ],[
            'choose.required'=>'Please Choose Numbers'
        ]);
        $game = Game::findOrFail(5);
        if($game->max_limit < $request->invest || $game->min_limit > $request->invest){
            $notify[] = ['error','Please Follow The Invest Limit'];
            return back()->withNotify($notify);
        }
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        if (isset($request->btn122)) {
            for ($i=1; $i <= 12; $i++) {
                $numbers[] = $i;
            }
        }elseif(isset($request->btn1324)){
            for ($i=13; $i <= 24; $i++) {
                $numbers[] = $i;
            }
        }elseif(isset($request->btn2536)){
            for ($i=25; $i <= 36; $i++) {
                $numbers[] = $i;
            }
        }elseif(isset($request->btn118)){
            for ($i=1; $i <= 18; $i++) {
                $numbers[] = $i;
            }
        }elseif(isset($request->btn119)){
            for ($i=19; $i <= 36; $i++) {
                $numbers[] = $i;
            }
        }elseif(isset($request->btneven)){
            for ($i=1; $i <= 36; $i++) {
                if ($i%2 == 0) {
                    $numbers[] = $i;
                }
            }
        }elseif(isset($request->btnodd)){
            for ($i=1; $i <= 36; $i++) {
                if ($i%2 != 0) {
                    $numbers[] = $i;
                }
            }
        }elseif(isset($request->btnred)){
            $numbers = [3,9,12,18,21,27,30,36,5,14,23,32,1,7,16,19,25,34];
        }elseif(isset($request->btnblack)){
            $numbers = [6,15,24,33,2,8,11,17,20,26,29,35,4,10,13,22,31,28];
        }elseif(isset($request->btn211)){
            $count = 3;
            while ($count <= 36) {
                $numbers[] = $count;
                $count++;
                $count++;
                $count++;
            }
        }elseif(isset($request->btn212)){
            $count = 2;
            while ($count <= 35) {
                $numbers[] = $count;
                $count++;
                $count++;
                $count++;
            }
        }elseif(isset($request->btn213)){
            $count = 1;
            while ($count <= 34) {
                $numbers[] = $count;
                $count++;
                $count++;
                $count++;
            }
        }elseif(isset($request->numbers)){
            $num = intval($request->numbers);
            if ($request->numbers > 0 && $request->numbers < 37) {
                $numbers = [$request->numbers];
            }else{
                $notify[] = ['error','Opps!Something is Wrong'];
                return back()->withNotify($notify);
            }
        }else{
            $notify[] = ['error','Opps!Something is Wrong'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        if($user->balance < $request->invest){
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        $user->balance -= $request->invest;
        $user->save();

        $general = GeneralSetting::first(['cur_sym','ic']);
        if ($general->ic == 1) {
            $commissionType = 'invest';
            levelCommision($user->id, $request->invest, $commissionType);
        }


        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'post_balance' => getAmount($user->balance),
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest To  ' . $game->name,
            'trx' => getTrx()
        ]);
        $bid_id = Bid::insertGetId([
            'game_id'=>$game->id,
            'phase_id'=>$request->phase_id,
            'invest'=>$request->invest,
            'select_count'=>collect($numbers)->count(),
            'user_id'=>$user->id,
        ]);
        foreach ($numbers as $num) {
            UserChoose::create([
                'bid_id'=>$bid_id,
                'phase_id'=>$request->phase_id,
                'choose'=>$num,
            ]);
        }
        $notify[] = ['success','You Bidded Successfully'];
        return back()->withNotify($notify);
    }

    public function buyNumberBid(Request $request){
        $request->validate([
            'phase_id'=>'required',
            'invest'=>'required|numeric',
            'user_choose'=>'required',
        ]);
        $game = Game::find(6);
        if (!$game) {
            $notify[] = ['error','Game Not Found'];
            return back()->withNotify($notify);
        }
        if($game->max_limit < $request->invest || $game->min_limit > $request->invest){
            $notify[] = ['error','Please Follow The Invest Limit'];
            return back()->withNotify($notify);
        }
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        $bid = Bid::where('user_choose',$request->user_choose)->where('phase_id',$request->phase_id)->first();
        if ($bid) {
            $notify[] = ['error','This Number is already selled'];
            return back()->withNotify($notify);
        }
        if ($request->user_choose < 1 || $request->user_choose > 100) {
            $notify[] = ['error','Invalide selection'];
            return back()->withNotify($notify);
        }
        $user = auth()->user();
        if($user->balance < $request->invest){
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        $user->balance -= $request->invest;
        $user->save();

        $general = GeneralSetting::first(['cur_sym','ic']);
        if ($general->ic == 1) {
            $commissionType = 'invest';
            levelCommision($user->id, $request->invest, $commissionType);
        }


        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'post_balance' => getAmount($user->balance),
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest To  ' . $game->name,
            'trx' => getTrx()
        ]);
        Bid::create([
            'game_id'=>$game->id,
            'phase_id'=>$request->phase_id,
            'invest'=>$request->invest,
            'user_choose'=>$request->user_choose,
            'user_id'=>$user->id,
        ]);
        $notify[] = ['success','You Bidded Successfully'];
        return back()->withNotify($notify);
    }
    
}
