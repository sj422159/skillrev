@extends('nontechmanager/infrastructure/layout')
@section('title','Cafeteria Items')
@section('Dashboard_select','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">CAFETERIA ITEM</h3>
            </div>
           
            <form action="{{url('nontech/manager/infrastructure/cafeteria/item/savedata')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2"> 

                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                       <label>Class</label>
          
                        <select class="form-control" name="class" required id="topbranch">
                            <option value="">Select</option>
                            @foreach($ctypes as $list)
                              @if($data[0]->cafetype==$list->id)
                                <option value="{{$list->id}}" selected>{{$list->ctype}}</option>
                              @else
                               <option value="{{$list->id}}">{{$list->ctype}}</option>
                              @endif
                             @endforeach
                        </select>
                    
        </div>
        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
            <label>Section</label>
              <select class="form-control" id="mainbranch" aria-required="true"aria-invalid="false"name="section" data-val="{{$data[0]->cafetype}}"  data-room="{{$data[0]->cafeid}}" required>
                           <option value="">Select</option>
                         </select>
            
        </div>
        </div>
         <div class="form-row mt-2"> 
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
       
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">ITEM Code</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Items Name" name="itemcode" value="{{$data[0]->itemcode}}">
                    </div>
                </div>
                 <div class="form-row mt-2"> 

                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">ITEM No</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Items Name" name="itemno" value="{{$data[0]->itemno}}">
                    </div>
                    <input type="hidden" name="id" value="{{$data[0]->id}}">
                </div>
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
    jQuery('#topbranch').change(function (){
        let classid=document.getElementById("topbranch").value;
         $('#mainbranch').html('');
        jQuery.ajax({
            url:'{{url("nontech/manager/infrastructure/cafeteria/getname")}}',
            type:'get',
            data:{cid:classid},
            success:function(data){
               $.each(data, function(key,section)
                 {   
                       
                          $('#mainbranch').prop('disabled', false).append('<option value="'+section.id+'">'+section.cafeteria+'</option>');  
                        
                });
            }
        });
    });

            

            var hid=$('#mainbranch').attr('data-val');
            var rid=$('#mainbranch').attr('data-room');
            $.ajax({
              url:'{{url("nontech/manager/infrastructure/cafeteria/getname")}}',
              type:'GET',
              data:{cid:hid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                       if(rid==section.id){
                        $('#mainbranch').prop('disabled', false).append('<option selected value="'+section.id+'">'+section.cafeteria+'</option>');
                        }else{
                          $('#mainbranch').prop('disabled', false).append('<option value="'+section.id+'">'+section.cafeteria+'</option>');  
                        }
                   
                });
              }
          });



            });

</script>
@endsection