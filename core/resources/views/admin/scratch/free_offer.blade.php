@extends('admin.layouts.app')

@section('panel')
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('SL')</th>

                                <th>@lang('Title')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($free_tickets) && count($free_tickets) >0)
                            @foreach ($free_tickets as $key=> $row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->ticket_name }}</td>


                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                </table><!-- table end -->
            </div>
        </div>

    </div><!-- card end -->
</div>

<div class="col-md-12">
    <div class="card b-radius--10 ">
        <div class="card-body p-0">
            <div class="table-responsive--sm table-responsive">
                
                    @csrf

                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                {{--<th >Free Lucky Draw</th> --}}
                                <th >Ticket Count</th>
                                <th >Ticket Amount</th>
                                <th >Lucky Draw Text Line One</th>
                                <th >Lucky Draw Text Line Two</th>
                                <th ></th>
                            </tr>

                        {{-- OLD CODE --}}
                        {{--
                            @if(isset($free_ticket_sets) && count($free_ticket_sets) > 0 )
                                @foreach ($free_ticket_sets as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>Buy {{ $raffle->title }} : {{ $item->purchased_ticket }}</td>
                                <td>
                                    @php
                                    $frees = getFreeTicket($raffle->id, $item->purchased_ticket)
                                    @endphp

                                    @if(isset($frees) && count($frees) > 0 )
                                    @foreach ($frees as $item)
                                        <p>{{ $item->ticket_name }} - {{ $item->free_ticket }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        --}}
                        </thead>
                        <tbody>
                        
                                @foreach ($free_ticket_sets as $k => $item)
                                    <tr>
                                        <td>
                                            <input type="text"  form="update_form_{{$item->id}}" class="form-control mb-2" value="{{$item->ticket_count}}" name="ticket_count" required/>
                                        </td>
                                        <td>
                                            <input type="text" form="update_form_{{$item->id}}"  class="form-control mb-2" value="{{$item->ticket_amount}}" name="ticket_amount" required/>
                                        </td>
                                        <td>
                                            <input type="text" form="update_form_{{$item->id}}"  class="form-control mb-2" value="{{$item->lucky_draw_text_line_one}}" name="lucky_draw_text_line_one" />
                                        </td>
                                        <td>
                                            <input type="text"  form="update_form_{{$item->id}}" class="form-control mb-2" value="{{$item->lucky_draw_text_line_two}}" name="lucky_draw_text_line_two" />
                                        </td>
                                        <td>

                                            <form class="d-inline-block" action="{{route('admin.raffle.free_offer.update', ['id'=> $item->id])}}" id="update_form_{{$item->id}}" method="post">
                                                <input type="hidden" class="form-control mb-2" value="{{$item->id}}" name="id" required />
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                            </form>

                                            <form class="d-inline-block" action="{{route('admin.raffle.free_offer.delete', ['id'=> $item->id])}}" method="post">
                                                <input type="hidden" class="form-control mb-2" value="{{$item->id}}" name="id" required />
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                        
                            <form action="{{ route('admin.raffle.free_offer.store',$raffle->id) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                                <tr>
                                    <td>

                                            <input type="hidden" value="{{$raffle->id}}" name="raffle_game_id" >
                                            
                                            <label class="float-left">Ticket Count:</label>
                                            <input type="text" class="form-control mb-2"  name="ticket_count"
                                                required/>
                                        </td>

                                        <td>
                                            <label class="float-left">Ticket Amount:</label>
                                            <input type="text" class="form-control mb-2"  name="ticket_amount"
                                                required/>
                                        </td>

                                        <td>
                                            <label class="float-left">Lucky Draw Text Line One:</label>
                                            <input type="text" class="form-control mb-2"  name="lucky_draw_text_line_one"
                                                />
                                        </td>

                                        <td>

                                            <label class="float-left">Lucky Draw Text Line Two:</label>
                                            <input type="text" class="form-control mb-2"  name="lucky_draw_text_line_two"
                                                />
                                        </td>

                                        {{--OLD CODE--}}
                                        {{--
                                        @if(!empty($free_tickets) && count($free_tickets) >0)
                                        @foreach ($free_tickets as $key=> $row)
                                                <input type="hidden" value="{{ $row->raffle_game_free_ticket_id }}" name="raffle_game_free_ticket_id[]" />
                                                <label class="float-left">Number of Free for {{ $row->ticket_name }}</label>
                                                <input type="number" class="form-control" placeholder="free ticket" name="free_ticket[]"
                                        value="{{ old('free_ticket['.$key.']') }}" requierd/>
                                        @endforeach
                                        @endif
                                        --}}


                                        <td>

                                            <div class>
                                                <button class="btn btn-sm btn-info" type="submit">Create</button>
                                            </div>

                                    </td>
                                </tr>
                                
                            </form>

                        </tbody>
                </table><!-- table end -->
        </div>
    </div>

</div><!-- card end -->
</div>

</div>

@endsection




