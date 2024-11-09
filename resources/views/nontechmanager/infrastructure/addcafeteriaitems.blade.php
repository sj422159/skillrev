@extends('nontechmanager/infrastructure/layout')
@section('title','Add Cafeteria Items')
@section('Dashboard_select','active')
@section('container')

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="form-row mt-4"> 
                <a href="{{url('infrastructure/items.xlsx')}}">
                <button type="button" class="btn btn-success">
                 Download Sample Excel Sheet
                </button> 
               </a>
               <br>
              
               
        <form action="{{url('nontech/manager/infrastructure/cafeteria/uploaditems')}}" enctype="multipart/form-data" method="post" class="col-12"> @csrf
               
            <div class="form-row mt-4">
            
      <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Cafeteria Type</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="hostel" id="category">
                <option value="">Select</option>
                @foreach($ctypes as $list)
                     <option value="{{$list->id}}">{{$list->ctype}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Cafeteria</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false" name="roomno">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Items</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="items" id="items" required>
                <option value="">Select</option>
                @foreach($items as $list)
                     <option value="{{$list->id}}">{{$list->infraitem}}</option>
                @endforeach 
            </select>
        </div>
    </div>
   <!--  <div class="form-row mt-4">
        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Required Items</label>
            <input type="text" name="" value="0" disabled id="itemscount" class="form-control">
        </div>

         <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Allocated Items</label>
            <input type="text" name="" value="0" disabled id="itemsallocated" class="form-control">
        </div>

        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Assigned Students</label>
            <input type="text" name="" value="0" disabled id="itemsassigned" class="form-control">
        </div>
      

             
       
       

        </div> -->


               


                    <div class="input-group col-md-8" style="margin-top:20px !important;">
                      <div class="custom-file">
                        <input type="file" name='excel' id="file" required="true">
                      </div>
                <button type="submit" class="btn btn-success" id="submit">
                 Upload Items
                </button>
                </div> 
        </form>
               
        </div>

              
               
              </div>
            </div>
          </div>
        </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


jQuery(document).ready(function(){

       

           jQuery('#category').change(function (){
            
             
           let cid=jQuery(this).val();
        
                        
           $('#domain').html('');
            $.ajax({
              url:'{{url("nontech/manager/infrastructure/cafeteria/getname")}}',
              type:'GET',
              data:{cid:cid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   
                        $('#domain').prop('disabled', false).append('<option value="'+section.id+'">'+section.cafeteria+'</option>');
                   
                });
              }
          });
         
       

});


});
 

</script>


@endsection
