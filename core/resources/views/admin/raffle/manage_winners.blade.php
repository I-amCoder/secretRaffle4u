@extends('admin.layouts.app')

@section('panel')
<div class="row mb-3">
    

<div class="col-md-12">
    <div class="card b-radius--10 ">
        <div class="card-body p-0">
            <div class="table-responsive--sm table-responsive">
                
                  

                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                {{--<th >Free Lucky Draw</th> --}}
                                <th >Raffle Game</th>
                                <th >User Email</th>
                                <th >User Name</th>
                                <th >Winning Position</th>
                                <th >Blocked Position</th>
                                <th >Action</th>
                            </tr>

                        
                        </thead>
                        <tbody>
                                @if (count($winners) > 0)
                                    
                               
                                @foreach ($winners as $k => $item)
                                    <tr>
                                        <td>
                                            <span>{{ $item->raffle_game->title }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->user->email }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->user->firstname." ".$item->user->lastname }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->winning_position }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->blocked_position }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.raffle.delete_winner', ['id' => $item->id]) }}" 
                                                onclick="return confirm('Are you sure you want to delete?')"
                                                class="btn btn-danger btn-sm">
                                            Delete
                                            </a>
                                        </td>
                                        
                                        
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>
                                        <h4 class="text-center">No Data</h4>
                                    </td>
                                    
                                </tr>
                                
                                @endif
                                <br>
                            
                                <form action="{{ route('admin.raffle.store_winners',$raffle->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                      <tr>
                                          <td>
                    
                                                  <label class="float-left">User</label>
                                                  <select name="user" id="user_id" class="form-control mb-2">
                                                      @foreach ($users as $user)
                                                          <option value="{{ $user->user->id }}">{{ $user->user->email }}</option>
                                                      @endforeach
                                                  </select>
                                                  
                                              </td>
                    
                                              <td>
                                                  <label class="float-left">Winning Position</label>
                                                  <input type="number" class="form-control mb-2" min="0"  name="winning_position"
                                                    />
                                              </td>
                                              <td>
                                                  <label class="float-left">Blocked Position</label>
                                                  <input type="text" class="form-control mb-2" min="0"  name="blocked_position"
                                                      />
                                              </td>
                    
                                              
                    
                                              
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
        <div class="row">
            
        </div>
    </div>

</div><!-- card end -->
</div>

</div>

@endsection




