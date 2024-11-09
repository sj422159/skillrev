@extends('nontechmanager/infrastructure/layout')
@section('title','Others Items')
@section('Dashboard_select','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">OTHER ITEM</h3>
            </div>
           
            <form action="{{url('nontech/manager/infrastructure/other/item/savedata')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2"> 

                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
            <label>Room</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="room" id="category" required>
                <option value="">Select</option>
                @foreach($rooms as $list)
                 @if($data[0]->roomid==$list->id)
                    <option value="{{$list->id}}" selected>{{$list->roomname}}</option>
                 @else
                     <option value="{{$list->id}}">{{$list->roomname}}</option>
                     @endif
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
            <label>Items</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="items" id="items" required>
                <option value="">Select</option>
                @foreach($items as $list)
                     
                     @if($data[0]->itemid==$list->id)
                     <option selected value="{{$list->id}}">{{$list->infraitem}}</option>
                     @else
                        <option value="{{$list->id}}">{{$list->infraitem}}</option>
                     @endif
                @endforeach 
            </select>
        </div>
            
        </div>
         <div class="form-row mt-2"> 
        
       
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">ITEM Code</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Items Name" name="itemcode" value="{{$data[0]->itemcode}}">
                    </div>
                
               

                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">ITEM No</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Items Name" name="itemno" value="{{$data[0]->itemno}}">
                    </div>
                    </div>
                    <input type="hidden" name="id" value="{{$data[0]->id}}">
               
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
            

            var hid=$('#domain').attr('data-val');
            var rid=$('#domain').attr('data-room');
            $.ajax({
              url:'{{url("nontech/manager/infrastructure/hostels/getroom")}}',
              type:'GET',
              data:{cid:hid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                       if(rid==section.id){
                        $('#domain').prop('disabled', false).append('<option selected value="'+section.id+'">'+section.roomname+'</option>');
                        }else{
                          $('#domain').prop('disabled', false).append('<option value="'+section.id+'">'+section.roomname+'</option>');  
                        }
                   
                });
              }
          });



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