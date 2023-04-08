<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailLog;
use App\Models\UserLogin;
use App\Models\RaffleGame;
use App\Models\FreeTicket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FreeTicketController extends Controller
{
    protected $freeticket;
    public function __construct(RaffleGame $raffle, FreeTicket $freeticket)
    {
        $this->raffle           = $raffle;
        $this->freeticket       = $freeticket;
    }


    public function index(Request $request)
    {
        $pageTitle = 'Free Tickets';
        $emptyMessage = 'No Free Tickets.';
        $tickets = $this->raffle->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.raffle.index', compact('pageTitle', 'tickets', 'emptyMessage'));
    }


    public function create(Request $request)
    {
        $pageTitle = 'Raffle Game';
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
        $free_ticket_sets = DB::table('raffle_game_free_lucky_draw')->where('raffle_game_id',$id)->groupBy('purchased_ticket')->get();

        return view('admin.raffle.free_offer', compact('pageTitle', 'emptyMessage', 'free_tickets','raffle','free_ticket_sets'));
    }

    public function freeOfferStore(Request $request, $id){
        $request->validate([
            'purchased_ticket'  => 'required',
            'free_ticket.*'       => 'required',
        ]);

        DB::beginTransaction();
        try {

            if($request->free_ticket){
                foreach ($request->free_ticket as $key => $value) {

                    DB::table('raffle_game_free_lucky_draw')->insert([
                        'is_free_ticket'    => 1,
                        'raffle_game_id'    => $id,
                        'raffle_game_free_ticket_id' => $request->raffle_game_free_ticket_id[$key] ?? null,
                        'purchased_ticket'  => $request->purchased_ticket,
                        'free_ticket'       => $value ?? 0,
                        'created_at'        => date('Y-m-d H:i:s'),
                        'created_by'        => Auth::id(),

                    ]);

                }
            }

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            $notify[] = ['error', 'Free ticket not assigned'];
            return redirect()->back()->withNotify($notify);
        }

        DB::commit();
        $notify[] = ['success', 'Free ticket assigned'];
        return redirect()->back()->withNotify($notify);

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

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            $notify[] = ['error', 'Winning gift segments not assigned'];
            return redirect()->back()->withNotify($notify);
        }

        DB::commit();
        $notify[] = ['success', 'Winning gift segments assigned'];
        return redirect()->back()->withNotify($notify);

    }



    public function winningSegments(Request $request,$id){

        $raffle = RaffleGame::find($id);
        $pageTitle = 'Winning offer for: '.$raffle->title;
        $emptyMessage = 'No offer yet.';
        $gifts = DB::table('raffle_game_winning_segments')->where('raffle_game_id',$id)->orderBy('order_id','asc')->get();
        return view('admin.raffle.winning_offer', compact('pageTitle', 'emptyMessage', 'gifts','raffle'));
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
            $raffle_games = DB::table('raffle_games')->insertGetId([
                'photo'         => $image,
                'category_id'   => $request->category_id,
                'title'         => $request->title,
                'unit_price'    => $request->unit_price,
                'total_tickets' => $request->total_tickets,
                'min_tickets'   => $request->min_tickets,
                'free_ticket'   => $request->free_ticket,
                'start_time'    => $request->start_time,
                'end_time'      => $request->end_time,
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

        // dd($request->all());

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
            $raffle_games->category_id  = $request->category_id;
            $raffle_games->title        = $request->title;
            $raffle_games->unit_price   = $request->unit_price;
            $raffle_games->total_tickets = $request->total_tickets;
            $raffle_games->min_tickets  = $request->min_tickets;
            $raffle_games->free_ticket  = $request->free_ticket;
            $raffle_games->start_time   = $request->start_time;
            $raffle_games->end_time     = $request->end_time;
            $raffle_games->created_at   = date('Y-m-d H:i:s');
            $raffle_games->created_by   = Auth::id();
            $raffle_games->update();

            // DB::table('raffle_games')->where('id',$id)->update([
            //     'photo'         => $photo,
            //     'category_id'   => $request->category_id,
            //     'title'         => $request->title,
            //     'unit_price'    => $request->unit_price,
            //     'total_tickets' => $request->total_tickets,
            //     'min_tickets'   => $request->min_tickets,
            //     'free_ticket'   => $request->free_ticket,
            //     'start_time'    => $request->start_time,
            //     'end_time'      => $request->end_time,
            //     'created_at'    => date('Y-m-d H:i:s'),
            //     'created_by'      => Auth::id(),
            // ]);

            if($request->free_ticket == 1){
                $free_tickets = $request->free_tickets;
                if($free_tickets){
                    DB::table('raffle_game_free_ticket_map')->where('raffle_game_id',$id)->delete();
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
            DB::table('raffle_game_tickets')->where('raffle_game_id',$id)->delete();
            for ($i=0; $i <$total_tickets ; $i++) {
                $code_sup++;
                $code = $code_pre.$code_sup;
                DB::table('raffle_game_tickets')->insert([
                    'code'              => $code,
                    'status'            => 1,
                    'raffle_game_id'    => $id,
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







}
