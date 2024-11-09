@extends('faculty/layout')
@section('title','Section Reports')
@section('reports','active')
@section('container')

<div class="row">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-header" style="display:flex;justify-content:flex-end;">
                      @if($swot!=0)
                    <a href="{{url('faculty/exam/swot')}}/{{$swot}}" class="btn btn-success btn-sm">SWOT</a>
                    @endif
                </div>
             <!-- /.card-header -->
              <div class="card-body">
                
                  

                      
                       <div class="col-12">
            <!-- Custom Tabs --> 
                         <div class="card">
                           
              <!-- /.card-header -->
              <div class="card-body">
                
                         
                       <div class="row">
        <div class="col-12">
        
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>

                    <tr style="background-color:gray;color:#000"><th colspan="5"  class=" text-secondary  font-weight-bolder opacity-7" style="text-align: center;color: #fff !important;">{{$finalassname}}</th></tr>
                   <tr class="" style="color:#fff !important">
                      
                      <th  class="text-secondary  font-weight-bolder opacity-7" >Section Name</th>
                      <th class=" text-secondary  font-weight-bolder opacity-7">Result</th>
                      <th class=" text-secondary  font-weight-bolder opacity-7">Overall Grade</th>
                      
                      <th class=" text-secondary  font-weight-bolder opacity-7">Report</th> 

                  </thead>
                  <tbody>
                   

                    @if($count>0)
                     
                    
                      @php
                       $c=0;
                      @endphp
                     
                       @foreach($section[0] as $list)
                       


                                     <tr>
                                  <td><p class="text-xs font-weight-bold mb-0">{{$list[3]}}</p></td>
                                  <td>
                                          @if($list[2]>=$sec[$c]->sectionpass)
                                             <span class="badge badge-sm bg-gradient-success">PASS</span>
                                          @else
                                             <span class="badge badge-sm bg-gradient-danger">FAIL</span>
                                          @endif
                                      </td>    
                                       
                                       
                                  <td>
                                     @if($list[2]>=90)
                       <span class="right badge badge-success">Outstanding</span>
                     @elseif($list[2]>=80)
                         <span class="right badge badge-success">Excellent</span>

                     @elseif($list[2]>=70)
                          <span class="right badge badge-primary">Very Good</span>
                     @elseif($list[2]>=60)
                           <span class="right badge badge-primary">Good</span>
                     @elseif($list[2]>=50)
                           <span class="right badge badge-warning">Average</span>
                     @elseif($list[2]>=40)
                           <span class="right badge badge-warning">To Improve</span>
                     @elseif($list[2]>=30)
                         <span class="right badge badge-danger">Poor</span>
                     @elseif($list[2]<30)
                               <span class="right badge badge-danger">Very Poor</span>

                     @endif 
                                  </td>
                                  
                                  <td>

                                  <form method="post" action="{{url('faculty/exam/detailedreport')}}" id="formw{{$c}}">
                      @csrf
                    @php
                      $num=0;
                      $sub=0;
                      $resskr[$c]=[];
                      $ressub[$c]=[];
                    @endphp
                    @foreach($res[0] as $li)
                    @php
                    if($list[3]==$li[5]){
                      $resskr[$c][$num]=$li[0].'&%$'.$li[1].'&%$'.$li[2].'&%$'.$li[3].'&%$'.$li[4];
                      @endphp
                       <input type="hidden" name="res[]" value="{{$resskr[$c][$num]}}" form="formw{{$c}}">
                       @php
                      $num++;
                       }
                      @endphp
                    @endforeach
                     @foreach($subskillset[0] as $li)
                    @php
                    if($list[3]==$li[4]){
                      $ressub[$c][$sub]=$li[0].'&%$'.$li[1].'&%$'.$li[2].'&%$'.$li[3].'&%$'.$li[4];
                      @endphp
                       <input type="hidden" name="sub[]" value="{{$ressub[$c][$sub]}}" form="formw{{$c}}">
                       @php
                      $sub++;
                       }
                      @endphp
                    @endforeach
                   

                       <input type="hidden" name="aname" value="" form="formw{{$c}}"> 
                      <input type="hidden" name="attr" value="{{$list[3]}}" form="formw{{$c}}">
                     
                 <input type="submit" class="btn btn-primary btn-sm" form="formw{{$c}}" value="Check Reports"name="Check" placeholder="Check">
                       
                     </form>
                    </td>
                                  
                  </tr>
                   
                      @php
                        $c++;
                      @endphp
                    @endforeach
                    @endif
                  
                    @php
                    $g=0
                    @endphp

             





































                 
                   
                  
                   
                          
                      
                   
                 
                  </tbody>
                </table>
              </div>

           
        </div>
      </div>



                       



                  </div>
                  <!-- /.tab-pane -->
                  
                  <!-- /.tab-pane -->
                  
                  <!-- /.tab-pane -->
                <!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>


                
     
                  <!-- /.tab-pane -->
                  
                  <!-- /.tab-pane -->
                </div>

                
                <!-- /.tab-content -->
              
            <!-- ./card -->
          </div>
          <!-- /.col -->
      </div>


@endsection