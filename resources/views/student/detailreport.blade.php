@extends('student/layout')
@section('title','Detailed Reports')
@section('Dashboard_select','active')
@section('container')

<head>
    <style type="text/css">
        th{
            font-size: 14px;
            text-transform: uppercase;
        }
        td{
            font-size: 12px;
            text-transform: capitalize;
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>
<div class="row">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              
              



              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    
       






<div class="row">
        <div class="col-12">
          
              
                
<div class="card-body">
  
             <table class="table table-hover" style="border:2px solid #000">
              <thead>
                <tr>
                    <th colspan="5" style="text-align:center;background-image: linear-gradient(to right, #870000,#190a05);color:#fff">{{$subs}}<br><span style="font-size:10px;text-transform:capitalize;">( Click On The Individual Skillset To See Attribute Level Performance )</span></th>
                </tr>
                    <tr style="background-color: grey;color:#fff">
                      <th>Skillset</th>
                      <th>Final Score</th>
                      <th>Grade</th>
                      <th>Highest Score</th>
                      <th>Average Score</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  
                             @for($i=0;$i<$subcount;$i++)
                    <tr data-widget="expandable-table" aria-expanded="false">
                       
                      <td>{{$sub[$i][3]}}</td>
                     
                      <td>{{$sub[$i][2]}}%</td>
                      <td>
                         @if($sub[$i][2]>=90)
                       <span class="right badge badge-success">Outstanding</span>
                     @elseif($sub[$i][2]>=80)
                         <span class="right badge badge-success">Excellent</span>

                     @elseif($sub[$i][2]>=70)
                          <span class="right badge badge-primary">Very Good</span>
                     @elseif($sub[$i][2]>=60)
                           <span class="right badge badge-primary">Good</span>
                     @elseif($sub[$i][2]>=50)
                           <span class="right badge badge-warning">Average</span>
                     @elseif($sub[$i][2]>=40)
                           <span class="right badge badge-warning">To Improve</span>
                     @elseif($sub[$i][2]>=30)
                         <span class="right badge badge-danger">Poor</span>
                     @elseif($sub[$i][2]<30)
                               <span class="right badge badge-danger">Very Poor</span>

                     @endif 
                      </td>
                      <td>...</td>
                      <td>...</td>
                   
                    </tr>
                    <tr class="expandable-body d-none">
                      <td colspan="6">
                        <div class="p-0" style="display: none;">
                          <table class="table table-hover" style="margin:0px;width: 100%;">
                              <thead>
                               <tr style="background-color: #cb6666;color:#fff;font-style: normal;">
                                 <th>Skill Attribute</th>
                               
                                 <th>Final Score</th>
                                 <th>Grade</th>
                                 <th>Highest Score</th>
                                 <th>Average Score</th>
                               </tr>
                             </thead>
                             <tbody style="background-color: #eecccc;color:#000" >  
                             @for($m=0;$m<$count;$m++)
                             @if($sub[$i][3]==$data[$m][4])
                              <tr>
                               <td>{{$data[$m][5]}}</td>
                              
                               <td>{{$data[$m][3]}}%</td>
                               <td>
                                  @if($data[$m][3]>=90)
                       <span class="right badge badge-success">Outstanding</span>
                     @elseif($data[$m][3]>=80)
                         <span class="right badge badge-success">Excellent</span>

                     @elseif($data[$m][3]>=70)
                          <span class="right badge badge-primary">Very Good</span>
                     @elseif($data[$m][3]>=60)
                           <span class="right badge badge-primary">Good</span>
                     @elseif($data[$m][3]>=50)
                           <span class="right badge badge-warning">Average</span>
                     @elseif($data[$m][3]>=40)
                           <span class="right badge badge-warning">To Improve</span>
                     @elseif($data[$m][3]>=30)
                         <span class="right badge badge-danger">Poor</span>
                     @elseif($data[$m][3]<30)
                               <span class="right badge badge-danger">Very Poor</span>

                     @endif 
                               </td>
                               <td>..</td>
                               <td>..</td>
                             </tr>
                             @endif
                             @endfor
                   
                             </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>

                    @endfor
                   
                     
                   
                             </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>

                  
                     
                   
                  </tbody>
                </table>




                
              </div>
              
           
        </div>
      </div>


           
                  <!-- /.tab-pane -->
                 
                      


























                   

                   </div>
                  <!-- /.tab-pane  -->
                 

                 
                  <!-- /.tab-pane -->
                 
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>

<script>
  $('#cmd').click(function() {
  var options = {
  };
  var pdf = new jsPDF('p', 'pt', 'a4');
  pdf.addHTML($("#tab_2"), 15, 15, options, function() {
    pdf.save('PageContent.pdf');
  });
});

</script>
@endsection