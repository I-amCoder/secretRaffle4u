<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RaffleGame;
use App\Models\ScratchGame;
use App\Models\ScratchCategory;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\RaffleCategory;
use App\Models\WithdrawMethod;
use App\Rules\FileTypeValidate;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Lib\Helper;
use DB;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    // junaid start
    public function wallet()
    {
        $pageTitle = 'Wallet';
        return view($this->activeTemplate . 'user.wallet', compact('pageTitle'));
    }
    // junaid end

    public function home()
    {
        if (!Session::get('currency')) {
            session()->put('currency', 'THB');
            session()->put('currency_symbol', '฿');
        }
        $pageTitle = 'Dashboard';
        $phases = \App\Models\Phase::where('status', 1)->where('draw_status', 0)->where('start_date', '<', Carbon::now()->toDateTimeString())->where('end_date', '>', Carbon::now()->toDateTimeString())->orderBy('id', 'desc')->limit(6)->with('game')->get();

        $raffle_cat = RaffleCategory::where('status', 1)->orderBy('id', 'asc')->get();
        $raffles    = RaffleGame::where('status', 1)->where('show', 1)->orderBy('category_id')->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'phases', 'raffle_cat', 'raffles'));
    }
    public function raffledraw()
    {
        $pageTitle = 'Raffle Draw';
        $phases = \App\Models\Phase::where('status', 1)->where('draw_status', 0)->where('start_date', '<', Carbon::now()->toDateTimeString())->where('end_date', '>', Carbon::now()->toDateTimeString())->orderBy('id', 'desc')->limit(6)->with('game')->get();

        $raffle_cat = RaffleCategory::where('status', 1)->orderBy('id', 'asc')->get();
        $raffles    = RaffleGame::where('status', 1)->where('show', 1)->orderBy('category_id')->get();

        return view($this->activeTemplate . 'user.raffle_draw', compact('pageTitle', 'phases', 'raffle_cat', 'raffles'));
    }

    public function profile()
    {

        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required' => 'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }
    public function raffle_tickets()
    {
        $pageTitle = 'Raffle Tickets';
        $emptyMessage = 'No Ticket found.';
        // $id = auth()->user()->raffle_tickets;
        // dd($id);

        $logs = auth()->user()->raffle_tickets()->with(['raffle_game'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.mytickets', compact('pageTitle', 'emptyMessage', 'logs'));
    }
    public function my_scratch_cards()
    {
        $pageTitle = 'Scratch Cards';
        $emptyMessage = 'No Scratch Card found.';
        // $id = auth()->user()->raffle_tickets;
        // dd($id);
        $logs = auth()->user()->scratch_cards()->with(['scratch_game'])->orderBy('id', 'desc')->get();
        $free_silver_actv = DB::table('scratch_game_tickets')->where('purchase_user_id', auth()->user()->id)
            ->where('scratch_game_id', 3)->where('status', 1)->count();
        $free_silver = DB::table('scratch_game_tickets')->where('purchase_user_id', auth()->user()->id)
            ->where('scratch_game_id', 3)->count();
        $free_gold_actv = DB::table('scratch_game_tickets')->where('purchase_user_id', auth()->user()->id)
            ->where('scratch_game_id', 4)->where('status', 1)->count();
        $free_gold = DB::table('scratch_game_tickets')->where('purchase_user_id', auth()->user()->id)
            ->where('scratch_game_id', 4)->count();
        // dd($logs);
        return view($this->activeTemplate . 'user.myscratch', compact('pageTitle', 'free_gold', 'free_gold_actv', 'free_silver', 'free_silver_actv', 'emptyMessage', 'logs'));
    }
    public function my_scratch_wins()
    {
        $pageTitle = 'Scratch Winnings';
        $emptyMessage = 'No winning found.';
        // $id = auth()->user()->raffle_tickets;
        // dd($id);
        $logs = auth()->user()->scratch_card_wins()->with(['scratch_game'])->orderBy('id', 'desc')->get();
        // dd($logs->rafflewins);
        return view($this->activeTemplate . 'user.myscratchwins', compact('pageTitle', 'emptyMessage', 'logs'));
    }
    public function rafflewins()
    {
        $pageTitle = 'Raffle Winnings';
        $emptyMessage = 'No winning found.';
        // $id = auth()->user()->raffle_tickets;
        // dd($id);
        $logs = auth()->user()->rafflewins()->with(['raffle_game'])->orderBy('id', 'desc')->paginate(getPaginate());
        // dd($logs->rafflewins);
        return view($this->activeTemplate . 'user.mywins', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status', 1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate . 'user.withdraw.methods', compact('pageTitle', 'withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id', 'desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle', 'withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id', 'desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg', 'jpeg', 'png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user, $request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['withdraw']['path'] . '/' . $directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        $emptyMessage = "No Data Found!";
        return view($this->activeTemplate . 'user.withdraw.log', compact('pageTitle', 'withdraws', 'emptyMessage'));
    }



    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function bids()
    {
        $pageTitle = 'Your Bids';
        $bids = auth()->user()->bids()->with(['game', 'phase', 'chooses'])->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No Bid Found';
        return view(activeTemplate() . 'user.bids', compact('pageTitle', 'bids', 'empty_message'));
    }

    public function wins()
    {
        $pageTitle = 'Win';
        // $wins = auth()->user()->wins()->with('phase')->latest()->paginate(getPaginate());
        $user_id = Auth::id();
        $raffle_wins = DB::table('raffle_tickets')
            ->select('raffle_tickets.*', 'raffle_games.title')
            ->where('raffle_tickets.user_id', $user_id)
            ->where('raffle_tickets.winning_position', '>', 0)
            ->join('raffle_games', 'raffle_tickets.raffle_game_id', '=', 'raffle_games.id')
            ->orderBy('raffle_tickets.id', 'ASC')->paginate(getPaginate());
        $scratch_wins = DB::table('scratch_game_tickets')
            ->select('scratch_game_tickets.*', 'scratch_games.title')
            ->join('scratch_games', 'scratch_game_tickets.scratch_game_id', '=', 'scratch_games.id')
            ->where('scratch_game_tickets.purchase_user_id', $user_id)
            ->where('scratch_game_tickets.winning_price', '>', 0)
            ->orderBy('scratch_game_tickets.id', 'ASC')->paginate(getPaginate());
        // $wins = auth()->user()->wins()->with('phase')->latest()->paginate(getPaginate());
        $empty_message = 'No Wins Found Yet';
        return view(activeTemplate() . 'user.wins', compact('pageTitle', 'raffle_wins', 'scratch_wins', 'empty_message'));
    }

    public function commissions()
    {
        $pageTitle = 'Referral Commissions';
        $commissions = auth()->user()->commissions()->orderBy('id', 'desc')->with('userFrom')->paginate(getPaginate());
        $empty_message = 'No Commissions Found Yet';
        return view(activeTemplate() . 'user.commissions', compact('pageTitle', 'commissions', 'empty_message'));
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $logs = auth()->user()->transactions()->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No transaction history';
        return view(activeTemplate() . 'user.transactions', compact('pageTitle', 'logs', 'empty_message'));
    }

    public function referral()
    {
        $pageTitle = "Referral";
        $empty_message = "Data Not Found";
        $refs = User::where('ref_by', auth()->user()->id)->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.referrals', compact('refs', 'pageTitle', 'empty_message'));
    }

    public function scratch_cards(Request $request)
    {
        $pageTitle = "Scratch cards";
        $phases = \App\Models\Phase::where('status', 1)->where('draw_status', 0)->where('start_date', '<', Carbon::now()->toDateTimeString())->where('end_date', '>', Carbon::now()->toDateTimeString())->orderBy('id', 'desc')->limit(6)->with('game')->get();

        $raffle_cat = ScratchCategory::where('status', 1)->orderBy('id', 'asc')->get();
        $raffles    = ScratchGame::where('status', 1)->orderBy('category_id')->get();

        return view($this->activeTemplate . 'user.scratch-cards.scratch-cards', compact('pageTitle', 'raffles', 'raffle_cat', 'phases'));
    }

    public function addWinningPoints(Request $request)
    {
        $data = [
            'status' => 'true',
            'message' => '',
        ];
        if ($user = Auth::user()) {
            $postData = $request->all();
            $userData = User::find($user->id);
            // $user_id = $userData->id;
            $WinnerValue = $postData['WinnerValue'];
            if ($WinnerValue > 0 && $WinnerValue != 'Free Play') {
                $total_amount = $WinnerValue;
                $hlp = new Helper;
                $total_amount = $hlp->convert_to_currency('USD', $total_amount);
                $userData->winnings = $userData->winnings + $total_amount;
                $userData->save();
            } else {
                $data['status'] = 'false';
                $data['message'] = 'Something went wrong!';
            }
        } else {
            $data['status'] = 'false';
            $data['message'] = 'User not logged in!';
        }
        echo json_encode($data);
    }
}
