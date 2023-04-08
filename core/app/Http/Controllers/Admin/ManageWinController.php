<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Game;
use App\Models\GeneralSetting;
use App\Models\Phase;
use App\Models\Transaction;
use App\Models\UserChoose;
use App\Models\Winner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageWinController extends Controller
{
    public function index()
    {
    	$pageTitle = "Manage Win";
    	$phases = Phase::where('draw_status',0)->where('end_date','<',Carbon::now())->with('game')->where('status',1)->paginate(getPaginate());
        $empty_message = "Nothing to draw";
    	return view('admin.win.index',compact('pageTitle','phases','empty_message'));
    }

    public function makeWinner($id){
    	$phase = Phase::find($id);
    	if (!$phase) {
    		$notify[] = ['error','Phase Not Found'];
    		return back()->withNotify($notify);
    	}
        $pageTitle = $phase->game->name;
    	return view('admin.win.'.$phase->game->alias,compact('phase','pageTitle'));
    }

    public function amoCalPool(Request $request){
    	$bids = Bid::where('user_choose',$request->number)->where('phase_id',$request->phase_id)->get();
    	$invest = $bids->sum('invest');
    	return response()->json($invest);
    }

    public function makeDraw(Request $request){
    	$request->validate([
    		'win'=>'required',
    		'phase_id'=>'required',
    	]);
    	$phase = Phase::find($request->phase_id);
    	if (!$phase) {
    		$notify[] = ['error','Phase Not Found'];
    		return back()->withNotify($notify);
    	}
    	$bids = Bid::where('user_choose',$request->win)->where('phase_id',$request->phase_id)->get();
    	$trx = getTrx();
        $gnl = GeneralSetting::first();
    	foreach ($bids as $bid) {
    		$amo = $bid->invest * ($bid->game->win_bonus / 100 );
    		$user = $bid->user;
    		$user->balance += $amo;
    		$user->save();

            $general = GeneralSetting::first(['cur_sym','wc']);
            if ($general->wc == 1) {
                $commissionType = 'win';
                levelCommision($user->id, $amo, $commissionType);
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amo;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Win Bonus From '.$bid->game->name;
            $transaction->trx = $trx;
            $transaction->save();

            $winner = new Winner();
			$winner->phase_id = $request->phase_id;
			$winner->user_id = $user->id;
			$winner->win = $request->win;
            $winner->amo = $amo;
            $winner->save();

            notify($user,'WIN_GAME',[
                'game'=>$bid->game->name,
                'win'=>$request->win,
                'amount'=>$amo,
                'currency'=>$gnl->cur_text,
            ]);
    	}
    	$phase->update(['draw_status'=>1]);
    	$notify[] = ['success','Winner Created Successfully'];
    	return redirect()->route('admin.win.index')->withNotify($notify);
    }

    public function calCard(Request $request){
        $bids = Bid::where('user_choose',$request->number)->where('phase_id',$request->phase_id)->get();
        $invest = $bids->sum('invest');
        return response()->json($invest);
    }

    public function winnerCard(Request $request){
        $request->validate([
            'win'=>'required',
            'phase_id'=>'required',
        ]);
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        $bids = Bid::where('user_choose',$request->win)->where('phase_id',$request->phase_id)->get();
        $trx = getTrx();
        $gnl = GeneralSetting::first();
        foreach ($bids as $bid) {
            $amo = $bid->invest * ($bid->game->win_bonus / 100 );
            $user = $bid->user;
            $user->balance += $amo;
            $user->save();

            $general = GeneralSetting::first(['cur_sym','wc']);
            if ($general->wc == 1) {
                $commissionType = 'win';
                levelCommision($user->id, $amo, $commissionType);
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amo;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Win Bonus From '.$bid->game->name;
            $transaction->trx = $trx;
            $transaction->save();

            $winner = new Winner();
            $winner->phase_id = $request->phase_id;
            $winner->user_id = $user->id;
            $winner->win = $request->win;
            $winner->amo = $amo;
            $winner->save();

            notify($user,'WIN_GAME',[
                'game'=>$bid->game->name,
                'win'=>$request->win,
                'amount'=>$amo,
                'currency'=>$gnl->cur_text,
            ]);
        }
        $phase->update(['draw_status'=>1]);
        $notify[] = ['success','Winner Created Successfully'];
        return redirect()->route('admin.win.index')->withNotify($notify);
    }

    public function amoCalDice(Request $request){
        $bids = Bid::where('user_choose',$request->number)->where('phase_id',$request->phase_id)->get();
        $invest = $bids->sum('invest');
        return response()->json($invest);
    }

    public function winnerDice(Request $request){
        $request->validate([
            'win'=>'required',
            'phase_id'=>'required',
        ]);
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        $bids = Bid::where('user_choose',$request->win)->where('phase_id',$request->phase_id)->get();
        $trx = getTrx();
        $gnl = GeneralSetting::first();
        foreach ($bids as $bid) {
            $amo = $bid->invest * ($bid->game->win_bonus / 100 );
            $user = $bid->user;
            $user->balance += $amo;
            $user->save();

            $general = GeneralSetting::first(['cur_sym','wc']);
            if ($general->wc == 1) {
                $commissionType = 'win';
                levelCommision($user->id, $amo, $commissionType);
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amo;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Win Bonus From '.$bid->game->name;
            $transaction->trx = $trx;
            $transaction->save();

            $winner = new Winner();
            $winner->phase_id = $request->phase_id;
            $winner->user_id = $user->id;
            $winner->win = $request->win;
            $winner->amo = $amo;
            $winner->save();


            notify($user,'WIN_GAME',[
                'game'=>$bid->game->name,
                'win'=>$request->win,
                'amount'=>$amo,
                'currency'=>$gnl->cur_text,
            ]);
        }
        $phase->update(['draw_status'=>1]);
        $notify[] = ['success','Winner Created Successfully'];
        return redirect()->route('admin.win.index')->withNotify($notify);
    }

    public function amoCalNumber(Request $request){
        $bids = Bid::where('user_choose',$request->number)->where('phase_id',$request->phase_id)->get();
        $invest = $bids->sum('invest');
        return response()->json($invest);
    }

    public function winnerNumber(Request $request){
        $request->validate([
            'win'=>'required',
            'phase_id'=>'required',
        ]);
        $phase = Phase::find($request->phase_id);
        if (!$phase) {
            $notify[] = ['error','Phase Not Found'];
            return back()->withNotify($notify);
        }
        $bids = Bid::where('user_choose',$request->win)->where('phase_id',$request->phase_id)->get();
        $trx = getTrx();
        $gnl = GeneralSetting::first();
        foreach ($bids as $bid) {
            $amo = $bid->invest * ($bid->game->win_bonus / 100 );
            $user = $bid->user;
            $user->balance += $amo;
            $user->save();

            $general = GeneralSetting::first(['cur_sym','wc']);
            if ($general->wc == 1) {
                $commissionType = 'win';
                levelCommision($user->id, $amo, $commissionType);
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amo;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Win Bonus From '.$bid->game->name;
            $transaction->trx = $trx;
            $transaction->save();

            $winner = new Winner();
            $winner->phase_id = $request->phase_id;
            $winner->user_id = $user->id;
            $winner->win = $request->win;
            $winner->amo = $amo;
            $winner->save();


            notify($user,'WIN_GAME',[
                'game'=>$bid->game->name,
                'win'=>$request->win,
                'amount'=>$amo,
                'currency'=>$gnl->cur_text,
            ]);
        }
        $phase->update(['draw_status'=>1]);
        $notify[] = ['success','Winner Created Successfully'];
        return redirect()->route('admin.win.index')->withNotify($notify);
    }


    public function amoCalNum(Request $request){
        $choose = UserChoose::where('phase_id',$request->id)->where('choose',$request->number)->with(['phase','bid'])->get();
        $game = Game::find(4);
        $bon = json_decode($game->win_bonus)->percent;
        $amo = 0;
        foreach ($choose as $key => $ch) {
            $amo += $ch->bid->invest * ( $bon[$ch->ind] / 100 );
        }
        return response()->json($amo);
    }

    public function winnerNum(Request $request){
        $request->validate([
            'win'=>'required',
            'phase_id'=>'required',
        ]);
        $bids = Bid::where('phase_id',$request->phase_id)->get();
        $phase = Phase::find($request->phase_id);
        $game = Game::find(4);
        $choose = UserChoose::where('phase_id',$request->phase_id)->where('choose',$request->win)->with(['phase','bid'])->get();
        $bon = json_decode($game->win_bonus)->percent;
        $trx = getTrx();
        $gnl = GeneralSetting::first();
        foreach ($choose as $key => $ch) {
            $amo = $bon[$ch->ind];
            $user = $ch->bid->user;
            $user->balance += $ch->bid->invest * ( $amo / 100 );

            $general = GeneralSetting::first(['cur_sym','wc']);
            if ($general->wc == 1) {
                $commissionType = 'win';
                levelCommision($user->id, $ch->bid->invest * ( $amo / 100 ), $commissionType);
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $ch->bid->invest * ( $amo / 100 );
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Win Bonus From '.$ch->bid->game->name;
            $transaction->trx = $trx;
            $transaction->save();

            $winner = new Winner();
            $winner->phase_id = $request->phase_id;
            $winner->user_id = $user->id;
            $winner->win = $request->win;
            $winner->amo = $ch->bid->invest * ( $amo / 100 );
            $winner->save();


            notify($user,'WIN_GAME',[
                'game'=>$ch->bid->game->name,
                'win'=>$request->win,
                'amount'=>$ch->bid->invest * ( $amo / 100 ),
                'currency'=>$gnl->cur_text,
            ]);
        }
        $phase->update(['draw_status'=>1]);
        $notify[] = ['success','Winner Created Successfully'];
        return redirect()->route('admin.win.index')->withNotify($notify);
    }

    public function amoCalRoul(Request $request){
        $choose = UserChoose::where('phase_id',$request->id)->where('choose',$request->number)->with(['phase','bid'])->get();
        $game = Game::find(5);
        $amo = 0;
        foreach ($choose as $key => $ch) {
            $bon = 36 / $ch->bid->select_count;
            $invest = $ch->bid->invest;
            $amo += $bon * $invest;
        }
        return response()->json($amo);
    }

    public function winnerRoul(Request $request){
        $request->validate([
            'win'=>'required',
            'phase_id'=>'required',
        ]);
        $bids = Bid::where('phase_id',$request->phase_id)->get();
        $phase = Phase::find($request->phase_id);
        $game = Game::find(5);
        $choose = UserChoose::where('phase_id',$request->phase_id)->where('choose',$request->win)->with(['phase','bid'])->get();
        $trx = getTrx();
        $gnl = GeneralSetting::first();
        foreach ($choose as $key => $ch) {
            $bon = 36 / $ch->bid->select_count;
            $invest = $ch->bid->invest;
            $user = $ch->bid->user;
            $user->balance += $bon * $invest;

            $general = GeneralSetting::first(['cur_sym','wc']);
            if ($general->wc == 1) {
                $commissionType = 'win';
                levelCommision($user->id, ($bon * $invest), $commissionType);
            }
            
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $bon * $invest;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Win Bonus From '.$ch->bid->game->name;
            $transaction->trx = $trx;
            $transaction->save();

            $winner = new Winner();
            $winner->phase_id = $request->phase_id;
            $winner->user_id = $user->id;
            $winner->win = $request->win;
            $winner->amo = $bon * $invest;
            $winner->save();


            notify($user,'WIN_GAME',[
                'game'=>$ch->bid->game->name,
                'win'=>$request->win,
                'amount'=>$bon * $invest,
                'currency'=>$gnl->cur_text,
            ]);
        }
        $phase->update(['draw_status'=>1]);
        $notify[] = ['success','Winner Created Successfully'];
        return redirect()->route('admin.win.index')->withNotify($notify);
    }

    public function winners(){
        $search = request()->search;
        if ($search){
            $pageTitle = "Search result for {{$search}}";
            $winners =Winner::with(['user', 'phase'])->whereHas('user', function ($q) use ($search){
                $q->where('username', $search);
            })->latest('id')->paginate(getPaginate());
            $empty_message = "Winner Not Found Yet";
            return view('admin.win.winners',compact('pageTitle','winners','empty_message'));
        }

        $pageTitle = "Winners";
        $winners = Winner::orderBy('id','desc')->with(['user', 'phase'])->paginate(getPaginate());
        $empty_message = "Winner Not Found Yet";
        return view('admin.win.winners',compact('pageTitle','winners','empty_message'));
    }
}
