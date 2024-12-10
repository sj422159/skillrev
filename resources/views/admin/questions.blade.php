@extends('admin/layout')
@section('title','Questions')
@section('Dashboard_select','active')
@section('container')
<style type="text/css">
    td,a,button{
        font-size: 12px;
        word-wrap: break-word !important;
    }
    th{
        font-size: 14px;

    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
@if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
<form action="{{url('admin/questions/bysa')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="mainbranch">
                <option value="">Select</option>
                @foreach($categories as $list)
                            @if($categoryid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->categories}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Subject</label>
                            <select name="domain" class="form-control" required="true" data-val="{{$domainid}}" id="subbranch">
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Module</label>
                            <select name="skillset" class="form-control" required="true" data-val="{{$skillsetid}}" id="subskillset">
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Chapter</label>
                            <select name="skillattribute" class="form-control" required="true" data-val="{{$skillattributeid}}" id="skillattribute" onchange="yesnoChecked(this)">
                            </select>
                    </div>
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Skill  Attribute Related Questions
            </button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>
<div class="card">
    <div class="card-header">
        <a href="{{url('admin/questions/add')}}">
        <button type="button" class="btn btn-success">
        Bulk Upload Questions
        </button> 
        </a>
    </div>
    <!-- /.card-header -->
  
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
      <thead>
               
                <tr>
                    <th>Chapter</th>
                    <th>Question Type</th>
                    <th style="width:35% !important;">Question</th>
                    <th>Checking</th>       
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $list)
            <tr>
           
             <td>{{$list->skillattribute}}</td>
             <td>{{$list->qtype}}</td>
            <td>{{$list->qtext}}</td>
            <td>
              @if($list->qstatus=="0")
              <button class="btn btn-secondary btn-sm">Incomplete</button>
             @else
               <button class="btn btn-success btn-sm">Completed</button>
             @endif
         </td>
         <td>
            <a href="{{url('admin/question/edit')}}/{{$list->id}}"><button type="button" class="btn btn-success btn-sm">Edit</button>
            </a>

             <a href="{{url('admin/question/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger btn-sm">Delete</button>
             </a>
              <a href="{{url('admin/question/view')}}/{{$list->id}}"><button type="button" class="btn btn-secondary btn-sm">View</button>
             </a>
            </td>
          </tr>
          @endforeach
            </tbody>
       </table>
              </div>

</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
    <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


    
 <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
    <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>




<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }

</script>
<script type="text/javascript"> 
  $(document).ready(function() {
   $('#example1').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

jQuery(document).ready(function(){

           jQuery('#mainbranch').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getdomain")}}',
              type:'get',
              data:'cid='+cid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#domain').html(result)
              }
             });
           });

            jQuery('#domain').change(function (){
            var sid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getskillset")}}',
              type:'post',
              data:'sid='+sid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillset').html(result)
              }
             });
           });



            jQuery('#skillset').change(function (){
            var gid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getskillattribute")}}',
              type:'post',
              data:'gid='+gid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillattribute').html(result)
              }
             });
           });

});


 



 $(document).ready(function(){
            var state = $('#mainbranch').val();
            var subbranch=$('#subbranch').attr('data-val');

           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/domain/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.domain+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                   }
                });
               subskillset();
               skillattribute();
              }
          });
          });

         function subskillset(){
                   var state = $('#subbranch').val();
                   var subskillset=$('#subskillset').attr('data-val');
                  
           $('#subskillset').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/skillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillset+'</option>');
                   }else{
                        $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                   }
                });
              }
          });
          };

        function skillattribute(){
            var state = $('#subskillset').attr('data-val');
            var subskillset=$('#skillattribute').attr('data-val');    
           $('#skillattribute').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/getskillattribute/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillattribute+'</option>');
                   }else{
                        $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillattribute+'</option>');
                   }
                });
              }
          });
          };
       $(document).ready(function(){
        $('#mainbranch').change(function(){

           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/skillattribute/domain/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                 $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                });
              }
          }); 
        });
      });
    $(document).ready(function(){
        $('#subbranch').change(function(){
           var state = $('#subbranch').val();
           $('#subskillset').html('');
            $.ajax({
             url:'{{url("admin/skillattribute/skillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              { 
                $('#subskillset').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                });
              }
          });
        });
    });

    $(document).ready(function(){
        $('#subskillset').change(function(){
           var state = $('#subskillset').val();
           $('#skillattribute').html('');
            $.ajax({
             url:'{{url("admin/skillattribute/getskillattribute/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              { 
                $('#skillattribute').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillattribute+'</option>');
                });
              }
          });
        });
      });

</script>

@endsection