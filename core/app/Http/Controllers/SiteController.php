<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\RaffleDraw;
use App\Models\Paytable;
use App\Models\RaffleTicket;
use App\Models\RaffleGame;
use App\Models\ScratchGame;
use App\Models\RewardPage;
use App\Models\ScratchCategory;
use App\Models\ScratchGameTicket;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\RaffleCategory;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\SupportAttachment;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Cache;
// use DB;
use Auth;
use Session;
use App\Lib\Helper;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function new_page()
    {
        /*-------assign random tickets to users-------* /
			$game_tickets = DB::table('raffle_tickets')->where('raffle_game_id',54)->get();
			foreach($game_tickets as $key => $item){
				$user_id = rand(1,12);
				DB::table('raffle_tickets')->where('id',$item->id)->update(['user_id'=>$user_id]);
			}
			exit;
		/*-------assign random tickets to users-------*/
        /*-------purchase random tickets-------* /
			$abc = DB::select(DB::raw('SELECT * FROM raffle_game_tickets AS t1
			JOIN (SELECT id FROM raffle_game_tickets WHERE is_booked = 0 ORDER BY RAND() LIMIT 1000) as t2 ON t1.id=t2.id'));
			$array = [];
			foreach($abc as $key => $item){
				$array[] = $item->code;
			}
			echo "<pre>";print_r($array);echo "</pre>";
		/*-------purchase random tickets-------*/
    }
    public function index()
    {
        // if(!Session::get('currency')){
        // session()->put('currency', 'THB');
        // session()->put('currency_symbol', '฿');
        // }
        $count = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->count();
        if ($count == 0) {
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $Scratch    = ScratchGame::where('status', 1)->inRandomOrder()->take(3)->get();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->first();

        $raffle_cat = RaffleCategory::where('status', 1)->where('is_show_on_home_page', 1)->orderBy('id', 'asc')->get();

        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections', 'raffle_cat', 'Scratch'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }


    public function contact(Request $request)
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }
    public function raffleDraw(Request $request)
    {

        $pageTitle  = "Raffle draw";

        if ($request->type) {
            $raffle_cat = RaffleCategory::where('status', 1)->where('id', $request->type)->orderBy('id', 'asc')->get();
            $raffles    = RaffleGame::where('status', 1)->where('show', 1)->orderBy('category_id')->get();
        } else {
            $raffle_cat = RaffleCategory::where('status', 1)->orderBy('id', 'asc')->get();
            $raffles    = RaffleGame::where('status', 1)->where('show', 1)->orderBy('category_id')->get();
        }

        return view($this->activeTemplate . 'page.raffle-draw', compact('pageTitle', 'raffles', 'raffle_cat'));
    }

    public function raffleDrawDetails(Request $request, $id)
    {
        $raffle = RaffleGame::where('id', $id)->first(); //where('status',1)->
        if ($raffle->show == 0) {
            return redirect()->to('/raffle-draw');
        }
        $pageTitle  = "Raffle draw :" . $raffle->title;
        $raffle_cat = RaffleCategory::where('status', 1)->where('id', $raffle->category_id)->first();

        $free_lucky_draw = DB::table('raffle_game_free_lucky_draw')
            ->select('raffle_game_free_lucky_draw.*', 'raffle_game_free_tickets.name as free_ticket_name')
            ->leftJoin('raffle_game_free_tickets', 'raffle_game_free_tickets.id', 'raffle_game_free_lucky_draw.raffle_game_free_ticket_id')
            ->where('raffle_game_free_lucky_draw.raffle_game_id', $id)

            // old
            // ->orderBy('raffle_game_free_lucky_draw.purchased_ticket','asc')
            // new code so table of ticket will show as asc order as per ticket
            ->orderBy('raffle_game_free_lucky_draw.ticket_count', 'asc')
            ->get();



        $winning_seg = DB::table('raffle_game_winning_segments')->where('raffle_game_id', $id)->orderBy('order_id', 'asc')->get();
        $tital_gift_price = DB::table('raffle_game_winning_segments')->where('raffle_game_id', $id)->sum('gift_price');

        $current_time = date('Y-m-d H:i');
        $start_time = $raffle->start_time;
        if (now() > $raffle->end_time) {
            $raffle->end_time = $raffle->next_time;
            $raffle->next_time = null;
            $raffle->save();
        }
        $end_time = $raffle->end_time;

        $total_tickets_sold = RaffleTicket::where('raffle_game_id', $raffle->id)->count();
        // dd($raffle->min_tickets);

        // echo "</pre>";
        // echo "<p>Current time</p>";
        // echo $current_time;
        // echo "<p>Srat time</p>";
        // echo $start_time;
        // echo "<p>End time</p>";
        // echo $end_time;
        // die();
        return view($this->activeTemplate . 'page.raffle-draw-details', compact('total_tickets_sold', 'pageTitle', 'raffle', 'raffle_cat', 'winning_seg', 'tital_gift_price', 'free_lucky_draw'));
    }
    public function buyticket(Request $req, $id)
    {
        if ($id) {
            $req->validate([
                'tickets' => 'int|required',
            ]);
            $free_lucky_draw = DB::table('raffle_game_free_lucky_draw')
                ->select('raffle_game_free_lucky_draw.*', 'raffle_game_free_tickets.name as free_ticket_name')
                ->leftJoin('raffle_game_free_tickets', 'raffle_game_free_tickets.id', 'raffle_game_free_lucky_draw.raffle_game_free_ticket_id')
                ->where('raffle_game_free_lucky_draw.raffle_game_id', $id)
                ->where('raffle_game_free_lucky_draw.ticket_count', $req->tickets)

                // old
                // ->orderBy('raffle_game_free_lucky_draw.purchased_ticket','asc')

                // new code so table of ticket will show as asc order as per ticket
                ->orderBy('raffle_game_free_lucky_draw.ticket_count', 'asc')

                ->first();
            if ($free_lucky_draw) {
                $raffle_game = RaffleGame::where('id', $id)->first();
                if (!$raffle_game) {
                    $notify[] = ['error', 'Something went wrong please try again'];
                    return redirect()->back()->withNotify($notify);
                    exit;
                }
                // dd($free_lucky_draw);
                $tickets = $req->tickets;
                $free_offers = DB::table('raffle_game_free_lucky_draw')->where('raffle_game_id', $raffle_game->id)->where('ticket_count', $tickets)->first();
                // $total_amount = $free_offers->ticket_amount * $tickets;
                $total_amount = $free_offers->ticket_amount;
                $hlp = new Helper;
                $total_amount = $hlp->convert_to_currency('USD', $total_amount);
                if ($total_amount > auth()->user()->balance) {
                    $notify[] = ['error', 'Insufficient Balance'];
                    return redirect()->back()->withNotify($notify);
                    exit;
                }




                // $check_tickets = DB::table('raffle_game_tickets')->where('raffle_game_id', $raffle_game->id)->where('is_booked', 0)->count();
                $check_tickets = DB::select(DB::raw('SELECT * FROM raffle_game_tickets AS t1 JOIN (SELECT id FROM raffle_game_tickets WHERE is_booked = 0 AND raffle_game_id = ' . $raffle_game->id . ' ORDER BY RAND() LIMIT ' . $tickets . ') as t2 ON t1.id=t2.id'));
                // dd($ticket_numbers);
                if (count($check_tickets) < $tickets) {
                    $notify[] = ['error', 'Ticket Limit Exeeded'];
                    return redirect()->back()->withNotify($notify);
                    exit;
                }
                // if (empty($max_ticket_no)) {
                //     $max_ticket_no = 1;
                // }
                $balance = auth()->user()->balance - $total_amount;
                // echo $max_ticket_no; exit;
                // echo $this->ticket_no($raffle_game->id, $raffle_game->total_tickets); exit;
                $insert_batch = [];
                foreach ($check_tickets as $key => $item) {
                    $insert_array = [
                        'user_id' => auth()->user()->id,
                        'raffle_game_id' => $id,
                        'amount' => $total_amount,
                        'ticket_no' => $item->ticket_no,
                        'ticket_code' => $item->code,
                    ];
                    $insert_batch[] = $insert_array;
                    DB::table('raffle_game_tickets')->where('id', $item->id)->update(['is_booked' => 1]);
                }
                RaffleTicket::insert($insert_batch);

                if ($raffle_game->min_tickets_status == 0) {
                    $total_tickets = $raffle_game->total_tickets;
                    $purchased_tickets = DB::table('raffle_tickets')->where('raffle_game_id', $raffle_game->id)->count();
                    $percent = ($purchased_tickets / $total_tickets) * 100;
                    if ($percent >= 10) {
                        RaffleGame::where('id', $raffle_game->id)->update(['min_tickets_status' => 1]);
                        DB::table('scratch_game_tickets')->where('raffle_game_id', $raffle_game->id)->update(['status' => 1]);
                        $raffle_game->min_tickets_status = 1;
                    }
                }

                // for ($i=0; $i <= $tickets; $i++) {

                // }
                User::where('id', auth()->user()->id)->update(['balance' => $balance]);

                // dd($raffle_game);

                if ($free_offers) {
                    $free_scratch_cards = $free_offers->free_scratch_cards;

                    if ($raffle_game->category->name == "Weekly" || $raffle_game->category->name == "Daily") {
                        $scratch_type = 'silver';
                        $scratch_game = 3;
                    } elseif ($raffle_game->category->name == "Monthly" || $raffle_game->category->name == "Yearly") {
                        $scratch_type = 'gold';
                        $scratch_game = 4;
                    } else {
                        $scratch_type = 'silver';
                        $scratch_game = 3;
                    }
                    for ($j = 0; $j < $free_scratch_cards; $j++) {
                        $scratch_insert = array();
                        $scratch_insert['raffle_game_id'] = $raffle_game->id;
                        $scratch_insert['scratch_category_id'] = 1;
                        $scratch_insert['scratch_game_id'] = $scratch_game;
                        $scratch_insert['status'] = ($raffle_game->min_tickets_status == 0) ? 2 : 1;
                        $scratch_insert['scratch_type'] = $scratch_type;
                        $scratch_insert['purchase_user_id'] = auth()->user()->id;
                        DB::table('scratch_game_tickets')->insert($scratch_insert);
                    }
                }

                $notify[] = ['success', 'Tickets Purchased Successfully'];
                return redirect()->back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Something went wrong please try again'];
                return redirect()->back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'Something went wrong please try again'];
            return redirect()->back()->withNotify($notify);
        }
    }
    public function ticket_no($game_id, $max)
    {

        $min = 1;
        $no = rand($min, $max);
        $check = DB::table('raffle_tickets')->where('raffle_game_id', $game_id)->where('ticket_code', $no)->get();
        if (count($check) > 0) {
            $no = $this->ticket_no($game_id, $max);
        }
        return $no;
    }
    public function raffleDrawFree(Request $request)
    {
        $pageTitle = "Scratch cards";
        return view($this->activeTemplate . 'page.raffle-draw-details-free', compact('pageTitle'));
    }

    public function scratchcards(Request $request)
    {
        $pageTitle = "Scratch cards";
        if ($request->type) {
            $raffle_cat = ScratchCategory::where('status', 1)->where('id', $request->type)->orderBy('id', 'asc')->get();
            $raffles    = ScratchGame::where('status', 1)->orderBy('category_id')->get();
        } else {
            $raffle_cat = ScratchCategory::where('status', 1)->orderBy('id', 'asc')->get();
            $raffles    = ScratchGame::where('status', 1)->orderBy('category_id')->get();
        }

        return view($this->activeTemplate . 'page.scratch-cards', compact('pageTitle', 'raffles', 'raffle_cat'));
    }


    public function lottery(Request $request)
    {
        $pageTitle = "International Lottery";
        return view($this->activeTemplate . 'page.lottery', compact('pageTitle'));
    }

    public function rewards(Request $request)
    {
        $pageTitle = "Rewards";
        $c_rules = RewardPage::where('type', 1)->get();
        $level_req = RewardPage::where('type', 2)->get();
        return view($this->activeTemplate . 'page.rewards', compact('pageTitle', 'c_rules', 'level_req'));
    }

    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->check() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function cookieAccept()
    {
        $cookie = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        session()->put('cookie_accepted', true);

        return response(['success' => 'Cookie accepted successfully']);
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function links($id, $slug)
    {
        // echo "here";exit;
        $link = Frontend::where('id', $id)->where('data_keys', 'extra.element')->firstOrFail();
        // echo "<pre>";print_r($link);echo "</pre>";exit;
        if (empty($link)) {
            return redirect();
        }
        $pageTitle = $link->data_values->title;
        return view($this->activeTemplate . 'links', compact('link', 'pageTitle'));
    }

    public function downloadAndroidApp(Request $req)
    {
        return view(activeTemplate() . 'download-app');
    }

    public function exchange_rate(Request $req)
    {
        // $helpers = new Helper();
        // $currencies = $helpers->get_currency_rates();
        // echo "<pre>";print_r($currencies);echo "</pre>";exit;
        $abc = DB::table('currency_rates')->orderBy('id', 'DESC')->first();
        // echo "<pre>";print_r(json_decode($abc->rates));echo "</pre>";exit;
        // echo "<pre>";print_r($abc);echo "</pre>";exit;

        $pkr_rates = json_decode(file_get_contents('https://v6.exchangerate-api.com/v6/78a6747b51e1b9b498c3728e/latest/THB'));
        $datetime = date('Y-m-d', $pkr_rates->time_last_update_unix);
        $rates = json_encode($pkr_rates->conversion_rates);
        $insert_array = [
            'date' => $datetime,
            'rates' => $rates,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('currency_rates')->insert($insert_array);
        // echo "<pre>";print_r($pkr_rates);echo "</pre>";exit;
    }
    public function changeCurrency($currency = NULL)
    {
        if ($currency == NULL) {
            $currency = 'THB';
        }
        $symbolData = DB::table('currencies')->where('code', $currency)->first();
        session()->put('currency', $currency);
        session()->put('currency_symbol', $symbolData->symbol);
        return redirect()->back();
    }
    public function scratchcards_game(Request $req, $id = NULL)
    {
        $userData = $tickets = [];
        $play = 'no';
        $pageTitle = "Scratch Card";
        $data = ScratchGame::with('paytable')->find($id);
        /**/
        if ($userData = Auth::user()) {
            $tickets = ScratchGameTicket::where('purchase_user_id', $userData->id)->where('scratch_game_id', $id)->where('status', 1)->get();
            // echo "<pre>";print_r($tickets);echo "</pre>";exit;
            if (isset($req->play)) {
                $play = 'yes';
                if (count($tickets) > 0) {
                    // echo "here";exit;
                    // $first_ticket = ScratchGameTicket::where('purchase_user_id', $userData->id)->where('scratch_game_id', $id)->where('status', 1)->first();
                    // ScratchGameTicket::where('id',$tickets[0]->id)->update(['status' => 0]);
                    // $tickets = ScratchGameTicket::where('purchase_user_id', $userData->id)->where('scratch_game_id', $id)->where('status', 1)->get();
                } else {
                    $notify[] = ['error', 'Buy more tickets!'];
                    return redirect()->route('scratch_cards_game', ['id' => $data->id])->withNotify($notify);
                }
            }
            // echo "<pre>";print_r($tickets);echo "</pre>";exit;
            // Session::flush();
            // Session::forget('scratch-game-'.$data->id);exit;

            if (!Session::has('scratch-game-' . $data->id)) {
                $session_array = [];
                foreach ($data->paytable()->get() as $key => $val) {
                    $session_array['scratch-game-' . $data->id][$val->amount] = 0;
                }
                Session::put($session_array);
            }
        }

        // echo "<pre>";print_r(Session::all());echo "</pre>";exit;
        // $tickets = [1,2,3,4,5];$play = 'yes';
        return view(activeTemplate() . 'user.scratch-cards.game', compact('pageTitle', 'data', 'tickets', 'play', 'userData'));
    }

    public function buyscratchticket(Request $req, $id = NULL)
    {
        // echo "<pre>";print_r($req->all());echo "</pre>";exit;
        if (Auth::user()) {
            $userData = User::find(Auth::id());
            // echo "<pre>";print_r($userData);echo "</pre>";exit;
            if ($id != NULL) {
                $req->validate([
                    'unit_price' => 'required',
                    'tickets' => 'required',
                ]);
                $scratchData = ScratchGame::find($id);
                // echo "<pre>";print_r($scratchData);echo "</pre>";exit;
                if (!empty($scratchData)) {
                    $tickets = $req->tickets;
                    // $total_amount = $scratchData->unit_price * $tickets;
                    // // echo "<pre>";print_r($total_amount);echo "</pre>";//exit;
                    // if ($total_amount > $userData->balance) {
                    // 	$notify[] = ['error', 'Insufficient Balance'];
                    // 	return redirect()->route('user.wallet')->withNotify($notify);
                    // 	exit;
                    // }
                    // $balance = $userData->balance - $total_amount;
                    $total_amount = $scratchData->unit_price * $tickets;
                    $hlp = new Helper;
                    $total_amount = $hlp->convert_to_currency('USD', $total_amount);
                    if ($total_amount > auth()->user()->balance) {
                        $notify[] = ['error', 'Insufficient Balance'];
                        return redirect()->back()->withNotify($notify);
                        exit;
                    }
                    $balance = $userData->balance - $total_amount;
                    // echo "<pre>";print_r($balance);echo "</pre>";exit;
                    User::where('id', $userData->id)->update(['balance' => $balance]);
                    for ($i = 1; $i <= $req->tickets; $i++) {
                        $query = new ScratchGameTicket;
                        $query->purchase_user_id = Auth::id();
                        $query->purchase_at = date('Y-m-d H:i:s');
                        $query->scratch_category_id = $scratchData->category_id;
                        $query->scratch_game_id = $id;
                        $query->status = 1;
                        $query->unit_price = $scratchData->unit_price;
                        $query->created_at = date('Y-m-d H:i:s');
                        $query->updated_at = date('Y-m-d H:i:s');
                        $query->created_by = Auth::id();
                        $query->updated_by = Auth::id();
                        $query->is_booked = 1;
                        $query->save();
                    }
                    $notify[] = ['success', 'Tickets Purchased Successfully'];
                    return redirect()->route('scratch_cards_game', ['id' => $scratchData->id])->withNotify($notify);
                } else {
                    $notify[] = ['error', 'Something went wronf please try again'];
                    return redirect()->back()->withNotify($notify);
                }
            } else {
                $notify[] = ['error', 'Something went wronf please try again'];
                return redirect()->back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'Please login'];
            return redirect()->route('login')->withNotify($notify);
        }
    }
}
