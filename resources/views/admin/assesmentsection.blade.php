@extends('admin/layout')
@section('title','Assesment Section')
@section('Dashboard_select','active')
@section('container')
<div class="row">
          <div class="col-12">
            <div class="card" style="padding:10px !important; ">
              <form  id="Form1" action="{{url('admin/assesments')}}" method="post">
              @csrf
              </form>
              <form  id="Form2" action="{{url('admin/createsection')}}" method="post">
              @csrf
              </form>
              <div class="card-body" style="padding:10px !important; overflow: hidden;">
                    <div class="form-row">
                      <div class="col-12 col-sm-1 mt-4 mt-sm-0">
                    <button type="submit" class="btn btn-primary" form="Form2">Add Section</button>
                    </div>
                    </div>
                  
                    <div class="form-row mt-4">

                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label for="branchname">Section Name :</label>
                    <input type="text" class="form-control" placeholder="Enter" name="sectionname" form="Form2" required="true">
                    </div>

                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Standard :</label>
                    
                    <select class="form-control" style="width: 100%;" aria-required="true" aria-invalid="false" name="skillgroup" id="country" form="Form2" required="true">
                    @foreach($categories as $list)
                    <option value="{{$list->id}}">{{$list->categories}}</option>
                    @endforeach  
                    </select>
                    </div>
                    
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Subject :</label>
                    <select class="form-control" style="width: 100%;" id="state" aria-required="true" aria-invalid="false" name="skillset[]" form="Form2" required="true">
                    @foreach($domains as $list)
                    <option value="{{$list->id}}">{{$list->domain}}</option>
                    @endforeach 
                    </select>
                    </div>

                   
                    @if($trainingtype=="1")
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Module :</label>
                    <select class="form-control" style="width:100%;" id="city" aria-required="true" aria-invalid="false" name="section[]"  form="Form2" required="true">
                    @foreach($skillsets as $list)
                    <option value="{{$list->id}}">{{$list->skillset}}</option>
                    @endforeach 
                    </select>
                    </div>

                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Chapter :</label>
                    <select class="form-control" style="width:100%;" id="town" aria-required="true" aria-invalid="false" name="chapter" form="Form2" required="true">
                    @foreach($skillattributes as $list)
                    <option value="{{$list->id}}">{{$list->skillattribute}}</option>
                    @endforeach 
                    </select>
                    </div>
                    <input type="hidden" name="trainingtype" value="1" form="Form2"><!-- 1 means one chapter to select-->
                    @else
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Module :</label>
                    <select class="form-control" style="width:100%;" id="city" multiple aria-required="true" aria-invalid="false" name="section[]"  form="Form2" required="true">
                    @foreach($skillsets as $list)
                    <option value="{{$list->id}}">{{$list->skillset}}</option>
                    @endforeach 
                    </select>
                    </div>
                    <input type="hidden" name="trainingtype" value="2" form="Form2"><!-- 2 mean multiple chapters select-->
                    @endif
                     
                  </div>

                  
              
                    
              
               

              <input type="hidden" name="id" value="{{$data[0]->id}}" form="Form2">
              <input type="hidden" name="id" value="{{$data[0]->id}}" form="Form1">
               
            
              </div>

               <table id="simpleTable1" class="table table-bordered table-striped">
                 <thead>
                    <br>
                    <tr>
                       <th>Section Name</th>
                       <th>Questions</th>
                       <th>Pass Percentage</th>
                       <th>Duration</th>
                       <th>order</th>
                       <th>Action</th>
                    </tr>
                    @foreach($sections as $list)
                     <tr>
                       <td>{{$list->sectionname}}</td>
                       <td>{{$list->totalquestions}}</td> 
                       <td>{{$list->sectionpass}}</td>
                       <td>{{$list->sectionduration}}</td>
                       <td><input type="number" name="order[]" value="{{$list->ordering}}" form="Form1">
                        <input type="hidden" name="sectionid[]" value="{{$list->id}}" form="Form1"></td>
                       
                  
                       <td><a href="{{url('admin/createsection')}}/{{$list->id}}">
                        <button type="button" class="btn btn-success">Edit</button>
                            </a>
                          <a href="{{url('admin/assesment/section/delete')}}/{{$list->id}}">
                            <button type="button" class="btn btn-danger">Delete</button>
                          </a>
                       </td>
                     </tr>
                    @endforeach
                    </thead>
                    <tbody>
                     </tbody>
                   </table>
              <div class="col-4 mt-4">
              <button type="submit" class="btn btn-success" style="margin-bottom: 20px !important;margin-left: 10px !important;"form="Form1">Submit</button></div>
              <!-- /.card-body -->
            </div>
          </form>
          
            <!-- /.card -->
          </div>
        </div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

// jQuery(document).ready(function(){

//           jQuery('#country').change(function (){
//              let cid=jQuery(this).val();
//              jQuery.ajax({
//               url:'{{url("admin/skillattribute/domain")}}',
//               type:'post',
//               data:'cid='+cid+
//               '&_token={{csrf_token()}}',
//               success:function(result){
//                 jQuery('#state').html(result)
//               }
//              });
//           });

//           jQuery('#state').change(function (){
//             var sid=jQuery(this).val();
//             var str=String(sid);
//             //str=1;
//              // alert(str);
//              jQuery.ajax({
//               url:'{{url("admin/skillattribute/skillset")}}',
//               type:'post',
//               data:'sid='+str+
//               '&_token={{csrf_token()}}',
//               success:function(result){
//                 jQuery('#city').html(result)
//               }
//              });
//           });

//           jQuery('#city').change(function (){
//             var tid=jQuery(this).val();
//             var ttr=String(tid);
//              jQuery.ajax({
//               url:'{{url("admin/skillattribute/getskillattribute")}}',
//               type:'post',
//               data:'tid='+ttr+
//               '&_token={{csrf_token()}}',
//               success:function(result){
//                 jQuery('#town').html(result)
//               }
//              });
//           });

// });


 

</script>


@endsection
