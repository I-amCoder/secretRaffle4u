<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Bid;
use App\Models\CommissionLog;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\RaffleGameSetting;
use App\Models\RaffleGame;
use App\Models\RaffleTicket;
use App\Models\RewardPage;
use App\Models\Referral;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Winner;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function rewards_page()
    {
        $c_rules = RewardPage::where('type', 1)->get();
        $level_req = RewardPage::where('type', 2)->get();
        $pageTitle = 'Reward Page';
        return view('admin.rewards_page', compact('pageTitle', 'c_rules', 'level_req'));

    }
    public function store_c_rule(Request $req)
    {
        $c_rule = new RewardPage;
        $c_rule->c_rule = $req->c_rule;
        $c_rule->type = 1;
        $c_rule->save();
        return back();
    }
    public function store_lvl_req(Request $req)
    {
        $c_rule = new RewardPage;
        $c_rule->level_req = $req->level_req;
        $c_rule->level_1 = $req->level_1;
        $c_rule->level_2 = $req->level_2;
        $c_rule->level_3 = $req->level_3;
        $c_rule->level_4 = $req->level_4;
        $c_rule->level_5 = $req->level_5;
        $c_rule->type = 2;
        $c_rule->save();
        return back();
    }
    public function delete_c_rules($id)
    {
        RewardPage::find($id)->delete();
        return back();
    }
    public function delete_l_req($id)
    {
        RewardPage::find($id)->delete();
        return back();
    }
    public function manage_winners($id)
    {
        if ($id) {

            $pageTitle = 'Choose Winners';
            $winners = RaffleGameSetting::where('raffle_game_id', $id)->with('user')->with('raffle_game')->get();
            $raffle = RaffleGame::findorfail($id); 
            $users = RaffleTicket::groupBy('user_id')->where('raffle_game_id', $raffle->id)->get();
            return view('admin.raffle.manage_winners', compact('pageTitle', 'winners', 'raffle', 'users'));

        }else{
            return redirect()->route('admin.raffle.index');
        }
        
    }
    public function delete_winner($id)
    {
        $del = RaffleGameSetting::where('id', $id)->delete();
        if ($del) {
            $notify[] = ['success', 'Deleted Successfully'];
            return back()->withNotify($notify);
        }else{
            $notify[] = ['error', 'Something went wrong please try again'];
            return back()->withNotify($notify);
        }
    }
    public function store_winners(Request $req, $id)
    {
        if ($id) {
            $req->validate([
            'user'  => 'required',
            ]);
            $set = new RaffleGameSetting;
            $set->user_id = $req->user;
            $set->raffle_game_id = $id;
            $set->winning_position = $req->winning_position;
            if ($req->blocked_position == 0) {
                $set->blocked_position = -1;
            }else{
                $set->blocked_position = $req->blocked_position;
            }
            
            
            if ($set->save()) {
                $notify[] = ['success', 'Saved Successfully'];
                return redirect()->route('admin.raffle.manage_winners', ['id' => $id])->withNotify($notify);
            }else{
                $notify[] = ['error', 'Something went wrong please try again'];
                return back()->withNotify($notify);
            }
        }else{
            abort(404, "Not Found");
        }
        
    }
    public function dashboard()
    {

        $pageTitle = 'Dashboard';

        // User Info
        $widget['total_users'] = User::count();
        $widget['verified_users'] = User::where('status', 1)->count();
        $widget['email_unverified_users'] = User::where('ev', 0)->count();
        $widget['sms_unverified_users'] = User::where('sv', 0)->count();

        $winners = Winner::get(['amo']);
        $widget['winners'] = $winners->count();
        $widget['winAmount'] = $winners->sum('amo');

        $sell = Bid::get(['invest']);
        $widget['bid'] = $sell->count();
        $widget['bidAmount'] = $sell->sum(['invest']);

        // Monthly Deposit & Withdraw Report Graph
        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);
        $report['withdraw_month_amount'] = collect([]);


        $depositsMonth = Deposit::where('created_at', '>=', Carbon::now()->subYear())
            ->where('status', 1)
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $depositsMonth->map(function ($depositData) use ($report) {
            $report['months']->push($depositData->months);
            $report['deposit_month_amount']->push(showAmount($depositData->depositAmount));
        });
        $withdrawalMonth = Withdrawal::where('created_at', '>=', Carbon::now()->subYear())->where('status', 1)
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();
        $withdrawalMonth->map(function ($withdrawData) use ($report){
            if (!in_array($withdrawData->months,$report['months']->toArray())) {
                $report['months']->push($withdrawData->months);
            }
            $report['withdraw_month_amount']->push(showAmount($withdrawData->withdrawAmount));
        });

        $months = $report['months'];

        for($i = 0; $i < $months->count(); ++$i) {
            $monthVal      = Carbon::parse($months[$i]);
            if(isset($months[$i+1])){
                $monthValNext = Carbon::parse($months[$i+1]);
                if($monthValNext < $monthVal){
                    $temp = $months[$i];
                    $months[$i]   = Carbon::parse($months[$i+1])->format('F-Y');
                    $months[$i+1] = Carbon::parse($temp)->format('F-Y');
                }else{
                    $months[$i]   = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }

        // Withdraw Graph
        $withdrawal = Withdrawal::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->where('status', 1)
            ->selectRaw('sum(amount) as totalAmount')
            ->selectRaw('DATE(created_at) day')
            ->groupBy('day')->get();

        $withdrawals['per_day'] = collect([]);
        $withdrawals['per_day_amount'] = collect([]);
        $withdrawal->map(function ($withdrawItem) use ($withdrawals) {
            $withdrawals['per_day']->push(date('d M', strtotime($withdrawItem->day)));
            $withdrawals['per_day_amount']->push($withdrawItem->totalAmount + 0);
        });


        // Deposit Graph
        $deposit = Deposit::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->where('status', 1)
            ->selectRaw('sum(amount) as totalAmount')
            ->selectRaw('DATE(created_at) day')
            ->groupBy('day')->get();
        $deposits['per_day'] = collect([]);
        $deposits['per_day_amount'] = collect([]);
        $deposit->map(function ($depositItem) use ($deposits) {
            $deposits['per_day']->push(date('d M', strtotime($depositItem->day)));
            $deposits['per_day_amount']->push($depositItem->totalAmount + 0);
        });


        // user Browsing, Country, Operating Log
        $userLoginData = UserLogin::where('created_at', '>=', \Carbon\Carbon::now()->subDay(30))->get(['browser', 'os', 'country']);

        $chart['user_browser_counter'] = $userLoginData->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_os_counter'] = $userLoginData->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_country_counter'] = $userLoginData->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);


        $payment['total_deposit_amount'] = Deposit::where('status',1)->sum('amount');
        $payment['total_deposit_charge'] = Deposit::where('status',1)->sum('charge');
        $payment['total_deposit_pending'] = Deposit::where('status',2)->count();

        $paymentWithdraw['total_withdraw_amount'] = Withdrawal::where('status',1)->sum('amount');
        $paymentWithdraw['total_withdraw_charge'] = Withdrawal::where('status',1)->sum('charge');
        $paymentWithdraw['total_withdraw_pending'] = Withdrawal::where('status',2)->count();
        return view('admin.dashboard', compact('pageTitle', 'widget', 'report', 'withdrawals', 'chart','payment','paymentWithdraw','depositsMonth','withdrawalMonth','months','deposits'));
    }


    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);
        $user = Auth::guard('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, imagePath()['profile']['admin']['path'], imagePath()['profile']['admin']['size'], $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password do not match !!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return redirect()->route('admin.password')->withNotify($notify);
    }

    public function notifications(){
        $notifications = AdminNotification::orderBy('id','desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('admin.notifications',compact('pageTitle','notifications'));
    }


    public function notificationRead($id){
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }

    public function requestReport()
    {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $url = "https://license.viserlab.com/issue/get?".http_build_query($arr);
        $response = json_decode(curlContent($url));
        if ($response->status == 'error') {
            return redirect()->route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports',compact('reports','pageTitle'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type'=>'required|in:bug,feature',
            'message'=>'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = json_decode(curlPostContent($url,$arr));
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success',$response->message];
        return back()->withNotify($notify);
    }

    public function systemInfo(){
        $laravelVersion = app()->version();
        $serverDetails = $_SERVER;
        $currentPHP = phpversion();
        $timeZone = config('app.timezone');
        $pageTitle = 'System Information';
        return view('admin.info',compact('pageTitle', 'currentPHP', 'laravelVersion', 'serverDetails','timeZone'));
    }

    public function readAll(){
        AdminNotification::where('read_status',0)->update([
            'read_status'=>1
        ]);
        $notify[] = ['success','Notifications read successfully'];
        return back()->withNotify($notify);
    }

    //Bids
    public function bids(){
        $search = request()->search;
        if ($search){
            $pageTitle = "Search result for {{$search}}";
            $bids = Bid::with(['user','phase','chooses','game'])->whereHas('user', function ($q) use ($search){
                $q->where('username', $search);
            })->orWhereHas('game', function ($query) use ($search){
                $query->where('name', $search);
            })->latest('id')->paginate(getPaginate());
            return view('admin.bids',compact('bids','pageTitle', 'search'));
        }

        $pageTitle = "Bids";
        $bids = Bid::with(['user','phase','chooses','game'])->latest('id')->paginate(getPaginate());
        return view('admin.bids',compact('bids','pageTitle'));
    }

    //Referral
    public function refIndex()
    {
        $pageTitle = 'Manage Referral';
        $trans = Referral::get();
        return view('admin.refer',compact('pageTitle', 'trans'));
    }

    public function refStore(Request $request)
    {
        $this->validate($request, [
            'level*' => 'required|integer|min:1',
            'percent*' => 'required|numeric',
            'commission_type' => 'required',
        ]);
        Referral::where('commission_type',$request->commission_type)->delete();
        for ($a = 0; $a < count($request->level); $a++){
            Referral::create([
                'level' => $request->level[$a],
                'percent' => $request->percent[$a],
                'commission_type' => $request->commission_type,
                'status' => 1,
            ]);
        }
        $notify[] = ['success', 'Create Successfully'];
        return back()->withNotify($notify);
    }

    public function referralStatusUpdate($type)
    {
        $general_setting = GeneralSetting::first();
        if (@$general_setting->$type == 1) {
            @$general_setting->$type = 0;
            $general_setting->save();
        }elseif(@$general_setting->$type == 0){
            @$general_setting->$type = 1;
            $general_setting->save();
        }else{
            $notify[] = ['error', 'Something Wrong'];
            return back()->withNotify($notify);
        }
        $notify[] = ['success', 'Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function settingUpdate(Request $request){
        $gnl = GeneralSetting::first();
        $gnl->update([
            'dc' => $request->dc ? 1 : 0,
            'wc' => $request->wc ? 1 : 0,
            'ic' => $request->ic ? 1 : 0,
        ]);
        $notify[] = ['success','Updated Successfully'];
        return back()->withNotify($notify);
    }

    //Commission log
    public function commissionLog()
    {
        $pageTitle = 'Referral Commission Log';
        $commissionLog = CommissionLog::orderBy('id','desc')->with(['userFrom','userTo'])->paginate(getPaginate());
        return view('admin.commissionLog', compact('pageTitle', 'commissionLog'));
    }
}
