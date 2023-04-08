<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Phase;
use Carbon\Carbon;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function pool(){
    	$pageTitle = "Pool Game";
    	$pool = Game::find(1);
    	return view('admin.game.pool',compact('pageTitle','pool'));
    }

    public function dice(){
        $pageTitle = "Dice Rolling Game";
        $dice = Game::find(3);
        return view('admin.game.dice',compact('pageTitle','dice'));
    }

    public function card(){
        $pageTitle = "Card Game";
        $card = Game::find(2);
        return view('admin.game.card',compact('pageTitle','card'));
    }

    public function nintynine(){
        $pageTitle = "Ninty Nine Game";
        $nintynine = Game::find(4);
        return view('admin.game.nintynine',compact('pageTitle','nintynine'));
    }

    public function roulette(){
        $pageTitle = "Roulette Game";
        $roulette = Game::find(5);
        return view('admin.game.roulette',compact('pageTitle','roulette'));
    }

    public function numberbuy(){
        $pageTitle = "Number Game";
        $numberbuy = Game::find(6);
        return view('admin.game.numberbuy',compact('pageTitle','numberbuy'));
    }

    public function update(Request $request,$id){
    	$request->validate([
    		'min_limit'=>'required|numeric',
    		'max_limit'=>'required|numeric',
    		'title'=>'required',
    		'instruction'=>'required',
    		'image'=>['nullable','image',new FileTypeValidate(['png','jpg','jpeg'])],
    	]);
    	$game = Game::find($id);
    	$image = $game->image;
    	if ($request->hasFile('image')) {
            $path = imagePath()['game']['path'];
            $size = imagePath()['game']['size'];
            $old = $game->image;
    		try {
    			$image = uploadImage($request->image,$path,$size,$old);
    		} catch (\Exception $e) {
    			$notify[] = ['error','Image Could Not be uploaded'];
    			return back()->withNotify($notify);
    		}
    	}
    	$game->update([
    		'name'=>$request->title,
    		'win_bonus'=>$request->win_bonus ? $request->win_bonus : $game->win_bonus,
    		'min_limit'=>$request->min_limit,
    		'max_limit'=>$request->max_limit,
    		'instruction'=>$request->instruction,
    		'image'=>$image,
    		'status'=>$request->status ? 1 : 0,
    	]);
    	$notify[] = ['success','Game Updated Successfully'];
    	return back()->withNotify($notify);
    }

    public function phase(){
    	$pageTitle = "Game Phases";
    	$phases = Phase::orderBy('id','desc')->with('game')->paginate(config('constants.table.default'));
    	$games = Game::where('status',1)->get();
    	$empty_message = "Data Not Found";
    	return view('admin.game.phases',compact('pageTitle','phases','games','empty_message'));
    }

    public function phaseCreate(Request $request){
        $request->validate([
            'game_id'=>'required',
            'end'=>'required',
            'start'=>'required',
        ]);
        $game = Game::find($request->game_id);
        if(!$game){
            $notify[] = ['error','Game not found'];
            return back()->withNotify($notify);
        }
        $exist = Phase::where('game_id',$request->game_id)->whereDate('start_date','>=',Carbon::parse($request->start))->whereDate('end_date','>=',Carbon::parse($request->end))->first();
        if ($exist) {
            $notify[] = ['error','Already 1 phase is running'];
            return back()->withNotify($notify);
        }
        $start = Carbon::parse($request->start)->toDateTimeString();
        $end = Carbon::parse($request->end)->toDateTimeString();
        if(Carbon::now() > $end){
            $notify[] = ['error','End date must be a future date'];
            return back()->withNotify($notify);
        }
        if($start > $end){
            $notify[] = ['error','End date must be greater than start date'];
            return back()->withNotify($notify);
        }
        $phase_number = $game->phases->count();
        Phase::create([
            'game_id'=>$request->game_id,
            'phase_number'=>$phase_number + 1,
            'end_date'=>$end,
            'start_date'=>$start,
        ]);
        $notify[] = ['success','Game Phase Created Successfully'];
        return back()->withNotify($notify);
    }

    public function phaseUpdate(Request $request,$id){
        $request->validate([
            'end'=>'required',
            'start'=>'required',
        ]);
        $phase = Phase::find($id);
        if (!$phase) {
            $notify[] = ['error','Game Phase Not Found'];
            return back()->withNotify($notify);
        }
        $start = Carbon::parse($request->start)->toDateTimeString();
        $end = Carbon::parse($request->end)->toDateTimeString();
        if(Carbon::now() > $end){
            $notify[] = ['error','End date must be a future date'];
            return back()->withNotify($notify);
        }
        if($start > $end){
            $notify[] = ['error','End date must be greater than start date'];
            return back()->withNotify($notify);
        }
        $phase->update([
            'end_date'=>$end,
            'start_date'=>$start,
        ]);
        $notify[] = ['success','Game Phase Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function phaseStatus($id){
        $phase = Phase::find($id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        if ($phase->status == 1) {
            $phase->update(['status'=>0]);
            $notify[] = ['success','Phase Deactivate Successfully'];
        }else{
            $phase->update(['status'=>1]);
            $notify[] = ['success','Phase Activate Successfully'];
        }
        return back()->withNotify($notify);
    }

    public function nintyninegameUpdate(Request $request){
        $request->validate([
            'level*' => 'required|integer|min:1',
            'percent*' => 'required|numeric',
        ]);
        $game = Game::find(4);
        $game->update([
            'win_bonus'=>[
                'level'=>$request->level,
                'percent'=>$request->percent,
            ]
        ]);
        $notify[] = ['success','Game Updated'];
        return back()->withNotify($notify);
    }
}
