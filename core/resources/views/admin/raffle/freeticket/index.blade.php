@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Unit Price</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{$ticket->id}}</td>
                                <td><img class="img-fluid" src="{{getImage('assets/images/game/'.$ticket->photo)}}" alt="" width="50"></td>
                                <td>{{$ticket->name}}</td>
                                <td>{{ $ticket->unit_price }}</td>
                                <td>{{ $ticket->status ? "Active" : "Deactive" }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-primary" href="{{route('admin.free-ticket.edit',['free_ticket'=>$ticket->id])}}"> <i class="fas fa-pen"></i></a>
                                        <form action="{{route('admin.free-ticket.destroy',['free_ticket'=>$ticket->id])}}" method="POST">

                                            @method('DELETE')
                                            @csrf

                                            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="d-flex justify-content-center">
                             {{ paginateLinks($tickets) }}

                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">

            </div>
        </div><!-- card end -->
    </div>
    </div>
@endsection
