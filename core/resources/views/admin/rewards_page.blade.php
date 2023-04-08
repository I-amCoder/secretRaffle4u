@extends('admin.layouts.app')

@section('panel')
<div class="row mb-3">
    <style>
        .c_rule{
            width: 80% !important;
            white-space: unset !important;
        }
    </style>

<div class="col-md-12">
    <div class="card b-radius--10 ">
        <div class="card-body p-0">
            <div class="table-responsive--sm table-responsive">
                
                  <h4>Level Upgrade Requirements:</h4>

                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                {{--<th >Free Lucky Draw</th> --}}
                                <th >Level Upgrade Requirements:</th>
                                <th >Level 1</th>
                                <th >Level 2</th>
                                <th >Level 3</th>
                                <th >Level 4</th>
                                <th >Level 5</th>
                                <th >Action</th>
                            </tr>

                        
                        </thead>
                        <tbody>
                                @if (count($level_req) > 0)
                                    
                               
                                @foreach ($level_req as $k => $item)
                                    <tr>
                                        <td>
                                            <span>{{ $item->level_req }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->level_1 }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->level_2 }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->level_3 }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->level_4 }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->level_5 }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.delete_l_req', ['id' => $item->id]) }}" 
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
                            
                                <form action="{{ route('admin.store_lvl_req') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                      <tr>
                                              
                    
                                              <td>
                                                <label class="float-left">Level Upgrade Requirements:</label>
                                                <input type="text" class="form-control mb-2" name="level_req"
                                                />
                                              </td>
                                              <td>
                                                <label class="float-left">Level 1</label>
                                                <input type="text" class="form-control mb-2"  name="level_1"
                                                />
                                              </td>
                                              <td>
                                                <label class="float-left">Level 2</label>
                                                <input type="text" class="form-control mb-2"  name="level_2"
                                                />
                                              </td>
                                              <td>
                                                <label class="float-left">Level 3</label>
                                                <input type="text" class="form-control mb-2"  name="level_3"
                                                />
                                              </td>
                                              <td>
                                                <label class="float-left">Level 4</label>
                                                <input type="text" class="form-control mb-2"  name="level_4"
                                                />
                                              </td>
                                              <td>
                                                <label class="float-left">Level 5</label>
                                                <input type="text" class="form-control mb-2"  name="level_5"
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
            <div class="table-responsive--sm table-responsive">
                
                  <h4>Commision Rules</h4>

                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th >Commision Rules</th>
                            </tr>

                        
                        </thead>
                        <tbody>
                                @if (count($c_rules) > 0)
                                    
                               
                                @foreach ($c_rules as $k => $item)
                                    <tr>
                                        <td class="c_rule">
                                            <span>{{ $item->c_rule }}</span>
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('admin.delete_c_rules', ['id' => $item->id]) }}" 
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
                            
                                <form action="{{ route('admin.store_c_rule') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                      <tr>
                                              
                    
                                              <td>
                                                <label class="float-left">Comission Rule</label>
                                                <textarea type="text" class="form-control mb-2" name="c_rule"
                                                ></textarea>
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




