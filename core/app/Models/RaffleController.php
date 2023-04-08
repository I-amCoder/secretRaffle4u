<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailLog;
use App\Models\UserLogin;
use App\Models\RaffleGame;
use App\Models\RaffleTicket;
use App\Models\ScratchGame;
use App\Models\Paytable;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon;

class RaffleController extends Controller
{
    protected $raffle;
    public function __construct(RaffleGame $raffle)
    {
        $this->raffle     = $raffle;
    }

    public function draw_winners()
    {
        $time = Carbon\Carbon::now()->addHours(2);
        $end_time=$time->toDateTimeString();
        $games = RaffleGame::where('end_time', '<', $end_time)->where('status', 1)->where('draw_status', 0)->get();
        foreach ($games as $key => $game) {
            if (1) {

                // min tickets completed
                $assigned_positions = array();
                // dd($game->winning_positions);
                foreach ($game->winning_positions as $key => $winner) {
                    // echo "ass"; exit;
                    // dd($winner);
                    $winning_ticket = RaffleTicket::where('user_id', $winner->user->id)
                    ->where('raffle_game_id', $game->id)
                    // ->where(function ($query) use ($winner) {
                    //     $query->where('winning_position', null)
                    //           ->orWhere('winning_position', '!=', $winner->winning_position);
                    // })
                    ->where('winning_position', null)
                    // ->where('winning_position', '!=', $winner->winning_position)
                    ->inRandomOrder()->first();
                    if ($winning_ticket) {
                        $winning_ticket->winning_position = $winner->winning_position;
                        $winning_ticket->save();
                        $assigned_positions[]=$winner->winning_position;
                    }


                }
                foreach ($game->blocked_positions as $key => $blocked) {
                    if ($blocked->blocked_position == 0) {
                        RaffleTicket::where('user_id', $blocked->user->id)
                        ->where('raffle_game_id', $game->id)
                        ->where('blocked_position', 0)
                        ->update(['blocked_position'=> -1]);
                    }else{
                        RaffleTicket::where('user_id', $blocked->user->id)
                        ->where('raffle_game_id', $game->id)
                        ->where('blocked_position', 0)
                        ->update(['blocked_position'=>$blocked->blocked_position]);
                    }
                }

                $raffle_game_winning_segments = DB::table('raffle_game_winning_segments')->where('raffle_game_id', $game->id)->get();
                foreach ($raffle_game_winning_segments as $key => $segment) {
                    if ($segment->type == 1) {

                        if (in_array($segment->position,$assigned_positions)) {
                            RaffleTicket::where('winning_position', $segment->position)
                            ->where('raffle_game_id', $game->id)
                            ->update(['winning_price' => $segment->gift_price]);
                            continue;
                        }else{

                            $winner_segment =  RaffleTicket::whereNotIn('blocked_position',[$segment->position,-1])
                            ->where('raffle_game_id', $game->id)
                            ->whereNull('winning_position')
                            ->inRandomOrder()->first();
							// echo "<pre>";print_r($winner_segment);echo "</pre>";exit;
                            if ($winner_segment) {
                                RaffleTicket::where('id', $winner_segment->id)
                                ->update(['winning_position' => $segment->position, 'winning_price' => $segment->gift_price]);
                            }


                        }
                    }elseif ($segment->type == 2) {
                        // dd($segment);
                        for ($i=$segment->position; $i <= $segment->position_end ; $i++) {
                            // echo $i;
                            if (in_array($i,$assigned_positions)) {
                                RaffleTicket::where('winning_position', $i)
                                ->where('raffle_game_id', $game->id)
                                ->update(['winning_price' => $segment->gift_price]);
                                continue;
                            }else{
                                $winner_segment =  RaffleTicket::whereNotIn('blocked_position',[$i,-1])
                                ->where('raffle_game_id', $game->id)
                                ->whereNull('winning_position')
                                ->inRandomOrder()->first();
                                // dd($winner_segment);
                                $upd = array();
                                if ($winner_segment) {
                                    $upd['winning_position'] = $i;
                                    $upd['winning_price'] = $segment->gift_price;
                                    RaffleTicket::where('id', $winner_segment->id)
                                    ->update($upd);
                                }
                            }

                        }
                    }
                }
            }else{
                // min tickets not completed

            }
        }
        // dd($games);
    }
    public function winning_deposit($user_id, $raffle_id, $position, $amount)
    {

    }
    public function index(Request $request)
    {
        $pageTitle = 'Raffle Game';
        $raffles = $this->raffle->with('category')->orderBy('category_id','asc')->paginate(getPaginate());
        $emptyMessage = 'No raffle game.';
        return view('admin.raffle.index', compact('pageTitle', 'raffles', 'emptyMessage'));
    }


    public function create(Request $request)
    {
        $pageTitle = 'Raffle Create';
        $raffles = RaffleGame::orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No raffle game.';
        $category = DB::table('raffle_categories')->where('status',1)->orderBy('id','asc')->get();
        $free_ticket = DB::table('raffle_game_free_tickets')->where('status',1)->orderBy('name','asc')->get();
        return view('admin.raffle.create', compact('pageTitle', 'raffles', 'emptyMessage','category','free_ticket'));
    }


    public function freeOffer(Request $request, $id)
    {
        $raffle = RaffleGame::find($id);

        $pageTitle = 'Free offer for: '.$raffle->title;
        $emptyMessage = 'No offer yet.';

        $free_tickets = DB::table('raffle_game_free_ticket_map')
        ->select('raffle_game_free_ticket_map.raffle_game_id','raffle_game_free_tickets.name as ticket_name','raffle_game_free_ticket_map.raffle_game_free_ticket_id')
        ->where('raffle_game_free_ticket_map.raffle_game_id',$id)
        ->leftJoin('raffle_game_free_tickets','raffle_game_free_tickets.id','raffle_game_free_ticket_map.raffle_game_free_ticket_id')
        ->get();

        // old code
        // $free_ticket_sets = DB::table('raffle_game_free_lucky_draw')->where('raffle_game_id',$id)->groupBy('purchased_ticket')->get();

        $free_ticket_sets = DB::table('raffle_game_free_lucky_draw')->where('raffle_game_id',$id)->get();

        return view('admin.raffle.free_offer', compact('pageTitle', 'emptyMessage', 'free_tickets','raffle','free_ticket_sets'));
    }



    public function freeOfferStore(Request $request, $id){

        DB::table('raffle_game_free_lucky_draw')->insert([
            'is_free_ticket'    => 1,
            'raffle_game_id'    => $request->raffle_game_id,
            // 'raffle_game_free_ticket_id' => $request->raffle_game_free_ticket_id[$key] ?? null,
            'ticket_count' => $request->ticket_count,
            'ticket_amount' => $request->ticket_amount,
            'free_scratch_cards' => $request->free_scratch_cards,
            'lucky_draw_text_line_one' => $request->lucky_draw_text_line_one,
            'lucky_draw_text_line_two' => $request->lucky_draw_text_line_two,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => Auth::id(),

        ]);

        // $request->validate([
        //     'purchased_ticket'  => 'required',
        //     'free_ticket.*'       => 'required',
        // ]);

        // DB::beginTransaction();
        // try {

        //     if($request->free_ticket){
        //         foreach ($request->free_ticket as $key => $value) {

        //             DB::table('raffle_game_free_lucky_draw')->insert([
        //                 'is_free_ticket'    => 1,
        //                 'raffle_game_id'    => $id,
        //                 'raffle_game_free_ticket_id' => $request->raffle_game_free_ticket_id[$key] ?? null,
        //                 // 'purchased_ticket'  => $request->purchased_ticket,
        //                 // 'free_ticket'       => $value ?? 0,
        //                 'ticket_count' => $request->ticket_count,
        //                 'ticket_amount' => $request->ticket_amount,
        //                 'lucky_draw_text_line_one' => $request->lucky_draw_text_line_one,
        //                 'lucky_draw_text_line_two' => $request->lucky_draw_text_line_two,
        //                 'created_at'        => date('Y-m-d H:i:s'),
        //                 'created_by'        => Auth::id(),

        //             ]);

        //         }
        //     }

        // } catch (\Throwable $th) {
        //     //throw $th;

        //     DB::rollBack();
        //     $notify[] = ['error', 'Free ticket not assigned'];
        //     return redirect()->back()->withNotify($notify);
        // }

        // DB::commit();

        $notify[] = ['success', 'Free ticket assigned'];
        return redirect()->back()->withNotify($notify);

    }


    public function freeOfferUpdate(Request $request, $id){

        DB::table('raffle_game_free_lucky_draw')
        ->where('id',$id)
        ->update([
            'ticket_count' => $request->ticket_count,
            'ticket_amount' => $request->ticket_amount,
            'free_scratch_cards' => $request->free_scratch_cards,
            'lucky_draw_text_line_one' => $request->lucky_draw_text_line_one,
            'lucky_draw_text_line_two' => $request->lucky_draw_text_line_two
        ]);

        return redirect()->back();
    }



    public function freeOfferDelete(Request $request, $id){
        DB::table('raffle_game_free_lucky_draw')->delete($id);
        return redirect()->back();
    }

    public function winningSegmentStore(Request $request, $id){
        $request->validate([
            'gift_type'     => 'required',
            'position'      => 'required',
            'gift_price'      => 'required',
            'order_id'      => 'required',

        ]);

        DB::beginTransaction();
        try {

            if($request->seg){
                DB::table('raffle_game_winning_segments')
                ->where('id',$request->seg)->update([
                    'gift_price'        => $request->gift_price,
                    'type'              => $request->gift_type,
                    'position'          => $request->position,
                    'position_end'      => $request->position_end ?? null,
                    'order_id'          => $request->order_id,
                    'updated_at'        => date('Y-m-d H:i:s'),
                    'updated_by'        => Auth::id(),
                ]);

            }else{
                DB::table('raffle_game_winning_segments')->insert([
                    'raffle_game_id'    => $id,
                    'gift_price'        => $request->gift_price,
                    'type'              => $request->gift_type,
                    'position'          => $request->position,
                    'position_end'      => $request->position_end ?? null,
                    'order_id'          => $request->order_id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'created_by'        => Auth::id(),
                ]);
            }


        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            $notify[] = ['error', 'Winning gift segments not assigned'];
            return redirect()->back()->withNotify($notify);
        }

        DB::commit();
        $notify[] = ['success', 'Winning gift segments assigned'];
        return redirect()->route('admin.winning_segments',$id)->withNotify($notify);

    }



    public function winningSegments(Request $request,$id){

        $raffle = RaffleGame::find($id);
        $pageTitle = 'Winning offer for: '.$raffle->title;
        $emptyMessage = 'No offer yet.';
        $seg = null;
        $gifts = DB::table('raffle_game_winning_segments')->where('raffle_game_id',$id)->orderBy('order_id','asc')->get();
        if($request->mode == 'edit'){
            $seg = DB::table('raffle_game_winning_segments')->where('id',$request->seg)->first();

        }

        return view('admin.raffle.winning_offer', compact('pageTitle', 'emptyMessage', 'gifts','raffle','seg'));
    }

    public function winningSegmentsDelete($id){

        $gift = DB::table('raffle_game_winning_segments')->where('id',$id)->first();
        $raffle = RaffleGame::find($gift->raffle_game_id);
        $current_time = date('Y-m-d H:i:s');
        //Need to check raffle is running
        DB::table('raffle_game_winning_segments')->where('id',$id)->delete();

        $notify[] = ['success', 'Winning gift segments deleted'];
        return redirect()->back()->withNotify($notify);


    }




    public function store(Request $request)
    {
        $request->validate([
            'image'         => 'required',
            'category_id'   => 'required',
            'title'         => 'required',
            'unit_price'    => 'required',
            'total_tickets' => 'required',
            'min_tickets'   => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);



        DB::beginTransaction();
        try {
            $image = null;
            $old = null;

            if ($request->hasFile('image')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];
                $photo = uploadImage($request->image,$path,$size,$old);
                $image  = $photo;
            }
            if($request->status=='on'){
                $status     = 1;
            }else{
                $status     = 0;
            }


            if($request->game_info){
                $raffle_info = json_encode($request->game_info);
            }else{
                $raffle_info = null;
            }


            $raffle_games = DB::table('raffle_games')->insertGetId([
                'photo'         => $image,
                'category_id'   => $request->category_id,
                'title'         => $request->title,
                'game_info'     => $raffle_info,
                'status'         => $status,
                'unit_price'    => $request->unit_price,
                'total_tickets' => $request->total_tickets,
                'min_tickets'   => $request->min_tickets,
                'free_ticket'   => $request->free_ticket,
                'start_time'    => $request->start_time,
                'end_time'      => $request->end_time,
                'bottom_box_input'    => $request->bottom_box_input,
                'bottom_box_input_2'      => $request->bottom_box_input_2,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'      => Auth::id(),
            ]);

            if($request->free_ticket == 1){
                $free_tickets = $request->free_tickets;
                if($free_tickets){
                    foreach ($free_tickets as $key => $value) {
                         DB::table('raffle_game_free_ticket_map')->insertGetId([
                            'raffle_game_id'                => $raffle_games,
                            'raffle_game_free_ticket_id'   => $value
                        ]);

                    }
                }
            }

            $total_tickets = $request->total_tickets;
            $code_pre = $raffle_games.'-';
            $code_sup = 1000;

            for ($i=0; $i <$total_tickets ; $i++) {
                $code_sup++;
                $code = $code_pre.$code_sup;

                DB::table('raffle_game_tickets')->insert([
                    'code'              => $code,
                    'status'            => 1,
                    'raffle_game_id'    => $raffle_games,
                    'unit_price'        => $request->unit_price,
                    'is_booked'         => 0,
                    'winning_position'  => 0,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'created_by'        => Auth::id(),
                ]);


            }


        } catch (\Throwable $th) {

            DB::rollBack();
            dd($th);
            $notify[] = ['error', 'Raffle game not created'];
            return redirect()->back()->withNotify($notify);

        }
        DB::commit();
        $notify[] = ['success', 'Raffle game has been created'];
        return redirect()->route('admin.raffle.index')->withNotify($notify);

    }

    public function edit(Request $request, $id)
    {
        $raffle = $this->raffle->find($id);
        $free_ticket_map = DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$id)->get();
        $category = DB::table('raffle_categories')->where('status',1)->orderBy('id','asc')->get();
        $free_ticket = DB::table('raffle_game_free_tickets')->where('status',1)->orderBy('name','asc')->get();
        $pageTitle = 'Raffle Update';
        $emptyMessage = 'No raffle game.';
        return view('admin.raffle.edit', compact('pageTitle', 'raffle', 'emptyMessage','category','free_ticket','free_ticket_map'));

    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            // 'image'         => 'required',
            'category_id'   => 'required',
            'title'         => 'required',
            'unit_price'    => 'required',
            'total_tickets' => 'required',
            'min_tickets'   => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);
        DB::beginTransaction();
        try {
            $photo = null;
            $raffle_games = $this->raffle->find($id);
            $photo = $raffle_games->photo;
            if ($request->hasFile('image')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];

                $old = $raffle_games->photo;
                if (File::exists($path.$raffle_games->photo)) {
                    File::delete($path.$raffle_games->photo);
                }
                $photo = uploadImage($request->image,$path,$size,$old);
                $raffle_games->photo  = $photo;
            }


            if ($request->hasFile('banner')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];

                $old = $raffle_games->banner;
                if (File::exists($path.$raffle_games->banner)) {
                    File::delete($path.$raffle_games->banner);
                }
                $banner = uploadImage($request->banner,$path,$size,$old);
                $raffle_games->banner  = $banner;
            }


            if ($request->hasFile('bannerMobile')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];

                $old = $raffle_games->bannerMobile;
                if (File::exists($path.$raffle_games->bannerMobile)) {
                    File::delete($path.$raffle_games->bannerMobile);
                }
                $bannerMobile = uploadImage($request->bannerMobile,$path,$size,$old);
                $raffle_games->bannerMobile  = $bannerMobile;
            }


            $raffle_games->category_id  = $request->category_id;
            $raffle_games->title        = $request->title;
            $raffle_games->sub_title = $request->sub_title;
            $raffle_games->jackpot_prize_total = $request->jackpot_prize_total;
            $raffle_games->ticket_price_heading = $request->ticket_price_heading;
            $raffle_games->lucky_draw_heading = $request->lucky_draw_heading;

            $raffle_games->unit_price   = $request->unit_price;
            $raffle_games->total_tickets = $request->total_tickets;
            $raffle_games->min_tickets  = $request->min_tickets;
            $raffle_games->free_ticket  = $request->free_ticket;
            $raffle_games->bottom_box_input  = $request->bottom_box_input;
            $raffle_games->bottom_box_input_2  = $request->bottom_box_input_2;
            $raffle_games->start_time   = \Carbon\Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
            $raffle_games->end_time     = \Carbon\Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
            // if($request->next_time){
            //     $raffle_games->next_time = \Carbon\Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
            // }
            if($request->status=='on'){
                $raffle_games->status     = 1;
            }
            else{
                $raffle_games->status     = 0;
            }
            $raffle_games->updated_at   = date('Y-m-d H:i:s');
            $raffle_games->updated_by   = Auth::id();



            if($request->game_info){
                $raffle_games->game_info = json_encode($request->game_info);
            }else{
                $raffle_games->game_info = null;
            }


            // by aman
            if($request->game_rules){
                $raffle_games->game_rules = json_encode($request->game_rules);
            }else{
                $raffle_games->game_rules = null;
            }



            $raffle_games->update();


            if($request->free_ticket == 1){
                $free_tickets = $request->free_tickets;
                if($free_tickets){

                    DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$raffle_games->id)->delete();
                    foreach ($free_tickets as $key => $value) {
                         DB::table('raffle_game_free_ticket_map')->insertGetId([
                            'raffle_game_id'                => $raffle_games->id,
                            'raffle_game_free_ticket_id'   => $value
                        ]);
                    }
                }
            }else{
                DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$raffle_games->id)->delete();
            }
            $total_tickets = $request->total_tickets;
            $code_pre = $raffle_games->id.'-';
            $code_sup = 1000;

            if($raffle_games->total_tickets != $request->total_tickets ){
                DB::table('raffle_game_tickets')->where('raffle_game_id',$raffle_games->id)->delete();
                for ($i=0; $i <$total_tickets ; $i++) {
                    $code_sup++;
                    $code = $code_pre.$code_sup;
                    // DB::table('raffle_game_tickets')->insert([
                    //     'code'              => $code,
                    //     'status'            => 1,
                    //     'raffle_game_id'    => $raffle_games->id,
                    //     'unit_price'        => $request->unit_price,
                    //     'is_booked'         => 0,
                    //     'winning_position'  => 0,
                    //     'created_at'        => date('Y-m-d H:i:s'),
                    //     'created_by'        => Auth::id(),
                    // ]);
                }
            }




        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            $notify[] = ['error', 'Raffle game not updated'];
            return redirect()->back()->withNotify($notify);
        }
        DB::commit();
        $notify[] = ['success', 'Raffle game has been updated'];
        return redirect()->route('admin.raffle.index')->withNotify($notify);
    }

    public function delete(Request $request, $id)
    {
        DB::table('raffle_games')->delete($id);

        return redirect()->route('admin.raffle.index');
    }
    public function scratch(Request $request)
    {
        $pageTitle = 'Scratch Card Game';
        $raffles = ScratchGame::orderBy('id','desc')->paginate(getPaginate());
        $raffles =ScratchGame::with('category')->orderBy('category_id','asc')->paginate(getPaginate());
        $emptyMessage = 'No Scratch Card game.';
        return view('admin.scratch.index', compact('pageTitle', 'raffles', 'emptyMessage'));
    }


    public function createscratch(Request $request)
    {
        $pageTitle = 'Scratch Card Create';
        $raffles = ScratchGame::orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No Scratch Card game.';
        $category = DB::table('scratch_categories')->where('status',1)->orderBy('id','asc')->get();
        $free_ticket = DB::table('raffle_game_free_tickets')->where('status',1)->orderBy('name','asc')->get();
        return view('admin.scratch.create', compact('pageTitle', 'raffles', 'emptyMessage','category','free_ticket'));
    }
    public function storescratch(Request $request)
    {
        $request->validate([
            'image'         => 'required',
            'category_id'   => 'required',
            'title'         => 'required',
            'unit_price'    => 'required',
            // 'total_tickets' => 'required',
            // 'min_tickets'   => 'required',
            // 'start_time'    => 'required',
            // 'end_time'      => 'required',
        ]);



        DB::beginTransaction();
        try {
            $image = null;
            $old = null;

            if ($request->hasFile('image')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];
                $photo = uploadImage($request->image,$path,$size,$old);
                $image  = $photo;
            }
            if($request->status=='on'){
                $status     = 1;
            }else{
                $status     = 0;
            }


            // if($request->game_info){
            //     $raffle_info = json_encode($request->game_info);
            // }else{
            //     $raffle_info = null;
            // }


            $raffle_games = DB::table('scratch_games')->insertGetId([
                'photo'         => $image,
                'category_id'   => $request->category_id,
                'title'         => $request->title,
                'status'         => $status,
                'unit_price'    => $request->unit_price,
                // 'total_tickets' => $request->total_tickets,
                // 'min_tickets'   => $request->min_tickets,
                // 'start_time'    => $request->start_time,
                // 'end_time'      => $request->end_time,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'      => Auth::id(),
            ]);

            // if($request->free_ticket == 1){
            //     $free_tickets = $request->free_tickets;
            //     if($free_tickets){
            //         foreach ($free_tickets as $key => $value) {
            //              DB::table('raffle_game_free_ticket_map')->insertGetId([
            //                 'raffle_game_id'                => $raffle_games,
            //                 'raffle_game_free_ticket_id'   => $value
            //             ]);

            //         }
            //     }
            // }

            // $total_tickets = $request->total_tickets;
            // $code_pre = $raffle_games.'-';
            // $code_sup = 1000;

            // for ($i=0; $i <$total_tickets ; $i++) {
            //     $code_sup++;
            //     $code = $code_pre.$code_sup;

            //     DB::table('raffle_game_tickets')->insert([
            //         'code'              => $code,
            //         'status'            => 1,
            //         'raffle_game_id'    => $raffle_games,
            //         'unit_price'        => $request->unit_price,
            //         'is_booked'         => 0,
            //         'winning_position'  => 0,
            //         'created_at'        => date('Y-m-d H:i:s'),
            //         'created_by'        => Auth::id(),
            //     ]);


            // }


        } catch (\Throwable $th) {

            DB::rollBack();
            dd($th);
            $notify[] = ['error', 'Scratch Card game not created'];
            return redirect()->back()->withNotify($notify);

        }
        DB::commit();
        $notify[] = ['success', 'Scratch Card game has been created'];
        return redirect()->route('admin.scratch.index')->withNotify($notify);

    }

    public function editscratch(Request $request, $id)
    {
        $raffle = ScratchGame::find($id);
        $free_ticket_map = DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$id)->get();
        $category = DB::table('raffle_categories')->where('status',1)->orderBy('id','asc')->get();
        $free_ticket = DB::table('raffle_game_free_tickets')->where('status',1)->orderBy('name','asc')->get();
        $pageTitle = 'Scratch Card Update';
        $emptyMessage = 'No Scratch Card game.';
        return view('admin.scratch.edit', compact('pageTitle', 'raffle', 'emptyMessage','category','free_ticket','free_ticket_map'));

    }

    public function updatescratch(Request $request, $id)
    {
        $request->validate([
            // 'image'         => 'required',
            'category_id'   => 'required',
            'title'         => 'required',
            'unit_price'    => 'required',
            'total_tickets' => 'required',
            'min_tickets'   => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);
        DB::beginTransaction();
        try {
            $photo = null;
            $raffle_games = ScratchGame::find($id);
            $photo = $raffle_games->photo;
            if ($request->hasFile('image')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];

                $old = $raffle_games->photo;
                if (File::exists($path.$raffle_games->photo)) {
                    File::delete($path.$raffle_games->photo);
                }
                $photo = uploadImage($request->image,$path,$size,$old);
                $raffle_games->photo  = $photo;
            }


            if ($request->hasFile('banner')) {
                $path = imagePath()['game']['path'];
                $size = imagePath()['game']['size'];

                $old = $raffle_games->banner;
                if (File::exists($path.$raffle_games->banner)) {
                    File::delete($path.$raffle_games->banner);
                }
                $banner = uploadImage($request->banner,$path,$size,$old);
                $raffle_games->banner  = $banner;
            }


            $raffle_games->category_id  = $request->category_id;
            $raffle_games->title        = $request->title;
            $raffle_games->unit_price   = $request->unit_price;
            $raffle_games->total_tickets = $request->total_tickets;
            $raffle_games->min_tickets  = $request->min_tickets;
            $raffle_games->start_time   = \Carbon\Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
            $raffle_games->end_time     = \Carbon\Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
            if($request->status=='on'){
                $raffle_games->status     = 1;
            }
            else{
                $raffle_games->status     = 0;
            }
            $raffle_games->updated_at   = date('Y-m-d H:i:s');
            $raffle_games->updated_by   = Auth::id();




            $raffle_games->update();


            // if($request->free_ticket == 1){
            //     $free_tickets = $request->free_tickets;
            //     if($free_tickets){

            //         DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$raffle_games->id)->delete();
            //         foreach ($free_tickets as $key => $value) {
            //              DB::table('raffle_game_free_ticket_map')->insertGetId([
            //                 'raffle_game_id'                => $raffle_games->id,
            //                 'raffle_game_free_ticket_id'   => $value
            //             ]);
            //         }
            //     }
            // }else{
            //     DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$raffle_games->id)->delete();
            // }
            // $total_tickets = $request->total_tickets;
            // $code_pre = $raffle_games->id.'-';
            // $code_sup = 1000;

            // if($raffle_games->total_tickets != $request->total_tickets ){
            //     DB::table('raffle_game_tickets')->where('raffle_game_id',$raffle_games->id)->delete();
            //     for ($i=0; $i <$total_tickets ; $i++) {
            //         $code_sup++;
            //         $code = $code_pre.$code_sup;
            //         DB::table('raffle_game_tickets')->insert([
            //             'code'              => $code,
            //             'status'            => 1,
            //             'raffle_game_id'    => $raffle_games->id,
            //             'unit_price'        => $request->unit_price,
            //             'is_booked'         => 0,
            //             'winning_position'  => 0,
            //             'created_at'        => date('Y-m-d H:i:s'),
            //             'created_by'        => Auth::id(),
            //         ]);
            //     }
            // }




        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            $notify[] = ['error', 'Scratch Card game not updated'];
            return redirect()->back()->withNotify($notify);
        }
        DB::commit();
        $notify[] = ['success', 'Scratch Card game has been updated'];
        return redirect()->route('admin.scratch.index')->withNotify($notify);
    }

    public function deletescratch(Request $request, $id)
    {
        DB::table('scratch_games')->delete($id);

        return redirect()->route('admin.scratch.index');
    }
    public function paytable(Request $request, $id = NULL)
    {
		// echo "<pre>";print_r($id);echo "</pre>";exit;
        $pageTitle = 'Paytables';
        // $raffles = Paytable::orderBy('id','desc')->paginate(getPaginate());
        $raffles_query = Paytable::query();
		if($id != NULL && $id > 0){
			$raffles_query->where('scratch_id',$id);
		}
		$raffles = $raffles_query->with('scratch')->orderBy('scratch_id','asc')->paginate(getPaginate());
		$scratch_games = ScratchGame::where('status',1)->orderBy('title','asc')->get();
		// echo "<pre>";print_r($scratch_games);echo "</pre>";exit;
        $emptyMessage = 'No Paytable.';
        return view('admin.scratch.Paytabel.index', compact('pageTitle', 'raffles', 'emptyMessage','scratch_games','id'));
    }
    public function createpaytable(Request $request, $id = NULL)
    {
        $pageTitle = 'Paytable Create';
        $raffles = Paytable::orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No Paytable.';
        $category = ScratchGame::where('status',1)->orderBy('title','asc')->get();
        return view('admin.scratch.Paytabel.create', compact('pageTitle', 'raffles', 'emptyMessage','category', 'id'));
    }
    public function storepaytable(Request $request)
    {
		// echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $data = $request->paytable;
        //dd($data);
        $request->validate([
            'scratch_id'   => 'required',
        ]);
        DB::beginTransaction();
        try {
            $image = null;
            $old = null;
           foreach($data as $val )
           {
            // dd($val['name']);
            $raffle_games = DB::table('paytables')->insertGetId([
                'scratch_id'   => $request->scratch_id,
                'tier'   => $val['tier'],
                'prize'   => ($val['prize'] != 0)?$val['prize']:0,
                'amount'   => ($val['amount'] != 0)?$val['amount']:0,
            ]);
           }


        } catch (\Throwable $th) {

            DB::rollBack();
            dd($th);
            $notify[] = ['error', 'Paytable not created'];
            return redirect()->back()->withNotify($notify);
        }
        DB::commit();
        $notify[] = ['success', 'Paytable has been created'];
        return redirect()->route('admin.paytable.index',['id' => $request->scratch_id])-
