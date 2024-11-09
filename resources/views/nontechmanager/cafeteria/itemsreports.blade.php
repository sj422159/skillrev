@extends('nontechmanager/cafeteria/layout')
@section('title','Repair Reports')
@section('Profile','active')
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
<form action="{{url('nontech/manager/cafeteria/items/reports/byfilter')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Caterers</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="hostel" id="category" >
                <option value="">Select</option>
                @foreach($hostels as $list)
                     <option value="{{$list->id}}">{{$list->fname}}{{$list->lname}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Food Category</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category" onchange="yesnoChecked(this)">
                <option value="">Select</option>
                @foreach($categories as $list)
                     <option value="{{$list->id}}">{{$list->foodcategory}}</option>
                @endforeach 
            </select>
        </div>
       
      
      
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Related Info
            </button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>
<div class="card">
    
    <!-- /.card-header -->
  
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
      <thead>
               
                <tr>
                    <th>Caterer</th>
                    <th>Food Category</th>
                    <th>Food Item</th>
                    <th>Pricetype</th>
                    <th>Price</th>
                    <th>Caterer Price</th>  
                    
                </tr>
            </thead>
            <tbody>
                @foreach($data as $list)
            <tr>
                <td>{{$list->fname}}{{$list->lname}}</td>
                <td>{{$list->foodcategory}}</td>  
                <td>{{$list->fooditems}}</td>
                <td>{{$list->ptype}}</td>
                <td>{{$list->price}}</td>
                <td>{{$list->catererprice}}</td>
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

           jQuery('#category').change(function (){
            
             
           let cid=jQuery(this).val();
        
                        
           $('#domain').html('');
            $.ajax({
              url:'{{url("nontech/manager/infrastructure/hostels/getroom")}}',
              type:'GET',
              data:{cid:cid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   
                        $('#domain').prop('disabled', false).append('<option value="'+section.id+'">'+section.roomname+'</option>');
                   
                });
              }
          });
         
           });         

});


 

</script>

@endsection