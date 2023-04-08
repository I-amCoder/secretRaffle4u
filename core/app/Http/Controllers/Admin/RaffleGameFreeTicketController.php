<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RaffleGameFreeTicket;
use Illuminate\Http\Request;

class RaffleGameFreeTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle ="Raffle Game Free Ticket";
        $tickets=RaffleGameFreeTicket::paginate(10);

        return view('admin.raffle.freeticket.index',compact('pageTitle','tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle ="Raffle Game Free Ticket Create";

        return view('admin.raffle.freeticket.create',compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=>'required',
            'title'=>'required',
            'unit_price'=>'required',
        ]);

        if ($request->hasFile('image')) {
            $path = imagePath()['game']['path'];
            $size = imagePath()['game']['size'];
            $photo = uploadImage($request->image,$path,$size);
            $image  = $photo;
        }
        $tickets=new RaffleGameFreeTicket();
        $tickets->name=$request->title;
        $tickets->photo=$image;
        $tickets->status=$request->status == "on" ? true : false ;
        $tickets->unit_price=$request->unit_price;
        $tickets->save();
        $notify[] = ['success', 'Raffle game ticket created'];
        return redirect()->route('admin.free-ticket.index')->withNotify($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RaffleGameFreeTicket  $raffleGameFreeTicket
     * @return \Illuminate\Http\Response
     */
    public function show(RaffleGameFreeTicket $raffleGameFreeTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RaffleGameFreeTicket  $r
     * @return \Illuminate\Http\Response
     */
    public function edit(RaffleGameFreeTicket $free_ticket)
    {

        $pageTitle ="Raffle Game Free Ticket Edit";
        return view('admin.raffle.freeticket.edit',compact('pageTitle','free_ticket'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RaffleGameFreeTicket  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RaffleGameFreeTicket $free_ticket)
    {

        $request->validate([
            'title'=>'required',
            'unit_price'=>'required',
        ]);

        if ($request->hasFile('image')) {
            $path = imagePath()['game']['path'];
            $size = imagePath()['game']['size'];
            $photo = uploadImage($request->image,$path,$size);
            $image  = $photo;
        }

        $free_ticket->name=$request->title;
        if ($request->hasFile('image')) {

        $free_ticket->photo=$image;
        }
        $free_ticket->status=$request->status == "on" ? true : false ;
        $free_ticket->unit_price=$request->unit_price;
        $free_ticket->save();
        $notify[] = ['success', 'Raffle Free Ticket Updated'];
        return redirect()->route('admin.free-ticket.index')->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RaffleGameFreeTicket  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy(RaffleGameFreeTicket $free_ticket)
    {
        $free_ticket->delete();

        $notify[] = ['success', 'Raffle Free Ticket Delete'];
        return redirect()->route('admin.free-ticket.index')->withNotify($notify);
    }
}
