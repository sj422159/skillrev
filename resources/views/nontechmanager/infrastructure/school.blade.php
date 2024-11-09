@extends('nontechmanager/infrastructure/layout')
@section('title','School Infrastructure')
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
<form action="{{url('nontech/manager/infrastructure/school/info/byfilter')}}" method="post">
    @csrf
     <div class="form-row mt-2">
                     <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                       <label>CLASS :</label>
                        <select class="form-control" name="class" required id="topbranch">
                            <option value="">Select</option>
                            @foreach($class as $list)
                             <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endforeach
                        </select>
                     </div>
                   
                    <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                      <label>SECTION :</label>
                         <select class="form-control" name="section" required id="mainbranch" >
                           <option value="">Select</option>
                         </select>
                     </div>
                     

        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Items</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="item" id="items" onchange="yesnoChecked(this)">
                <option value="">Select</option>
                @foreach($items as $list)
                     <option value="{{$list->id}}">{{$list->infraitem}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Action</label><br>
            @if(count($data)>0)
            <a href="{{url('nontech/manager/infrastructure/school/info/export')}}/{{$mid}}"><button type="button"class="btn btn-success">Export</button></a>
            @else
            <a href="#"><button type="button"class="btn btn-success disabled">Export</button></a>
            @endif
        </div>
      
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Related Info
            </button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>
<div class="card">
    <div class="card-header">
        <a href="{{url('nontech/manager/infrastructure/add/schoolitems')}}">
        <button type="button" class="btn btn-success">
         Add Items
        </button> 
        </a>
    </div>
    <!-- /.card-header -->
  
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
      <thead>
               
                <tr>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Items</th>
                    <th>Item No</th>  
                    <th>Item Desc</th>    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $list)
            <tr>
                  <td>{{$list->categories}}</td>
                  <td>{{$list->section}}</td>
                  <td>{{$list->infraitem}}</td>
                  <td>{{$list->itemno}}</td>
                  <td>{{$list->itemdesc}}</td>
                  <td><a href="{{url('nontech/manager/infrastructure/school/edit/items')}}/{{$list->id}}" class="btn btn-primary btn-sm">Edit</a></td>
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
    jQuery('#topbranch').change(function (){
        let classid=document.getElementById("topbranch").value;
        jQuery.ajax({
            url:'{{url("nontech/manager/view/sections")}}',
            type:'get',
            data:{classid:classid},
            success:function(result){
            jQuery('#mainbranch').html(result)
            }
        });
    });

});

 

</script>

@endsection