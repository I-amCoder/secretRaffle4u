@extends('admin.layouts.app')

@section('panel')
<div class="row">

<div class="col-lg-6">
    <div class="card b-radius--10 ">
        <div class="card-body p-0">
            <div class="table-responsive--sm table-responsive">
                <form action="{{ route('admin.winning_segments.store',$raffle->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th colspan="4">Winning gift segments</th>
                            </tr>

                        </thead>
                        <tbody>
                            @if(isset($gifts) && count($gifts) > 0)
                            @foreach($gifts as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>

                                        {{ $item->position }}{{ postionTxt($item->position) }}

                                        @if($item->type == 2)
                                         - {{ $item->position_end }}{{ postionTxt($item->position_end) }}

                                        @endif

                                    </td>
                                    <td>{{ $item->gift_price }}</td>
                                    <td>
                                        <a href="{{ route('admin.winning_segments.delete',$item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>

                                        <a href="{{ route('admin.winning_segments',['id' =>$raffle->id,'mode' => 'edit', 'seg' => $item->id]) }}" class="btn btn-sm btn-info" >Edit</a>

                                    </td>


                                </tr>

                            @endforeach
                            @endif


                            @if( (request()->get('mode') == 'edit') && ($seg != null))

                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" name="gift_type" id="gift_type">
                                            <option value="1" {{ $seg->type == 1 ? 'selected' : '' }} >Single</option>
                                            <option value="2" {{ $seg->type == 2 ? 'selected' : '' }} >Multiple</option>
                                        </select>
                                     </div>

                                     <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" class="form-control" placeholder="position" name="position"
                                           value="{{ $seg->position }}" requierd/>
                                     </div>

                                     <div class="form-group end_position_div">
                                        <label>End Position</label>
                                        <input type="text" class="form-control" placeholder="position end" name="position_end"
                                           value="{{ $seg->position_end }}" requierd/>
                                     </div>

                                   </td>

                                   <td colspan="1">
                                    <div class="form-group">
                                        <label>Gift Price</label>
                                        <input type="number" step="0.01" class="form-control" placeholder="gift price" name="gift_price"
                                           value="{{ $seg->gift_price }}" requierd/>
                                     </div>
                                   </td>
                                   <td>
                                    <label>Order</label>
                                    <input type="number" class="form-control" placeholder="order_id" name="order_id"
                                       value="{{ $seg->order_id }}" requierd/>
                                   </td>
                                   <td>
                                       <input type="hidden" value="{{ $seg->id }}" name="seg" />
                                       <button class="btn btn-sm btn-info" type="submit">Update</button>
                                   </td>
                               </tr>

                            @else

                           <tr>
                            <td>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="gift_type" id="gift_type">
                                        <option value="1">Single</option>
                                        <option value="2">Multiple</option>
                                    </select>
                                 </div>

                                 <div class="form-group">
                                    <label>Position</label>
                                    <input type="number" class="form-control" placeholder="position" name="position"
                                       value="{{ old('position') }}" requierd/>
                                 </div>

                                 <div class="form-group end_position_div">
                                    <label>End Position</label>
                                    <input type="text" class="form-control" placeholder="position end" name="position_end"
                                       value="{{ old('position_end') }}" requierd/>
                                 </div>

                               </td>

                               <td colspan="1">
                                <div class="form-group">
                                    <label>Gift Price</label>
                                    <input type="number" step="0.01" class="form-control" placeholder="gift price" name="gift_price"
                                       value="{{ old('gift_price') }}" requierd/>
                                 </div>
                               </td>
                               <td>
                                <label>Order</label>
                                <input type="number" class="form-control" placeholder="order_id" name="order_id"
                                   value="{{ old('order_id') }}" requierd/>
                               </td>
                               <td>
                                   <button class="btn btn-sm btn-info" type="submit">Save</button>
                               </td>
                           </tr>
                           @endif

                        </tbody>
                </table><!-- table end -->
                </form>
        </div>
    </div>

</div><!-- card end -->
</div>
</div>

@endsection

@if( (request()->get('mode') == 'edit') && ($seg != null))

<script>
    var bv = `{{ $seg->type }}`;
    howHideGiftEndPosition(bv);
</script>

@else

<script>
howHideGiftEndPosition(1);
</script>

@endif


@push('script')
    <script type="text/javascript">


        $(document).on('change','#gift_type',function(e){
            var abc = $(this).val();
            howHideGiftEndPosition(abc);
        })

        function howHideGiftEndPosition(id) {
            if(id == '2'){
                $('.end_position_div').show();
            }else{
                $('.end_position_div').hide();
            }

        }


    </script>
@endpush




