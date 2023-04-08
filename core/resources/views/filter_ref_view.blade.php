@if(isset($pageData))
  @if(!empty($pageData['s_ref'][0]))


 @if(!empty($pageData['s_ref'])) 
                        @foreach($pageData['s_ref'] as $key=>$job)
                        {{$job->email}}  <a href="" style="text-decoration: underline;">Add</a><br>



                                           @endforeach
 @else
                   No Record Found
                    @endif










                
      @endif
  @endif